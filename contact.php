<?php
// contact.php (EL AGRESTE) — listo para producción
// Requiere en el <form>: input honeypot name="website", hidden name="tt_start",
// y el widget de Turnstile (inyecta cf-turnstile-response).
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

// ========= Config =========
$TURNSTILE_SECRET   = '0x4AAAAAABuVRRqXalG9_4q41H7ep662o7g'; // <- tu secret real
$RECIPIENTS         = 'contacto@agrestepatagonia.com, agrestecorreo@gmail.com';
$SUBJECT_PREFIX     = 'Mensaje de';
$MIN_SECONDS        = 4;    // time-trap mínimo
$RATE_LIMIT_SECONDS = 30;   // 1 envío por IP cada 30 s
$FROM_DOMAIN_MAIL   = 'no-reply@agrestepatagonia.com'; // mejora entregabilidad (SPF/DKIM)

// ========= Helpers =========
function fail(int $code, string $msg) {
  http_response_code($code);
  echo json_encode(['ok' => false, 'error' => $msg], JSON_UNESCAPED_UNICODE);
  exit;
}

function ts_verify(string $secret, string $token, string $ip): bool {
  $payload = http_build_query([
    'secret'   => $secret,
    'response' => $token,
    'remoteip' => $ip,
  ]);

  // Usar cURL si está disponible
  if (function_exists('curl_init')) {
    $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT        => 10,
      CURLOPT_POST           => true,
      CURLOPT_POSTFIELDS     => $payload,
    ]);
    $resp = curl_exec($ch);
    curl_close($ch);
  } else {
    // Fallback sin cURL
    $opts = [
      'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => $payload,
        'timeout' => 10,
      ]
    ];
    $resp = @file_get_contents('https://challenges.cloudflare.com/turnstile/v0/siteverify', false, stream_context_create($opts));
  }

  if ($resp === false) return false;
  $data = json_decode($resp, true);
  return is_array($data) && !empty($data['success']);
}

// ========= 1) Solo POST =========
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
  fail(403, 'Hubo un problema con su envío, intente de nuevo por favor. | There was a problem with your submission, please try again.');
}

$ip  = $_SERVER['REMOTE_ADDR'] ?? '';
$now = time();

// ========= 2) Rate limit por IP =========
$ipKey = sys_get_temp_dir() . '/agreste_form_rl_' . preg_replace('/[^0-9a-f\.:]/i', '_', $ip) . '.txt';
$last = @file_get_contents($ipKey);
if ($last !== false && ($now - (int)$last) < $RATE_LIMIT_SECONDS) {
  fail(429, 'Demasiados intentos. Esperá un momento. | Too many attempts. Please wait a moment.');
}
@file_put_contents($ipKey, (string)$now, LOCK_EX);

// ========= 3) Honeypot =========
if (!empty($_POST['website'] ?? '')) {
  fail(400, 'Verificación fallida. | Verification failed.');
}

// ========= 4) Time-trap =========
$tt = isset($_POST['tt_start']) ? (int)$_POST['tt_start'] : 0;
if ($tt <= 0 || ($now - $tt) < $MIN_SECONDS) {
  fail(400, 'Enviaste demasiado rápido. | You sent too quickly.');
}

// ========= 5) Turnstile (server-side) =========
$tsToken = $_POST['cf-turnstile-response'] ?? '';
if ($tsToken === '') {
  fail(400, 'Falta la verificación. | Verification missing.');
}
if (!ts_verify($TURNSTILE_SECRET, $tsToken, $ip)) {
  fail(400, 'Verificación fallida. | Verification failed.');
}

// ========= 6) Campos y validación =========
$first   = trim((string)($_POST['name']   ?? ''));
$last    = trim((string)($_POST['name-2'] ?? ''));
$fullname = preg_replace("/[\r\n]+/", ' ', trim($first . ' ' . $last));

$phone         = trim((string)($_POST['phone']  ?? ''));
$emailRaw      = trim((string)($_POST['email']  ?? ''));
$email         = filter_var($emailRaw, FILTER_VALIDATE_EMAIL);
$subject_input = trim((string)($_POST['subject']?? ''));
if (mb_strlen($subject_input) > 150) $subject_input = mb_substr($subject_input, 0, 150);
$message       = trim((string)($_POST['message'] ?? ''));

// Requeridos (mantengo phone obligatorio como en tu script original)
if ($first === '' || $last === '' || $phone === '' || $message === '' || !$email) {
  fail(400, 'Hubo un problema con su envío; faltan campos o el correo es inválido. | Some fields are missing or the email is invalid.');
}

// ========= 7) Componer email =========
$subject = "{$SUBJECT_PREFIX} {$fullname}: {$subject_input}";
$body  = "Nombre completo: {$fullname}\n";
$body .= "Email: {$email}\n";
$body .= "Asunto: {$subject_input}\n";
$body .= "Teléfono: {$phone}\n";
$body .= "IP: {$ip}\n\n";
$body .= "Mensaje:\n{$message}\n";

// Cabeceras (From fijo del dominio para evitar bloqueos)
$headers  = "From: EL AGRESTE <{$FROM_DOMAIN_MAIL}>\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// ========= 8) Enviar =========
$sent = @mail($RECIPIENTS, $subject, $body, $headers);
if (!$sent) {
  fail(500, 'Algo salió mal y no se pudo enviar el mensaje. | Something went wrong and we could not send your message.');
}

// ========= 9) OK =========
http_response_code(200);
echo json_encode(['ok' => true, 'message' => 'Gracias, su mensaje ha sido enviado. | Thank you! Your message has been sent.'], JSON_UNESCAPED_UNICODE);

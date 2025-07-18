<?php
// contact.php

// 1. Sólo procesar peticiones POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    exit("Hubo un problema con su envío, intente de nuevo por favor. | There was a problem with your submission, please try again.");
}

// 2. Obtener y sanear los campos del formulario
$first   = strip_tags(trim($_POST["name"]     ?? ''));
$last    = strip_tags(trim($_POST["name-2"]   ?? ''));
$fullname = str_replace(["\r","\n"], [" "," "], "$first $last");

$phone         = strip_tags(trim($_POST["phone"]   ?? ''));
$email         = filter_var(trim($_POST["email"]  ?? ''), FILTER_SANITIZE_EMAIL);
$subject_input = strip_tags(trim($_POST["subject"] ?? ''));
$message       = trim($_POST["message"] ?? '');

// 3. Validación básica
if (
    empty($first) ||
    empty($last)  ||
    empty($phone) ||
    empty($message) ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    http_response_code(400);
    exit("Hubo un problema con su envío, algunos campos faltan o el correo es inválido. | There was a problem with your submission—some fields are missing or the email is invalid.");
}

// 4. Configurar destinatario y asunto del email
$recipient = "contacto@agrestepatagonia.com";
$subject   = "Mensaje de $fullname: $subject_input";

// 5. Construir el cuerpo del correo
$email_content  = "Nombre completo: $fullname\n";
$email_content .= "Email: $email\n";
$email_content .= "Asunto: $subject_input\n";
$email_content .= "Teléfono: $phone\n\n";
$email_content .= "Mensaje:\n$message\n";

// 6. Cabeceras
$email_headers  = "From: $fullname <$email>\r\n";
$email_headers .= "Reply-To: $email\r\n";

// 7. Enviar el correo
if (mail($recipient, $subject, $email_content, $email_headers)) {
    http_response_code(200);
    echo "Gracias, su mensaje ha sido enviado. | Thank you! Your message has been sent.";
} else {
    http_response_code(500);
    echo "Algo salió mal y no se pudo enviar el mensaje. | Something went wrong and we couldn't send your message.";
}

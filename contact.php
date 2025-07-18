<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $fullname = strip_tags(trim($_POST["fullname"]));
		$fullname = str_replace(array("\r","\n"),array(" "," "),$fullname);
        $phone = strip_tags(trim($_POST["phone"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($fullname) OR empty($phone) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Hubo un problema con su envío, intente de nuevo por favor. | There was a problem with your submission, please try again.";
            exit;
        }

        // Update this to your desired email address.
        $recipient = "contacto@agrestepatagonia.com";
		$subject = "Message from $fullname";

        // Email content.
        $email_content = "Nombre|Name: $fullname\n";
        $email_content .= "Correo|Email: $email\n\n";
        $email_content .= "Asunto|Subject: $subject\n\n";
        $email_content .= "Telefono|Phone: $phone\n\n";
        $email_content .= "Mensaje|Message: $message\n";

        // Email headers.
        $email_headers = "From: $fullname <$email>\r\nReply-to: <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Gracias su mensaje ha sido enviado |  Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Algo salió mal y no se pudo enviar el mensaje | Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Hubo un problema con su envío, intente de nuevo por favor. | There was a problem with your submission, please try again.";
    }

?>
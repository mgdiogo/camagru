<?php

function sendEmailVerification($username, $recipient, $verificationLink): void { 
	$to = $recipient;
	$subject = "Camagru - Verify your email";
	$message = '<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <div>
            <p>' . htmlspecialchars($username) . ', thank you for registering to Camagru</p>
            <p>Please click the following link to verify your account: 
               <a href="http://localhost:8080/verify?token=' . $verificationLink . '">Verify account</a>
            </p>
        </div>
    </body>
    </html>';

    // Set headers to send HTML email
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: camagru.group@gmail.com\r\n";

	try {
		mail($to, $subject, $message, $headers);
	} catch (Exception $e) {
		echo "Error sending email: " . $e->getMessage();
	}
}

function sendChangeEmail($username, $recipient, $verificationLink): void {
	$to = $recipient;
	$subject = "Camagru - Verify email update";
	$message = '<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <div>
            <p> ' . htmlspecialchars($username) . ', please click the following link to update your email address: 
               <a href="http://localhost:8080/changeInfo?token=' . $verificationLink . '">Update email address</a>
            </p>
        </div>
    </body>
    </html>';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: camagru.group@gmail.com\r\n";

	try {
		mail($to, $subject, $message, $headers);
	} catch (Exception $e) {
		echo "Error sending change email: " . $e->getMessage();
	}
}

function sendChangePassword($username, $recipient, $verificationLink){
	$to = $recipient;
	$subject = "Camagru - Verify password update";
	$message = '<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <div>
            <p> ' . htmlspecialchars($username) . ', please click the following link to update your password: 
               <a href="http://localhost:8080/changePassword?token=' . $verificationLink . '">Update password</a>
            </p>
        </div>
    </body>
    </html>';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: camagru.group@gmail.com\r\n";

	try {
		mail($to, $subject, $message, $headers);
	} catch (Exception $e) {
		echo "Error sending change password email: " . $e->getMessage();
	}
}
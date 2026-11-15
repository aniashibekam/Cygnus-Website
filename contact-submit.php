
<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed.");
}

// Spam protection
if (!empty($_POST["website"])) {
    exit("Invalid submission.");
}

// Validate inputs
$name = trim($_POST["name"] ?? "");

$email = filter_var(
    trim($_POST["email"] ?? ""),
    FILTER_VALIDATE_EMAIL
);

$subject = trim($_POST["subject"] ?? "");
$message = trim($_POST["message"] ?? "");

if (
    $name === "" ||
    strlen($name) > 150 ||
    !$email ||
    $subject === "" ||
    strlen($subject) > 200 ||
    $message === "" ||
    strlen($message) > 5000
) {
    header("Location: contact.html?status=invalid#contact");
    exit;
}

// Email settings
$to = "info@cygnusx.io";
$mail_subject = "New Cygnus Website Enquiry: " . $subject;

$body = "A new enquiry has been submitted through the Cygnus website.\n\n";
$body .= "Full Name: " . $name . "\n";
$body .= "Email Address: " . $email . "\n";
$body .= "Subject: " . $subject . "\n\n";
$body .= "Message:\n" . $message . "\n";

$headers = [];
$headers[] = "From: Cygnus Website <info@cygnusx.io>";
$headers[] = "Reply-To: " . $email;
$headers[] = "Content-Type: text/plain; charset=UTF-8";

$sent = mail(
    $to,
    $mail_subject,
    $body,
    implode("\r\n", $headers)
);

if ($sent) {
    header("Location: contact.html?status=success#contact");
} else {
    header("Location: contact.html?status=error#contact");
}

exit;


<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed.");
}

// Basic spam protection
if (!empty($_POST["website"])) {
    exit("Invalid submission.");
}

// Read and validate inputs
$email = filter_var(
    trim($_POST["email"] ?? ""),
    FILTER_VALIDATE_EMAIL
);

$message = trim($_POST["message"] ?? "");

if (!$email || $message === "" || strlen($message) > 5000) {
    header("Location: starvia.html?status=invalid#contact");
    exit;
}

// Email settings
$to = "starvia@cygnusx.io";
$subject = "New Starvia Website Enquiry";

$body = "A new enquiry has been submitted through the Starvia website.\n\n";
$body .= "Sender Email: " . $email . "\n\n";
$body .= "Message:\n" . $message . "\n";

$headers = [];
$headers[] = "From: Starvia Website <starvia@cygnusx.io>";
$headers[] = "Reply-To: " . $email;
$headers[] = "Content-Type: text/plain; charset=UTF-8";

$sent = mail($to, $subject, $body, implode("\r\n", $headers));

if ($sent) {
    header("Location: starvia.html?status=success#contact");
} else {
    header("Location: starvia.html?status=error#contact");
}

exit;

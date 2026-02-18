<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	echo json_encode([
		"ok" => false,
		"message" => "Ungültige Anfrage"
	]);
	exit;
}

// Honeypot zaštita
if (!empty($_POST['website'])) {
	echo json_encode([
		"ok" => true,
		"message" => "Kommentar erfolgreich gesendet!"
	]);
	exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
	echo json_encode([
		"ok" => false,
		"message" => "Bitte alle Felder ausfüllen."
	]);
	exit;
}

// Ovdje kasnije može DB / mail
echo json_encode([
	"ok" => true,
	"message" => "Kommentar erfolgreich gesendet!"
]);

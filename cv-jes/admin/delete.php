<?php
declare(strict_types=1);

require __DIR__ . '/../inc/config.php';

session_start();
if (empty($_SESSION['admin_ok'])) {
	header('Location: index.php');
	exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id > 0) {
	$stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
	$stmt->execute([':id' => $id]);
}

header('Location: index.php');
exit;

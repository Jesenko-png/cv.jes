<?php
declare(strict_types=1);

require __DIR__ . '/../inc/config.php';

// Simple password protection
$ADMIN_PASS = 'promijeni-ovo';

// login check
session_start();
if (isset($_POST['pass'])) {
	if (hash_equals($ADMIN_PASS, (string)$_POST['pass'])) {
		$_SESSION['admin_ok'] = true;
	} else {
		$error = 'Falsches Passwort';
	}
}
if (empty($_SESSION['admin_ok'])):
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Login</title></head>
<body style="font-family:Arial;padding:30px;">
	<h2>Admin Login</h2>
	<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
	<form method="post">
		<input type="password" name="pass" placeholder="Passwort" required>
		<button type="submit">Login</button>
	</form>
</body>
</html>
<?php exit; endif; ?>

<?php
// list comments
$stmt = $pdo->query("SELECT id, name, email, message, ip, created_at FROM comments ORDER BY id DESC LIMIT 200");
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Kommentare Admin</title>
	<style>
		body{font-family:Arial;padding:30px;}
		table{border-collapse:collapse;width:100%;}
		th,td{border:1px solid #ddd;padding:10px;vertical-align:top;}
		th{background:#f5f5f5;}
	</style>
</head>
<body>
	<h2>Kommentare (letzte 200)</h2>

	<table>
		<tr>
			<th>ID</th>
			<th>Datum</th>
			<th>Name / Email</th>
			<th>Kommentar</th>
			<th>IP</th>
			<th>Aktion</th>
		</tr>
		<?php foreach ($rows as $r): ?>
		<tr>
			<td><?= (int)$r['id'] ?></td>
			<td><?= htmlspecialchars((string)$r['created_at']) ?></td>
			<td>
				<strong><?= htmlspecialchars((string)$r['name']) ?></strong><br>
				<?= htmlspecialchars((string)$r['email']) ?>
			</td>
			<td><?= nl2br(htmlspecialchars((string)$r['message'])) ?></td>
			<td><?= htmlspecialchars((string)$r['ip']) ?></td>
			<td>
				<form method="post" action="delete.php" onsubmit="return confirm('Delete?');">
					<input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
					<button type="submit">Löschen</button>
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</body>
</html>

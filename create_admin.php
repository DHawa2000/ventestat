<?php
require_once "config/db.php";

$hash = password_hash("admin123", PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
$stmt->execute([$hash, "admin"]);

echo "Admin créé avec succès";
?>
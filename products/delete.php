<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/db.php";

// Vérification de l'ID (sécurité importante)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

header("Location: list.php");
exit;
?>
<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/db.php";

// Vérification ID (important)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list.php");
    exit;
}

$id = $_GET['id'];

// Récupérer produit
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

// Sécurité si produit introuvable
if (!$product) {
    header("Location: list.php");
    exit;
}

// Mise à jour
if (isset($_POST['update'])) {

    $stmt = $pdo->prepare("
        UPDATE products
        SET libelle=?, categorie=?, prix=?, stock=?
        WHERE id=?
    ");

    $stmt->execute([
        $_POST['libelle'],
        $_POST['categorie'],
        $_POST['prix'],
        $_POST['stock'],
        $id
    ]);

    header("Location: list.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>

<h2>Modifier produit</h2>

<form method="POST">

    <input name="libelle" value="<?= htmlspecialchars($product['libelle']) ?>"><br><br>

    <input name="categorie" value="<?= htmlspecialchars($product['categorie']) ?>"><br><br>

    <input name="prix" value="<?= $product['prix'] ?>"><br><br>

    <input name="stock" value="<?= $product['stock'] ?>"><br><br>

    <button type="submit" name="update">Modifier</button>

</form>

<?php include "../includes/footer.php"; ?>
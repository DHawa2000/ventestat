<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/db.php";

if (isset($_POST['save'])) {

    $libelle = $_POST['libelle'];
    $categorie = $_POST['categorie'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];

    $stmt = $pdo->prepare("
        INSERT INTO products (libelle, categorie, prix, stock)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([$libelle, $categorie, $prix, $stock]);

    header("Location: list.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>

<h2>Ajouter produit</h2>

<form method="POST">
    <input name="libelle" placeholder="Libellé" required><br><br>
    <input name="categorie" placeholder="Catégorie" required><br><br>
    <input name="prix" type="number" placeholder="Prix" required><br><br>
    <input name="stock" type="number" placeholder="Stock" required><br><br>

    <button type="submit" name="save">Enregistrer</button>
</form>

<?php include "../includes/footer.php"; ?>
<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/db.php";

$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>

<?php include "../includes/header.php"; ?>

<h2>Liste des produits</h2>

<a href="add.php" class="btn btn-success mb-3">+ Ajouter produit</a>

<table class="table table-bordered table-striped">

    <tr>
        <th>ID</th>
        <th>Libellé</th>
        <th>Catégorie</th>
        <th>Prix</th>
        <th>Stock</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($products as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['libelle']) ?></td>
            <td><?= htmlspecialchars($p['categorie']) ?></td>
            <td><?= $p['prix'] ?></td>
            <td><?= $p['stock'] ?></td>
            <td>
                <a class="btn btn-primary btn-sm" href="edit.php?id=<?= $p['id'] ?>">Modifier</a>

                <a class="btn btn-danger btn-sm"
                   href="delete.php?id=<?= $p['id'] ?>"
                   onclick="return confirm('Supprimer ce produit ?')">
                   Supprimer
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php include "../includes/footer.php"; ?>
<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/db.php";

$message = "";

// PRODUITS
$products = $pdo->query("SELECT * FROM products")->fetchAll();

// TRAITEMENT VENTE
if (isset($_POST['sell'])) {

    $product_id = $_POST['product_id'];
    $quantite = (int) $_POST['quantite'];

    if ($quantite <= 0) {
        $message = "Quantité invalide";
    } else {

        try {

            $pdo->beginTransaction();

            // produit
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();

            if (!$product) {
                throw new Exception("Produit introuvable");
            }

            if ($product['stock'] < $quantite) {
                throw new Exception("Stock insuffisant");
            }

            $total = $product['prix'] * $quantite;

            // vente
            $stmt = $pdo->prepare("
                INSERT INTO sales (product_id, quantite, total)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$product_id, $quantite, $total]);

            // stock
            $stmt = $pdo->prepare("
                UPDATE products
                SET stock = stock - ?
                WHERE id = ?
            ");
            $stmt->execute([$quantite, $product_id]);

            $pdo->commit();

            header("Location: add.php?success=1");
            exit;

        } catch (Exception $e) {
            $pdo->rollBack();
            $message = $e->getMessage();
        }
    }
}
?>

<?php include "../includes/header.php"; ?>

<h2>Nouvelle vente</h2>

<?php if (isset($_GET['success'])): ?>
    <div style="color:green;">Vente enregistrée avec succès</div>
<?php endif; ?>

<?php if ($message): ?>
    <div style="color:red;"><?= $message ?></div>
<?php endif; ?>

<form method="POST">

    <label>Produit</label>
    <select name="product_id" required>
        <?php foreach ($products as $p): ?>
            <option value="<?= $p['id'] ?>">
                <?= htmlspecialchars($p['libelle']) ?> (Stock: <?= $p['stock'] ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label>Quantité</label>
    <input type="number" name="quantite" min="1" required>

    <br><br>

    <button type="submit" name="sell">Valider vente</button>

</form>

<?php include "../includes/footer.php"; ?>
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

if (isset($_POST['sell'])) {

    $product_id = $_POST['product_id'];
    $quantite = (int) $_POST['quantite'];

    if ($quantite <= 0) {
        $message = "Quantité invalide";
    } else {

        try {

            $pdo->beginTransaction();

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

            $stmt = $pdo->prepare("
                INSERT INTO sales (product_id, quantite, total)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$product_id, $quantite, $total]);

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

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow border-0">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">🧾 Nouvelle vente</h4>
                </div>

                <div class="card-body">

                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success">
                            Vente enregistrée avec succès
                        </div>
                    <?php endif; ?>

                    <?php if ($message): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Produit</label>

                            <select name="product_id" class="form-select" required>
                                <option value="">-- Choisir un produit --</option>

                                <?php foreach ($products as $p): ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= htmlspecialchars($p['libelle']) ?> 
                                        (Stock: <?= $p['stock'] ?>)
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantité</label>

                            <input type="number"
                                   name="quantite"
                                   class="form-control"
                                   min="1"
                                   required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="sell" class="btn btn-success">
                                💰 Valider la vente
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>
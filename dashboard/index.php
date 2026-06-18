<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/db.php";

// CA TOTAL
$stmt = $pdo->query("
SELECT SUM(total) AS ca_total FROM sales
");
$ca = $stmt->fetch();
$caTotal = $ca['ca_total'] ?? 0;

// CA PAR CATEGORIE
$stmt = $pdo->query("
SELECT p.categorie,
       SUM(s.total) AS chiffre_affaires
FROM sales s
JOIN products p ON s.product_id = p.id
GROUP BY p.categorie
");
$caCategorie = $stmt->fetchAll();

// TOP PRODUITS
$stmt = $pdo->query("
SELECT p.libelle,
       SUM(s.quantite) AS total_vendu
FROM sales s
JOIN products p ON s.product_id = p.id
GROUP BY p.id
ORDER BY total_vendu DESC
LIMIT 5
");
$topProduits = $stmt->fetchAll();

// CA PAR MOIS
$stmt = $pdo->query("
SELECT DATE_FORMAT(sale_date,'%Y-%m') AS mois,
       SUM(total) AS ca
FROM sales
GROUP BY mois
ORDER BY mois
");
$caMois = $stmt->fetchAll();
?>

<?php include "../includes/header.php"; ?>

<h1>Tableau de bord</h1>

<!-- CA TOTAL -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-dark">
            <div class="card-body">
                <h5>CA Total</h5>
                <h2><?= number_format($caTotal,2) ?> FCFA</h2>
            </div>
        </div>
    </div>
</div>

<!-- CA CATEGORIE -->
<h3>CA par catégorie</h3>

<table class="table table-bordered">
<tr>
    <th>Catégorie</th>
    <th>CA</th>
</tr>

<?php foreach($caCategorie as $c): ?>
<tr>
    <td><?= htmlspecialchars($c['categorie']) ?></td>
    <td><?= number_format($c['chiffre_affaires'],2) ?></td>
</tr>
<?php endforeach; ?>
</table>

<!-- TOP PRODUITS -->
<h3>Top 5 produits</h3>

<table class="table table-striped">
<tr>
    <th>Produit</th>
    <th>Quantité</th>
</tr>

<?php foreach($topProduits as $p): ?>
<tr>
    <td><?= htmlspecialchars($p['libelle']) ?></td>
    <td><?= $p['total_vendu'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<!-- GRAPH -->
<h3>CA par mois</h3>
<canvas id="monGraphique"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = [
<?php foreach($caMois as $m): ?>
"<?= $m['mois'] ?>",
<?php endforeach; ?>
];

const data = [
<?php foreach($caMois as $m): ?>
<?= $m['ca'] ?>,
<?php endforeach; ?>
];

new Chart(document.getElementById('monGraphique'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'CA par mois',
            data: data
        }]
    }
});
</script>

<?php include "../includes/footer.php"; ?>
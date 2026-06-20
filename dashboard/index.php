<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/db.php";

/* =========================
   📊 KPI
========================= */
$ca_total = $pdo->query("SELECT SUM(total) FROM sales")->fetchColumn();

$nb_sales = $pdo->query("SELECT COUNT(*) FROM sales")->fetchColumn();

$nb_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();

/* =========================
   🏆 TOP PRODUITS
========================= */
$top = $pdo->query("
    SELECT p.libelle, SUM(s.quantite) AS qte
    FROM sales s
    JOIN products p ON s.product_id = p.id
    GROUP BY p.libelle
    ORDER BY qte DESC
    LIMIT 5
")->fetchAll();

/* =========================
   📊 CA PAR PRODUIT
========================= */
$labelsProd = [];
$dataProd = [];

$stmt = $pdo->query("
    SELECT p.libelle, SUM(s.total) AS ca
    FROM sales s
    JOIN products p ON s.product_id = p.id
    GROUP BY p.libelle
");

while ($row = $stmt->fetch()) {
    $labelsProd[] = $row['libelle'];
    $dataProd[] = $row['ca'];
}

/* =========================
   📈 CA PAR MOIS
========================= */
$labelsMonth = [];
$dataMonth = [];

$stmt = $pdo->query("
    SELECT DATE_FORMAT(sale_date, '%Y-%m') AS mois, SUM(total) AS ca
    FROM sales
    GROUP BY mois
    ORDER BY mois
");

while ($row = $stmt->fetch()) {
    $labelsMonth[] = $row['mois'];
    $dataMonth[] = $row['ca'];
}
?>

<?php include "../includes/header.php"; ?>

<div class="container mt-4">

    <h2 class="mb-4">📊 Dashboard VenteStat</h2>

    <!-- KPI -->
    <div class="row">

        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5>💰 Chiffre d'affaires</h5>
                    <h3><?= number_format($ca_total, 0, ',', ' ') ?> FCFA</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5>🧾 Ventes</h5>
                    <h3><?= $nb_sales ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5>📦 Produits</h5>
                    <h3><?= $nb_products ?></h3>
                </div>
            </div>
        </div>

    </div>

    <!-- GRAPHIQUES -->
    <div class="row mt-4">

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    📈 CA par produit
                </div>
                <div class="card-body">
                    <canvas id="chartProd"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    📊 CA par mois
                </div>
                <div class="card-body">
                    <canvas id="chartMonth"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- TOP PRODUITS -->
    <div class="card mt-4 shadow">
        <div class="card-header bg-primary text-white">
            🏆 Top 5 produits vendus
        </div>
        <div class="card-body">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité vendue</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($top as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['libelle']) ?></td>
                            <td><?= $t['qte'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* =========================
   GRAPH 1 - PRODUITS
========================= */
new Chart(document.getElementById('chartProd'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labelsProd) ?>,
        datasets: [{
            label: 'CA (FCFA)',
            data: <?= json_encode($dataProd) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    }
});

/* =========================
   GRAPH 2 - MOIS
========================= */
new Chart(document.getElementById('chartMonth'), {
    type: 'line',
    data: {
        labels: <?= json_encode($labelsMonth) ?>,
        datasets: [{
            label: 'CA mensuel (FCFA)',
            data: <?= json_encode($dataMonth) ?>,
            borderColor: 'green',
            fill: false,
            tension: 0.3
        }]
    }
});
</script>

<?php include "../includes/footer.php"; ?>
<?php
session_start();
require_once "../config/db.php";

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = $user['username'];

        header("Location: ../dashboard/index.php");
        exit;

    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Connexion - VenteStat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card shadow-lg border-0">

                <div class="card-header bg-primary text-white text-center">

                    <h3>VenteStat</h3>

                    <p class="mb-0">Connexion</p>

                </div>

                <div class="card-body p-4">

                    <?php if(!empty($error)){ ?>

                        <div class="alert alert-danger">

                            <?= htmlspecialchars($error) ?>

                        </div>

                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">Nom d'utilisateur</label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Mot de passe</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <div class="d-grid">

                            <button
                                type="submit"
                                name="login"
                                class="btn btn-primary">

                                Se connecter

                            </button>

                        </div>

                    </form>

                </div>

                <div class="card-footer text-center text-muted">

                    Mini plateforme de gestion et d'analyse des ventes

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>
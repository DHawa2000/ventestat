
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

<h2>Connexion</h2>

<form method="POST">

    <input type="text" name="username" placeholder="Nom utilisateur" required>
    <br><br>

    <input type="password" name="password" placeholder="Mot de passe" required>
    <br><br>

    <button type="submit" name="login">Se connecter</button>

</form>

<p style="color:red;">
    <?= $error ?>
</p>


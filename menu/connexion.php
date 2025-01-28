 //Page de connexion pour les restaurateurs

<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification des informations de connexion
}

?>

<form method="post" action="">
    Nom d'utilisateur: <input type="text" name="username">
    Mot de passe: <input type="password" name="password">
    <button type="submit">Connexion</button>
</form>

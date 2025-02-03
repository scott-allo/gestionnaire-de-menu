<?php
// reset_request.php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Vérifier si l'email existe dans la base de données
    $stmt = $pdo->prepare("SELECT id, email FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Générer un jeton unique
        $resetToken = bin2hex(random_bytes(32)); // Générer un jeton sécurisé
        $expiresAt = date("Y-m-d H:i:s", strtotime("+1 hour")); // Le jeton expire dans 1 heure

        // Insérer le jeton et l'expiration dans la table password_resets
        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, reset_token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$user['id'], $resetToken, $expiresAt]);

        // Envoyer l'email avec le lien de réinitialisation
        $resetLink = "https://olivia-dondas.students-laplateforme.io/reset_password.php?token=$resetToken";

        $subject = "Réinitialisation de votre mot de passe";
        $message = "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink";
        $headers = "From: no-reply@olivia-dondas.students-laplateforme.io/.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "Un email vous a été envoyé pour réinitialiser votre mot de passe.";
        } else {
            echo "Erreur lors de l'envoi de l'email.";
        }
    } else {
        echo "Cet email n'est pas enregistré.";
    }
}
?>





<!-- formulaire.html -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
</head>
<body>
    <h1>Réinitialisation de votre mot de passe</h1>
    <form action="reset_request.php" method="POST">
        <label for="email">Entrez votre adresse email :</label>
        <input type="email" name="email" required>
        <button type="submit">Réinitialiser le mot de passe</button>
    </form>
</body>
</html>
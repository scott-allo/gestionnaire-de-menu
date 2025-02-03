<?php
// reset_password.php
require 'config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Vérifier si le jeton est valide et n'est pas expiré
    $stmt = $pdo->prepare("SELECT pr.user_id, pr.reset_token, pr.expires_at, u.email FROM password_resets pr JOIN users u ON pr.user_id = u.id WHERE pr.reset_token = ?");
    $stmt->execute([$token]);
    $resetRequest = $stmt->fetch();

    if ($resetRequest) {
        // Vérifier si le jeton a expiré
        if (strtotime($resetRequest['expires_at']) > time()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Nouveau mot de passe
                $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

                // Mettre à jour le mot de passe de l'utilisateur
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->execute([$newPassword, $resetRequest['user_id']]);

                // Supprimer le jeton de réinitialisation
                $stmt = $pdo->prepare("DELETE FROM password_resets WHERE reset_token = ?");
                $stmt->execute([$token]);

                echo "Votre mot de passe a été réinitialisé avec succès.";
            }
        } else {
            echo "Le lien de réinitialisation a expiré.";
        }
    } else {
        echo "Jeton invalide.";
    }
} else {
    echo "Jeton manquant.";
}
?>
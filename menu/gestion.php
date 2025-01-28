<?php
$host = "localhost";
$db = "gestionnaire-de-menu";
$user = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer tous les plats
$sql = "SELECT p.id, p.nom, p.description, p.prix, c.nom AS categorie 
        FROM plats p 
        JOIN categories c ON p.id_categorie = c.id";
$stmt = $pdo->query($sql);
$plats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des plats</title>
</head>
<body>
    <h1>Liste des plats</h1>
    <a href="ajouter.php">Ajouter un nouveau plat</a>
    <table border="1">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($plats as $plat): ?>
                <tr>
                    <td><?= htmlspecialchars($plat['nom']) ?></td>
                    <td><?= htmlspecialchars($plat['description']) ?></td>
                    <td><?= htmlspecialchars($plat['prix']) ?> €</td>
                    <td><?= htmlspecialchars($plat['categorie']) ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $plat['id'] ?>">Modifier</a>
                        <a href="supprimer.php?id=<?= $plat['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce plat ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
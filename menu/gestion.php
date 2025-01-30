<?php
$host = "localhost";
$db = "gestionnaire-de-menu";
$user = "root"; // MySQL username
$password = ""; // MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

// Retrieve all dishes
$sql = "SELECT p.id, p.name, p.description, p.price, c.name AS category 
        FROM dishes p 
        JOIN categories c ON p.category_id = c.id";
$stmt = $pdo->query($sql);
$plats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liste des plats</title>
</head>
<body>
    <h1>Dish List</h1>
    <a href="add.php">Ajouter un nouveau plat</a>
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
                    <td><?= htmlspecialchars($plat['name']) ?></td>
                    <td><?= htmlspecialchars($plat['description']) ?></td>
                    <td><?= htmlspecialchars($plat['price']) ?> €</td>
                    <td><?= htmlspecialchars($plat['category']) ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $plat['id'] ?>">Edit</a>
                        <a href="supprimer.php?id=<?= $plat['id'] ?>" onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer ce plat ?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
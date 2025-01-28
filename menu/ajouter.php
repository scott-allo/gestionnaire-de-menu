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

// Récupérer les catégories pour le formulaire
$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ajouter un plat
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $id_categorie = $_POST['id_categorie'];

    $sql = "INSERT INTO plats (nom, ingredients, prix, id_categorie) VALUES (:nom, :ingredients, :prix, :id_categorie)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':ingredients' => $ingredients,
        ':prix' => $prix,
        ':id_categorie' => $id_categorie
    ]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un plat</title>
</head>
<body>
    <h1>Ajouter un nouveau plat</h1>
    <form method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" required><br>
        <label>Description :</label>
        <textarea name="description" required></textarea><br>
        <label>Prix :</label>
        <input type="number" name="prix" step="0.01" required><br>
        <label>Catégorie :</label>
        <select name="id_categorie" required>
            <?php foreach ($categories as $categorie): ?>
                <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['nom']) ?></option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>

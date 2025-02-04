 <?php
// Inclusion de la configuration de la base de données
$config = require('config.php');

// Connexion à la base de données avec gestion d'erreur
try {
    $pdo = new PDO("mysql:host=" . $config['db_host'] . ";dbname=" . $config['db_name'] . ";charset=utf8mb4", $config['db_user'], $config['db_pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

//var_dump($_GET);

// Vérification si une demande de suppression a été faite
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Préparation de la requête de suppression
    $sql = "DELETE FROM dishes WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Exécution de la requête
    $stmt->execute(['id' => $id]);

    // Redirection pour éviter de réexécuter la suppression lors d'un rafraîchissement de la page
    header("Location: gestion.php");
    exit();
}

// Traitement de l'ajout d'un nouveau plat via le formulaire
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    // Gestion de l'upload de l'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO dishes (name, description, price, category_id, image) 
                    VALUES (:name, :description, :price, :category_id, :image)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'description' => $description, 'price' => $price, 'category_id' => $category_id, 'image' => $target_file]);
        } else {
            // Si l'image ne peut être uploadée, on insère sans l'image
            $sql = "INSERT INTO dishes (name, description, price, category_id) 
                    VALUES (:name, :description, :price, :category_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'description' => $description, 'price' => $price, 'category_id' => $category_id]);
        }
    }

    // Redirection vers la page de gestion après soumission
    header("Location: gestion.php"); 
    exit();
}

// Récupération des plats existants
$sql = "SELECT p.id, p.name, p.description, p.price, p.image, c.name AS category
        FROM dishes p 
        JOIN categories c ON p.category_id = c.id";
$stmt = $pdo->query($sql);
$dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des catégories pour le menu déroulant
$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des plats</title>
	<link rel="icon" href="images/favicon.png">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/gestion.css"> 
   
</head>
<body>
    <header class="header">
        <img src="images/logo.png" alt="logo" class="logo1">
    </header>

    <section class="container">
		 <a href="menu.php" class="menu-btn">Afficher le Menu</a>
		
        <!-- Bouton pour ouvrir le modal -->
        <label for="showModal" class="add-btn">Ajouter un nouveau plat</label>
        <input type="checkbox" id="showModal">
		
		
        
		
        <!-- Modal pour l'ajout -->
        <div class="modal">
            <div class="modal-content">
                <label for="showModal" class="close">X</label>
                <h2>Ajouter un plat</h2>
                <form action="gestion.php" method="POST" class="modal-form" enctype="multipart/form-data">
                    <label for="name">Nom du plat</label>
                    <input type="text" id="name" name="name" required>

                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>

                    <label for="price">Prix</label>
                    <input type="number" id="price" name="price" step="0.01" required>

                    <label for="category_id">Catégorie</label>
                    <select id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="image">Image</label>
                    <input type="file" id="image" name="image">

                    <input type="submit" value="Ajouter le plat">
                </form>
            </div>
        </div>

        <!-- Tableau des plats -->
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dishes as $dish): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($dish['name']); ?></td>
                        <td><?php echo htmlspecialchars($dish['description']); ?></td>
                        <td class="price"><?= htmlspecialchars($dish['price']) ?> €</td>
                        <td><?= htmlspecialchars($dish['category']) ?></td>
                        <td><img src="<?php echo htmlspecialchars($dish['image']); ?>" alt="Image de <?php echo htmlspecialchars($dish['name']); ?>" width="50"></td>
                        <td>
                            <a href="#">Modifier</a>
                            <a href="gestion.php?action=delete&id=<?php echo $dish['id']?> "onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer ce plat ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <footer class="footer">
        <p>2025 - Bistroteca by Olivia Dondas & Scott Allo - Tous droits réservés</p>
    </footer>
</body>
</html>
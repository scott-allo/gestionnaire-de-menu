<?php
// Connexion à la base de données et récupération des catégories
$config = require('config.php');
try {
    $pdo = new PDO("mysql:host=" . $config['db_host'] . ";dbname=" . $config['db_name'] . ";charset=utf8mb4", $config['db_user'], $config['db_pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Récupérer les catégories
    $stmt = $pdo->query("SELECT * FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un plat</title>
    <style>
        /* Style de base, à adapter selon tes préférences */
        .container {
            margin: 20px;
        }

        .add-btn {
            cursor: pointer;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        #showModal:checked + .modal {
            display: flex;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
        }

        .close {
            cursor: pointer;
            font-size: 20px;
            float: right;
        }

        form input, form textarea, form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <section class="container">
        <label for="showModal" class="add-btn">Ajouter un nouveau plat</label>
        <input type="checkbox" id="showModal">
        <div class="modal">
            <div class="modal-content">
                <label for="showModal" class="close">X</label>
                <h2>Ajouter un plat</h2>
                <form method="POST" action="gestion.php" enctype="multipart/form-data">
                    <input type="text" name="name" placeholder="Nom du plat" required>
                    <textarea name="description" placeholder="Description du plat" required></textarea>
                    <input type="number" name="price" placeholder="Prix (€)" step="0.01" required>
                    <select name="category_id" required>
                        <option value="">Choisir une catégorie</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="file" name="image" placeholder="URL de l'image (optionnel)">
                    <button type="submit">Ajouter</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
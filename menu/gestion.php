<?php
$host = "localhost";
$db = "gestionnaire-de-menu";
$user = "root"; // MySQL username
$password = ""; // MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
    
}

// Retrieve all dishes
$sql = "SELECT p.id, p.name, p.description, p.price, p.image, c.name AS category
        FROM dishes p 
        JOIN categories c ON p.category_id = c.id";
$stmt = $pdo->query($sql);
$dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retrieve categories for the modal form
$sqlCategories = "SELECT * FROM categories";
$stmtCategories = $pdo->query($sqlCategories);
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des plats</title>
    <style>
        /* Styles de base */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }

        .container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #101720;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #101720;
            margin-right: 5px;
            display: inline-block;
        }

        a:hover {
            background-color: #f05bb5;
        }

        /* Bouton d'ajout */
        .add-btn {
            display: inline-block;
            background-color: #101720;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .add-btn:hover {
            background-color: #f05bb5;
        }

        /* Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }


        #modal:target {
            display: flex;

        td.price {
            white-space: nowrap; 

        }

        .modal-content {
            background: white;
            padding: 20px;
            width: 400px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            text-decoration: none;
            color: black;
        }

        .close:hover {
            color: red;
        }

        /* Formulaire */
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal button {
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .modal button:hover {
            background-color: #218838;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                font-size: 12px;
                padding: 8px;
            }

            a {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <section class="container">
        <!-- Lien pour ouvrir le modal -->
        <a href="#modal" class="add-btn">Ajouter un nouveau plat</a>

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
                        <td data-label="Nom"><?= htmlspecialchars($dish['name']) ?></td>
                        <td data-label="Description"><?= htmlspecialchars($dish['description']) ?></td>
                        <td data-label="Prix" class="price"><?= htmlspecialchars($dish['price']) ?> €</td>
                        <td data-label="Catégorie"><?= htmlspecialchars($dish['category']) ?></td>
                        <td data-label="Image">
                            <?php if (!empty($dish['image'])):?>
                                <img src="<?= htmlspecialchars($dish['image'])?>" alt="<?= htmlspecialchars($dish['name']) ?>" width="50">
                            <?php else: ?>
                                <span>Pas d'image</span>
                            <?php endif; ?>       
                        </td>
                        <td data-label="Actions">

                            <a href="edit.php?id=<?= $dish['id'] ?>">Modifier</a>
                            <a href="delete.php?id=<?= $dish['id'] ?>" onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer ce plat ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
             </tbody>
        </table>
    </section>

    <!-- Modal d'ajout -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <a href="#" class="close">&times;</a>
            <h2>Ajouter un nouveau plat</h2>
            <form method="POST" action="add.php">
    <label>Nom :</label>
    <input type="text" name="nom" required>

    <label>Description :</label>
    <textarea name="description" required></textarea>

    <label>Prix :</label>
    <input type="number" name="prix" step="0.01" required>

    <label>Catégorie :</label>
    <select name="id_categorie" required>
        <?php foreach ($categories as $categorie): ?>
            <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Ajouter</button>
</form>
        </div>
    </div>

</body>
</html>


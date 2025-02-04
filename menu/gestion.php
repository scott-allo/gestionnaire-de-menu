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
    <style>
        /* Style de base pour la page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            min-height: 100vh;
            margin: 0;
            padding: 0;
            flex-direction: column;
        }

        /* Conteneur central pour les éléments */
        .container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Styles de la table des plats */
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
		
		
        td.price {
            white-space: nowrap; 
        }

        /* Styles des liens d'action */
        a {
            text-decoration: none;
            color: #101720;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #e1e1e1;
            margin-right: 5px;
            display: inline-block;
        }

        a:hover {
            background-color: #101720;
            color: white;
        }

        /* Bouton d'ajout */
        .add-btn {
            display: block;
            text-align: center;
            background-color: #101720;
            color: white;
            padding: 10px;
            border-radius: 5px;
            width: 200px;
            margin: 20px auto;
        }

        .add-btn:hover {
            background-color: rgb(240, 181, 221);
        }

        /* Masquage du checkbox pour le modal */
        input[type="checkbox"] {
            display: none;
        }

        /* Modal - Affichage du formulaire d'ajout */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease, visibility 0s 0.3s;
            opacity: 0;
            visibility: hidden;
        }

        input[type="checkbox"]:checked + .modal {
            display: flex;
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            padding: 25px;
            border-radius: 12px;
            width: 60%;
            max-width: 600px;
            box-sizing: border-box;
            overflow-y: auto;
            position: relative;
            transform: scale(0.95);
            transition: transform 0.3s ease-in-out;
        }

        input[type="checkbox"]:checked + .modal .modal-content {
            transform: scale(1);
        }

        /* Style du bouton de fermeture */
        .close {
            cursor: pointer;
            color: #101720;
            font-size: 16px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            padding: 5px;
            border-radius: 50%;
        }

        .close:hover {
            background-color: #e1e1e1;
        }

        /* Formulaire dans le modal */
        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .modal-form input, .modal-form select, .modal-form textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        .modal-form input:focus, .modal-form select:focus, .modal-form textarea:focus {
            border-color: #101720;
        }

        .modal-form input[type="submit"] {
            background-color: #101720;
            color: white;
            border: none;
            cursor: pointer;
            padding: 12px;
            border-radius: 8px;
        }

        .modal-form input[type="submit"]:hover {
            background-color: #333;
        }

        /* Adaptation responsive */
        @media (max-width: 768px) {
            .modal-content {
                width: 90%;
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .modal-content {
                width: 100%;
                padding: 15px;
            }
                /* Adaptation responsive */
      @media (max-width: 768px) {
            .modal-content {
                width: 90%;
                padding: 20px;
            }
        }

      @media (max-width: 480px) {
			  
	.modal-content {
             width: 100%;
             padding: 15px;
            }
		  
			  
    table {
        display: block;
		width: 100%;
		overflow-x: auto;
    }
    thead {
        display: none; /* Cache les en-têtes sur mobile */
    }
    tbody tr {
        display: flex;
        flex-direction: column;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 10px;
        background: #fff;
    }
    td {
        display: flex;
		align-items: center;
        justify-content: space-between;
        padding: 12px 8px;
		font-size: 14px;
    }
    td::before {
        content: attr(data-label);
		flex:1;
        font-weight: bold;
        margin-right: 10px;
        color: #555;
    }
    .price {
		font-size: 16px;
		font-weight: bold;
        white-space: nowrap;
		
    }	
}
        }
    </style>
</head>
<body>
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
</body>
</html>
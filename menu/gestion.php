<?php
$host = "localhost";
$db = "gestionnaire-de-menu";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

// Process form submission (for adding a new dish)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image = $_POST['image'];

    $sql = "INSERT INTO dishes (name, description, price, category_id, image) 
            VALUES (:name, :description, :price, :category_id, :image)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'description' => $description, 'price' => $price, 'category_id' => $category_id, 'image' => $image]);

    header("Location: gestion.php"); // Redirect to gestion page after submission
    exit();
}

// Retrieve all dishes
$sql = "SELECT p.id, p.name, p.description, p.price, p.image, c.name AS category
        FROM dishes p 
        JOIN categories c ON p.category_id = c.id";
$stmt = $pdo->query($sql);
$dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch categories for the dropdown
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
    <style>
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

        .container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            margin: 0 auto;
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

        td.price {
            white-space: nowrap; 
        }

  /* Masquer le checkbox */
input[type="checkbox"] {
    display: none;
}

/* Le modal lui-même */
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
    transition: opacity 0.3s ease, visibility 0s 0.3s; /* Transition douce */
    opacity: 0;
    visibility: hidden;
}

/* Affichage du modal lorsque le checkbox est coché */
input[type="checkbox"]:checked + .modal {
    display: flex;
    opacity: 1;
    visibility: visible;
    transition: opacity 0.3s ease;
}

/* Contenu du modal */
.modal-content {
    background: white;
    padding: 25px;
    border-radius: 12px;
    width: 60%;
    max-width: 600px;
    box-sizing: border-box;
    overflow-y: auto;
    position: relative;
    transition: transform 0.3s ease-in-out;
    transform: scale(0.95); /* Petit effet de zoom au début */
}

/* Affichage du contenu du modal avec un léger zoom */
input[type="checkbox"]:checked + .modal .modal-content {
    transform: scale(1);
}

/* Bouton pour ouvrir le modal */
label[for="showModal"] {
    display: block;
    text-align: center;
    background-color: #101720;
    color: white;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    width: 220px;
    margin: 20px auto;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

label[for="showModal"]:hover {
    background-color: #333;
}

/* Fermeture du modal (la croix) */
.close {
    cursor: pointer;
    color: #101720;
    font-size: 16px;  /* Réduction de la taille de la croix */
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: transparent;
    border: none;
    padding: 5px;
    border-radius: 50%;
    transition: background-color 0.3s ease;
}

/* Effet au survol de la croix */
.close:hover {
    background-color: #e1e1e1;
}

/* Structure du formulaire dans le modal */
.modal-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Style des champs de saisie (input, select, textarea) */
.modal-form input, .modal-form select, .modal-form textarea {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border-radius: 8px;
    border: 1px solid #ddd;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

/* Changement de couleur de la bordure au focus */
.modal-form input:focus, .modal-form select:focus, .modal-form textarea:focus {
    border-color: #101720;
}

/* Style du bouton de soumission dans le modal */
.modal-form input[type="submit"] {
    background-color: #101720;
    color: white;
    border: none;
    cursor: pointer;
    padding: 12px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    font-size: 16px;
}

.modal-form input[type="submit"]:hover {
    background-color: #333;
}

/* Adaptation responsive pour les écrans plus petits */
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
}

        /* Form styles */
        input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            padding: 10px 20px;
            background-color: #101720;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #333;
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
                <form method="POST" action="gestion.php">
                    <input type="text" name="name" placeholder="Nom du plat" required>
                    <textarea name="description" placeholder="Description du plat" required></textarea>
                    <input type="number" name="price" placeholder="Prix (€)" step="0.01" required>
                    <select name="category_id" required>
                        <option value="">Choisir une catégorie</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="image" placeholder="URL de l'image (optionnel)">
                    <button type="submit">Ajouter</button>
                </form>
            </div>
        </div>

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
                        <td><?= htmlspecialchars($dish['name']) ?></td>
                        <td><?= htmlspecialchars($dish['description']) ?></td>
                        <td class="price"><?= htmlspecialchars($dish['price']) ?> €</td>
                        <td><?= htmlspecialchars($dish['category']) ?></td>
                        <td>
                            <?php if (!empty($dish['image'])):?>
                                <img src="<?= htmlspecialchars($dish['image'])?>" alt="<?= htmlspecialchars($dish['name']) ?>" width="50">
                            <?php else: ?>
                                <span>Pas d'image</span>
                            <?php endif; ?>       
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $dish['id'] ?>">Modifier</a>
                            <a href="delete.php?id=<?= $dish['id'] ?>" onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer ce plat ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
             </tbody>
        </table>
    </section>
</body>
</html>

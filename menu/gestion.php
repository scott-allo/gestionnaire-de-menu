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

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                width: 95%;
                padding: 15px;
            }

            table {
                font-size: 14px;
            }

            .add-btn {
                width: 100%;
            }

            th, td {
                font-size: 12px;
                padding: 8px;
            }

            a {
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
    table {
        display: block;
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
        border-radius: 8px;
        background: #fff;
    }

    td {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
    }

    td::before {
        content: attr(data-label);
        font-weight: bold;
        margin-right: 10px;
        color: #333;
    }

    .price {
        white-space: nowrap;
    }
}

        
    </style>
</head>
<body>
    <section class="container">
        <a href="add.php" class="add-btn">Ajouter un nouveau plat</a>
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
</body>
</html>
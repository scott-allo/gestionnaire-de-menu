
<?php
$host = "localhost";
$db = "olivia-dondas_gestionnaire-de-menu";
$user = "olivia-dondas"; 
$password = "kzCFKQbU3N@t9j7"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}

// Récupérer tous les plats
$sql = "SELECT p.name, p.description, p.price, p.image, c.name AS category
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
    <title>Menu du restaurant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
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

        h1 {
            text-align: center;
            color: #101720;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .menu-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }

        .menu-item .info {
            flex: 1;
        }

        .menu-item h2 {
            margin: 0;
            font-size: 18px;
            color: #101720;
        }

        .menu-item p {
            margin: 5px 0;
            color: #555;
        }

        .menu-item .price {
            font-weight: bold;
            color: #d9534f;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            .menu-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .menu-item img {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <section class="container">
        <h1>Notre Menu</h1>
        <?php foreach ($dishes as $dish): ?>
            <div class="menu-item">
                <img src="<?= !empty($dish['image']) ? htmlspecialchars($dish['image']) : 'images/default.png'; ?>" 
                     alt="<?= htmlspecialchars($dish['name']) ?>">
                <div class="info">
                    <h2><?= htmlspecialchars($dish['name']) ?></h2>
                    <p><?= htmlspecialchars($dish['description']) ?></p>
                    <p><strong>Catégorie :</strong> <?= htmlspecialchars($dish['category']) ?></p>
                    <p class="price"><?= htmlspecialchars($dish['price']) ?> €</p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</body>
</html>

<?php
$config = require('config.php');

if (isset($_POST['submit'])) {
    try {
        // Vérifier si les champs sont remplis
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
            header("Location: connection.html?error=Tous les champs sont obligatoires !");
            exit();
        }

        // Connexion à la base de données
        $pdo = new PDO("mysql:host=" . $config['db_host'] . ";dbname=" . $config['db_name'] . ";charset=utf8mb4", $config['db_user'], $config['db_pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Hacher le mot de passe
        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Préparer et exécuter la requête d'insertion
        $query = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $query->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $query->bindValue(':password', $hashedPassword, PDO::PARAM_STR);

        $query->execute();

        // Redirection vers la page de connexion après inscription réussie
        header("Location: login.php?success=Inscription réussie ! Vous pouvez maintenant vous connecter.");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de base de données :" . $e->getMessage();
        header("Location: login.php?error=Erreur de base de données: " . urlencode($e->getMessage()));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bistroteca - Inscription</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .allcontainer {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            padding: 20px;
            box-sizing: border-box; /* Assure que le padding est inclus dans la largeur totale */
            flex-wrap: wrap; /* Permet aux éléments de se déplacer sur la ligne suivante si nécessaire */
        }

        .container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 300px;
            text-align: center;
            margin: 10px; /* Ajoute un espacement autour de chaque conteneur */
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; /* Assure que le padding est inclus dans la largeur totale */
        }

        button {
            background-color: #101720;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: rgb(240, 181, 221);
        }

        p {
            margin-top: 15px;
        }

        a {
            color: #101720;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .logo1 {
            text-align: center;
			height: auto;
            max-width: 120px;
            margin-top: 0px;
			
        }

        .logo2 {
            width: 100%;
            max-width: 500px;
            height: auto;
            margin-left: 40px;
        }

        .header, .footer {
            width: 100%;
            background-color: #E59710;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            left: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			z-index: 1000;
			box-sizing: border-box;
			min-height: 60px;
        }

        .header {
            top: 0;
            height: 10vh;
			
			
        }

        .footer {
            bottom: 0;
            margin-top: 20px;
            height: 25px;
        }
		
		h2 {
			font-family: Patriot;
	

        /* Media Queries */
        @media (max-width: 768px) {
            .allcontainer {
                flex-direction: column;
                align-items: center;
                padding: 10px;
            }

            .logo2 {
                width: 80%;
                margin: 20px 0;
            }
        }

        @media (max-width: 480px) {
            .container {
                width: 90%;
                margin: 10px auto;
            }

            .logo2 {
                width: 100%;
                margin: 10px 0;
            }

            .header, .footer {
                padding: 10px 0;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <img src="images/logo.png" alt="logo" class="logo1">
    </header>
    <section class="allcontainer">
        <aside class="logo2">
            <img src="images/logo.png" alt="logo" class="logo2">
        </aside>
        <section class="container">
            <h2>Bistroteca</h2>
            <h3>Inscription</h3>

            <?php
            if (isset($_GET['error'])) {
                echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
            }
            ?>

            <form action="" method="POST">
                <input type="text" name="name" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <button type="submit" name="submit">S'inscrire</button>
                <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
            </form>
        </section>
    </section>
    <footer class="footer">
        <p>2025 - Bistroteca - Tous droits réservés</p>
    </footer>
</body>
</html>

<?php
$host = "localhost";
$db = "gestionnaire-de-menu";
$user = "root"; 
$password = ""; 

if(isset($_POST['login'])) {
    try {
        
        if(empty($_POST['email']) || empty($_POST['password'])){
            header("Location: login.php?error=Tous les champs sont obligatoires !");
            exit();
        }

        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
       
        $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $query->execute();
        
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        if($user && password_verify($_POST['password'], $user['password'])) {
         
            header("Location: gestion.php?success=Connexion réussie !");
            exit();
        } else {
          
            header("Location: login.php?error=Email ou mot de passe incorrect !");
            exit();
        }
    } catch (PDOException $e) {
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
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
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
    </style>
</head>
<body>

    <div class="container">
        <h2>Bienvenue sur Art'doise</h2>
        <h3>Connexion</h3>

        <?php
        if(isset($_GET['error'])) {
            echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>

        <form action="" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="login">Se connecter</button>
            <p>Mot de passe oublié? <a href="connexion.php">Cliquez-ici</a></p>
        </form>
    </div>

</body>
</html>

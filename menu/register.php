<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    
    <?php
$host = "localhost";
$db = "gestionnaire-de-menu";
$user = "root"; 
$password = "root"; 

if(isset($_POST['submit'])){
    try {
        // Vérifier si les champs sont remplis
        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){
            header("Location: connection.html?error=Tous les champs sont obligatoires !");
            exit();
        }

        // Connexion à la base de données
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, 'root');
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
        header("Location: login.php?success=Inscription réussie !");
        exit();
    } catch (PDOException $e) {
        header("Location: login.php?error=Erreur de base de données: " . urlencode($e->getMessage()));
        exit();
    }
}
?>


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .allcontainer{
          display: flex;
          justify-content: space-around;
          align-items: center; 
          width: 100%;
          padding: 20px;
          }
        .container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 300px;
            text-align: center;
            margin-right: 50px;
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
            background-color:rgb(240, 181, 221);
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
        .logo1{
          text-align: center;
          width: 120px;
          margin-top: -30px; 

        }
        .logo2{
          width: 500px;
          height: 450px;
          margin-left: 40px;
          
        }
        .header, .footer {
            width: 100%;
            background-color:rgb(73, 73, 73);
            color: white;
            text-align: center;
            padding: 15px 0;
            position: fixed;
            left: 0;
        }
        .header {
            top: 0;
            height: 7%;
        }
        .footer {
            bottom: 0;
            margin-top: 20px;
            height: 25px;
        }
    </style>
</head>
<body>
    <div class="header">
       <img src="/gestionnaire-de-menu/images/chef.png" alt="logo" class="logo1">
    </div>
    <div class="allcontainer">
       <div class="logo2">
          <img src="/gestionnaire-de-menu/images/chef.png" alt="logo" class="logo2">
       </div>
       <div class="container">
        <h2>Bienvenue sur Art'doise</h2>
        <h3>Inscription</h3>

        <?php
        if(isset($_GET['error'])) {
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

    </div>
    <div class="footer">
        <p>2025 - Art'doise - Tous droits réservés</p>
    </div>
</body>
</html>
</head>

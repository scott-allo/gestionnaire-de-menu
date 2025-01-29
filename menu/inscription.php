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
$password = ""; 

if(isset($_POST['submit'])){
    try {
        // Check if fields are filled
        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){
            header("Location: signup.html?error=All fields are required!");
            exit();
        }

        // Connect to the database
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Hash the password
        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Prepare SQL query
        $query = $pdo->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
        $query->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $query->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        
        // Execute the query
        $query->execute();

        // Redirect to login page
        header("Location: ../connexion.php");
        exit();
    } catch (PDOException $e) {
        header("Location: signup.html?error=Database error: " . urlencode($e->getMessage()));
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
            background-color:rgb(240, 181, 221);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Sign Up</h2>

        <?php
        if(isset($_GET['error'])) {
            echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        
        ?>

        <form action="signup.php" method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="email" placeholder="Email" required>
         <input type="password" name="password" placeholder="Password" required>
         <button type="submit" name="submit">Sign Up</button>
        </form>
    </div>

</body>
</html>
</head>


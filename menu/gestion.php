
<?php
//Page unique pour gérer les plats, catégories et ingrédients

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "restaurant_db";

try {
    // Création d'une connexion PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

    // Configuration de PDO pour afficher les erreurs sous forme d'exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connexion réussie à la base de données restaurant_db !";

    // Exemple d'une requête simple : récupération des tables existantes
    $query = $conn->query("SHOW TABLES");
    $tables = $query->fetchAll(PDO::FETCH_COLUMN);

    echo "<br>Tables dans la base de données :<br>";
    foreach ($tables as $table) {
        echo "- $table<br>";
    }

} catch (PDOException $e) {
    // Gestion des erreurs de connexion ou d'exécution
    die("Erreur lors de la connexion : " . $e->getMessage());
}
?>

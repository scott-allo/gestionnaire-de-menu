<?php
$host = "localhost";
$db = "gestionnaire-de-menu";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier que tous les champs sont remplis
    if (!empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['id_categorie'])) {
        // Récupérer les données et les sécuriser
        $nom = htmlspecialchars($_POST['nom']);
        $description = htmlspecialchars($_POST['description']);
        $prix = floatval($_POST['prix']);
        $id_categorie = intval($_POST['id_categorie']);

        try {
            // Préparer la requête
            $sql = "INSERT INTO dishes (name, description, price, category_id) VALUES (:nom, :description, :prix, :id_categorie)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':id_categorie', $id_categorie);

            // Exécuter la requête
            if ($stmt->execute()) {
                header("Location: gestion.php?success=1");
                exit();
            } else {
                echo "Erreur lors de l'ajout du plat.";
            }
        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
        }
    } else {
        echo "Tous les champs sont requis.";
    }
} else {
    echo "Requête invalide.";
}
?>

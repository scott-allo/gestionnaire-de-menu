
<?php
 //Page de connexion pour les restaurateurs
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification des informations de connexion
}

?>


<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contactez Matcha Tea</title>
    <link rel="stylesheet" href="../styles/style.css" />

  </head>

  <body>
  <section class="fond">
  <header class="navbar">
    <section class="logo">
      <a href="../index.html" class="lienpourindex">
      <img
        src="../assets/logos/Matcha Tea-Logo Officiel - Quad color.png"
        alt="Logo Matcha Tea"
        class="logo"
      />
      </a>
    </section>
  </header>

   <nav class="sidebar">
        <ul>
          <li>
            <a href="./vente.html" class="liensidebar"
              >Vente</a
            >
          </li>
          <li>
            <a href="./histoire.html" class="liensidebar"
              >Histoire</a
            >
          </li>
          <li>
            <a href="./apropos.html" class="liensidebar"
              >À propos</a
            >
          </li>
          <li>
            <a href="./contact.html" class="liensidebar"
              >Contact</a
            >
          </li>
        </ul>
      </nav>
<main>
<form method="post" action="">
    Nom d'utilisateur: <input type="text" name="username">
    Mot de passe: <input type="password" name="password">
    <button type="submit">Connexion</button>
</form>

  <section class="conteneur-contact">
    <div class="illustration">
      <img src="../assets/logos/Matcha Tea-Logo Officiel - Quad color.png" alt="Illustration de contact">
    </div>
  
    <div class="formulaire">
      <h3>Inscrivez-vous</h3>
      <form action="#" method="post" class="contact-form">
       
        <div class="groupe-champ">
          <label for="nom">Prénom</label>
          <input type="text" id="prenom" name="prenom" required placeholder="Prénom" />
        </div>
    
        <div class="groupe-champ">
          <label for="prenom">Nom</label>
          <input type="text" id="nom" name="nom" required placeholder="Nom" />
        </div>

        <div class="groupe-champ">
          <label for="prenom">Téléphone</label>
          <input type="tel" id="telephone" name="telephone" required placeholder="Téléphone" />
        </div>
    
        <div class="groupe-champ">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required placeholder="Email" />
        </div>
        <div class="groupe-champ">
          <label for="email">Mot de passe</label>
          <input type="password" id="motdepasse" name="motdepasse" required placeholder="Mot de passe" />
        </div>
    
    
        
    
        <div class="actions-formulaire">
          <button type="submit">S'inscrire</button>
        </div>
      </form>
    </div>
  </section>
</main>

    <footer>
      <p class="copyright">Matchala Inc. 2025 - tous droits réservés</p>
    </footer>
    </section>
  </body>
</html>


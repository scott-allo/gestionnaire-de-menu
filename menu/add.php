<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un plat</title>
    <style>
        /* Styles de base */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        
        a.button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }

        a.button:hover {
            background-color: #218838;
        }

        /* Modal (caché par défaut) */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }

        /* Afficher le modal si ":target" est activé */
        #modal:target {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 20px;
            width: 400px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        /* Bouton de fermeture */
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            text-decoration: none;
            color: black;
        }

        .close:hover {
            color: red;
        }

        /* Formulaire */
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal button {
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .modal button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Bouton pour ouvrir le modal -->
    <a href="#modal" class="button">Ajouter un plat</a>

    <!-- Modal (s'ouvre avec #modal) -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <a href="#" class="close">&times;</a> <!-- Ferme le modal -->
            <h2>Ajouter un nouveau plat</h2>
            <form method="POST">
                <label>Nom :</label>
                <input type="text" name="nom" required>

                <label>Description :</label>
                <textarea name="description" required></textarea>

                <label>Prix :</label>
                <input type="number" name="prix" step="0.01" required>

                <label>Catégorie :</label>
                <select name="id_categorie" required>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['nom']) ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Ajouter</button>
            </form>
        </div>
    </div>

</body>
</html>

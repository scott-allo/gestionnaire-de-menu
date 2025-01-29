<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
            <input type="text" name="firstname" placeholder="First Name" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="submit">Sign Up</button>
        </form>
    </div>

</body>
</html>

<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "inscription_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["mot_de_passe"])) {
            $_SESSION["user"] = $user;

            // Vérifie le rôle et redirige
            if ($user["role"] === "admin") {
                header("Location: interface.php");
            } else {
                header("Location: interfac.php");
            }
            exit();
        } else {
            $message = "❌ Mot de passe incorrect.";
        }
    } else {
        $message = "❌ Aucun utilisateur trouvé avec cet email.";
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .input-group {
            margin-bottom: 15px;
        }
        input[type="text"],
        input[type="password"] {
            width: 95%;
            padding: 10px;
            border: none;
            border-bottom: 2px orangered solid;
            font-size: 16px;
        }
        button.btn {
            width: 99%;
            padding: 10px;
            background-color: orangered;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input::placeholder {
            color: rgb(0, 0, 0);
        }
        button.btn:hover {
            background-color: darkorange;
        }
        .msg {
            text-align: center;
            color: red;
            margin-bottom: 15px;
        }
        a {
            color: orangered;
            text-decoration: none;
            transition: color 0.3s;
        }
        a:hover {
            color: darkorange;
        }

        /* Media Queries pour tous les appareils */
        
        /* Tablettes et petits écrans (768px et moins) */
        @media (max-width: 768px) {
            .login-container {
                padding: 30px;
            }
            
            h2 {
                font-size: 24px;
            }
        }
        
        /* Smartphones moyens (600px et moins) */
        @media (max-width: 600px) {
            .login-container {
                padding: 25px;
            }
            
            input[type="text"],
            input[type="password"] {
                font-size: 15px;
            }
            
            button.btn {
                font-size: 15px;
                padding: 9px;
            }
        }
        
        /* Petits smartphones (480px et moins) */
        @media (max-width: 480px) {
            body {
                padding: 25px;
                align-items: flex-start;
                margin-top: 100px;
            }
            
            .login-container {
                padding: 20px;
                margin-top: 20px;
            }
            
            h2 {
                font-size: 22px;
                margin-bottom: 15px;
            }
            
            .input-group {
                margin-bottom: 12px;
            }
            
            .msg {
                font-size: 14px;
            }
        }
        
        /* Très petits smartphones (360px et moins) */
        @media (max-width: 360px) {
            .login-container {
                padding: 15px;
                
            }
            
            h2 {
                font-size: 20px;
            }
            
            input[type="text"],
            input[type="password"] {
                font-size: 14px;
                padding: 8px;
            }
            
            button.btn {
                font-size: 14px;
                padding: 8px;
            }
            
            a {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form method="POST" action="">
            <h2>Login</h2>
            <?php if (!empty($message)) echo "<div class='msg'>$message</div>"; ?>
            <div class="input-group">
                <input type="text" name="username" placeholder="Email">
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Mot de passe">
            </div>
            <br>
            <button type="submit" class="btn">Connexion</button>
            <br><br>
            <center><a href="inscription.php">Créer un compte</a></center>
        </form>
    </div>
</body>
</html>
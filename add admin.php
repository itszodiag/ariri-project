<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "inscription_db");

    if ($conn->connect_error) {
        die("Échec de connexion : " . $conn->connect_error);
    }

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $role = 'admin'; // Tous les nouveaux comptes seront admin

    $image_nom = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_ext = pathinfo($image_nom, PATHINFO_EXTENSION);
    $image_new_name = uniqid('profil_', true) . '.' . $image_ext;
    $image_path = "uploads/" . $image_new_name;

    $check = "SELECT * FROM utilisateurs WHERE email='$email'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        $message = "<p class='error'>❌ Email déjà utilisé.</p>";
    } else {
        if (move_uploaded_file($image_tmp, $image_path)) {
            $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, date_naissance, email, mot_de_passe, image, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nom, $prenom, $date_naissance, $email, $mot_de_passe, $image_path, $role);
            
            if ($stmt->execute()) {
                $_SESSION['user'] = [
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'image' => $image_path,
                    'email' => $email,
                    'role' => $role
                ];
                header("Location: interface.php");
                exit();
            } else {
                $message = "<p class='error'>❌ Erreur : " . $conn->error . "</p>";
            }
        } else {
            $message = "<p class='error'>❌ Échec du téléchargement de l'image.</p>";
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription avec Image</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(0, 0, 0);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topnav {
            overflow: hidden;
            background-color: orangered;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: orangered;
            color: white;
        }

        .topnav .icon {
            display: none;
        }

        .container {
            background: white;
            margin: 100px auto 20px;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: black;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            
        }

        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background: rgb(255, 106, 7);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: rgb(0, 0, 0);
        }

        .success {
            color: green;
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            background: #e6ffe6;
            border-radius: 5px;
        }

        .error {
            color: red;
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            background: #ffebeb;
            border-radius: 5px;
        }

        /* Media Queries pour la responsive design */

        /* Tablettes (768px et moins) */
        @media screen and (max-width: 768px) {
            .container {
                margin-top: 80px;
                padding: 25px;
            }
            
            .topnav a:not(:first-child) {
                display: none;
            }
            
            .topnav a.icon {
                float: right;
                display: block;
            }
            
            .topnav.responsive {
                position: relative;
            }
            
            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            
            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }

        /* Smartphones (600px et moins) */
        @media screen and (max-width: 600px) {
            .container {
                width: 85%;
                padding: 20px;
                margin-top: 70px;
            }
            
            h2 {
                font-size: 22px;
            }
            
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="date"],
            input[type="file"] {
                padding: 8px;
                font-size: 14px;
            }
            
            input[type="submit"] {
                padding: 10px;
                font-size: 15px;
            }
        }

        /* Petits smartphones (400px et moins) */
        @media screen and (max-width: 400px) {
            .container {
                width: 90%;
                padding: 15px;
            }
            
            .topnav a {
                padding: 10px 12px;
                font-size: 15px;
            }
            
            h2 {
                font-size: 20px;
            }
            
            label {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="topnav" id="myTopnav">
        <a href="home.html" class="active">Home <i class='bx bx-home-alt'></i></a>
        <a href="about.html">About</a>
        <a href="service.php">Services</a>
        <a href="poject.php">Project</a>
        <a href="contact.php">Contact</a>
        <a href="add project.php">Add Project</a>
        <a href="add admin.php">add admin</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>

    <div class="container">
        <h2>3TINA LMA3LOMAT DIALK</h2>
        
        <?php echo $message; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Nom</label>
            <input type="text" name="nom" required>

            <label>Prénom</label>
            <input type="text" name="prenom" required>

            <label>Date de naissance</label>
            <input type="date" name="date_naissance" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe" required>

            <label>Image de profil</label>
            <input type="file" name="image" accept="image/*" required>

            <input type="submit" value="S'inscrire">
        </form>
    </div>

    <script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
    </script>
</body>
</html>
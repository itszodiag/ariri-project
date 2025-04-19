<?php
session_start();

$message = "Les données ont été enregistrées.";

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
            $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, date_naissance, email, mot_de_passe, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nom, $prenom, $date_naissance, $email, $mot_de_passe, $image_path);
            
            if ($stmt->execute()) {
                $_SESSION['user'] = [
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'image' => $image_path
                ];
                header("Location: interfac.php");
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
    <title>Inscription avec Image</title>
    <style>
        body {
            font-family: Arial;
            background:rgb(0, 0, 0);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background:rgb(255, 106, 7);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background:rgb(0, 0, 0);
        }

        .success {
            color: green;
            text-align: center;
            margin-top: 10px;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
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
</body>
</html>

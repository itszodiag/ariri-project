<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'inscription_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification et récupération des données
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation des champs requis
    if (empty($_POST['title']) || empty($_POST['url']) || empty($_POST['language']) || empty($_FILES['image']['name'])) {
        die("Tous les champs sont obligatoires.");
    }

    // Nettoyage des données
    $title = htmlspecialchars($_POST['title']);
    $url = htmlspecialchars($_POST['url']);
    $language = htmlspecialchars($_POST['language']);

    // Gestion de l'image
    $upload_dir = 'uploads/';
    
    // Crée le dossier s'il n'existe pas
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Vérification des erreurs d'upload
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die("Erreur lors de l'upload de l'image: " . $_FILES['image']['error']);
    }

    // Vérification type et taille
    $allowed_types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $_FILES['image']['tmp_name']);
    finfo_close($finfo);

    if (!array_key_exists($mime_type, $allowed_types)) {
        die("Type de fichier non autorisé. Seuls JPEG, PNG et GIF sont acceptés.");
    }

    if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
        die("Fichier trop volumineux (2Mo max).");
    }

    // Renommer l'image
    $extension = $allowed_types[$mime_type];
    $new_image_name = uniqid('img_', true) . '.' . $extension;
    $target_path = $upload_dir . $new_image_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
        try {
            // Insertion dans la base de données
            $stmt = $pdo->prepare("INSERT INTO projects (title, image, url, language) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $target_path, $url, $language]);

            // Redirection après succès
            header("Location: poject.php"); // Correction du nom du fichier (poject -> project)
            exit;
        } catch (PDOException $e) {
            // Supprimer l'image uploadée en cas d'erreur SQL
            if (file_exists($target_path)) {
                unlink($target_path);
            }
            die("Erreur lors de l'enregistrement en base de données: " . $e->getMessage());
        }
    } else {
        die("Erreur lors de l'upload de l'image.");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Projet</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(0, 0, 0);
            margin: 0;
            padding: 0;
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

        .form-container {
            background: white;
            margin: 100px auto 20px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 90%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="url"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: orangered;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color:rgb(169, 165, 163);
        }
        
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        .project__grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* Media Queries pour la responsive design */

        /* Pour les écrans moyens (tablettes) */
        @media screen and (max-width: 768px) {
            .form-container {
                width: 80%;
                margin-left: auto;
                margin-right: auto;
            }
            
            .topnav a:not(:first-child) {display: none;}
            .topnav a.icon {
                float: right;
                display: block;
            }
            
            .topnav.responsive {position: relative;}
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

        /* Pour les petits écrans (smartphones) */
        @media screen and (max-width: 600px) {
            .form-container {
                width: 90%;
                padding: 20px;
                margin-top: 80px;
            }
            
            h2 {
                font-size: 20px;
            }
            
            input[type="text"],
            input[type="url"],
            input[type="file"],
            select {
                padding: 8px;
                font-size: 14px;
            }
            
            input[type="submit"] {
                padding: 10px;
                font-size: 15px;
            }
        }

        /* Pour les très petits écrans */
        @media screen and (max-width: 400px) {
            .form-container {
                width: 95%;
                padding: 15px;
            }
            
            .topnav a {
                padding: 10px 12px;
                font-size: 15px;
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

<div class="form-container">
    <h2>Ajouter un nouveau projet</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Nom du projet :</label>
        <input type="text" name="title" id="title" required>

        <label for="image">Image :</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <label for="url">URL du projet :</label>
        <input type="url" name="url" id="url" required>

        <label for="language">Langage utilisé :</label>
        <input type="text" name="language" id="language" required>

        <input type="submit" value="Ajouter le projet">
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
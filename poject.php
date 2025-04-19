<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'inscription_db';
$username = 'root';
$password = ''; // ou ton mot de passe MySQL

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Erreur de connexion : " . $e->getMessage());
}

// Traitement de la recherche
$search = isset($_GET['query']) ? $_GET['query'] : '';
$sql = "SELECT * FROM projects";
if (!empty($search)) {
  $sql .= " WHERE language LIKE :search";
}
$stmt = $pdo->prepare($sql);
if (!empty($search)) {
  $stmt->execute(['search' => '%' . $search . '%']);
} else {
  $stmt->execute();
}
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Project</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {
      background-color: #121212;
      color: white;
      margin: 0;
      font-family: Arial, sans-serif;
    }
    
    
    
    .search-container {
      float: right;
      padding: 3px 0px;
      margin-top: 6px;
    }
    
    .search-container input {
      padding: 6px;
      font-size: 17px;
      border: none;
      width: 230px;
      border-radius: 5px;

    }
    
    .search-container button {
      padding: 6px 10px;
      background: #ddd;
      font-size: 17px;
      border: none;
      cursor: pointer;
      border-radius: 0 5px 5px 0;
    }
    
    .search-container button:hover {
      background: #ccc;
    }
    
    /* Projects section */
    .project__container {
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .project__grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    
    .project__card img {
      width: 100%;
      height: auto;
      border-radius: 10px;
      transition: transform 0.3s ease;
    }
    
    .project__card img:hover {
      transform: scale(1.03);
    }
    
    /* Responsive styles */
    @media screen and (max-width: 768px) {
      .topnav a:not(:first-child) {display: none;}
      .topnav a.icon {
        float: right;
        display: block;
      }
      
      .search-container {
        float: none;
        display: block;
        text-align: left;
        width: 100%;
        margin: 0;
        padding: 14px;
      }
      
      .search-container input {
        width: 80%;
      }
    }
    
    @media screen and (max-width: 768px) {
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
      
      .project__grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      }
    }
    
    @media screen and (max-width: 480px) {
      .project__grid {
        grid-template-columns: 1fr;
      }
      
      .search-container input {
        width: 50%;
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
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
  <div class="search-container">
    <form method="GET" action="">
      <input type="text" placeholder="Search by language..." name="query" value="<?= htmlspecialchars($search) ?>">
      <button type="submit"><i class="fa fa-search"></i></button>
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
</div>



<section class="project">
  <div class="project__container">
    <h2><span>Latest</span> Projects</h2>
    <div class="project__grid">
      <?php if ($projects): ?>
        <?php foreach ($projects as $project): ?>
          <div class="project__card">
            <a href="<?= htmlspecialchars($project['url']) ?>" target="_blank">
              <img src="<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>"> 
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No projects found for "<?= htmlspecialchars($search) ?>"</p>
      <?php endif; ?>
    </div>
  </div>
</section>

</body>
</html>
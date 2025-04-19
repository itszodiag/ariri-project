<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "inscription_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Erreur de connexion: " . $conn->connect_error);
}

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$search = strtolower($search);

$sql = "SELECT * FROM services";
if (!empty($search)) {
  $sql = "SELECT * FROM services WHERE LOWER(title) LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Services</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    body {
      background-color: black;
      background-size: cover;
      color: white;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .topnav {
      background-color: orangered;
      overflow: hidden;
    }

    .topnav a {
      float: left;
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }

    .topnav .search-container {
      float: right;
    }

    .topnav .search-container input[type=text] {
      padding: 6px;
      margin-top: 8px;
      font-size: 17px;
      border: none;
      border-radius: 4px 0 0 4px;
    }

    .topnav .search-container button {
      padding: 6px 10px;
      margin-top: 8px;
      background: #ddd;
      font-size: 17px;
      border: none;
      cursor: pointer;
      border-radius: 0 4px 4px 0;
    }

    .topnav .icon {
      display: none;
    }

    @media screen and (max-width: 600px) {
      .topnav a:not(:first-child), .topnav .search-container {
        display: none;
      }

      .topnav a.icon {
        float: right;
        display: block;
      }

      .topnav.responsive {
        position: relative;
      }

      .topnav.responsive a.icon {
        position: absolute;
        right: 0;
        top: 0;
      }

      .topnav.responsive a {
        float: none;
        display: block;
        text-align: left;
      }

      .topnav.responsive .search-container {
        float: none;
        display: block;
        text-align: left;
        width: 100%;
        padding: 10px;
      }

      .topnav.responsive .search-container input[type=text] {
        width: 80%;
        margin-bottom: 10px;
      }

      .topnav.responsive .search-container button {
        width: 18%;
      }
    }

    .section__container {
      padding: 40px 20px;
      text-align: center;
    }

    .section__subtitle {
      font-size: 1.2rem;
      color: #ccc;
    }

    .section__title {
      font-size: 2rem;
      margin-bottom: 30px;
    }

    .section__title span {
      color: orangered;
    }

    .service__grid {
      display: grid;
      gap: 2rem;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      padding: 20px;
    }

    .service__card {
      background-color: #1a1a1a;
      padding: 20px;
      border-radius: 10px;
      transition: transform 0.3s;
    }

    .service__card:hover {
      transform: translateY(-5px);
    }

    .service__card i {
      font-size: 2rem;
      margin-bottom: 10px;
      color: white;
    }

    .read__more {
      color: orangered;
      display: inline-block;
      margin-top: 10px;
      text-decoration: underline;
    }
    
  </style>
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
</head>
<body>

  <div class="topnav" id="myTopnav">
    <a href="home.html" class="active">Home <i class='bx bx-home-alt'></i></a>
    <a href="about.html">About</a>
    <a href="service.php">Services</a>
    <a href="poject.php">Project</a>
    <a href="contact.php">Contact</a>
    <div class="search-container">
      <form action="" method="GET">
        <input type="text" placeholder="Search..." name="q" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
  <br>
  <section class="service">
    <div class="section__container service__container">
      <p class="section__subtitle">What I Offer!</p>
      <h2 class="section__title"><span>My</span> Services</h2>
      <div class="service__grid">

        <?php
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $icon = "ri-service-line";
            if (stripos($row["title"], "design") !== false) {
              $icon = "ri-smartphone-line";
            } elseif (stripos($row["title"], "development") !== false) {
              $icon = "ri-code-s-slash-line";
            } elseif (stripos($row["title"], "creative") !== false) {
              $icon = "ri-edit-2-line";
            }

            echo "<div class='service__card'>";
            echo "<i class='$icon'></i>";
            echo "<h4>" . htmlspecialchars($row["title"]) . "</h4>";
            echo "<p>" . htmlspecialchars($row["description"]) . "</p>";
            echo "<a  href='" . htmlspecialchars($row["link"]) . "' class='read__more' >Read more...</a>";
            echo "</div>";
          }
        } else {
          echo "<p>Aucun service trouvé.</p>";
        }

        $conn->close();
        ?>

      </div>
    </div>
  </section>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css"
      rel="stylesheet">
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      body{
        background-color: var(--primary-color);
        background-size: 1000% 1000%;
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
  <footer>
    <div class="section__container footer__container">
      <div class="footer__content">
        <h2 class="section__title">Contact <span>Me!</span></h2>
        <p class="section__subtitle">If you have any project in your mind</p>
        <div class="footer__details">
          <p>
            You can reach me through the contact form provided on this
            website. Simply fill out the form with your name, email address,
            and message, and I will get back to you as soon as possible.
          </p>
          <p>CASABLANCA</p>
          <p>ISTA NTIC-SIDI MAAROF</p>
          <p>MOROCCO</p>
          <p>aririayman0@gmail.com</p>
        </div>
        <div class="social__icons">
          <a href="https://web.facebook.com/profile.php?id=61566249420266" class="icon"><i class="ri-facebook-fill"></i></a>
          <a href="https://github.com/zodiag08" class="icon"><i class='bx bxl-github'></i></a>
          <a href="https://www.instagram.com/itszodiag/" class="icon"><i class='bx bxl-instagram'></i></a>
        </div>
      </div>
      <footer>
      <?php
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;
$idea = $_POST['idea'] ?? null;

if ($name && $email && $idea) {
  $servername = "localhost";
  $username = "root"; 
  $password = "";      
  $dbname = "inscription_db";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    $error = "Connection failed: " . $conn->connect_error;
  } else {
    $sql = "INSERT INTO contact_messages (name, email, phone, idea) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $idea);

    if ($stmt->execute()) {
      $success = "Message envoyé avec succès !";
    } else {
      $error = "❌ Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
  }
} else {
  $error = " Tous les champs obligatoires ne sont pas remplis.";
}
}
?>
     
    <form class="footer__form" method="POST" action="">
      <input type="text" name="name" placeholder="Your Name" required />
      <input type="email" name="email" placeholder="Your Email Address" required />
      <input type="text" name="phone" placeholder="Your Phone Number" />
      <textarea name="idea" cols="30" rows="10" placeholder="Your Idea" required></textarea>
      <button type="submit" class="btn">Send Message</button>

      <?php if (!empty($success)) : ?>
        <p class="message success"><?= $success ?></p>
      <?php endif; ?>

      <?php if (!empty($error)) : ?>
        <p class="message error"><?= $error ?></p>
      <?php endif; ?>
    </form>
  </div>
</footer>
</body>
</html>
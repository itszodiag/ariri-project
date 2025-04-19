<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}


$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Web Design </title>
    <style>


.container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg,rgb(0, 0, 0),rgb(0, 0, 0));
    padding: 35px;
    
    max-width: 1250px;
    margin: auto;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    color: white;
    font-family: 'Segoe UI', sans-serif;
}

.welcome-text {
    font-size: 1.2rem;
    width: 20%;
}

.profile-pic {
    border-radius: 50%;
    width: 60px;
    height: 60px;
    border: 3px solid white;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    object-fit: cover;
}


@media (max-width: 768px) {
    .container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .welcome-text {
        width: 100%;
        margin-bottom: 15px;
    }

    .profile-pic {
        margin: 0 auto;
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
    </div><br>
    <div class="container">
    <span class="welcome-text">Hello, <?php echo htmlspecialchars($user['prenom']); ?>!</span>
    <img class="profile-pic" src="<?php echo $user['image']; ?>" alt="Photo de profil">
</div>
    <header>
      <div class="section__container header__container">
        <p><span>Hello</span> I'm</p>
        <h1>AYMEN</h1>
        <h2 class="section__title" >UI/UX <span>Designer.</span></h2>
        <p>
          Welcome to my web developer portfolio! I'm Aymen, a skilled and
          creative web developer with a passion for creating beautiful,
          responsive, and user-friendly websites. I've worked on a variety of
          web projects, ranging from personal blogs to e-commerce platforms.
        </p>
        <div class="action__btns">
          <a href="test.php"><button class="btn">Entrer <i class='bx bx-user'></i></button></a>
          <a href="https://www.youtube.com/playlist?list=PLXC_gcsKLD6n7p6tHPBxsKjN5hA_quaPI" class="video">
            <div class="play">
              <i class="ri-play-fill"></i>
            </div>
            <span>Watch My Video</span>
          </a>
        </div>
      </div>
    </header>
    <section class="about">
      <div class="section__container about__container">
        <div class="about__image">
          <img src="about-bg.jpg" alt="about" />
        </div>
        <div class="about__content">
          <h2 class="section__title">About <span>Me</span></h2>
          <p class="section__subtitle">Creative UI/UX Designer!</p>
          <p class="about__details">
            As a UI/UX designer, I specialize in creating user interfaces and
            experiences for digital products. I have extensive experience
            working with product managers, developers, and other stakeholders to
            gather requirements, create wireframes and prototypes, and conduct
            user testing to ensure that the final product meets the needs of the
            users. Throughout my career, I have achieved several milestones,
            including designing successful digital products that have received
            positive feedback from users and stakeholders.
          </p>
          
        </div>
      </div>
    </section>

    <section class="service">
      <div class="section__container service__container">
        <p class="section__subtitle">What I Offer!</p>
        <h2 class="section__title"><span>My</span> Services</h2>
        <div class="service__grid">
          <div class="service__card">
            <i class="ri-smartphone-line"></i>
            <h4>Web Design</h4>
            <p>
              We are dedicated to providing high-quality web design services
              that are tailored to meet the specific needs of our clients.
            </p>
            <a href="web design.html" class="read__more">Read more...</a>
          </div>
          <div class="service__card">
            <i class="ri-code-s-slash-line"></i>
            <h4>Web Development</h4>
            <p>
              We use the latest web technologies and development tools to create
              websites that are fast, secure, and scalable.
            </p>
            <a href="Web Development.html" class="read__more">Read more...</a>
          </div>
          <div class="service__card">
            <i class="ri-edit-2-line"></i>
            <h4>Creative Design</h4>
            <p>
              Our approach is collaborative, and we encourage your feedback
              throughout the design process to ensure that we are meeting your
              expectations.
            </p>
            <a href="Creative Design.html" class="read__more">Read more...</a>
          </div>
        </div>
      </div>
    </section>

    <section class="project">
      <div class="section__container project__container">
        <p class="section__subtitle">Portfolio</p>
        <h2 class="section__title"><span>Latest</span> Project</h2>
        <div class="project__grid">
          <div class="project__card">
            <a href=" https://zodiag08.github.io/khouchali-chaimae/"><img src="babe1.png" alt="project"/></a>
          </div>
          <div class="project__card">
            <a href="https://zodiag08.github.io/aya-jnane/"><img src="movie.png" alt="project" /></a>
          </div>
          <div class="project__card">
            <a href="https://zodiag08.github.io/qatar-nada/"><img src="mike up.png" alt="project" />
            </div></a>
          <div class="project__card">
            <a href="https://zodiag08.github.io/faresibrahim/"><img src="shop.png" alt="project" /></a>
          </div>
          <div class="project__card">
            <img src="project-5.png" alt="project" />
          </div>
          <div class="project__card">
            <img src="project-6.png" alt="project" />
          </div>
        </div>
      </div>
    </section>

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
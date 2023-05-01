<?php
require_once 'config.php';
session_start();

$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Utilisateur introuvable.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $birthday = trim($_POST["birthday"]);
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Vérifiez si le nom d'utilisateur est unique
    $sql = "SELECT * FROM users WHERE username = :username AND id <> :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id', $_SESSION['id']);
    $stmt->execute();

    if ($stmt->fetch()) {
        echo "Le nom d'utilisateur existe déjà.";
        exit();
    }

    // Mettez à jour les informations de l'utilisateur
    if (!empty($password)) {
        // Hachez le mot de passe
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, birthday = :birthday, email = :email, username = :username, password = :password WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':password', $password_hash);
    } else {
        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, birthday = :birthday, email = :email, username = :username WHERE id = :id";
        $stmt = $conn->prepare($sql);
    }

    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':birthday', $birthday);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id', $_SESSION['id']);

    if ($stmt->execute()) {
        header("Location: profile.php");
    } else {
        echo "Erreur lors de la mise à jour du profil.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>HeroBiz Bootstrap Template - Home 1</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Variables CSS Files. Uncomment your preferred color scheme -->
  <link href="assets/css/variables.css" rel="stylesheet">
  <!-- <link href="assets/css/variables-blue.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-green.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-orange.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-purple.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-red.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-pink.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: HeroBiz
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/herobiz-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>


<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top" data-scrollto-offset="0">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>HeroBiz<span>.</span></h1>
      </a>

    
      <?php
          include 'nav.php' ;
          ?>
    </div>
  </header><!-- End Header -->

  <main id="main">
 

  <section id="about" class="about">
  <h1>Modifier le profil de <?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?></h1>

  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container bootstrap snippets bootdeys">
<div class="row">
  <div class="col-xs-12 col-sm-9">
    <form class="form-horizontal" action="modifier_profil.php" method="post">
        <div class="panel panel-default">
          <div class="panel-body text-center">
           <img src="https://bootdey.com/img/Content/avatar/avatar6.png" class="img-circle profile-avatar" alt="User avatar">
          </div>
        </div>
      <div class="panel panel-default">
        <div class="panel-heading">
        <h4 class="panel-title">User info</h4>
        </div>
        <div class="panel-body">
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Prénom : </label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nom :</label>
            <div class="col-sm-10">
            <input type="text" name="last_name"class="form-control" id="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Date de naissance :</label>
            <div class="col-sm-10">
            <input type="date" name="birthday" class="form-control"id="birthday" value="<?php echo htmlspecialchars($user['birthday']); ?>" required>
            </div>
          </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label">Adresse e-mail :</label>
            <div class="col-sm-10">
            <input type="email" name="email" class="form-control"id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
          </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Nom d'utilisateur :</label>
            <div class="col-sm-10">
            <input type="text" name="username" class="form-control" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
          </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Mot de passe :</label>
            <div class="col-sm-10">
            <input type="password" name="password" class="form-control" id="password">
            </div>
          </div><br>
          <button type="submit" class="form-control" >Enregistrer les modifications</button>
        </div>
       
      </div>
    </form>
  </div>
</div>
</div>
  </section>
    
  </main>
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-content">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>HeroBiz</h3>
              <p>
                A108 Adam Street <br>
                NY 535022, USA<br><br>
                <strong>Phone:</strong> +1 5589 55488 55<br>
                <strong>Email:</strong> info@example.com<br>
              </p>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="footer-legal text-center">
      <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div class="copyright">
            &copy; Copyright <strong><span>HeroBiz</span></strong>. All Rights Reserved
          </div>
          <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
          </div>
        </div>

        <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
          <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>

      </div>
    </div>

  </footer><!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

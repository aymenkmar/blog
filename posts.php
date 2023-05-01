<?php
        session_start();
        // Check if user is logged in
        if(!isset($_SESSION["username"])){
            header("Location: index.php");
            exit();
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
<style>
  .g-height-50 {
    height: 50px;
}

.g-width-50 {
    width: 50px !important;
}

@media (min-width: 0){
    .g-pa-30 {
        padding: 2.14286rem !important;
    }
}

.g-bg-secondary {
    background-color: #fafafa !important;
}

.u-shadow-v18 {
    box-shadow: 0 5px 10px -6px rgba(0, 0, 0, 0.15);
}

.g-color-gray-dark-v4 {
    color: #777 !important;
}

.g-font-size-12 {
    font-size: 0.85714rem !important;
}

.media-comment {
    margin-top:20px
}
</style>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top" data-scrollto-offset="0">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>HeroBiz<span>.</span></h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.php">Home</a></li>
          <?php 
          echo '<li><a href="posts.php">Posts</a></li>';
          if((isset($_SESSION["first_name"]))){
      
            $link = $_GET["link"];
            if($link == "logout")
            {
              session_start();
              session_unset();
              session_destroy();
              header("Location: index.php");
              exit();
            }
            echo ' <a href="index.php?link=logout">Logout</a></li>';
           
           }else{
           
           echo '<li><a class="nav-link scrollto" href="login.php">Login</a></li>
           <li><a class="nav-link scrollto" href="register.php">Register</a></li>';
           
           }
          ?>
          
          <li><a class="nav-link scrollto" href="index.html#contact">Contact</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle d-none"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->

  <main id="main">
  <section id="about" class=" container about">
    <div class="row">
      <div class="col-md-6">
  <h1>Ajouter une publication</h1>
    <form action="ajouter_publication.php" method="post">
    <input type="text" name="title" class="form-control" placeholder="Titre" required><br>
    <textarea name="content" class="form-control" placeholder="Quoi de neuf ?" rows="4" cols="50" required></textarea><br>
    <button type="submit" class="form-control" name="submit">Publier</button>
  </form>
  </div>
  </div>
          </section>
  <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Posts Page</h2>
          <?php if(isset($error)) { ?>
        <div><?php echo '<p>'.$error.'</p>' ;?></div>
    <?php } ?>
        </div>
        <div class="row g-4 g-lg-5" data-aos="fade-up" data-aos-delay="200">
          <div class="col-lg-12">
		
          <?php
  require_once 'config.php';

$sql = "SELECT publications.*, users.first_name, users.last_name FROM publications LEFT JOIN users ON publications.user_id = users.id where users.id = ".$_SESSION["id"]." ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();

 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class="media g-mb-30 media-comment">';
    echo '<div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">';
    echo '<div class="g-mb-15">';

    if ($row['first_name'] !== NULL && $row['last_name'] !== NULL) {
        if ($row['updated_at'] !== NULL) {
            echo '<h5 class="h5 g-color-gray-dark-v1 mb-0"><small>Modifié par ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) . ' le ' . $row['updated_at'] . '</small></h5>';
        } else {
            echo '<h5 class="h5 g-color-gray-dark-v1 mb-0"><small>Publié par ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) . ' le ' . $row['created_at'] . '</small></h5>';
        }
    } else {
        if ($row['updated_at'] !== NULL) {
            echo '<h5 class="h5 g-color-gray-dark-v1 mb-0"><small>Modifié le ' . $row['updated_at'] . '</small></h5>';
        } else {
            echo '<h5 class="h5 g-color-gray-dark-v1 mb-0"><small>Publié le ' . $row['created_at'] . '</small></h5>';
        }
    }
    echo '</div>';
    echo '<p>' . htmlspecialchars($row['title']) . '</p>';
    echo '<p>' . htmlspecialchars($row['content']) . '</p>';
    echo '<ul class="list-inline d-sm-flex my-0">';
    echo '<li class="list-inline-item g-mr-20">';
    echo '<a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!">';
    echo '<i class="fa fa-thumbs-up g-pos-rel g-top-1 g-mr-3"></i>
        178
        </a>
    </li>';
    echo '<li class="list-inline-item g-mr-20">';
    echo '<a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!">';
    echo '<i class="fa fa-thumbs-down g-pos-rel g-top-1 g-mr-3"></i>
        34
        </a>
    </li>';

    if (isset($_SESSION['id']) && $_SESSION['id'] == $row['user_id']) {
        echo '<li class="list-inline-item g-mr-20">';
        echo '<a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="modifier_publication.php?id=' . $row['id'] . '">';
        echo '<i class="fa fa-pencil g-pos-rel g-top-1 g-mr-3"></i>
            Modifier
            </a>
        </li>';
    }

    echo '</ul>';
    echo '</div>';
    echo '</div>';
}
  
  ?>
        </div>

      </div>
    </section><!-- End About Section -->
    
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
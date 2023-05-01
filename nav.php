<?php

?>
 <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.php">Home</a></li>
          <?php 
          
          if((isset($_SESSION["login_active"]))){
            session_start();
            echo '<li><a href="posts.php">Posts</a></li>';
            echo ' <a href="logout.php">Logout</a></li>';
           
           }else{
           
           echo '<li><a class="nav-link scrollto" href="login.php">Login</a></li>
           <li><a class="nav-link scrollto" href="register.php">Register</a></li>';
           
           }
          ?>
          
          <li><a class="nav-link scrollto" href="index.html#contact">Contact</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle d-none"></i>
      </nav><!-- .navbar -->
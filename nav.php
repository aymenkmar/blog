<?php

?>
 <nav id="navbar" class="navbar">
        <ul>
          
          <?php 
          
          if((isset($_SESSION["login_active"]))){
            echo'<li><a class="nav-link scrollto" href="welcome.php">Home</a></li>';
            echo '<li><a href="posts.php">Posts</a></li>';
            echo '<li><a href="profile.php">Profile</a></li>';
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
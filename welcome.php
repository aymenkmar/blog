<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <?php
        session_start();
        // Check if user is logged in
        if(!isset($_SESSION["username"])){
            header("Location: login.php");
            exit();
        }
    ?>

    <h1>Welcome, <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?>!</h1>

    <p>You have successfully logged in.</p>
    
    //ajouter publication
     <h1>Ajouter une publication</h1>
    <form action="ajouter_publication.php" method="post">
    <input type="text" name="title" placeholder="Titre" required><br>
    <textarea name="content" placeholder="Quoi de neuf ?" rows="4" cols="50" required></textarea><br>
    <button type="submit" name="submit">Publier</button>
  </form>

  <h1>Publications</h1>
<?php
  require_once 'config.php';

  $sql = "SELECT * FROM publications ORDER BY created_at DESC";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<div>";
    echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
    echo "<p>" . htmlspecialchars($row['content']) . "</p>";
    echo "<small>" . $row['created_at'] . "</small>";
    echo "</div>";
  }
  ?>

    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
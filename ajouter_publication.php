<?php
require_once 'config.php';

if (isset($_POST['submit'])) {
  $title = $_POST['title'];
  $content = $_POST['content'];

  try {
    $sql = "INSERT INTO publications (title, content) VALUES (:title, :content)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);

    $stmt->execute();

    header("Location: " . $_SERVER['HTTP_REFERER']);
  } catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
  }
}
?>
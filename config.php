<?php
$host = 'localhost';
$dbname = 'blog_db';
$username = 'root';
$password = 'Amine123!';

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Erreur de connexion: " . $e->getMessage();
}
?>


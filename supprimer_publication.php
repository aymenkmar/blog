<?php
require_once 'config.php';
session_start();
if (isset($_GET['id'])) {
    $publication_id = $_GET['id'];

    $sql = "SELECT * FROM publications WHERE post_id = :id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $publication_id);
    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->execute();
    $publication = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$publication) {
        echo "Publication introuvable ou accès non autorisé.";
        exit();
    }

    try {
        $sql = "DELETE FROM publications WHERE post_id = :id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $publication_id);
        $stmt->bindParam(':user_id', $_SESSION['id']);
        $stmt->execute();

        header("Location: posts.php");
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
} else {
    header("Location: welcome.php");
}
?>

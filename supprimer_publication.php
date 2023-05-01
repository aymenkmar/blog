<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION["id"];

    try {
        $sql = "DELETE FROM publications WHERE id = :id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        header("Location: welcome.php");
        exit();
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}
?>

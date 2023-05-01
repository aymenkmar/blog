<?php
require_once 'config.php';


if (isset($_POST['submit'])) {
    $user_id = $_SESSION["id"];
    $title = $_POST['title'];
    $content = $_POST['content'];

    try {
        $sql = "INSERT INTO publications (user_id, title, content) VALUES (:user_id, :title, :content)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);

        $stmt->execute();

        header("Location: " . $_SERVER['HTTP_REFERER']);
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}
?>

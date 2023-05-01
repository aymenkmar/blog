<?php
require_once 'config.php';
session_start();
if (isset($_POST['likeme'])) {
    $id = $_POST['post_id'];
    $likes = $_POST['likes']+1;
    try {
        $sql = "UPDATE `publications` SET `likes`='$likes' WHERE `post_id`='$id'"; 
     
        $result = $conn->query($sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}
if (isset($_POST['dislikeme'])) {
    $id = $_POST['post_id'];
    $dislikes = $_POST['dislikes']+1;
    try {
        $sql = "UPDATE `publications` SET `dislikes`='$dislikes' WHERE `post_id`='$id'"; 
        $result = $conn->query($sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}
?>

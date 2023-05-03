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

// Retrieve number of likes and dislikes for the publication
$id = $_GET['id'];
$sql = "SELECT `likes`, `dislikes` FROM `publications` WHERE `post_id`='$id'";
$result = $conn->query($sql);
if ($result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $likes = $row['likes'];
    $dislikes = $row['dislikes'];
} else {
    $likes = 0;
    $dislikes = 0;
}
?>

<!-- Display number of likes and dislikes on the page -->
<p>Likes: <?php echo $likes; ?></p>
<p>Dislikes: <?php echo $dislikes; ?></p>

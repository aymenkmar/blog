<?php
session_start();

require_once 'config.php';

if (isset($_POST['report']) && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Update report count for post
    $sql = "UPDATE publications SET reports = reports + 1 WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$post_id]);

    // Check if post has reached 3 reports
    $sql = "SELECT reports FROM publications WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$post_id]);
    $reports = $stmt->fetchColumn();

    if ($reports >= 3) {
        // Remove post from view
        $sql = "UPDATE publications SET visible = 0 WHERE post_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$post_id]);
    }
}
?>

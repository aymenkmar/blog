<?php
session_start();

require_once 'config.php';

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Récupération de l'ID de la publication à signaler
$post_id = $_GET['id'];

// Incrémentation du nombre de signalements pour cette publication
$sql = "UPDATE publications SET reports = reports + 1 WHERE post_id = $post_id";

if ($conn->query($sql) === TRUE) {
    echo "La publication a été signalée avec succès";
} else {
    echo "Erreur lors du signalement de la publication: " . $conn->error;
}

// Vérification du nombre de signalements pour cette publication
$sql = "SELECT reports FROM publications WHERE post_id = $post_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $reports = $row["reports"];
    if ($reports >= 3) {
        // Cacher la publication si elle a été signalée plus de 3 fois
        $sql = "UPDATE publications SET content = '[Contenu masqué]' WHERE post_id = $post_id";
        if ($conn->query($sql) === TRUE) {
            echo "La publication a été masquée car elle a été signalée plus de 3 fois";
        } else {
            echo "Erreur lors de la mise à jour de la publication: " . $conn->error;
        }
    }
}

// Fermeture de la connexion
$conn->close();
?>

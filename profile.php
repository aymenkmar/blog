<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Utilisateur introuvable.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS and JavaScript files here -->
</head>
<body>
    <!-- Your navigation bar and other page elements -->

    <h1>Profil de <?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?></h1>

    <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['first_name']); ?></p>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['last_name']); ?></p>
    <p><strong>Date de naissance :</strong> <?php echo htmlspecialchars($user['birthday']); ?></p>
    <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($user['username']); ?></p>

</body>
</html>

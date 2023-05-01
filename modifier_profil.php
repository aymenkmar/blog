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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $birthday = trim($_POST["birthday"]);
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Vérifiez si le nom d'utilisateur est unique
    $sql = "SELECT * FROM users WHERE username = :username AND id <> :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id', $_SESSION['id']);
    $stmt->execute();

    if ($stmt->fetch()) {
        echo "Le nom d'utilisateur existe déjà.";
        exit();
    }

    // Mettez à jour les informations de l'utilisateur
    if (!empty($password)) {
        // Hachez le mot de passe
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, birthday = :birthday, email = :email, username = :username, password = :password WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':password', $password_hash);
    } else {
        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, birthday = :birthday, email = :email, username = :username WHERE id = :id";
        $stmt = $conn->prepare($sql);
    }

    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':birthday', $birthday);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id', $_SESSION['id']);

    if ($stmt->execute()) {
        header("Location: profile.php");
    } else {
        echo "Erreur lors de la mise à jour du profil.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS and JavaScript files here -->
</head>
<body>
    <!-- Your navigation bar and other page elements -->

    <h1>Modifier le profil de <?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?></h1>

    <form action="modifier_profil.php" method="post">
        <div>
            <label for="first_name">Prénom :</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>
        <div>
            <label for="last_name">Nom :</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        </div>
        <div>
            <label for="birthday">Date de naissance :</label>
            <input type="date" name="birthday" id="birthday" value="<?php echo htmlspecialchars($user['birthday']); ?>" required>
        </div>
        <div>
            <label for="email">Adresse e-mail :</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Enregistrer les modifications</button>
    </form>

    <!-- Your footer and other page elements -->
</body>
</html>

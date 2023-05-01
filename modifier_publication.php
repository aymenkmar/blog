<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve publication info
    try {
        $sql = "SELECT * FROM publications WHERE id = :id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $_SESSION['id']);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            header("Location: welcome.php");
            exit();
        }

        $publication = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
} else {
    header("Location: welcome.php");
    exit();
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update publication info
    try {
        $sql = "UPDATE publications SET title = :title, content = :content WHERE id = :id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $_SESSION['id']);
        $stmt->execute();

        header("Location: welcome.php");
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier publication</title>
</head>
<body>
    <h1>Modifier publication</h1>
    <form action="modifier_publication.php?id=<?php echo $publication['id']; ?>" method="post">
        <input type="text" name="title" placeholder="Titre" value="<?php echo htmlspecialchars($publication['title']); ?>" required><br>
        <textarea name="content" placeholder="Quoi de neuf ?" rows="4" cols="50" required><?php echo htmlspecialchars($publication['content']); ?></textarea><br>
        <button type="submit" name="submit">Enregistrer</button>
    </form>
</body>
</html>


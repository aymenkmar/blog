<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $publication_id = $_GET['id'];

    $sql = "SELECT * FROM publications WHERE post_id = :post_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $publication_id);
    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->execute();
    $publication = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$publication) {
        echo "Publication introuvable ou accès non autorisé.";
        exit();
    }

    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        try {
            $sql = "UPDATE publications SET title = :title, content = :content, updated_at = NOW() WHERE post_id = :post_id AND user_id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':post_id', $publication_id);
            $stmt->bindParam(':user_id', $_SESSION['id']);

            $stmt->execute();

            header("Location: posts.php");
        } catch(PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
} else {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la publication</title>
</head>
<body>
<h1>Modifier la publication</h1>
<form action="modifier_publication.php?id=<?php echo $publication_id; ?>" method="post">
    <input type="text" name="title" placeholder="Titre" value="<?php echo htmlspecialchars($publication['title']); ?>" required><br>
    <textarea name="content" placeholder="Quoi de neuf ?" rows="4" cols="50" required><?php echo htmlspecialchars($publication['content']); ?></textarea><br>
    <button type="submit" name="submit">Mettre à jour</button>
</form>
</body>
</html>
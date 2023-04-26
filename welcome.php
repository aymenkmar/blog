<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <?php
        session_start();
        // Check if user is logged in
        if(!isset($_SESSION["username"])){
            header("Location: login.php");
            exit();
        }
    ?>

    <h1>Welcome, <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?>!</h1>

    <p>You have successfully logged in.</p>

    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>
</html>

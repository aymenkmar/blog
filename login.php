<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php
    session_start();

    // Check if the user is already logged in
    if(isset($_SESSION["username"])) {
        header("Location: welcome.php");
        exit();
    }

    // Process the login form when submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the login credentials from the form
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Connect to the database
        $host = "localhost";
        $user = "root";
        $pass = "0123456789+aZ";
        $dbname = "blog_db";
        $conn = mysqli_connect($host, $user, $pass, $dbname);

        // Check if the connection was successful
        if(!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve the user's information from the database
        $sql = "SELECT id, first_name, last_name FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) == 1) {
            // If the login credentials are correct, store the user's information in the session
            $row = mysqli_fetch_assoc($result);
            $_SESSION["id"] = $row["id"];
            $_SESSION["username"] = $username;
            $_SESSION["first_name"] = $row["first_name"];
            $_SESSION["last_name"] = $row["last_name"];

            // Redirect the user to the welcome page
            header("Location: welcome.php");
            exit();
        } else {
            // If the login credentials are incorrect, display an error message
            $error = "Invalid username or password";
        }

        // Close the database connection
        mysqli_close($conn);
    }
    ?>

    <?php if(isset($error)) { ?>
        <div><?php echo $error; ?></div>
    <?php } ?>

    <form method="post">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register</a></p>
</body>
</html>

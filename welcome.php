<?php
    session_start();
    // Check if user is logged in
    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit();
    }

    // Check if the user has submitted the publication form
    if(isset($_POST["submit_publication"])){
        // Code to save the publication in the database
        // ...
    }
?>

<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?></h1>

    <form method="post" action="">
        <label for="publication_type">Publication Type:</label>
        <select name="publication_type" id="publication_type">
            <option value="text">Text</option>
            <option value="photo">Photo</option>
        </select>
        <br><br>
        <label for="publication_content">Publication Content:</label>
        <textarea name="publication_content" id="publication_content"></textarea>
        <br><br>
        <input type="submit" name="submit_publication" value="Add Publication">
    </form>

    <?php
        // Display the user's publications
        $user_id = $_SESSION["user_id"];

        // Connect to the database
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dbname = "myDB";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve the user's publications from the database
        $sql = "SELECT * FROM publications WHERE user_id='$user_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Your Publications:</h2>";
            // Display the user's publications
            while($row = mysqli_fetch_assoc($result)) {
                echo "<p>" . $row["publication_content"] . "</p>";
            }
        } else {
            echo "<p>No publications found.</p>";
        }
        
        
        
        // Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Get the publication type and data from the form submission
$publication_type = $_POST['publication_type'];
$publication_data = $_POST['publication_data'];

// Insert the publication data into the database
$sql = "INSERT INTO publications (user_id, publication_type, publication_data) 
        VALUES ('$user_id', '$publication_type', '$publication_data')";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Publication was successfully saved to the database
} else {
    // Error saving publication to the database
}


        mysqli_close($conn);
    ?>

</body>
</html>


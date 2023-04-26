<!DOCTYPE html>
<html>
<head>
	<title>Registration Page</title>
</head>
<body>
	<h2>Register</h2>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<label for="first_name">First Name:</label>
		<input type="text" id="first_name" name="first_name" required><br><br>
		<label for="last_name">Last Name:</label>
		<input type="text" id="last_name" name="last_name" required><br><br>
		<label for="birthday">Birthday:</label>
		<input type="date" id="birthday" name="birthday" required><br><br>
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required><br><br>
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" required><br><br>
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required><br><br>
		<label for="confirm_password">Confirm Password:</label>
		<input type="password" id="confirm_password" name="confirm_password" required><br><br>
		<input type="submit" value="Register">
	</form>

	<?php
	// Check if the form was submitted
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		// Retrieve the form data
		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];
		$birthday = $_POST["birthday"];
		$email = $_POST["email"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$confirm_password = $_POST["confirm_password"];

		// Validate the form data
		if($password !== $confirm_password) {
			echo "Password and confirmation password do not match.";
			exit();
		}

		// Connect to the MySQL database
		$host = "localhost";
		$user = "root";
		$password_db = "0123456789+aZ";
		$database = "blog_db";
		$conn = mysqli_connect($host, $user, $password_db, $database);

		// Check if the connection was successful
		if(mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit();
		}

		// Check if the username already exists
		$sql = "SELECT * FROM users WHERE username='$username'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0) {
			echo "Username already exists.";
			exit();
		}

		// Insert the new user into the database
		$sql = "INSERT INTO users (first_name, last_name, birthday, email, username, password) VALUES ('$first_name', '$last_name', '$birthday', '$email', '$username', '$password')";
		if(mysqli_query($conn, $sql)) {
			echo "Account created successfully. Redirecting to login page...";
			header("Refresh: 3; url=login.php");
			exit();
		} else {
			echo "Error: " . mysqli_error($conn);
		}

		// Close the database connection
		mysqli_close($conn);
	}
	?>
</body>
</html>


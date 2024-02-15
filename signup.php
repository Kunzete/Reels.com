<?php 
    include_once 'Assets/config.php';

    if (isset($_POST['submit'])) {
    
        // Validate and sanitize input data
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        if (!$name || !$username || !$email || !$password) {
            echo "<script>alert('Invalid input! Please provide valid information.')</script>";
            // You may want to redirect the user back to the signup page here.
            exit;
        }
    
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Check if the username is already in use
        $checkUsernameQuery = "SELECT * FROM `users` WHERE `username` = '$username'";
        $checkUsernameResult = $conn->query($checkUsernameQuery);
    
        if ($checkUsernameResult->num_rows > 0) {
            echo "<script>alert('Username is already in use! Please choose a different username.')</script>";
            // You may want to redirect the user back to the signup page here.
        }else{
            $checkEmailQuery = "SELECT * FROM `users` WHERE `email` = '$email'";
            $checkEmailResult = $conn->query($checkEmailQuery);

            if ($checkEmailResult->num_rows > 0) {
                echo "<script>alert('Email is already in use! Head to Login page...')</script>";
                // You may want to redirect the user back to the signup page here.
            }else{
                // Assuming $conn is your database connection
                $sql = "INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`) 
                VALUES (NULL, '$name', '$username', '$email', '$hashedPassword')";
                $result = $conn->query($sql);
            
                if ($result) {
                    echo "<script>window.location.href = 'signin.php'</script>";
                    exit;
                } else {
                    echo "<script>alert('We are having some problems! Please try again later.')</script>";
                }
            }
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="signup-container">
        <div class="signup-header">
            <h2>Signup</h2>
        </div>
        <form class="signup-form" action="#" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <input type="checkbox" id="show" onclick=Show()>
            <label for="password">Show Password</label>

            <br>
            <br>
            <div class="form-group">
                <button type="submit" name="submit">Sign Up</button>
            </div>
            <a href="signin.php">Already have an account?</a>
        </form>
    </div>

    <script src="app.js"></script>
</body>
</html>

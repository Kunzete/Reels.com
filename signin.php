<?php 

    include_once 'Assets/config.php';

    if (isset($_POST['submit'])) {
    
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $checkUserQuery = "SELECT * FROM `users` WHERE `username` = '$username'";
        $checkUserResult = $conn->query($checkUserQuery);
    
        if ($checkUserResult->num_rows > 0) {
            $user = $checkUserResult->fetch_assoc();
            session_start();
            $_SESSION['user_id'] = $user['id']; 
            
            // Verify the entered password against the hashed password
            if (password_verify($password, $user['password'])) {
                // Password is correct, you can redirect to a secure page
                header("Location: index.php");
                exit;
            } else {
                echo "<script>alert('Incorrect password! Please try again.')</script>";
            }
        } else {
            echo "<script>alert('Username not found! Please check your username and try again.')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="signup-container">
        <div class="signup-header">
            <h2>Login</h2>
        </div>
        <form class="signup-form" action="#" method="post">

            <div class="form-group">
                <label for="username">Username/Email</label>
                <input type="text" id="username" name="username" required>
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
                <button type="submit" name="submit">Login</button>
            </div>
            <a href="signup.php">Don't have an account? Sign up now!</a>
        </form>
    </div>

    <script src="app.js"></script>
</body>
</html>
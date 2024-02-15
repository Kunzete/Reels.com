<?php
include_once 'Assets/config.php'; // Include your database connection script

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Retrieve user details based on the token from the database
    $stmt = $conn->prepare("SELECT * FROM password_reset WHERE token = ? AND expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Token is valid, allow the user to reset the password
    } else {
        echo "Invalid or expired token.";
        exit;
    }
} else {
    echo "Token not provided.";
    exit;
}

// Handle password update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the new password
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        // Update the user's password in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $userId = $user['user_id']; // Use the user ID retrieved from the database

        $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $updateStmt->bind_param("si", $hashedPassword, $userId);

        if ($updateStmt->execute()) {
            // Password updated successfully, remove the token from the password_reset table
            $deleteStmt = $conn->prepare("DELETE FROM password_reset WHERE user_id = ?");
            $deleteStmt->bind_param("i", $userId);
            $deleteStmt->execute();

            echo "Password updated successfully!";
        } else {
            echo "Error updating password.";
        }
    } else {
        echo "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <h2>Reset Password</h2>
    <form method="post" action="">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <input type="submit" value="Reset Password">
    </form>
</body>

</html>

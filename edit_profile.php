<?php
// edit_profile.php
include_once 'Assets/config.php';
session_start();

// Check if the user is logged in. If not, redirect them to the login page.
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'signin.php'</script>";
    exit;
}


$userID = $_SESSION['user_id'];

// Check if the form is submitted
if (isset($_POST['update_profile'])) {
    // Validate and sanitize input data
    $newName = $_POST['new_name'];
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];

    // You can add more validation as needed

    if (!isset($newPassword)) {

        $updateProfileQuery = "UPDATE `users` SET `name`='$newName', `username`='$newUsername' WHERE `id`='$userID'";
        $updateResult = $conn->query($updateProfileQuery);

        if ($updateResult) {
            echo "<script>alert('Profile updated successfully.')</script>";
            // You might want to redirect the user to their updated profile or another page
        } else {
            echo "<script>alert('Error updating profile.')</script>";
        }

    } else {
        // Hash the new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update user information in the database
        $updateProfileQuery = "UPDATE `users` SET `name`='$newName', `username`='$newUsername', `password`='$hashedNewPassword' WHERE `id`='$userID'";
        $updateResult = $conn->query($updateProfileQuery);

        if ($updateResult) {
            echo "<script>alert('Profile updated successfully.')</script>";
            // You might want to redirect the user to their updated profile or another page
        } else {
            echo "<script>alert('Error updating profile.')</script>";
        }
    }
}

// Retrieve the current user's profile information
$getProfileQuery = "SELECT * FROM `users` WHERE `id` = '$userID'";
$getProfileResult = $conn->query($getProfileQuery);

if ($getProfileResult->num_rows === 1) {
    $user = $getProfileResult->fetch_assoc();
} else {
    // Handle the case where the user is not found (this should not happen in a well-structured system)
    echo "User not found";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #222;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #111;
            color: #fff;
            text-align: center;
            padding: 1em;
        }

        main {
            max-width: 600px;
            margin: 20px auto;
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            background-color: #444;
            color: #fff;
            border: 1px solid #666;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #111;
            color: #fff;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>

<body>
    <header>
        <a href="index.php">Reels.com</a>
    </header>
    <main>
        <form method="post" action="">
            <label>Name: <input type="text" name="new_name" value="<?php echo $user['name']; ?>" required></label>
            <label>Username: <input type="text" name="new_username" value="<?php echo $user['username']; ?>"
                    required></label>
            <label>New Password: <input type="password" name="new_password"></label>
            <input type="submit" name="update_profile" value="Update Profile">
        </form>
        <p><a href="profile.php">Back to Profile</a></p>
        <p><a href="logout.php">Logout</a></p>
    </main>
</body>

</html>
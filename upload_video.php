<?php
include_once 'Assets/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

$userID = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_video'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle video file upload
    $videoUploadDir = "uploads/videos/";
    $videoFileName = $videoUploadDir . basename($_FILES['video_file']['name']);
    $videoFileType = strtolower(pathinfo($videoFileName, PATHINFO_EXTENSION));
    $maxFileSize = 10 * 1024 * 1024; // 10 MB

    // Validate video file type and size
    if ($videoFileType != "mp4" && $videoFileType != "mkv") {
        echo "<script>alert('Sorry, only MP4 and MKV files are allowed.')</script>";
    } elseif ($_FILES['video_file']['size'] > $maxFileSize) {
        echo "<script>alert('Sorry, the file size exceeds the maximum limit (10 MB).')</script>";
    } else {
        // Move uploaded video file to destination
        move_uploaded_file($_FILES['video_file']['tmp_name'], $videoFileName);

        // Insert video information into the database
        $insertVideoQuery = "INSERT INTO `videos` (`id`, `title`, `description`, `video_filename`)
                             VALUES ('$userID', '$title', '$description', '$videoFileName')";
        $insertResult = $conn->query($insertVideoQuery);

        if ($insertResult) {
            echo "<script>alert('Video uploaded successfully.')</script>";
        } else {
            echo "<script>alert('Error uploading video.')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <!-- Add your stylesheet link or embed your styles here -->
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #222;
        color: #fff;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    header {
        background-color: #111;
        color: #fff;
        padding: 1em;
    }

    form {
        max-width: 600px;
        margin: 20px auto;
        background-color: #333;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    }

    label {
        display: block;
        margin-bottom: 10px;
        color: #fff;
    }

    input[type="text"],
    textarea,
    input[type="file"] {
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
        padding: 10px;
        border: none;
        border-radius: 4px;
    }

    a {
        text-decoration: none;
        color: #fff;
    }

    p {
        margin-top: 20px;
    }
</style>

<body>
    <h2>Upload Video</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Description: <textarea name="description"></textarea></label><br>
        <label>Video File: <input type="file" name="video_file" accept="video/mp4, video/mov" required></label><br>
        <input type="submit" name="upload_video" value="Upload Video">
    </form>
    <p><a href="profile.php">Back to Profile</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>

</html>
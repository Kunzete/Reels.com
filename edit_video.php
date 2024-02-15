<?php
// edit_profile.php
include_once 'Assets/config.php';
session_start();

// Check if the user is logged in. If not, redirect them to the login page.
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'signin.php'</script>";
    exit;
}

if (isset($_GET['video_id'])) {

    $userID = $_SESSION['user_id'];
    $videoID = $_GET['video_id'];

    $sql = "SELECT * FROM videos WHERE video_id='$videoID' AND id = '$userID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }else{
        if (isset($_SESSION['user_id'])) {
            echo "<script>window.location.href = 'profile.php'</script>";
        }else{
            echo "<script>window.location.href = 'index.php'</script>";
        }
    }


    if (isset($_POST['update_video'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $sql = "UPDATE `videos` SET `title` = '$title', `description` = '$description' WHERE `videos`.`video_id` = '$videoID' AND id = '$userID';";
        $result = $conn->query($sql);

        if ($result) {
            echo "<script>alert('video updated successfully')</script>";
        }else{
            echo "<script>alert('Video update failed due to'" . mysqli_error($conn) . ")</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit video</title>
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
            <label>Video Title <input type="text" name="title" value="<?php echo $row['title']; ?>" required></label>
            <label>Video Description <input type="text" name="description" value="<?php echo $row['description']; ?>"required></label>
            <input type="submit" name="update_video" value="Update video">
        </form>
        <p><a href="profile.php">Back to Profile</a></p>
    </main>
</body>

</html>
<?php
// profile.php
include_once 'Assets/config.php';
include_once 'Assets/header.php';

// Check if the user is logged in. If not, redirect them to the login page.

// Retrieve user data from the database based on the user's ID stored in the session
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            overflow-y: scroll;
            font-family: 'Roboto', sans-serif;
            user-select: none;
        }

        a {
            text-decoration: none;
            color: #fff;
        }

        .video-thumbnail {
            display: flex;
            flex-direction: row;
            justify-content: start;
            align-items: start;
            padding: 0;
            border-radius: 12px;
            width: 100%;
            height: 100%;
            overflow-wrap: break-word;
            border: 0.2em #181818 solid;

            video {
                height: auto;
                border-top-left-radius: 10px;
                border-bottom-left-radius: 10px;
            }

            .inline-div {
                /* Align text at start */
                width: 50%;
                padding-left: 5%;
                padding-top: 2%;
                background-color: transparent !important;
                height: 100%;
                width: 100%;
                border-top-right-radius: 10px;
                border-bottom-right-radius: 10px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding-bottom: 5%;

                .inline-edit button {
                    background-color: transparent !important;
                    cursor: pointer;
                    border: none;
                    border: 0.2em #181818 solid;
                    color: #0087ca;
                    border-radius: 10px;
                    height: 40px;
                    width: 40px;
                    font-size: 16px;
                    margin: 0px 5px;
                }

                .inline-edit a {
                    background-color: transparent !important;
                    cursor: pointer;
                    border: none;
                    border: 0.2em #181818 solid;
                    color: #0087ca;
                    border-radius: 10px;
                    height: 40px;
                    width: 40px;
                    font-size: 16px;
                    margin: 0px 5px;
                    padding: 7.5px;
                }

                h2 {
                    margin: 5% 0px;
                }
            }
        }

        .videos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            place-items: center;
            padding: 2% 12px;
        }


        #video-container {
            background-color: #0f0f0f;
            padding: 8% 25px;
            height: 100vh;
        }

        #video-container h3 {
            margin-bottom: 10px;
        }

        .video-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 10px;
        }

        .username {
            padding: 7% 0px 0px 0px;
            width: 100%;
            text-align: center;
        }

        @media (max-width: 768px) and (min-width: 320px) {
            .username {
                padding: 30% 0px 5% 0px;
            }

            .videos {
                grid-template-columns: repeat(1, 1fr);
                gap: 20px;
                place-items: center;
            }
                
            .video-thumbnail video{
            	 height: 200px;
                    width: 150px;
            }
        }
    </style>
</head>

<body>
    <?php 

    $username = $_GET['username'];

    // Retrieve videos uploaded by the current user
    $getVideosQuery = "SELECT users.username, videos.* 
    FROM users 
    JOIN videos ON users.id = videos.id WHERE username = '$username'";
    $getVideosResult = $conn->query($getVideosQuery);
    ?>

    <div class="username">
        <h2>
            <?php echo $username ?>
        </h2>
    </div>
    <div class="videos">
        <?php
        if ($getVideosResult->num_rows > 0) {
            $dialogIndex = 1;
            while ($video = $getVideosResult->fetch_assoc()) {
                echo '<div class="video-thumbnail">';
                echo '<video width="150" height="300" controls>';
                echo '<source src="' . $video['video_filename'] . '" type="video/mp4">';
                echo 'Your browser does not support the video tag.';
                echo '</video>';
                echo '<div class="inline-div">';
                echo '<div class="inline-header">';
                echo '<h2>' . $video['title'] . '</h2>';
                echo '<p>' . $video['description'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
    </div>

</body>

</html>
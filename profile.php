<?php

include_once 'Assets/header.php';
include_once 'Assets/config.php';

$userSession = $_SESSION['user_id'];


// Retrieve user data from the database based on the user's ID stored in the session

// Retrieve videos uploaded by the current user
$getVideosQuery = "SELECT * FROM `videos` WHERE `id` = '$userSession'";
$getVideosResult = $conn->query($getVideosQuery);

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
        dialog {
            text-align: center;
            background-color: #004b71 !important;
            padding: 50px;
            border-radius: 12px;
            border: none;
            width: 25vw;
            margin: 35vh 38vw;

            h4 {
                color: white;
            }

            .button_div {
                padding: 10px 0px;
            }

            .button_div a {
                border: 1px white solid;
                border-radius: 5px;
                padding: 5% 10px;
                margin: 0px 5px;
            }
        }


        body {
            overflow-y: scroll;
            font-family: 'Roboto', sans-serif;
            user-select: none;
        }

        body::-webkit-scrollbar {
            width: 2px;
            background-color: white;
        }

        body::-webkit-scrollbar-thumb {
            color: green;
            background-color: aqua;
        }

        body::-webkit-scrollbar-track {
            background-color: white;
        }

        form {
            margin-bottom: 20px;
            margin-top: 2%;
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

                .inline-edit {
                    display: flex;
                }

                .inline-edit .show,
                .close {
                    background-color: transparent !important;
                    cursor: pointer;
                    border: none;
                    border: 0.2em #181818 solid;
                    color: #0087ca;
                    border-radius: 10px;
                    height: 50px;
                    width: 50px;
                    text-align: center;
                    font-size: 16px;
                    margin: 0px 5px;
                    padding: 12px 0px;
                }

                h2 {
                    margin: 5% 0px;
                }
            }
        }

        .videos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* 3 columns with equal width */
            gap: 20px;
            place-items: center;
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

        /* Media query for smaller screens */
        @media (max-width: 768px) and (min-width: 320px) {
            #video-container {
                padding: 25% 10px;
            }

            .video-thumbnail {
                min-width: 95vw;
            }

            .inline-edit {
                display: flex;
            }

            dialog {

                text-align: center;
                background-color: #740112;
                padding: 50px;
                border-radius: 12px;
                width: 80vw;
                margin: 25vh 10%;
            }

            .videos {
                display: grid;
                grid-template-columns: repeat(1, 1fr);
                /* 3 columns with equal width */
                gap: 20px;
                place-items: center;
            }
        }
    </style>
</head>

<body>

    <div id="video-container">
        <div class="video-head">
            <h3>Your Videos</h3>
            <a href="./upload_video.php">
                <h3>Upload Video <span><i class="fa-regular fa-square-plus"></i></span></h3>
            </a>
        </div>

        <div class="videos">
            <?php
            if ($getVideosResult->num_rows > 0) {
                $videoIndex = 1;
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
                    echo '<div class="inline-edit">';
                    echo '<dialog id="' . $videoIndex . '">
                            <h4>Are you sure you want to delete "' . $video['title'] . '" </h4></br></br>
                            <div class="button_div">
                                <a class="dialog-button" href="delete_video.php?video_id=' . $video['video_id'] . '">YES</a>
                                <a class="dialog-button" href="profile.php" class="close" id="close">NO</a>
                            </div>
                          </dialog>';
                    echo '<a class="show" data-dialog="' . $videoIndex . '"><i class="fa-solid fa-trash"></i></a>';
                    echo '<a href="edit_video.php?video_id=' . $video['video_id'] . '" class="close" data-dialog="' . $videoIndex . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $videoIndex++;
                }
            }
                
               
            ?>
        </div>


        <form method="post" action="./edit_profile.php">
            <input type="submit" value="Edit Profile">
        </form>

        <p><a href="logout.php">Logout</a></p>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const showButtons = document.querySelectorAll(".show");
            const closeButtons = document.querySelectorAll(".close");

            showButtons.forEach(showButton => {
                showButton.addEventListener('click', function () {
                    const dialogId = this.getAttribute('data-dialog');
                    const dialog = document.getElementById(dialogId);
                    dialog.showModal();
                });
            });

            closeButtons.forEach(closeButton => {
                closeButton.addEventListener('click', function () {
                    const dialogId = this.getAttribute('data-dialog');
                    const dialog = document.getElementById(dialogId);
                    dialog.close();
                });
            });
        });
    </script>

</body>

</html>
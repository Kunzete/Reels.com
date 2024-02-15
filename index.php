<?php
    include_once 'Assets/header.php'; include_once 'Assets/config.php'

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reels | Upload & View</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<style>
    .info a {
        display: flex;
        justify-content: start;
        align-items: center;
        margin-top: 0px;
        padding-top: 0px;
        padding-bottom: 10px;

        img {
            padding: 0 5px 0px 0px;
        }

    }

    .no-vid {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 22%;
        padding-left: 20px;
        height: 100%
    }
</style>

<body>

    <div class="reels" id="reelsContainer">
        <?php

        $sql = "SELECT users.username, videos.* 
        FROM users 
        JOIN videos ON users.id = videos.id ORDER BY RAND()";
        $result = $conn->query($sql);

        // Check if there are videos
        if ($result->num_rows > 0) {
            $videoIndex = 1; // Counter for assigning unique IDs to video elements
            while ($row = $result->fetch_assoc()) {
                $videoOwner = $row['username'];
                $videoDescription = $row['description'];
                $videoTitle = $row['title'];
                $videoFilename = $row['video_filename']; // Adjust the path
        
                // Display each video thumbnail with a link to open the video modal
                echo '<section class="video-thumbnail" id="Reel/' . $videoIndex . '/">';
                echo
                    '<div class="info">'
                    . '<a style=" font-family: Arial, Helvetica, sans-serif;" href="public_profile.php?username=' . $videoOwner . '"><img style="background-color:black; border-radius:100px; border: 0.05em lime solid; padding:0px; margin: 0px 5px 0px 0px;" src="Assets/Profilepic.png" height="40px"><h3> ' . $videoOwner . '</h3></a>'
                    . '<h4 style=" font-family: Arial, Helvetica, sans-serif;">' . $videoTitle . '</h4>'
                    . '<p>' . $videoDescription . '</p>'
                    . '</div>';
                echo '<video autoplay="autoplay" id="reel_video" loop class="reel_vid"
                style="position: relative; height: 55%; content: "";"';
                echo '<source src="' . $videoFilename . '" type="video/mp4">'; // Adjust the type if necessary
                echo '</video>';
                echo '</section>';

                $videoIndex+=1;

            }
        } else {
            // If there are no videos, display a message
            echo
                '<div class="no-vid">
                <p style="color: white;">No videos available</p>
            </div>';
        }

        $index = 1;

        ?>

    </div>

    <div class="buttons">
        <a href="#" id="prevLink"><i class="fa-solid fa-circle-arrow-up"></i></a>
        <a href="#" id="nextLink"><i class="fa-solid fa-circle-arrow-down"></i></a>
    </div>

    <script>
        function handleVideoIntersection(entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Play the video when it comes into view
                    entry.target.play();
                } else {
                    // Pause the video when it goes out of view
                    entry.target.pause();
                }
            });
        }

        const observer = new IntersectionObserver(handleVideoIntersection, { threshold: 0.2 });

        // Attach the observer to all video elements in the reels container
        const videoElements = document.querySelectorAll('.video-thumbnail video');
        videoElements.forEach(video => {
            observer.observe(video);
        });

        var index = 1; // Starting index

        // Function to scroll to the target section based on index
        function scrollToSection(sectionIndex) {
            var targetSection = document.getElementById('Reel/' + sectionIndex + '/');
            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Event listener for clicking the links
        document.getElementById('prevLink').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default link behavior
            if (index > 1) {
                index--; // Decrement the index if not at the first section
                scrollToSection(index); // Scroll to the target section
            }
        });

        document.getElementById('nextLink').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default link behavior
            var totalSections = document.querySelectorAll('section').length;
            if (index < totalSections) {
                index++; // Increment the index if not at the last section
                scrollToSection(index); // Scroll to the target section
            }
        });

        function scrollToTop(sectionIndex) {
            var targetSection2 = document.getElementById('Reel/1/');
            if (targetSection2) {
                targetSection2.scrollIntoView({ behavior: 'smooth' });
            }
        }

        if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
            setTimeout(function () {
                scrollToTop(1);
            }, 300);
        }

        // Get all video elements on the page
        const videos = document.querySelectorAll('.reel_vid');

        // Add click event listener to each video
        videos.forEach(video => {
            video.addEventListener('click', () => {
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
            });
        });

    </script>
</body>

</html>
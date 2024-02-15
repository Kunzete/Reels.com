<?php 

require_once 'Assets/config.php';

if (isset($_GET['video_id'])) {
    $video = $_GET['video_id'];


    $sql = "DELETE FROM videos WHERE video_id = '$video'";
    $result = $conn->query($sql);

    if ($result) {
        header('location: profile.php');
    }
}
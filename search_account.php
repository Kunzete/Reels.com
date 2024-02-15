<?php
    include_once 'Assets/config.php';
	include_once 'Assets/header.php';
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
    }
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
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

    nav{
        position: fixed;
        width: 100vw;
    }
    .section{
        padding: 10% 30%;
        background-color: #0f0f0f;
        min-height  : 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .userlist{
        background-color: black;
        border: 0.2em #0087ca solid;
        border-radius: 12px;
        padding: 30px;
        display: flex;
        flex-direction: column;
        min-height: auto;
        justify-content: center;
        align-items: center;
        min-width: 40vw;

        h2{
            text-align: center;
        }
        h2:hover{
            text-decoration: underline;
            text-decoration-color: #0087ca;
            text-underline-offset: 5px;
        }
        ul li{
            text-decoration: none;
            list-style: none;
            font-size: 20px;
            margin: 5% 0% 0px 0%;
            text-align: start;
            display: flex;
            justify-content: start;
            align-items: center;
            border: 0.2em #181818 solid;
            border-radius: 50px;
            padding: 5px 10px;

            a{
                display: flex;
                justify-content: center;
                align-items: center;

                span{
                    margin: 0px 6px;
                }
            }
        }
        .no-user{
            text-align: center;
            padding: 5% 0px;
        }
    }
</style>

<body>


    <div class="section">
        <div class="userlist">
            <h2>Userlist</h2>
            <ul id='users'>
                <?php 
                    $sql =  "SELECT * FROM `users` WHERE `username` = '$username'";
                    $result= $conn->query($sql);

                    if ($result->num_rows >0) {
                        while ($row = $result->fetch_assoc()) {
                            $uname = $row['username'];
                ?>
                    <li><a href="public_profile.php?username=<?php echo $uname?>"><img src="Assets/Profilepic.png" height="40px" alt=""><span><?php echo $row['username']?></span></a></li>
                <?php
                        }
                    }else{
                        echo '<h3 class="no-user">No user found...👻</h3>';
                    }
                ?>
        </div>
    </div>


</body>

</html>
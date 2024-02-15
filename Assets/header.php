<?php session_start();
error_reporting(0);
include_once 'config.php';
?>

<nav>
    <div class="heading">
        <a href="index.php">
            <h1 class="hover-underline-animation">Reels.com</h1>
        </a>
    </div>

    <div class="search-box">
        <button class="btn-search"
            onclick="location.href='search_account.php?username='+document.getElementById('username').value"><i
                class="fas fa-search" name="submit"></i></button>
        <input type="text" id="username" class="input-search" placeholder="Search username...">
    </div>

    <?php
    if (isset($_SESSION['user_id'])) {
        $uid = $_SESSION['user_id'];
        $sql = "SELECT * FROM users WHERE `id` = '$uid'";
        $result = $conn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            ?>
            <div class="account">
                <a href="Reels.com/../profile.php">
                    <?php echo $row['name'] ?> <span><i class="fa-solid fa-user"></i></span>
                </a>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="account">
            <a href="Reels.com/../signin.php">Signin <span><i class="fa-solid fa-user-plus"></i></span></a>
        </div>
        <?php
    }
    ?>

    <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn">
            <i class="fa fa-bars"></i>
        </button>
        <div class="dropdown-content" id="myDropdown">
            <ul>
                <li>
                    <div class="search-box2">
                        <button class="btn-search2"
                            onclick="location.href='search_account.php?username='+document.getElementById('drop-username').value"><i
                                class="fas fa-search" name="submit"></i></button>
                        <input type="text" id="drop-username" class="input-search2" placeholder="Search username...">
                    </div>
                </li>
                <li>

                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $uid = $_SESSION['user_id'];
                        $sql = "SELECT * FROM users WHERE `id` = '$uid'";
                        $result = $conn->query($sql);

                        if ($result) {
                            $row = $result->fetch_assoc();
                            ?>
                            <div class="account2">
                                <a href="Reels.com/../profile.php">
                                    <?php echo $row['name'] ?> <span><i class="fa-solid fa-user"></i></span>
                                </a>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="account2">
                            <a href="Reels.com/../signin.php">Signin <span><i class="fa-solid fa-user-plus"></i></span></a>
                        </div>
                        <?php
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>

</nav>

<script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

</script>
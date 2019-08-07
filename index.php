<?php
require_once 'kapcs.php';
session_start();
$session = "";
if (!isset($_SESSION['id'])) {
    if (isset($_COOKIE['name']) && isset($_COOKIE['id'])) {
        $_SESSION['name'] = $_COOKIE['name'];
        $_SESSION['id'] = $_COOKIE['id'];
        $session = $_SESSION['name'];
    }
} else {
    $session = $_SESSION['name'];
}
$query1 = "SELECT * FROM mismatch_user m ORDER BY m.join_date DESC ";
$result = mysqli_query($kapcs, $query1) or die ($query1);
?>
<!DOCTYPE html>
<html lang="hu-HU">
<head>
    <meta charset="UTF-8">
    <title>Mismatch - Where opposites attract!</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Mismatch - Where opposites attract!</h1>
    <div class="container">
        <div>
            <br>
        </div>
        <div><img src="sziv.jpg" width="20"/><a href="view.php"> View Profile</a></div>
        <div><img src="sziv.jpg" width="20"/><a href="edit.php"> Edit Profile</a></div>
        <?php
        if (!empty($session)){
            ?>
            <div><img src="sziv.jpg" width="20"/><a href="logout.php"> Log out (<?php echo($_SESSION['name']) ?>) </a>
            </div>
            <div><br></div>
            <p><strong>Latest members</strong></p>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                $tomb[] = $row;
            }
            for ($i = 0;
                 $i < count($tomb);
                 $i++) {
                $last_name = $tomb[$i]['last_name'];
                $fajl = $tomb[$i]['picture'];
                echo "<div class='row'>";
                echo '<div class="col-6 col-sm-2 "><img src="' . target_dir . $fajl . '" alt="score image" height="80px" width="80px" ></div>';
                echo '<div class=\"col-6 col-sm-2 row align-self-center mr-3\"><a href="people.php?id='.$tomb[$i]['user_id'] .'" >' . $last_name . '</a></div>';
                echo "</div>";
            }
        }
        else {
            ?>
            <div><img src="sziv.jpg" width="20"/><a href="login.php"> Log in </a></div>
            <div><img src="sziv.jpg" width="20"/><a href="sign_up.php"> Sign Up</a>
            </div>
            <div><br></div>
            <p><strong>Latest members</strong></p>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                $tomb[] = $row;
            }
            for ($i = 0;
                 $i < count($tomb);
                 $i++) {
                $last_name = $tomb[$i]['last_name'];
                $fajl = $tomb[$i]['picture'];
                echo "<div class='row'>";
                echo '<div class="col-6 col-sm-2 "><img src="' . target_dir . $fajl . '" alt="score image" height="80px" width="80px" ></div>';
                echo "<div class=\"col-6 col-sm-2 row align-self-center mr-3\">$last_name</div>";
                echo "</div>";
            }
        }
        mysqli_close($kapcs);
        ?>
    </div>
</body>
</html>
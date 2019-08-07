<?php
require_once 'kapcs.php';
session_start();
if (!isset($_SESSION['id'])) {
    if (isset($_COOKIE['name']) && isset($_COOKIE['id'])) {
        $_SESSION['name'] = $_COOKIE['name'];
        $_SESSION['id'] = $_COOKIE['id'];
        $session = $_SESSION['name'];
        $query2 = "SELECT * FROM mismatch_user WHERE username='$session'";
        $result = mysqli_query($kapcs, $query2) or die ($query2);
    }
} else {
    $session = $_SESSION['name'];
    $query2 = "SELECT * FROM mismatch_user WHERE username='$session'";
    $result = mysqli_query($kapcs, $query2) or die ($query2);
}
?>

<!DOCTYPE html>
<html lang="hu-HU">
<head>
    <meta charset="UTF-8">
    <title>Mismatch - View Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h6>You are loged in as  <?php echo($_SESSION['name']) ?> <a href="logout.php">Log out </a></h6>
    <h1>Mismatch - View Profile</h1>
    <div class="container">
        <div>
            <br>
        </div>

        <?php
        $row = mysqli_fetch_array($result);
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $gender = $row['gender'];
        $birthdate = $row['birthdate'];
        $location = $row['city'] . ", " . $row['state'];
        $fajl = $row['picture'];
        echo "<div class='row'>";
        echo "<div  class=\"col-6 col-sm-2\"><strong>First name: </strong></div>";
        echo "<div class=\"col-6 col-sm-2\">$first_name</div>";
        echo "<div class='w-100'></div>";
        echo "<div  class=\"col-6 col-sm-2\"><strong>Last name: </strong></div>";
        echo "<div class=\"col-6 col-sm-2\">$last_name</div>";
        echo "<div class='w-100'></div>";
        echo "<div  class=\"col-6 col-sm-2\"><strong>Gender: </strong></div>";
        echo "<div class=\"col-6 col-sm-2\">$gender</div>";
        echo "<div class='w-100'></div>";
        echo "<div  class=\"col-6 col-sm-2\"><strong>Birthdate: </strong></div>";
        echo "<div class=\"col-6 col-sm-2\">$birthdate</div>";
        echo "<div class='w-100'></div>";
        echo "<div  class=\"col-6 col-sm-2\"><strong>Location: </strong></div>";
        echo "<div class=\"col-6 col-sm-2\">$location</div>";
        echo "<div class='w-100'></div>";
        echo "<div  class=\"col-6 col-sm-2  align-self-center mr-3\"><strong>Picture: </strong></div>";
        echo '<div class="col-6 col-sm-2 row align-self-center mr-3"><img src="' . target_dir . $fajl . '" alt="score image" height="80px" width="80px" ></div>';
        echo "</div>";
        echo "<br>";
        echo "<p>Would you like to <a href='edit.php'>edit your profile</a> or back to the  <a href='index.php'>first page?</a></p>";
        mysqli_close($kapcs);
        ?>

    </div>
</div>
</body>
</html>

<?php
require_once 'kapcs.php';
session_start();
?>
<!DOCTYPE html>
<html lang="hu-HU">
<head>
    <meta charset="UTF-8">
    <title>Mismatch - Log In</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Mismatch - Log In</h1>
    <div class="container">
        <br>
        <h6>Please enter your username and password to log in to Mismacht.</h6>
        <br>
    </div>
<?php
if(!isset($_SESSION['id']) ) {
    if (isset($_POST['submit'])) {
        $uname = mysqli_real_escape_string($kapcs, trim($_POST['user_name']));
        $pw = mysqli_real_escape_string($kapcs, trim($_POST['pass']));
        if (empty($uname) || empty($pw)) {
            echo '<div class="container">';
            echo '<h6>Nem töltöttél ki minden mezőt!</h6>';
            echo '</div>';
        } else {
            $query1 = "SELECT m.username, m.user_id FROM mismatch_user m WHERE m.username = '$uname' AND m.pass = SHA('$pw')";
            $result = mysqli_query($kapcs, $query1);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result);
                $username = $row['username'];
                $uid = $row['user_id'];
                $_SESSION['name']="$username";
                $_SESSION['id']="$uid";
                setcookie('name', "$username", time() + 60*60*24*30);
                setcookie('id', "$uid", time() + 60*60*24*30);
                header('Location: \Projects\headfirstkonyv4\index.php');
                echo "<div class='container'><h6>You are loged in as " . $_COOKIE['name'] . " .</h6></div>";
            } else {
                echo '<div class="container">';
                echo '<h6>Sorry, you must enter valid user name and password to access this page.</h6>';
                echo '</div>';
            }
        }
    }
}
    else{
        header('Location: \Projects\headfirstkonyv4\index.php');
    }
?>
    <div>
        <form action="login.php" method="post">
            <fieldset class="border p-2">
                <legend class="w-auto">Log In</legend>
                <div class='row'>
                    <label class="col-2 col-sm-2, strong">Username: </label>
                    <input class="col-2 col-sm-2" type="text" name="user_name" size="18%">
                    <div class='w-100'></div>
                    <label class="col-2 col-sm-2, strong">Password: </label>
                    <input class="col-2 col-sm-2" type="password" name="pass" size="18%">
                </div>
            </fieldset>
            <input class="btn btn-primary" type="submit" name="submit" value="Log In">
        </form>
    </div>
</div>
</body>
</html>
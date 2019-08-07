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
?>
<!DOCTYPE html>
<html lang="hu-HU">
<head>
    <meta charset="UTF-8">
    <title>Mismatch - Edit Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h6>You are loged in as  <?php echo($_SESSION['name']) ?> </h6>
    <h1>Mismatch - Edit Profile</h1>
    <div class="container">
        <div>
            <br>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            $first_name = mysqli_real_escape_string($kapcs, trim($_POST['fname']));
            $last_name = mysqli_real_escape_string($kapcs, trim($_POST['lname']));
            $gender = mysqli_real_escape_string($kapcs, trim($_POST['gender']));
            $birthdate = mysqli_real_escape_string($kapcs, trim($_POST['birthdate']));
            $location = explode(",", mysqli_real_escape_string($kapcs, trim($_POST['location'])));
            $city1 = mysqli_real_escape_string($kapcs, trim($location[0]));
            $state1 = mysqli_real_escape_string($kapcs, trim($location[1]));
            $fajl1 = $_FILES['file']['name'];
            $target_file = target_dir . basename($_FILES["file"]["name"]);
            $txtFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (!empty($fajl1)) {
                if ($txtFileType != "jpeg" && $txtFileType != "gif" && $txtFileType != "png" && $txtFileType != "jpg") {
                    echo "JPG vagy GIF formátumot tölthetsz csak fel.<br>";
                } else if ($_FILES["file"]["size"] > 500000) {
                    echo "Túl nagy fájl.<br>";
                } else {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                        $query = "UPDATE mismatch.mismatch_user SET
                first_name = '$first_name',
                last_name = '$last_name',
                gender = '$gender',
                birthdate = '$birthdate',
                city = '$city1',
                state = '$state1',
                picture = '$fajl1'
                WHERE username='$session'";
                        $result1 = mysqli_query($kapcs, $query) or die ($query);
                    } else {
                        echo "Sikertelen feltöltés.";
                    }
                }
            } else {
                $query3 = "UPDATE mismatch.mismatch_user SET
                first_name = '$first_name',
                last_name = '$last_name',
                gender = '$gender',
                birthdate = '$birthdate',
                city = '$city1',
                state = '$state1'
                WHERE username='$session'";
                $result2 = mysqli_query($kapcs, $query3) or die ($query3);
            }
        }
        $query2 = "SELECT * FROM mismatch_user WHERE username='$session'";
        $result = mysqli_query($kapcs, $query2) or die ($query2);
        $row = mysqli_fetch_array($result);
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $gender = $row['gender'];
        $birthdate = $row['birthdate'];
        $location = $row['city'] . ", " . $row['state'];
        $fajl = $row['picture'];
        ?>
        <div>
            <form action="edit.php" enctype="multipart/form-data" method="post">
                <div><img src="sziv.jpg" width="20"/><a href="index.php">Index</a></div>
                <div><img src="sziv.jpg" width="20"/><a href="view.php"> View Profile</a></div>
                <br>
                <fieldset class="border p-2">
                    <legend class="w-auto">Personal Information</legend>
                    <div class='row'>
                        <label class="col-2 col-sm-2, strong">First name: </label>
                        <input class="col-2 col-sm-2" type="text" name="fname" size="18%"
                               value="<?php echo $first_name; ?>">
                        <div class='w-100'></div>
                        <label class="col-2 col-sm-2, strong">Last name: </label>
                        <input class="col-2 col-sm-2" type="text" name="lname" size="18%"
                               value="<?php echo $last_name; ?>">
                        <div class='w-100'></div>
                        <label class="col-2 col-sm-2, strong">Gender: </label>
                        <select name="gender" value="<?php echo $gender; ?>">
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                        <div class='w-100'></div>
                        <label class="col-2 col-sm-2, strong">Birthdate: </label>
                        <input class="col-2 col-sm-2" type="date" name="birthdate"
                               value="<?php echo $birthdate; ?>">
                        <div class='w-100'></div>
                        <label class="col-2 col-sm-2, strong">Location: </label>
                        <input class="col-2 col-sm-2" type="text" name="location" size="18%"
                               value="<?php echo $location; ?>"><br>
                        <div class='w-100'></div>
                        <label class="col-2 col-sm-2, strong">Picture: </label>
                        <input type="file" name="file">
                        <img src="<?php echo target_dir . $fajl; ?>" width="10%" height="10%">
                    </div>
                </fieldset>
                <input class="btn btn-primary" type="submit" name="submit" value="Save Profile">
            </form>
        </div>
    </div>
</div>
</body>
</html>
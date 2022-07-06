<?php 
include_once "../config/connection.php";
if (!is_authentic()) {
    header("location:" . URL . "index.php");
    exit;
}
$fnameErr = $lnameErr = $emailErr =  "";
$fname = $lname = $email  = "";
$id = $_SESSION["sg"]["user_id"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!preg_match("/^[a-zA-Z]{1,}$/", $conn->real_escape_string($_POST["fname"]))) {
        $fnameErr = "Invalid user name:Only characters are allowed";
    } else {
        $fname =  $conn->real_escape_string($_POST["fname"]);
    }
    if (!preg_match("/^[a-zA-Z]{1,}$/", $conn->real_escape_string($_POST["lname"]))) {
        $lnameErr = "Invalid user name:Only characters are allowed";
    } else {
        $lname =  $conn->real_escape_string($_POST["lname"]);
    }
    if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",  $conn->real_escape_string($_POST["email"]))) {
        $emailErr = "Invalid email";
    } else {
        $email = $conn->real_escape_string($_POST["email"]);
    }


    if ($fnameErr == "" && $lnameErr == "" && $emailErr == ""  && $_POST["csrf_token"] == $_SESSION['sg']["token"]) {
        $stmt = $conn->prepare("UPDATE  users set firstname=? ,lastname=? ,email=? where user_id=? ");
        $stmt->bind_param("sssi", $fname, $lname, $email, $id);
        $executed = $stmt->execute();

        if ($executed == true && $conn->affected_rows > 0) {
            header("location: " . URL . "users/user_profile.php");
        }
    }
}



if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $stmt = $conn->prepare("SELECT firstname, lastname,email FROM users where user_id=?");
    $stmt->bind_param("i", $id);
    $executed = $stmt->execute();
    $result=$stmt->get_result();
    $row = $result->fetch_assoc();
    $fname =  htmlspecialchars($row["firstname"]);
    $lname = htmlspecialchars( $row["lastname"]);
    $email =  htmlspecialchars($row["email"]);
}

?>


    <?php include_once "../include/header.php" ?>
    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div class=" col-sm-6 col-md-3 ">
                <form action="" class="form-container1" method="POST" onsubmit="return profile_edit()">
                    <div class="form-group">
                        <label for="Inputname1">First Name:</label>
                        <input type="text" placeholder="First Name" class="form-control" id="Inputname1" name="fname" value="<?php echo $fname; ?>">
                        <small style="color: red;" id="nameHelp1" class="form-text "><?php echo $fnameErr; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="Inputname2">Last Name:</label>
                        <input type="text" placeholder="Last Name" class="form-control" id="Inputname2" name="lname" value="<?php echo $lname; ?>">
                        <small style="color: red;" id="nameHelp2" class="form-text "><?php echo $lnameErr; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail1">Email Address:</label>
                        <input type="text" placeholder="Email id" class="form-control" id="InputEmail1" name="email" value="<?php echo $email; ?>">
                        <small style="color: red;" id="emailHelp" class="form-text"><?php echo $emailErr; ?></small>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['sg']['token']; ?>" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
                    <button type="button" class="btn btn-primary btn-block" onclick="location.href='<?php echo URL; ?>users/user_profile.php'">Cancel</button>
                </form>
            </div>
        </div>
    </div>
    <?php include_once "../include/footer.php" ;

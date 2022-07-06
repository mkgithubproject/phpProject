<?php
// include_once "./config/connection.php";
//or
include_once dirname(__FILE__)."/config/connection.php";
if (is_authentic()) {
    header("location:" . URL . "users/user_profile.php");
    
}
$TITLE="Register Here";
$fnameErr = $lnameErr = $emailErr = $passErr = $re_passErr = $regi_info = "";
$fname = $lname = $email = $password = $re_password = "";
$delete_flag = 0;
$error__flag = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["csrf_token"] != $_SESSION['sg']["token"]) {
        $error__flag = 1;
        $token_error = "Invaid request, please try again";
    }

    if (!preg_match("/^[a-zA-Z]{1,}$/", $conn->real_escape_string($_POST["fname"]))) {
        $fnameErr = "Invalid user name:Only characters are allowed";
        $error__flag = 1;
    } else {
        $fname =  $conn->real_escape_string($_POST["fname"]);
    }
    if (!preg_match("/^[a-zA-Z]{1,}$/", $conn->real_escape_string($_POST["lname"]))) {
        $lnameErr = "Invalid user name:Only characters are allowed";
        $error__flag = 1;
    } else {
        $lname =  $conn->real_escape_string($_POST["lname"]);
    }
    if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",  $conn->real_escape_string($_POST["email"]))) {
        $emailErr = "Invalid email";
        $error__flag = 1;
    } else {
        $email = $conn->real_escape_string($_POST["email"]);
    }
    if (!preg_match("/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/",  $conn->real_escape_string($_POST["pwd"]))) {
        $passErr = "must contain 8 character at least one uppercase ,lower case ,numeric,and special character";
        $error__flag = 1;
    } else {
        $password =  $conn->real_escape_string($_POST["pwd"]);
    }
    $re_password = $conn->real_escape_string($_POST["re_pwd"]);
    if ($re_password != $password) {
        $error__flag = 1;
        $re_passErr = "Paasword must be same like previous field";
    }
    if ($error__flag == 0) {
        $stmt = $conn->prepare("SELECT email ,delete_flag from users where email=? AND delete_flag=? ");
        $stmt->bind_param("si", $email, $delete_flag);
        $executed = $stmt->execute();
        $result = $stmt->get_result();
        if ($executed == true && $result->num_rows > 0) {
            $regi_info = "You have already registered";
        } else {
            $stmt = $conn->prepare("insert into users (firstname,lastname,email,password,`confirm password`,delete_flag)values(?,?,?,?,?,?)");
            $stmt->bind_param("sssssi", $fname, $lname, $email, $password, $re_password, $delete_flag);
            $stmt->execute();
            $regi_info = "";
            $stmt->close();
            $conn->close();
            echo '<script>alert("You are registered")</script>';
            header("location: " . URL . "users/login.php");
        }
    }
}

include "./include/header.php"; ?>
<div class="container-fluid ">
    <div class="row justify-content-center">
        <div class=" col-sm-6 col-md-3 ">
            <?php
            if (!empty($token_error)) {
            ?>
                <div class="alert alert-dannger"><?php echo $token_error; ?></div>
            <?php
            }
            ?>
            <form action="" class="form-container1" method="POST" onsubmit="return register()">
                <div class="form-group">
                    <label for="Inputname1">First Name:</label>
                    <input type="text" placeholder="First Name" class="form-control" id="Inputname1" name="fname" value="<?php echo $fname ?>">
                    <small id="nameHelp1" style="color: red;" class="form-text "><?php echo $fnameErr; ?></small>
                </div>
                <div class="form-group">
                    <label for="Inputname2">Last Name:</label>
                    <input type="text" placeholder="Last Name" class="form-control" id="Inputname2" name="lname" value="<?php echo $lname ?>">
                    <small id="nameHelp2" style="color: red;" class="form-text "><?php echo $lnameErr; ?></small>
                </div>
                <div class="form-group">
                    <label for="InputEmail1">Email Address:</label>
                    <input type="text" placeholder="Email id" class="form-control" id="InputEmail1" name="email" value="<?php echo $email ?>">
                    <small id="emailHelp" style="color: red;" class="form-text"><?php echo $emailErr; ?></small>
                </div>
                <div class="form-group">
                    <label for="InputPassword1">Password:</label>
                    <input type="password" placeholder="Password" class="form-control" id="InputPassword1" name="pwd" value="<?php echo $password ?>">
                    <small id="passwordHelp1" style="color: red;" class="form-text "><?php echo $passErr; ?></small>
                </div>
                <div class="form-group">
                    <label for="InputPassword2">Confirm Password:</label>
                    <input type="password" placeholder="Confirm Password" class="form-control" id="InputPassword2" name="re_pwd" value="<?php echo $re_password ?>">
                    <small id="passwordHelp2" style="color: red;" class="form-text "><?php echo $re_passErr; ?></small>
                </div>
                <div class="form-group">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['sg']['token']; ?>" />
                </div>
                <div class="form-group">
                    <span style="color: red;"><?php echo $regi_info; ?></span>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
    </div>
</div>
<?php include_once "./include/footer.php";

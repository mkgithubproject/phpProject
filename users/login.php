<?php
include_once "../config/connection.php";
if (is_authentic()) {
    header("location:" . URL . "users/user_profile.php");
    exit;
}
$TITLE="Login Here";
$login_info = $emailError = $passError = "";
$email = $password = "";
$delete_flag=0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailError = "*All field required.";
    } else {
        $email =  $conn->real_escape_string($_POST["email"]);
        
    }
    if (empty($_POST["psw"])) {
        $passError = "*All field required.";
    } else {
        $password =  $conn->real_escape_string($_POST["psw"]);
        
    }
    if ($emailError == "" && $passError == "") {
        $stmt = $conn->prepare("SELECT user_id,email,password FROM users where email=? AND password=? AND delete_flag=?");
        $stmt->bind_param("ssi", $email, $password,$delete_flag);
        $executed = $stmt->execute();
        $result = $stmt->get_result();
        $row=$result->fetch_assoc();
        if ($executed == true && ($result->num_rows > 0 && $_POST["csrf_token"] == $_SESSION["sg"]["token"])) {
            $_SESSION["sg"]["loggedin"] = true;
            $_SESSION["sg"]["user_id"] = $row["user_id"];
            $stmt->close();
            $conn->close();
            header("location:" . URL . "users/user_profile.php");
           
        } else {
            $login_info = "Invalid Credential";
        }
    }
}

include_once "../include/header.php"; ?>
    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div class=" col-sm-6 col-md-3 ">
                <form action="" class="form-container2" method="POST" onsubmit="return login()" >
                    <div class="form-group">
                        <label for="InputEmail1">Email address:</label>
                        <input type="email" placeholder="Email id" class="form-control" id="InputEmail1" aria-describedby="emailHelp" name="email" value="<?php echo $email ?>">
                        <small id="emailHelp" style="color: red;" class="form-text "><?php echo $emailError; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="InputPassword1">Password:</label>
                        <input type="password" placeholder="password" class="form-control" id="InputPassword1" name="psw" value="<?php echo $password ?>">
                        <small id="passwordHelp" style="color: red;" class="form-text "><?php echo $passError; ?></small>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['sg']['token']; ?>" />
                    </div>
                    <div class="form-group">
                        <span style="color: red;"><?php echo $login_info; ?></span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
    <?php include_once "../include/footer.php";
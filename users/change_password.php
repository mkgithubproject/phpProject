<?php
include_once "../config/connection.php";
if (!is_authentic()) {
  header("location:" . URL . "index.php");
  exit;
}
$TITLE="Change Password";
$id=$_SESSION["sg"]["user_id"];
$passErr=$prevpassErr=$changepassInfo="";
$password=$prevpassword=""; 
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if (!preg_match("/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/
    ",  $conn->real_escape_string($_POST["psw"]))) {
          $passErr = "must contain 8 character at least one uppercase ,lower case ,numeric,and special character";
      } else {
          $password =  $conn->real_escape_string($_POST["psw"]);
          
}if (!preg_match("/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/
",  $conn->real_escape_string($_POST["prevpass"]))) {
      $prevpassErr = "previous password is not matched";
  } else {
      $prevpassword =  $conn->real_escape_string($_POST["prevpass"]);
     
}
if($passErr=="" && $prevpassErr==""){
    $stmt = $conn->prepare("SELECT password from users where user_id= ?");
    $stmt->bind_param("i",  $id);
    $executed = $stmt->execute();
    $result=$stmt->get_result();
   

    if($result== true && $result->num_rows >0 ){
        
       $row=$result->fetch_assoc();
       if($row["password"]==$prevpassword && $_POST["csrf_token"] == $_SESSION["sg"]["token"]){
         
         $stmt = $conn->prepare("UPDATE users SET `password`=?,`confirm password`=? where user_id=?");
         $stmt->bind_param("ssi", $password,$password, $id);
         $executed = $stmt->execute();

        
   
        if($executed==true && $conn->affected_rows>0 ){
            $changepassInfo="Password changed successfully!";
            $stmt->close();
        }
    }
    else{
        $prevpassErr="previous password is not matched!";
    }
}


}

$conn->close();
}
 include_once "../include/header.php" ?>
<div class="container-fluid ">
        <div class="row justify-content-center">
            <div class=" col-sm-6 col-md-3 ">
                <form action="" class="form-container2" method="POST" >
                    <div class="form-group">
                        <label for="prevpass">Previous password:</label>
                        <input type="password" placeholder="Enter previous password" class="form-control" id="prevpass" aria-describedby="emailHelp" name="prevpass" value="<?php echo $prevpassword;?>">
                        <small id="passHelp" style="color: red;" class="form-text "><?php echo $prevpassErr;?></small>
                    </div>
                    <div class="form-group">
                        <label for="InputPassword">New Password:</label>
                        <input type="password" placeholder=" New password" class="form-control" id="InputPassword" name="psw" value="<?php echo $password;?>">
                        <small id="passwordHelp" style="color: red;" class="form-text "><?php echo $passErr;?></small>
                    </div>
                    <div class="form-group">
                        <small id="changedpasswordhelp" style="color:green;" class="form-text "><?php echo $changepassInfo;?></small>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['sg']['token']; ?>" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
<?php include_once "../include/footer.php"; 

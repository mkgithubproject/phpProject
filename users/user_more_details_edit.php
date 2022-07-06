<?php
include_once "../config/connection.php";
if (!is_authentic()) {
    header("location:" . URL . "index.php");
    exit;
}
$TITLE = "User more details edit";
$arr = [];
$id = $_SESSION["sg"]["user_id"];
$profileError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $city = $_POST["city"];
    $pic = $_FILES["profile_picture"];
    $file_name = $pic["name"];
    $file_error = $pic["error"];
    $file_temp = $pic["tmp_name"];
    $destination;
    $file_ext = explode('.', $file_name);
    $file_check = strtolower(end($file_ext));
    $file_ext_stored = array('png', 'jpg', 'jpeg');
    if (in_array($file_check, $file_ext_stored) ) {
        $now = new DateTime('NOW', new DateTimeZone('Asia/Kolkata'));
        $date_time = $now->getTimestamp();
        $destination = "../images/$date_time$file_name";
        move_uploaded_file($file_temp, $destination);
        
    }
    elseif(!$_FILES['profile_picture']['size'] == 0){
        $profileError = "Image should be png,jpg or jpeg format";
       
    } 
    $birthday = $_POST["birthday"];
    $about = $conn->real_escape_string($_POST["about"]);
    $gender = $_POST["gender"];
    $skills = (isset($_POST['skill'])) ? $_POST['skill'] : array();
    $stmt = $conn->prepare("UPDATE  users set city=?,dateofbirth=?,about=?,gender=?,profileimage=? WHERE user_id=?");
    $stmt->bind_param("sssssi", $city, $birthday, $about, $gender, $destination, $id);
    $executed = $stmt->execute();
    $stmt = $conn->prepare("DELETE from user_skill where user_id=?");
    $stmt->bind_param("i", $id);
    $executed = $stmt->execute();
    foreach ($skills as $skill) {
        $stmt = $conn->prepare("SELECT skill_id from skill_table WHERE skill=?");
        $stmt->bind_param("s", $skill);
        $executed = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $skill_id = $row["skill_id"];
        $stmt = $conn->prepare("INSERT into user_skill (user_id,skill_id) VALUES(?,?)");
        $stmt->bind_param("ii", $id, $skill_id);
        $executed = $stmt->execute();
        // header("location:".URL."users/project.php");

    }
}







$stmt = $conn->prepare("SELECT city,profileimage,gender,dateofbirth,about from users where user_id = ?");
$stmt->bind_param("i", $id);
$executed = $stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt = $conn->prepare("SELECT skill_id from user_skill where user_id=?");
$stmt->bind_param("i", $id);
$executed = $stmt->execute();
$result2 = $stmt->get_result();
while ($row2 = $result2->fetch_assoc()) {
    $skill_id = $row2["skill_id"];
    $stmt = $conn->prepare("SELECT skill from skill_table where skill_id=?");
    $stmt->bind_param("i", $skill_id);
    $executed = $stmt->execute();
    $result3 = $stmt->get_result();
    $row3 = $result3->fetch_assoc();
    array_push($arr, $row3["skill"]);
}





include_once "../include/header.php" ?>
<h3 style="text-align: center;">Edit Profile</h1>
    <div class="container " style="margin-top: 15px;
  background-color: #fff;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0px 0px 10px 0px #000;">
        <div class="col-lg-12">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label style="color:blue; font-size:large"><i>Skills:</i></label><br>
                    <input type="checkbox" id="skill1" name="skill[]" value="php" <?php if (in_array("php", $arr)) {
                                                                                        echo "checked";
                                                                                    } ?>>

                    <label for="skill1"> php</label><br>
                    <input type="checkbox" id="skill2" name="skill[]" value="mysql" <?php if (in_array("mysql", $arr)) {
                                                                                        echo "checked";
                                                                                    } ?>>
                    <label for="skill2"> mysql</label><br>
                    <input type="checkbox" id="skill3" name="skill[]" value="javascript" <?php if (in_array("javascript", $arr)) {
                                                                                                echo "checked";
                                                                                            } ?>>
                    <label for="skill3"> javascript</label><br>
                    <input type="checkbox" id="skill4" name="skill[]" value="html" <?php if (in_array("html", $arr)) {
                                                                                        echo "checked";
                                                                                    } ?>>
                    <label for="skill4"> html</label><br>
                    <input type="checkbox" id="skill5" name="skill[]" value="java" <?php if (in_array("java", $arr)) {
                                                                                        echo "checked";
                                                                                    } ?>>
                    <label for="skill5"> java</label><br>
                    <input type="checkbox" id="skill6" name="skill[]" value="react.js" <?php if (in_array("react.js", $arr)) {
                                                                                            echo "checked";
                                                                                        } ?>>
                    <label for="skill6"> react.js</label><br>
                    <input type="checkbox" id="skill7" name="skill[]" value="node.js" <?php if (in_array("node.js", $arr)) {
                                                                                            echo "checked";
                                                                                        } ?>>
                    <label for="skill7"> node.js</label><br>

                </div>
                <div class="form-group">
                    <label style="color:blue; font-size:large"><i>City:</i></label><br>
                    <select name="city" class="form-control">
                        <option value="" selected disabled hidden>Select city</option>
                        <option value="chandigarh" <?php if ($row['city'] === 'chandigarh') {
                                                        echo 'selected ';
                                                    } ?>>Chandigarh</option>
                        <option value="mohali" <?php if ($row['city'] === 'mohali') {
                                                    echo 'selected';
                                                } ?>>Mohali</option>
                        <option value="panchkula" <?php if ($row['city'] === 'panchkula') {
                                                        echo 'selected';
                                                    } ?>>Panchkula</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color:blue; font-size:large" for="profileimage"><i>Upload/change profile image</i></label>
                    <input type="file" name="profile_picture" class="form-control-file" id="profileimage">
                    <small style="color: red;" class="form-text "><?php echo $profileError; ?></small>
                </div>
                <div class="form-group">
                    <label style="color:blue; font-size:large"><i>Gender:</i></label><br>
                    <input type="radio" id="male" name="gender" value="male" <?php if ($row['gender'] === 'male') {
                                                                                    echo 'checked';
                                                                                } ?>>
                    <label for="male">Male</label><br>
                    <input type="radio" id="female" name="gender" value="female" <?php if ($row['gender'] === 'female') {
                                                                                        echo 'checked';
                                                                                    } ?>>
                    <label for="female">Female</label><br>
                    <input type="radio" id="other" name="gender" value="other" <?php if ($row['gender'] === 'other') {
                                                                                    echo 'checked';
                                                                                } ?>>
                    <label for="other">Other</label>
                </div>
                <div class="form-group">
                    <label style="color:blue; font-size:large" for="birthday"><i>Date of birth:</i></label><br>
                    <input type="date" id="birthday" name="birthday" value="<?php echo $row['dateofbirth'] ?>">
                </div>
                <div class="form-group">
                    <label style="color:blue; font-size:large" for="about"><i>About yourself:</i></label>
                    <textarea class="form-control" id="about" name="about" placeholder="About yourself ......" rows="3"><?php echo htmlspecialchars($row['about']) ?></textarea>
                </div>
                <div class="form-group">
                    <label style="color:blue; font-size:large" for="about"><i>Change password:</i></label><br>
                    <button class="btn-primary btn"> <a href="<?php echo URL ?>users/change_password.php" class="text-white"> Change Password </a>
                </div>
                <div>
                    <button type="submit" style="margin-left:40%" class="btn btn-primary ">Update Profile</button>
                    <button type="button" class="btn btn-secondary " onclick="location.href='<?php echo URL; ?>users/user_profile.php'">Cancel</button>

                </div>
            </form>
        </div>
    </div>
    <?php include_once "../include/footer.php";

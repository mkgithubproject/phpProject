<?php include_once dirname(__FILE__) . "/../config/connection.php";
if (!is_authentic()) {
  header("location:" . URL . "index.php");
  exit;
}
$arr = [];
$id = $_SESSION["sg"]["user_id"];
$stmt = $conn->prepare("SELECT * from users where user_id = ?");
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


$TITLE = "User Profile";
include_once "../include/header.php"; ?>
<div class="container">
  <div class="col-lg-12">
    <br><br>
    <h1 class="text-warning text-center"> User Profile</h1>
    <br>
    <table id="tabledata" class=" table table-striped table-hover table-bordered">
      <tr class="bg-dark text-white text-center">


        <th>First Name </th>
        <th>Last Name </th>
        <th>Email </th>

        <th> Actions </th>

      </tr>

      <tr>

        <td> <?php echo htmlspecialchars($row['firstname']);  ?> </td>
        <td> <?php echo htmlspecialchars($row['lastname']);  ?> </td>
        <td> <?php echo htmlspecialchars($row['email']);  ?> </td>
        <td> <button class="btn-primary btn"> <a href="<?php echo URL; ?>users/user_profile_edit.php" class="text-white"> Edit </a> </button> <button class="btn-danger btn"> <a href="<?php echo URL ?>users/user_profile_delete.php" class="text-white"> Delete </a> </button> </td>

      </tr>

    </table>
    <br>
    <h1 class="text-warning text-center"> More Details</h1>
  </div>
</div>
<div class="container " style="margin-top: 15px;
  background-color: #fff;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0px 0px 10px 0px #000;">
  <div class="col-lg-12">
    <form>
      <div class="form-group">
        <label style="color:blue; font-size:large"><i>Skills:</i></label><br>
        <?php foreach ($arr as $value) { ?>
          <p><?php echo $value; ?></p>
        <?php } ?>



      </div>
      <div class="form-group">
        <label style="color:blue; font-size:large"><i>City:</i></label><br>
        <p><?php echo $row["city"]; ?></p>
      </div>
      <div class="form-group">
        <label style="color:blue; font-size:large"><i>Profile picture:</i></label><br>
        <img src="<?php echo $row["profileimage"]; ?>" alt="Avtar" width="60" height="50" class="img-thumbnail">

      </div>
      <div class="form-group">
        <label style="color:blue; font-size:large"><i>Gender:</i></label><br>
        <p><?php echo $row["gender"]; ?></p>
      </div>
      <div class="form-group">
        <label style="color:blue; font-size:large"><i>Date of birth:</i></label><br>
        <p><?php echo $row["dateofbirth"]; ?></p>
      </div>
      <div class="form-group">
        <label style="color:blue; font-size:large"><i>About yourself:</label>
        <p><?php echo $row["about"]; ?></p>
      </div>
      <div class="form-group">

        <button type="button" class="btn btn-primary " onclick="location.href='<?php echo URL ?>users/user_more_details_edit.php'">Update Details</button>
    </form>
  </div>
</div>
<?php include_once "../include/footer.php";

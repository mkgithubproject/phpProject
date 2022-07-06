<?php 
include_once "../config/connection.php";
if (!is_authentic()) {
    header("location:" . URL . "index.php");
    exit;
}
$TITLE="Edit Project";
$p_id = $_GET['project_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["csrf_token"] == $_SESSION['sg']["token"]) {
    $projectName=$conn->real_escape_string($_POST["prname"]);
    $projectdesc=$conn->real_escape_string($_POST["prdesc"]);
    $allot_date = $_POST["all_date"];
    $dead_date = $_POST["dead_date"];
    $project_createtime = $_POST["pr_createtime"];
    $skills = (isset($_POST['skill'])) ? $_POST['skill'] : array();

    $stmt = $conn->prepare("UPDATE  project set project_name=?,project_description=?,allotment_date=?,deadline_date=?,creation_on=? WHERE project_id=?");
    $stmt->bind_param("sssssi", $projectName,$projectdesc, $allot_date,$dead_date,$project_createtime,$p_id);
    $executed = $stmt->execute();
    $stmt = $conn->prepare("DELETE from projectskill_required where project_id=?");
    $stmt->bind_param("i", $p_id);
    $executed = $stmt->execute();
    foreach ($skills as $skill) {
        $stmt = $conn->prepare("SELECT p_skill_id from p_skill WHERE skill=?");
        $stmt->bind_param("s", $skill);
        $executed = $stmt->execute();
        $result=$stmt->get_result();
        $row = $result->fetch_assoc();
        $skill_id = $row["p_skill_id"];
        $stmt = $conn->prepare("INSERT into projectskill_required (project_id,p_skill_id) VALUES(?,?)");
        $stmt->bind_param("ii", $p_id,$skill_id);
        $executed = $stmt->execute();
        header("location:".URL."users/project.php");

    }
}
$stmt = $conn->prepare("SELECT project_name,project_description,allotment_date,deadline_date,creation_on from project WHERE project_id=?");
$stmt->bind_param("i", $p_id);
$executed = $stmt->execute();
$result=$stmt->get_result();

$row;
$creation_on;
$arr = [];
if ($result == true && $conn->affected_rows > 0) {
    $row = $result->fetch_assoc();
    $creation_on = $row["creation_on"];
    $dateTime = new DateTime($creation_on);
    $creation_on =  $dateTime->format('H:i');
}
$stmt = $conn->prepare("SELECT p_skill_id FROM projectskill_required WHERE project_id=?");
$stmt->bind_param("i",$p_id);
$executed = $stmt->execute();
$result=$stmt->get_result();


while ($row2 = $result->fetch_assoc()) {
    $id = $row2["p_skill_id"];
    $stmt = $conn->prepare("SELECT skill from p_skill where p_skill_id=?");
    $stmt->bind_param("i", $id);
    $executed = $stmt->execute();
    $result2=$stmt->get_result();

   
    $row3 = $result2->fetch_assoc();

    array_push($arr, $row3["skill"]);
}

$conn->close();

 include_once "../include/header.php" ?>
    <h3 style="text-align: center;">Edit Project</h1>
        <div class="container " style="margin-top: 15px;
  background-color: #fff;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0px 0px 10px 0px #000;">
            <div class="col-lg-12">
                <form action="" method="POST">
                    <div class="form-group">
                        <label style="color: blue;" for="exampleFormControlInput1">Project name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="prname" placeholder="Name of the project" value="<?php echo htmlspecialchars($row['project_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label style="color: blue;" for="exampleFormControlTextarea1">Project descreption</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="prdesc" placeholder="Describe your project here......" rows="3" required><?php echo htmlspecialchars($row['project_description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label style="color: blue;" for="allotdate">Allotment date:MM/DD/YYYY</label>
                        <input type="date" class="form-control" id="allotdate" name="all_date" value="<?php echo $row['allotment_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label style="color: blue;" for="deadlinedate">Deadline date:MM/DD/YYYY</label>
                        <input type="date" class="form-control" name="dead_date" id="deadlinedate" value="<?php echo $row['deadline_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label style="color: blue;" for="timeon">Project creation time</label>
                        <input type="time" class="form-control" id="timeon" name="pr_createtime" value="<?php echo $creation_on; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['sg']['token']; ?>" />
                    </div>
                    <div class="form-group">
                        <label style="color: blue;">Skills:</label><br>
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
                    <button type="submit" class="btn btn-primary ">Update Project</button>
                    <button type="button" class="btn btn-secondary " onclick="location.href='<?php echo URL; ?>users/project.php'">Cancel</button>
                </form>
            </div>
        </div>
        <?php include_once "../include/footer.php"; ?>

<?php 
include_once "../config/connection.php";
if (!is_authentic()) {
    header("location:" . URL . "index.php");
    exit;
}
$TITLE="Create Project";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $projectName=$conn->real_escape_string($_POST["prname"]);
    $projectdesc=$conn->real_escape_string($_POST["prdesc"]);
    $allot_date=$_POST["all_date"];
    $dead_date=$_POST["dead_date"];
    $project_createtime=$_POST["pr_createtime"]; 
 $skills = (isset($_POST['skill'])) ? $_POST['skill'] : array();
 $last_id ;
  if( $_POST["csrf_token"] == $_SESSION['sg']["token"]){

    $stmt = $conn->prepare("INSERT INTO project (project_name,project_description,allotment_date,deadline_date,creation_on)VALUES(?,?,?,?,?)");
    $stmt->bind_param("sssss", $projectName, $projectdesc, $allot_date, $dead_date,$project_createtime);
    $result=$stmt->execute();
   
     
 if($result==true && $stmt->affected_rows>0){
   $last_id = $stmt->insert_id;
 }
  foreach($skills as $skill){

    $stmt = $conn->prepare("SELECT p_skill_id from p_skill WHERE skill=? ");
    $stmt->bind_param("s",$skill);
    $executed = $stmt->execute();
       $result=$stmt->get_result();    
      $row=$result->fetch_assoc();
      $skill_id=$row["p_skill_id"];

      $stmt = $conn->prepare("INSERT into projectskill_required (project_id,p_skill_id) VALUES(?,?)");
      $stmt->bind_param("ii",$last_id,$skill_id);
      $executed = $stmt->execute();
      

  }
}$stmt->close();
  $conn->close();
  header("location: " . URL . "users/project.php");
}


 include_once "../include/header.php" ?>
    <h3 style="text-align: center;">Create Project</h1>
        <div class="container " style="margin-top: 15px;
  background-color: #fff;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0px 0px 10px 0px #000;">
            <div class="col-lg-12">
                <form action="" method="POST">
                    <div class="form-group">
                        <label style="color: blue;" for="exampleFormControlInput1">Project name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="prname" placeholder="Name of the project" required>
                    </div>
                    <div class="form-group">
                        <label style="color: blue;" for="exampleFormControlTextarea1">Project descreption</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="prdesc" placeholder="Describe your project here......" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label style="color: blue;" for="allotdate">Allotment date</label>
                        <input type="date" class="form-control" name="all_date" id="allotdate"required
                        >
                    </div>
                    <div class="form-group">
                        <label style="color: blue;" for="deadlinedate">Deadline date</label>
                        <input type="date" class="form-control" name="dead_date" id="deadlinedate" required>
                    </div>
                    <div class="form-group">
                        <label style="color: blue;" for="timeon">Project creation time</label>
                        <input type="time" class="form-control" name="pr_createtime"
                        id="timeon" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['sg']['token']; ?>" />
                    </div>
                    <div class="form-group">
                        <label style="color: blue;">Skills:</label><br>
                        <input type="checkbox" id="skill1" name="skill[]" value="php">
                        <label for="skill1"> php</label><br>
                        <input type="checkbox" id="skill2" name="skill[]" value="mysql">
                        <label for="skill2"> mysql</label><br>
                        <input type="checkbox" id="skill3" name="skill[]" value="javascript">
                        <label for="skill3"> javascript</label><br>
                        <input type="checkbox" id="skill4" name="skill[]" value="html">
                        <label for="skill4"> html</label><br>
                        <input type="checkbox" id="skill5" name="skill[]" value="java">
                        <label for="skill5"> java</label><br>
                        <input type="checkbox" id="skill6" name="skill[]" value="react.js">
                        <label for="skill6"> react.js</label><br>
                        <input type="checkbox" id="skill7" name="skill[]" value="node.js">
                        <label for="skill7"> node.js</label><br>

                    </div>
                    <button type="submit" class="btn btn-primary " style="margin-left:40%;">Create Project</button>
                </form>
            </div>
        </div>
        <?php include_once "../include/footer.php"; ?>

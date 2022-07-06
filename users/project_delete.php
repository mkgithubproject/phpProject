<?php 
include_once "../config/connection.php";
if (!is_authentic()) {
  header("location:" .URL. "index.php");
  exit;
}

$p_id =$_GET['project_id'];
isset($_GET["token"])? $token=$_GET["token"]:$token=null;
if($token===$_SESSION['sg']['token']){
$stmt = $conn->prepare("UPDATE project SET delete_flag=1 Where project_id=?");
$stmt->bind_param("i", $p_id);
$executed = $stmt->execute();
if($executed==true && $conn->affected_rows>0){
  header("location:" .URL. "users/project.php?del=1");
}
$stmt->close();
$conn->close();
}
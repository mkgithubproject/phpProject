<?php 
include_once "../config/connection.php";
if (!is_authentic()) {
  header("location:" . URL . "index.php");
  exit;
}
echo $id=$_SESSION["sg"]["user_id"];
$stmt = $conn->prepare("UPDATE users SET delete_flag=1 WHERE user_id=?");
$stmt->bind_param("i",$id);
$executed = $stmt->execute();

header("location:".URL."users/logout.php");

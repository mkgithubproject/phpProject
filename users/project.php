<?php
include_once "../config/connection.php";
if (!is_authentic()) {
    header("location:" . URL . "index.php");
    exit;
}
$TITLE = "Projects Here";
$del = isset($_GET["del"]);
// if($del==1){
//   echo "<script>alert('Project deleted successfully');</script>";
// }
?>
<?php include_once "../include/header.php" ?>
<button class="btn-primary btn mk-button"> <a href="<?php echo URL ?>users/create_project.php" class="text-white"> Create Project</a> </button>
<div id="search-bar" class="mt-2 ml-2">
    <h6>Search Projects Here:</h6>
    <input type="text" autocomplete="off" placeholder="Enter project name......">
</div>

<div class="container">

    <div class="col-lg-12">
        <br><br>
        <h1 class="text-warning text-center"> Project List</h1>
        <br>
        <table id="tabledata" class=" table table-striped table-hover table-bordered">

            <?php
            //paginaation
            //Get the current page number
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $limit_per_page = 5;
            $offset = ($page - 1) * $limit_per_page;
            $where = " WHERE delete_flag=0 ";
            if (!empty($_GET['s'])) {
                $where .= "and project_name like '%" . $conn->real_escape_string($_GET['s']) . "%' ";
            }
            $sql = "SELECT count(*) as total_counts from project " . $where;
            $result = $conn->query($sql);
            $rrow = $result->fetch_assoc();
            $total_records = $rrow['total_counts'];
            $number_of_page = ceil($total_records / $limit_per_page);

            //retrieve data
            $delete_flag = 0;
            $stmt = $conn->prepare("SELECT project_id,project_name from project " . $where . " LIMIT $offset,$limit_per_page");
            //$stmt->bind_param("i", $delete_flag);
            $executed = $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) { ?>
                <tr class="bg-dark text-white text-center">

                    <th> S.No. </th>
                    <th>Project Name </th>
                    <th> Delete </th>
                    <th> Update </th>
                </tr>


                <?php

                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td> <?php echo htmlspecialchars($row['project_id']);  ?> </td>
                        <td> <?php echo htmlspecialchars($row['project_name']);  ?> </td>
                        <td style="text-align: center;"> <button class="btn-danger btn"> <a href="<?php echo URL; ?>users/project_delete.php?project_id=<?php echo $row['project_id'];  ?>& token=<?php echo $_SESSION['sg']['token']; ?>" class="text-white"> Delete </a> </button> </td>
                        <td style="text-align: center;"> <button class="btn-primary btn"> <a href="<?php echo URL; ?>users/project_edit.php?project_id=<?php echo $row['project_id'];  ?> " class="text-white"> Edit </a> </button> </td>
                    </tr>
                <?php  }
            } else { ?>
                <h1>No project available</h1>
            <?php } ?>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination nav justify-content-center">
                <?php for ($page = 1; $page <= $number_of_page; $page++) {  ?>
                    <li class="page-item "><a class="page-link" href="<?php echo URL; ?>users/project.php?page=<?php echo $page; ?>"><?php echo $page; ?></a></li>

                <?php } ?>
            </ul>
        </nav>

    </div>
</div>
<?php include_once "../include/footer.php"; ?>



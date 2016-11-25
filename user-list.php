<?php
include("header.php");
include("sidemenu.php");

if ($_SESSION["role"] == 'user') {
    echo "<script type='text/javascript'>window.location.href = '" . SITE_URL . "';</script>";
}
$final_status = 2;

//Delete Function
function runDeleteFunction($dbconnect, $id) {

    $select_query = "SELECT * FROM LOGIN_DETAILS l, USER_DETAILS u WHERE l.ID = u.LOGIN_ID AND l.ID ='" . $id . "' ";
    $dbconnect->sql = $select_query;
    $dbconnect->countresult();
    if ($dbconnect->count > 0) {
        //Login 
        $delete_query = "DELETE FROM LOGIN_DETAILS WHERE ID = '" . $id . "';";
        $dbconnect->sql = $delete_query;
        $dbconnect->deletetb();
        //User
        $delete_query = "DELETE FROM USER_DETAILS WHERE LOGIN_ID = '" . $id . "';";
        $dbconnect->sql = $delete_query;
        $dbconnect->deletetb();

        return 1;
    } else {
        return 0;
    }
}

if (isset($_GET['id'])) {
    if ($_SESSION["role"] == 'admin') {
        $final_status = runDeleteFunction($dbconnect, $_GET['id']);
    }
}

//Get all
$query = "SELECT * FROM LOGIN_DETAILS l, USER_DETAILS u WHERE l.ID = u.LOGIN_ID ORDER BY l.id ";
$dbconnect->sql = $query;
$dbconnect->selecttb();
$results = ($dbconnect->nrow!='0') ? $dbconnect->res : '0';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">               
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php if ($final_status == '1') { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Deleted successfully...
                    </div>
                <?php } elseif ($final_status == '0') { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        No record..
                    </div>
                <?php } ?>
                <div class="box box-primary">                                            
                    <div class="box-body">
                        <div class="heading"><b>User List</b></div>                        
                        <table id="report_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>FIRST_NAME</th>
                                    <th>LAST_NAME</th>
                                    <th>EMAIL</th>
                                    <th>PHONE_NO</th>
                                    <th>ROLE</th>
                                    <th>ACCESS</th>
                                    <th>STATUS</th>
                                    <th>CREATED_ON</th>                                                                        
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($results !='0') { ?>
                                    <?php while ($row = mysql_fetch_array($results)) { ?>
                                        <tr>
                                            <td><a href="edit-user.php?id=<?php echo $row['ID']; ?>"><i class="fa fa-fw fa-edit"></i></a>
                                                <a href="user-list.php?id=<?php echo $row['ID']; ?>" onclick="return confirm('Are you sure ?')"><i class="fa fa-fw fa-close"></i></a>
                                            </td>
                                            <td><?php echo $row['FIRST_NAME']; ?></td>
                                            <td><?php echo $row['LAST_NAME']; ?></td>
                                            <td><?php echo $row['EMAIL']; ?></td>
                                            <td><?php echo $row['PHONE_NO']; ?></td>
                                            <td><?php echo ($row['ROLE'] == '1') ? 'Admin' : 'User'; ?></td>
                                            <td><?php echo ($row['ACCESS'] == '1') ? 'Yes' : 'No'; ?></td>
                                            <td><?php echo ($row['STATUS'] == '1') ? 'Enable' : 'Disable'; ?></td>
                                            <td><?php echo $row['CREATED_ON']; ?></td>                                        
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>                                        
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->       
</div>
<!-- /.content-wrapper -->


<?php include("footer.php"); ?>
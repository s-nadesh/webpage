<?php
include("header.php");
include("sidemenu.php");


$results = array();
$final_status =2;

//Delete Function
function runDeleteFunction($dbconnect,$id) {
    
    $select_query = "SELECT * FROM BOMX WHERE ID = '".$id."';";
    $dbconnect->sql = $select_query;
    $dbconnect->countresult();
    if($dbconnect->count > 0 ){
        $delete_query = "DELETE FROM BOMX WHERE ID = '".$id."';";
        $dbconnect->sql = $delete_query;
        $dbconnect->deletetb();
        return 1;
    }else{
        return 0;
    }
    
}

if (isset($_GET['id'])) {
    if($_SESSION["role"]=='admin'){
        $final_status = runDeleteFunction($dbconnect,$_GET['id']);
    }
}


if (isset($_POST['submit-btn'])) {
    $start_date = date("Y-m-d h:m:s", strtotime($_POST['start_date']));
    $end_date = date("Y-m-d h:m:s", strtotime($_POST['end_date']));

    //Filter
    $query = "SELECT * FROM BOMX WHERE CREATED_ON >='" . $start_date . "' AND CREATED_ON <= '" . $end_date . "'";

    $dbconnect->sql = $query;
    $dbconnect->selecttb();
    $results = ($dbconnect->res) ? $dbconnect->res : '0';
} else {
    //Get all
    $query = "SELECT * FROM BOMX ORDER BY ID DESC LIMIT 0,5";
//    $query = "SELECT * FROM BOMX ORDER BY ID DESC";
    $dbconnect->sql = $query;
    $dbconnect->selecttb();
    $results = ($dbconnect->res) ? $dbconnect->res : '0';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">   
            
            
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                <?php if($_SESSION["role"]=='admin'){ ?>    
                <div class="form-group">
                    <a href="create-bomx.php"><button class="btn btn-block bg-maroon" type="button"> <i class="fa fa-fw fa-plus"></i> Add BOMX</button></a>
                </div>            
                <?php } ?>
                <div class="box  box-primary"> 
                    <div class="box-header with-border">
                        <i class="fa fa-search"></i>

                        <h3 class="box-title">Search</h3>
                    </div>
                    <!-- form start -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <form role="form" id="conversion_tool" lpformnum="12" action="" method="post">
                                    <div class="form-group">
                                        <label>Start Date:</label>
                                        <input type="text" id="datepicker-start" class="form-control pull-right" name="start_date" value="<?php if (isset($_POST['submit-btn'])) {
                echo $_POST['start_date'];
            } ?>">
                                    </div>                                    
                                    <div class="form-group">
                                        <label>End Date:</label>
                                        <input type="text" id="datepicker-end" class="form-control pull-right" name="end_date" value="<?php if (isset($_POST['submit-btn'])) {
                echo $_POST['end_date'];
            } ?>">
                                    </div>                                    

                                    <div class="form-group">
                                        <label></label>
                                        <button class="btn btn-block btn-success btn-sm" type="submit" name="submit-btn">Submit</button>   
                                    </div>
                                </form>
                            </div>
                        </div>                                                    
                    </div>
                </div>
                <!-- /.box-body -->                      


            </div>            
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
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
                        <div class="heading"><b>BOMX</b></div>
                        <table id="conversion-plus" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php if($_SESSION["role"]=='admin'){ ?><th></th><?php } ?>
                                    <th>PARENT_PN</th>
                                    <th>CHILD_PN</th>
                                    <th>LICENSE_UI_NAME</th>
                                    <th>LICENSE_TYPE</th>
                                    <th>TO_INSTALL</th>
                                    <th>CHILD_DESC</th>
                                    <th>CREATED_ON</th>
                                    <th>LAST_UPDATED_ON</th>
                                    <th>TYPE_UPGRADE</th>
                                    <th>COL_SEARCH</th>
                                    <th>PROD_MODEL</th>
                                </tr>
                            </thead>
                            <tbody>
<?php while ($row = mysql_fetch_array($results)) { ?>
                                    <tr>
                                        <?php if($_SESSION["role"]=='admin'){ ?>
                                        <td><a href="edit-bomx.php?id=<?php echo $row['ID']; ?>"><i class="fa fa-fw fa-edit"></i></a>
                                            <a href="bomx.php?id=<?php echo $row['ID']; ?>" onclick="return confirm('Are you sure ?')"><i class="fa fa-fw fa-close"></i></a>
                                        </td>
                                        <?php } ?>
                                        <td><?php echo $row['PARENT_PN']; ?></td>
                                        <td><?php echo $row['CHILD_PN']; ?></td>
                                        <td><?php echo $row['LICENSE_UI_NAME']; ?></td>
                                        <td><?php echo $row['LICENSE_TYPE']; ?></td>
                                        <td><?php echo $row['TO_INSTALL']; ?></td>
                                        <td><?php echo $row['CHILD_DESC']; ?></td>
                                        <td><?php echo $row['CREATED_ON']; ?></td>
                                        <td><?php echo $row['LAST_UPDATED_ON']; ?></td>
                                        <td><?php echo $row['TYPE_UPGRADE']; ?></td>
                                        <td><?php echo $row['COL_SEARCH']; ?></td>
                                        <td><?php echo $row['PROD_MODEL']; ?></td>
                                    </tr>
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
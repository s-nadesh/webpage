<?php
include("header.php");
include("sidemenu.php");
if($_SESSION["role"]=='user'){
    echo "<script type='text/javascript'>window.location.href = '".SITE_URL."';</script>";
}
$id = $_GET['id'];

$final_status = '2';

if (isset($_POST['submit-form'])) {

    $flag = '0';

    $PARENT_PN = $_POST['PARENT_PN'];
    $CHILD_PN = $_POST['CHILD_PN'];
    $LICENSE_UI_NAME = ($_POST['LICENSE_UI_NAME']) ? $_POST['LICENSE_UI_NAME'] : 'null';
    $LICENSE_TYPE = ($_POST['LICENSE_TYPE']) ? $_POST['LICENSE_TYPE'] : 'null';
    $TO_INSTALL = ($_POST['TO_INSTALL']) ? $_POST['TO_INSTALL'] : 'null';
    $CHILD_DESC = nl2br($_POST['CHILD_DESC']);
    $CREATED_ON = date("Y-m-d h:m:s", strtotime($_POST['CREATED_ON']));
    $TYPE_UPGRADE = ($_POST['TYPE_UPGRADE']) ? $_POST['TYPE_UPGRADE'] : 'null';
    $COL_SEARCH = ($_POST['COL_SEARCH']) ? $_POST['COL_SEARCH'] : 'null';
    $PROD_MODEL = ($_POST['PROD_MODEL']) ? $_POST['PROD_MODEL'] : 'null';
    $LAST_UPDATED_ON = date("Y-m-d h:m:s");

    //PHP validation
    if (!$PARENT_PN) {
        $flag = '1';
    }
    if (!$CHILD_PN) {
        $flag = '1';
    }
    if (!$CHILD_DESC) {
        $flag = '1';
    }
    if (!$CREATED_ON) {
        $flag = '1';
    }

    if ($flag != '1') {
        //Create BOMX
        $bomx_query = "UPDATE BOMX SET PARENT_PN= '" . $PARENT_PN . "', CHILD_PN='" . $CHILD_PN . "',LICENSE_UI_NAME='" . $LICENSE_UI_NAME . "',LICENSE_TYPE='" . $LICENSE_TYPE . "',TO_INSTALL='" . $TO_INSTALL . "', CHILD_DESC='" . $CHILD_DESC . "',CREATED_ON='" . $CREATED_ON . "', LAST_UPDATED_ON='" . $LAST_UPDATED_ON . "',TYPE_UPGRADE='" . $TYPE_UPGRADE . "',COL_SEARCH='" . $COL_SEARCH . "',PROD_MODEL='" . $PROD_MODEL . "'  WHERE ID='" . $id . "';";

        $dbconnect->sql = $bomx_query;
        $dbconnect->updatetb();
        $final_status = 1; //Result status
    } else {
        $final_status = 0;
    }
}
$query = "SELECT * FROM BOMX WHERE ID ='" . $id . "' ";
$dbconnect->sql = $query;
$dbconnect->selecttb();
$results = ($dbconnect->res) ? $dbconnect->res : '0';

if ($results) {
    $row = mysql_fetch_array($results);
} else {
    header("Location: " . SITE_URL);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <p></p>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php if (isset($_GET['branch'])) { ?>
                <li><a href="#"><?php echo $_GET['type']; ?></a></li>
            <?php } else if(isset($_GET['type'])){ ?>
                <li class="active"><?php echo $_GET['type']; ?></li>
            <?php } ?>
            <?php if (isset($_GET['sub_branch'])) { ?>
                <li><a href="#"><?php echo $_GET['branch']; ?></a></li>
                <li class="active"><?php echo $_GET['sub_branch']; ?></li>
            <?php } else if(isset($_GET['branch'])){ ?>
                <li class="active"><?php echo $_GET['branch']; ?></li>
            <?php } ?>

        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <form role="form" id="create_bomx_form" lpformnum="12" action="" method="post">
                <div class="col-md-12">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create BOMX</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->                        
                        <div class="box-body">
                            <?php if ($final_status == '1') { ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Updated successfully...
                                </div>
                            <?php } elseif ($final_status == '0') { ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Please Check Your Details..
                                </div>
                            <?php } ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="PARENT_PN">PARENT_PN*:</label>
                                    <input type="text" class="form-control" id="PARENT_PN" name="PARENT_PN" placeholder="Enter PARENT_PN" value="<?php echo ($row['PARENT_PN'] != 'null') ? $row['PARENT_PN'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="CHILD_PN">CHILD_PN*:</label>
                                    <input type="text" class="form-control" id="CHILD_PN" name="CHILD_PN" placeholder="Enter CHILD_PN" value="<?php echo ($row['CHILD_PN'] != 'null') ? $row['CHILD_PN'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="LICENSE_UI_NAME">LICENSE_UI_NAME:</label>
                                    <input type="text" class="form-control" name="LICENSE_UI_NAME" id="LICENSE_UI_NAME" placeholder="Enter LICENSE_UI_NAME"value="<?php echo ($row['LICENSE_UI_NAME'] != 'null') ? $row['LICENSE_UI_NAME'] : ''; ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="LICENSE_TYPE">LICENSE_TYPE:</label>
                                    <input type="text" class="form-control" name="LICENSE_TYPE" id="LICENSE_TYPE" placeholder="Enter LICENSE_TYPE"value="<?php echo ($row['LICENSE_TYPE'] != 'null') ? $row['LICENSE_TYPE'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="TO_INSTALL">TO_INSTALL:</label>
                                    <input type="text" class="form-control" name="TO_INSTALL" id="TO_INSTALL" placeholder="Enter TO_INSTALL"value="<?php echo ($row['TO_INSTALL'] != 'null') ? $row['TO_INSTALL'] : ''; ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="CHILD_DESC">CHILD_DESC*:</label>                                    
                                    <textarea placeholder="Enter CHILD_DESC" rows="3" class="form-control" id="CHILD_DESC" name="CHILD_DESC"><?php echo preg_replace('/\<br(\s*)?\/?\>/i', "", $row['CHILD_DESC']); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="CREATED_ON">CREATED_ON*:</label>
                                    <input type="text" id="datepicker-start" class="form-control" name="CREATED_ON" value="<?php echo date('m/d/Y', strtotime($row['CREATED_ON'])); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="TYPE_UPGRADE">TYPE_UPGRADE:</label>
                                    <input type="text" class="form-control" id="TYPE_UPGRADE" name="TYPE_UPGRADE" placeholder="Enter TYPE_UPGRADE" value="<?php echo ($row['TYPE_UPGRADE'] != 'null') ? $row['TYPE_UPGRADE'] : ''; ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="COL_SEARCH">COL_SEARCH:</label>
                                    <input type="text" class="form-control" id="COL_SEARCH" name="COL_SEARCH" placeholder="Enter COL_SEARCH"value="<?php echo ($row['COL_SEARCH'] != 'null') ? $row['COL_SEARCH'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="PROD_MODEL">PROD_MODEL:</label>
                                    <input type="text" class="form-control" id="PROD_MODEL" name="PROD_MODEL" placeholder="Enter PROD_MODEL"value="<?php echo ($row['PROD_MODEL'] != 'null') ? $row['PROD_MODEL'] : ''; ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <div class="col-xs-12 col-sm-8 col-md-8  col-lg-6">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <button class="btn btn-block btn-success" type="submit" name="submit-form">Submit</button>
                                    </div>
                                    <div class="col-xs-4">
                                        <a href="bomx.php"><button class="btn btn-block btn-warning" type="button">Back</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </form>
        </div>        
        <!-- /.row -->
    </section>
    <!-- /.content -->       
</div>
<!-- /.content-wrapper -->

<?php include("footer.php"); ?>
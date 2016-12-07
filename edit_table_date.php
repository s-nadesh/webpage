<?php
include("header.php");
include("sidemenu.php");

if (isset($_GET['type'])) {
    $table = $_GET['type'];
} else {
    echo "<script type='text/javascript'>window.location.href = '" . SITE_URL . "';</script>";
}


$final_status = '2';

$dbconnect->getTableColumn($table);
$columns  = ($dbconnect->nrow != '0') ? $dbconnect->res : $dbconnect->nrow;

$dbconnect->getPrimaryKey($table);
$primary_key = $dbconnect->primary_key;


if (isset($_POST['submit-form'])) {

    $_fields = array();
    while ($cols = mysql_fetch_array($columns)) {
        if ($cols['COLUMN_NAME'] == $primary_key) {
            continue;
        }
        $_fields[] = $cols['COLUMN_NAME'] . "='" . $_POST[$cols['COLUMN_NAME']] . "'";
    }


    $_query = "UPDATE " . $table . " SET " . implode($_fields, ', ') . " WHERE " . $primary_key . "='" . $_POST[$primary_key] . "';";
    $dbconnect->sql = $_query;
    $dbconnect->updatetb();

    $final_status = 1;
    $dbconnect->getTableColumn($table);
    $columns  = ($dbconnect->nrow != '0') ? $dbconnect->res : $dbconnect->nrow;
}


$cond = ($primary_key != '') ? " WHERE " . $primary_key . ' = "' . $_GET[$primary_key].'"' : '';
$query = "SELECT * FROM " . $table . $cond;
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
    <?php include_once("include/breadcrumb.php"); ?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <form role="form" id="new_user_form" lpformnum="12" action="" method="post">
                <div class="col-md-12">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit <?php echo $table; ?></h3>
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
                            <div class="col-md-12">
                                <?php while ($res = mysql_fetch_array($columns)) { ?>
                                    <?php if ($res['COLUMN_NAME'] == $primary_key) { ?>
                                        <input type="hidden" name="<?php echo $res['COLUMN_NAME']; ?>" value="<?php echo ($row[$res['COLUMN_NAME']] != '') ? $row[$res['COLUMN_NAME']] : ''; ?>">
                                        <?php continue;
                                    } ?>                                                                
                                    <div class="form-group">
                                        <label for="First Name"><?php echo $res['COLUMN_NAME']; ?>:</label>
                                        <input type="text" class="form-control" name="<?php echo $res['COLUMN_NAME']; ?>" value="<?php echo ($row[$res['COLUMN_NAME']] != '') ? $row[$res['COLUMN_NAME']] : ''; ?>">
                                    </div>
<?php } ?>
                            </div>                            

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <div class="col-xs-12 col-sm-8 col-md-8  col-lg-6">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <button class="btn btn-block btn-success" type="submit" name="submit-form">Submit</button>
                                    </div>
                                    <div class="col-xs-4">
                                        <a href="index.php"><button class="btn btn-block btn-warning" type="button">Back</button></a>
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
<?php
include("header.php");
include("sidemenu.php");


$table = '';
$results = array();
$final_status = 2;
$fields = array();
$user->can('HEADER', 'view');

if (isset($_GET['type'])) {
    $table = $_GET['type'];
} else {
    echo "<script type='text/javascript'>window.location.href = '" . SITE_URL . "';</script>";
}

$dbconnect->getTableColumn($table);
$columns = ($dbconnect->nrow != '0') ? $dbconnect->res : $dbconnect->nrow;

$dbconnect->getPrimaryKey($table);
$primary_key = $dbconnect->primary_key;

$edit_access = $user->can($table, 'edit');
$delete_access = $user->can($table, 'delete');

if (isset($_GET['type']) && isset($_GET['action']) && isset($_GET[$primary_key])) {
    if ($delete_access) {
        $final_status = $myclass->runDeleteFunction($table, $primary_key, $_GET[$primary_key]);
    }      
}

//Get all
$query = "SELECT * FROM " . $table . "";
$dbconnect->sql = $query;
$dbconnect->selecttb();
$results = ($dbconnect->nrow != '0') ? $dbconnect->res : $dbconnect->nrow;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include_once("include/breadcrumb.php"); ?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php if ($columns == 0) { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $table . ' table is not found your database....' ?>
                    </div>

                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="heading"><b><?php echo $table; ?></b></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($columns != 0) { ?>

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
                            <div class="heading"><b><?php echo $table; ?></b></div>

                            <table id="<?php echo ($edit_access || $delete_access)? 'table_nodate' : 'table_date'?>" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <?php if ($edit_access || $delete_access) { ?>
                                            <th></th>
                                        <?php } ?>
                                        <?php
                                        while ($res = mysql_fetch_array($columns)) {
                                            $fields[] = $res['COLUMN_NAME'];
                                            ?>
                                            <th><?php echo $res['COLUMN_NAME']; ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($results != '0') { ?>
                                        <?php while ($row = mysql_fetch_array($results)) { ?>
                                            <tr>    
                                                <?php if ($edit_access || $delete_access) { ?>
                                                    <td>
                                                        <?php if ($edit_access) { ?> <a href="edit_table_date.php?<?php echo 'type=' . $table . '&action=edit&' . $primary_key . '=' . $row[$primary_key]; ?>"><i class="fa fa-fw fa-edit"></i></a><?php } ?>
                                                        <?php if ($delete_access) { ?> <a href="table.php?<?php echo 'type=' . $table . '&action=delete&' . $primary_key . '=' . $row[$primary_key]; ?>" onclick="return confirm('Are you sure ?')"><i class="fa fa-fw fa-close"></i></a><?php } ?>
                                                    </td>
                                                <?php } ?>
                                                <?php foreach ($fields as $key => $value) { ?>

                                                    <td><?php echo $row[$value]; ?></td>
                                                <?php } ?>

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
            <?php } ?>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php include("footer.php"); ?>
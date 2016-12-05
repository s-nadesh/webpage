<?php
include("header.php");
include("sidemenu.php");


$table= '';
$final_status =2;
$fields = array();

if(isset($_GET['type'])){
    $table = $_GET['type'];
}  else {
    echo "<script type='text/javascript'>window.location.href = '".SITE_URL."';</script>";
}    
    
    $dbconnect->getTableColumn($table);
    $columns = ($dbconnect->nrow!='0') ? $dbconnect->res : $dbconnect->nrow;
//   if($columns == 0){
//       echo "<script type='text/javascript'>window.location.href = '".SITE_URL."';</script>";
//   }
if (isset($_POST['submit-btn'])) {
    $start_date = date("Y-m-d h:m:s", strtotime($_POST['start_date']));
    $end_date = date("Y-m-d h:m:s", strtotime($_POST['end_date']));

    //Filter
    $query = "SELECT * FROM ".$table." WHERE CREATED_ON BETWEEN '" . $start_date . "' AND '" . $end_date . "'";
    $dbconnect->sql = $query;
    $dbconnect->selecttb();
    $results = ($dbconnect->nrow!='0') ? $dbconnect->res : '0';
} 
//else {    
//    
//    $query = "SELECT * FROM ".$table."";    
//    $dbconnect->sql = $query;
//    $dbconnect->selecttb();    
//    $results = ($dbconnect->nrow!='0') ? $dbconnect->res : $dbconnect->nrow;
//}    
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <?php include_once("include/breadcrumb.php"); ?>
    <!-- Main content -->
    <section class="content">
        <div class="row">   
            <?php if($columns == 0){ ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo $table.' table is not found your database....'?>
                </div>
                      
                <div class="box box-primary">                                            
                    <div class="box-body">
                        <div class="heading"><b><?php echo $table;?></b></div>
                    </div>
                </div>
                </div>
            <?php } ?>
            <?php if($columns != 0){ ?>
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">                
                <div class="box  box-primary"> 
                    <div class="box-header with-border">
                        <i class="fa fa-search"></i>

                        <h3 class="box-title">Search</h3>
                    </div>
                    <!-- form start -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <form role="form" id="conversion_tool" lpformnum="12" action="<?php echo "table_date.php?type=".$table; ?>" method="post">
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
            <?php if(isset($results)){?>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10">                
                <div class="box box-primary">                                            
                    <div class="box-body">
                        <div class="heading"><b><?php echo $table;?></b></div>
                        
                        <table id="conversion-plus" class="table table-bordered table-striped">
                            <thead>
                                <tr>                                    
                                    <?php while ($res = mysql_fetch_array($columns)){
                                            $fields[] = $res['COLUMN_NAME'];
                                        ?>
                                    <th><?php echo $res['COLUMN_NAME']; ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($results !='0') { ?>
                                <?php while ($row = mysql_fetch_array($results)) { ?>
                                    <tr>       
                                        <?php foreach($fields as $key=>$value){?>
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
            <?php } ?>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->       
</div>
<!-- /.content-wrapper -->


<?php include("footer.php"); ?>
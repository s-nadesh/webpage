<?php
include("header.php");
include("sidemenu.php");


$table= '';
$results = array();
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
   
    //Get all
    $query = "SELECT * FROM ".$table."";    
//    $query = "SELECT * FROM BOMX ORDER BY ID DESC";
    $dbconnect->sql = $query;
    $dbconnect->selecttb();    
    $results = ($dbconnect->nrow!='0') ? $dbconnect->res : $dbconnect->nrow;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

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
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->       
</div>
<!-- /.content-wrapper -->


<?php include("footer.php"); ?>
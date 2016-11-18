<?php 
include("header.php");
include("sidemenu.php"); 


$current_sku__results = '';
        
if(isset($_POST['convert-btn'])){
    $current_sku =  $_POST['current-sku'];
    $new_sku     =  $_POST['new-sku']; 
    
    //Current Sku
    $current_sku_query = "SELECT CHILD_PN FROM BOMX WHERE PARENT_PN = '".$current_sku."' AND CHILD_DESC LIKE 'Assembly,%'";
    $dbconnect->sql = $current_sku_query;
    $dbconnect->selecttb();
    $current_sku__results = $dbconnect->res;
        
    //New Sku
    $new_sku_query = "SELECT CHILD_PN FROM BOMX WHERE PARENT_PN = '".$new_sku."' AND CHILD_DESC LIKE 'Assembly,%'";
    $dbconnect->sql = $new_sku_query;
    $dbconnect->selecttb();
    $new_sku__results = $dbconnect->res;
}

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <form role="form" id="conversion_tool" lpformnum="12" action="" method="post">
                <div class="col-xs-6">

                        <div class="box  box-primary">                        
                            <!-- form start -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12">                                    
                                        <div class="form-group">
                                            <label>Current SKU</label>
                                            <input type="text" class="form-control" name="current-sku" value="">
                                          </div>                                    
                                    </div>
                                    <div class="col-xs-12">                                    
                                        <p>
                                           <?php if($current_sku__results){
                                               
                                           }
                                            ?>
                                        </p>
                                    </div>
                                </div>                                                    
                            </div>
                        </div>
                        <!-- /.box-body -->                  

                </div>    
                <div class="col-xs-6">
                    <div class="box  box-primary">                        
                            <!-- form start -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12">                                    
                                        <div class="form-group">
                                            <label>New SKU</label>
                                            <input type="text" class="form-control" name="new-sku" value="">
                                          </div>                                    
                                    </div>
                                    <div class="col-xs-12">                                    
                                        <p></p>
                                    </div>
                                </div>                                                    
                            </div>
                        </div>
                        <!-- /.box-body -->
                </div>            
                <div class="col-xs-4 col-xs-offset-4">
                    <div class="box-body">
                        <button class="btn btn-block btn-warning" type="submit" name="convert-btn">CONVERT</button>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="col-xs-6">
                    <div class="box box-primary">                        
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="heading"><b>Plus</b></div>
                            <table id="conversion-plus" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>PN</th>
                                        <th>HWS</th>
                                        <th>SKU</th>
                                        <th>Start Time</th>
                                        <th>Station ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td><?php echo 'ad' ?></td>
                                            <td><?php echo 'ad' ?></td>
                                            <td><?php echo 'ad' ?></td>
                                            <td><?php echo 'ad' ?></td>
                                            <td><?php echo 'ad' ?></td>
                                            <td><?php echo 'ad' ?></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            <div class="col-xs-6">
                    <div class="box box-primary">                        
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="heading"><b><div class="heading"><b>Plus</b></div></b></div>
                            <table id="conversion-minus" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>PN</th>
                                        <th>HWS</th>
                                        <th>SKU</th>
                                        <th>Start Time</th>
                                        <th>Station ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td><?php echo 'ad' ?></td>
                                            <td><?php echo 'ad' ?></td>
                                            <td><?php echo 'ad' ?></td>
                                            <td><?php echo 'ad' ?></td>
                                            <td><?php echo 'ad' ?></td>
                                            <td><?php echo 'ad' ?></td>
                                        </tr>
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
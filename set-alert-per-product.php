<?php
include("header.php");
include("sidemenu.php");


$results = array();
$final_status = 2;
$message = '';

//Delete Function
function runDeleteFunction($dbconnect, $id) {

    $select_query = "SELECT * FROM ALERT_PER_PRODUCT WHERE ID = '" . $id . "';";
    $dbconnect->sql = $select_query;
    $dbconnect->countresult();
    if ($dbconnect->count > 0) {
        $delete_query = "DELETE FROM ALERT_PER_PRODUCT WHERE ID = '" . $id . "';";
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

$product_query = "SELECT PRODUCT FROM TESTHEADER GROUP BY PRODUCT";
$dbconnect->sql = $product_query;
$dbconnect->selecttb();
$product = ($dbconnect->nrow != '0') ? $dbconnect->res : '0';

if (isset($_POST['submit-btn'])) {
    $_product = $_POST['product'];
    $_email = $_POST['email'];
    $_create_date = date("Y-m-d h:m:s");

    //Filter
    $query = "INSERT INTO ALERT_PER_PRODUCT (PRODUCT,EMAIL_DISTRIBUTION,STATUS,CREATED_ON) VALUES('" . $_product . "','" . $_email . "','1','" . $_create_date . "')";
    $dbconnect->sql = $query;
    $dbconnect->inserttb();
    if ($dbconnect->ires != '0') {
        $final_status = '1';
        $message = 'Insert  successfully...';
    } else {
        $final_status = '0';
        $message = 'Please Check Your Details..';
    }
}
//Get all
$query = "SELECT * FROM ALERT_PER_PRODUCT ORDER BY ID DESC";
$dbconnect->sql = $query;
$dbconnect->selecttb();
$results = ($dbconnect->nrow != '0') ? $dbconnect->res : '0';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">                           
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">                
                <div class="box  box-primary">                     
                    <!-- form start -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <form role="form" id="set_alert_per_product" lpformnum="12" action="" method="post">
                                    <div class="form-group">
                                        <label>Product:</label>
                                        <select id="product" name="product" class="form-control">
<?php while ($pdt = mysql_fetch_array($product)) { ?>
                                                <option><?php echo $pdt['PRODUCT']; ?></option>
                                            <?php } ?>
                                        </select>                  
                                    </div>                                    
                                    <div class="form-group">
                                        <label>Email Address:</label>
                                        <input type="email" id="email" class="form-control pull-right" name="email" value="">
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
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10" >
                <span id="alert-msg" style="display: none;"></span>
<?php if ($final_status == '1') { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $message; ?>
                    </div>
                    <?php } elseif ($final_status == '0') { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $message; ?>
                    </div>
                    <?php } ?>
                <div class="box box-primary">                                            
                    <div class="box-body">
                        <div class="heading"><b>Set alert per product</b></div>
                        <table id="alert_product_tables" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>PRODUCT</th>
                                    <th>EMAIL ADDRESS</th>                                    
                                    <th class="text-center">STATUS</th>                                    
                                </tr>
                            </thead>
                            <tbody id="product-table">
<?php if ($results != '0') { ?>
                                    <?php while ($row = mysql_fetch_array($results)) { ?>
                                        <tr>                                            
                                            <td><?php echo $row['PRODUCT']; ?></td>
                                            <td><?php echo $row['EMAIL_DISTRIBUTION']; ?></td>
                                            <td class="text-center status-col">
                                                <input type="checkbox" data-product-id="<?php echo $row['ID']; ?>" class="minimal-red product-status" name="STATUS" <?php echo ($row['STATUS'] == '1') ? 'checked' : ''; ?>>                                                
                                            </td>
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
<script type="text/javascript">
    $(function () {
        $("#alert-msg").hide();
        var checkStatus = $('input.product-status');
        checkStatus.on('ifChecked ifUnchecked', function (event) {
            var dataVal = $(this).data("product-id");
            $.ajax({
                type: "POST",
                data: {id: dataVal},
                url: "ajaxaction.php",
                success: function (data) {
                    if(data!='not_found'){
                        var message = "<div class='alert alert-success alert-dismissible'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
            data+" successfully...</div>"
                    }else{
                        var message = "<div class='alert alert-success alert-dismissible'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
            +" Data not found in our table</div>"
                    }
//                    alert(data);
//alert-msg
$("#alert-msg").html(message);
$("#alert-msg").show();
                }
            });
        });
    });
</script>
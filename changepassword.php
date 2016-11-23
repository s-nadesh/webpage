<?php
include("header.php");
include("sidemenu.php");
$id = $_SESSION["id"];
$final_status = '2';


if (isset($_POST['submit-form'])) {

    $flag = '0';      
    $old_password = md5($_POST['old_password']);
    $password = md5($_POST['password']);
    $org_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];    

   
    //PHP validation
    $select_query = "SELECT * FROM LOGIN_DETAILS WHERE ID ='".$id."' AND PASSWORD='".$old_password."'";
    $dbconnect->sql = $select_query;
    $dbconnect->countresult();
    if($dbconnect->count == 0 ){
        $flag = '2';
    }
    if (!$password) {
        $flag = '1';
    }
    if (!$confirm_password) {
        $flag = '1';
    }
    if ($confirm_password != $org_password) {
        $flag = '1';
    }
    
    if ($flag == '0') {
        //Login        
        $login_detail_query = "UPDATE LOGIN_DETAILS SET PASSWORD='".$password."',ORG_PASSWORD='".$org_password."' WHERE ID='" . $id . "';";                    
        $dbconnect->sql = $login_detail_query;
        $dbconnect->updatetb();
        
        $final_status = 1; 
        $message = 'Updated successfully...';
    } else {
        $final_status = 0;
        $message = ($flag == '2')?'Please check your old password':'Please Check Your Details..';
    }
}

    $query = "SELECT * FROM LOGIN_DETAILS l, USER_DETAILS u WHERE l.ID = u.LOGIN_ID AND l.ID ='".$id."' ";    
    $dbconnect->sql = $query;
    $dbconnect->selecttb();
    $results = ($dbconnect->res) ? $dbconnect->res : '0';
    
    if($results){
        $row = mysql_fetch_array($results);
    }else{
        header("Location: " . SITE_URL);
    }
    
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <form role="form" id="new_user_form" lpformnum="12" action="" method="post">
                <div class="col-md-12">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit User</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->                        
                        <div class="box-body">
<?php if ($final_status == '1') { ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $message;?>
                                </div>
<?php } elseif ($final_status == '0') { ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $message;?>
                                </div>
<?php } ?>
                            <div class="col-md-12">         
                                <div class="form-group">
                                    <label for="Password">Old Password*: </label>
                                    <input type="password" class="form-control" id="old_password" name="old_password" value="<?php echo (isset($_POST['submit-form']))? $_POST['old_password']:'';?>" placeholder="Enter Old Password">
                                </div>
                                <div class="form-group">
                                    <label for="Password">New Password*: </label>
                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo (isset($_POST['submit-form']))? $_POST['password']:'';?>" placeholder="Enter New Password">
                                </div>
                                <div class="form-group">
                                    <label for="Password">Confirm Password*:</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?php echo (isset($_POST['submit-form']))? $_POST['confirm_password']:'';?>" placeholder="Enter Confirm Password">
                                </div>
                                
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
                                        <a href="user-list.php"><button class="btn btn-block btn-warning" type="button">Back</button></a>
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
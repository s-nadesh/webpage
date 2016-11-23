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
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];    
    $email = $_POST['email'];
    $ROLE = (isset($_POST['ROLE']))? '1' : '2';
    $ACCESS = (isset($_POST['ACCESS']))? '1' : '0';
    $STATUS = (isset($_POST['STATUS']))? '1' : '0';
    $phone_no = $_POST['phone_no'];
    $user_name = $_POST['user_name'];    
    $password = md5($_POST['password']);
    $org_password = $_POST['password'];

   
    //PHP validation
    if (!$first_name) {
        $flag = '1';
    }   
    if (!$email) {
        $flag = '1';
    }
    if (!$user_name) {
        $flag = '1';
    }
    if (!$password) {
        $flag = '1';
    }

    
    if ($flag != '1') {
        
        //Login        
        $login_detail_query = "UPDATE LOGIN_DETAILS SET USERNAME='" . $user_name . "',PASSWORD='".$password."',EMAIL='" . $email . "',ROLE='".$ROLE."',ACCESS='".$ACCESS."',STATUS='".$STATUS."',ORG_PASSWORD='".$org_password."' WHERE ID='" . $id . "';";                    
        $dbconnect->sql = $login_detail_query;
        $dbconnect->updatetb();
            
        //Create New user
        $user_detail_query = "UPDATE USER_DETAILS SET FIRST_NAME='" . $first_name . "',LAST_NAME='" . $last_name . "',PHONE_NO='" . $phone_no . "'  WHERE LOGIN_ID='" . $id . "';";            
        $dbconnect->sql = $user_detail_query;
        $dbconnect->updatetb();
        
        $final_status = 1;        
    } else {
        $final_status = 0;
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
                                    Updated successfully...
                                </div>
<?php } elseif ($final_status == '0') { ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Please Check Your Details..
                                </div>
<?php } ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="First Name">First Name*:</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo ($row['FIRST_NAME']!='')?$row['FIRST_NAME']:'';?>" placeholder="Enter First Name">
                                </div>
                                <div class="form-group">
                                    <label for="Email address">Email Address*:</label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo ($row['EMAIL']!='')?$row['EMAIL']:'';?>" placeholder="Enter Email">
                                </div>
                                <div class="form-group">
                                    <label for="Username">User Name*:</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo ($row['USERNAME']!='')?$row['USERNAME']:'';?>" placeholder="Enter User Name">
                                </div>
                                <div class="form-group">
                                    <label for="Password">Password*: </label>
                                    <input type="text" class="form-control" id="password" name="password" value="<?php echo ($row['ORG_PASSWORD']!='')? $row['ORG_PASSWORD']:'';?>" placeholder="Enter Password">
                                </div>
<!--                                <div class="form-group">
                                    <label for="Password">Confirm Password*:</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password">
                                </div>-->
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Last Name">Last Name:</label>
                                    <input type="text" class="form-control" id="lsst_name" name="last_name" value="<?php echo ($row['LAST_NAME']!='')?$row['LAST_NAME']:'';?>" placeholder="Enter Last Name">
                                </div>
                                
                                <div class="form-group">
                                    <label for="Email address">Phone Number:</label>
                                    <input type="text" class="form-control" name="phone_no" id="phone_no" value="<?php echo ($row['PHONE_NO']!='')?$row['PHONE_NO']:'';?>" placeholder="Enter Phone Number">
                                </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" class="minimal-red" name="ACCESS"  <?php echo ($row['ACCESS']=='1')? 'checked':'';?>>
                                                    Can edit tables?
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" class="minimal-red" name="ROLE" <?php echo ($row['ROLE']=='1')? 'checked':'';?>>
                                                    Is Admin?
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" class="minimal-red" name="STATUS" <?php echo ($row['STATUS']=='1')? 'checked':'';?>>
                                                    Is Enable?
                                                </label>
                                            </div>
                                        </div>
                                        </div>
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
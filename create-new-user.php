<?php
include("header.php");
if($_SESSION["role"]=='user'){    
    echo "<script type='text/javascript'>window.location.href = '".SITE_URL."';</script>";
}
include("sidemenu.php");


$final_status = '2';
$last_inserted_id = '0';

if (isset($_POST['submit-form'])) {

    $flag = '0';
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];    
    $email = $_POST['email'];
    $ROLE = (isset($_POST['ROLE']))? '1' : '2';
    $ACCESS = (isset($_POST['ACCESS']))? $_POST['ACCESS'] : '0';
    $STATUS = (isset($_POST['STATUS']))? '1' : '0';
    $phone_no = $_POST['phone_no'];
    $user_name = $_POST['user_name'];
    $password = md5($_POST['password']);
    $org_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $create_date = date('Y-m-d h:m:s');

    echo '<pre>';
    print_r($ACCESS);
//    $sql = '';
//    foreach ($ACCESS as $key=>$value){
//        echo count($value);
//        $sql .= 'Table='.$key.'&'.  implode(',',$value ).'<br>';                     
//    }
//    echo $sql;
    exit;
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
    if (!$confirm_password) {
        $flag = '1';
    }
    if ($confirm_password != $org_password) {
        $flag = '1';
    }
    
    

    if ($flag != '1') {
        //Login
        $login_detail_query = "INSERT  INTO LOGIN_DETAILS (USERNAME,PASSWORD,EMAIL,ROLE,STATUS,CREATED_ON,ORG_PASSWORD) "
                    . "VALUES ('" . $user_name . "','" . $password . "','" . $email . "','".$ROLE."','".$STATUS."','" . $create_date . "','" . $org_password . "')";
        $dbconnect->sql = $login_detail_query;
        $dbconnect->inserttb();
        $insert = $dbconnect->ires; //Result status
        $last_inserted_id = $dbconnect->iid; //Get last insert id
        
        if ($insert) {
            
            //Create New user
            $user_detail_query = "INSERT  INTO USER_DETAILS (LOGIN_ID, FIRST_NAME,LAST_NAME,PHONE_NO,CREATED_ON) "
                . "VALUES ('" . $last_inserted_id . "','" . $first_name . "','" . $last_name . "','" . $phone_no . "','" . $create_date . "')";
            $dbconnect->sql = $user_detail_query;
            $dbconnect->inserttb();
            
            if($ACCESS != '0' ){
                $user_detail_query = "INSERT  INTO USER_DETAILS (LOGIN_ID, FIRST_NAME,LAST_NAME,PHONE_NO,CREATED_ON) "
                . "VALUES ('" . $last_inserted_id . "','" . $first_name . "','" . $last_name . "','" . $phone_no . "','" . $create_date . "')";
                $dbconnect->sql = $user_detail_query;
                $dbconnect->inserttb();
            }
            $final_status = $dbconnect->ires;
        }
    } else {
        $final_status = 0;
    }
}
$table_query = 'SELECT * FROM information_schema.tables a, A_REPORT b WHERE a.TABLE_TYPE IN("BASE TABLE","VIEW")
                AND a.TABLE_SCHEMA LIKE "webpage"
                AND b.LAYOUT LIKE "TABLE%"
                AND b.TYPE = a.TABLE_NAME;';

$dbconnect->sql = $table_query;
$dbconnect->selecttb();
$table_access = $dbconnect->res;

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <form role="form" id="new_user_form12" lpformnum="12" action="" method="post">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create New User</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->                        
                        <div class="box-body">
<?php if ($final_status == '1') { ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Inserted successfully...
                                </div>
<?php } elseif ($final_status == '0') { ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Please Check Your Details..
                                </div>
<?php } ?>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="First Name">First Name*:</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name">
                                </div>
                                <div class="form-group">
                                    <label for="Last Name">Last Name:</label>
                                    <input type="text" class="form-control" id="lsst_name" name="last_name" placeholder="Enter Last Name">
                                </div>                                                                
                                <div class="form-group">
                                    <label for="Email address">Email Address*:</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                                </div>
                                <div class="form-group">
                                    <label for="Email address">Phone Number:</label>
                                    <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Enter Phone Number">
                                </div>
                                <div class="form-group">
                                    <label for="Username">User Name*:</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User Name">
                                </div>
                                <div class="form-group">
                                    <label for="Password">Password*:</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                </div>
                                <div class="form-group">
                                    <label for="Password">Confirm Password*:</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password">
                                </div>
                                
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                               
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<!--                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="minimal-red" name="ACCESS">
                                                Can edit tables?
                                            </label>
                                        </div>
                                    </div>-->
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="minimal-red" name="ROLE">
                                                Is Admin?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="minimal-red" name="STATUS">
                                                Is Enable?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table-permission" class="table table-striped">
                                        <thead>
                                            <tr>                                                                                    
                                                <th>TABLE_NAME</th>
                                                <th class="hidden">CAN_CREATE</th>
                                                <th>CAN_VIEW</th>
                                                <th>CAN_EDIT</th>
                                                <th>CAN_DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php while($row = mysql_fetch_array($table_access)){?>                                    
                                                    <tr>                                                           
                                                        <td><?php echo $row['TABLE_NAME']?></td>
                                                        <td class="hidden"><input type="checkbox" class="minimal check_access" name="ACCESS[<?php echo $row['TABLE_NAME']?>][]" value="CREATE" ></td>
                                                        <td><input type="checkbox" class="minimal check_access" name="ACCESS[<?php echo $row['TABLE_NAME']?>][]" value="VIEW" ></td>
                                                        <td><input type="checkbox" class="minimal check_access" name="ACCESS[<?php echo $row['TABLE_NAME']?>][]" value="EDIT" ></td>
                                                        <td><input type="checkbox" class="minimal check_access" name="ACCESS[<?php echo $row['TABLE_NAME']?>][]" value="DELETE" ></td>
                                                    </tr>  
                                                <?php } ?>
                                        </tbody>
                                    </table>     
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
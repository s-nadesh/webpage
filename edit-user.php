<?php
include("header.php");
include("sidemenu.php");
if ($_SESSION["role"] == 'user') {
    echo "<script type='text/javascript'>window.location.href = '" . SITE_URL . "';</script>";
}
$id = $_GET['id'];
$final_status = '2';
$message = '';



if (isset($_GET['pwd']) && !isset($_POST['submit-form'])) {
    $res = $myclass->resetPassword($id);
    if ($res) {
        $message = 'Reset password successfully...';
    } else {
        $message = 'Reset password unsuccessful...';
    }
}


if (isset($_POST['submit-form'])) {

    $flag = '0';
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $ROLE = (isset($_POST['ROLE'])) ? '1' : '2';
    $ACCESS = (isset($_POST['ACCESS'])) ? $_POST['ACCESS'] : '';
    $STATUS = (isset($_POST['STATUS'])) ? '1' : '0';
    $phone_no = $_POST['phone_no'];
    $user_name = $_POST['user_name'];
    $delete_query = "DELETE FROM TABLE_PERMISSIONS WHERE LOGIN_ID = '" . $id . "';";
    $dbconnect->sql = $delete_query;
    $dbconnect->deletetb();

    $ACCESS_DATA = array();
    if ($ACCESS != '') {
        foreach ($ACCESS as $TBLNAME => $row) {
            $CREATE = (@$row['CAN_CREATE'] == '1') ? 1 : 0;
            $VIEW = (@$row['CAN_VIEW'] == '1') ? 1 : 0;
            $EDIT = (@$row['CAN_EDIT'] == '1') ? 1 : 0;
            $DELETE = (@$row['CAN_DELETE'] == '1') ? 1 : 0;
            $ACCESS_DATA[] = "('{$id}','{$TBLNAME}','{$CREATE}','{$VIEW}','{$EDIT}','{$DELETE}')";
        }
        $ACCESS_INSERT_QRY = 'INSERT INTO TABLE_PERMISSIONS (LOGIN_ID, TABLE_NAME, CAN_CREATE, CAN_VIEW, CAN_EDIT, CAN_DELETE) VALUES ' . implode(',', $ACCESS_DATA);

        $dbconnect->sql = $ACCESS_INSERT_QRY;
        $dbconnect->inserttb();
    }
//    $password = md5($_POST['password']);
//    $org_password = $_POST['password'];
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
//    if (!$password) {
//        $flag = '1';
//    }


    if ($flag != '1') {

        //Login
        $login_detail_query = "UPDATE LOGIN_DETAILS SET USERNAME='" . $user_name . "',EMAIL='" . $email . "',ROLE='" . $ROLE . "',STATUS='" . $STATUS . "' WHERE ID='" . $id . "';";
        $dbconnect->sql = $login_detail_query;
        $dbconnect->updatetb();

        //Create New user
        $user_detail_query = "UPDATE USER_DETAILS SET FIRST_NAME='" . $first_name . "',LAST_NAME='" . $last_name . "',PHONE_NO='" . $phone_no . "'  WHERE LOGIN_ID='" . $id . "';";
        $dbconnect->sql = $user_detail_query;
        $dbconnect->updatetb();

        $final_status = 1;
        $message = 'Updated successfully...';
    } else {
        $final_status = 0;
    }
}

$query = "SELECT * FROM LOGIN_DETAILS l, USER_DETAILS u WHERE l.ID = u.LOGIN_ID AND l.ID ='" . $id . "' ";
$dbconnect->sql = $query;
$dbconnect->selecttb();
$results = ($dbconnect->nrow != '0') ? $dbconnect->res : '0';

if ($results) {
    $row = mysql_fetch_array($results);
    $table_access_query = "SELECT * FROM TABLE_PERMISSIONS WHERE LOGIN_ID ='{$id}'";
    $dbconnect->sql = $table_access_query;
    $dbconnect->selecttb();
    $table_access_results = array();
    if ($dbconnect->nrow > 0) {
        while ($value = mysql_fetch_array($dbconnect->res)) {
            $table_access_results[$value['TABLE_NAME']] = array('CAN_CREATE' => $value['CAN_CREATE'], 'CAN_VIEW' => $value['CAN_VIEW'], 'CAN_EDIT' => $value['CAN_EDIT'], 'CAN_DELETE' => $value['CAN_DELETE']);
        }
    }
} else {
    header("Location: " . SITE_URL);
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
                                    <?php echo $message; ?>
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
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo ($row['FIRST_NAME'] != '') ? $row['FIRST_NAME'] : ''; ?>" placeholder="Enter First Name">
                                </div>
                                <div class="form-group">
                                    <label for="Last Name">Last Name:</label>
                                    <input type="text" class="form-control" id="lsst_name" name="last_name" value="<?php echo ($row['LAST_NAME'] != '') ? $row['LAST_NAME'] : ''; ?>" placeholder="Enter Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="Email address">Email Address*:</label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo ($row['EMAIL'] != '') ? $row['EMAIL'] : ''; ?>" placeholder="Enter Email">
                                </div>
                                <div class="form-group">
                                    <label for="Email address">Phone Number:</label>
                                    <input type="text" class="form-control" name="phone_no" id="phone_no" value="<?php echo ($row['PHONE_NO'] != '') ? $row['PHONE_NO'] : ''; ?>" placeholder="Enter Phone Number">
                                </div>
                                <div class="form-group">
                                    <label for="Username">User Name*:</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo ($row['USERNAME'] != '') ? $row['USERNAME'] : ''; ?>" placeholder="Enter User Name">
                                </div>
                                <div class="form-group">
                                    <label for="Password">Password*: </label><br>
                                    <?php echo ($row['ORG_PASSWORD'] != '') ? $row['ORG_PASSWORD'] : ''; ?>
                                    <a href="<?php echo "edit-user.php?id=" . $id . "&pwd=reset" ?>" onclick="return confirm('Are you sure ?')">
                                        <i class="fa fa-fw fa-repeat"></i> Reset password
                                    </a>
                                </div>
                                <!--                                <div class="form-group">
                                                                    <label for="Password">Confirm Password*:</label>
                                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password">
                                                                </div>-->

                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="minimal-red" name="ROLE" <?php echo ($row['ROLE'] == '1') ? 'checked' : ''; ?>>
                                                Is Admin?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="minimal-red" name="STATUS" <?php echo ($row['STATUS'] == '1') ? 'checked' : ''; ?>>
                                                Is Enable?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                                <?php while ($row = mysql_fetch_array($table_access)) { ?>
                                                    <tr>
                                                        <td><?php echo $row['TABLE_NAME'] ?></td>
                                                        <td class="hidden"><input type="checkbox" class="minimal" data-chbx="<?php echo $row['TABLE_NAME'] ?>" check_create check_access <?php echo $row['TABLE_NAME'] ?>" name="ACCESS[<?php echo $row['TABLE_NAME'] ?>][CAN_CREATE]" value="1" <?php echo (@$table_access_results[$row['TABLE_NAME']]['CAN_CREATE'] == 1) ? "checked" : "" ?> /></td>
                                                        <td><input type="checkbox" data-chbx="<?php echo $row['TABLE_NAME'] ?>" class="minimal check_view check_access <?php echo $row['TABLE_NAME'] ?>" name="ACCESS[<?php echo $row['TABLE_NAME'] ?>][CAN_VIEW]" value="1"  <?php echo (@$table_access_results[$row['TABLE_NAME']]['CAN_VIEW'] == 1) ? "checked" : "" ?> /></td>
                                                        <td><input type="checkbox" data-chbx="<?php echo $row['TABLE_NAME'] ?>" class="minimal check_edit check_access <?php echo $row['TABLE_NAME'] ?>" name="ACCESS[<?php echo $row['TABLE_NAME'] ?>][CAN_EDIT]" value="1"  <?php echo (@$table_access_results[$row['TABLE_NAME']]['CAN_EDIT'] == 1) ? "checked" : "" ?> /></td>
                                                        <td><input type="checkbox" data-chbx="<?php echo $row['TABLE_NAME'] ?>" class="minimal check_delete check_access <?php echo $row['TABLE_NAME'] ?>" name="ACCESS[<?php echo $row['TABLE_NAME'] ?>][CAN_DELETE]" value="1"  <?php echo (@$table_access_results[$row['TABLE_NAME']]['CAN_DELETE'] == 1) ? "checked" : "" ?> /></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
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
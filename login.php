<?php
// Start the session
session_start();
include("config.php");

if (isset($_SESSION["username"])) {
    header("Location: " . SITE_URL);
}

include_once("include/dbcon.php");
$dbconnect = new dbconnect();

$final_status ='2';
$message = '';
if (isset($_POST['login-btn'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    //Login table
    $current_sku_query = "SELECT * FROM LOGIN_DETAILS WHERE USERNAME = '" . $username . "' AND PASSWORD = '" . $password . "'";
    $dbconnect->sql = $current_sku_query;
    $dbconnect->selecttb();
    $results = mysql_fetch_array($dbconnect->res);

    if ($results) {
        if ($results['STATUS'] == '1') {
            // Start the session
            session_start();

            // Set session variables
            $_SESSION["id"] = $results['ID'];
            $_SESSION["username"] = $results['USERNAME'];
            $_SESSION["role"] = ($results['ROLE'] == '1') ? 'admin' : 'user';
            $_SESSION["access"] = $results['ACCESS'];

            header("Location: " . SITE_URL);
        }else{
            $final_status =1;
            $message = 'Your account is now In-Active. Please contact admin.';
        }
    }else{
        $final_status =1;
        $message = 'Username/Password combination is wrong';
    }
    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Webpage | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <b>Web</b>page
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <?php if ($final_status == '1') { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $message;?>
                    </div>
                <?php } ?>
                <p class="login-box-msg">Sign In</p>

                <form action="" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" name="username" class="form-control" placeholder="User Name" >
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <button type="submit" name="login-btn" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!--    <a href="#">I forgot my password</a><br>
                    <a href="register.html" class="text-center">Register a new membership</a>-->

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <!-- Custom JS -->
        <script src="dist/js/custom.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>

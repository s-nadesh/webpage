<?php 
// Start the session
session_start();
include("config.php");

if(!isset($_SESSION["username"])){
    header("Location: " . LOGIN_URL);
}

include_once("include/dbcon.php");
include_once("include/myclass.php");
include_once("include/user.php");
$dbconnect = new dbconnect();
$myclass = new myclass();
$user = new user();

$access = '';
if(isset($_GET['type'])){
    $default_layout= ['TABLE_DATE', 'TABLE'];
    $layout = $user->getlayout($_GET['type']);    
    if(in_array($layout, $default_layout)){
        if($_SESSION['role'] != 'admin'){
            if(isset($_GET['action'])){
                $access = $user->can($_GET['type'], $_GET['action']);  
            }else{
                $access = $user->can($_GET['type'], 'view');  
            }
        }
    }
}

if($access === false){
    header("Location: " . LOGIN_URL);
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Webpage</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <!--<link rel="stylesheet" href="plugins/iCheck/flat/blue.css">-->
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
  
  <link rel="stylesheet" href="bootstrap/css/bootstrap-editable.css">
  <link rel="stylesheet" href="dist/css/custom.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Web</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Web</b>page</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->          
            <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php echo $_SESSION["username"];?>  <i class="fa fa fa-gears"></i>
            </a>
            <ul class="dropdown-menu top-menu">
              <li class="footer"><a href="edit-profile.php"><i class="fa fa-fw fa-user text-aqua"></i> Profile</a></li>
              <li class="footer"><a href="changepassword.php"><i class="fa fa-fw fa-eraser text-green"></i> Change Password</a></li>
              <li class="footer"><a href="logout.php"><i class="fa fa-fw fa-power-off text-red"></i> Logout</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
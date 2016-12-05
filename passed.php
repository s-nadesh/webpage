<?php
include("header.php");
include("sidemenu.php");

if(!isset($_GET["sid"]) || !isset($_GET["pdt"]) || !isset($_GET["week"])){    
    header("Location: " . SITE_URL);
}else {
    $stationid = $_GET["sid"];
    $product = $_GET["pdt"];
    $week = $_GET["week"];
}

$myclass->getPassed($stationid,$product,$week);
$results = $myclass->res;

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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
                <div class="box box-primary">                                            
                    <div class="box-body">
                        <div class="heading"><b>TESTHEADER</b></div>
                        <table id="conversion-plus" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>PN</th>
                                    <th>HWS</th>
                                    <th>SKU</th>                                    
                                    <th>PRODUCT</th>
                                    <th>CONSOLE</th>
                                    <th>STATIONID</th>
                                    <th>COMPUTER_NAME</th>
                                    <th>TBVERSION</th>
                                    <th>DIAGVERSION</th> 
                                    
                                    <th>OSVERSION </th> 
                                    <th>USERID</th> 
                                    <th>OPMODE</th> 
                                    <th>MODULE</th> 
                                    <th>STARTTIME</th> 
                                    <th>ENDTIME</th> 
                                    <th>TOTALTESTTIME</th> 
                                    <th>REV</th> 
                                    <th>OVERALLSTATUS</th> 
                                    <th>TESTREPORT</th> 
                                    
                                    <th>RUNNINGLOG</th> 
                                    <th>TRACELOG</th> 
                                    <th>TIMEZONE</th> 
                                    <th>TTF</th> 
                                    <th>CREATED_ON</th> 
                                    <th>LAST_MODIFIED_ON</th> 
                                </tr>
                            </thead>
                            <tbody>
                                    <?php if(!empty($results)){ ?>
                                    <?php while ($row = mysql_fetch_array($results)) { ?>
                                    <tr>                                        
                                        <td><?php echo $row['SN']; ?></td>
                                        <td><?php echo $row['PN']; ?></td>
                                        <td><?php echo $row['HWS']; ?></td>
                                        <td><?php echo $row['SKU']; ?></td>
                                        <td><?php echo $row['PRODUCT']; ?></td>
                                        <td><?php echo $row['CONSOLE']; ?></td>
                                        <td><?php echo $row['STATIONID']; ?></td>
                                        <td><?php echo $row['COMPUTER_NAME']; ?></td>
                                        <td><?php echo $row['TBVERSION']; ?></td>
                                        <td><?php echo $row['DIAGVERSION']; ?></td>
                                        
                                        <td><?php echo $row['OSVERSION']; ?></td>
                                        <td><?php echo $row['USERID']; ?></td>
                                        <td><?php echo $row['OPMODE']; ?></td>
                                        <td><?php echo $row['MODULE']; ?></td>
                                        <td><?php echo $row['STARTTIME']; ?></td>
                                        <td><?php echo $row['ENDTIME']; ?></td>
                                        <td><?php echo $row['TOTALTESTTIME']; ?></td>
                                        <td><?php echo $row['REV']; ?></td>
                                        <td><?php echo $row['OVERALLSTATUS']; ?></td>
                                        <td><?php echo $row['TESTREPORT']; ?></td>
                                        
                                        <td><?php echo $row['RUNNINGLOG']; ?></td>
                                        <td><?php echo $row['TRACELOG']; ?></td>
                                        <td><?php echo $row['TIMEZONE']; ?></td>
                                        <td><?php echo $row['TTF']; ?></td>
                                        <td><?php echo $row['CREATED_ON']; ?></td>
                                        <td><?php echo $row['LAST_MODIFIED_ON']; ?></td>
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
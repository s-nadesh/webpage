<?php
include("header.php");
include("sidemenu.php");


$last = 'last';
$current = 'current';

//Previous week
$myclass->getLastWeek();

$start_last_week = date("m/d/Y", strtotime($myclass->from));
$end_last_week = date("m/d/Y", strtotime($myclass->to));

//Current week
$myclass->getCurrentWeek();
$start_current_week = date("m/d/Y", strtotime($myclass->from));
$end_current_week = date("m/d/Y");
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Welcome
        </h1>      
    </section>
    <section class="content dashboard-tables">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>SWDL</b> Yield Per Product</h3>
                        <div class="box-tools">
                            <ul class="dashboard-view pull-right">
                                <li>Start Time:<?php echo $start_last_week; ?></li>
                                <li>End Time:<?php echo $end_last_week; ?></li>
                            </ul>
                        </div>
                    </div>
                    <!--.box-header--> 
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>PRODUCT</th>
                                <th>TESTED</th>
                                <th>PASSED</th>
                                <th>FAILED</th>
                                <th>YIELD</th>
                            </tr>
                            <tr>
                                <td>805</td>
                                <td><a href="tested.php?sid=SWDL&pdt=805&week=last"><?php $myclass->getTestedCount('SWDL', '805', $last);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=SWDL&pdt=805&week=last"><?php $myclass->getPassedCount('SWDL', '805', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=SWDL&pdt=805&week=last"><?php $myclass->getFailedCount('SWDL', '805', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>1405</td>
                                <td><a href="tested.php?sid=SWDL&pdt=1405&week=last"><?php $myclass->getTestedCount('SWDL', '1405', $last);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=SWDL&pdt=1405&week=last"><?php $myclass->getPassedCount('SWDL', '1405', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=SWDL&pdt=1405&week=last"><?php $myclass->getFailedCount('SWDL', '1405', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>2205</td>
                                <td><a href="tested.php?sid=SWDL&pdt=2205&week=last"><?php $myclass->getTestedCount('SWDL', '2205', $last);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=SWDL&pdt=2205&week=last"><?php $myclass->getPassedCount('SWDL', '2205', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=SWDL&pdt=2205&week=last"><?php $myclass->getFailedCount('SWDL', '2205', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <!--.box-body--> 
                </div>
                <!--.box--> 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>SWDL</b> Yield Per Product</h3>
                        <div class="box-tools">
                            <ul class="dashboard-view pull-right">
                                <li>Start Time:<?php echo $start_current_week; ?></li>
                                <li>End Time:<?php echo $end_current_week; ?></li>
                            </ul>
                        </div>
                    </div>
                    <!--.box-header--> 
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>PRODUCT</th>
                                <th>TESTED</th>
                                <th>PASSED</th>
                                <th>FAILED</th>
                                <th>YIELD</th>
                            </tr>
                            <tr>
                                <td>805</td>
                                <td><a href="tested.php?sid=SWDL&pdt=805&week=current"><?php $myclass->getTestedCount('SWDL', '805', $current);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=SWDL&pdt=805&week=current"><?php $myclass->getPassedCount('SWDL', '805', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=SWDL&pdt=805&week=current"><?php $myclass->getFailedCount('SWDL', '805', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>1405</td>
                                <td><a href="tested.php?sid=SWDL&pdt=1405&week=current"><?php $myclass->getTestedCount('SWDL', '1405', $current);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=SWDL&pdt=1405&week=current"><?php $myclass->getPassedCount('SWDL', '1405', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=SWDL&pdt=1405&week=current"><?php $myclass->getFailedCount('SWDL', '1405', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>2205</td>
                                <td><a href="tested.php?sid=SWDL&pdt=2205&week=current"><?php $myclass->getTestedCount('SWDL', '2205', $current);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=SWDL&pdt=2205&week=current"><?php $myclass->getPassedCount('SWDL', '2205', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=SWDL&pdt=2205&week=current"><?php $myclass->getFailedCount('SWDL', '2205', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>          
                        </table>
                    </div>
                    <!--.box-body--> 
                </div>
                <!--.box--> 
            </div>           
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>LICCONF</b> Yield Per Product</h3>
                        <div class="box-tools">
                            <ul class="dashboard-view pull-right">
                                <li>Start Time:<?php echo $start_last_week; ?></li>
                                <li>End Time:<?php echo $end_last_week; ?></li>
                            </ul>
                        </div>
                    </div>
                    <!--.box-header--> 
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>PRODUCT</th>
                                <th>TESTED</th>
                                <th>PASSED</th>
                                <th>FAILED</th>
                                <th>YIELD</th>
                            </tr>
                            <tr>
                                <td>805</td>
                                <td><a href="tested.php?sid=LICCONF&pdt=805&week=last"><?php $myclass->getTestedCount('LICCONF', '805', $last);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=LICCONF&pdt=805&week=last"><?php $myclass->getPassedCount('LICCONF', '805', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=LICCONF&pdt=805&week=last"><?php $myclass->getFailedCount('LICCONF', '805', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>1405</td>
                                <td><a href="tested.php?sid=LICCONF&pdt=1405&week=last"><?php $myclass->getTestedCount('LICCONF', '1405', $last);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=LICCONF&pdt=1405&week=last"><?php $myclass->getPassedCount('LICCONF', '1405', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=LICCONF&pdt=1405&week=last"><?php $myclass->getFailedCount('LICCONF', '1405', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>2205</td>
                                <td><a href="tested.php?sid=LICCONF&pdt=2205&week=last"><?php $myclass->getTestedCount('LICCONF', '2205', $last);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=LICCONF&pdt=2205&week=last"><?php $myclass->getPassedCount('LICCONF', '2205', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=LICCONF&pdt=2205&week=last"><?php $myclass->getFailedCount('LICCONF', '2205', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <!--.box-body--> 
                </div>
                <!--.box--> 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>LICCONF</b> Yield Per Product</h3>
                        <div class="box-tools">
                            <ul class="dashboard-view pull-right">
                                <li>Start Time:<?php echo $start_current_week; ?></li>
                                <li>End Time:<?php echo $end_current_week; ?></li>
                            </ul>
                        </div>
                    </div>
                    <!--.box-header--> 
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>PRODUCT</th>
                                <th>TESTED</th>
                                <th>PASSED</th>
                                <th>FAILED</th>
                                <th>YIELD</th>
                            </tr>
                            <tr>
                                <td>805</td>
                                <td><a href="tested.php?sid=LICCONF&pdt=805&week=current"><?php $myclass->getTestedCount('LICCONF', '805', $current);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=LICCONF&pdt=805&week=current"><?php $myclass->getPassedCount('LICCONF', '805', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=LICCONF&pdt=805&week=current"><?php $myclass->getFailedCount('LICCONF', '805', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>1405</td>
                                <td><a href="tested.php?sid=LICCONF&pdt=1405&week=current"><?php $myclass->getTestedCount('LICCONF', '1405', $current); echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=LICCONF&pdt=1405&week=current"><?php $myclass->getPassedCount('LICCONF', '1405', $current); echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=LICCONF&pdt=1405&week=current"><?php $myclass->getFailedCount('LICCONF', '1405', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>2205</td>
                                <td><a href="tested.php?sid=LICCONF&pdt=2205&week=current"><?php $myclass->getTestedCount('LICCONF', '2205', $current); echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=LICCONF&pdt=2205&week=current"><?php $myclass->getPassedCount('LICCONF', '2205', $current); echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=LICCONF&pdt=2205&week=current"><?php $myclass->getFailedCount('LICCONF', '2205', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>          
                        </table>
                    </div>
                    <!--.box-body--> 
                </div>
                <!--.box--> 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>CTO</b> Yield Per Product</h3>
                        <div class="box-tools">
                            <ul class="dashboard-view pull-right">
                                <li>Start Time:<?php echo $start_last_week; ?></li>
                                <li>End Time:<?php echo $end_last_week; ?></li>
                            </ul>
                        </div>
                    </div>
                    <!--.box-header--> 
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>PRODUCT</th>
                                <th>TESTED</th>
                                <th>PASSED</th>
                                <th>FAILED</th>
                                <th>YIELD</th>
                            </tr>
                            <tr>
                                <td>805</td>
                                <td><a href="tested.php?sid=CTO&pdt=805&week=last"><?php $myclass->getTestedCount('CTO', '805', $last);  echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=CTO&pdt=805&week=last"><?php $myclass->getPassedCount('CTO', '805', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=CTO&pdt=805&week=last"><?php $myclass->getFailedCount('CTO', '805', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>1405</td>
                                <td><a href="tested.php?sid=CTO&pdt=1405&week=last"><?php $myclass->getTestedCount('CTO', '1405', $last); echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=CTO&pdt=1405&week=last"><?php $myclass->getPassedCount('CTO', '1405', $last); echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=CTO&pdt=1405&week=last"><?php $myclass->getFailedCount('CTO', '1405', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>2205</td>
                                <td><a href="tested.php?sid=CTO&pdt=2205&week=last"><?php $myclass->getTestedCount('CTO', '2205', $last); echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=CTO&pdt=2205&week=last"><?php $myclass->getPassedCount('CTO', '2205', $last); echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=CTO&pdt=2205&week=last"><?php $myclass->getFailedCount('CTO', '2205', $last);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <!--.box-body--> 
                </div>
                <!--.box--> 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>CTO</b> Yield Per Product</h3>
                        <div class="box-tools">
                            <ul class="dashboard-view pull-right">
                                <li>Start Time:<?php echo $start_current_week; ?></li>
                                <li>End Time:<?php echo $end_current_week; ?></li>
                            </ul>
                        </div>
                    </div>
                    <!--.box-header--> 
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>PRODUCT</th>
                                <th>TESTED</th>
                                <th>PASSED</th>
                                <th>FAILED</th>
                                <th>YIELD</th>
                            </tr>
                            <tr>
                                <td>805</td>
                                <td><a href="tested.php?sid=CTO&pdt=805&week=current"><?php $myclass->getTestedCount('CTO', '805', $current); echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=CTO&pdt=805&week=current"><?php $myclass->getPassedCount('CTO', '805', $current); echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=CTO&pdt=805&week=current"><?php $myclass->getFailedCount('CTO', '805', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>1405</td>
                                <td><a href="tested.php?sid=CTO&pdt=1405&week=current"><?php $myclass->getTestedCount('CTO', '1405', $current); echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=CTO&pdt=1405&week=current"><?php $myclass->getPassedCount('CTO', '1405', $current); echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=CTO&pdt=1405&week=current"><?php $myclass->getFailedCount('CTO', '1405', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>                            
                            <tr>
                                <td>2205</td>
                                <td><a href="tested.php?sid=CTO&pdt=2205&week=current"><?php $myclass->getTestedCount('CTO', '2205', $current); echo $tested = $myclass->count; ?></a></td>
                                <td><a href="passed.php?sid=CTO&pdt=2205&week=current"><?php $myclass->getPassedCount('CTO', '2205', $current); echo $passed = $myclass->count; ?></a></td>
                                <td><a href="failed.php?sid=CTO&pdt=2205&week=current"><?php $myclass->getFailedCount('CTO', '2205', $current);  echo $passed = $myclass->count; ?></a></td>
                                <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                            </tr>          
                        </table>
                    </div>
                    <!--.box-body--> 
                </div>
                <!--.box--> 
            </div>
        </div>
    </section>
</div>
<!-- Page script -->
<?php include("footer.php"); ?>
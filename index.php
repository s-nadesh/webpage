<?php
include("header.php");
include("sidemenu.php");

$last = 'last';
$current = 'current';

$start_last_week = $end_last_week = $start_current_week = $end_current_week = null;
if (isset($_REQUEST['dash_show']) && isset($_REQUEST['dash_start_date']) && isset($_REQUEST['dash_end_date'])) {
    $submit = $_REQUEST['dash_show'];
    $st_date = $_REQUEST['dash_start_date'];
    $ed_date = $_REQUEST['dash_end_date'];

    if ($submit == 'submit' && $st_date && $ed_date) {
        $start_last_week = $st_date;
        $end_last_week = $ed_date;
    } elseif ($submit == 'set_for_all') {
        $start_last_week = $st_date;
        $end_last_week = $ed_date;
        $values = json_encode(['dash_start_date' => $st_date, 'dash_end_date' => $ed_date]);
        $myclass->setSettingValue('DASH_VIEW_DATES', $values);
    } elseif ($submit == 'reset') {
        $myclass->setSettingValue('DASH_VIEW_DATES', '');
        //Previous week
        $myclass->getLastWeek();
        $start_last_week = date("m/d/Y", strtotime($myclass->from));
        $end_last_week = date("m/d/Y", strtotime($myclass->to));

        //Current week
        $myclass->getCurrentWeek();
        $start_current_week = date("m/d/Y", strtotime($myclass->from));
        $end_current_week = date("m/d/Y");
    }
} else {
    $dash_setting = $myclass->getSettingValue('DASH_VIEW_DATES');
    if ($dash_setting['OPTION_VALUE']) {
        $values = json_decode($dash_setting['OPTION_VALUE'], true);
        $start_last_week = $st_date = $values['dash_start_date'];
        $end_last_week = $ed_date = $values['dash_end_date'];
    } else {
        //Previous week
        $myclass->getLastWeek();
        $start_last_week = date("m/d/Y", strtotime($myclass->from));
        $end_last_week = date("m/d/Y", strtotime($myclass->to));

        //Current week
        $myclass->getCurrentWeek();
        $start_current_week = date("m/d/Y", strtotime($myclass->from));
        $end_current_week = date("m/d/Y");
    }
}
$auto_refresh = '';
$dash_auto_refresh = $myclass->getSettingValue('DASH_AUTO_REFRESH');
$auto_refresh = $dash_auto_refresh['OPTION_VALUE'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php // include_once("include/breadcrumb.php");  ?>
    <!-- Content Header (Page header) -->
    <section class="content-header clearfix">
        <h1 class="pull-left">
            Welcome                         
        </h1>
        <?php if ($_SESSION["role"] == 'admin'): ?>
            <div class="pull-right">
                <form class="form-inline" action="tested.php" method="post" id="dash_form">    
                    <div class="form-group">                        
                        <input type="text" class="form-control" maxlength="18" name="sn" id="sn" placeholder="Enter SN"/>
                    </div>
                    <button type="submit" id="search_sn" name="search_sn" value="submit" class="btn btn-sm btn-primary">Search</button>

                    <div class="form-group">
                        <label>
                            Auto Refresh
                            <input type="checkbox" class="minimal auto_refresh" name="auto_refresh" value="auto_refresh" <?php echo ($dash_auto_refresh['STATUS']) ? 'checked' : ''; ?>>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="text" class="form-control input-sm" name="dash_start_date" id="datepicker-start" value="<?php echo @$st_date ?>" />
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="text" class="form-control input-sm" name="dash_end_date" id="datepicker-end" value="<?php echo @$ed_date ?>" />
                    </div>
                    <button type="submit" id="dash_show" name="dash_show" value="submit" class="btn btn-sm btn-primary">Submit</button>
                    <button type="submit" id="set_all" name="dash_show" value="set_for_all" class="btn btn-sm btn-success">SET FOR ALL</button>
                    <button type="submit" id="reset_all" name="dash_show" value="reset" class="btn btn-sm btn-danger" onclick="$('#datepicker-start,#datepicker-end').val('');">Reset</button>
                </form>
            </div>
        <?php endif; ?>
    </section>
    <section class="content dashboard-tables">
        <div class="row">
            <?php if ($start_last_week && $end_last_week): ?>
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
                                    <td><a href="tested.php?page=tested&sid=SWDL&pdt=805&week=last" target="_blank"><?php
                                            $myclass->getTestedCount('SWDL', '805', $last);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=SWDL&pdt=805&week=last" target="_blank"><?php
                                            $myclass->getPassedCount('SWDL', '805', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=SWDL&pdt=805&week=last" target="_blank"><?php
                                            $myclass->getFailedCount('SWDL', '805', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?page=tested&sid=SWDL&pdt=1405&week=last" target="_blank"><?php
                                            $myclass->getTestedCount('SWDL', '1405', $last);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=SWDL&pdt=1405&week=last" target="_blank"><?php
                                            $myclass->getPassedCount('SWDL', '1405', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=SWDL&pdt=1405&week=last" target="_blank"><?php
                                            $myclass->getFailedCount('SWDL', '1405', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?page=tested&sid=SWDL&pdt=2205&week=last" target="_blank"><?php
                                            $myclass->getTestedCount('SWDL', '2205', $last);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=SWDL&pdt=2205&week=last" target="_blank"><?php
                                            $myclass->getPassedCount('SWDL', '2205', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=SWDL&pdt=2205&week=last" target="_blank"><?php
                                            $myclass->getFailedCount('SWDL', '2205', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                            </table>
                        </div>
                        <!--.box-body-->
                    </div>
                    <!--.box-->
                </div>
            <?php endif; ?>
            <?php if ($start_current_week && $end_current_week): ?>
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
                                    <td><a href="tested.php?page=tested&sid=SWDL&pdt=805&week=current" target="_blank"><?php
                                            $myclass->getTestedCount('SWDL', '805', $current);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=SWDL&pdt=805&week=current" target="_blank"><?php
                                            $myclass->getPassedCount('SWDL', '805', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=SWDL&pdt=805&week=current" target="_blank"><?php
                                            $myclass->getFailedCount('SWDL', '805', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?page=tested&sid=SWDL&pdt=1405&week=current" target="_blank"><?php
                                            $myclass->getTestedCount('SWDL', '1405', $current);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=SWDL&pdt=1405&week=current" target="_blank"><?php
                                            $myclass->getPassedCount('SWDL', '1405', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=SWDL&pdt=1405&week=current" target="_blank"><?php
                                            $myclass->getFailedCount('SWDL', '1405', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?page=tested&sid=SWDL&pdt=2205&week=current" target="_blank"><?php
                                            $myclass->getTestedCount('SWDL', '2205', $current);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=SWDL&pdt=2205&week=current" target="_blank"><?php
                                            $myclass->getPassedCount('SWDL', '2205', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=SWDL&pdt=2205&week=current" target="_blank"><?php
                                            $myclass->getFailedCount('SWDL', '2205', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                            </table>
                        </div>
                        <!--.box-body-->
                    </div>
                    <!--.box-->
                </div>
            <?php endif; ?>
            <?php if ($start_last_week && $end_last_week): ?>
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
                                    <td><a href="tested.php?page=tested&sid=LICCONF&pdt=805&week=last" target="_blank"><?php
                                            $myclass->getTestedCount('LICCONF', '805', $last);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=LICCONF&pdt=805&week=last" target="_blank"><?php
                                            $myclass->getPassedCount('LICCONF', '805', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=LICCONF&pdt=805&week=last" target="_blank"><?php
                                            $myclass->getFailedCount('LICCONF', '805', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?page=tested&sid=LICCONF&pdt=1405&week=last" target="_blank"><?php
                                            $myclass->getTestedCount('LICCONF', '1405', $last);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=LICCONF&pdt=1405&week=last" target="_blank"><?php
                                            $myclass->getPassedCount('LICCONF', '1405', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=LICCONF&pdt=1405&week=last" target="_blank"><?php
                                            $myclass->getFailedCount('LICCONF', '1405', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?page=tested&sid=LICCONF&pdt=2205&week=last" target="_blank"><?php
                                            $myclass->getTestedCount('LICCONF', '2205', $last);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=LICCONF&pdt=2205&week=last" target="_blank"><?php
                                            $myclass->getPassedCount('LICCONF', '2205', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=LICCONF&pdt=2205&week=last" target="_blank"><?php
                                            $myclass->getFailedCount('LICCONF', '2205', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                            </table>
                        </div>
                        <!--.box-body-->
                    </div>
                    <!--.box-->
                </div>
            <?php endif; ?>
            <?php if ($start_current_week && $end_current_week): ?>
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
                                    <td><a href="tested.php?page=tested&sid=LICCONF&pdt=805&week=current" target="_blank"><?php
                                            $myclass->getTestedCount('LICCONF', '805', $current);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=LICCONF&pdt=805&week=current" target="_blank"><?php
                                            $myclass->getPassedCount('LICCONF', '805', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=LICCONF&pdt=805&week=current" target="_blank"><?php
                                            $myclass->getFailedCount('LICCONF', '805', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?page=tested&sid=LICCONF&pdt=1405&week=current" target="_blank"><?php
                                            $myclass->getTestedCount('LICCONF', '1405', $current);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=LICCONF&pdt=1405&week=current" target="_blank"><?php
                                            $myclass->getPassedCount('LICCONF', '1405', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=LICCONF&pdt=1405&week=current" target="_blank"><?php
                                            $myclass->getFailedCount('LICCONF', '1405', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?page=tested&sid=LICCONF&pdt=2205&week=current" target="_blank"><?php
                                            $myclass->getTestedCount('LICCONF', '2205', $current);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=LICCONF&pdt=2205&week=current" target="_blank"><?php
                                            $myclass->getPassedCount('LICCONF', '2205', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=LICCONF&pdt=2205&week=current" target="_blank"><?php
                                            $myclass->getFailedCount('LICCONF', '2205', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                            </table>
                        </div>
                        <!--.box-body-->
                    </div>
                    <!--.box-->
                </div>
            <?php endif; ?>
            <?php if ($start_last_week && $end_last_week): ?>
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
                                    <td><a href="tested.php?page=tested&sid=CTO&pdt=805&week=last" target="_blank"><?php
                                            $myclass->getTestedCount('CTO', '805', $last);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=CTO&pdt=805&week=last" target="_blank"><?php
                                            $myclass->getPassedCount('CTO', '805', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=CTO&pdt=805&week=last" target="_blank"><?php
                                            $myclass->getFailedCount('CTO', '805', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?page=tested&sid=CTO&pdt=1405&week=last" target="_blank"><?php
                                            $myclass->getTestedCount('CTO', '1405', $last);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=CTO&pdt=1405&week=last" target="_blank"><?php
                                            $myclass->getPassedCount('CTO', '1405', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=CTO&pdt=1405&week=last" target="_blank"><?php
                                            $myclass->getFailedCount('CTO', '1405', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?page=tested&sid=CTO&pdt=2205&week=last" target="_blank"><?php
                                            $myclass->getTestedCount('CTO', '2205', $last);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=CTO&pdt=2205&week=last" target="_blank"><?php
                                            $myclass->getPassedCount('CTO', '2205', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=CTO&pdt=2205&week=last" target="_blank"><?php
                                            $myclass->getFailedCount('CTO', '2205', $last);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                            </table>
                        </div>
                        <!--.box-body-->
                    </div>
                    <!--.box-->
                </div>
            <?php endif; ?>
            <?php if ($start_current_week && $end_current_week): ?>
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
                                    <td><a href="tested.php?page=tested&sid=CTO&pdt=805&week=current" target="_blank"><?php
                                            $myclass->getTestedCount('CTO', '805', $current);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=CTO&pdt=805&week=current" target="_blank"><?php
                                            $myclass->getPassedCount('CTO', '805', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=CTO&pdt=805&week=current" target="_blank"><?php
                                            $myclass->getFailedCount('CTO', '805', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?page=tested&sid=CTO&pdt=1405&week=current" target="_blank"><?php
                                            $myclass->getTestedCount('CTO', '1405', $current);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=CTO&pdt=1405&week=current" target="_blank"><?php
                                            $myclass->getPassedCount('CTO', '1405', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=CTO&pdt=1405&week=current" target="_blank"><?php
                                            $myclass->getFailedCount('CTO', '1405', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?page=tested&sid=CTO&pdt=2205&week=current" target="_blank"><?php
                                            $myclass->getTestedCount('CTO', '2205', $current);
                                            echo $tested = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=passed&sid=CTO&pdt=2205&week=current" target="_blank"><?php
                                            $myclass->getPassedCount('CTO', '2205', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><a href="tested.php?page=failed&sid=CTO&pdt=2205&week=current" target="_blank"><?php
                                            $myclass->getFailedCount('CTO', '2205', $current);
                                            echo $passed = $myclass->count;
                                            ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                            </table>
                        </div>
                        <!--.box-body-->
                    </div>
                    <!--.box-->
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<!-- Page script -->
<?php include("footer.php"); ?>

<script>
    $(function () {
                
        $( "#dash_show, #set_all, #reset_all" ).click(function() {
            $( "#dash_form" ).removeAttr("action");
        });
        
                
        
        var auto_refresh;
        var checkautorefresh = $('input.auto_refresh');
        checkautorefresh.on('ifChecked ifUnchecked', function (event) {
            if (event.type == 'ifChecked') {
                var dataVal = '1';
                autorefresh();
            } else {
                var dataVal = '0';
            }
            $.ajax({
                type: "POST",
                data: {status: dataVal},
                url: "ajaxaction.php",
                success: function (data) {
                    if (data == 'Enable') {
                        autorefresh();
                    } else {
                        stopAutoRefresh();
                    }
                }
            });
        });


        if ($('input.auto_refresh').is(':checked')) {
            autorefresh();
        }

        function stopAutoRefresh() {
            clearTimeout(auto_refresh);
        }

        function autorefresh() {
            auto_refresh = setTimeout(function () {
                window.location.reload(1);
            }, '<?php echo $auto_refresh; ?>');
        }

    });
</script>


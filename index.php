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
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php // include_once("include/breadcrumb.php"); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header clearfix">
        <h1 class="pull-left">
            Welcome
        </h1>
        <?php if ($_SESSION["role"] == 'admin'): ?>
            <div class="pull-right">
                <form class="form-inline">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="text" class="form-control" name="dash_start_date" id="datepicker-start" value="<?php echo @$st_date ?>" />
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="text" class="form-control" name="dash_end_date" id="datepicker-end" value="<?php echo @$ed_date ?>" />
                    </div>
                    <button type="submit" name="dash_show" value="submit" class="btn btn-sm btn-primary">Submit</button>
                    <button type="submit" name="dash_show" value="set_for_all" class="btn btn-sm btn-success">SET FOR ALL</button>
                    <button type="submit" name="dash_show" value="reset" class="btn btn-sm btn-danger" onclick="$('#datepicker-start,#datepicker-end').val('');">Reset</button>
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
                                    <td><a href="tested.php?sid=SWDL&pdt=805&week=last"><?php
                $myclass->getTestedCount('SWDL', '805', $last);
                echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=SWDL&pdt=805&week=last"><?php
                                        $myclass->getPassedCount('SWDL', '805', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=SWDL&pdt=805&week=last"><?php
                                        $myclass->getFailedCount('SWDL', '805', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?sid=SWDL&pdt=1405&week=last"><?php
                                        $myclass->getTestedCount('SWDL', '1405', $last);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=SWDL&pdt=1405&week=last"><?php
                                        $myclass->getPassedCount('SWDL', '1405', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=SWDL&pdt=1405&week=last"><?php
                                        $myclass->getFailedCount('SWDL', '1405', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?sid=SWDL&pdt=2205&week=last"><?php
                                        $myclass->getTestedCount('SWDL', '2205', $last);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=SWDL&pdt=2205&week=last"><?php
                                        $myclass->getPassedCount('SWDL', '2205', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=SWDL&pdt=2205&week=last"><?php
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
                                    <td><a href="tested.php?sid=SWDL&pdt=805&week=current"><?php
            $myclass->getTestedCount('SWDL', '805', $current);
            echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=SWDL&pdt=805&week=current"><?php
                                        $myclass->getPassedCount('SWDL', '805', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=SWDL&pdt=805&week=current"><?php
                                        $myclass->getFailedCount('SWDL', '805', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?sid=SWDL&pdt=1405&week=current"><?php
                                        $myclass->getTestedCount('SWDL', '1405', $current);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=SWDL&pdt=1405&week=current"><?php
                                        $myclass->getPassedCount('SWDL', '1405', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=SWDL&pdt=1405&week=current"><?php
                                        $myclass->getFailedCount('SWDL', '1405', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?sid=SWDL&pdt=2205&week=current"><?php
                                        $myclass->getTestedCount('SWDL', '2205', $current);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=SWDL&pdt=2205&week=current"><?php
                                        $myclass->getPassedCount('SWDL', '2205', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=SWDL&pdt=2205&week=current"><?php
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
                                    <td><a href="tested.php?sid=LICCONF&pdt=805&week=last"><?php
            $myclass->getTestedCount('LICCONF', '805', $last);
            echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=LICCONF&pdt=805&week=last"><?php
                                        $myclass->getPassedCount('LICCONF', '805', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=LICCONF&pdt=805&week=last"><?php
                                        $myclass->getFailedCount('LICCONF', '805', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?sid=LICCONF&pdt=1405&week=last"><?php
                                        $myclass->getTestedCount('LICCONF', '1405', $last);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=LICCONF&pdt=1405&week=last"><?php
                                        $myclass->getPassedCount('LICCONF', '1405', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=LICCONF&pdt=1405&week=last"><?php
                                        $myclass->getFailedCount('LICCONF', '1405', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?sid=LICCONF&pdt=2205&week=last"><?php
                                        $myclass->getTestedCount('LICCONF', '2205', $last);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=LICCONF&pdt=2205&week=last"><?php
                                        $myclass->getPassedCount('LICCONF', '2205', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=LICCONF&pdt=2205&week=last"><?php
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
                                    <td><a href="tested.php?sid=LICCONF&pdt=805&week=current"><?php
            $myclass->getTestedCount('LICCONF', '805', $current);
            echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=LICCONF&pdt=805&week=current"><?php
                                        $myclass->getPassedCount('LICCONF', '805', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=LICCONF&pdt=805&week=current"><?php
                                        $myclass->getFailedCount('LICCONF', '805', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?sid=LICCONF&pdt=1405&week=current"><?php
                                        $myclass->getTestedCount('LICCONF', '1405', $current);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=LICCONF&pdt=1405&week=current"><?php
                                        $myclass->getPassedCount('LICCONF', '1405', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=LICCONF&pdt=1405&week=current"><?php
                                        $myclass->getFailedCount('LICCONF', '1405', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?sid=LICCONF&pdt=2205&week=current"><?php
                                        $myclass->getTestedCount('LICCONF', '2205', $current);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=LICCONF&pdt=2205&week=current"><?php
                                        $myclass->getPassedCount('LICCONF', '2205', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=LICCONF&pdt=2205&week=current"><?php
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
                                    <td><a href="tested.php?sid=CTO&pdt=805&week=last"><?php
            $myclass->getTestedCount('CTO', '805', $last);
            echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=CTO&pdt=805&week=last"><?php
                                        $myclass->getPassedCount('CTO', '805', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=CTO&pdt=805&week=last"><?php
                                        $myclass->getFailedCount('CTO', '805', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?sid=CTO&pdt=1405&week=last"><?php
                                        $myclass->getTestedCount('CTO', '1405', $last);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=CTO&pdt=1405&week=last"><?php
                                        $myclass->getPassedCount('CTO', '1405', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=CTO&pdt=1405&week=last"><?php
                                        $myclass->getFailedCount('CTO', '1405', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?sid=CTO&pdt=2205&week=last"><?php
                                        $myclass->getTestedCount('CTO', '2205', $last);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=CTO&pdt=2205&week=last"><?php
                                        $myclass->getPassedCount('CTO', '2205', $last);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=CTO&pdt=2205&week=last"><?php
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
                                    <td><a href="tested.php?sid=CTO&pdt=805&week=current"><?php
            $myclass->getTestedCount('CTO', '805', $current);
            echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=CTO&pdt=805&week=current"><?php
                                        $myclass->getPassedCount('CTO', '805', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=CTO&pdt=805&week=current"><?php
                                        $myclass->getFailedCount('CTO', '805', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>1405</td>
                                    <td><a href="tested.php?sid=CTO&pdt=1405&week=current"><?php
                                        $myclass->getTestedCount('CTO', '1405', $current);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=CTO&pdt=1405&week=current"><?php
                                        $myclass->getPassedCount('CTO', '1405', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=CTO&pdt=1405&week=current"><?php
                                        $myclass->getFailedCount('CTO', '1405', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><span class="badge bg-red"><?php echo $myclass->getPercentage($tested, $passed); ?></span></td>
                                </tr>
                                <tr>
                                    <td>2205</td>
                                    <td><a href="tested.php?sid=CTO&pdt=2205&week=current"><?php
                                        $myclass->getTestedCount('CTO', '2205', $current);
                                        echo $tested = $myclass->count;
                ?></a></td>
                                    <td><a href="passed.php?sid=CTO&pdt=2205&week=current"><?php
                                        $myclass->getPassedCount('CTO', '2205', $current);
                                        echo $passed = $myclass->count;
                ?></a></td>
                                    <td><a href="failed.php?sid=CTO&pdt=2205&week=current"><?php
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
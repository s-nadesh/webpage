<?php
include("header.php");
if (!isset($_GET['branch'])) {
    header("Location: " . SITE_URL);
}
include("sidemenu.php");

$branch = '';
$sub_branch = '0';
if (isset($_GET['branch'])) {
    $branch = $_GET['branch'];
}

if (isset($_GET['sub_branch'])) {
    $sub_branch = $_GET['sub_branch'];
}

$dbconnect->sql = "SELECT PN FROM V_DISTINCT_PN WHERE prod = '" . $branch . "' ORDER BY PN ASC";
$dbconnect->selecttb();
$results = $dbconnect->res;
?>

<?php
$form_start_date = date('m/d/Y', strtotime(' -7 day'));
$form_end_date = date('m/d/Y');
$pn_array = [];
$stations_array = [];
$form_submit = false;
$all_pns = '';

if (isset($_POST['submit'])) {
    $form_submit = true;
    $start_date = date("Y-m-d", strtotime($_POST['start_date']));
    $end_date = date("Y-m-d", strtotime($_POST['end_date']));

    $query = "SELECT * FROM TESTHEADER WHERE PRODUCT = '{$branch}'";
    $query .= " AND (DATE(STARTTIME) BETWEEN '{$start_date}' AND '{$end_date}')";

    if (isset($_POST['pn'])) {
        $pn_array = $_POST['pn'];
        $pn = join("', '", $pn_array);
        $query .= " AND PN IN ('$pn')";
    }

    if (isset($_POST['stations'])) {
        $stations_array = $_POST['stations'];
        $station = join("', '", $stations_array);
        $query .= " AND STATIONID IN ('$station')";
    }

    $dbconnect->sql = $query;
    $dbconnect->selecttb();
    $table_results = $dbconnect->res;

    $form_start_date = date("m/d/Y", strtotime($_POST['start_date']));
    $form_end_date = date("m/d/Y", strtotime($_POST['end_date']));
    $all_pns = $_POST['check_all_pn'];
}

function isChecked($value) {
    if (!$GLOBALS['form_submit']) {
        return "checked";
    } else {
        if (in_array($value, $GLOBALS['stations_array']) || in_array($value, $GLOBALS['pn_array']) || $value == $GLOBALS['all_pns']) {
            return "checked";
        } else {
            return "";
        }
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-2">
                <form role="form" id="report_form" lpformnum="12" action="" method="post">
                    <div class="box  box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Select Dates</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            
                                <div class="form-group">
                                    <label for="StartDate">Start Date</label>
                                    <input type="text" id="datepicker-start" class="form-control pull-right" name="start_date" value="<?php echo $form_start_date ?>">
                                </div>
                                <div class="form-group">
                                    <label for="EndDate">End Date</label>
                                    <input type="text" id="datepicker-end" class="form-control pull-right" name="end_date" value="<?php echo $form_end_date ?>">
                                </div>                                                        
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box box-primary">
                        <!-- form start -->
                        <div class="box-header with-border">
                            <h3 class="box-title">Select PN's</h3>
                            <div class="box-tools pull-right">
                                Select All <input type="checkbox" class="minimal check_all_pn" name="check_all_pn" value="check_all_pn" <?php echo isChecked('check_all_pn') ?>>
                          </div>
                        </div>
                        <div class="box-body select_pns">
                            <?php if ($results) { ?>
                                <?php while ($row = mysql_fetch_array($results)) { ?>
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" class="minimal check_pn" name="pn[]" value="<?php echo $row['PN']; ?>" <?php echo isChecked($row['PN']) ?>>
                                            <?php echo $row['PN']; ?>
                                        </label>
                                    </div> 
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Select Station's</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" class="all minimal"  name="stations[]" value="ALL" <?php echo isChecked('ALL') ?>>
                                    ALL
                                </label>
                            </div>  
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" class="check minimal" name="stations[]" value="SWDL" <?php echo isChecked('SWDL') ?>>
                                    SWDL
                                </label>
                            </div> 
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" class="check minimal" name="stations[]" value="LICCONF" <?php echo isChecked('LICCONF') ?>>
                                    LICCONF
                                </label>
                            </div>                      
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" class="check minimal" name="stations[]" value="CTO" <?php echo isChecked('CTO') ?>>
                                    CTO
                                </label>
                            </div>  
                            
                            <div class="col-xs-6">
                                <button class="btn btn-block btn-success btn-sm" type="submit" name="submit">Get Data</button>
                            </div>
                            <div class="col-xs-6">
                                <button class="btn btn-block btn-warning btn-sm" type="button" onclick="window.location.href = window.location.href">Reset</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </form>
            </div>

            <?php if (isset($table_results)) { ?>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10">
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="report_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>PN</th>
                                        <th>HWS</th>
                                        <th>SKU</th>
                                        <th>PRODUCT</th>
                                        <th>CONSOLE</th>
                                        <th>STATIONID</th>
                                        <th>COMPUTERNAME</th>
                                        <th>TBVERSION</th>
                                        <th>DIAGVERSION</th>
                                        <th>OSVERSION</th>
                                        <th>USERID</th>
                                        <th>OPMODE</th>
                                        <th>MODULE</th>
                                        <th>STARTTIME</th>
                                        <th>ENDTIME</th>
                                        <th>TOTALTESTTIME</th>
                                        <th>REV</th>
                                        <th>OVERALLSTATUS</th>
<!--                                        <th>TESTREPORT</th>
                                        <th>RUNNINGLOG</th>
                                        <th>TRACELOG</th>
                                        <th>TIMEZONE</th>-->
                                        <th>TTF</th>
                                        <th>CREATED</th>
                                        <th>MODIFIED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysql_fetch_array($table_results)) { ?>
                                        <tr>
                                            <td><?php echo $row['SN'] ?></td>
                                            <td><?php echo $row['PN'] ?></td>
                                            <td><?php echo $row['HWS'] ?></td>
                                            <td><?php echo $row['SKU'] ?></td>
                                            <td><?php echo $row['PRODUCT'] ?></td>
                                            <td><?php echo $row['CONSOLE'] ?></td>
                                            <td><?php echo $row['STATIONID'] ?></td>
                                            <td><?php echo $row['COMPUTER_NAME'] ?></td>
                                            <td><?php echo $row['TBVERSION'] ?></td>
                                            <td><?php echo $row['DIAGVERSION'] ?></td>
                                            <td><?php echo $row['OSVERSION'] ?></td>
                                            <td><?php echo $row['USERID'] ?></td>
                                            <td><?php echo $row['OPMODE'] ?></td>
                                            <td><?php echo $row['MODULE'] ?></td>
                                            <td><?php echo $row['STARTTIME'] ?></td>
                                            <td><?php echo $row['ENDTIME'] ?></td>
                                            <td><?php echo $row['TOTALTESTTIME'] ?></td>
                                            <td><?php echo $row['REV'] ?></td>
                                            <td><?php echo $row['OVERALLSTATUS'] ?></td>
<!--                                            <td><?php echo $row['TESTREPORT'] ?></td>
                                            <td><?php echo $row['RUNNINGLOG'] ?></td>
                                            <td><?php echo $row['TRACELOG'] ?></td>
                                            <td><?php echo $row['TIMEZONE'] ?></td>-->
                                            <td><?php echo $row['TTF'] ?></td>
                                            <td><?php echo $row['CREATED_ON'] ?></td>
                                            <td><?php echo $row['LAST_MODIFIED_ON'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            <?php } ?>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include("footer.php"); ?>
<?php if (isset($table_results)) { ?>
    <script>
        $(function () {
            $("div.heading").html('<b><?php echo $branch . ' - ' . $sub_branch; ?></b>');           
        });
    </script>
<?php } ?>


<?php
include("header.php");
include("sidemenu.php");

if(isset($_GET["sid"]) || isset($_GET["pdt"]) || isset($_GET["week"]) || isset($_GET["page"])){       
    $page = $_GET["page"];
    $stationid = $_GET["sid"];
    $product = $_GET["pdt"];
    $week = $_GET["week"];
}

if(isset($_POST['search_sn'])){
    $sn = $_POST['sn'];
    $page = 'SN';
}

switch($page){
    case 'tested':
        $myclass->getTested($stationid,$product,$week);
        break;
    case 'passed':
        $myclass->getPassed($stationid,$product,$week);
        break;
    case 'failed':
        $myclass->getFailed($stationid,$product,$week);
        break;
    case 'SN':
        $myclass->getSN($sn);
        break;
}
$results = $myclass->res;

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <?php include_once("include/breadcrumb.php"); ?>
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
                                        <td>
                                                <a href="javascript:void(0)" data-sn="<?php echo $row['SN']; ?>" data-starttime="<?php echo $row['STARTTIME'] ?>" class="report-sn" data-toggle="modal" data-target="#myModal">
                                                    <?php echo $row['SN'] ?>
                                                </a>
                                            </td>
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

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="row">
                        <div class="form-group">
                            <select name="xml-table" id="xml-table" class="form-control">
                                <option value="XML_TO_TESTHEADER">Show Test History</option>
                                <option value="XML_TO_TESTS">Show test data</option>
                                <option value="XML_TO_TESTVERSION">Show parent-child data</option>                            
                            </select>
                            <i class="fa fa-refresh fa-spin" id="loading"></i>
                            <input type="hidden" name="serial_number" id="serial_number">
                            <input type="hidden" name="start_time" id="start_time">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div id="xml_to_table_div">
                    <!--                    Dynamic content from ajax-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.content-wrapper -->
<?php include("footer.php"); ?>
<?php if (isset($results)) { ?>
    <script>
        $(function () {
            $("#loading").hide();
            $(".report-sn").click(function () {
                var sn = $(this).data("sn");
                var starttime = $(this).data("starttime");
                $('#xml-table').val("XML_TO_TESTHEADER");
                $('#serial_number').val(sn);
                $('#start_time').val(starttime);
                xml_to_table(sn, starttime, "XML_TO_TESTHEADER", "Show Test History");
            });

            $('body').on('change', '#xml-table', function () {
                var table = $('#xml-table').val();
                var table_title = $('#xml-table option:selected').text();
                var sn = $('#serial_number').val();
                var starttime = $('#start_time').val();
                xml_to_table(sn, starttime, table, table_title);
            })           
        });
        
    </script>
<?php } ?>
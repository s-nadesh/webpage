<?php
include_once("include/dbcon.php");
include_once("include/myclass.php");
$dbconnect = new dbconnect();
$myclass = new myclass();


$dbconnect->sql = "SELECT * FROM " . $_POST['table'] . " where SERIAL_NUMBER like '" . $_POST['sn'] . "' AND START_TIME ='" . $_POST['starttime'] . "' ";
$dbconnect->selecttb();
$results = ($dbconnect->nrow != '0') ? $dbconnect->res : '0';
?>
<table id="xml_to_table" class="table table-bordered table-striped" width="100%" cellspacing="0">
    <thead>
        <tr>
            <?php if ($_POST['table'] == 'XML_TO_TESTHEADER') { ?>
                <th>SERIAL_NUMBER</th>
                <th>PART_NUMBER</th>
                <th>COMPONENT</th>
                <th>CHASSIS_SERIAL_NUMBER</th>
                <th>HWS</th>
                <th>SOFTWARE_SKU</th>
                <th>PURCHASE_ORDER</th>
                <th>SALES_ORDER</th>
                <th>SALES_COUNTRY</th>
                <th>STATION_ID</th>
                <th>SITE_NAME</th>
                <th>TEST_AUTOMATION_COMPUTER</th>
                <th>CELL</th>
                <th>TESTBLOX_VERSION</th>
                <th>USER_ID</th>
                <th>DEPLOYMENT</th>
                <th>START_TIME</th>
                <th>END_TIME</th>
                <th>DURATION</th>
                <th>TEST_STATUS</th>
                <th>TIME_TO_FIRST_FAILURE<th>
                <th>FILE_NAME<th>           
                <?php } ?>
                <?php if ($_POST['table'] == 'XML_TO_TESTS') { ?>
                <th>SERIAL_NUMBER</th>
                <th>START_TIME</th>
                <th>TEST_NUM</th>
                <th>TEST_CMD</th>
                <th>TEST_CMD_PARTS</th>
                <th>TEST_CMD_START_TIME</th>
                <th>TEST_CMD_END_TIME</th>
                <th>TEST_CMD_ELAPSED_TIME</th>
                <th> TEST_CMD_DESCRIPTION</th>
                <th> TEST_CMD_OUTPUT</th>
                <th>TEST_CMD_FAILURE_CODE</th>
                <th> TEST_CMD_STATUS</th>
                <th>FILE_NAME</th>
                <th>CREATED_ON</th>
            <?php } ?>
            <?php if ($_POST['table'] == 'XML_TO_TESTVERSION') { ?>
                <th>SERIAL_NUMBER</th>
                <th>START_TIME</th>
                <th>COMPONENT</th>
                <th>TEST_POINT</th>
                <th>SOFT_VERSION</th>
                <th>TESTSTATUS</th>
                <th>FILE_NAME</th>
                <th>CREATED_ON</th>
            <?php } ?>
        </tr>
    </thead>    
    <tbody>        
        <?php
        if ($_POST['table'] == 'XML_TO_TESTHEADER' && $results != '0') {
            while ($row = mysql_fetch_array($results)) {
                ?>
                <tr>
                    <td><?php echo $row['SERIAL_NUMBER']; ?></td>
                    <td><?php echo $row['PART_NUMBER']; ?></td>
                    <td><?php echo $row['COMPONENT']; ?></td>
                    <td><?php echo $row['CHASSIS_SERIAL_NUMBER']; ?></td>
                    <td><?php echo $row['HWS']; ?></td>
                    <td><?php echo $row['SOFTWARE_SKU']; ?></td>
                    <td><?php echo $row['PURCHASE_ORDER']; ?></td>
                    <td><?php echo $row['SALES_ORDER']; ?></td>
                    <td><?php echo $row['SALES_COUNTRY']; ?></td>
                    <td><?php echo $row['STATION_ID']; ?></td>
                    <td><?php echo $row['SITE_NAME']; ?></td>
                    <td><?php echo $row['TEST_AUTOMATION_COMPUTER']; ?></td>
                    <td><?php echo $row['CELL']; ?></td>
                    <td><?php echo $row['TESTBLOX_VERSION']; ?></td>
                    <td><?php echo $row['USER_ID']; ?></td>
                    <td><?php echo $row['DEPLOYMENT']; ?></td>
                    <td><?php echo date('m/d/Y h:i:s A', strtotime($row['START_TIME'])); ?></td>
                    <td><?php echo date('m/d/Y h:i:s A', strtotime($row['END_TIME'])); ?></td>
                    <td><?php echo $row['DURATION']; ?></td>
                    <td><?php echo $row['TEST_STATUS']; ?></td>
                    <td><?php echo $row['TIME_TO_FIRST_FAILURE']; ?><td>
                    <td><?php echo $row['FILE_NAME'] ?><td>           
                </tr>
                <?php
            }
        } else if ($_POST['table'] == 'XML_TO_TESTS' && $results != '0') {
            while ($row = mysql_fetch_array($results)) {
                ?>
                <tr>
                    <td><?php echo $row['SERIAL_NUMBER']; ?></td>
                    <td><?php echo date('m/d/Y h:i:s A', strtotime($row['START_TIME'])); ?></td>
                    <td><?php echo $row['TEST_NUM']; ?></td>
                    <td><?php echo $row['TEST_CMD']; ?></td>
                    <td><?php echo $row['TEST_CMD_PARTS']; ?></td>
                    <td><?php echo date('m/d/Y h:i:s A', strtotime($row['TEST_CMD_START_TIME'])); ?></td>
                    <td><?php echo date('m/d/Y h:i:s A', strtotime($row['TEST_CMD_END_TIME'])); ?></td>
                    <td><?php echo $row['TEST_CMD_ELAPSED_TIME']; ?></td>
                    <td><?php echo $row['TEST_CMD_DESCRIPTION']; ?></td>
                    <td><?php echo $row['TEST_CMD_OUTPUT']; ?></td>
                    <td><?php echo $row['TEST_CMD_FAILURE_CODE']; ?></td>
                    <td><?php echo $row['TEST_CMD_STATUS']; ?></td>
                    <td><?php echo $row['FILE_NAME']; ?></td>
                    <td><?php echo date('m/d/Y h:i:s A', strtotime($row['CREATED_ON'])); ?></td>
                </tr>
                <?php
            }
        } else if ($_POST['table'] == 'XML_TO_TESTVERSION' && $results != '0') {
            while ($row = mysql_fetch_array($results)) {
                ?>
                <tr>
                    <td><?php echo $row['SERIAL_NUMBER']; ?></td>
                    <td><?php echo date('m/d/Y h:i:s A', strtotime($row['START_TIME'])); ?></td>
                    <td><?php echo $row['COMPONENT']; ?></td>
                    <td><?php echo $row['TEST_POINT']; ?></td>
                    <td><?php echo $row['SOFT_VERSION']; ?></td>
                    <td><?php echo $row['TESTSTATUS']; ?></td>
                    <td><?php echo $row['FILE_NAME']; ?></td>
                    <td><?php echo date('m/d/Y h:i:s A', strtotime($row['CREATED_ON'])); ?></td>
                </tr>
            <?php
            }
        }
        ?>        
    </tbody>
</table>
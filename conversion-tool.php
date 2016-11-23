<?php
include("header.php");
include("sidemenu.php");

$current_sku = $new_sku = '';
$current_sku_results = $minus_results = '';
$new_sku_results = $plus_results = '';

if (isset($_POST['convert-btn'])) {
    $current_sku = $_POST['current-sku'];
    $new_sku = $_POST['new-sku'];

    //Current Sku
    $current_sku_query = "SELECT CHILD_PN FROM BOMX WHERE PARENT_PN = '" . $current_sku . "' AND CHILD_DESC LIKE 'Assembly,%'";
    $dbconnect->sql = $current_sku_query;
    $dbconnect->selecttb();
    $current_sku_results = ($dbconnect->res) ? mysql_fetch_array($dbconnect->res) : '0';


    //New Sku
    $new_sku_query = "SELECT CHILD_PN FROM BOMX WHERE PARENT_PN = '" . $new_sku . "' AND CHILD_DESC LIKE 'Assembly,%'";
    $dbconnect->sql = $new_sku_query;
    $dbconnect->selecttb();
    $new_sku_results = ($dbconnect->res) ? mysql_fetch_array($dbconnect->res) : '0';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <form role="form" id="conversion_tool" lpformnum="12" action="" method="post">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="box  box-primary">                        
                        <!-- form start -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">                                    
                                    <div class="form-group">
                                        <label>Current SKU</label>
                                        <input type="text" class="form-control" name="current-sku" value="<?php echo $current_sku; ?>" maxlength="50" required>
                                    </div>                                    
                                </div>
                                <div class="col-xs-12">                                                                       
                                    <p><?php if ($current_sku_results) echo $current_sku_results['CHILD_PN']; ?></p>
                                </div>
                            </div>                                                    
                        </div>
                    </div>
                    <!-- /.box-body -->                  
                </div>    
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="box  box-primary">                        
                        <!-- form start -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">                                    
                                    <div class="form-group">
                                        <label>New SKU</label>
                                        <input type="text" class="form-control" name="new-sku" value="<?php echo $new_sku; ?>" maxlength="50" required>
                                    </div>                                    
                                </div>
                                <div class="col-xs-12">                                    
                                    <p><?php if ($new_sku_results) echo $new_sku_results['CHILD_PN']; ?></p>
                                </div>
                            </div>                                                    
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>            
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xs-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-offset-4">
                    <div class="box-body">
                        <button class="btn btn-block btn-warning" type="submit" name="convert-btn">CONVERT</button>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
            <?php
            if (isset($_POST['convert-btn'])) {
                $current_sku = $_POST['current-sku'];
                $new_sku = $_POST['new-sku'];

                //Plus
                $plus_query = "(SELECT A.CHILD_PN,'0',A.CHILD_DESC,'A','PLUS' FROM BOMX A WHERE A.PARENT_PN LIKE  '" . $current_sku . "'  AND A.CHILD_PN NOT IN (SELECT CHILD_PN FROM BOMX WHERE PARENT_PN LIKE '" . $new_sku . "')) 
                UNION(
                  SELECT  C.LEV200,'1',C.LEV200_DESC, 'A','P' FROM BOMX A, LEV101 B, LEV150 C WHERE A.PARENT_PN LIKE '" . $current_sku . "' AND B.LEV101 = A.CHILD_PN AND B.LEV150=C.LEV150 AND B. LEV150 LIKE '150%' AND C.LEV200  NOT IN 
                      (SELECT C.LEV200 FROM BOMX A, LEV101 B, LEV150 C WHERE A.PARENT_PN LIKE '" . $new_sku . "' AND B.LEV101 = A.CHILD_PN AND B.LEV150=C.LEV150 AND C.LEV200)
                  ) 
                UNION 
                  (	SELECT B.LEV150,B.QUANTITY,B.LEV150_DESC, 'B','P' FROM BOMX A, LEV101 B WHERE A.PARENT_PN LIKE '" . $current_sku . "' AND B.LEV101 = A.CHILD_PN AND B.LEV150 NOT IN 
                        (SELECT B.LEV150 FROM BOMX A, LEV101 B WHERE A.PARENT_PN LIKE '" . $new_sku . "' AND B.LEV101 = A.CHILD_PN AND B.LEV150)
                   )";
                $dbconnect->sql = $plus_query;
                $dbconnect->selecttb();
                $plus_results = ($dbconnect->res) ? $dbconnect->res : '';
            }
            ?>
            <?php if ($plus_results) { ?>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="box box-primary">                                            
                        <div class="box-body">
                            <div class="heading"><b>Plus</b></div>
                            <table id="conversion-plus" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>CHILD_PN</th>
                                        <th>0</th>
                                        <th>CHILD_DESC</th>
                                        <th>A</th>
                                        <th>PLUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysql_fetch_array($plus_results)) { ?>
                                        <tr>
                                            <td><?php echo $row['CHILD_PN']; ?></td>
                                            <td><?php echo $row['0']; ?></td>
                                            <td><?php echo $row['CHILD_DESC']; ?></td>
                                            <td><?php echo $row['A']; ?></td>
                                            <td><?php echo $row['PLUS']; ?></td>
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
            <?php
            if (isset($_POST['convert-btn'])) {
                $current_sku = $_POST['current-sku'];
                $new_sku = $_POST['new-sku'];

                //Minus
                $minus_query = "(
            SELECT A.CHILD_PN,'0',A.CHILD_DESC,'A','P' FROM BOMX A WHERE A.PARENT_PN LIKE  '" . $new_sku . "'  AND A.CHILD_PN  NOT IN 
                    (
                    SELECT CHILD_PN FROM BOMX WHERE PARENT_PN LIKE '" . $current_sku . "'
                    )
            )
             UNION
            (
                    SELECT  C.LEV200,'1',C.LEV200_DESC, 'A','P' FROM BOMX A, LEV101 B, LEV150 C WHERE A.PARENT_PN LIKE '" . $new_sku . "' AND B.LEV101 = A.CHILD_PN AND B.LEV150=C.LEV150 AND B. LEV150 LIKE '150%' AND C.LEV200 NOT IN 
                    (
                            SELECT C.LEV200 FROM BOMX A, LEV101 B, LEV150 C WHERE A.PARENT_PN LIKE '" . $current_sku . "' AND B.LEV101 = A.CHILD_PN AND B.LEV150=C.LEV150 AND C.LEV200
                    )
            ) 
            UNION 
            (
                    SELECT B.LEV150,B.QUANTITY,B.LEV150_DESC, 'B','P' FROM BOMX A, LEV101 B WHERE A.PARENT_PN LIKE '" . $new_sku . "' AND B.LEV101 = A.CHILD_PN AND B.LEV150 NOT IN 
                    (
                            SELECT B.LEV150 FROM BOMX A, LEV101 B WHERE A.PARENT_PN LIKE '" . $current_sku . "' AND B.LEV101 = A.CHILD_PN AND B.LEV150
                    )
            )";
                $dbconnect->sql = $minus_query;
                $dbconnect->selecttb();
                $minus_results = ($dbconnect->res) ? $dbconnect->res : '';
            }
            ?>
            <?php if ($minus_results) { ?>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="box box-primary">                        
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="heading"><b><div class="heading"><b>Minus</b></div></b></div>
                            <table id="conversion-minus" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>CHILD_PN</th>
                                        <th>0</th>
                                        <th>CHILD_DESC</th>
                                        <th>A</th>
                                        <th>P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysql_fetch_array($minus_results)) { ?>
                                        <tr>
                                            <td><?php echo $row['CHILD_PN']; ?></td>
                                            <td><?php echo $row['0']; ?></td>
                                            <td><?php echo $row['CHILD_DESC']; ?></td>
                                            <td><?php echo $row['A']; ?></td>
                                            <td><?php echo $row['P']; ?></td>
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
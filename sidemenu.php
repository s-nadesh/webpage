<?php //  include("config.php");   ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Admin</p>          
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <?php
            $all_menus = array();
            ?>

            <?php
            $dbconnect->sql = "SELECT DISTINCT(TYPE),ID FROM A_REPORT WHERE DISABLE = 0 ORDER BY ID;";
            $dbconnect->selecttb();
            $fl_result = $dbconnect->res;

            if ($fl_result) {
                while ($row1 = mysql_fetch_array($fl_result)) {

                    $root_menus = array();
                    $root_menus[0] = $row1['TYPE'];
                    $sl = "SELECT  DISTINCT A.TYPE, REPORT_ID FROM A_OPTIONS A, A_REPORT B WHERE A.REPORT_ID= B.ID AND A.DISABLE =0 AND A.REPORT_ID ='" . $row1['ID'] . "' ORDER BY A.REPORT_ID ;";
                    $dbconnect->sql = $sl;
                    $dbconnect->selecttb();
                    $sl_result = $dbconnect->res;
                    if ($dbconnect->nrow == '0') {
                        $root_menus[1] = 'NO';
                    } else {
                        $i = 0;
                        $branch = array();
                        while ($row2 = mysql_fetch_array($sl_result)) {

                            $branch[$i][0] = $row2['TYPE'];

                            $tl = "SELECT A.PRODUCT, A.TESTREPORT FROM A_TEST_REPORTS A, A_OPTIONS B WHERE A.PRODUCT=B.TYPE AND A.PRODUCT='" . $row2['TYPE'] . "';";
                            $dbconnect->sql = $tl;
                            $dbconnect->selecttb();
                            $tl_result = $dbconnect->res;
                            if ($dbconnect->nrow == '0') {
                                $branch[$i][1] = 'NO';
                            } else {
                                $j = 0;
                                $sub_branch = array();
                                while ($row3 = mysql_fetch_array($tl_result)) {

                                    $sub_branch[$j] = $row3['TESTREPORT'];
                                    $j++;
                                }

                                $branch[$i][1] = $sub_branch;
                            }
                            $i++;
                        }
                        $root_menus[1] = $branch;
                    }

                    $all_menus[$row1['ID']] = $root_menus;
                }
            }
            ?>
            <?php
//        foreach($all_menus as $root_menu){
//                echo $root_menu[0].'<br>';        
//            if($root_menu[1]!='NO'){
//                foreach($root_menu[1] as $branch_menu){
//                    echo '----'.$branch_menu[0].'<br>';
//                    
//                    if($branch_menu[1]!='NO'){
//                        foreach($branch_menu[1] as $sub_branch){        
//                            echo '--------'.$sub_branch.'<br>';
//                        }
//                    }  else {
//                        echo '--------No<br>';
//                    }
//                    
//                }
//            }  else {
//                echo '----No<br>';
//            }
//            echo '<br>';
//        }
            ?>
            <?php foreach ($all_menus as $root_menu) { ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-laptop"></i>
                        <span><?php echo $root_menu[0]; ?></span>
                        <?php if ($root_menu[1] != 'NO') { ?>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        <?php } ?>
                    </a>
                    <?php if ($root_menu[1] != 'NO') { ?>
                        <ul class="treeview-menu">
                            <?php foreach ($root_menu[1] as $branch_menu) { ?>

                                <li>
                                    <?php if ($branch_menu[1] != 'NO') { ?>
                                        <a href="#"><i class="fa fa-plus"></i> 
                                            <span><?php echo $branch_menu[0]; ?> </span>                            
                                            <span class="pull-right-container">
                                                <i class="fa fa-angle-right pull-right"></i>
                                            </span></a>
                                    <?php } else { ?>
                                        <a href="report.php?<?php echo 'branch=' . $branch_menu[0]; ?>"><i class="fa fa-circle-o"></i> 
                                            <span><?php echo $branch_menu[0]; ?> </span>                            
                                        </a>
                                    <?php } ?>

                                    <?php if ($branch_menu[1] != 'NO') { ?>
                                        <ul class="treeview-menu">
                                            <?php foreach ($branch_menu[1] as $sub_branch) { ?>

                                                <li><a href="report.php?<?php echo 'branch=' . $branch_menu[0] . '&sub_branch=' . $sub_branch; ?>"><i class="fa fa-circle-o"></i>  <?php echo $sub_branch; ?></a></li>

                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>                      

                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>        

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
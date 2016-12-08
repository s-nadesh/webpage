<section class="content-header clearfix">    
    <ol class="breadcrumb">
        <li>
            <a href="index.php">
                <i class="fa fa-dashboard"></i> Home
            </a>
        </li>

        <?php if (isset($_GET['branch'])) { ?>
            <li class="active"><?php echo $_GET['type']; ?></li>
        <?php } else if (isset($_GET['type'])) { ?>
            <li class="active"><?php echo $_GET['type']; ?></li>
        <?php } ?>

        <?php if (isset($_GET['sub_branch'])) { ?>
            <li class="active"><?php echo $_GET['branch']; ?></li>
            <li class="active"><?php echo $_GET['sub_branch']; ?></li>
        <?php } else if (isset($_GET['branch'])) { ?>
            <li class="active"><?php echo $_GET['branch']; ?></li>
            <?php } ?>
    </ol>
</section>
<?php include("header.php"); ?>
<?php include("sidemenu.php"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Advanced Search
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Advanced Search</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Search</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="datepicker-start" class="form-control pull-right">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form-group -->             
                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="datepicker-end" class="form-control pull-right">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form-group -->              
                    </div>
                    <!-- /.col -->
                    <div class="col-md-2">             
                        <button class="btn btn-info" type="submit"><i class="fa fa-search"></i> Search</button>
                        <!-- /.form-group -->              
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->        
        </div>
        <!-- /.box -->

        <div class="row">
            <div class="col-md-12">
                <!-- Default box -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Title</h3>         
                    </div>
                    <div class="box-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent at placerat ex. Praesent neque leo, tincidunt aliquet facilisis non, efficitur a sem. Integer bibendum eros orci, ornare gravida turpis pellentesque sed. Fusce eu nulla sit amet diam auctor sagittis sit amet id odio. Nullam in arcu at nibh pellentesque pretium vitae vitae elit. Integer posuere, purus in condimentum euismod, nulla nibh sagittis sapien, eu cursus diam tortor sit amet purus. Integer venenatis nunc accumsan mauris ullamcorper rhoncus. Aliquam congue vestibulum ipsum eget pretium. Pellentesque in libero eu leo venenatis elementum.</p>
                        <p>Donec congue sagittis ex, sed tincidunt elit ornare in. Duis vel laoreet mauris, at fringilla ligula. Curabitur enim nulla, ullamcorper nec nibh eget, efficitur feugiat justo. Morbi nec ex sit amet nulla mollis venenatis. Integer id neque eget nisi ultricies dictum quis vitae ante. Nulla vel mollis erat. Duis nisl nisi, volutpat quis erat sit amet, lobortis bibendum risus. Nulla auctor lacinia ipsum quis viverra. Nam ut neque dui. Aliquam et ultricies nisi.</p>
                        <p>Sed laoreet aliquam accumsan. Integer hendrerit bibendum lectus et accumsan. Cras semper enim a nunc facilisis semper. Fusce ac tincidunt quam. Curabitur convallis consectetur magna vel tincidunt. Pellentesque fringilla neque non mollis pulvinar. Fusce fermentum est sem, eu feugiat felis pretium quis. Phasellus hendrerit porttitor quam, quis malesuada metus varius vel. Donec iaculis nulla est, a volutpat risus porta vitae. Mauris tempor sed velit sed aliquam. </p>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        Footer
                    </div>
                    <!-- /.box-footer-->
                </div>
                <!-- /.box -->             

            </div>

        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- Page script -->


<?php include("footer.php"); ?>
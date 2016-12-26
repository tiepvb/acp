<?php
checklogin();
include 'header.php';
?>
<!-- Page Content -->
<div id="wapper">
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <?php include 'left.php'; ?>
            </div>

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #337ab7;border-color: #337ab7;color: #fff;">Panel Heading</div>
                    <div class="panel-body">Panel Content</div>
                </div>
            </div>

        </div>

    </div>
    <!-- /.container -->
</div>
<?php
include 'footer.php';
?>
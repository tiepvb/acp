<?php
checklogin();
include 'header.php';
$noti;
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
                    <div class="panel-heading" style="background-color: #337ab7;border-color: #337ab7;color: #fff;">STUDIO</div>
                    <div class="panel-body">
<?php
if($_GET['t'] == 'studio' && isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode'] == 'edit' && is_numeric($_GET['id'])){
    $id=intval($_GET['id']);
    $qe = $mysqli->query("SELECT * FROM jav_studio WHERE id=".$id);
    $r=$qe->fetch_array();

    if(isset($_POST['editstudio'])){
        $sql=$mysqli->query("UPDATE `jav_studio` SET name='".stripslashes(addslashes(trim($_POST['name'])))."',name_ascii='".name_on_bar(trim($_POST['name']))."',description='".stripslashes(addslashes($_POST['description']))."',keyword='".stripslashes(addslashes($_POST['keyword']))."' WHERE id = ".$id);
        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Updated success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant update studio!!!</div>';
        }
        $qe = $mysqli->query("SELECT * FROM jav_studio WHERE id=".$id);
        $r=$qe->fetch_array();
    }
?>
                    <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">

                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Name</span>
                      <input name="name" type="text" class="form-control" value="<?php echo $r['name']; ?>" required="">
                    </div></div>

                    <div class="form-group">
                        <label for="comment">Description:</label>
                        <textarea class="form-control" rows="5" name="description"><?php echo $r['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="comment">Keyword:</label>
                        <textarea class="form-control" rows="5" name="keyword"><?php echo $r['keyword']; ?></textarea>
                    </div>

                    
                    <div class="form-group">
                        <p align="center"><button name="editstudio" type="submit" class="btn btn-default">Action</button></p>
                    </div>
                </form>
<?php
}
elseif($_GET['t'] == 'studio' && isset($_GET['mode']) && $_GET['mode'] == 'edit'){ 
?>
                    <ul class="list-group">
                    <?php
                        $q = $mysqli->query("SELECT * FROM jav_studio ORDER BY name");
                        while ($r=$q->fetch_array()) {
                    ?>
                    <li class="list-group-item clearfix">
                        <span style="line-height: 2;"><?php echo $r['name']; ?></span>
                        <span class="pull-right button-group">
                            <a href="?t=studio&mode=edit&id=<?php echo $r['id']; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a> 
                        </span>
                    </li>
                    <?php
                        }
                    ?>
                    </ul>
<?php
}
elseif($_GET['t'] == 'studio' && isset($_GET['mode']) && $_GET['mode'] == 'add'){ 
    if(isset($_POST['addstudio'])){
        $sql=$mysqli->query("INSERT INTO `jav_studio`(`name`, `name_ascii`, `description`, `keyword`) VALUES ('".stripslashes(addslashes(trim($_POST['name'])))."','".name_on_bar(trim($_POST['name']))."','".stripslashes(addslashes($_POST['description']))."','".stripslashes(addslashes($_POST['keyword']))."')");
        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Created success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant create studio!!!</div>';
        }
    }
?>
                <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">
                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Name</span>
                      <input name="name" type="text" class="form-control" placeholder="Name" required="">
                    </div></div>

                    <div class="form-group">
                        <label for="comment">Description:</label>
                        <textarea class="form-control" rows="5" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="comment">Keyword:</label>
                        <textarea class="form-control" rows="5" name="keyword"></textarea>
                    </div>

                    <div class="form-group">
                        <p align="center"><button name="addstudio" type="submit" class="btn btn-default">Action</button></p>
                    </div>
                </form>
<?php
}
?>

                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /.container -->
</div>
<?php
include 'footer.php';
?>
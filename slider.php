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
                    <div class="panel-heading" style="background-color: #337ab7;border-color: #337ab7;color: #fff;">SLIDER</div>
                    <div class="panel-body">
<?php
if($_GET['t']=='slider' && isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode'] == 'edit' && is_numeric($_GET['id'])){
    $id=intval($_GET['id']);
    $qe = $mysqli->query("SELECT * FROM jav_slider WHERE id=".$id);
    $r=$qe->fetch_array();

    if(isset($_POST['editslider'])){
        $sql=$mysqli->query("UPDATE `jav_slider` SET name='".stripslashes(addslashes(trim($_POST['name'])))."',url='".stripslashes(addslashes(trim($_POST['url'])))."',img='".stripslashes(addslashes(trim($_POST['img'])))."',info='".stripslashes(addslashes(trim($_POST['info'])))."' WHERE id = ".$id);
        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Updated success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant update slider!!!</div>';
        }
        $qe = $mysqli->query("SELECT * FROM jav_slider WHERE id=".$id);
        $r=$qe->fetch_array();
    }
?>
                    <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">

                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Name</span>
                      <input name="name" type="text" class="form-control" value="<?php echo $r['name']; ?>" required="">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Url</span>
                        <input name="url" type="text" class="form-control" value="<?php echo $r['url']; ?>" required="">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Image</span>
                        <input name="img" type="text" class="form-control" value="<?php echo $r['img']; ?>" required="">
                    </div></div>

                    <div class="form-group">
                        <label for="comment">Info</label>
                        <textarea name="info" class="form-control" rows="10"><?php echo $r['info']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <p align="center"><button name="editslider" type="submit" class="btn btn-default">Action</button></p>
                    </div>
                </form>
<?php
}
elseif($_GET['t']=='slider' && isset($_GET['mode']) && $_GET['mode'] == 'edit'){ 
?>
                    <div class="row list-group" style="margin-top: -15px;">
                    <?php
                        $q = $mysqli->query("SELECT * FROM jav_slider ORDER BY id");
                        while ($r=$q->fetch_array()) {
                    ?>
                    <div class="col-md-12 list-group-item showepradius">
	                    <div class="col-md-11">
                            <a href="?t=slider&mode=edit&id=<?php echo $r['id']; ?>"><?php echo $r['name']; ?></a>
                        </div>
	                    <div class="col-md-1" style="text-align: center;color: #ff0000;cursor: pointer;"><i data-id="<?php echo $r['id']; ?>" class="glyphicon glyphicon-remove deleted_slider"></i></div>
	                </div>
                    <?php
                        }
                    ?>
                    </div>
<?php
}
elseif($_GET['t']=='slider' && isset($_GET['mode']) && $_GET['mode'] == 'add'){ 
    if(isset($_POST['addslider'])){

   		$sql=$mysqli->query("INSERT INTO `jav_slider`(`name`, `url`, `img`, `info`) VALUES ('".stripslashes(addslashes(trim($_POST['name'])))."','".stripslashes(addslashes(trim($_POST['url'])))."','".stripslashes(addslashes(trim($_POST['img'])))."','".stripslashes(addslashes(trim($_POST['info'])))."')");

        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Created slider success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant create slider!!!</div>';
        }
    }
?>
                <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">
                	
                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Name</span>
                      <input name="name" type="text" class="form-control" placeholder="Name" required="">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Url</span>
                        <input name="url" type="text" class="form-control" placeholder="Url" required="">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Image</span>
                        <input name="img" type="text" class="form-control" placeholder="Image" required="">
                    </div></div>

                    <div class="form-group">
                        <label for="comment">Info</label>
                        <textarea name="info" class="form-control" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <p align="center"><button name="addslider" type="submit" class="btn btn-default">Action</button></p>
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
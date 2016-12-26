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
                    <div class="panel-heading" style="background-color: #337ab7;border-color: #337ab7;color: #fff;">ACTOR</div>
                    <div class="panel-body">
<?php
if($_GET['t']=='actor' && isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode'] == 'edit' && is_numeric($_GET['id'])){
    $id=intval($_GET['id']);
    $qe = $mysqli->query("SELECT * FROM jav_actor WHERE id=".$id);
    $r=$qe->fetch_array();

    if(isset($_POST['editactor'])){
        $sql=$mysqli->query("UPDATE `jav_actor` SET name='".stripslashes(addslashes(trim($_POST['name'])))."',name__ascii='".name_on_bar(trim($_POST['name']))."',img='".stripslashes(addslashes(trim($_POST['img'])))."' WHERE id = ".$id);
        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Updated success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant update actor!!!</div>';
        }
        $qe = $mysqli->query("SELECT * FROM jav_actor WHERE id=".$id);
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
                        <span class="input-group-addon minwcat" >Image</span>
                        <input name="img" type="text" class="form-control" value="<?php echo $r['img']; ?>" >
                    </div></div>

                    <div class="form-group">
                        <p align="center"><button name="editactor" type="submit" class="btn btn-default">Action</button></p>
                    </div>
                </form>
<?php
}
elseif($_GET['t']=='actor' && isset($_GET['mode']) && $_GET['mode'] == 'edit'){ 
?>
                    <div class="row list-group" style="margin-top: -15px;">
                    <?php
                        $q = $mysqli->query("SELECT * FROM jav_actor ORDER BY id DESC LIMIT 30");
                        while ($r=$q->fetch_array()) {
                    ?>
                    <div class="col-md-12 list-group-item showepradius">
	                    <div class="col-md-11">
                            <a href="?t=actor&mode=edit&id=<?php echo $r['id']; ?>"><?php echo $r['name']; ?></a>
                        </div>
	                    <div class="col-md-1" style="text-align: center;color: #ff0000;cursor: pointer;"><i data-id="<?php echo $r['id']; ?>" class="glyphicon glyphicon-remove deleted_actor"></i></div>
	                </div>
                    <?php
                        }
                    ?>
                    </div>
<?php
}
elseif($_GET['t']=='actor' && isset($_GET['mode']) && $_GET['mode'] == 'add'){ 
    if(isset($_POST['addactor'])){

   		$sql=$mysqli->query("INSERT INTO `jav_actor`(`name`, `name__ascii`, `img`) VALUES ('".stripslashes(addslashes(trim($_POST['name'])))."','".name_on_bar(trim($_POST['name']))."','".stripslashes(addslashes(trim($_POST['img'])))."')");

        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Created episode success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant create actor!!!</div>';
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
                        <span class="input-group-addon minwcat" >Image</span>
                        <input name="img" type="text" class="form-control" placeholder="Image" >
                    </div></div>
                    
                    <div class="form-group">
                        <p align="center"><button name="addactor" type="submit" class="btn btn-default">Action</button></p>
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
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
                    <div class="panel-heading" style="background-color: #337ab7;border-color: #337ab7;color: #fff;">VIDEO</div>
                    <div class="panel-body">
<?php
if($_GET['t']=='video' && isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode'] == 'edit' && is_numeric($_GET['id'])){
    $id=intval($_GET['id']);
    $qe = $mysqli->query("SELECT * FROM jav_video WHERE m_id=".$id);
    $r=$qe->fetch_array();

    if(isset($_POST['editvideo'])){

        $sql=$mysqli->query("UPDATE `jav_video` SET `m_title`='".addslashes(trim($_POST['title']))."',`m_url`='".addslashes(trim($_POST['url']))."',`m_type`='".acp_type(addslashes(trim($_POST['url'])))."',`m_time`='".addslashes(trim($_POST['m_time']))."',`m_img`='".addslashes(trim($_POST['img']))."',`m_cat`='".join_value($_POST['selectcat'])."',`m_title_ascii`='".name_on_bar(trim($_POST['title']))."' WHERE m_id=".$id);

        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Updated success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant update video!!!</div>';
        }
        $qe = $mysqli->query("SELECT * FROM jav_video WHERE m_id=".$id);
        $r=$qe->fetch_array();
    }
?>
                    <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="comment">Category:</label>
                        <?php echo acp_cat($r['m_cat']); ?>
                    </div>
                    
                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Title</span>
                      <input name="title" type="text" class="form-control" value="<?php echo $r['m_title']; ?>" required="">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Url</span>
                        <input name="url" type="text" class="form-control" value="<?php echo $r['m_url']; ?>" required="">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Time</span>
                        <input name="m_time" type="text" class="form-control" value="<?php echo $r['m_time']; ?>" required="">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Image</span>
                        <input name="img" type="text" class="form-control" value="<?php echo $r['m_img']; ?>" required="">
                    </div></div>

                    <div class="form-group">
                        <p align="center"><button name="editvideo" type="submit" class="btn btn-default">Action</button></p>
                    </div>
                </form>
<?php
}
elseif($_GET['t']=='video' && isset($_GET['mode']) && $_GET['mode'] == 'edit'){ 
?>
                    <div class="row list-group" style="margin-top: -15px;">
                    <?php
                        $q = $mysqli->query("SELECT * FROM jav_video ORDER BY m_id");
                        while ($r=$q->fetch_array()) {
                    ?>
                    <div class="col-md-12 list-group-item showepradius">
	                    <div class="col-md-9">
                            <a href="?t=video&mode=edit&id=<?php echo $r['m_id']; ?>"><?php echo $r['m_title']; ?></a>
                        </div>
	                    <div class="col-md-2"><?php echo player_name($r['m_type']); ?></div>
	                    <div class="col-md-1" style="text-align: center;color: #ff0000;cursor: pointer;"><i data-id="<?php echo $r['m_id']; ?>" class="glyphicon glyphicon-remove deleted_video"></i></div>
	                </div>
                    <?php
                        }
                    ?>
                    </div>
<?php
}
elseif($_GET['t']=='video' && isset($_GET['mode']) && $_GET['mode'] == 'add'){ 
    if(isset($_POST['addvideo'])){
    	$cat=join_value($_POST['selectcat']);

    	for ($i=0; $i < count($_POST['title']); $i++) {
    		$title=stripslashes(trim($_POST['title'][$i]));
    		$m_url = stripslashes(trim($_POST['url'][$i]));
            $m_time = stripslashes(trim($_POST['m_time'][$i]));
            $img = stripslashes(trim($_POST['img'][$i]));
			$m_type = acp_type($m_url);
            $sql=$mysqli->query("INSERT INTO `jav_video`(`m_title`, `m_url`, `m_type`, `m_time`, `m_img`, `m_cat`, `m_title_ascii`) VALUES ('".$title."','".$m_url."','".$m_type."','".$m_time."','".$img."','".$cat."','".name_on_bar($title)."')");
    	}
        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Created video success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant create video!!!</div>';
        }
    }
?>
                <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">
                	<div class="form-group">
                        <label for="comment">Category:</label>
                        <?php echo acp_cat(); ?>
                    </div>
                	<div id="addnewep" style="padding: 10px; border: 1px solid #ddd;margin-bottom: 10px;">
	                    <div class="form-group"><div class="input-group">
	                      <span class="input-group-addon minwcat" >Title</span>
	                      <input name="title[]" type="text" class="form-control" placeholder="Title" required="">
	                    </div></div>

	                    <div class="form-group"><div class="input-group">
	                        <span class="input-group-addon minwcat" >Url</span>
	                        <input name="url[]" type="text" class="form-control" placeholder="Url" required="">
	                    </div></div>

                        <div class="form-group"><div class="input-group">
                            <span class="input-group-addon minwcat" >Time</span>
                            <input name="m_time[]" type="text" class="form-control" placeholder="Time" required="">
                        </div></div>

                        <div class="form-group"><div class="input-group">
                            <span class="input-group-addon minwcat" >Image</span>
                            <input name="img[]" type="text" class="form-control" placeholder="Image" required="">
                        </div></div>

	                </div>

	                <div class="form-group">
                        <div class="pull-right">
	                	  <a id="addnew" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i> Add</a>
                        </div>
                        <div class="pull-left">
                            <a id="delete_video" class="btn btn-default"><i class="glyphicon glyphicon-minus"></i> Del</a>
                        </div>
	                </div>
                    
                    <div class="form-group">
                        <p align="center"><button name="addvideo" type="submit" class="btn btn-default">Action</button></p>
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
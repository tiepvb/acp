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
                    <div class="panel-heading" style="background-color: #337ab7;border-color: #337ab7;color: #fff;">EPISODE</div>
                    <div class="panel-body">
<?php
if($_GET['t']=='episode' && isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode'] == 'edit' && is_numeric($_GET['id'])){
    $id=intval($_GET['id']);
    $qe = $mysqli->query("SELECT m_title, m_url, m_dvd FROM jav_data WHERE m_id=".$id);
    $r=$qe->fetch_array();

    if(isset($_POST['editep'])){
        $sql=$mysqli->query("UPDATE `jav_data` SET m_title='".addslashes(trim($_POST['title']))."',m_url='".addslashes(trim($_POST['url']))."',m_dvd='".addslashes($_POST['dvd'])."' WHERE m_id = ".$id);
        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Updated success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant update episode!!!</div>';
        }
        $qe = $mysqli->query("SELECT m_title, m_url, m_dvd FROM jav_data WHERE m_id=".$id);
        $r=$qe->fetch_array();
    }
?>
                    <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">
                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Title</span>
                      <input name="title" type="text" class="form-control" value="<?php echo $r['m_title']; ?>">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Url</span>
                        <input name="url" type="text" class="form-control" value="<?php echo $r['m_url']; ?>">
                    </div></div>

                 	<div class="form-group">
                        <label for="comment">Dvd name:</label>
                        <?php echo acp_phim_list_edit($r['m_dvd']); ?>
                    </div>

                    <div class="form-group">
                        <p align="center"><button name="editep" type="submit" class="btn btn-default">Action</button></p>
                    </div>
                </form>
<?php
}
elseif($_GET['t']=='episode' && isset($_GET['mode']) && $_GET['mode'] == 'edit'){ 
?>
                    <div class="row list-group" style="margin-top: -15px;">
                    <?php
                        $q = $mysqli->query("SELECT * FROM jav_data ORDER BY m_id");
                        while ($r=$q->fetch_array()) {
                    ?>
                    <div class="col-md-12 list-group-item showepradius">
	                    <div class="col-md-2 ">
	                    	<a href="?t=episode&mode=edit&id=<?php echo $r['m_id']; ?>">Ep <?php echo $r['m_title']; ?></a>
	                    </div>
	                    <div class="col-md-7"><?php echo name_dvd($r['m_dvd']); ?></div>
	                    <div class="col-md-2"><?php echo player_name($r['m_type']); ?></div>
	                    <div class="col-md-1" style="text-align: center;color: #ff0000;cursor: pointer;"><i data-id="<?php echo $r['m_id']; ?>" class="glyphicon glyphicon-remove deleted_ep"></i></div>
	                </div>
                    <?php
                        }
                    ?>
                    </div>
<?php
}
elseif($_GET['t']=='episode' && isset($_GET['mode']) && $_GET['mode'] == 'add'){ 
    if(isset($_POST['addepisode'])){
    	$dvd=addslashes($_POST['dvd']);

    	for ($i=0; $i < count($_POST['title']); $i++) {
    		$title=stripslashes(trim($_POST['title'][$i]));
    		$m_url = stripslashes(trim($_POST['url'][$i]));
			$m_type = acp_type($m_url);
    		$sql=$mysqli->query("INSERT INTO `jav_data`(`m_title`, `m_dvd`, `m_url`, `m_type`) VALUES ('".$title."','".$dvd."','".$m_url."','".$m_type."')");
    	}
        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Created episode success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant create episode!!!</div>';
        }
    }
?>
                <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">
                	<div class="form-group">
                        <label for="comment">Dvd Name:</label>
                        <input class="form-control" rows="5" id="dvdname" type="text">
                        <input id="dvd" name="dvd" type="hidden">
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

	                </div>

	                <div class="form-group" align="right">
	                	<a id="addnew" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i> Add</a>
	                </div>
                    <div class="form-group">
                        <p align="center"><button name="addepisode" type="submit" class="btn btn-default">Action</button></p>
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
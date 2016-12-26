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
                    <div class="panel-heading" style="background-color: #337ab7;border-color: #337ab7;color: #fff;">DVD</div>
                    <div class="panel-body">
<?php
if($_GET['t']=='dvd' && isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode'] == 'edit' && is_numeric($_GET['id'])){
    $id=intval($_GET['id']);
    $qe = $mysqli->query("SELECT * FROM jav_dvd WHERE id=".$id);
    $r=$qe->fetch_array();

    if(isset($_POST['editdvd'])){
        $studio = join_value($_POST['selectstudio']);
        $cat=join_value($_POST['selectcat']);
        $actor=join_value($_POST['selectactor']);
        $tags=join_value($_POST['selecttag']);
        $img=stripslashes(trim($_POST['imgdvd']));
        $imginfo=stripslashes(trim($_POST['imginfo']));
        if(preg_match('/cdn.javbox.org/i', $img)) $img=trim($img);
        else $img=acp_transload(trim($img),name_on_bar(trim($_POST['namedvd'])),'poster');
        if(preg_match('/cdn.javbox.org/i', $imginfo)) $imginfo=trim($imginfo);
        else $imginfo = acp_transload(trim($imginfo),name_on_bar(trim($_POST['namedvd'])),'info');
        
        $sql=$mysqli->query("UPDATE `jav_dvd` SET name='".addslashes(trim($_POST['namedvd']))."',name_ascii='".name_on_bar(trim($_POST['namedvd']))."',name_jp='".addslashes(trim($_POST['namedvdjp']))."',time_dvd='".stripslashes(trim($_POST['timedvd']))."',uncensored='".stripslashes(trim($_POST['uncensored']))."',img='".$img."',img_info='".$imginfo."',info='".addslashes(trim($_POST['infodvd']))."',cat='".$cat."',actor='".$actor."',studio='".$studio."',tags='".$tags."',date='".time()."',quality='".stripslashes(trim($_POST['quality']))."' WHERE id=".$id);

        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Updated success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant update dvd!!!</div>';
        }
        $qe = $mysqli->query("SELECT * FROM jav_dvd WHERE id=".$id);
        $r=$qe->fetch_array();
    }
?>
                    <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">
                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Dvd name</span>
                      <input name="namedvd" type="text" class="form-control" value="<?php echo $r['name']; ?>" required="">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Name JP</span>
                        <input name="namedvdjp" type="text" class="form-control" value="<?php echo $r['name_jp']; ?>" >
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Time dvd</span>
                        <input name="timedvd" type="text" class="form-control" value="<?php echo $r['time_dvd']; ?>" required="">
                    </div></div>

                    <div class="form-group row">
                    <div class="col-md-11">
                        <div class="input-group">
                            <span class="input-group-addon minwcat" >Actor</span>
                            <input id="actor" type="text" class="form-control" placeholder="Actor">
                        </div>
                        <div id="actorselect"><?php echo acp_actor($r['actor']); ?></div>
                    </div>
                        <div class="col-md-1" style="margin-left: -10px;"><a class="btn btn-default submitactor">Add</a></div>
                    </div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Uncensored</span>
                        <select name="uncensored" class="form-control">
                            <option value="Cen" <?php if($r['uncensored']=='Cen'){echo 'selected';} ?>>Censored</option>
                            <option value="Uncen" <?php if($r['uncensored']=='Uncen'){echo 'selected';} ?>>Uncensored</option>
                        </select>
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Quality</span>
                        <select name="quality" class="form-control">
                            <option value="HD" selected>HD</option>
                            <option value="SD">SD</option>
                        </select>
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Image info</span>
                        <input name="imginfo" type="text" class="form-control" value="<?php echo $r['img_info']; ?>">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Image dvd</span>
                        <input name="imgdvd" type="text" class="form-control" value="<?php echo $r['img']; ?>" required="">
                    </div></div>

                    <div class="form-group row">
                    <div class="col-md-11">
                        <div class="input-group">
                            <span class="input-group-addon minwcat" >Tags</span>
                            <input id="tagdvd" type="text" class="form-control" placeholder="Tags dvd">
                        </div>
                        <div id="tagselect"><?php echo acp_tags($r['tags']); ?></div>
                    </div>
                    <div class="col-md-1" style="margin-left: -10px;"><a class="btn btn-default submitag">Add</a></div>
                    </div>

                    <div class="form-group">
                        <div class="input-group"><span class="input-group-addon minwcat" >Studio</span></div>
                        <?php echo acp_studio($r['studio']); ?>
                    </div>

                    <div class="form-group">
                        <div class="input-group"><span class="input-group-addon minwcat" >Category</span></div>
                        <?php echo acp_cat($r['cat']); ?>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control mceEditor" name="infodvd" rows="10"><?php echo $r['info']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <p align="center"><button name="editdvd" type="submit" class="btn btn-default">Action</button></p>
                    </div>
                </form>
<?php
}
elseif($_GET['t']=='dvd' && isset($_GET['mode']) && $_GET['mode'] == 'edit'){ 
?>
                    <div class="row list-group" style="margin-top: -15px;">
                    <?php
                        $q = $mysqli->query("SELECT * FROM jav_dvd ORDER BY id DESC");
                        while ($r=$q->fetch_array()) {
                    ?>
                    <div class="col-md-12 list-group-item showepradius">
	                    <div class="col-md-9 ">
	                    	<a href="?t=dvd&mode=edit&id=<?php echo $r['id']; ?>"><?php echo $r['name']; ?></a>
	                    </div>
	                    <div class="col-md-2"><?php echo $r['uncensored']; ?></div>
	                    <div class="col-md-1" style="text-align: center;color: #ff0000;cursor: pointer;"><i data-id="<?php echo $r['id']; ?>" class="glyphicon glyphicon-remove deleted_dvd"></i></div>
	                </div>
                    <?php
                        }
                    ?>
                    </div>
<?php
}
elseif($_GET['t']=='dvd' && isset($_GET['mode']) && $_GET['mode'] == 'add'){ 
    if(isset($_POST['adddvd'])){
    	$studio = join_value($_POST['selectstudio']);
        $cat=join_value($_POST['selectcat']);
        $actor=join_value($_POST['selectactor']);
        $tags=join_value($_POST['selecttag']);
        $img=stripslashes(trim($_POST['imgdvd']));
        $imginfo=stripslashes(trim($_POST['imginfo']));
        if(preg_match('/cdn.javbox.org/i', $img)) $img=trim($img);
        else $img=acp_transload(trim($img),name_on_bar(trim($_POST['namedvd'])),'poster');
        if(preg_match('/cdn.javbox.org/i', $imginfo)) $imginfo=trim($imginfo);
        else $imginfo = acp_transload(trim($imginfo),name_on_bar(trim($_POST['namedvd'])),'info');

        $sql=$mysqli->query("INSERT INTO `jav_dvd`(`name`, `name_ascii`, `name_jp`, `time_dvd`, `uncensored`, `img`, `img_info`, `info`, `cat`, `actor`, `studio`, `tags`, `date`, `quality`) VALUES ('".addslashes(trim($_POST['namedvd']))."','".name_on_bar(trim($_POST['namedvd']))."','".addslashes(trim($_POST['namedvdjp']))."','".stripslashes(trim($_POST['timedvd']))."','".stripslashes(trim($_POST['uncensored']))."','".$img."','".$imginfo."','".addslashes(trim($_POST['infodvd']))."','".$cat."','".$actor."','".$studio."','".$tags."','".time()."','".stripslashes(trim($_POST['quality']))."')");

        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Created dvd success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant create dvd!!!</div>';
        }
    }
?>
                <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">

                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Dvd name</span>
                      <input name="namedvd" type="text" class="form-control" placeholder="Dvd name" required="">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Name JP</span>
                        <input name="namedvdjp" type="text" class="form-control" placeholder="Name jp" >
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Time dvd</span>
                        <input name="timedvd" type="text" class="form-control" placeholder="Time dvd" required="">
                    </div></div>

                    <div class="form-group row">
                    <div class="col-md-11">
                        <div class="input-group">
                            <span class="input-group-addon minwcat" >Actor</span>
                            <input id="actor" type="text" class="form-control" placeholder="Actor">
                        </div>
                        <div id="actorselect"></div>
                    </div>
                        <div class="col-md-1" style="margin-left: -10px;"><a class="btn btn-default submitactor">Add</a></div>
                    </div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Uncensored</span>
                        <select name="uncensored" class="form-control">
                            <option value="Cen" selected>Censored</option>
                            <option value="Uncen">Uncensored</option>
                        </select>
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Quality</span>
                        <select name="quality" class="form-control">
                            <option value="HD" selected>HD</option>
                            <option value="SD">SD</option>
                        </select>
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Image info</span>
                        <input name="imginfo" type="text" class="form-control" placeholder="Image info">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Image dvd</span>
                        <input name="imgdvd" type="text" class="form-control" placeholder="Image dvd" required="">
                    </div></div>

                    <div class="form-group row">
                    <div class="col-md-11">
                        <div class="input-group">
                            <span class="input-group-addon minwcat" >Tags</span>
                            <input id="tagdvd" type="text" class="form-control" placeholder="Tags dvd">
                        </div>
                        <div id="tagselect"></div>
                    </div>
                    <div class="col-md-1" style="margin-left: -10px;"><a class="btn btn-default submitag">Add</a></div>
                    </div>

                    <div class="form-group">
                        <div class="input-group"><span class="input-group-addon minwcat" >Studio</span></div>
                        <?php echo acp_studio(); ?>
                    </div>

                    <div class="form-group">
                        <div class="input-group"><span class="input-group-addon minwcat" >Category</span></div>
                        <?php echo acp_cat(); ?>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control mceEditor" name="infodvd" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <p align="center"><button name="adddvd" type="submit" class="btn btn-default">Action</button></p>
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
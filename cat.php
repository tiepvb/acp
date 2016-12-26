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
                    <div class="panel-heading" style="background-color: #337ab7;border-color: #337ab7;color: #fff;">CATEGORY</div>
                    <div class="panel-body">
<?php
if(isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode'] == 'edit' && is_numeric($_GET['id'])){
    $id=intval($_GET['id']);
    $qe = $mysqli->query("SELECT * FROM jav_cat WHERE id=".$id);
    $r=$qe->fetch_array();

    if(isset($_POST['editcat'])){
        $sql=$mysqli->query("UPDATE `jav_cat` SET name='".addslashes(trim($_POST['catname']))."',title='".addslashes(trim($_POST['titleseo']))."',description='".addslashes($_POST['description'])."',keyword='".addslashes($_POST['keyword'])."',type='".name_on_bar(trim($_POST['catname']))."',sub_id='".addslashes($_POST['subcat'])."',cat_img='".addslashes(trim($_POST['img']))."' WHERE id = ".$id);
        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Updated success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant update category!!!</div>';
        }
    }
?>
                    <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">
                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Name</span>
                      <input name="catname" type="text" class="form-control" placeholder="<?php echo $r['name']; ?>" value="<?php echo $r['name']; ?>">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Main cat</span>
                        <?php echo acp_maincat($id); ?>
                    </div></div>

                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Title Seo</span>
                      <input name="titleseo" type="text" class="form-control" placeholder="Title Seo" value="<?php echo $r['title']; ?>">
                    </div></div>

                    <div class="form-group">
                        <label for="comment">Image:</label>
                        <input class="form-control" rows="5" name="img" type="text" value="<?php echo $r['cat_img']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="comment">Description:</label>
                        <textarea class="form-control" rows="5" name="description"><?php echo $r['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="comment">Keyword:</label>
                        <textarea class="form-control" rows="5" name="keyword"><?php echo $r['keyword']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <p align="center"><button name="editcat" type="submit" class="btn btn-default">Action</button></p>
                    </div>
                </form>
<?php
}
elseif(isset($_GET['mode']) && $_GET['mode'] == 'edit'){ 
?>
                    <ul class="list-group">
                    <?php
                        $q = $mysqli->query("SELECT * FROM jav_cat ORDER BY name");
                        while ($r=$q->fetch_array()) {
                    ?>
                    <li class="list-group-item clearfix">
                        <span style="line-height: 2;"><?php echo $r['name']; ?></span>
                        <span class="pull-right button-group">
                            <a href="?t=cat&mode=edit&id=<?php echo $r['id']; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a> 
                        </span>
                    </li>
                    <?php
                        }
                    ?>
                    </ul>
<?php
}
elseif(isset($_GET['mode']) && $_GET['mode'] == 'add'){ 
    if(isset($_POST['addcat'])){
        $sql=$mysqli->query("INSERT INTO `jav_cat`(`name`, `title`, `description`, `keyword`, `type`, `sub_id`, `cat_img`) VALUES ('".addslashes(trim($_POST['namecat']))."','".addslashes(trim($_POST['titleseo']))."','".addslashes($_POST['description'])."','".addslashes($_POST['keyword'])."','".name_on_bar(trim($_POST['namecat']))."','".addslashes($_POST['subcat'])."','".addslashes(trim($_POST['img']))."')");
        if($sql){
            $noti='<div align="center" class="alert alert-success" role="alert">Created success.</div>';
        }else{
            $noti='<div align="center" class="alert alert-danger" role="alert">Cant create category!!!</div>';
        }
    }
?>
                <?php echo isset($noti)?$noti:''; ?>
                <form action="" method="POST">
                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Name</span>
                      <input name="namecat" type="text" class="form-control" placeholder="Name" required="">
                    </div></div>

                    <div class="form-group"><div class="input-group">
                        <span class="input-group-addon minwcat" >Main cat</span>
                        <?php echo acp_maincat(''); ?>
                    </div></div>

                    <div class="form-group"><div class="input-group">
                      <span class="input-group-addon minwcat" >Title Seo</span>
                      <input name="titleseo" type="text" class="form-control" placeholder="Title Seo" >
                    </div></div>

                    <div class="form-group">
                        <label for="comment">Image:</label>
                        <input class="form-control" rows="5" name="img" type="text">
                    </div>

                    <div class="form-group">
                        <label for="comment">Description:</label>
                        <textarea class="form-control" rows="5" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="comment">Keyword:</label>
                        <textarea class="form-control" rows="5" name="keyword"></textarea>
                    </div>

                    <div class="form-group">
                        <p align="center"><button name="addcat" type="submit" class="btn btn-default">Action</button></p>
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
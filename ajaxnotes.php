<?php
include("inc/config.php");
include("inc/func.php");
if(isset($_GET['term'])){
	$kw = name_on_bar($_GET['term']);
	$q = $mysqli->query("SELECT name, id FROM jav_dvd WHERE name_ascii LIKE '%".$kw."%' ORDER BY name DESC LIMIT 10");
	//$html['label'];
	//$html['value'];
	$values=array();
	while ($r = $q->fetch_array()) {
		$html['label'] = $r['name'];
		$html['value'] = $r['id'];
		array_push($values,$html);
		//array_push ($r['id'], $html['value']);
	}
	for ($i=0; $i < count($values); $i++) { 
		$json[]=$values[$i];
	}
	//$json=json_encode(array($values[0],$values[1]));
	//var_dump($a);
	echo json_encode($json);
	exit();
}
if (isset($_POST['playerdelete'])) {
	$id=intval($_POST['playerdelete']);
	$sql = $mysqli->query("DELETE FROM `jav_player` WHERE id=".$id);
	if($sql){
		echo 1;
	}else{
		echo 2;
	}
}
if (isset($_POST['epdelete'])) {
	$id=intval($_POST['epdelete']);
	$sql = $mysqli->query("DELETE FROM `jav_data` WHERE m_id=".$id);
	if($sql){
		echo 1;
	}else{
		echo 2;
	}
}
if (isset($_POST['sdelete'])) {
	$id=intval($_POST['sdelete']);
	$sql = $mysqli->query("DELETE FROM `jav_slider` WHERE id=".$id);
	if($sql){
		echo 1;
	}else{
		echo 2;
	}
}
if(isset($_POST['tagdvd'])){
	$name=addslashes(trim($_POST['tagdvd']));
	$q = $mysqli->query("SELECT * FROM jav_tags WHERE name_ascii = '".name_on_bar($name)."' ORDER BY id ASC");
	$json=array();
	if(!$q->num_rows) {
		$sql=$mysqli->query("INSERT INTO jav_tags (name,name_ascii) VALUES ('".stripslashes($name)."','".name_on_bar($name)."')");
		if($sql){
			$json['success'] = 'true';
			$json['msg'] = '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="selecttag" name="selecttag[]" value='.$mysqli->insert_id.' checked>&nbsp;&nbsp;'.stripslashes($name);
		}else{
			$json['success'] = 'false';
			$json['msg'] = 'Cant insert tag!!!';
		}
	}else{
		$r=$q->fetch_array();
		$json['success'] = 'true';
			$json['msg'] = '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="selecttag" name="selecttag[]" value='.$r['id'].' checked>&nbsp;&nbsp;'.$r['name'];
	}
	echo json_encode($json);
}

if(isset($_POST['actor'])){
	$name=addslashes(trim($_POST['actor']));
	$q = $mysqli->query("SELECT * FROM jav_actor WHERE name__ascii = '".name_on_bar($name)."' ORDER BY id ASC");
	$json=array();
	if(!$q->num_rows) {
		$sql=$mysqli->query("INSERT INTO jav_actor (name,name__ascii) VALUES ('".ucwords(stripslashes($name))."','".name_on_bar($name)."')");
		if($sql){
			$json['success'] = 'true';
			$json['msg'] = '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="selectactor" name="selectactor[]" value='.$mysqli->insert_id.' checked>&nbsp;&nbsp;'.ucwords(stripslashes($name));
		}else{
			$json['success'] = 'false';
			$json['msg'] = 'Cant insert actor!!!';
		}
	}else{
		$r=$q->fetch_array();
		$json['success'] = 'true';
			$json['msg'] = '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="selectactor" name="selectactor[]" value='.$r['id'].' checked>&nbsp;&nbsp;'.$r['name'];
	}
	echo json_encode($json);
}

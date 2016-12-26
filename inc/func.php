<?php
function checklogin()
{
    if(!isset($_SESSION['admin_id'])){
        header("Location: ".DOMAIN."?t=login");
        exit();
    }
}
function acp_maincat($id) {
	global $mysqli;
	$q = $mysqli->query("SELECT id, name FROM jav_cat ORDER BY name ASC");
	$html = '<select class="form-control" name="subcat">';
	$html .= '<option value="0">- Main category -</option>';
	while ($r = $q->fetch_array()) {
		$html .= "<option value=\"".$r['id'].(($r['id'] == $id)?" selected":"")."\">".$r['name']."</option>";
	}
	$html .= '</select>';
	return $html;
}
function utf8_to_ascii($str) {
	$chars = array(
		'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','ắ','ằ','ẳ','ẵ','ặ','á','à','ả','ã','ạ','â','ă'),
		'A'	=>	array('Ấ','Ầ','Ẩ','Ẫ','Ậ','Ắ','Ằ','Ẳ','Ẵ','Ặ','Á','À','Ả','Ã','Ạ','Â','Ă'),
		'e' =>	array('ế','ề','ể','ễ','ệ','é','è','ẻ','ẽ','ẹ','ê'),
		'E'	=>	array('Ế','Ề','Ể','Ễ','Ệ','É','È','Ẻ','Ẽ','Ẹ','Ê'),
		'i'	=>	array('í','ì','ỉ','ĩ','ị'),
		'I' =>	array('Í','Ì','Ỉ','Ĩ','Ị'),
		'o'	=>	array('ố','ồ','ổ','ỗ','ộ','ớ','ờ','ở','ỡ','ợ','ó','ò','ỏ','õ','ọ','ô','ơ'),
		'O'	=>	array('Ố','Ồ','Ổ','Ô','Ộ','Ớ','Ờ','Ở','Ỡ','Ợ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
		'u'	=>	array('ứ','ừ','ử','ữ','ự','ú','ù','ủ','ũ','ụ','ư'),
		'U' =>	array('Ứ','Ừ','Ử','Ữ','Ự','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
		'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ'),
		'Y'	=>	array('Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		'd'	=>	array('đ'),
		'D' => 	array('Đ'),
		//'' => 	array(':',"'"),
		//' '	=>	array('-'),
	);
	foreach ($chars as $key => $arr)
		foreach ($arr as $val)
			$str = str_replace($val,$key,$str);
	return $str;
}
function name_on_bar($string,$title=false) {
	$string = strtolower(stripslashes(utf8_to_ascii(m_unhtmlchars($string))));
	$delete_chars = array('~','!','@','#','$','%','^','*','(',')','=','|','}','{',']','[','"',"'",':',';','?','>','<',',','`','’','+');
	$string = str_replace ($delete_chars, '', $string );
	$noi_ngang = array('---',' & ',' - ',' + ','/','-','&',' ','_','.','--');
	$string = str_replace ($noi_ngang, '-', $string );
	if ($title) $string = strtolower($string).'/';
	return $string;
}
function m_unhtmlchars($str) {
	return str_replace(
		array('&lt;', '&gt;', '&quot;', '&amp;', '&#92;', '&#39;'),
		array('<', '>', '"', '&', chr(92), chr(39)), $str);
}
function name_dvd($value)
{
	global $mysqli;
	$q = $mysqli->query("SELECT name FROM jav_dvd WHERE id=".$value);
	$r = $q->fetch_array();
	$url='<a href="'.DOMAIN.'?t=dvd&mode=edit&id='.$value.'">'.$r['name'].'</a>';
	return $url;
}
function player_name($value)
{
	global $mysqli;
	$q = $mysqli->query("SELECT name FROM jav_player WHERE id=".$value);
	$r = $q->fetch_array();
	return $r['name'];
}
function acp_phim_list_edit($id = 0, $add = false) {
	global $mysqli;
	$q = $mysqli->query("SELECT id, name FROM jav_dvd ORDER BY name ASC");
	$html = '<select class="form-control" name="dvd">';
	if ($add) $html .= "<option value=\"dont_edit\"".(($id == 0)?" selected":'').">No edit</option>";
	$html .= "<option value=0".(($id == 0 && !$add)?" selected":'').">Updating</option>";
	while ($r = $q->fetch_array()) {
		$html .= "<option value=".$r['id'].(($id == $r['id'])?" selected":'').">".$r['name']."</option>";
	}
	$html .= "</select>";
	return $html;
}
function get_ext($url){
	$ext = explode('.',$url);
	$ext = $ext[count($ext)-1];
	$ext = explode('?',$ext);
	$ext = $ext[0];
	return $ext;
}
function acp_type($url){
	global $mysqli;
		$result= false;
		$par=get_ext($url);
		if (in_array($par,array('m3u8','flv','wmv','mp3','avi','divx','mp4','mpeg'))){
			$ext='ext:'.$par;
			$query_ext = $mysqli->query("SELECT id FROM jav_player WHERE pcheck ='$ext'");
			$count_ext=$query_ext->num_rows;
			if($count_ext){
			$kq=$query_ext->fetch_array();
			$result=$kq['id'];
			}
		}else{
			if (stripos($url,"https://")===0) {
				preg_match('@^(?:https://)?([^/]+)@i',$url, $matches);
			}else {
				preg_match('@^(?:http://)?([^/]+)@i',$url, $matches);
			}
			$site = 'site:'.$matches[1];
			$query_site = $mysqli->query("SELECT id FROM jav_player WHERE pcheck ='".$site."'");
			$count_site=$query_site->num_rows;
			if($count_site){
				$kq=$query_site->fetch_array();
				$result=$kq['id'];
			}
		}
	return $result;
}

function acp_cat($id = 0, $add = false) {
    global $mysqli;
    $q = $mysqli->query("SELECT * FROM jav_cat ORDER BY name ASC");
    $cat=explode(',',$id);
    $num=count($cat);
    $html='<div class="row">';
    $checked="";
    while ($r = $q->fetch_array()) {
        for ($i=0; $i<$num;$i++) if ($cat[$i]==$r['id']) $checked='checked="checked"';
        $html .= '<div class="col-md-3"><input type="checkbox" id="selectcat" name="selectcat[]" value="'.$r['id'].'" '.$checked.'> - '.$r['name']."</div>";
        $checked="";
    }
    $html .='</div>';
    return $html;
}

function join_value($str){
    $num=count($str);
    $max=$num-1;
    $string="";
    for ($i=0; $i<$num;$i++){
        if ($i<$max) $string .=$str[$i].',';
        else $string .=$str[$i];
    }
return $string;
}

function acp_studio($id = 0, $add = false) {
    global $mysqli;
    $q = $mysqli->query("SELECT * FROM jav_studio ORDER BY name ASC");
    $studio=explode(',',$id);
    $num=count($studio);
    $html='<div class="row">';
    $checked="";
    while ($r = $q->fetch_array()) {
        for ($i=0; $i<$num;$i++) if ($studio[$i]==$r['id']) $checked='checked="checked"';
        $html .= '<div class="col-md-3"><input type="checkbox" id="selectstudio" name="selectstudio[]" value="'.$r['id'].'" '.$checked.'> - '.$r['name']."</div>";
        $checked="";
    }
    $html .='</div>';
    return $html;
}

function acp_actor($id = 0, $add = false) {
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM jav_actor ORDER BY name ASC");
    $actor=explode(',',$id);
    $num=count($actor);
    $html='';
    while ($r = $q->fetch_array()) {
    for ($i=0; $i<$num;$i++) if ($actor[$i]==$r['id']) $html .= '<input type="checkbox" id="selectactor" name=selectactor[] value="'.$r['id'].'" checked>&nbsp;&nbsp; '.$r['name'].'&nbsp;&nbsp;&nbsp;&nbsp;';
	}
    return $html;
}

function acp_tags($id = 0) {
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM jav_tags ORDER BY name ASC");
    $tags=explode(',',$id);
    $num=count($tags);
    $html='';
    while ($r = $q->fetch_array()) {
        for ($i=0; $i<$num;$i++){
        	if ($tags[$i]==$r['id']) {
        		$html .= '<input type="checkbox" id="selecttag" name="selecttag[]" value="'.$r['id'].'" checked="checked"> - '.$r['name']."<br/>";
        	}
        }
    }
	return $html;
}

function m_htmlchars($str) {
	return str_replace(
		array('<', '>', '"', chr(92), chr(39)),
		array('&lt;', '&gt;', '&quot;', '&#92;', '&#39;'),
		$str
	);
}

function openImage($file){
    $type = exif_imagetype($file);
    switch($type)
    {
        case '1':
            $img = @imagecreatefromgif($file);
            break;
        case '2':
            $img = @imagecreatefromjpeg($file);
            break;
        case '3':
            $img = @imagecreatefrompng($file);
            break;
        default:
            $img = false;
            break;
    }
    return $img;
}

function resizeImage($fileName, $newWidth, $newHeight, $savePath,$status){
    	list($width, $height) = getimagesize($fileName);
    	$image=openImage($fileName);
    	if($status=='poster'){
    		$imageResized = imagecreatetruecolor($newWidth, $newHeight);
    	}else{
    		$imageResized = imagecreatetruecolor($width, $height);
    		$newWidth = $width;
    		$newHeight = $height;
    	}
    	//print($image);die;
		imagecopyresampled($imageResized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($imageResized, $savePath, 100);
        imagedestroy($image);
        imagedestroy($imageResized);
    return $savePath;
}
function acp_transload($url,$name,$type) {
	//resize_image
	if($type=='poster'){
		$savefile='/home/xxx/acp/tmp/'.time().'.jpg';
		$savend='/home/xxx/acp/tmp/'.$name.'-'.time().'.jpg';
		$status='poster';
		$f='dvd';
	}else{
		$savefile='/home/xxx/acp/tmp/'.time().'.jpg';
		$savend='/home/xxx/acp/tmp/'.$name.'-'.time().'.jpg';
		$status='info';
		$f='info';
	}
    $ch = curl_init ($url);
	$fp = fopen ($savefile, "w");
	curl_setopt ($ch, CURLOPT_FILE, $fp);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_exec ($ch);
	curl_close ($ch);
	fclose ($fp);
	$urlz=resizeImage($savefile, 215, 311, $savend,$status);
	$name = str_replace(' ', '-', $name);
	$filename = $name.'-'.time().'.jpg';
	$connect = ftp_connect('ip');
	$login_result = ftp_login($connect, 'userftp', 'passftp');
	if($login_result){
		if (ftp_chdir($connect, '/home/xxx/poster/'.$f)) {
			$file_path = '/home/xxx/poster/'.$f.'/'.$filename;
			if(ftp_put($connect,$filename,$urlz, FTP_BINARY)) $result = $file_path;
			else return 'Không upload được rồi';
		} else $result = 'Không kết nối được vào fordel';
	} else $result = 'Không login được ftp';
	ftp_close($connect);
	unlink($savend);

	unlink($savefile);
	$result=str_replace('/home/xxx/poster','http://cdn.xxx.org',$result);
	return $result;
}
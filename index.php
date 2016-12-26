<?php
ob_start();
session_start();
include("inc/config.php");
include("inc/func.php");
$t=isset($_GET['t'])?$_GET['t']:'';
switch ($t) {
	case 'login':
		include 'login.php';
		break;
	case 'cat':
		include 'cat.php';
		break;
	case 'episode':
		include 'episode.php';
		break;
	case 'video':
		include 'video.php';
		break;
	case 'dvd':
		include 'dvd.php';
		break;
	case 'player':
		include 'player.php';
		break;
	case 'slider':
		include 'slider.php';
		break;
	case 'actor':
		include 'actor.php';
		break;
	case 'studio':
		include 'studio.php';
		break;
	case 'user':
		include 'user.php';
		break;
	default:
		include 'dashboard.php';
		break;
}
?>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
define('db_host',			'localhost');
define('db_name',			'backend');
define('db_user',			'root');
define('db_pass',			'');
define('useradmin',			'');
define('passadmin',			'');
define('DOMAIN', 'localhost');
//$connection = mysql_connect(db_host,db_user,db_pass);
$mysqli = new mysqli(db_host,db_user,db_pass,db_name);
//$select_database = mysql_select_db(db_name, $connection);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
//mysql_query("SET NAMES utf8");

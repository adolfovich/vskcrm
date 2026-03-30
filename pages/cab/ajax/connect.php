<?php
session_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Support Database
include ('../../../_conf.php');
include ('../../../classes/safemysql.class.php');
$db = new SafeMySQL(array('host' => $db_host,'user' => $db_user, 'pass' => $db_pass, 'db' => $db_name, 'charset' => 'utf8'));

//var_dump($db->getRow("SELECT * FROM `settings`"));

require_once('../../../classes/core.class.php');

$core  = new Core();

$url = $core->url;
$form = $core->form;
$ip = $core->ip;
$get = $core->setGet();

if (isset($_SESSION['id'])) {
  $user_id = $_SESSION['id'];
  $user_data = $db->getRow("SELECT * FROM `users` WHERE `id` = ?i", $user_id);
} else {
  die();
}

$db_settings = $db->getAll("SELECT * FROM settings");
$settings=[];
foreach ($db_settings as $setting){
	$settings[$setting['name']] = [
		"description" => $setting['description'],
		"data" => $setting['data'],
	];
}

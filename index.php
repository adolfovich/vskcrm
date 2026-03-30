<?php

/*
+---------------------------------------------------------------------------+
|                                                                           |
| ============                                                              |
| Copyright (c) by eXeptional                                               |
| For contact details:                                                      |
| adolfovich@list.ru                                                                          |
|	                                                                        |
| PHP7.2 & MYSQL5.8                                                         |
+---------------------------------------------------------------------------+
*/

session_start();
set_time_limit (30000);

// Support Database
include ('_conf.php');
include ('classes/safemysql.class.php');
$db = new SafeMySQL(array('host' => $db_host,'user' => $db_user, 'pass' => $db_pass, 'db' => $db_name, 'charset' => 'utf8'));

if ($debug_mode){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
} else {
	error_reporting(0);
}

require_once('classes/core.class.php');

$core	= new Core();
$url	= $core->url;
$form	= $core->form;
$ip		= $core->ip;
$get	= $core->setGet();

if (isset($_SESSION['id'])) {
  $user_id = $_SESSION['id'];
}

require_once('pages/controller.php');

<?php

$menu = $db->getAll("SELECT * FROM `menu` WHERE `enabled` = 1 ORDER BY `ordering`");

$db_settings = $db->getAll("SELECT * FROM settings");
$settings=[];
foreach ($db_settings as $setting){
	$settings[$setting['name']] = [
		"description" => $setting['description'],
		"data" => $setting['data'],
	];
}

if (isset($url[1])) {
  $page_name = $db->getOne("SELECT name FROM menu WHERE url LIKE '%".$url[1]."%'");
}

if (isset($user_id)) {
  $auth_user = $db->getRow("SELECT * FROM `users` WHERE `id` = ?i", $user_id);
  $user_data = $auth_user;
  $employe = $db->getRow("SELECT * FROM `employees` WHERE `user_id` = ?i", $user_id);
  
  $user_profile = $db->getRow("SELECT * FROM `profiles` WHERE `id` = ?i", $user_data['profile']);
}

header("Cache-Control: no cache");
//session_cache_limiter("private_no_expire");

//var_dump($url[0]);

if ($url[0] == 'cab') {
  include ('pages/cab/template.php');
} else if ($url[0] == 'api') {
    include ('api/controller.php');
} else {
    include ('pages/cab/login.php');
}

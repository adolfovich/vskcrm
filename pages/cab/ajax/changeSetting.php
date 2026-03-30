<?php

require_once('connect.php');

$arr['response'] = [];


if (isset($_POST['name'])) {
  
  $db->query("UPDATE settings SET data = ?s WHERE name = ?s", $_POST['change'], $_POST['name']);
  
  $arr['response']['html'] = 'Success';

  
} else {
  $arr['error'] = 'error';
}

echo $core->returnJson($arr);

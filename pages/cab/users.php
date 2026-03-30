<?php

if (isset($get['a']) && $get['a'] == 'del') {
  if ($db->query("UPDATE `users` SET `status` = 0 WHERE `id` = ?i", $get['id'])) {
    $msg = ["type"=>"success", "text"=>"Пользователь удален"];
  };
}

if (isset($get['a']) && $get['a'] == 'return') {
  if ($db->query("UPDATE `users` SET `status` = 1 WHERE `id` = ?i", $get['id'])) {
    $msg = ["type"=>"success", "text"=>"Пользователь восстановлен"];
  };
}

if (isset($get['a']) && $get['a'] == 'del_profile') {
  $users_with_profile = $db->getAll("SELECT * FROM users WHERE profile = ?i", $get['id']);
  if (count($users_with_profile)) {
    $msg = ["type"=>"danger", "text"=>"Ошибка! Профиль не может быть удален так как установлен у пользователей"];
  } else {
    if ($db->query("UPDATE `profiles` SET `is_del` = 1 WHERE `id` = ?i", $get['id'])) {
      $msg = ["type"=>"success", "text"=>"Профиль удален"];
    }
  }
}

if (isset($get['a']) && $get['a'] == 'all_users') {
  $status[] = 0;
  $status[] = 1;
} else {
  $status[] = 1;
}

if (isset($_GET['search_user']) && $_GET['search_user'] != '') {
  $users_where = 'WHERE login LIKE "%'.$_GET['search_user'].'%" OR name LIKE "%'.$_GET['search_user'].'%"';
}

$users = $db->getAll("SELECT *,(SELECT name FROM crews WHERE id = employees.crew) as crew_name FROM users JOIN employees ON users.id = employees.user_id WHERE users.status IN (?a) ORDER BY employees.user_id", $status);

$profiles = $db->getAll("SELECT * FROM `profiles` WHERE `is_del` = 0");

include ('tpl/cab/users.tpl');

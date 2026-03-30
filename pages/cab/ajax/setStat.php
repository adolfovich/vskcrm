<?php

require_once('connect.php');

if (isset($_SESSION['id'])) {
  $user_data = $db->getRow("SELECT * FROM `users` WHERE `id` = ?i", $_SESSION['id']);
  $user_salons = explode(",", $user_data['salons']);
} else {
  $arr['error'] = 'Пользователь не авторизован';
  echo $core->returnJson($arr);
  die();
}

if (!$statistic = $db->getRow("SELECT * FROM `statistics` WHERE `string_id` = ?s", $form['stat'])) {
  $arr['error'] = 'Возникла ошибка. Обновите страницу';
  echo $core->returnJson($arr);
  die();
}

if (!$salon = $db->getRow("SELECT * FROM `salons` WHERE `id` = ?i", $form['salon'])) {
  $arr['error'] = 'Возникла ошибка. Обновите страницу';
  echo $core->returnJson($arr);
  die();
}

//var_dump($user_data['salons']);

if (!in_array($salon['id'], $user_salons) && $user_data['salons'] != 0) {
  $arr['error'] = 'У вас нет прав для добавления статистики этому салону';
  echo $core->returnJson($arr);
  die();
}

if ($tmp_data = $db->getRow("SELECT * FROM `stat_data` WHERE `date` = ?s AND `salon_id` = ?i AND `stat_id` = ?i", $form['date'], $salon['id'], $statistic['id'])) {
  //var_dump($tmp_data);
  $arr['error'] = 'За этот день уже есть данные';
  echo $core->returnJson($arr);
  die();
}

$insert = [
  'salon_id' => $salon['id'],
  'user_id' => $user_data['id'],
  'stat_id' => $statistic['id'],
  'value' => $form['value'],
  'date' => $form['date'],
];

$sql = $db->parse("INSERT INTO `stat_data` SET ?u", $insert);

if ($db->query($sql)) {
  $arr['response'] = 'Статистика добавлена';
  echo $core->returnJson($arr);
  die();
} else {
  $arr['error'] = 'Ошибка добавления статистики';
  echo $core->returnJson($arr);
  die();
}

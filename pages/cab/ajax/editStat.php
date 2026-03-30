<?php

require_once('connect.php');

if ($db->getRow("SELECT * FROM `stat_data` WHERE `id` = ?i", $form['id'])) {
  if (!preg_match("/[^0-9]/", $form['value'])) {
    $sql = $db->parse("UPDATE `stat_data` SET `value` = ?i WHERE `id` = ?i", $form['value'], $form['id']);
  } else {
    $arr['error'] = 'Неверное значение';
    echo $core->returnJson($arr);
    die();
  }
} else {
  $arr['error'] = 'Ошибка. Перезагрузите страницу.';
  echo $core->returnJson($arr);
  die();
}

if ($db->query($sql)) {
  $arr['response'] = 'Значение изменено';
  echo $core->returnJson($arr);
  die();
} else {
  $arr['error'] = 'Ошибка добавления статистики';
  echo $core->returnJson($arr);
  die();
}

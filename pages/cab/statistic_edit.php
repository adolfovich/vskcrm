<?php

if (isset($get['a']) && $get['a'] == 'save') {
  if (strlen($form['statName']) >= 5) {
    $update = [
      "name" => $form['statName'],
      "el_name" => $form['statElName']
    ];

    $q = $db->parse("UPDATE `statistics` SET ?u WHERE `id` = ?i", $update, $get['id']);

    if ($db->query($q)) {
      $msg = ["type"=>"success", "text"=>"Данные сохранены"];
    }
  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! Название статистики должно содержать не менее 5 символов"];
  }
}

if (isset($get['id'])) {
  if ($stat_data = $db->getRow("SELECT * FROM `statistics` WHERE `id` = ?i", $get['id'])) {

  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! Статистика не найдена"];
  }
}

include ('tpl/cab/statistic_edit.tpl');

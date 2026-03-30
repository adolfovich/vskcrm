<?php

if (isset($get['a']) && $get['a'] == 'del') {
  if ($db->query("UPDATE `statistics` SET `enabled` = 0 WHERE `id` = ?i", $get['id'])) {
    $msg = ["type"=>"success", "text"=>"Статистика удалена"];
  }
}

$statistics = $db->getAll("SELECT * FROM `statistics` WHERE `enabled` = 1");



include ('tpl/cab/stat_settings.tpl');

<?php

if (isset($get['a']) && $get['a'] == 'del') {
  if ($db->query("UPDATE `objects` SET `is_del` = 1 WHERE `id` = ?i", $get['id'])) {
    $msg = ["type"=>"success", "text"=>"Объект удален"];
  }
}

$objects = $db->getAll("SELECT *, (SELECT name FROM directions WHERE id = o.direction) as direction_name FROM objects o WHERE is_del = 0");


include ('tpl/cab/objects.tpl');

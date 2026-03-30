<?php

if (isset($get['a']) && $get['a'] == 'del') {
  if ($db->query("UPDATE `salons` SET `enabled` = 0 WHERE `id` = ?i", $get['id'])) {
    $msg = ["type"=>"success", "text"=>"Салон удален"];
  }
}

$salons = $db->getAll("SELECT * FROM salons WHERE enabled = 1");

$fields = $db->getAll("SELECT * FROM salons_fields WHERE deleted = 0 AND show_in_table = 1");


include ('tpl/cab/salons.tpl');

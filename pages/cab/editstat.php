<?php

$url_params = explode('?', $_SERVER['REQUEST_URI']);
//var_dump($url_params);

$stat_id = $db->getOne("SELECT `id` FROM `statistics` WHERE `string_id` = ?s", $_GET['stat']);

$salons = [];

if ($_GET['salon'] == 'all') {
  $all_salons = $db->getAll("SELECT `id` FROM `salons` WHERE `enabled` = 1");
  foreach ($all_salons as $salon) {
    $salons[] = $salon['id'];
  }
} else {
  $salons[] = $_GET['salon'];
}

//var_dump($salons);

$statistics = $db->getAll("SELECT
                                  sd.*,
                                  (SELECT name FROM salons WHERE id = sd.`salon_id`) as salon_name,
                                  (SELECT name FROM statistics WHERE id = sd.`stat_id`) as stat_name
                           FROM `stat_data` sd WHERE sd.`date` BETWEEN ?s AND ?s AND sd.`stat_id` = ?i AND sd.`salon_id` IN (?a)", $_GET['dateFrom'],  $_GET['dateTo'], $stat_id, $salons);



include ('tpl/cab/editStat.tpl');

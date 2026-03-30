<?php

require_once('connect.php');

//var_dump($form);

$statistic = $db->getRow("SELECT * FROM `statistics` WHERE `string_id` = ?s", $form['stat']);


//var_dump($statistic);

if ($form['salon'] != 'all') {
  $salon = ' AND `salon_id` = ' . $form['salon'];
} else {
  $salon = ' AND `salon_id` != 0';
}

if ($form['type'] == 'by_week') {
  $param_type = 'WEEK';
} else if ($form['type'] == 'by_month') {
  $param_type = 'MONTH';
} else {
  $param_type = 'DAY';
}

$sql = $db->parse("
  SELECT
    YEAR(`date`) as `year`,
    $param_type(`date`) as `$param_type`,
    MIN(`date`) as `start_date`,
    MAX(`date`) as `end_date`,
    SUM(`value`) as `value`
  FROM `stat_data`
  WHERE `stat_id` = ?i AND `date` BETWEEN ?s AND ?s $salon
  GROUP BY YEAR(`date`), $param_type(`date`) ORDER BY `date`
", $statistic['id'], $form['date_from'], $form['date_to']);

//var_dump($sql);

$data = $db->getAll($sql);

$data_values = [];
$x_axis = [];
foreach ($data as $value) {
  $data_values[] = $value['value'];
  $x_axis[] = date("d.m", strtotime($value['start_date']));
}


$output = [
  'data' => $data_values,
  'categories' => $x_axis,
  'title' => $statistic['name'],
  'element' => $statistic['el_name']
];

//$output = json_encode($output);

echo json_encode($output);



//var_dump($data);

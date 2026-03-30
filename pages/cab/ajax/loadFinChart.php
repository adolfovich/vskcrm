<?php
require_once('connect.php');

$arr['response'] = [];
$arr['response']['expenses'] = '';
$arr['response']['income'] = '';

$x_axis = [];
$data_values = [];
$data_values1 = [];

$date_start = strtotime($form["dateFrom"]);
$date_end = strtotime($form["dateTo"]);

if ($form["salon"] == 'all') {
  if ($user_data['salons'] == 0) {
    $accepted_salons = $db->getCol("SELECT id FROM salons WHERE enabled = 1  AND franchising = 0");
  } else {
    $accepted_salons = explode(",", $user_data['salons']);
  }

  //var_dump($accepted_salons);
} else {
  $accepted_salons[] = $form["salon"];
}

if ($form["chartType"] == 'days') {

  while ($date_start <= $date_end) {

    $expenses = $db->getRow("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name, SUM(amount) as sum_amount FROM finance_journal WHERE op_type = 'credit' AND salon IN (?a) AND date = ?s AND is_del = 0 GROUP BY date", $accepted_salons, date("Y-m-d", $date_start));

    $incomes = $db->getRow("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name, SUM(amount) as sum_amount FROM finance_journal WHERE op_type = 'debit' AND salon IN (?a) AND date = ?s AND is_del = 0 GROUP BY date", $accepted_salons, date("Y-m-d", $date_start));

    if ($expenses) {
      $data_values[] = $expenses['sum_amount'];
    } else {
      $data_values[] = 0;
    }

    if ($incomes) {
      $data_values1[] = $incomes['sum_amount'];
    } else {
      $data_values1[] = 0;
    }

    $x_axis[] = date("d.m", $date_start);
    $date_start += 86400;// прибавляем 86400 секунд (24 часа)
  }

} else if ($form["chartType"] == 'weeks') {

  while ($date_start <= $date_end) {
    $x_axis[] = date("d.m", $date_start) . ' - ' . date("d.m", ($date_start + (86400 * 6)));
    $date_start += 86400 * 7;// прибавляем 86400 секунд (24 часа)
  }

  $expenses = $db->getAll("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name, SUM(amount) as sum_amount FROM finance_journal WHERE op_type = 'credit' AND salon IN (?a) AND date BETWEEN ?s AND ?s AND is_del = 0 GROUP BY YEARWEEK(date)", $accepted_salons, $form["dateFrom"], $form["dateTo"]);

  $incomes = $db->getAll("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name, SUM(amount) as sum_amount FROM finance_journal WHERE op_type = 'debit' AND salon IN (?a) AND date BETWEEN ?s AND ?s AND is_del = 0 GROUP BY YEARWEEK(date)", $accepted_salons, $form["dateFrom"], $form["dateTo"]);

  foreach ($expenses as $value) {
    $data_values[] = $value['sum_amount'];
  }

  foreach ($incomes as $value1) {
    $data_values1[] = $value1['sum_amount'];
  }

} else if ($form["chartType"] == 'months') {

  $expenses = $db->getAll("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name, SUM(amount) as sum_amount FROM finance_journal WHERE op_type = 'credit' AND salon IN (?a) AND date BETWEEN ?s AND ?s AND is_del = 0 GROUP BY YEAR(date), MONTH(date)", $accepted_salons, $form["dateFrom"], $form["dateTo"]);

  $incomes = $db->getAll("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name, SUM(amount) as sum_amount FROM finance_journal WHERE op_type = 'debit' AND salon IN (?a) AND date BETWEEN ?s AND ?s AND is_del = 0 GROUP BY YEAR(date), MONTH(date)", $accepted_salons, $form["dateFrom"], $form["dateTo"]);

  foreach ($expenses as $expense) {
    $x_axis[] = $core->getMonthName(date("n", strtotime($expense['date']))) .' '. date("Y", strtotime($expense['date']));
  }

  foreach ($expenses as $value) {
    $data_values[] = $value['sum_amount'];
  }

  foreach ($incomes as $value1) {
    $data_values1[] = $value1['sum_amount'];
  }
}

$arr['response']['chart']['element'] = 'Расходы';
$arr['response']['chart']['data'] = $data_values;

$arr['response']['chart']['element1'] = 'Доходы';
$arr['response']['chart']['data1'] = $data_values1;

$arr['response']['chart']['title'] = 'Доходы и расходы';
$arr['response']['chart']['categories'] = $x_axis;

echo $core->returnJson($arr);

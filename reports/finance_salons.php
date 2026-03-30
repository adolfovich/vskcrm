<?php

require_once('connect.php');

if ($_GET["salon"] == 'all') {
 if ($user_data['salons'] == '0') {
	$accepted_salons = $db->getCol("SELECT id FROM salons WHERE enabled = 1 AND franchising = 0");
 } else {
	$accepted_salons = explode(",", $user_data['salons']);
 }
} else {
  $accepted_salons[] = $_GET["salon"];
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Ya Statistic">
  <meta name="author" content="Exeptional Software">
  <title>Отчет по салонам </title>
  <!-- Favicon -->
  <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

  <style>
    .report-header {
      max-width: 1024px;
      margin: 0 auto;
      text-align: center;
      margin-top: 50px;
    }

    table {
      width: 800px;
      margin: 0 auto;
      border: 1px #000 solid;
      border-collapse: collapse;
    }

    th {
      padding: 10px;
      border: 1px #000 solid;
      background: #ccc;
    }

    td {
      padding: 10px;
      border: 1px #000 solid;
      text-align: center;
    }


  </style>

</head>

<body>

  <div class="report-header">
    <div><h2>Отчет по салонам</h2></div>
    <div><h3>за период <?=date("d.m.Y", strtotime($_GET['dateFrom']))?> - <?=date("d.m.Y", strtotime($_GET['dateTo']))?></h3></div>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width: 40px;">#</th>
        <th>Название салона</th>
        <th>Доходы</th>
        <th>Расходы</th>
        <th>Остаток</th>
      </tr>
    </thead>
    <tbody>

<?php

$count_incomes = 0;
$count_expenses = 0;
$i = 1;

foreach ($accepted_salons as $accepted_salon) {
  if ($_GET["type"] == 'all') {
    $sql = $db->parse("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name FROM finance_journal WHERE salon = ?i AND date BETWEEN ?s AND ?s AND is_del = 0 ORDER BY date DESC", $accepted_salon, $_GET["dateFrom"], $_GET["dateTo"]);
  } else {
    if ($_GET["type"] == 1) {
      $type = 'debit';
    } else if ($_GET["type"] == 2) {
      $type = 'credit';
    } else {
      $type = 'neutral';
    }

    if (isset($_GET['description']) && $_GET['description'] != '' && $_GET['description'] != '0') {
      $sql = $db->parse("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name FROM finance_journal WHERE 	op_decryption = ?s AND op_type = ?s AND salon = ?i AND date BETWEEN ?s AND ?s AND is_del = 0 ORDER BY date DESC", $_GET['description'], $type, $accepted_salon, $_GET["dateFrom"], $_GET["dateTo"]);
    } else {
      $sql = $db->parse("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name FROM finance_journal WHERE op_type = ?s AND salon = ?i AND date BETWEEN ?s AND ?s AND is_del = 0 ORDER BY date DESC", $type, $accepted_salon, $_GET["dateFrom"], $_GET["dateTo"]);
    }
  }

  $operations = $db->getAll($sql);
  $expenses = 0;
  $incomes = 0;

  if ($operations) {
    foreach($operations as $operation) {
      if ($operation['op_type'] == 'credit') {
        $expenses += $operation['amount'];
      } else if ($operation['op_type'] == 'debit') {
        $incomes += $operation['amount'];
      }
    }
    $balance = $incomes-$expenses;
    echo '<tr>';
    echo '<td>'.$i.'</td>';
    echo '<td>'.$operation['salon_name'].'</td>';
    echo '<td>'.number_format($incomes, 2, '.', ' ').' р.</td>';
    echo '<td>'.number_format($expenses, 2, '.', ' ').' р.</td>';
    echo '<td>'.number_format($balance, 2, '.', ' ').' р.</td>';
    echo '</tr>';

    $count_incomes += $incomes;
    $count_expenses += $expenses;
    $i++;
  }

}
$count_balance = $count_incomes - $count_expenses;
echo '<tr style="background: #eee; border: 2px #000 solid;">';
echo '<td colSpan="2">Всего по салонам:</td>';
echo '<td>'.number_format($count_incomes, 2, '.', ' ').' р.</td>';
echo '<td>'.number_format($count_expenses, 2, '.', ' ').' р.</td>';
echo '<td>'.number_format($count_balance, 2, '.', ' ').' р.</td>';
echo '</tr>';
?>
    </tbody>
  </table>
</body>

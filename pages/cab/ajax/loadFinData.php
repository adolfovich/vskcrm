<?php


require_once('connect.php');

$arr['response'] = [];
$arr['response']['expenses'] = '';
$arr['response']['income'] = '';
$arr['response']['operations'] = '';

$op_type_names = [
  'credit' => 'Расход',
  'debit' => 'Доход',
  'neutral' => 'Инкасация',
];

if ($form["salon"] == 'all') {
 if ($user_data['salons'] == '0') {
	$accepted_salons = $db->getCol("SELECT id FROM salons WHERE enabled = 1  AND franchising = 0");
 } else {
	$accepted_salons = explode(",", $user_data['salons']);
 }
} else {
  $accepted_salons[] = $form["salon"];
}

if($settings['show_del_operations']['data']) {
	$show_del = '';
} else {
	$show_del = ' AND is_del = 0 ';
}

if ($form["type"] == 'all') {
	
  $sql = $db->parse("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name FROM finance_journal WHERE salon IN (?a) AND date BETWEEN ?s AND ?s ".$show_del." ORDER BY date DESC", $accepted_salons, $form["dateFrom"], $form["dateTo"]);
} else {
  if ($form["type"] == 1) {
    $type = 'debit';
  } else if ($form["type"] == 2) {
    $type = 'credit';
  } else {
    $type = 'neutral';
  }

  if (isset($form['description']) && $form['description'] != '' && $form['description'] != '0' && $form['description'] != 'all') {
    $sql = $db->parse("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name FROM finance_journal WHERE 	op_decryption = ?s AND op_type = ?s AND salon IN (?a) AND date BETWEEN ?s AND ?s ".$show_del." ORDER BY date DESC", $form['description'], $type, $accepted_salons, $form["dateFrom"], $form["dateTo"]);
  } else {
    $sql = $db->parse("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name FROM finance_journal WHERE op_type = ?s AND salon IN (?a) AND date BETWEEN ?s AND ?s ".$show_del." ORDER BY date DESC", $type, $accepted_salons, $form["dateFrom"], $form["dateTo"]);
  }

}

$operations = $db->getAll($sql);

$sum = 0;
$credit = 0;
$debit = 0;
$incass = 0;

if ($operations) {

  foreach($operations as $operation) {
	  if ($operation['is_del'] == 1) {
		$arr['response']['operations'] .= '<tr style="color: #ccc !important;">';  
	  } else {
		$arr['response']['operations'] .= '<tr>';
	  }
    
    $arr['response']['operations'] .= '<th scope="row">'.$operation['salon_name'].'</th>';
    $arr['response']['operations'] .= '<td>'.date("d.m.Y", strtotime($operation['date'])).'</td>';
    $arr['response']['operations'] .= '<td>'.$op_type_names[$operation['op_type']].'</td>';
    $arr['response']['operations'] .= '<td><div style="max-width: 150px; white-space: normal;">'.$operation['op_decryption'].'</div></td>';
    $arr['response']['operations'] .= '<td>'.number_format($operation['amount'], 2, '.', ' ').'</td>';
    $arr['response']['operations'] .= '<td><div style="max-width: 150px; white-space: normal;">'.$operation['op_comment'].'</div></td>';
    $arr['response']['operations'] .= '<td style="padding-left: 0; padding-right: 0; text-align: center;">';
	if ($operation['is_del'] != 1) {
		$arr['response']['operations'] .= '<a class="btn btn-outline-primary btn-sm" href="#" onClick="editOperation('.$operation['id'].')"><i class="fas fa-edit"></i></a> ';
		$arr['response']['operations'] .= '<a class="btn btn-outline-danger btn-sm" href="?deleteRecord='.$operation['id'].'"><i class="fas fa-trash-alt"></i></a>';
	}
	//$arr['response']['operations'] .= '<a class="btn btn-outline-success btn-sm" href="#" onClick="showOpHistory('.$operation['id'].')"><i class="fas fa-list"></i></a>';
    $arr['response']['operations'] .= '</td>';
    $arr['response']['operations'] .= '</tr>';
    $arr['response']['operations'] .= '';

    if ($operation['op_type'] == 'credit' && $operation['is_del'] == 0) {
      $sum -= $operation['amount'];
      $credit += $operation['amount'];
    } else if ($operation['op_type'] == 'debit' && $operation['is_del'] == 0) {
      $sum += $operation['amount'];
      $debit += $operation['amount'];
    }  else if ($operation['op_type'] == 'neutral' && $operation['is_del'] == 0) {      
      $incass += $operation['amount'];
    }
  }

  //$arr['response']['operations'] .= '<tfoot>';

  $arr['response']['operations'] .= '<tr style="background: #f6f9fc;">';
  //$arr['response']['operations'] .= '<th scope="col" style="text-align: right;"></th>';
  $arr['response']['operations'] .= '<th scope="col" colspan="7" style="text-align: center; font-weight: 400;">';
  $arr['response']['operations'] .= 'ДОХОД: ';
  $arr['response']['operations'] .= '<b>'.number_format($debit, 2, '.', ' ').'р.</b> | ';
  $arr['response']['operations'] .= 'РАСХОД: ';
  $arr['response']['operations'] .= '<b>'.number_format($credit, 2, '.', ' ').'р.</b> | ';

  $arr['response']['operations'] .= 'ИТОГО: ';
  $arr['response']['operations'] .= '<b>'.number_format($sum, 2, '.', ' ').'р.</b> | ';

  $arr['response']['operations'] .= 'ИНКАССАЦИЯ: ';
  $arr['response']['operations'] .= '<b>'.number_format($incass, 2, '.', ' ').'р.</b> </th> ';

  $arr['response']['operations'] .= '</tr>';

  //$arr['response']['operations'] .= '</tfoot>';

} else {
  $arr['response']['operations'] .= '<tr>';
  $arr['response']['operations'] .= '<td colspan="6" style="text-align: center;">Нет данных</td>';
  $arr['response']['operations'] .= '</tr>';
}

$expenses = $db->getAll("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name FROM finance_journal WHERE op_type = 'credit' AND salon IN (?a) AND date BETWEEN ?s AND ?s AND is_del = 0 ORDER BY date DESC", $accepted_salons, $form["dateFrom"], $form["dateTo"]);

if ($expenses) {
  foreach($expenses as $expense) {
    $arr['response']['expenses'] .= '<tr>';
    $arr['response']['expenses'] .= '<th scope="row">'.$expense['salon_name'].'</th>';
    $arr['response']['expenses'] .= '<td>'.date("d.m.Y", strtotime($expense['date'])).'</td>';
    $arr['response']['expenses'] .= '<td>Расход</td>';
    $arr['response']['expenses'] .= '<td>'.$expense['op_decryption'].'</td>';
    $arr['response']['expenses'] .= '<td>'.number_format($expense['amount'], 2, '.', ' ').'</td>';
    $arr['response']['expenses'] .= '<td>'.$expense['op_comment'].'</td>';
    $arr['response']['expenses'] .= '<td><a href="?deleteRecord='.$expense['id'].'"><i class="fas fa-trash-alt"></i></a></td>';
    $arr['response']['expenses'] .= '</tr>';

    $arr['response']['expenses'] .= '';
  }
} else {
  $arr['response']['expenses'] .= '<tr>';
  $arr['response']['expenses'] .= '<td colspan="6" style="text-align: center;">Нет данных</td>';
  $arr['response']['expenses'] .= '</tr>';
}

$incomes = $db->getAll("SELECT *, (SELECT name FROM salons WHERE id = salon) as salon_name FROM finance_journal WHERE op_type = 'debit' AND salon IN (?a) AND date BETWEEN ?s AND ?s AND is_del = 0 ORDER BY date DESC", $accepted_salons, $form["dateFrom"], $form["dateTo"]);

if ($incomes) {
  foreach($incomes as $income) {
    $arr['response']['income'] .= '<tr>';
    $arr['response']['income'] .= '<th scope="row">'.$income['salon_name'].'</th>';
    $arr['response']['income'] .= '<td>'.date("d.m.Y", strtotime($income['date'])).'</td>';
    $arr['response']['income'] .= '<td>Расход</td>';
    $arr['response']['income'] .= '<td>'.$income['op_decryption'].'</td>';
    $arr['response']['income'] .= '<td>'.number_format($income['amount'], 2, '.', ' ').'</td>';
    $arr['response']['income'] .= '<td>'.$income['op_comment'].'</td>';
    $arr['response']['income'] .= '<td><a href="?deleteRecord='.$income['id'].'"><i class="fas fa-trash-alt"></i></a></td>';
    $arr['response']['income'] .= '</tr>';
    $arr['response']['income'] .= '';
  }
} else {
  $arr['response']['income'] .= '<tr>';
  $arr['response']['income'] .= '<td colspan="6" style="text-align: center;">Нет данных</td>';
  $arr['response']['income'] .= '</tr>';
}

echo $core->returnJson($arr);

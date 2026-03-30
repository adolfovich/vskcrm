<?php

require_once('connect.php');


$arr['response'] = '';
//$arr['response'] = [];

//echo $form['opId'];

$OpHistory = $db->getAll("SELECT * FROM finance_journal_changes WHERE fj_id = ?i", $form['opId']);

if ($OpHistory) {
	$arr['response'] .= '<table class="table table-bordered">';
	
	foreach ($OpHistory as $operation) {
		$arr['response'] .= '<tr>';
			$arr['response'] .= '<td>'.$operation['date'].'</td>';
			$arr['response'] .= '<td>'.$operation['user'].'</td>';
			$arr['response'] .= '<td>'.$operation['old_date'].'</td>';
			$arr['response'] .= '<td>'.$operation['new_date'].'</td>';
			$arr['response'] .= '<td>'.$operation['old_op_type'].'</td>';
			$arr['response'] .= '<td>'.$operation['new_op_type'].'</td>';
			$arr['response'] .= '<td>'.$operation['old_op_decryption'].'</td>';
			$arr['response'] .= '<td>'.$operation['new_op_decryption'].'</td>';
			$arr['response'] .= '<td>'.$operation['old_amount'].'</td>';
			$arr['response'] .= '<td>'.$operation['new_amount'].'</td>';
			$arr['response'] .= '<td>'.$operation['old_op_comment'].'</td>';
			$arr['response'] .= '<td>'.$operation['new_op_comment'].'</td>';
			$arr['response'] .= '<td>'.$operation['old_salon'].'</td>';
			$arr['response'] .= '<td>'.$operation['new_salon'].'</td>';			
		$arr['response'] .= '</tr>';
	}
} else {
	$arr['response'] .= 'Нет данных';
}

echo $core->returnJson($arr);
<?php

//var_dump($user_data['salons']);

if ($user_data['salons'] === '0') {
  $accepted_salons = 0;
  $user_salons = $db->getAll("SELECT * FROM salons WHERE enabled = 1 AND franchising = 0");
  $user_salons_ids = $db->getCol("SELECT id FROM salons WHERE enabled = 1 AND franchising = 0");
} else if ($user_data['salons'] === '') {
  $accepted_salons = '';
  $user_salons = $db->getAll("SELECT * FROM salons WHERE enabled = 1 AND franchising = 0");
  $user_salons_ids = $db->getCol("SELECT id FROM salons WHERE enabled = 1 AND franchising = 0");
} else {
  $accepted_salons = explode(",", $user_data['salons']);
  $user_salons = $db->getAll("SELECT * FROM salons WHERE enabled = 1 AND id IN (?a)", $accepted_salons);
  $user_salons_ids = $db->getCol("SELECT id FROM salons WHERE enabled = 1 AND id IN (?a)", $accepted_salons);
}

if (isset($_GET['deleteRecord']) && $_GET['deleteRecord'] > 0) {
  $db->query("UPDATE finance_journal SET is_del = 1 WHERE id = ?i", $_GET['deleteRecord']);
  
  $fj_data = $db->getRow("SELECT * FROM finance_journal WHERE id = ?i", $_GET['deleteRecord']);
  
  $insert_changes = [
				'fj_id' => $fj_data['id'],
				'old_date' => $fj_data['date'],
				'new_date' => NULL,
				'old_op_type' => $fj_data['op_type'],
				'new_op_type' => '-',
				'old_op_decryption' => $fj_data['op_decryption'],
				'new_op_decryption' => '-',
				'old_amount' => $fj_data['amount'],
				'new_amount' => '0',
				'old_op_comment' => $fj_data['op_comment'],
				'new_op_comment' => '-',
				'old_salon' => $fj_data['salon'],
				'new_salon' => '0',
				'user' => $user_data['id']
			];
			
			$db->query('INSERT INTO finance_journal_changes SET ?u', $insert_changes);
			
			
  
  
  $msg['type'] = 'success';
  $msg['text'] = 'Операция удалена';
}

if (isset($form['action_type']) && $form['action_type'] == 'edit_operation') {
  if ($accepted_salons == 0 || in_array($form['opSalon'], $accepted_salons)) {
    if (time() > strtotime($form['opDete'])) {
      if ($form['opAmount'] > 0) {

        $operation_data = $db->getRow("SELECT * FROM finance_operation_types WHERE name = ?s", $form['opDesc']);
		
		$fj_data = $db->getRow("SELECT * FROM finance_journal WHERE id = ?i", $form['opId']);
		
		if (
			$fj_data['date'] != $form['opDete'] || 
			$fj_data['op_type'] != $operation_data['type'] || 
			$fj_data['op_decryption'] != $operation_data['name'] || 
			$fj_data['amount'] != $form['opAmount'] || 
			$fj_data['op_comment'] != $form['opComment'] ||
			$fj_data['salon'] != $form['opSalon']	
			) {
				
			$insert_changes = [
				'fj_id' => $fj_data['id'],
				'old_date' => $fj_data['date'],
				'new_date' => $form['opDete'],
				'old_op_type' => $fj_data['op_type'],
				'new_op_type' => $operation_data['type'],
				'old_op_decryption' => $fj_data['op_decryption'],
				'new_op_decryption' => $operation_data['name'],
				'old_amount' => $fj_data['amount'],
				'new_amount' => $form['opAmount'],
				'old_op_comment' => $fj_data['op_comment'],
				'new_op_comment' => $form['opComment'],
				'old_salon' => $fj_data['salon'],
				'new_salon' => $form['opSalon'],
				'user' => $user_data['id']
			];
			
			$db->query('INSERT INTO finance_journal_changes SET ?u', $insert_changes);
			
		}

        $update = [
          'salon' => $form['opSalon'],
          'date' => $form['opDete'],
          'op_type' => $operation_data['type'],
          'op_decryption' => $operation_data['name'],
          'amount' => $form['opAmount'],
          'op_comment' => $form['opComment']
        ];
        $db->query("UPDATE finance_journal SET ?u WHERE id = ?i", $update, $form['opId']);

        $msg['type'] = 'success';
        $msg['text'] = 'Операция сохранена';

      } else {
        $msg['window'] = 'addOperation';
        $msg['type'] = 'error';
        $msg['text'] = 'Сумма должна быть больше нуля';
      }
    } else {
      $msg['window'] = 'editOperation';
      $msg['type'] = 'error';
      $msg['text'] = 'Дата не может быть больше текущей';
    }
  } else {
    $msg['window'] = 'editOperation';
    $msg['type'] = 'error';
    $msg['text'] = 'Неверно указан салон';
  }
}

if (isset($form['action_type']) && $form['action_type'] == 'add_operation') {
  if ($accepted_salons == 0 || in_array($form['opSalon'], $accepted_salons)) {
    if (time() > strtotime($form['opDete'])) {
      if ($form['opAmount'] > 0) {
        $operation_data = $db->getRow("SELECT * FROM finance_operation_types WHERE id = ?s", $form['opDesc']);

        if(isset($_POST['op_param'])) {
          $op_params = json_encode($_POST['op_param']);
        } else {
          $op_params = NULL;
        }

        $insert = [
          'salon' => $form['opSalon'],
          'date' => $form['opDete'],
          'op_type' => $operation_data['type'],
          'op_decryption' => $operation_data['name'],
          'amount' => $form['opAmount'],
          'op_comment' => $form['opComment'],
          'op_params' => $op_params
        ];
        $db->query("INSERT INTO finance_journal SET ?u", $insert);

        $msg['type'] = 'success';
        $msg['text'] = 'Операция сохранена';
      } else {
        $msg['window'] = 'addOperation';
        $msg['type'] = 'error';
        $msg['text'] = 'Сумма должна быть больше нуля';
      }
    } else {
      $msg['window'] = 'addOperation';
      $msg['type'] = 'error';
      $msg['text'] = 'Дата не может быть больше текущей';
    }
  } else {
    $msg['window'] = 'addOperation';
    $msg['type'] = 'error';
    $msg['text'] = 'Неверно указан салон';
  }
}

$op_descriptions = $db->getAll("SELECT * FROM finance_operation_types WHERE salon IN (0, ?a) AND enable = 1", $user_salons_ids);

$descriptions = [];

foreach ($op_descriptions as $op_description) {
  if ($op_description['type'] == 'debit') {
    $descriptions[1][$op_description['id']] = $op_description['name'];
  } else if ($op_description['type'] == 'credit') {
    $descriptions[2][$op_description['id']] = $op_description['name'];
  } else {
    $descriptions[3][$op_description['id']] = $op_description['name'];
  }
}

$descriptions = json_encode($descriptions);

$filter = [];

if (isset($_COOKIE['finFilter']) && $_COOKIE['finFilter'] != '') {
  $finFilter = explode("&", $_COOKIE['finFilter']);
  foreach($finFilter as $value) {
    $filterEl = explode("=", $value);
    $filter[$filterEl[0]] = $filterEl[1];
  }
}

$salons = $db->getAll("SELECT * FROM salons WHERE enabled = 1");

include ('tpl/cab/finance.tpl');

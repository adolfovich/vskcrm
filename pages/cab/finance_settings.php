<?php

if (isset($form['action_type']) && $form['action_type'] == 'edit_operation') {
  $update = [
    'salon' => $form['opSalon'],
    'name' => $form['opName'],
    'type' => $form['opType']
  ];

  $db->query("UPDATE finance_operation_types SET ?u WHERE id =?i", $update, $form['opId']);

  $msg['type'] = 'success';
  $msg['text'] = 'Операция сохранена';
}

if (isset($form['action_type']) && $form['action_type'] == 'add_operation') {
  if (strlen($form['opName']) > 5) {

    $insert = [
      'salon' => $form['opSalon'],
      'name' => $form['opName'],
      'enable' => 1,
      'type' => $form['opType']
    ];

    $db->query("INSERT INTO finance_operation_types SET ?u", $insert);

    $msg['type'] = 'success';
    $msg['text'] = 'Операция добавлена';

  } else {
    $msg['window'] = 'addOperation';
    $msg['type'] = 'error';
    $msg['text'] = 'Название операции должно быть больше 5 символов';
  }
}

if (isset($_GET['delete']) && $_GET['delete'] > 0) {
  $db->query("UPDATE finance_operation_types SET enable = 0 WHERE id = ?i", $_GET['delete']);

  $msg['type'] = 'success';
  $msg['text'] = 'Операция удалена';
}

$all_salons = $db->getAll("SELECT * FROM salons WHERE enabled = 1");

if (isset($form['opNameSearch']) && $form['opNameSearch'] != '') {
  $operations = $db->getAll("SELECT * FROM finance_operation_types WHERE enable = 1 AND name LIKE ?s", '%'.$form['opNameSearch'].'%');
} else {
  $operations = $db->getAll("SELECT * FROM finance_operation_types WHERE enable = 1");
}





include ('tpl/cab/finance_settings.tpl');

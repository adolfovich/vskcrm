<?php

if (!$user_profile['edit_salons']) {
  include ('tpl/cab/403.tpl');
  die();
}

if (isset($form['field_ordering'])) {
  $db->query("UPDATE salons_fields SET ordering = ?i WHERE id = ?i", $form['field_ordering'], $form['field_id']);
}

if (isset($_GET['deleteField']) && $_GET['deleteField'] > 0) {
  $db->query("UPDATE salons_fields SET deleted = 1 WHERE id = ?i", $_GET['deleteField']);
  $msg['type'] = 'success';
  $msg['text'] = 'Поле удалено';
}

if (isset($form['editFieldId']) && $form['editFieldId'] > 0) {
  if ($form['EditFieldName'] != '') {
    $update = [
      'name' => $form['EditFieldName'],
      'ordering' => $form['EditFieldOrdering'],
    ];

    if (isset($form['EditfieldShow'])) {
      $update['show_in_table'] = 1;
    } else {
      $update['show_in_table'] = 0;
    }
    $db->query("UPDATE salons_fields SET ?u WHERE id = ?i", $update, $form['editFieldId']);
    $msg['type'] = 'success';
    $msg['text'] = 'Поле сохранено';
  } else {
    $msg['window'] = 'editField';
    $msg['type'] = 'error';
    $msg['text'] = 'Название не может быть пустым';
  }
}

//addFieldForm
if (isset($form['action']) && $form['action'] == 'addField') {
  if ($form['addFieldName'] != '') {
    $insert = [
      'name' => $form['addFieldName'],
      'ordering' => $form['addFieldOrdering']
    ];
    if (isset($form['addFieldShow'])) {
      $insert['show_in_table'] = 1;
    }
    $db->query("INSERT INTO salons_fields SET ?u", $insert);
    $msg['type'] = 'success';
    $msg['text'] = 'Поле сохранено';
  } else {
    $msg['window'] = 'addField';
    $msg['type'] = 'error';
    $msg['text'] = 'Название не может быть пустым';
  }
}


$fields = $db->getAll("SELECT * FROM salons_fields WHERE deleted = 0 ORDER BY ordering");

include ('tpl/cab/salons_fields.tpl');

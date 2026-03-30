<?php

if (isset($_GET['delete']) && $_GET['type_id'] > 0) {
  $db->query("UPDATE tickets_types SET deleted = 1 WHERE id = ?i", $_GET['type_id']);
}

if (isset($form['action_type'])) {
  if ($form['action_type'] == 'add_type') {
    $insert = [
      'name' => $form['typeName'],
    ];
    $db->query("INSERT INTO tickets_types SET ?u", $insert);
  }

  if ($form['action_type'] == 'edit_type') {
    $update = [
      'name' => $form['typeName'],
    ];
    $db->query("UPDATE tickets_types SET ?u WHERE id = ?i", $update, $form['typeId']);
  }
}

$types = $db->getAll("SELECT tt.*  FROM tickets_types tt WHERE deleted = 0");

include ('tpl/cab/tickets_types.tpl');

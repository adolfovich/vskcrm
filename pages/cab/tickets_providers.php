<?php

if (isset($_GET['delete']) && $_GET['provider_id'] > 0) {
  $db->query("UPDATE tickets_providers SET deleted = 1 WHERE id = ?i", $_GET['provider_id']);
}

if (isset($form['action_type'])) {
  if ($form['action_type'] == 'add') {
    $insert = [
      'name' => $form['providerName'],
      'desctiption' => $form['providerDescription'],
      'email' => $form['providerEmail'],
    ];
    $db->query("INSERT INTO tickets_providers SET ?u", $insert);
  }

  if ($form['action_type'] == 'edit') {
    $update = [
      'name' => $form['providerName'],
      'desctiption' => $form['providerDescription'],
      'email' => $form['providerEmail'],
    ];
    $db->query("UPDATE tickets_providers SET ?u WHERE id = ?i", $update, $form['providerId']);
  }
}

$providers = $db->getAll("SELECT *  FROM tickets_providers WHERE deleted = 0");

include ('tpl/cab/tickets_providers.tpl');

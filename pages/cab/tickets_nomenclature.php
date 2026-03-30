<?php

if (isset($_GET['delete']) && $_GET['product_id'] > 0) {
  $db->query("UPDATE tickets_nomenclature SET deleted = 1 WHERE id = ?i", $_GET['product_id']);
}

if (isset($form['action_type'])) {
  if ($form['action_type'] == 'add') {
    $insert = [
      'name' => $form['productName'],
      'description' => $form['productDescription'],
      'provider' => $form['productProvider'],
      'type' => $form['productType'],
    ];
    $db->query("INSERT INTO tickets_nomenclature SET ?u", $insert);
  }

  if ($form['action_type'] == 'edit') {
    $update = [
      'name' => $form['productName'],
      'description' => $form['productDescription'],
      'provider' => $form['productProvider'],
      'type' => $form['productType'],
    ];
    $db->query("UPDATE tickets_nomenclature SET ?u WHERE id = ?i", $update, $form['productId']);
  }
}

$nomenclature = $db->getAll("SELECT tn.*, (SELECT name FROM tickets_providers WHERE id = tn.provider) as provider_name  FROM tickets_nomenclature tn WHERE tn.deleted = 0");

$providers = $db->getAll("SELECT * FROM tickets_providers WHERE deleted = 0");

include ('tpl/cab/tickets_nomenclature.tpl');

<?php

if (isset($_GET['sort']) && $_GET['status_id'] > 0) {
  if ($_GET['sort'] == 'up') {
    $db->query("UPDATE tickets_statuses SET ordering = ordering - 1 WHERE id = ?i", $_GET['status_id']);
  } else if ($_GET['sort'] == 'down') {
    $db->query("UPDATE tickets_statuses SET ordering = ordering + 1 WHERE id = ?i", $_GET['status_id']);
  }
}

if (isset($_GET['delete']) && $_GET['status_id'] > 0) {
  $db->query("UPDATE tickets_statuses SET deleted = 1 WHERE id = ?i", $_GET['status_id']);
}

if (isset($form['action_type'])) {
  if ($form['action_type'] == 'add_status') {
    $next_statuses = '';
    $i = 0;
    //var_dump($form);
    if (isset($form['statusNext']) && count($form['statusNext'])) {
      foreach ($form['statusNext'] as $status) {
        if ($i != 0) {
          $next_statuses .= ',';
        }
        $next_statuses .= $status;
        $i++;
      }
    }

    $insert = [
      'name' => $form['statusName'],
      'color' => $form['statusColor'],
      'next_statuses' => $next_statuses,
    ];

    $db->query("INSERT INTO tickets_statuses SET ?u", $insert);
  }

  if ($form['action_type'] == 'edit_status') {
    $next_statuses = '';
    $i = 0;
    //var_dump($form);
    if (isset($form['statusNext']) && count($form['statusNext'])) {
      foreach ($form['statusNext'] as $status) {
        if ($i != 0) {
          $next_statuses .= ',';
        }
        $next_statuses .= $status;
        $i++;
      }
    }

    $update = [
      'name' => $form['statusName'],
      'color' => $form['statusColor'],
      'next_statuses' => $next_statuses,
    ];

    $db->query("UPDATE tickets_statuses SET ?u WHERE id = ?i", $update, $form['statusId']);
  }
}

$statuses = $db->getAll("SELECT ts.*, (SELECT name FROM tickets_statuses WHERE id = ts.next_statuses) as next_status FROM tickets_statuses ts WHERE deleted = 0 ORDER BY ts.ordering");

include ('tpl/cab/tickets_statuses.tpl');

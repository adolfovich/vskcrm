<?php

if (isset($get['a']) && $get['a'] == 'save') {
  //var_dump($form['accepted_ticket_statuses']);
  if (strlen($form['profileName']) >= 5) {
    $update['name'] = $form['profileName'];
    if ($form['access']) {
      $update_access = '';
      $update_stat_access = '';

      $end_element = array_pop($form['access']);
      foreach ($form['access'] as $value) {
         $update_access .= $value . ',';
      }
      $update_access .= $end_element;

      $end_element1 = array_pop($form['stat_access']);
      foreach ($form['stat_access'] as $value) {
         $update_stat_access .= $value . ',';
      }
      $update_stat_access .= $end_element1;

      if (isset($form['change_ticket_status']) && $form['change_ticket_status'] == 1) {
        $change_ticket_status = '1';
      } else {
        $change_ticket_status = '0';
      }

      if (isset($form['edit_education']) && $form['edit_education'] == 1) {
        $edit_education = '1';
      } else {
        $edit_education = '0';
      }

      if (isset($form['edit_finance']) && $form['edit_finance'] == 1) {
        $edit_finance = '1';
      } else {
        $edit_finance = '0';
      }

      if (isset($form['edit_salons']) && $form['edit_salons'] == 1) {
        $edit_salons = '1';
      } else {
        $edit_salons = '0';
      }

      if (isset($form['change_close_tickets']) && $form['change_close_tickets'] == 1) {
        $change_close_tickets = '1';
      } else {
        $change_close_tickets = '0';
      }
	  
	  if (isset($form['delete_tickets']) && $form['delete_tickets'] == 1) {
        $delete_tickets = '1';
      } else {
        $delete_tickets = '0';
      }

      if ($form['accepted_ticket_statuses']) {
        $update['accepted_ticket_statuses'] = implode(',', $form['accepted_ticket_statuses']);
      }

      $update['access'] = $update_access;
      $update['stat_access'] = $update_stat_access;
      $update['change_ticket_status'] = $change_ticket_status;
      $update['edit_education'] = $edit_education;
      $update['edit_finance'] = $edit_finance;
      $update['edit_salons'] = $edit_salons;
      $update['change_close_tickets'] = $change_close_tickets;
      $update['delete_tickets'] = $delete_tickets;

      $q = $db->parse("UPDATE `profiles` SET ?u WHERE `id` = ?i", $update, $get['id']);

      //var_dump($q);

      if ($db->query($q)) {
        $msg = ["type"=>"success", "text"=>"Профиль изменен"];
      }

    }
  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! Название профиля должно быть не менее 5 символов"];
  }
}

if (isset($get['id'])) {
  if (intval($get['id']) > 0 && $profile_data = $db->getRow("SELECT * FROM `profiles` WHERE `id` = ?i", $get['id'])) {
    $access = explode(",", $profile_data['access']);

    $statistics = $db->getAll("SELECT * FROM `statistics` WHERE `enabled` = 1");
    $stat_access = explode(",", $profile_data['stat_access']);

  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! профиль не найден"];
    $error_open = TRUE;
  }
}

if (isset($get['type']) && $get['type'] == 'new') {

    $msg = ["type"=>"success", "text"=>"Профиль создан"];

}

$tickets_statuses = $db->getAll("SELECT * FROM tickets_statuses WHERE deleted = 0 ORDER BY ordering");

$accepted_statuses = explode(',', $profile_data['accepted_ticket_statuses']);
//var_dump($accepted_statuses);

include ('tpl/cab/profile_edit.tpl');

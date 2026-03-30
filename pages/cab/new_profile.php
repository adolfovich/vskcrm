<?php

if (isset($get['a']) && $get['a'] == 'new') {
  //var_dump($form);
  if (strlen($form['profileName']) >= 5) {
    $insert['name'] = $form['profileName'];
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

      //$insert['name'] = $update_access;
      $insert['access'] = $update_access;
      $insert['stat_access'] = $update_stat_access;
      $insert['change_ticket_status'] = $change_ticket_status;
      $insert['edit_education'] = $edit_education;


      //$q = $db->parse("UPDATE `profiles` SET ?u WHERE `id` = ?i", $update, $get['id']);
      $q = $db->parse("INSERT INTO profiles SET ?u", $insert);

      //var_dump($q);

      if ($db->query($q)) {
        $new_id = $db->insertId();
        $core->jsredir('profile_edit?id='.$new_id.'&type=new');
        //$msg = ["type"=>"success", "text"=>"Профиль сохранен"];
      }

    }
  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! Название профиля должно быть не менее 5 символов"];
  }
}

if (isset($get['id'])) {
  if ($profile_data = $db->getRow("SELECT * FROM `profiles` WHERE `id` = ?i", $get['id'])) {
    $access = explode(",", $profile_data['access']);

    $statistics = $db->getAll("SELECT * FROM `statistics` WHERE `enabled` = 1");
    $stat_access = explode(",", $profile_data['stat_access']);
  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! профиль не найден"];
  }
}

$statistics = $db->getAll("SELECT * FROM `statistics` WHERE `enabled` = 1");

include ('tpl/cab/new_profile.tpl');

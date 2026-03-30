<?php

if (isset($get['a']) && $get['a'] == 'save' && $user_profile['edit_salons']) {
  if (strlen($form['salonName']) >= 5) {
    $update['name'] = $form['salonName'];


    if (isset($form['franchising']) && $form['franchising'] == 1) {
      $update['franchising'] = 1;
    } else {
      $update['franchising'] = 0;
    }

    if (!$form['rent_amount']) $form['rent_amount'] = 0;
    if (!$form['communal_amount']) $form['communal_amount'] = 0;

    $update['rent_day_pay'] = $form['rent_day_pay'];
    $update['rent_amount'] = $form['rent_amount'];
    $update['rent_type'] = $form['rent_type'];
    $update['communal_amount'] = $form['communal_amount'];
    $update['payment_card'] = $form['payment_card'];
    $update['payment_person'] = $form['payment_person'];

    $q = $db->parse("UPDATE `salons` SET ?u WHERE `id` = ?i", $update, $get['id']);

    foreach ($form['salonFields'] as $field_id => $field_value) {
      if ($field_value != '') {
        $core->setSalonFieldValue($get['id'], $field_id, $field_value);
      }
    }

    if ($db->query($q)) {
      $msg = ["type"=>"success", "text"=>"Данные сохранены"];
    }


  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! Название салона должно содержать не менее 5 символов"];
  }
}

if (isset($get['id'])) {
  if ($salon_data = $db->getRow("SELECT * FROM `salons` WHERE `id` = ?i", $get['id'])) {
    $fields_list = $db->getAll("SELECT * FROM salons_fields WHERE deleted != 1");
  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! салон не найден"];
  }
}

if (!$user_profile['edit_salons']) {
  $disabled = 'disabled';
} else {
  $disabled = '';
}

include ('tpl/cab/salon_edit.tpl');

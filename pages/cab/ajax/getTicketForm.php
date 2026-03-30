<?php

require_once('connect.php');

$html = '';

if (isset($form['ticket_type']) && $form['ticket_type'] > 0) {
  $fields = $db->getAll("SELECT * FROM `tickets_fields` WHERE `ticket_type` = ?i", $form['ticket_type']);
  $salons = $db->getAll("SELECT * FROM `salons` WHERE `enabled` = 1");
  $user_data = $db->getRow("SELECT * FROM `users` WHERE `id` = ?i", $_SESSION['id']);
  $user_salons = explode(",", $user_data['salons']);

  $html .= '<input type="hidden" name="type" value="'.$form['ticket_type'].'">';

  $html .= '<div class="row">';
    $html .= '<div class="col-md-12">';
      $html .= '<div class="form-group">';
        $html .= '<label for="selectStatistic">Выберите салон</label>';
        $html .= '<select name="salon" class="form-control has-success" data-toggle="select">';
        foreach($salons as $salon) {
          if (in_array($salon['id'], $user_salons) || $user_data['salons'] == 0) {
            $html .= '<option value="'.$salon['id'].'">'.$salon['name'].'</option>';
          }
        }
        $html .= '</select>';
      $html .= '</div>';
    $html .= '</div>';
  $html .= '</div>';

  foreach ($fields as $field) {
    if ($field['required']) {
      $required = '<span style="color: red; font: icon;"> *</span>';
    } else {
      $required = '';
    }
    $html .= '<div class="row">';

    if ($field['type'] != 'textarea' && $field['type'] != 'number') {
      $html .= '<div class="col-md-12">';
        $html .= '<div class="form-group">';

          $html .= '<label for="">'.$field['name'].$required.'</label>';
          $html .= '<input type="'.$field['type'].'" name="field_'.$field['id'].'" class="form-control ticketForm" placeholder="">';
        $html .= '</div>';
      $html .= '</div>';
    } else if ($field['type'] == 'number') {
      $html .= '<div class="col-md-6">';
        $html .= '<div class="form-group">';
          $html .= '<label for="">'.$field['name'].$required.'</label>';
        $html .= '</div>';
      $html .= '</div>';
      $html .= '<div class="col-md-6">';
        $html .= '<div class="form-group">';
            $html .= '<input type="'.$field['type'].'" name="field_'.$field['id'].'" class="form-control ticketForm" placeholder="">';
        $html .= '</div>';
      $html .= '</div>';
    } else if ($field['type'] == 'textarea') {
      $html .= '<div class="col-md-12">';
        $html .= '<div class="form-group">';
          $html .= '<label for="">'.$field['name'].$required.'</label>';
          $html .= '<textarea name="field_'.$field['id'].'" class="form-control ticketForm" rows="3" placeholder=""></textarea>';
        $html .= '</div>';
      $html .= '</div>';
    }

    $html .= '</div>';
  }
  $html .= '<div class="row">';
  $html .= '<div class="col-md-12">';
  $html .= '<div class="form-group">';
  $html .= '<button type="button" onClick="sendTiket()" class="btn btn-primary">Отправить</button>';
  $html .= '</div>';
  $html .= '</div>';
  $html .= '</div>';

  $arr['response'] = $html;
} else {
  $arr['error'] = 'Ошибка. Неверный тип статистики';
}

echo $core->returnJson($arr);

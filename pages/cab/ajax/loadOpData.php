<?php

require_once('connect.php');

$arr['response'] = [];

$user_data = $db->getRow("SELECT * FROM users WHERE id = ?i", $_SESSION['id']);

if (!$user_data['salons']) {
  $accepted_salons = 0;
  $user_salons = $db->getAll("SELECT * FROM salons WHERE enabled = 1");
  $user_salons_ids = $db->getCol("SELECT id FROM salons WHERE enabled = 1");
} else {
  $accepted_salons = explode(",", $user_data['salons']);
  $user_salons = $db->getAll("SELECT * FROM salons WHERE enabled = 1 AND id IN (?a)", $accepted_salons);
  $user_salons_ids = $db->getCol("SELECT id FROM salons WHERE enabled = 1 AND id IN (?a)", $accepted_salons);
}

$operation_data = $db->getRow("SELECT * FROM finance_journal WHERE id = ?i", $form['id']);
$selected = '';

$arr['response']['html'] = '';
$arr['response']['html'] .= '<input type="hidden" name="opId" value="'.$operation_data['id'].'">';
$arr['response']['html'] .= '<div class="form-group" style="margin-bottom: 0.5rem;">';
$arr['response']['html'] .= '<label for="opSalon">Салон</label>';
$arr['response']['html'] .= '<select class="form-control" id="opSalon" name="opSalon">';
foreach($user_salons as $user_salon) {
  if ($operation_data['salon'] == $user_salon['id']) {
    $selected = 'selected';
  } else {
    $selected = '';
  }
  $arr['response']['html'] .= '<option value="'.$user_salon['id'].'" '.$selected.'>'.$user_salon['name'].'</option>';
}
$arr['response']['html'] .= '</select>';
$arr['response']['html'] .= '</div>';

$arr['response']['html'] .= '<div class="form-group" style="margin-bottom: 0.5rem;">';
$arr['response']['html'] .= '<label for="opDete">Дата операции</label>';
$arr['response']['html'] .= '<input type="date" name="opDete" class="form-control" id="opDete" placeholder="" value="'.date("Y-m-d", strtotime($operation_data['date'])).'">';
$arr['response']['html'] .= '</div>';
$arr['response']['html'] .= '<div class="form-group" style="margin-bottom: 0.5rem;">';
$arr['response']['html'] .= '<label for="opType">Тип операции</label>';
$arr['response']['html'] .= '<select class="form-control" id="opType" name="opType" onChange="loadDescriptions();">';
$arr['response']['html'] .= '<option value="1"';
if ($operation_data['op_type'] == 'debit') $arr['response']['html'] .= 'selected';
$arr['response']['html'] .= '>Доход</option>';
$arr['response']['html'] .= '<option value="2"';
if ($operation_data['op_type'] == 'credit') $arr['response']['html'] .= 'selected';
$arr['response']['html'] .= '>Расход</option>';
$arr['response']['html'] .= '<option value="3"';
if ($operation_data['op_type'] == 'neutral') $arr['response']['html'] .= 'selected';
$arr['response']['html'] .= '>Инкассация</option>';
$arr['response']['html'] .= '</select>';
$arr['response']['html'] .= '</div>';

$arr['response']['html'] .= '<div class="form-group" style="margin-bottom: 0.5rem;">';
$arr['response']['html'] .= '<label for="opDesc">Расшифровка</label>';
$arr['response']['html'] .= '<select class="form-control" id="opDesc" name="opDesc">';
$descriptions = $db->getAll("SELECT * FROM finance_operation_types WHERE type = ?s AND enable = 1", $operation_data['op_type']);
$selected = '';
foreach ($descriptions as $description) {
  if ($description['name'] == $operation_data['op_decryption']) {
    $selected = 'selected';
  } else {
    $selected = '';
  }
  $arr['response']['html'] .= '<option value="'.$description['name'].'" '.$selected.'>'.$description['name'].'</option>';
}
$arr['response']['html'] .= '</select>';
$arr['response']['html'] .= '</div>';

$arr['response']['html'] .= '<div class="form-group" style="margin-bottom: 0.5rem;">';
$arr['response']['html'] .= '<label for="opAmount">Сумма</label>';
$arr['response']['html'] .= '<input type="number" name="opAmount" class="form-control" id="opAmount" placeholder="" value="'.$operation_data['amount'].'">';
$arr['response']['html'] .= '</div>';

$arr['response']['html'] .= '<div class="form-group" style="margin-bottom: 0.5rem;">';
$arr['response']['html'] .= '<label for="opComment">Комментарий</label>';
$arr['response']['html'] .= '<input type="text" name="opComment" class="form-control" id="opComment" placeholder="" value="'.$operation_data['op_comment'].'">';
$arr['response']['html'] .= '</div>';
$arr['response']['html'] .= '';
$arr['response']['html'] .= '';

echo $core->returnJson($arr);

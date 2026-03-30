<?php

require_once('connect.php');

$arr['response'] = [];

$operation_type_data = $db->getRow("SELECT * FROM finance_operation_types WHERE id = ?i", $form['id']);

$all_salons = $db->getAll("SELECT * FROM salons WHERE enabled = 1");


$arr['response']['html'] = '';

$arr['response']['html'] .= '<input type="hidden" name="opId" value="'.$operation_type_data['id'].'" />';

$arr['response']['html'] .= '<div class="form-group">';
$arr['response']['html'] .= '<label for="opSalon">Салон</label>';
$arr['response']['html'] .= '<select class="form-control" id="opSalon" name="opSalon">';
$arr['response']['html'] .= '<option value="0">Все салоны</option>';
foreach($all_salons as $salon) {
  if ($operation_type_data['salon'] != 0 && $operation_type_data['salon'] == $salon['id']) {
    $selected = 'selected';
  } else {
    $selected = '';
  }
  $arr['response']['html'] .= '<option value="'.$salon['id'].'" '.$selected.'>'.$salon['name'].'</option>';
}
$arr['response']['html'] .= '</select>';
$arr['response']['html'] .= '</div>';

$arr['response']['html'] .= '<div class="form-group">';
$arr['response']['html'] .= '<label for="opType">Тип операции</label>';
$arr['response']['html'] .= '<select class="form-control" id="opType" name="opType">';
$arr['response']['html'] .= '<option value="debit"';
if ($operation_type_data['type'] == 'debit') $arr['response']['html'] .= 'selected';
$arr['response']['html'] .= '>Доход</option>';
$arr['response']['html'] .= '<option value="credit"';
if ($operation_type_data['type'] == 'credit') $arr['response']['html'] .= 'selected';
$arr['response']['html'] .= '>Расход</option>';
$arr['response']['html'] .= '<option value="neutral"';
if ($operation_type_data['type'] == 'neutral') $arr['response']['html'] .= 'selected';
$arr['response']['html'] .= '>Инкассация</option>';
$arr['response']['html'] .= '</select>';
$arr['response']['html'] .= '</div>';

$arr['response']['html'] .= '<div class="form-group">';
$arr['response']['html'] .= '<label for="opName">Название</label>';
$arr['response']['html'] .= '<input type="text" name="opName" class="form-control" id="opName" placeholder="" value="'.$operation_type_data['name'].'">';
$arr['response']['html'] .= '</div>';
$arr['response']['html'] .= '';
$arr['response']['html'] .= '';



echo $core->returnJson($arr);

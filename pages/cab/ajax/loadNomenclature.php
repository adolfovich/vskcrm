<?php

require_once('connect.php');

$arr['response'] = [];


if (isset($_POST['id'])) {

  $nomenclature = $db->getAll("SELECT * FROM tickets_nomenclature WHERE provider = ?i AND deleted = 0", $_POST['id']);

  if ($nomenclature) {

    $arr['response']['html'] = '';

    $arr['response']['html'] .= '<div class="form-row">';
    $arr['response']['html'] .= '<div class="col text-center">Название</div>';
    $arr['response']['html'] .= '<div class="col text-center">Прошлая закупка</div>';
    $arr['response']['html'] .= '<div class="col text-center">Остаток</div>';
    $arr['response']['html'] .= '<div class="col text-center">Заказ</div>';
    $arr['response']['html'] .= '</div>';

    foreach ($nomenclature as $element) {
      //var_dump($element);
      $arr['response']['html'] .= '<div class="form-row">';
      $arr['response']['html'] .= '<div class="col">'.$element['name'].'</div>';
      $arr['response']['html'] .= '<div class="col"><input type="number" class="form-control" value="0" disabled></div>';
      $arr['response']['html'] .= '<div class="col"><input name="nomenclature['.$element['id'].'][old]" type="number" class="form-control" min="0"></div>';
      $arr['response']['html'] .= '<div class="col"><input name="nomenclature['.$element['id'].'][new]" type="number" class="form-control" min="0"></div>';
      $arr['response']['html'] .= '</div>';
      $arr['response']['html'] .= '';
    }

    $arr['response']['html'] .= '';

  } else {
    $arr['error'] = 'Товары не найдены';
  }
} else {
  $arr['error'] = 'error2';
}

echo $core->returnJson($arr);

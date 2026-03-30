<?php

require_once('connect.php');

$arr['response'] = [];

if (isset($_GET['id'])) {

  $product = $db->getRow("SELECT * FROM tickets_nomenclature WHERE id = ?i", $_GET['id']);

  if ($product) {

    $providers = $db->getAll("SELECT * FROM tickets_providers WHERE deleted = 0");

    $arr['response']['html'] = '';

    $arr['response']['html'] .= '<input type="hidden" name="productId" value="'.$product['id'].'">';

    $arr['response']['html'] .= '<div class="form-group" >';
    $arr['response']['html'] .= '<label for="productName">Название</label>';
    $arr['response']['html'] .= '<input type="text" name="productName" class="form-control" id="productName" placeholder="Название" value="'.$product['name'].'">';
    $arr['response']['html'] .= '</div>';

    $arr['response']['html'] .= '<div class="form-group" >';
    $arr['response']['html'] .= '<label for="productDescription">Описание</label>';
    $arr['response']['html'] .= '<input type="text" name="productDescription" class="form-control" id="productDescription" placeholder="Описание" value="'.$product['description'].'">';
    $arr['response']['html'] .= '</div>';

    $arr['response']['html'] .= '<div class="form-group">';
    $arr['response']['html'] .= '<label for="productProvider">Поставщик</label>';
    $arr['response']['html'] .= '<select class="form-control" id="productProvider" name="productProvider">';
    foreach($providers as $provider) {
      if ($provider['id'] == $product['provider']) {
        $selected = 'selected';
      } else {
        $selected = '';
      }
      $arr['response']['html'] .= '<option value="'.$provider['id'].'" '.$selected.'>'.$provider['name'].'</option>';
    }
    $arr['response']['html'] .= '</select>';
    $arr['response']['html'] .= '</div>';

    $arr['response']['html'] .= '<div class="form-group" >';
    $arr['response']['html'] .= '<label for="productType">Ед. изм.</label>';
    $arr['response']['html'] .= '<input type="text" name="productType" class="form-control" id="productType" placeholder="Ед. изм." value="'.$product['type'].'">';

    $arr['response']['html'] .= '</div>';

  } else {
    $arr['error'] = 'error';
  }
} else {
  $arr['error'] = 'error';
}

echo $core->returnJson($arr);

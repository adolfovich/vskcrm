<?php

require_once('connect.php');

$arr['response'] = [];


if (isset($_GET['id'])) {

  $providers = $db->getRow("SELECT * FROM tickets_providers WHERE id = ?i", $_GET['id']);

  if ($providers) {

    $arr['response']['html'] = '';

    $arr['response']['html'] .= '<input type="hidden" name="providerId" value="'.$providers['id'].'">';

    $arr['response']['html'] .= '<div class="form-group" >';
    $arr['response']['html'] .= '<label for="providerName">Название</label>';
    $arr['response']['html'] .= '<input type="text" name="providerName" class="form-control" id="providerName" placeholder="Название" value="'.$providers['name'].'">';
    $arr['response']['html'] .= '</div>';

    $arr['response']['html'] .= '<div class="form-group" >';
    $arr['response']['html'] .= '<label for="providerDescription">Описание</label>';
    $arr['response']['html'] .= '<input type="text" name="providerDescription" class="form-control" id="providerDescription" placeholder="Описание" value="'.$providers['desctiption'].'">';
    $arr['response']['html'] .= '</div>';

    $arr['response']['html'] .= '<div class="form-group" >';
    $arr['response']['html'] .= '<label for="providerEmail">Email</label>';
    $arr['response']['html'] .= '<input type="text" name="providerEmail" class="form-control" id="providerEmail" placeholder="Email" value="'.$providers['email'].'">';
    $arr['response']['html'] .= '</div>';

    $arr['response']['html'] .= '';

  } else {
    $arr['error'] = 'error';
  }
} else {
  $arr['error'] = 'error';
}

echo $core->returnJson($arr);

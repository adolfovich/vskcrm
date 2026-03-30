<?php

require_once('connect.php');

$arr['response'] = [];


if (isset($_GET['id'])) {

  $type = $db->getRow("SELECT * FROM tickets_types WHERE id = ?i", $_GET['id']);

  if ($type) {

    $arr['response']['html'] = '';

    $arr['response']['html'] .= '<input type="hidden" name="typeId" value="'.$type['id'].'">';

    $arr['response']['html'] .= '<div class="form-group" >';
    $arr['response']['html'] .= '<label for="typeName">Название</label>';
    $arr['response']['html'] .= '<input type="text" name="typeName" class="form-control" id="typeName" placeholder="Название" value="'.$type['name'].'">';
    $arr['response']['html'] .= '</div>';




    $arr['response']['html'] .= '';

  } else {
    $arr['error'] = 'error';
  }
} else {
  $arr['error'] = 'error';
}

echo $core->returnJson($arr);

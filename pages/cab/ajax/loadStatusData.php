<?php

require_once('connect.php');

$arr['response'] = [];


if (isset($_GET['id'])) {

  $status = $db->getRow("SELECT * FROM tickets_statuses WHERE id = ?i", $_GET['id']);

  if ($status) {

    $statuses = $db->getAll("SELECT * FROM tickets_statuses WHERE id != ?i AND deleted = 0", $_GET['id']);
    $next_statuses = explode(',', $status['next_statuses']);

    //$next_status = $db->getRow("SELECT * FROM tickets_statuses WHERE id = ?i", $status['next_statuses']);

    $status_colors = [
      'badge-primary',
      'badge-secondary',
      'badge-success',
      'badge-danger',
      'badge-warning',
      'badge-info',
      'badge-light',
      'badge-dark',
    ];

    $arr['response']['html'] = '';

    $arr['response']['html'] .= '<input type="hidden" name="statusId" value="'.$status['id'].'"';

    $arr['response']['html'] .= '<div class="form-group" >';
    $arr['response']['html'] .= '<label for="statusName">Название</label>';
    $arr['response']['html'] .= '<input type="text" name="statusName" class="form-control" id="statusName" placeholder="Название" value="'.$status['name'].'">';
    $arr['response']['html'] .= '</div>';

    $arr['response']['html'] .= '<div class="form-group">';
    $arr['response']['html'] .= '<label for="statusColor">Цвет</label>';
    $arr['response']['html'] .= '<input type="color" name="statusColor" class="form-control" id="statusColor" placeholder="" value="'.$status['color'].'">';
    $arr['response']['html'] .= '</div>';

    $arr['response']['html'] .= '<div class="form-group">';
    $arr['response']['html'] .= '<label for="statusNext">След. статусы</label>';
    $arr['response']['html'] .= '</div>';

    foreach($statuses as $status) {
      if (in_array($status['id'], $next_statuses)) {
        $checked = 'checked';
      } else {
        $checked = '';
      }
      $arr['response']['html'] .= '<div class="form-group form-check">';
      $arr['response']['html'] .= '<input type="checkbox" class="form-check-input" name="statusNext[]" value="'.$status['id'].'" '.$checked.'>';
      $arr['response']['html'] .= '<label class="form-check-label" for="exampleCheck1">'.$status['name'].'</label>';
      $arr['response']['html'] .= '</div>';
    }



    $arr['response']['html'] .= '</div>';
    $arr['response']['html'] .= '';

  } else {
    $arr['error'] = 'error';
  }
} else {
  $arr['error'] = 'error';
}

echo $core->returnJson($arr);

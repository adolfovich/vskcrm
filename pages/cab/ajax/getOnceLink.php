<?php

require_once('connect.php');

$arr['response'] = '';
$arr['response'] .= '';

if (isset($_POST['type'])) {
  if ($_POST['type'] == 'video') {
    if (isset($_POST['id']) && $_POST['id'] > 0) {
      $video_data = $db->getRow("SELECT * FROM edu_videos WHERE id = ?i AND deleted = 0", $_POST['id']);
      if ($video_data) {

        $video_hash = md5('oncevideo'.$video_data['id'].time());

        $insert = [
          'id_video' => $video_data['id'],
          'hash' => $video_hash
        ];

        $db->query("INSERT INTO edu_once_links SET ?u", $insert);
        $url = $db->getOne("SELECT data FROM settings WHERE name = 'site_url'");

        $arr['response'] .= '<form class="form-inline">';
        $arr['response'] .= '<div class="form-row">';
        $arr['response'] .= '<div class="col-8">';
        $arr['response'] .= '<input type="text" class="form-control" id="inputUrl" placeholder="" value="'.$url.'video?id='.$video_hash.'" readonly>';
        $arr['response'] .= '</div>';
        $arr['response'] .= '<div class="col-4" style="text-align: right;">';
        $arr['response'] .= '<button type="button" class="btn btn-primary" onclick="copyUrl()">Копировать</button>';
        $arr['response'] .= '</div>';
        $arr['response'] .= '</div>';
        $arr['response'] .= '</form>';
        $arr['response'] .= '';

      } else {
        $arr['error'] = 'Ошибка. Видео не существует.';
      }
    } else {
      $arr['error'] = 'Ошибка. Неверные данные.';
    }
  } else if ($_POST['type'] == 'subcat') {
    $subcat_data = $db->getRow("SELECT * FROM edu_subcategories WHERE id = ?i AND deleted = 0", $_POST['id']);
    if ($subcat_data) {
      $hash = md5('oncevideo'.$subcat_data['id'].time());

      $insert = [
        'id_subcat' => $subcat_data['id'],
        'hash' => $hash
      ];

      $db->query("INSERT INTO edu_once_links SET ?u", $insert);
      $url = $db->getOne("SELECT data FROM settings WHERE name = 'site_url'");

      $arr['response'] .= '<form class="form-inline">';
      $arr['response'] .= '<div class="form-row">';
      $arr['response'] .= '<div class="col-8">';
      $arr['response'] .= '<input type="text" class="form-control" id="inputUrl" placeholder="" value="'.$url.'video?id='.$hash.'" readonly>';
      $arr['response'] .= '</div>';
      $arr['response'] .= '<div class="col-4" style="text-align: right;">';
      $arr['response'] .= '<button type="button" class="btn btn-primary" onclick="copyUrl()">Копировать</button>';
      $arr['response'] .= '</div>';
      $arr['response'] .= '</div>';
      $arr['response'] .= '</form>';
      $arr['response'] .= '';
    }

  } else if ($_POST['type'] == 'cat') {
    $cat_data = $db->getRow("SELECT * FROM edu_categories WHERE id = ?i AND deleted = 0", $_POST['id']);
    if ($cat_data) {
      $hash = md5('oncevideo'.$cat_data['id'].time());

      $insert = [
        'id_cat' => $cat_data['id'],
        'hash' => $hash
      ];

      $db->query("INSERT INTO edu_once_links SET ?u", $insert);
      $url = $db->getOne("SELECT data FROM settings WHERE name = 'site_url'");

      $arr['response'] .= '<form class="form-inline">';
      $arr['response'] .= '<div class="form-row">';
      $arr['response'] .= '<div class="col-8">';
      $arr['response'] .= '<input type="text" class="form-control" id="inputUrl" placeholder="" value="'.$url.'video?id='.$hash.'" readonly>';
      $arr['response'] .= '</div>';
      $arr['response'] .= '<div class="col-4" style="text-align: right;">';
      $arr['response'] .= '<button type="button" class="btn btn-primary" onclick="copyUrl()">Копировать</button>';
      $arr['response'] .= '</div>';
      $arr['response'] .= '</div>';
      $arr['response'] .= '</form>';
      $arr['response'] .= '';
    }

  }

} else {
  $arr['error'] = 'Ошибка. Неверные данные.';
}



echo $core->returnJson($arr);

<?php

require_once('connect.php');

$arr['response'] = '';

if (isset($_POST['type']) && isset($_POST['id'])) {
  if ($_POST['type'] == 'editCat') {

    $cat_data = $db->getRow("SELECT * FROM edu_categories WHERE id = ?i", $_POST['id']);
    $profiles = $db->getAll("SELECT * FROM profiles WHERE is_del = 0");

    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<input type="hidden" name="catId" value="'.$cat_data['id'].'">';
    $arr['response'] .= '<label for="catName">Название</label>';
    $arr['response'] .= '<input type="text" name="catName" class="form-control" id="catName" placeholder="Название" value="'.$cat_data['name'].'">';
    $arr['response'] .= '</div>';

    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<label for="catColor">Цвет</label>';
    $arr['response'] .= '<input type="color" name="catColor" class="form-control" id="catColor" placeholder="" value="'.$cat_data['color'].'">';
    $arr['response'] .= '</div>';

    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<label for="catOrdering">Сортировка</label>';
    $arr['response'] .= '<input type="text" name="catOrdering" class="form-control" id="catOrdering" placeholder="" value="'.$cat_data['ordering'].'">';
    $arr['response'] .= '</div>';

    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<label for="catIcon">Иконка</label>';
    $arr['response'] .= '<img style="width:30px; margin-left: 10px;" src="'.$cat_data['icon'].'">';
    $arr['response'] .= '<input style="margin-top: 10px;" type="file" name="catIcon" class="form-control" id="catIcon aria-describedby="iconlHelp" ">';
    $arr['response'] .= '<small id="iconlHelp" class="form-text text-muted">Для изменения иконки загрузите новое изображение</small>';

    $arr['response'] .= '</div>';

    $arr['response'] .= '';
    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<label for="profiles">Профили</label>';
    foreach ($profiles as $profile) {
      $arr['response'] .= '<div class="form-check">';

      if (in_array($profile['id'], explode(",", $cat_data['access']))) {
        $checked = 'checked';
      } else if ($profile['id'] == 1) {
        $checked = 'checked';
      } else {
        $checked = '';
      }
      $arr['response'] .= '<input name="profiles[]" class="form-check-input" type="checkbox" '.$checked.' value="'.$profile['id'].'" id="profiles'.$profile['id'].'">';
      $arr['response'] .= '<label class="form-check-label" for="profiles'.$profile['id'].'">';
      $arr['response'] .= $profile['name'];
      $arr['response'] .= '</label>';
      $arr['response'] .= '</div>';
    }

    $arr['response'] .= '</div>';

  } else if ($_POST['type'] == 'deleteCat') {
    $cat_data = $db->getRow("SELECT * FROM edu_categories WHERE id = ?i", $_POST['id']);

    $arr['response'] .= '<input type="hidden" name="catId" value="'.$cat_data['id'].'">';
    $arr['response'] .= '<div class="row">';
    $arr['response'] .= '<div class="col text-center">Подтвердите удаление категории "'.$cat_data['name'].'"</div>';
    $arr['response'] .= '</div>';
    $arr['response'] .= '';
  } else if ($_POST['type'] == 'editSubcat') {
    $subcat_data = $db->getRow("SELECT * FROM edu_subcategories WHERE id = ?i", $_POST['id']);
    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<input type="hidden" name="subCatId" value="'.$subcat_data['id'].'">';
    $arr['response'] .= '<label for="subCatName">Название</label>';
    $arr['response'] .= '<input type="text" name="subCatName" class="form-control" id="subCatName" placeholder="Название" value="'.$subcat_data['name'].'">';
    $arr['response'] .= '</div>';

    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<label for="subCatColor">Цвет</label>';
    $arr['response'] .= '<input type="color" name="subCatColor" class="form-control" id="subCatColor" placeholder="" value="'.$subcat_data['color'].'">';
    $arr['response'] .= '</div>';

    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<label for="subCatOrdering">Сортировка</label>';
    $arr['response'] .= '<input type="text" name="subCatOrdering" class="form-control" id="subCatOrdering" placeholder="" value="'.$subcat_data['ordering'].'">';
    $arr['response'] .= '</div>';
    $arr['response'] .= '';
  } else if ($_POST['type'] == 'deleteSubcat') {
    $subcat_data = $db->getRow("SELECT * FROM edu_subcategories WHERE id = ?i", $_POST['id']);

    $arr['response'] .= '<input type="hidden" name="subCatId" value="'.$subcat_data['id'].'">';
    $arr['response'] .= '<div class="row">';
    $arr['response'] .= '<div class="col text-center">Подтвердите удаление подкатегории "'.$subcat_data['name'].'"</div>';
    $arr['response'] .= '</div>';
    $arr['response'] .= '';
  } else if ($_POST['type'] == 'editVideo') {
    $video_data = $db->getRow("SELECT * FROM edu_videos WHERE id = ?i", $_POST['id']);

    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<input type="hidden" name="videotId" value="'.$video_data['id'].'">';
    $arr['response'] .= '<label for="videoName">Название</label>';
    $arr['response'] .= '<input type="text" name="videoName" class="form-control" id="videoName" placeholder="Название" value="'.$video_data['name'].'">';
    $arr['response'] .= '</div>';

    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<label for="videoOrdering">Сортировка</label>';
    $arr['response'] .= '<input type="text" name="videoOrdering" class="form-control" id="videoOrdering" placeholder="" value="'.$video_data['ordering'].'">';
    $arr['response'] .= '</div>';

    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<label for="videoFile">Файл видеоролика</label>';
    $arr['response'] .= '<input type="file" name="videoFile" class="form-control" id="videoFile" aria-describedby="fileHelp" >';
    $arr['response'] .= '<small id="fileHelp" class="form-text text-muted"><b>Если оставить поле пустым, видео не изменится.</b> Файл должен быть в формате MP4.</small>';
    $arr['response'] .= '</div>';


    $dopFiles = $db->getAll("SELECT * FROM edu_videos_files WHERE video_id = ?i AND deleted = 0", $video_data['id']);

    $arr['response'] .= '<ul class="list-group">';
    $arr['response'] .= '<li class="list-group-item" style="background-color: #eee;">Дополнительные файлы</li>';

    if ($dopFiles) {
      foreach ($dopFiles as $dopFile) {
        $dopFileName = explode("/", $dopFile['path']);
        $dopFileName = $dopFileName[3];
        $dopFileExtention = explode(".", $dopFileName);
        $dopFileExtention = end($dopFileExtention);
        $arr['response'] .= '<li class="list-group-item" id="modalEditDopFile'.$dopFile['id'].'" style="padding: 0.5rem; padding-left: 1rem; padding-right: 1rem;">';
        $arr['response'] .= '<div class="row">';
        $arr['response'] .= '<div class="col-2">';
        $arr['response'] .= '<span style="font-size: 1.5em;">'.$core->getFileIco($dopFileExtention).'</span>';
        $arr['response'] .= '</div>';
        $arr['response'] .= '<div class="col-8">';
        $arr['response'] .= '<div>';
        $arr['response'] .= $dopFileName;
        $arr['response'] .= '</div>';
        $arr['response'] .= '</div>';
        $arr['response'] .= '<div class="col-2">';
        $arr['response'] .= '<a class="btn text-danger" onClick="deleteDopFile('.$dopFile['id'].')"><i class="far fa-trash-alt"></i></a>';
        $arr['response'] .= '</div>';
        $arr['response'] .= '</div>';
        $arr['response'] .= '</li>';

      }
    }

    $arr['response'] .= '<li class="list-group-item" id="dopFiles">';
    $arr['response'] .= '<div class="form-group">';
    $arr['response'] .= '<input type="file" name="dopFile1" class="form-control" id="dopFile1" aria-describedby="dopFileHelp1" >';
    $arr['response'] .= '<small id="dopFileHelp1" class="form-text text-muted">Файл должен быть в формате MP3, Word, Excel, PDF</small>';
    $arr['response'] .= '</div>';
    $arr['response'] .= '</li>';
    $arr['response'] .= '<li class="list-group-item">';
    $arr['response'] .= '<a href="#" class="btn btn-outline-primary btn-sm" onClick="addFileField(); return false;">Добавить еще один файл</a>';
    $arr['response'] .= '</li>';
    $arr['response'] .= '</ul>';
    $arr['response'] .= '';

    $arr['response'] .= '';
    $arr['response'] .= '';

    $arr['response'] .= '';
  } else if ($_POST['type'] == 'deleteVideo') {
    $video_data = $db->getRow("SELECT * FROM edu_videos WHERE id = ?i", $_POST['id']);

    $arr['response'] .= '<input type="hidden" name="videotId" value="'.$video_data['id'].'">';
    $arr['response'] .= '<div class="row">';
    $arr['response'] .= '<div class="col text-center">Подтвердите удаление видео "'.$video_data['name'].'"</div>';
    $arr['response'] .= '</div>';
    $arr['response'] .= '';
  }
} else {
  $arr['error'] = 'Ошибка. Неверные данные.';
}

echo $core->returnJson($arr);

<?php
//echo 111;

$accepted_img_types = [
  'image/jpeg',
  'image/png',
  'image/gif'
];

if (isset($_POST['action_type']) && $_POST['action_type'] == 'delete_video') {
  $db->query("UPDATE edu_videos SET deleted = 1 WHERE id = ?i", $_POST['videotId']);
  $msg['type'] = 'success';
  $msg['text'] = 'Видеоролик удален';
}

if (isset($_POST['action_type']) && $_POST['action_type'] == 'edit_subcat') {
  $check_ordering = $db->getRow("SELECT * FROM edu_subcategories WHERE ordering = ?i", $_POST['subCatOrdering']);
  $all_edit_subcats = $db->getAll("SELECT * FROM edu_subcategories WHERE ordering >= ?i AND id != ?i", $_POST['subCatOrdering'], $_POST['subCatId']);
    $db->query("UPDATE edu_subcategories SET name = ?s, ordering = ?i, color = ?s WHERE id = ?i", $_POST['subCatName'], $_POST['subCatOrdering'], $_POST['subCatColor'], $_POST['subCatId']); //

    if ($check_ordering && $check_ordering['id'] != $_POST['subCatId']) {
      foreach ($all_edit_subcats as $edit_subcat) {
        $db->query("UPDATE edu_subcategories SET ordering = ordering + 1 WHERE id = ?i", $edit_subcat['id']);
      }
    }
    $msg['type'] = 'success';
    $msg['text'] = 'Подкатегория сохранена';
}

if (isset($_POST['action_type']) && $_POST['action_type'] == 'delete_subcat') {
  $db->query("UPDATE edu_subcategories SET deleted = 1 WHERE id = ?i", $_POST['subCatId']);
  $msg['type'] = 'success';
  $msg['text'] = 'Подкатегория удалена';
}

if (isset($_POST['action_type']) && $_POST['action_type'] == 'delete_cat') {
  $db->query("UPDATE edu_categories SET deleted = 1 WHERE id = ?i", $_POST['catId']);
  $msg['type'] = 'success';
  $msg['text'] = 'Категория удалена';
}

if (isset($_POST['action_type']) && $_POST['action_type'] == 'edit_cat') {

  $check_ordering = $db->getRow("SELECT * FROM edu_categories WHERE ordering = ?i", $_POST['catOrdering']);
  $all_edit_cats = $db->getAll("SELECT * FROM edu_categories WHERE ordering >= ?i AND id != ?i", $_POST['catOrdering'], $_POST['catId']);

  $profiles = implode(",", $_POST['profiles']);
  $db->query("UPDATE edu_categories SET name = ?s, access = ?s, ordering = ?i, color = ?s WHERE id = ?i", $_POST['catName'], $profiles, $_POST['catOrdering'], $_POST['catColor'], $_POST['catId']);

  if (isset($_FILES['catIcon']) && $_FILES['catIcon']['error'] == 0) {
    if (!in_array($_FILES['catIcon']['type'], $accepted_img_types)) {
      $msg['window'] = 'addCat';
      $msg['type'] = 'error';
      $msg['text'] = 'Неверный формат изображения';
    } else {
      $full_path = dirname(__FILE__);
      $full_path = str_replace('pages/cab', 'caticons/', $full_path);

      $fileTmpPath = $_FILES['catIcon']['tmp_name'];
      $name = $_FILES['catIcon']['name'];
      $dest_path = $full_path . $name;

      $dbpath = '/caticons/'.$name;

      if(move_uploaded_file($fileTmpPath, $dest_path)) {
        $db->query("UPDATE edu_categories SET icon = ?s WHERE id = ?i", $dbpath, $_POST['catId']);
      }
    }
  }

  if ($check_ordering && $check_ordering['id'] != $_POST['catId']) {
    foreach ($all_edit_cats as $edit_cat) {
      $db->query("UPDATE edu_categories SET ordering = ordering + 1 WHERE id = ?i", $edit_cat['id']);
    }
  }
      unset($_POST);
      $msg['type'] = 'success';
      $msg['text'] = 'Категория сохранена';
}

if (isset($_POST['action_type']) && $_POST['action_type'] == 'add_cat') {
  //var_dump(1111);
  if ($_POST['catName'] != '') {
    //var_dump(222);
    if (isset($_POST['profiles']) && count($_POST['profiles']) > 0) {
      //var_dump(333);
      $dbpath = '';
      if (isset($_FILES['catIco']) && $_FILES['catIco']['error'] == 0) { //&& $_FILES['videoFile']['error'] == 0
        if (!in_array($_FILES['catIco']['type'], $accepted_img_types)) {
          $msg['window'] = 'addCat';
          $msg['type'] = 'error';
          $msg['text'] = 'Неверный формат изображения';
        } else {

          $full_path = dirname(__FILE__);
          $full_path = str_replace('pages/cab', 'caticons/', $full_path);

          $fileTmpPath = $_FILES['catIco']['tmp_name'];
          $name = $_FILES['catIco']['name'];
          $dest_path = $full_path . $name;

          $dbpath = '/caticons/'.$name;

          if(move_uploaded_file($fileTmpPath, $dest_path)) {


          } else {
            $msg['window'] = 'addCat';
            $msg['type'] = 'error';
            $msg['text'] = 'Ошибка копирования';
          }

        }
      }

      if ($_POST['catOrdering'] == '') $_POST['catOrdering'] = 100;

      $profiles = implode(",", $_POST['profiles']);
      $db->query("INSERT INTO edu_categories SET name = ?s, access = ?s, color = ?s, ordering = ?i, icon = ?s", $_POST['catName'], $profiles, $_POST['catColor'], $_POST['catOrdering'], $dbpath);
      $new_cat_id = $db->insertId();

      $check_ordering = $db->getRow("SELECT * FROM edu_categories WHERE ordering = ?i", $_POST['catOrdering']);
      $all_edit_cats = $db->getAll("SELECT * FROM edu_categories WHERE ordering >= ?i AND id != ?i", $_POST['catOrdering'], $new_cat_id);

      if ($check_ordering) {
        foreach ($all_edit_cats as $edit_cat) {
          $db->query("UPDATE edu_categories SET ordering = ordering + 1 WHERE id = ?i", $edit_cat['id']);
        }
      }

      unset($_POST);
      $msg['type'] = 'success';
      $msg['text'] = 'Категория успешно добавлена';

    } else {
      $msg['window'] = 'addCat';
      $msg['type'] = 'error';
      $msg['text'] = 'Укажите один или несколько профилей';
    }
  } else {
    $msg['window'] = 'addCat';
    $msg['type'] = 'error';
    $msg['text'] = 'Название не может быть пустым';
  }
}

if (isset($_POST['action_type']) && $_POST['action_type'] == 'add_subcat') {
  if ($_POST['subCatName'] != '') {
    if ($_POST['subCatOrdering'] == '') $_POST['subCatOrdering'] = 100;
    $db->query("INSERT INTO edu_subcategories SET name = ?s, cat = ?i, color = ?s, ordering = ?i", $_POST['subCatName'], $_POST['cat'], $_POST['subCatColor'], $_POST['subCatOrdering']);
    $new_subcat_id = $db->insertId();

    $check_ordering = $db->getRow("SELECT * FROM edu_subcategories WHERE ordering = ?i", $_POST['subCatOrdering']);
    $all_edit_subcats = $db->getAll("SELECT * FROM edu_subcategories WHERE ordering >= ?i AND id != ?i", $_POST['subCatOrdering'], $new_subcat_id);

    if ($check_ordering) {
      foreach ($all_edit_subcats as $edit_subcat) {
        $db->query("UPDATE edu_subcategories SET ordering = ordering + 1 WHERE id = ?i", $edit_subcat['id']);
      }
    }
    unset($_POST);
    $msg['type'] = 'success';
    $msg['text'] = 'Категория успешно добавлена';
  } else {
    $msg['window'] = 'addCat';
    $msg['type'] = 'error';
    $msg['text'] = 'Название не может быть пустым';
  }
}

$full_path = dirname(__FILE__);
$full_path = str_replace('pages/cab', 'videos/', $full_path);

$allowFileTypes = [
  'audio/mp3',
  'audio/mpeg',
  'application/msword',
  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
  'application/vnd.ms-office',
  'application/pdf',
  'image/jpeg',
  'image/png',
  'image/gif'
];

if (isset($_POST['action_type']) && $_POST['action_type'] == 'edit_video') {
  $check_ordering = $db->getRow("SELECT * FROM edu_videos WHERE ordering = ?i", $_POST['videoOrdering']);
  $all_edit_videos = $db->getAll("SELECT * FROM edu_videos WHERE ordering >= ?i AND id != ?i", $_POST['videoOrdering'], $_POST['videotId']);
    $db->query("UPDATE edu_videos SET name = ?s, ordering = ?i WHERE id = ?i", $_POST['videoName'], $_POST['videoOrdering'], $_POST['videotId']);

    if ($check_ordering && $check_ordering['id'] != $_POST['videotId']) {
      foreach ($all_edit_videos as $edit_video) {
        $db->query("UPDATE edu_videos SET ordering = ordering + 1 WHERE id = ?i", $_POST['videotId']);
      }
    }

    if (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] == 0) {
      if ($_FILES['videoFile']['error'] == 0 && $_FILES['videoFile']['type'] == 'video/mp4') {
        $fileTmpPath = $_FILES['videoFile']['tmp_name'];
        $name = $_FILES['videoFile']['name'];
        $dest_path = $full_path . $name;
        $dbpath = '/videos/'.$name;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
          $db->query("UPDATE edu_videos SET path = ?s WHERE id = ?i", $dbpath, $_POST['videotId']);
        }
      } else {
        $msg['window'] = 'edit';
        $msg['video_id'] = $_POST['videotId'];
        $msg['type'] = 'error';
        $msg['text'] = 'Недопустимый формат видео файла';
      }
    }

    unset($_FILES['videoFile']);

    if (count($_FILES)) {
      foreach ($_FILES as $file) {
        if ($file['error'] == 0) {
          if (in_array(mime_content_type($file['tmp_name']), $allowFileTypes)) {
            $fileTmpPath = $file['tmp_name'];
            $name = $file['name'];
            $dest_path = $full_path . '/dopfiles/' . $name;
            $dbpath = '/videos/dopfiles/'.$name;

            move_uploaded_file($fileTmpPath, $dest_path);

            $insert = [
              'video_id' => $_POST['videotId'],
              'path' => $dbpath
            ];
            $db->query("INSERT INTO edu_videos_files SET ?u", $insert);
          } else {
            $msg['window'] = 'edit';
            $msg['video_id'] = $_POST['videotId'];
            $msg['type'] = 'error';
            $msg['text'] = 'Недопустимый формат дополнительного файла';
            break;
          }
        }
      }
    }

    if (isset($_POST['deleteDopFile'])) {
      foreach ($_POST['deleteDopFile'] as $deleteDopFile) {
        $db->query("UPDATE edu_videos_files SET deleted = 1 WHERE id = ?i", $deleteDopFile);
      }
    }

    if (!isset($msg['type']) || $msg['type'] != 'error') {
      $msg['type'] = 'success';
      $msg['text'] = 'Видеоролик сохранен';
    }
}

if (isset($_POST['action_type']) && $_POST['action_type'] == 'add_video') {
  if ($_POST['videoName'] != '') {

    if (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] == 0) {

      if ($_FILES['videoFile']['type'] != 'video/mp4') {
        $msg['window'] = 'addCat';
        $msg['type'] = 'error';
        $msg['text'] = 'Не выбран файл или неверный формат файла';

        //break;
      } else {
        $fileTmpPath = $_FILES['videoFile']['tmp_name'];
        $name = $_FILES['videoFile']['name'];
        $dest_path = $full_path . $name;
        $dbpath = '/videos/'.$name;

        move_uploaded_file($fileTmpPath, $dest_path);


      }

    } else {
      $dbpath = '';
    }

    $db->query("INSERT INTO edu_videos SET name = ?s, path = ?s, subcat = ?i", $_POST['videoName'], $dbpath, $_POST['subcat']);
    $new_video_id = $db->insertId();

    unset($_FILES['videoFile']);

    foreach ($_FILES as $dopFile) {

      if (in_array(mime_content_type($dopFile['tmp_name']), $allowFileTypes)) {

        $fileTmpPath = $dopFile['tmp_name'];
        $name = $dopFile['name'];
        $dest_path = $full_path . '/dopfiles/' . $name;
        $dbpath = '/videos/dopfiles/'.$name;

        move_uploaded_file($fileTmpPath, $dest_path);

        $insert = [
          'video_id' => $new_video_id,
          'path' => $dbpath
        ];

        $db->query("INSERT INTO edu_videos_files SET ?u", $insert);
      } else {
        $msg['window'] = 'addCat';
        $msg['type'] = 'error';
        $msg['text'] = 'Недопустимый формат дополнительного файла';
        break;
      }
    }

    $msg['type'] = 'success';
    $msg['text'] = 'Видео успешно добавлено';
    unset($_POST);

  } else {
    $msg['window'] = 'addCat';
    $msg['type'] = 'error';
    $msg['text'] = 'Название не может быть пустым';
  }
}

if (isset($_GET['cat']) &&  $_GET['cat'] > 0) {
  $cat_data = $db->getRow("SELECT * FROM edu_categories WHERE id = ?i", $_GET['cat']);
  $access_groups = explode(',', $cat_data['access']);

  if ($cat_data) {
    if (in_array($auth_user['profile'], $access_groups)) {
      if (isset($_GET['subcat'])) {
        $subcat_data = $db->getRow("SELECT * FROM edu_subcategories WHERE id = ?i", $_GET['subcat']);

        if (isset($_GET['video'])) {
          $video_data = $db->getRow("SELECT * FROM edu_videos WHERE id = ?i", $_GET['video']);
          if ($video_data) {
            $dopFiles = $db->getAll("SELECT * FROM edu_videos_files WHERE video_id = ?i AND deleted = 0", $video_data['id']);
            include ('tpl/cab/education_viseo.tpl');
          } else {
            include ('tpl/cab/404.tpl');
          }
        } else {
          if ($subcat_data) {
            $videos = $db->getAll("SELECT * FROM edu_videos WHERE subcat = ?i AND deleted = 0 ORDER BY ordering", $_GET['subcat']);
            include ('tpl/cab/education_viseos.tpl');
          } else {
            include ('tpl/cab/404.tpl');
          }
        }
      } else {
        $subcats = $db->getAll("SELECT * FROM edu_subcategories WHERE cat = ?i AND deleted = 0 ORDER BY ordering", $cat_data['id']);
        include ('tpl/cab/education_cat.tpl');
      }
    } else {
      include ('tpl/cab/403.tpl');
    }

  } else {
    include ('tpl/cab/404.tpl');
  }

} else {
  $cats = $db->getAll("SELECT * FROM edu_categories WHERE deleted = 0 ORDER BY ordering");
  //echo '222';
  //var_dump($cats);
  $profiles = $db->getAll("SELECT * FROM profiles WHERE is_del = 0");
  $icons = $db->getAll("SELECT * FROM icons");
  include ('tpl/cab/education.tpl');
}

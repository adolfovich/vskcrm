<?php

require_once('connect.php');

//var_dump($form);

$user_create = $_SESSION['id'];

$type = $form['type'];
$salon_id = $form['salon'];

//var_dump($type);

unset($form['type']);
unset($form['salon']);

$arr = [];
$form_arr = [];

$save = FALSE;

foreach ($form as $key => $value) {
  $key = explode('_', $key);
  $field = $db->getRow("SELECT * FROM `tickets_fields` WHERE `id` = ?i", $key[1]);

  if ($field['required'] == 1 && !$value) {
    $arr['error'] = 'Не заполнено одно или несколько обязательных полей';
    echo $core->returnJson($arr);
    die();
  } else {
    //if ($value) {
      $form_arr[$field['id']] = $value;
      $save = TRUE;
    //}

  }
}

//var_dump($form_arr);

if ($save) {
  $json = json_encode($form_arr);

  $insert = [
    "type" => $type,
    "salon_id" => $salon_id,
    "user_create" => $user_create,
    "data" => $json
  ];

  $db->query("INSERT INTO `tickets` SET ?u", $insert);
  $insert_id = $db->insertId();

  $core->ticketLog($insert_id, $user_create, 'Создание задачи');



  $arr['response'] = 'Заявка добавлена. Номер задачи #'.$insert_id;
  echo $core->returnJson($arr);
  die();
} else {
  $arr['error'] = 'Не заполнено ни одно поле';
  echo $core->returnJson($arr);
  die();
}


//var_dump($json);

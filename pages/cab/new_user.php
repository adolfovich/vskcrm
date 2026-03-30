<?php

if (isset($_GET['a']) && $_GET['a'] == 'save') {
  //echo 'save';
  $login = $form['userLogin'];
  $pass = $form['userPass'];
  $repass = $form['userRePass'];
  $name = $form['userName'];
  //$profile = $form['userProfile'];
  //$salons = $form['userSalons'];

  //var_dump($form['userSalons']);

  if ($login && strlen($login) >= 3) {
    if (strlen($name) >= 5) {
      if (strlen($pass) >= 8) {
        if ($pass == $repass) {
          if (isset($form['userProfile'])) {


            $insert = [
              'login' => $login,
              'pass' => $core->as_md5($pass, $pass_key),
              'name' => $name
            ];

            if (isset($form['userProfile'])) {
              $insert['profile'] = $form['userProfile'];
            }

            if (isset($form['userSalons'])) {
              $userSalons = '';
              $end_element = array_pop($form['userSalons']);
              foreach ($form['userSalons'] as $value) {
                 $userSalons .= $value . ',';
              }
              $userSalons .= $end_element;
              $insert['salons'] = $userSalons;
            }

            $q = $db->parse("INSERT INTO users SET ?u", $insert);

            if ($db->query($q)) {
              $msg = ["type"=>"success", "text"=>"Пользователь создан успешно"];
              unset($form);
            }

            //var_dump($q);
          } else {
            $msg = ["type"=>"danger", "text"=>"Ошибка! Не указан профиль пользователя"];
          }
        } else {
          $msg = ["type"=>"danger", "text"=>"Ошибка! Введенные пароли не совпадают"];
        }
      } else {
        $msg = ["type"=>"danger", "text"=>"Ошибка! Длинна пароля должна быть не менее 8 символов"];
      }
    } else {
      $msg = ["type"=>"danger", "text"=>"Ошибка! Длинна ФИО должна быть не менее 5 символов"];
    }
  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! Длинна логина должна быть не менее 3-х символов"];
  }
}

$profiles = $db->getAll("SELECT * FROM `profiles`");
$salons = $db->getAll("SELECT * FROM `salons`");


include ('tpl/cab/new_user.tpl');

<?php

//var_dump($form);

if (isset($_GET) && count($_GET)) {
  if (isset($_GET['page'])) {
    $get_page_name = $_GET['page'];
    unset($_GET['page']);
    $get_page_params = '';
    $i = 0;
    foreach ($_GET as $key => $value) {
      if ($i == 0) {
        $get_page_params .= '?';
      } else {
        $get_page_params .= '&';
      }
      $get_page_params .= $key.'='.$value;
      $i++;
    }
  }
} else {
  $get_page_name = '';
  $get_page_params = '';
}

if ($core->login()) {
  $core->redir('cab/'.$get_page_name.$get_page_params);
}

if (isset($form['inputLogin']) && $form['inputLogin'] == '') {
  $error = 'Не указан логин';
} elseif (isset($form['inputPassword']) && $form['inputPassword'] == '') {
  $error = 'Не указан пароль';
} elseif (isset($form['inputLogin']) && isset($form['inputPassword'])) {
  if ($user_info = $db->getRow('SELECT * FROM users WHERE login = ?s', $form['inputLogin'])) {

      //var_dump($core->as_md5($form['inputPassword'], $pass_key));

    if ($core->as_md5($form['inputPassword'], $pass_key) == $user_info['pass']) {
      //echo 'OKK';

      $_SESSION['id'] = $user_info['id'];
      $_SESSION['login'] = $user_info['login'];
      setcookie ("sid", session_id(), time() + 50000);
      $session_time = $core->cfgRead('session_time');

      if (setcookie("login", $user_info['login'], time() + $session_time)) {
        //echo 'OKK';
        //var_dump($_SESSION);
        $core->redir('cab/'.$get_page_name.$get_page_params);
      } else {
        echo 'ошибка установки cookie';
      }


    } else {
      $error = 'Неверный пароль';
    }
  } else {
    $error = 'Пользователь не найден';
  }
}

include ('tpl/cab/login.tpl');

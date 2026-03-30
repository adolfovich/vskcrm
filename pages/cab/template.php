<?php

if (!$core->login()) {
  if (isset($url[1]) && $url[1] != '') {
    $get_staring = '?page='.$url[1];
    if (isset($_GET) && count($_GET)) {
      foreach ($_GET as $key => $value) {
        $get_staring .= '&'.$key.'='.$value;
      }
    }
  } else {
    $get_staring = '';
  }
  $core->redir('/login'.$get_staring);
} else {

  if (!isset($url[1]) || $url[1] == '') {
    $page = 'pages/cab/default.php';
  } elseif (file_exists('pages/cab/'.$url[1].'.php')) {
    $page = 'pages/cab/'.$url[1].'.php';
  } else {
    $page = 'pages/cab/404.php';
  }	

  include ('tpl/cab/header.tpl');
  include ('tpl/cab/template.tpl');
  include ('tpl/cab/footer.tpl');

}

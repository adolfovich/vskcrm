<?php

if (isset($_GET['a']) && $_GET['a'] == 'save') {
  if (strlen($form['salonName']) >= 5) {
    $insert = [
      "name" => $form['salonName']
    ];

    $q = $db->parse("INSERT INTO salons SET ?u", $insert);

    if ($db->query($q)) {
      $msg = ["type"=>"success", "text"=>"Салон создан успешно"];
      unset($form);
    }

  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! Название должно быть не менее 5 символов"];
  }
}



include ('tpl/cab/new_salon.tpl');

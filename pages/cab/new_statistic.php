<?php

function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya', ' ' => '-'
    );
    return strtr($string, $converter);
}

if (isset($get['a']) && $get['a'] == 'save') {
  if (strlen($form['statName']) >= 5) {

    $string_id = rus2translit($form['statName']);

    var_dump($string_id);

    $update = [
      "name" => $form['statName'],
      "el_name" => $form['statElName'],
      "string_id" => $string_id
    ];

    $q = $db->parse("INSERT INTO `statistics` SET ?u", $update);

    if ($db->query($q)) {
      $msg = ["type"=>"success", "text"=>"Данные сохранены"];
    }
  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! Название статистики должно содержать не менее 5 символов"];
  }
}

if (isset($get['id'])) {
  if ($stat_data = $db->getRow("SELECT * FROM `statistics` WHERE `id` = ?i", $get['id'])) {

  } else {
    $msg = ["type"=>"danger", "text"=>"Ошибка! Статистика не найдена"];
  }
}

include ('tpl/cab/new_statistic.tpl');

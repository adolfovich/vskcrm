<?php

require_once('connect.php');

$records = $db->getAll("
    SELECT * 
    FROM knowledgebase 
    WHERE 
        -- Поиск полной строки в subject или text
        (subject LIKE CONCAT('%', ?s, '%') 
         OR text LIKE CONCAT('%', ?s, '%'))
        -- ИЛИ поиск отдельных слов в keywords
        OR keywords REGEXP CONCAT('(', REPLACE(TRIM(?s), ' ', '|'), ')');",
    $_POST['text'], $_POST['text'], $_POST['text']) ;

$arr = [];
$html = '';

if ($records) {
    foreach ($records as $record) {

        $html .= '<div class="card" >';
        $html .= '<div class="card-body">';
        //$html .= '<div class="alert alert-warning ticket-status" style="background: '.$ticket['status_color'].'">'.$ticket['status_name'].'</div>';
        $html .= '<h3 class="card-title row">';
        $html .= '<div class="col-sm text-left">';
        $html .= $record['subject'] . '<span class="keywords" style=""> ('.$core->hashtags($record['keywords']).')</span>';
        $html .= '</div>';
        $html .= '</h3>';
        $html .= '<p class="card-text collapse-text" id="spoilerText'.$record['id'].'">'.$record['text'].'</p>';

        $html .= '<button class="btn btn-outline-primary mt-2 toggle-spoiler"
                                                data-target="#spoilerText'.$record['id'].'"
                                                aria-expanded="false"
                                                style="width: 100%;">
                                            Развернуть
                                        </button>';

        $html .= '</div>';
        $html .= '</div>';

    }
} else {
    $html .= '<h3 class="card-title row">';
    $html .= '<div class="col-sm text-left">';
    $html .= 'Ничего не найдено';
    $html .= '</div>';
    $html .= '</h3>';
}

//echo $html;

$arr['response'] = $html;

echo $core->returnJson($arr);

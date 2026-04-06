<?php



$searchString = $_GET["searchString"];

$content = [];

if ($searchString != "") {

    $records = $db->getAll("
    SELECT * 
    FROM knowledgebase 
    WHERE 
        -- Поиск полной строки в subject или text
        (subject LIKE CONCAT('%', ?s, '%') 
         OR text LIKE CONCAT('%', ?s, '%'))
        -- ИЛИ поиск отдельных слов в keywords
        OR keywords REGEXP CONCAT('(', REPLACE(TRIM(?s), ' ', '|'), ')');",
        $searchString, $searchString, $searchString) ;

    if (count($records) > 0) {
        $content['status'] = 'ok';
        foreach ($records as $record) {

            $content['content'][] = $record;
        }
    } else {
        $content['status'] = 'error';
        $content['error'] = 'Ничего не найдено(';
    }

    //echo $content;
} else {
    $content['status'] = 'error';
    $content['error'] =  'не задана строка поиска';
}

echo json_encode($content);
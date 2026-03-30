<?php

if (isset($_GET['action']) && isset($_POST['subject'])) {
    if ($_POST['subject'] != '' && $_POST['keywords'] != '' && $_POST['text'] != '') {
        $insert['subject'] = $_POST['subject'];
        $insert['keywords'] = $_POST['keywords'];
        $insert['text'] = $_POST['text'];
        $insert['author'] = $user_id;

        //var_dump($insert);

        $db->query("INSERT INTO knowledgebase SET ?u", $insert);

        $core->jsredir('kbrecord?id='.$db->insertId());
    }
} else if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'new':
            $subject = '';
            $keywords = '';
            $text = '';
            break;
        case 'del':
            $db->query("UPDATE knowledgebase SET is_del = 1 WHERE id = ?i", $_GET['id']);
            $core->jsredir('knowledgebase');
            break;
    }

    include ('tpl/cab/kbrecord.tpl');
} else if (isset($_GET['id']) && $_GET['id'] > 0) {

    if (isset($_POST['subject']) && $_POST['subject'] != '' && $_POST['keywords'] != '' && $_POST['text'] != '') {
        $update['subject'] = $_POST['subject'];
        $update['keywords'] = $_POST['keywords'];
        $update['text'] = $_POST['text'];
        $update['dateupdate'] = date("Y-m-d H:i:s");


        $db->query("UPDATE knowledgebase SET ?u WHERE id = ?i", $update, $_GET['id']);
    }

    $record = $db->getRow("SELECT * FROM knowledgebase WHERE  id = ?i", $_GET['id']);
    //var_dump($record);
    $subject = $record['subject'];
    $keywords = $record['keywords'];
    $text = $record['text'];

    include ('tpl/cab/kbrecord.tpl');
} else {
    include ('tpl/cab/404.tpl');
}




<?php

require_once('connect.php');

$tickets = $db->getAll("
    SELECT t.*,
    (SELECT name FROM objects WHERE id = t.object_id) as object_name,
    (SELECT name FROM tickets_statuses WHERE id = t.status) as status_name,
    (SELECT color FROM tickets_statuses WHERE id = t.status) as status_color
    FROM tickets t 
	LEFT JOIN objects o ON t.object_id=o.id
    WHERE t.is_del = 0 AND t.object_id IN (SELECT id FROM objects WHERE crew = ?i) AND (
        t.rzhd_id LIKE ?s OR o.name LIKE ?s
    ) 
    ORDER BY t.id DESC", $_POST['crew'], '%'.$_POST['text'].'%', '%'.$_POST['text'].'%') ;

$arr = [];
$html = '';

if ($tickets) {
    foreach ($tickets as $ticket) {
        $html .= '<a href="'.$ticket['id'].'">';
        $html .= '<div class="card" >';
        $html .= '<div class="card-body">';
        $html .= '<div class="alert alert-warning ticket-status" style="background: '.$ticket['status_color'].'">'.$ticket['status_name'].'</div>';
        $html .= '<h3 class="card-title row">';
        $html .= '<div class="col-sm text-left">';
        $html .= 'Заявка №'.$ticket['rzhd_id'].' от '.date("d.m.y", strtotime($ticket['create_date']));
        $html .= '</div>';
        $html .= '<div class="col-sm text-right">'.$ticket['object_name'].'</div>';
        $html .= '</h3>';
        $html .= '<p class="card-text">'.$ticket['text'].'</p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</a>';
    }
} else {
    $html .= '<h3 class="card-title row">';
    $html .= '<div class="col-sm text-left">';
    $html .= 'Ничего не найдено';
    $html .= '</div>';
    $html .= '</h3>';
}

$arr['response'] = $html;

echo $core->returnJson($arr);

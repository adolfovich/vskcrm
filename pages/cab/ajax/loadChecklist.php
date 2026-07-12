<?php

require_once('connect.php');



$operations1 = $db->getAll("SELECT * FROM checklist_operations WHERE checklist_id = ?i AND regulations = 1", $_POST['checklist_id']) ;
$operations2 = $db->getAll("SELECT * FROM checklist_operations WHERE checklist_id = ?i AND regulations = 2", $_POST['checklist_id']) ;

$arr = [];
$html = '';

if ($operations1) {

    $html .= '<div class="card" >';
    $html .= '<div class="card-body row-striped">';
    $html .= '<h3>Регламент 1</h3>';

    foreach ($operations1 as $operation) {

        $html .= '<div class="row">';
            $html .= '<div class="col-10">'.$operation['action'].'</div>';
            $html .= '<div class="col-2"><input type="checkbox" /> </div>';
        $html .=  '</div>';


    }
    $html .= '</div>';
    $html .= '</div>';

    if ($operations2) {
        $html .= '<div class="card" >';
        $html .= '<div class="card-body row-striped">';
        $html .= '<h3>Регламент 2</h3>';

        foreach ($operations2 as $operation) {

            $html .= '<div class="row">';
            $html .= '<div class="col-10">'.$operation['action'].'</div>';
            $html .= '<div class="col-2"><input type="checkbox" /> </div>';
            $html .=  '</div>';


        }
        $html .= '</div>';
        $html .= '</div>';
    } else {
        $html .= '<div class="card" >';
        $html .= '<div class="card-body">';
        $html .= '<h3>Регламент 2 не предусмотрен</h3>';
        $html .= '</div>';
        $html .= '</div>';
    }

} else {
    $html .= '<h3 class="card-title row">';
    $html .= '<div class="col-sm text-left">';
    $html .= 'Операций не найдено';
    $html .= '</div>';
    $html .= '</h3>';
}

//echo $html;

$arr['response'] = $html;

echo $core->returnJson($arr);

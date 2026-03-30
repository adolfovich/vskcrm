<?php

require_once('connect.php');

$arr['response'] = [];
$arr['response']['html'] = '';

$operation_params = $db->getAll("SELECT * FROM finance_operation_params");

$i = 1;

foreach ($operation_params as $params) {
    $operations_types = explode(',', $params['operations_types']);    

    if (in_array($_POST['descId'], $operations_types)) {
        $arr['response']['html'] .= '<div class="form-group" style="margin-bottom: 0.5rem;">';
        $arr['response']['html'] .=    '<label for="opDescParam'.$i.'">'.$params['label'].'</label>';
        if ($params['type'] == 'select') {
            $arr['response']['html'] .=      '<select class="form-control" id="op_param['.$params['name'].']" name="op_param['.$params['name'].']">'; 
            foreach (json_decode($params['param_values'], TRUE) as $key => $value) {
                if ($key == date("n") || $key == date("Y")) { $selected = 'selected'; } else { $selected = ''; }
                $arr['response']['html'] .=  '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
            }
            
            $arr['response']['html'] .=      '</select>';
        } else if ($params['type'] == 'input') {
            $arr['response']['html'] .= '<input type="number" name="op_param['.$params['name'].']" class="form-control" id="op_param['.$params['name'].']" placeholder="" >';
        }
        $arr['response']['html'] .=  '</div>';
    }     
}

echo $core->returnJson($arr);
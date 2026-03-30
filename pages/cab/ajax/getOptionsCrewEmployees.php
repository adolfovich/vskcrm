<?php

require_once('connect.php');

$arr['response'] = '';

if (isset($_POST['id'])) {
	$employees = $db->getAll("SELECT * FROM employees WHERE crew = ?i AND dismissal = 0", $_POST['id']);
	
	if ($employees) {
		foreach ($employees as $employe) {
			$arr['response'] .= '<option value="'.$employe['id'].'">'.$employe['surname'].' '.$employe['firstname'].'</option>';
		}
	} else {
		$arr['response'] .= '<option selected disabled>В бригаде нет сотрудников</option>';
	}
	
	

} else {
  $arr['error'] = 'Ошибка. Неверные данные.';
}

echo $core->returnJson($arr);
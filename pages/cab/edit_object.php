<?php

if (isset($form)) {
	if ($form['objAction'] == "update") {
		$update['direction'] = $form['objDirection'];
		$update['name'] = $form['objName'];
		$update['address'] = $form['objAddress'];
		$update['crew'] = $form['objCrew'];
		$update['employees'] = implode(",", $form['objCrewEmployees']);
		
		$db->query("UPDATE objects SET ?u WHERE id = ?i", $update, $form['objId']);
		
	} else if ($form['objAction'] == "new") {
		
		$insert['direction'] = $form['objDirection'];
		$insert['name'] = $form['objName'];
		$insert['address'] = $form['objAddress'];
		$insert['crew'] = $form['objCrew'];
		$insert['employees'] = implode(",", $form['objCrewEmployees']);
		
		$db->query("INSERT INTO objects SET ?u", $insert);
		$newId = $db->insertId();
		if (isset($form["save"])) {
			$msg['type'] = 'success';
			$msg['text'] = 'Успешно сохранено';
			$core->jsredir('edit_object?id='.$newId);
		} else {
			$core->jsredir('objects');
		}
	}
}

if (isset($form["saveclose"])) {
	$core->jsredir('objects');
} else if (isset($form["save"])) {
	$msg['type'] = 'success';
	$msg['text'] = 'Успешно сохранено';
}

if (isset($get['a']) && $get['a'] == 'new') {
  
} else {
	$object = $db->getRow("SELECT * FROM `objects` WHERE `id` = ?i", $get['id']);
}

$directions = $db->getAll("SELECT * FROM `directions` WHERE is_del = 0");

$crews = $db->getAll("SELECT * FROM `crews` WHERE is_del = 0");

if (isset($object)) {
    $employees = $db->getAll("SELECT * FROM `employees` WHERE dismissal = 0 AND crew = ?i", $object["crew"]);
} else {
    $employees = $db->getAll("SELECT * FROM `employees` WHERE dismissal = 0");
}

include ('tpl/cab/edit_object.tpl');

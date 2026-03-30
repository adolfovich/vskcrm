<?php

$stop = 0;
$msg = [];

if (isset($form['save']) || isset($form['saveclose'])) {
	
	$update = [];
	
	if (strlen($form['userLogin']) >= 5) {
		if (preg_match("#^[aA-zZ0-9\-_]+$#",$form['userLogin'])) {	
			$update_login = 1;
					
		} else {
			$msg[] = ["type"=>"danger", "text"=>"Ошибка! Логин должен содержать только буквы и цифры"];
		}		
	} else {
		$msg[] = ["type"=>"danger", "text"=>"Ошибка! Логин должен быть не короче 5 символов"];
	}
	
	if (($form['userPass'] && $form['userRePass']) || (isset($get['a']) && $get['a'] == 'new')) {
		if (strlen($form['userPass']) >= 5) {
		  if ($form['userPass'] == $form['userRePass']) {
			$update_pass = 1;
		  } else {
			$msg[] = ["type"=>"danger", "text"=>"Ошибка! Введенные пароли не совпадают"];
		  }
		} else {
		  $msg[] = ["type"=>"danger", "text"=>"Ошибка! Пароль должен быть не менее 5 символов"];
		}
	}
	
	if ((isset($get['a']) && $get['a'] == 'new') && (!isset($form['userProfile']) || $form['userProfile'] < 1)) {
		$msg[] = ["type"=>"danger", "text"=>"Не выбран профиль пользователя"];
		$stop = 1;
	}
	
	if (($form['userSurname'] == '' || $form['userFirstname'] == '' || $form['userPatronymic'] == '') && $stop != 1) {
		$msg[] = ["type"=>"danger", "text"=>"Ошибка! ФИО не может быть пустым"];
	} else {
		
		if ($update_login) {
			if (isset($get['a']) && $get['a'] == 'new') {
				$db->query("INSERT INTO `users` SET `login` = ?s", $form['userLogin']);
				$newId = $db->insertId();
				$get['id'] = $newId;
			} else {
				$db->query("UPDATE `users` SET `login` = ?s WHERE `id` = ?i", $form['userLogin'], $get['id']);
			}
			
		}
		if (isset($update_pass)){
			$db->query("UPDATE `users` SET `pass` = ?s WHERE `id` = ?i", $core->as_md5($form['userPass'], $pass_key), $get['id']);
		}
		
		if (isset($form['userProfile'])) {
			$db->query("UPDATE `users` SET `profile` = ?i WHERE `id` = ?i", $form['userProfile'], $get['id']);
		} 
		
		$update['surname'] = $form['userSurname'];
		$update['firstname'] = $form['userFirstname'];
		$update['patronymic'] = $form['userPatronymic'];
		$update['phone'] = $form['userPhone'];
		$update['email'] = $form['userEmail'];
		if (isset($form['userCrew'])) {
			$update['crew'] = $form['userCrew'];
		}	
		if (isset($form['userCrew_leader']) && $form['userCrew_leader'] == 1) {
			$update['crew_leader'] = 1;
		} else {
			$update['crew_leader'] = 0;
		}
		
		if (isset($get['a']) && $get['a'] == 'new') {
			$update['user_id'] = $newId;
			$db->query("INSERT INTO employees SET ?u", $update);
		} else {
			$db->query("UPDATE employees SET ?u WHERE user_id = ?i", $update, $get['id']);
		}
		
		if (isset($newId)) {
			$core->jsredir('user_edit?id='.$newId);
		}
		if (isset($form["saveclose"])) {
			$core->jsredir('users');
		} else if (isset($form["save"])) {
			$msg[] = ["type"=>"success", "text"=>"Данные сохранены"];
		}
	}

}

//var_dump($user_data['salons']);

if (isset($get['id'])) {
  if ($user_data = $db->getRow("SELECT *,(SELECT name FROM crews WHERE id = employees.crew) as crew_name FROM users JOIN employees ON users.id = employees.user_id WHERE users.id = ?i", $get['id'])) {
    $user_profile = $db->getRow("SELECT * FROM `profiles` WHERE `id` = ?i", $user_data['profile']);    
  } else {
    $msg[] = ["type"=>"danger", "text"=>"Ошибка! пользователь не найден"];
  }
} else if ($get['a'] == 'new') {
	if (isset($form)) {
		$user_data['surname'] = $form['userSurname'];
		$user_data['firstname'] = $form['userFirstname'];
		$user_data['patronymic'] = $form['userPatronymic'];
		$user_data['login'] = $form['userLogin'];
		$user_profile['name'] = '';
		$user_data['phone'] = $form['userPhone'];
		$user_data['email'] = $form['userEmail'];
		$user_data['crew_name'] = '';
		$user_data['crew_leader'] = '';
	} else {
		$user_data['surname'] = '';
		$user_data['firstname'] = '';
		$user_data['patronymic'] = '';
		$user_data['login'] = '';
		$user_profile['name'] = '';
		$user_data['phone'] = '';
		$user_data['email'] = '';
		$user_data['crew_name'] = '';
		$user_data['crew_leader'] = '';
	}
	
}
$profiles = $db->getAll("SELECT * FROM `profiles`");
$crews = $db->getAll("SELECT * FROM crews WHERE is_del= 0");

include ('tpl/cab/user_edit.tpl');

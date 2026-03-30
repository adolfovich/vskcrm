<?php

//var_dump(__DIR__ . "/ajax/sendPurchaseEmail.php?id=");

$imgFileTypes = [
  'image/jpg',
  'image/jpeg',
  'image/png',
];

$full_path = dirname(__FILE__);
$full_path = str_replace('pages/cab', '', $full_path);
$full_path = realpath($full_path);
//$attach_Path = str_replace('pages/cab', '', $full_path);

if (isset($form)) {

  $curr_ticket = $db->getRow("SELECT * FROM `tickets` WHERE `id` = ?i", $_GET['id']);

    if(isset($_FILES['dv_photo']['name'][0]) && $_FILES['dv_photo']['size'][0] > 0) {
      //var_dump($_FILES['dv_photo']['name'][0]);

          $Dv_fileTmpPath = $_FILES['dv_photo']['tmp_name'][0];
          $extention = explode(".", $_FILES['dv_photo']['name'][0]);
          $extention = end($extention);

          $Dv_name = $curr_ticket['rzhd_id'].'_dv_'.date("dmYHis").'.'.$extention;

          //var_dump($full_path);
          //echo '<br>';

          $Dv_dest_path = $full_path."/ticketsAttachments/" . $Dv_name;
        var_dump($Dv_dest_path);
        echo '<br>';
          $Dv_dest_path = str_replace("/", "\\", $Dv_dest_path);
        var_dump($Dv_dest_path);
        echo '<br>';

          $dbpath = '/ticketsAttachments/'.$Dv_name;

          if (in_array(mime_content_type($Dv_fileTmpPath), $imgFileTypes)) {
              $Dv_attFiles['type'] = 'img';
          } else {
              $Dv_attFiles['type'] = 'file';
          }

        var_dump($Dv_attFiles['type']);
        echo '<br>';

          $Dv_attFiles['path'] = $dbpath;



          move_uploaded_file($Dv_fileTmpPath, $Dv_dest_path);

        $Dv_attFilesJson = json_encode($Dv_attFiles);

        $core->ticketLog($_GET['id'], $user_data['id'], '<span style="text-decoration: underline;">Загружена ДВ</span>', $Dv_attFilesJson);

  }


    if (isset($form['dep_plan']) && $form['dep_plan'] != '' && $form['dep_plan'] != date("Y-m-d", strtotime($curr_ticket['date_visit_plane']))) {
        $db->query("UPDATE tickets SET date_visit_plane = ?s WHERE id = ?i", $form['dep_plan'], $_GET['id']);
        $comment = 'Дата запланированного выезда изменена с '.date("d.m.Y", strtotime($curr_ticket['date_visit_plane'])).' на '.date("d.m.Y", strtotime($form['dep_plan']));
        $core->ticketLog($_GET['id'], $user_data['id'], '<span style="text-decoration: underline;">Изменение:</span> '.$comment);
        unset($comment);
    }

    if (isset($form['dep_fact']) && $form['dep_fact'] != '' && $form['dep_fact'] != date("Y-m-d", strtotime($curr_ticket['date_visit_fact']))) {
        $db->query("UPDATE tickets SET date_visit_fact = ?s WHERE id = ?i", $form['dep_fact'], $_GET['id']);
        $comment = 'Дата фактического выезда изменена с '.date("d.m.Y", strtotime($curr_ticket['date_visit_fact'])).' на '.date("d.m.Y", strtotime($form['dep_fact']));
        $core->ticketLog($_GET['id'], $user_data['id'], '<span style="text-decoration: underline;">Изменение:</span> '.$comment);
        unset($comment);
    }

  if (isset($form['lead_time']) && $form['lead_time'] != date("Y-m-d", strtotime($curr_ticket['lead_time']))) {
    $db->query("UPDATE `tickets` SET lead_time = ?s WHERE `id` = ?i", $form['lead_time'], $_GET['id']);
    $comment = 'Дата выполнения  изменена с '.date("d.m.Y", strtotime($curr_ticket['lead_time'])).' на '.date("d.m.Y", strtotime($form['lead_time']));
    $core->ticketLog($_GET['id'], $user_data['id'], '<span style="text-decoration: underline;">Изменение:</span> '.$comment);
    unset($comment);
  }

  if (isset($form['changeStatus'])) {

    $changeStatus = $form['changeStatus'];
    if ($changeStatus == 2 && $curr_ticket['type'] == 100) {
      $purchase_tickets = explode(';', $curr_ticket['text']);
      foreach ($purchase_tickets as $purchase_ticket) {
        $db->query("UPDATE tickets SET status = ?i WHERE id = ?i", $core->cfgRead('auto_status_purchse_end'), $purchase_ticket);
      }
    }

    if ($changeStatus == $core->cfgRead('auto_status_purchse_send') && ($curr_ticket['type'] == 100 || $curr_ticket['type'] == 0)) {
      $html = '';
      $ticket_data = $db->getRow("SELECT
        *,
        (SELECT `name` FROM `tickets_statuses` WHERE `id` = t.`status`) as status_name,
        (SELECT `next_statuses` FROM `tickets_statuses` WHERE `id` = t.`status`) as next_statuses,
        (SELECT `edited` FROM `tickets_statuses` WHERE `id` = t.`status`) as edited,
        (SELECT `color` FROM `tickets_statuses` WHERE `id` = t.`status`) as status_color,
        (SELECT `name` FROM `tickets_types` WHERE `id` = t.`type`) as type_name,
        (SELECT name FROM tickets_providers WHERE id = provider) as provider_name,
        (SELECT email FROM tickets_providers WHERE id = provider) as provider_email
        FROM `tickets` t WHERE `id` = ?i", $_GET['id']);

      if ($ticket_data['provider_email']) {
        if ($ticket_data['type'] == 0) {
          $purchases = $db->getAll("SELECT tp.*, (SELECT id FROM tickets_nomenclature WHERE id = tp.nomenclature_id) as nomenclature_id, (SELECT name FROM tickets_nomenclature WHERE id = tp.nomenclature_id) as nomenclature, (SELECT type FROM tickets_nomenclature WHERE id = tp.nomenclature_id) as nomenclature_type FROM tickets_purchases tp WHERE tp.ticket_id = ?i AND 	tp.purchase > 0", $ticket_data['id'] );

          foreach ($purchases as $purchase) {
            $html .= $purchase['nomenclature'].' - '.$purchase['purchase'].'('.$purchase['nomenclature_type'].')<br>';
          }
        }

        if ($ticket_data['type'] == 100) {
          $purchases = explode(';', $ticket['text']);

          $count_purchases = $db->getAll("SELECT id, 	nomenclature_id, SUM(residue) AS sum_residue, SUM(purchase) AS sum_purchase, (SELECT name FROM tickets_nomenclature WHERE id = nomenclature_id) as name, (SELECT type FROM tickets_nomenclature WHERE id = nomenclature_id) as nomenclature_type FROM tickets_purchases WHERE ticket_id IN (?a) GROUP BY nomenclature_id", $purchases);

          foreach ($count_purchases as $count_purchase) {
            $html .= $count_purchase['nomenclature'].' - '.$count_purchase['purchase'].'('.$count_purchase['nomenclature_type'].')<br>';
          }
        }

        $send_email = $core->sendMyMail('Заказ #'.$ticket_data['id'].' '.$core->cfgRead('salon_name'), $html , $ticket_data['provider_email']);

        $comment = 'Отправлено письмо поставщику на адрес '.$ticket_data['provider_email'];
        $core->ticketLog($_GET['id'], $user_data['id'], '<span style="text-decoration: underline;">Email:</span> '.$comment);
      }



    }
    unset($form['changeStatus']);
  }

  if (isset($form['comment'])) {
    $comment = $form['comment'];
    unset($form['comment']);
  }

  $total_files = 0;

  if (isset($_FILES['comment_photo']))  $total_files = count($_FILES['comment_photo']['name']);

  if (!isset($comment) || $comment == '') $comment = ' ';
	 
  if ((isset($comment) && $comment != '') || $total_files) {
	  
	  $attFiles = [];
	  
	  for($key = 0; $key < $total_files; $key++) {
		  
		  if(isset($_FILES['comment_photo']['name'][$key]) && $_FILES['comment_photo']['size'][$key] > 0) {
			
			$fileTmpPath = $_FILES['comment_photo']['tmp_name'][$key];
            $extention = explode(".", $_FILES['comment_photo']['name'][$key]);
            $extention = end($extention);
            //$name = uniqid().'.'.$extention;
            $name = $_FILES['comment_photo']['name'][$key];
            $dest_path = $full_path.'/ticketsAttachments/' . $name;
            $dbpath = '/ticketsAttachments/'.$name;
			
			if (in_array(mime_content_type($fileTmpPath), $imgFileTypes)) {
				$attFiles[$key]['type'] = 'img';
			} else {
				$attFiles[$key]['type'] = 'file';
			}
			
		    $attFiles[$key]['path'] = $dbpath;

            move_uploaded_file($fileTmpPath, $dest_path);
			
		  }
		  
	  }


	   $attFilesJson = json_encode($attFiles);

      if (isset($comment) && $comment != '' && $comment != ' ') {
          var_dump($comment);
          $core->ticketLog($_GET['id'], $user_data['id'], '<span style="text-decoration: underline;">Комментарий</span>: '.$comment, $attFilesJson);
      }
	  

  }


  if (isset($changeStatus) && $changeStatus != $curr_ticket['status']) {
    $update = [
      "status" => $changeStatus
    ];
    $db->query("UPDATE `tickets` SET ?u WHERE `id` = ?i", $update, $_GET['id']);
    $status_info = $core->getTicketStatusInfo($changeStatus);
    $core->ticketLog($_GET['id'], $user_data['id'], '<span style="text-decoration: underline;">Изменение статуса на</span> "'.$status_info['name'].'"');
  }





  $saved = TRUE;
}

$ticket = $db->getRow("SELECT
  *,
  (SELECT `name` FROM `tickets_statuses` WHERE `id` = t.`status`) as status_name,
  (SELECT `next_statuses` FROM `tickets_statuses` WHERE `id` = t.`status`) as next_statuses,
  (SELECT `edited` FROM `tickets_statuses` WHERE `id` = t.`status`) as edited,
  (SELECT `color` FROM `tickets_statuses` WHERE `id` = t.`status`) as status_color,
  (SELECT `name` FROM `tickets_types` WHERE `id` = t.`type`) as type_name,
  (SELECT name FROM tickets_providers WHERE id = provider) as provider_name,
  (SELECT email FROM tickets_providers WHERE id = provider) as provider_email,
  (SELECT name FROM users WHERE id = responsible_user) as responsible_user_name, 
  (SELECT name FROM objects WHERE id = t.object_id) as object_name
  FROM `tickets` t WHERE `id` = ?i", $_GET['id']);

//var_dump($ticket['next_statuses']);

if (!$user_profile['change_close_tickets']) {
  $next_statuses = explode(',', $ticket['next_statuses']);
} else {
  $next_statuses = $db->getCol("SELECT id FROM tickets_statuses WHERE deleted != 1");
}

//$next_statuses = explode(',', $ticket['next_statuses']);

//var_dump($next_statuses);

$ticket_log = $db->getAll("SELECT tl.*, (SELECT `name` FROM `users` WHERE `id` = tl.`user_id`) as `user_name` FROM `tickets_log` tl WHERE tl.`ticket_id` = ?i ORDER BY tl.`id` DESC", $ticket['id']);

$ticket_photos = $db->getAll("SELECT * FROM tickets_photos WHERE ticket_id = ?i", $ticket['id']);

if (!$ticket['type_name']) {
  if ($ticket['type'] == 0) {
    $ticket['type_name'] = 'Закупка';
  } else if ($ticket['type'] == 100) {
    $ticket['type_name'] = 'Общая закупка';
  }
}

if ($ticket['type'] == 0) {
  $purchases = $db->getAll("SELECT tp.*, (SELECT id FROM tickets_nomenclature WHERE id = tp.nomenclature_id) as nomenclature_id, (SELECT name FROM tickets_nomenclature WHERE id = tp.nomenclature_id) as nomenclature FROM tickets_purchases tp WHERE tp.ticket_id = ?i AND 	tp.purchase > 0", $ticket['id'] );
}

if ($ticket['type'] == 100) {
  $purchases = explode(';', $ticket['text']);
}

$comments = $db->getAll("SELECT tl.*, (SELECT `name` FROM `users` WHERE `id` = tl.`user_id`) as `user_name` FROM `tickets_log` tl WHERE tl.`ticket_id` = ?i AND (tl.text LIKE ?s OR tl.attachments IS NOT NULL) ORDER BY tl.`id` DESC", $ticket['id'], '%Комментарий%');

include ('tpl/cab/ticket.tpl');

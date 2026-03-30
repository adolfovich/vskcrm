<?php

require_once('connect.php');

$arr['response'] = [];

$arr['response']['tickets'] = '';

if ($form["salon"] == 'all') {
 if ($user_data['salons'] == '0') {
	$accepted_salons = $db->getCol("SELECT id FROM salons WHERE enabled = 1  AND franchising = 0");
  $accepted_salons [] = 0;
 } else {
	$accepted_salons = explode(",", $user_data['salons']);
 }
} else {
  $accepted_salons[] = $form["salon"];
}

$user_profile = $db->getRow("SELECT * FROM profiles WHERE id = ?i", $user_data['profile']);


$dateTo = $form["dateTo"].' 23:59:59';

$sql = $db->parse("SELECT *,
(SELECT name FROM salons WHERE id = salon_id) as salon_name,
(SELECT name FROM tickets_types WHERE id = type) as type_name,
(SELECT name FROM tickets_statuses WHERE id = status) as status_name,
(SELECT color FROM tickets_statuses WHERE id = status) as status_color,
(SELECT name FROM tickets_providers WHERE id = provider) as provider_name
FROM tickets WHERE salon_id IN (?a) AND is_del = 0 AND create_date BETWEEN ?s AND ?s ", $accepted_salons, $form["dateFrom"], $dateTo);


if ($form["type"] != '0') {
  $sql .= $db->parse(" AND type = ?s ", $form['type']);
}

if ($form['status'] != '0') {
  $sql .= $db->parse(" AND status = ?s ", $form['status']);
}


$sql .= ' ORDER BY create_date DESC';

//var_dump($sql);
$tickets = $db->getAll($sql);


if ($tickets) {

  foreach($tickets as $ticket) {

    $last_change = $db->getOne("SELECT date FROM tickets_log WHERE ticket_id = ?i ORDER BY date DESC LIMIT 1", $ticket['id']);

    if (!$last_change) $last_change = $ticket['create_date'];

    if (!$ticket['lead_time']) {
      $lead_time = '---';
    } else {
      $lead_time = date("d.m.Y H:i", strtotime($ticket['lead_time']));
    }

    //$arr['response']['tickets'] .= '<a href="#">';

    if (!$ticket['type_name']) {
      if ($ticket['type'] == 0) {
        $ticket['type_name'] = 'Закупка';
      } else if ($ticket['type'] == 100) {
        $ticket['type_name'] = 'Общая закупка';
      }
    }

    $arr['response']['tickets'] .= '<tr onClick="document.location.href = \'/cab/ticket?id='.$ticket['id'].'\'">';

    $arr['response']['tickets'] .= '<th class="align-middle" style="text-align: center;" scope="row">'.$ticket['id'];
	if ($user_profile['delete_tickets']) {
		$arr['response']['tickets'] .= '&nbsp <a style="color: red;" href="?del_ticket='.$ticket['id'].'"><i class="fas fa-trash"></i></a> ';
	}
	$arr['response']['tickets'] .= '</th>';
    $arr['response']['tickets'] .= '<th class="align-middle" style="text-align: center;" scope="row">'.date("d.m.Y H:i", strtotime($ticket['create_date'])).'</th>';
    $arr['response']['tickets'] .= '<td class="align-middle" style="text-align: center;">'.$ticket['salon_name'].'</td>';
    $arr['response']['tickets'] .= '<td class="align-middle" style="text-align: center;">'.$ticket['type_name'].' ';
    if ($ticket['provider']) {
      $arr['response']['tickets'] .= '<br>('.$ticket['provider_name'].')'; //
    }
    $arr['response']['tickets'] .= '</td>';
    $arr['response']['tickets'] .= '<td class="align-middle" style="text-align: center;"><span class="status" style="color:'.$ticket['status_color'].'; background-color: '.$core->hex2rgba($ticket['status_color'], 0.3).';">'.$ticket['status_name'].'</span></td>';

    $arr['response']['tickets'] .= '<td class="align-middle" style="text-align: center;">'.$lead_time.'</td>';

    $arr['response']['tickets'] .= '<td class="align-middle" style="text-align: center;">'.date("d.m.Y H:i", strtotime($last_change)).'</td>';

    $arr['response']['tickets'] .= '</tr>';

    //$arr['response']['tickets'] .= '</a>';

  }

} else {
  $arr['response']['tickets'] .= '<tr>';
  $arr['response']['tickets'] .= '<td colspan="5" style="text-align: center;">Нет данных</td>';
  $arr['response']['tickets'] .= '</tr>';
}


echo $core->returnJson($arr);

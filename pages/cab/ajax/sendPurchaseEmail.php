<?php

require_once('connect.php');

var_dump(222);

$arr = [];
$html = '';

if (isset($get['id']) && $get['id'] > 0) {

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

  if ($ticket_data && ($ticket_data['type'] == 0 || $ticket_data['type'] == 100)) {

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

    $arr['response_email'] = $send_email;

  } else {
    $arr['error'] = 'Заявка не найдена или не является закупкой';
  }

} else {
  $arr['error'] = 'Возникла ошибка. Обновите страницу';
}

$arr['response'] = $html;

echo $core->returnJson($arr);

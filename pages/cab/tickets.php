<?php

$allowFileTypes = [
  'image/jpg',
  'image/jpeg',
  'image/png',
];

$full_path = dirname(__FILE__);
$full_path = str_replace('pages/cab', '', $full_path);

$img_insert = [];

if(isset($_GET['del_ticket']) && $_GET['del_ticket'] > 0) {
	$db->query("UPDATE tickets SET is_del = 1 WHERE id = ?i", $_GET['del_ticket']);
}

$tickets = $db->getAll("
    SELECT t.*, 
    (SELECT name FROM objects WHERE id = t.object_id) as object_name, 
    (SELECT name FROM tickets_statuses WHERE id = t.status) as status_name, 
    (SELECT color FROM tickets_statuses WHERE id = t.status) as status_color 
    FROM tickets t 
    WHERE t.is_del = 0 AND t.object_id IN (SELECT id FROM objects WHERE crew = ?i)
    ORDER BY t.id DESC", $employe['crew']) ;


include ('tpl/cab/tickets.tpl');

<?php

require_once('connect.php');

$arr['response']['html'] = 'Отчет отправлен';


if ($_POST["reportBalance"] <= 0) {
	$arr['error'] = 'Не заполнено поле "Остаток"';
	$arr['error_field'] = 'reportBalance';	
}

if ($_POST["reportNonCash"] <= 0) {
	$arr['error'] = 'Не заполнено поле "Б/нал"';
	$arr['error_field'] = 'reportNonCash';
}

if ($_POST["reportManikClients"] <= 0) {
	$arr['error'] = 'Не заполнено поле "Маники"';
	$arr['error_field'] = 'reportManikClients';
}
if ($_POST["reportManikAmount"] <= 0) {
	$arr['error'] = 'Не заполнено поле "Маники"';
	$arr['error_field'] = 'reportManikAmount';
}

if ($_POST["reportParikClients"] <= 0) {
	$arr['error'] = 'Не заполнено поле "Парики"';
	$arr['error_field'] = 'reportParikClients';
}
if ($_POST["reportParikAmount"] <= 0) {
	$arr['error'] = 'Не заполнено поле "Парики"';
	$arr['error_field'] = 'reportParikAmount';
}
if ($_POST["reportValClients"] <= 0) {
	$arr['error'] = 'Не заполнено поле "Валовый доход"';
	$arr['error_field'] = 'reportValClients';
}
if ($_POST["reportValAmount"] <= 0) {
	$arr['error'] = 'Не заполнено поле "Валовый доход"';
	$arr['error_field'] = 'reportValAmount';
}


echo $core->returnJson($arr);
<?php

require_once('connect.php');

$salon_data = $db->getRow("SELECT * FROM salons WHERE id = ?i", $form['rentSalon']);

if ($salon_data) {
  if ($form['paymentType'] == 1) {
    $amount = $salon_data['rent_amount'];
    $count_payments = $core->getSalonRentSum($form['rentSalon'], $form['rentMonth'], date("Y"));
  } else {
    $amount = $salon_data['communal_amount'];
    $count_payments = $core->getSalonCommunalSum($form['rentSalon'], $form['rentMonth'], date("Y"));
  }

  //var_dump($form['paymentType']);

  if (($count_payments + $form['rentPayment']) <= $amount || $form['paymentType'] == 2) {
    $insert = [
      'payment_type' => $form['paymentType'],
      'payment_amount' => $form['rentPayment'],
      'payment_salon_id' => $salon_data['id'],
      'user_id' => $user_id
    ];
    $db->query("INSERT INTO salons_payments SET ?u", $insert);

    $arr['response']['html'] = '
        <span class="rent-payments-'.$form['rentMonth'].'" onClick="changeRentPayments('.$form['rentMonth'].', '.$salon_data['id'].')">'.
        ($count_payments + $form['rentPayment']).
        '</span>';

    $arr['response']['month'] = $form['rentMonth'];

  } else {
    $arr['error'] = 'После внесения платежа сумма будет больше чем сумма аренды';
  }

} else {
  $arr['error'] = 'error';
}

echo $core->returnJson($arr);

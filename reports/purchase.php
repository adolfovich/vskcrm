<?php

require_once('connect.php');

if (isset($_GET["ticket"]) && $_GET["ticket"] > 0) {
  $ticket_data = $db->getRow("SELECT * FROM tickets WHERE id = ?i", $_GET["ticket"]);

  if ($ticket_data && ($ticket_data['type'] == 0 || $ticket_data['type'] == 100)) {
    $salon_data = $db->getRow("SELECT * FROM salons WHERE id = ?i", $ticket_data['salon_id']);
    $provider_data = $db->getRow("SELECT * FROM tickets_providers WHERE id = ?i", $ticket_data['provider']);


      if ($ticket_data['type'] == 0) {
        $ticket['type_name'] = 'Заявка на закупку';
      } else if ($ticket_data['type'] == 100) {
        $ticket['type_name'] = 'Общая закупка';
      }


    if ($ticket_data['type'] == 0) {
      $purchases = $db->getAll("SELECT tp.*, (SELECT id FROM tickets_nomenclature WHERE id = tp.nomenclature_id) as nomenclature_id, (SELECT name FROM tickets_nomenclature WHERE id = tp.nomenclature_id) as nomenclature FROM tickets_purchases tp WHERE tp.ticket_id = ?i AND 	tp.purchase > 0", $ticket_data['id'] );
    }

    if ($ticket_data['type'] == 100) {
      $purchases = explode(';', $ticket_data['text']);

    }

    $n = 1;

    ?>
    <!DOCTYPE html>
    <html>

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Ya Statistic">
      <meta name="author" content="Exeptional Software">
      <title><?=$ticket['type_name']?></title>
      <!-- Favicon -->
      <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">
      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

      <style>
        .report-header {
          max-width: 1024px;
          margin: 0 auto;
          text-align: center;
          margin-top: 50px;
        }

        .purchase-details {
          max-width: 800px;
          margin: 0 auto;
          margin-top: 10px;
        }

        table {
          width: 800px;
          margin: 0 auto;
          border: 1px #000 solid;
          border-collapse: collapse;
        }

        th {
          padding: 10px;
          border: 1px #000 solid;
          background: #ccc;
        }

        td {
          padding: 10px;
          border: 1px #000 solid;
          text-align: center;
        }


      </style>

    </head>

    <body>

      <div class="report-header">
        <div><h2><?=$ticket['type_name']?> #<?=$ticket_data['id']?></h2></div>
        <div><h3>от <?=date("d.m.Y", strtotime($ticket_data['create_date']))?> </h3></div>
      </div>

      <div class="purchase-details">
        <?php if ($ticket_data['type'] == 0) { ?>
        <p><b>Салон:</b> <?=$salon_data['name']?></p>
        <?php } ?>
        <p><b>Поставщик:</b> <?=$provider_data['name']?></p>
      </div>

      <table>
        <thead>
          <tr>
            <th>№ П/П</th>
            <th>Наименование</th>
            <th>Прошлая закупка</th>
            <th>Остаток</th>
            <th>Заказ</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($ticket_data['type'] == 0) { ?>
            <?php foreach ($purchases as $purchase) { ?>
              <tr>
                <td><?=$n?></td>
                <td class="align-middle" style="text-align:left;"><?=$purchase['nomenclature']?></td>
                <td><?=$core->previousPurchase($purchase['nomenclature_id'], $ticket_data['salon_id'])?></td>
                <td><?=$purchase['residue']?></td>
                <td><?=$purchase['purchase']?></td>
              </tr>
              <?php $n++; ?>
            <?php } ?>
          <?php } else if ($ticket_data['type'] == 100) { ?>
            <?php $count_purchases = $db->getAll("SELECT id, 	nomenclature_id, SUM(residue) AS sum_residue, SUM(purchase) AS sum_purchase, (SELECT name FROM tickets_nomenclature WHERE id = nomenclature_id) as name FROM tickets_purchases WHERE ticket_id IN (?a) GROUP BY nomenclature_id", $purchases); ?>
            <?php foreach ($count_purchases as $count_purchase) { ?>
              <tr id="heading<?=$count_purchase['nomenclature_id']?>">
                <td><?=$n?></td>
                <td class="text-center"><?=$count_purchase['name']?></td>
                <td class="text-center"><?=$core->previousPurchase($count_purchase['nomenclature_id'])?></td>
                <td class="text-center"><?=$count_purchase['sum_residue']?></td>
                <td class="text-center"><?=$count_purchase['sum_purchase']?></td>
              </tr>
              <?php $n++; ?>
            <?php } ?>
          <?php } ?>
        </tbody>
      </table>
    <?php

  } else {
    die("Ошибка. Обратитесь к администратору");
  }
} else {
  die("Ошибка. Обратитесь к администратору");
}

<?php

require_once('connect.php');

$arr['response']['html'] = '';

if (isset($form['searchProvider']) && isset($form['searchName'])) {

  $sql = "SELECT tn.*, (SELECT name FROM tickets_providers WHERE id = tn.provider) as provider_name  FROM tickets_nomenclature tn WHERE";

  if ($form['searchProvider'] != 'all' && $form['searchProvider'] > 0 ) {
    $searchProvider = " provider = " . $form['searchProvider'];
    $sql .= $searchProvider;
  }

  if (isset($searchProvider)) {
    $searchName = " AND	name LIKE '".$form['searchName']."%'";
  } else {
    $searchName = " name LIKE '".$form['searchName']."%'";
  }

  $sql .= $searchName;

  $nomenclatures = $db->getAll($sql);

  if ($nomenclatures) {
    $i = 1;
    foreach ($nomenclatures as $product) {
      $arr['response']['html'] .= '<tr>';
      $arr['response']['html'] .= '<td style="text-align: center;">'.$product['name'].'</td>';
      $arr['response']['html'] .= '<td style="text-align: center;">'.$product['description'].'</td>';
      $arr['response']['html'] .= '<td style="text-align: center;">'.$product['provider_name'].'</td>';
      $arr['response']['html'] .= '<td style="text-align: center;">'.$product['type'].'</td>';
      $arr['response']['html'] .= '<td style="text-align: center;">';
      $arr['response']['html'] .= '<a href="#" class="btn btn-outline-primary btn-sm" title="Редактировать" onClick="openModalEditProduct('.$product['id'].');">';
      $arr['response']['html'] .= '<i class="fas fa-edit"></i>';
      $arr['response']['html'] .= '</a>';
      $arr['response']['html'] .= '</td>';
      $arr['response']['html'] .= '<td style="text-align: center;">';
      $arr['response']['html'] .= '<a href="?delete&product_id='.$product['id'].'" class="btn btn-outline-danger btn-sm" title="Удалить">';
      $arr['response']['html'] .= '<i class="fas fa-trash-alt"></i>';
      $arr['response']['html'] .= '</a>';
      $arr['response']['html'] .= '</td>';
      $arr['response']['html'] .= '</tr>';
      $i++;
    }

  } else {
    $arr['response']['html'] .= '<tr>';
    $arr['response']['html'] .= '<td colspan="7" ><center>Ничего не найдено</center></td>';
    $arr['response']['html'] .= '</tr>';
  }

} else {
  $arr['error'] = 'error';
}

echo $core->returnJson($arr);

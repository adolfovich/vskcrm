<?php


require_once('connect.php');

function getDatesArray($date_start, $date_end)
{
    $dates = array();
    $date = $date_start;
    do {
        $dates[] = $date;
        $date = date('Y-m-d', strtotime($date . ' + 1 days'));
        $currDateArr = explode('-', $date);
    } while (strtotime($date) < strtotime($date_end));
    return $dates;
}

function getDayAmount($date, $operation_id, $salon) {
  global $db;
  if ($operation_id == 'saldo') {
    $day_amount_debit = $db->getOne("SELECT SUM(amount) FROM finance_journal WHERE date = ?s AND op_type = ?s AND salon = ?i AND is_del = 0", $date, 'debit', $salon);
    $day_amount_credit = $db->getOne("SELECT SUM(amount) FROM finance_journal WHERE date = ?s AND op_type = ?s AND salon = ?i AND is_del = 0", $date, 'credit', $salon);

    $day_amount = $day_amount_debit - $day_amount_credit;
  } else if ($operation_id == 'debit' || $operation_id == 'credit') {
    $day_amount = $db->getOne("SELECT SUM(amount) FROM finance_journal WHERE date = ?s AND op_type = ?s AND salon = ?i AND is_del = 0", $date, $operation_id, $salon);
  } else if ($operation_id == 'inkass') {
	$day_amount = $db->getOne("SELECT SUM(amount) FROM finance_journal WHERE date = ?s AND op_type = ?s AND salon = ?i AND is_del = 0", $date, 'neutral', $salon);
  } else {
    $day_amount = $db->getOne("SELECT SUM(amount) FROM finance_journal WHERE date = ?s AND op_decryption = (SELECT name FROM finance_operation_types WHERE id = ?i) AND op_type = (SELECT type FROM finance_operation_types WHERE id = ?i) AND salon = ?i AND is_del = 0", $date, $operation_id, $operation_id, $salon);
  }
  return $day_amount;
}
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
*/
echo '<pre>';

$date_start = date("Y-m-d 00:00:00", strtotime($_GET["dateFrom"]));
$date_end = date("Y-m-d 23:59:59", strtotime($_GET["dateTo"]));
$date_aray = getDatesArray($date_start, $date_end);

if ($_GET["salon"] != 'all') {
  $salon_data = $db->getRow("SELECT * FROM salons WHERE id = ?i", $_GET["salon"]);
  if ($user_data['salons'] == '0') {
 	  $accepted_salons = $db->getCol("SELECT id FROM salons WHERE enabled = 1");
  } else {
 	  $accepted_salons = explode(",", $user_data['salons']);
  }
  if (!in_array($salon_data['id'], $accepted_salons)) {
    $salon_data = '';
  }
} else {
  $salon_data = '';
}

if ($salon_data) {

$debit_operations = $db->getAll("SELECT id, name, report_color FROM finance_operation_types WHERE type = 'debit' AND (salon = 0 OR salon = ?i) ORDER BY ordering, id", $salon_data["id"]);
$insert = [
  'id' => 'debit',
  'name' => 'ДОХОДЫ'
];
array_unshift($debit_operations, $insert);

$credit_operations = $db->getAll("SELECT id, name, report_color FROM finance_operation_types WHERE type = 'credit' AND (salon = 0 OR salon = ?i) ORDER BY ordering, id", $salon_data["id"]);
$insert = [
  'id' => 'credit',
  'name' => 'РАСХОДЫ'
];
array_unshift($credit_operations, $insert);



echo '</pre>';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Ya Statistic">
  <meta name="author" content="Exeptional Software">
  <title>Отчет по салонам </title>
  <!-- Favicon -->
  <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script type="text/javascript" src="/assets/vendor/codebase/grid.js"></script>
  <link rel="stylesheet" href="/assets/vendor/codebase/grid.css">

  <style>
    html, body {
      height: 100%;
    }

    .report-header {
      max-width: 1024px;
      margin: 0 auto;
      text-align: center;
      padding-top: 10px;
    }

    * {font:arial,sans-serif;}

    p {margin:28px 0 3px 0;}

    .divFixHeaderCol {
      position:relative;
      border:0;
      border-left:1px solid #d0d0d0;
      border-bottom:1px solid #d0d0d0;
      overflow:hidden;
    }

    .divFixHeaderCol table {border-collapse:collapse;}

    .divFixHeaderCol td {
      padding: 5px !important;
      white-space: nowrap;
      font:400 11px tahoma,arial,sans-serif;
      padding:2px;
      border:1px solid #d0d0d0;
      border-left:0;
      background:#fff;
      min-height:14px;
    }

    .divFixHeaderCol .fixRegion td {
      background:#fff no-repeat;
      background-image:linear-gradient(#eee,#eee);
      background-position:1px 1px;
      padding: 5px;
      white-space: nowrap;
    }
    .cntr {text-align:center;}
  </style>
</head>
<body>

  <div class="report-header">
    <div><h2>Отчет по салону <?=$salon_data["name"]?></h2></div>
    <div><h3>за период <?=date("d.m.Y", strtotime($_GET['dateFrom']))?> - <?=date("d.m.Y", strtotime($_GET['dateTo']))?></h3></div>
  </div>
  <?php $sum_debit = 0; ?>
  <?php $sum_credit = 0; ?>
  <div id="main_table_contaner" style="height: calc(100% - 120px);  overflow: hidden;">
    <table id="main_table" >
      <tr>
        <td>&nbsp;</td>
        <?php foreach ($date_aray as $date) { ?>
          <td><?=date("d.m.y", strtotime($date))?></td>
        <?php } ?>
        <td>ИТОГО</td>
      </tr>
      <?php $i = 0; ?>
      <?php foreach ($debit_operations as $debit_operation) { ?>
      <tr>
        <td><?=$debit_operation['name']?></td>
        <?php $sum = 0; ?>
		<?php $sum_inkass = 0; ?>
		
        <?php foreach ($date_aray as $date) { ?>
          <td style="<?php if ($i == 0) {echo "background:#eee;";} else {echo "background: ".$debit_operation['report_color'].";";} ?>">
            <?php $day_amount = getDayAmount($date, $debit_operation['id'], $salon_data["id"]); ?>
            <?=$day_amount?>
            <?php $sum += $day_amount;?>
            <?php $sum_debit += $day_amount; ?>
          </td>
        <?php } ?>
        <td style="<?php if ($i == 0) {echo "background:#eee;";} else {echo "background: ".$debit_operation['report_color'].";";} ?>">
          <?=$sum?>

        </td>
      </tr>
      <?php $i++; ?>
      <?php } ?>
      <?php $i = 0; ?>
      <?php foreach ($credit_operations as $credit_operation) { ?>
      <tr>
        <td><?=$credit_operation['name']?></td>
        <?php $sum = 0; ?>
        <?php foreach ($date_aray as $date) { ?>
          <td style="<?php if ($i == 0) {echo "background:#eee;";} else {echo "background: ".$credit_operation['report_color'].";";} ?>">
            <?php $day_amount = getDayAmount($date, $credit_operation['id'], $salon_data["id"]); ?>
            <?=$day_amount?>
            <?php $sum += $day_amount;?>
            <?php $sum_credit += $day_amount; ?>
          </td>
        <?php } ?>
        <td style="<?php if ($i == 0) {echo "background:#eee;";} else {echo "background: ".$credit_operation['report_color'].";";} ?>">
          <?=$sum?>

        </td>
      </tr>
      <?php $i++; ?>
      <?php } ?>
	  <tr>
		  <td>Инкассация</td>
			<?php foreach ($date_aray as $date) { ?>
			  <td style="background:#eee;">
				<?php $day_amount = getDayAmount($date, 'inkass', $salon_data["id"]); ?>
				<?=$day_amount?>
				<?php $sum_inkass += $day_amount;?>				
			  </td>
			<?php } ?>
			<td style="background:#eee;">
			  <?=$sum_inkass?>
			</td>
	  </td>
      <tr>
        <td>САЛЬДО</td>
        <?php foreach ($date_aray as $date) { ?>
          <td style="background:#eee;">
            <?php $day_amount = getDayAmount($date, 'saldo', $salon_data["id"]); ?>
            <?=$day_amount?>
            <?php $sum += $day_amount;?>
            <?php $sum_credit += $day_amount; ?>
          </td>
        <?php } ?>
        <td style="background:#eee;">
          <?=$sum?>

        </td>
      </tr>
    </table>
  </div>

<script>
function gid(i) {return document.getElementById(i);}
function CEL(s) {return document.createElement(s);}
function ACH(p,c) {p.appendChild(c);}

function getScrollWidth() {
	var dv = CEL('div');
	dv.style.overflowY = 'scroll'; dv.style.width = '50px'; dv.style.height = '50px'; dv.style.position = 'absolute';
	dv.style.visibility = 'hidden';
	ACH(document.body,dv);
	var scrollWidth = dv.offsetWidth - dv.clientWidth;
	document.body.removeChild(dv);
	return (scrollWidth);
}

function setSum(tbl, rr, cc) {
  console.log(tbl);
	var rowCount = tbl.rows.length, sum = '';
	for (var i=rr; i<rowCount; i++) {
		var row = tbl.rows[i];
		for (var j=cc; j < row.cells.length; j++) {
			sum = Math.floor(Math.random()*10000) + '';
			row.cells[i,j].innerHTML = sum.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
			row.cells[i,j].style.textAlign = 'right';
		}
	}
}

function FixAction(el) {
	FixHeaderCol(gid('main_table'),1,1,400,170);
	el.parentNode.removeChild(el);
}

function FixHeaderCol(tbl, fixRows, fixCols, ww, hh) {
	var scrollWidth = getScrollWidth(), cont = CEL('div'), tblHead = CEL('table'), tblCol = CEL('table'), tblFixCorner = CEL('table');
	cont.className = 'divFixHeaderCol';
	cont.style.width = ww + 'px'; cont.style.height = hh + 'px';
	tbl.parentNode.insertBefore(cont,tbl);
	ACH(cont,tbl);

	var rows = tbl.rows, rowsCnt = rows.length, i=0, j=0, colspanCnt=0, columnCnt=0, newRow, newCell, td;
	for (j=0; j<rows[0].cells.length; j++) {columnCnt += rows[0].cells[j].colSpan;}
	var delta = columnCnt - fixCols;

	for (i=0; i<rowsCnt; i++) {
		columnCnt = 0; colspanCnt = 0;
		newRow = rows[i].cloneNode(true), td = rows[i].cells;
		for (j=0; j<td.length; j++) {
			columnCnt += td[j].colSpan;
			if (i<fixRows) {
				newRow.cells[j].style.width = getComputedStyle(td[j]).width;
				ACH(tblHead,newRow);
			}
		}

		newRow = CEL('tr');
		for (j=0; j<fixCols; j++) {
			if (!td[j]) continue;
			colspanCnt += td[j].colSpan;
			if (columnCnt - colspanCnt >= delta) {
				newCell = td[j].cloneNode(true);
				newCell.style.width = getComputedStyle(td[j]).width;
				newCell.style.height = td[j].clientHeight - parseInt(getComputedStyle(td[j]).paddingBottom) - parseInt(getComputedStyle(td[j]).paddingTop) + 'px';
				ACH(newRow,newCell);
			}
		}
		if (i<fixRows) {ACH(tblFixCorner,newRow);}
		ACH(tblCol,newRow.cloneNode(true));
	}

	tblFixCorner.style.position = 'absolute'; tblFixCorner.style.zIndex = '3'; tblFixCorner.className = 'fixRegion';
	tblHead.style.position = 'absolute'; tblHead.style.zIndex = '2'; tblHead.style.width = tbl.offsetWidth + 'px'; tblHead.className = 'fixRegion';
	tblCol.style.position = 'absolute'; tblCol.style.zIndex = '2'; tblCol.className = 'fixRegion';

	cont.insertBefore(tblHead,tbl);
	cont.insertBefore(tblFixCorner,tbl);
	cont.insertBefore(tblCol,tbl);

	var bodyCont = CEL('div');
	bodyCont.style.cssText = 'position:absolute;';

	var divHscroll = CEL('div'), d1 = CEL('div');
	divHscroll.style.cssText = 'width:100%; bottom:0; overflow-x:auto; overflow-y:hidden; position:absolute; z-index:3;';
	divHscroll.onscroll = function () {
		var x = -this.scrollLeft + 'px';
		bodyCont.style.left = x;
		tblHead.style.left = x;
	}

	d1.style.width = tbl.offsetWidth + scrollWidth + 'px';
	d1.style.height = '2px';

	ACH(divHscroll,d1);
	ACH(cont,divHscroll);
	ACH(bodyCont,tbl);
	ACH(cont,bodyCont);

	var divVscroll = CEL('div'), d2 = CEL('div');
	divVscroll.style.cssText = 'height:100%; right:0; overflow-x:hidden; overflow-y:auto; position:absolute; z-index:3';
	divVscroll.onscroll = function () {
		var y = -this.scrollTop + 'px';
		bodyCont.style.top = y;
		tblCol.style.top = y;
	}

	d2.style.height = tbl.offsetHeight + scrollWidth + 'px';
	d2.style.width = scrollWidth + 'px';

	ACH(divVscroll,d2);
	ACH(cont,divVscroll);

	cont.addEventListener('wheel', myWheel);
	function myWheel(e) {
		e = e || window.event;
		var delta = e.deltaY || e.detail || e.wheelDelta;
		var z = delta > 0 ? 1 : -1;
		divVscroll.scrollTop = divVscroll.scrollTop + z*17;
		e.preventDefault ? e.preventDefault() : (e.returnValue = false);
	}
}

window.onload = function() {
    FixHeaderCol(gid('main_table'),1,1,$('#main_table_contaner').width(),$('#main_table_contaner').height());
}

</script>
</body>
</html>

<?php } else { ?>

  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Ya Statistic">
    <meta name="author" content="Exeptional Software">
    <title>Отчет по салонам </title>
    <!-- Favicon -->
    <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">  <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/vendor/codebase/grid.js"></script>
    <link rel="stylesheet" href="/assets/vendor/codebase/grid.css">

    <style>
      html, body {
        height: 100%;
      }

      .report-header {
        max-width: 1024px;
        margin: 0 auto;
        text-align: center;
        padding-top: 10px;
      }

      * {font:arial,sans-serif;}

      p {margin:28px 0 3px 0;}

    </style>
  </head>
  <body>

    <div class="report-header">
      <div><h2>Ошибка</h2></div>
      <div><h3>Неверный салон</h3></div>
    </div>

  </body>
</html>

<?php } ?>

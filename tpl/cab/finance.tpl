<div class="main-content">

  <style>
  .modal-error {
    text-align: center;
  }
  </style>

  <div class="modal" id="addOperation"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form id="addOperationForm" method="POST">
        <input type="hidden" name="action_type" value="add_operation">

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Добавлeние операции</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="padding-top: 5px; padding-bottom: 5px;">

            <div class="form-group" style="margin-bottom: 0.5rem;">
              <label for="opSalon">Салон</label>
              <select class="form-control" id="opSalon" name="opSalon">
                <?php if ($user_salons[0] !== '') { ?>
                  <?php foreach($user_salons as $user_salon) { ?>
                    <option value="<?=$user_salon['id']?>"><?=$user_salon['name']?></option>
                  <?php } ?>
                <?php } else { ?>
                  <option selected disabled >Нет салонов</option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group" style="margin-bottom: 0.5rem;">
              <label for="opDete">Дата операции</label>
              <input type="date" name="opDete" class="form-control" id="opDete" placeholder="" value="<?=date("Y-m-d")?>">
            </div>

            <div class="form-group" style="margin-bottom: 0.5rem;">
              <label for="opType">Тип операции</label>
              <select class="form-control" id="opType" name="opType" onChange="loadDescriptions();">
                <option value="1">Доход</option>
                <option value="2">Расход</option>
                <option value="3">Инкассация</option>
              </select>
            </div>

            <div class="form-group" style="margin-bottom: 0.5rem;">
              <label for="opType">Нал/Безнал</label>
              <select class="form-control" id="opTypeMoney" name="opTypeMoney" >
                <option value="1">Нал</option>
                <option value="2">Безнал</option>
              </select>
            </div>

            <div class="form-group" style="margin-bottom: 0.5rem;">
              <label for="opDesc">Расшифровка</label>
              <select class="form-control" id="opDesc" name="opDesc" onChange="loadDescParams(this.value);">
                <option selected disabled>Выберите тип операции</option>
              </select>
            </div>

            <div id="opDescParams">

            </div>

            <div class="form-group" style="margin-bottom: 0.5rem;">
              <label for="opAmount">Сумма</label>
              <input type="number" name="opAmount" class="form-control" id="opAmount" placeholder="" >
            </div>

            <div class="form-group" style="margin-bottom: 0.5rem;">
              <label for="opComment">Комментарий</label>
              <input type="text" name="opComment" class="form-control" id="opComment" placeholder="" >
            </div>

          </div>

          <div class="modal-error text-danger">
            <?php if (isset($msg) && $msg['type'] == 'error') { echo $msg['text']; } ?>
          </div>
          <div class="modal-footer" style="padding-top: 0.5rem;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            <button type="submit" id="addOperationSubmit" class="btn btn-primary">Сохранить</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<script>
$( "#addOperationSubmit" ).click(function() {
  $( "#addOperationSubmit" ).prop('disabled', true);
  $( "#addOperationSubmit" ).text( 'Подождите...' );
  $( "#addOperationForm" ).submit();
});
</script>


	<div class="modal fade bd-example-modal-lg" id="opHistory"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">    

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">История операции</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="opHistoryBody" style="padding-top: 5px; padding-bottom: 5px;">

          </div>          
          <div class="modal-footer" style="padding-top: 0.5rem;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>            
          </div>
        </div>
      
    </div>
  </div>

  <div class="modal" id="editOperation"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form id="editOperationForm" method="POST">
        <input type="hidden" name="action_type" value="edit_operation">

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Изменение операции</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="editOperationBody" style="padding-top: 5px; padding-bottom: 5px;">

          </div>
          <div class="modal-error text-danger">
            <?php if (isset($msg) && $msg['type'] == 'error') { echo $msg['text']; } ?>
          </div>
          <div class="modal-footer" style="padding-top: 0.5rem;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            <button type="submit" class="btn btn-primary">Сохранить</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php if (isset($msg) && $msg['type'] == 'error') { ?>
    <script>
      $('#<?=$msg['window']?>').modal('show');
    </script>
  <?php } ?>

    <!-- Top navbar -->
    <?php include ('tpl/cab/tpl_header.tpl'); ?>
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <?php if (isset($msg) && $msg['type'] == 'success') { ?>
        <div class="row" style="padding-left: 40px; padding-right: 40px;">
          <div class="col-sm-8">
            <div class="alert alert-<?=$msg['type']?> alert-dismissible fade show" role="alert">
                <span class="alert-inner--icon"></span>
                <span class="alert-inner--text"><?=$msg['text']?></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
      <div class="container-fluid">
        <div class="header-body">

        </div>
      </div>

    <!-- Page content -->

    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">

            <div class="card-header bg-transparent" style="padding-bottom: 0;">
              <div class="row align-items-center">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link <?php if (!isset($_GET['rent_month'])) echo 'active' ?>" id="home-tab" data-toggle="tab" href="#finance-operations" role="tab" aria-controls="finance-operations" aria-selected="true">Операции</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if (isset($_GET['rent_month'])) echo 'active' ?>" id="profile-tab" data-toggle="tab" href="#finance-rent" role="tab" aria-controls="finance-rent" aria-selected="false">Аренда</a>
                  </li>
                </ul>
                <div class="col text-right">
                </div>
              </div>
            </div>


            <div class="card-header bg-transparent" style="padding-bottom: 0;">




            </div>
            <div class="card-body">

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade <?php if (!isset($_GET['rent_month'])) echo 'show active' ?>" id="finance-operations" role="tabpanel" aria-labelledby="finance-operations-tab">
                  <div class="row align-items-center">
                    <div class="col-md-8">
                      <form class="form-inline" id="finForm">
                        <div class="form-row">
                          <div class="form-group mx-sm-3 mb-2">
                            <label for="dateFrom" style="padding-right: 47px;">Период с </label>

                            <input type="date" name="dateFrom" class="form-control" id="dateFrom" placeholder=""
                            value="<?php if(isset($filter['dateFrom'])) {echo date("Y-m-d", strtotime($filter['dateFrom'])); } else { echo date("Y-m-d", (time() - (86400 * 30)));} ?>"
                            onChange="loadFinData()">
                          </div>
                          <div class="form-group mx-sm-3 mb-2">
                            <label for="dateTo" style="padding-right: 30px;"> - </label>
                            <input type="date" name="dateTo" class="form-control" id="dateTo" placeholder=""
                            value="<?php if(isset($filter['dateTo'])) {echo date("Y-m-d", strtotime($filter['dateTo'])); } else { echo date("Y-m-d");} ?>"
                            onChange="loadFinData()">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group mx-sm-3 mb-2">
                            <label for="salon" style="padding-right: 60px;">Салон</label>

                            <select name="salon" id="salon" class="form-control chosen-select" style="margin-left: 10px; max-width: 140px;" onChange="loadFinData()" >
                              <?php if ($accepted_salons[0] !== '') { ?>
                              <?php
                              if (count($user_salons) <= 1) {
                                ?>
                                <option value="<?=$user_salons[0]['id']?>" selected><?=$user_salons[0]['name']?></option>
                                <?php
                              } else {
                                ?>
                                <option value="all" selected>Все</option>
                                <?php
                                $selected = '';
                                foreach ($user_salons as $user_salon) {
                                  if (isset($filter['salon']) && $filter['salon'] == $user_salon['id']) {
                                    $selected = 'selected';
                                  } else {
                                    $selected = '';
                                  }
                                  ?>
                                  <option value="<?=$user_salon['id']?>" <?=$selected?>><?=$user_salon['name']?></option>
                                  <?php
                                }
                              }
                              ?>
                              <?php } else { ?>
                                <option selected disabled >Нет салонов</option>
                              <?php } ?>
                            </select>
                          </div>


                          <div class="form-group mx-sm-3 mb-2">
                            <label for="type">Тип</label>
                            <select name="type" id="type" class="form-control" style="margin-left: 10px; max-width: 140px;" onChange="loadDescriptionsFilter(); loadFinData();" <?php if ($accepted_salons === '') echo 'disabled'; ?>>
                              <option value="all" <?php if (isset($filter['type']) && $filter['type'] == 'all') echo 'selected'; ?>>Все</option>
                              <option value="2" <?php if (isset($filter['type']) && $filter['type'] == '2') echo 'selected'; ?>>Расходы</option>
                              <option value="1" <?php if (isset($filter['type']) && $filter['type'] == '1') echo 'selected'; ?>>Доходы</option>
                              <option value="3" <?php if (isset($filter['type']) && $filter['type'] == '3') echo 'selected'; ?>>Инкассация</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group mx-sm-3 mb-2">
                            <label for="description">Расшифровка</label>
                            <select name="description" id="description" class="form-control  select2-salon" style="margin-left: 10px; max-width: 140px;" onChange="loadFinData()" <?php if ($accepted_salons === '') echo 'disabled'; ?> >
                                <option value="all" selected>Все</option>
                                <?php
                                $selected = '';
                                foreach ($op_descriptions as $op_description) {
                                  if (isset($filter['description']) && $filter['description'] == $op_description['id']) {
                                    $selected = 'selected';
                                  } else {
                                    $selected = '';
                                  }
                                  ?>
                                  <option value="<?=$op_description['id']?>" <?=$selected?>><?=$op_description['name']?></option>
                                  <?php
                                  }
                                ?>
                            </select>
                          </div>
                        </div>
                      </form>
                      <div class="form-row">
                        <div class="form-group mx-sm-3 mb-2">
                          <a href="#" class="btn btn-primary mb-2" onClick="loadFinData()">Применить</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 text-right">
                      <button class="btn btn-primary mb-2" onClick="openModalAddOperation()">Добавить операцию</button>

                      <?php if ($user_profile['edit_finance']) { ?>
                      <a href="finance_settings" class="btn btn-primary mb-2" ><i class="fas fa-cog"></i></a>
                      <?php } ?>
                      <br>
                      <!--a href="#" class="btn btn-primary mb-2" onClick="openReport('finForm', '/reports/finance_salons.php')">Отчет по салонам</i></a-->

                      <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary mb-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Отчеты
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                          <a href="#" class="dropdown-item" onClick="openReport('finForm', '/reports/finance_salons.php')">по салонам</a>
                          <a href="#" class="dropdown-item" onClick="openReport('finForm', '/reports/finance_salon.php')">по одному салону</a>
                        </div>
                      </div>

                    </div>
                  </div>

                  <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="operations-tab" data-toggle="tab" href="#operations" role="tab" aria-controls="operations" aria-selected="true" onclick="document.cookie='finTab=operations'">Операции</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="chart-tab" data-toggle="tab" href="#chart" role="tab" aria-controls="chart" aria-selected="false" onclick="document.cookie='finTab=chart'">График</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="operations" role="tabpanel" aria-labelledby="operations-tab" style="overflow-x: scroll;">
                      <table class="table table-sm">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col" style="text-align: center;">Салон</th>
                            <th scope="col" style="text-align: center;">Дата</th>
                            <th scope="col" style="text-align: center;">Тип<br>операции</th>
                            <th scope="col" style="text-align: center;">Расшифровка</th>
                            <th scope="col" style="text-align: center;">Сумма</th>
                            <th scope="col" style="text-align: center;">Комментарий</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody class="table-striped" id="table-operations">
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="chart-tab">
                      <form id="formChart">
                        <div class="form-group">
                          <label for="chartType">Сортировка</label>
                          <select class="form-control" id="chartType" name="chartType" onChange="loadChart();">
                            <option value="days">По дням</option>
                            <option value="weeks">По неделям</option>
                            <option value="months">По месяцам</option>
                          </select>
                        </div>
                      </form>
                      <div id="finChart"></div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade <?php if (isset($_GET['rent_month'])) echo 'show active' ?>" id="finance-rent" role="tabpanel" aria-labelledby="finance-rent-tab">
                  <div class="card-body" style="padding: 0.1rem;">
                    <form id="rent-select-month" method="GET">
                      <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Месяц</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="rent_month" onChange="$('#rent-select-month').submit()">
                            <?php
                              $curr_month = date("m");
                              $curr_year = date("Y");
                              $start_month = $curr_month - 12;
                              if ($start_month < 1) {
                                $start_month = (12 - ($curr_month - 12));
                                $start_year = $curr_year - 1;
                              }
                              $is_selected = 0;
                              for ($i = $start_month; $i <= $start_month + 12; $i++) {
                                if ($i > 12) {
                                  $echo_month = $i - 12;
                                  $echo_year = $start_year + 1;
                                } else {
                                  $echo_month = $i;
                                  $echo_year = $start_year;
                                }

                                //var_dump($is_selected);

                                if ((($echo_month == date("m") && $echo_year == date("Y")) || ($echo_month == date("m", strtotime($_GET['rent_month'].'-01')) && $echo_year == date("Y", strtotime($_GET['rent_month'].'-01')))) && $is_selected == 0) {
                                  $selected = 'selected';
                                  $is_selected = 1;
                                } else {
                                  $selected = '';
                                }
                                echo '<option '.$selected.' value="'.$echo_year.'-'.$echo_month.'">'.$core->getMonthName($echo_month).' '.$echo_year.'</option>';

                              }
                            ?>

                          </select>
                        </div>
                      </div>
                    </form>
                            <div class="table-responsive">
                              <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                  <tr>

                                    <th scope="col" class="text-left">Салон</th>
                                    <th scope="col" class="text-center">Дата<br>оплаты</th>
                                    <th scope="col" class="text-center">Нал/<br>Бнал</th>
                                    <th scope="col" class="text-center">Сумма<br>аренды</th>
                                    <th scope="col" class="text-center">Оплачено<br>аренды</th>
                                    <th scope="col" class="text-center">Сумма<br>комм.</th>
                                    <th scope="col" class="text-center">Оплачено<br>комм.</th>
                                    <th scope="col" class="text-center">Карта/тел.<br>для оплаты</th>
                                    <th scope="col" class="text-center">ИП/ООО</th>

                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($salons as $salon_payments) { ?>
                                    <?php if ($salon_payments['rent_amount'] || $salon_payments['communal_amount']) { ?>
                                      <?php
                                        $tooltip_rent = '';
                                        $tooltip_communal = '';

                                        if (isset($_GET['rent_month'])) {
                                          $tooltip_data_month = date("m", strtotime($_GET['rent_month'].'-01'));
                                          $tooltip_data_year = date("Y", strtotime($_GET['rent_month'].'-01'));
                                        } else {
                                          $tooltip_data_month = date("m");
                                          $tooltip_data_year = date("Y");
                                        }


                                        $tooltip_data = $db->getAll("SELECT * FROM finance_journal WHERE salon = ?i AND date between ?s AND ?s AND is_del = 0",
                                            $salon_payments['id'],
                                            $tooltip_data_year.'-'.$tooltip_data_month.'-01 00:00:00',
                                            $tooltip_data_year.'-'.$tooltip_data_month.'-'.date("t", strtotime($tooltip_data_year.'-'.$tooltip_data_month.'-01 00:00:00')).' 23:59:59');

                                        foreach ($tooltip_data as $value) {

                                          if ($value['op_decryption'] == 'Аренда') {
                                            $tooltip_rent .= date("d.m.y H:i", strtotime($value['date'])).' | '.$value['amount'].'<br>';
                                          } else if ($value['op_decryption'] == 'Ком- платежи') {
                                            $tooltip_communal .= date("d.m.y H:i", strtotime($value['date'])).' | '.$value['amount'].'<br>';
                                          }
                                        }

                                      ?>
                                      <tr>
                                        <td scope="col" class="text-left"><?=$salon_payments['name']?></td>
                                        <td scope="col" class="text-center"><?=$salon_payments['rent_day_pay']?></td>
                                        <td scope="col" class="text-center">
                                          <?php if ($salon_payments['rent_type'] == 0) {echo 'Н';} else {echo 'Б';} ?>
                                        </td>
                                        <td scope="col" class="text-center rent-amount-<?=$i?>"><?=$salon_payments['rent_amount']?></td>

                                        <td scope="col" id="rent-payments-<?=$i?>-<?=$salon_payments['id']?>" class="text-center" ><?=$tooltip_rent?></td>

                                        <td scope="col" class="text-center commumal-amount-<?=$i?>"><?=$salon_payments['communal_amount']?></td>

                                        <td scope="col" id="commumal-payments-<?=$i?>-<?=$salon_payments['id']?>" class="text-center " ><?=$tooltip_communal?></td>

                                        <td scope="col" class="text-center"><?=$salon_payments['payment_card']?></td>
                                        <td scope="col" class="text-center"><?=$salon_payments['payment_person']?></td>
                                      </tr>
                                    <?php } ?>
                                  <?php } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

  <script>
    function openModalAddOperation() {
      addSalonId = $('#salon').val();
      $("#opSalon option[value='"+addSalonId+"']").attr("selected", "selected");
      $('#addOperation').modal('show');
    }

  <?php if (isset($_COOKIE['finTab'])) { ?>
    activaTab('<?=$_COOKIE['finTab']?>');
  <?php } ?>



  function activaTab(tab){
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
  };

  function editOperation(opId) {
    //console.log(opId);
    $.post(
      "/pages/cab/ajax/loadOpData.php",
      { id: opId },
      onAjaxSuccess
    );

    function onAjaxSuccess(data)
    {
      result = JSON.parse(data);
      if (result.status == 'OK') {
        document.getElementById('editOperationBody').innerHTML = result.response.html;
        $('#editOperation').modal('show');
        loadChart();
      } else {
        Swal.fire({
          title: 'Ошибка!',
          text: result.error,
          type: 'error',
          confirmButtonText: 'ОК'
        })
      }
    }
  }

    var descriptoins = JSON.parse('<?=$descriptions?>');

    function loadDescriptions() {
      type = document.getElementById("opType").value;
      descr = document.getElementById("opDesc");
      descr.innerHTML = '';
      for (key in descriptoins[type]) {
        descr.innerHTML += '<option value="'+key+'">'+descriptoins[type][key]+'</option>';
      }

      loadDescParams($("#opDesc").val());
    }

    function loadDescParams(value) {
      //console.log(value);
		/*
      $.post(
        "/pages/cab/ajax/loadFinDescParams.php",
        { descId: value },
        onAjaxSuccess
      );

      function onAjaxSuccess(data)
      {
        console.log(data);
        result = JSON.parse(data);

        console.log(result);

        if (result.status == 'OK') {

          //opDescParams
          console.log(result.response.html);
          $('#opDescParams').html(result.response.html);

        } else {
          Swal.fire({
            title: 'Ошибка!',
            text: result.error,
            type: 'error',
            confirmButtonText: 'ОК'
          })
        }
      }*/
    }

    function loadDescriptionsFilter() {
      type = document.getElementById("type").value;
      descr = document.getElementById("description");
      descr.innerHTML = '<option value="0">Все</option>';
      <?php if (isset($filter['description'])) { ?>
      selectedDescr = '<?=$filter['description']?>';
      <?php } else { ?>
      selectedDescr = '';
      <?php } ?>

      for (key in descriptoins[type]) {
        if (selectedDescr == descriptoins[type][key]) {
          descr.innerHTML += '<option value="'+descriptoins[type][key]+'" selected>'+descriptoins[type][key]+'</option>';
        } else {
          descr.innerHTML += '<option value="'+descriptoins[type][key]+'">'+descriptoins[type][key]+'</option>';
        }
      }
    }

    $(document).ready(function(){

        loadDescriptions();
        loadDescriptionsFilter();
        loadFinData();
    })

    function loadChart() {
      $.post(
        "/pages/cab/ajax/loadFinChart.php",
        $("#formChart").serialize()+'&'+$("#finForm").serialize(),
        onAjaxSuccess
      );

      function onAjaxSuccess(data)
      {
        result = JSON.parse(data);

        if (result.status == 'OK') {
          var options = {
              chart: {
                  height: 350,
                  type: 'line',
                  zoom: {
                    enabled: false,
                  },
                  toolbar: {
                    show: false,
                    autoSelected: 'zoom'
                  }
              },
              series: [
                {
                  name: result.response.chart.element,
                  data: result.response.chart.data
                },{
                  name: result.response.chart.element1,
                  data: result.response.chart.data1
                }
              ],
              dataLabels: {
                  enabled: true
              },
              stroke: {
                  curve: 'straight'
              },
              title: {
                  text: result.response.chart.title,
                  align: 'left'
              },
              xaxis: {
                  categories: result.response.chart.categories,
              },
              grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
              },
              markers: {
                size: 4
              },
          }

          document.getElementById('finChart').innerHTML = '';
          var chart = new ApexCharts(
              document.querySelector("#finChart"),
              options
          );
          chart.render()
        } else {
          Swal.fire({
            title: 'Ошибка!',
            text: result.error,
            type: 'error',
            confirmButtonText: 'ОК'
          })
        }
      }
    }

    function setCookieFilter() {
      filterData = $("#finForm").serialize();
      document.cookie='finFilter='+filterData;
    }

    function loadFinData() {

      setCookieFilter();
      $.post(
        "/pages/cab/ajax/loadFinData.php",
        $("#finForm").serialize(),
        onAjaxSuccess
      );

      function onAjaxSuccess(data)
      {
		console.log(data);
        result = JSON.parse(data);

        if (result.status == 'OK') {
          document.getElementById('table-operations').innerHTML = result.response.operations;
          loadChart();
        } else {
          Swal.fire({
            title: 'Ошибка!',
            text: result.error,
            type: 'error',
            confirmButtonText: 'ОК'
          })
        }
      }
    }
	
	function showOpHistory(id) {
	  $.post(
        "/pages/cab/ajax/loadOpHistory.php",
        {opId: id},
        onAjaxSuccess
      );
	  
	  function onAjaxSuccess(data)
      {

		console.log(data);
		
		result = JSON.parse(data);
		
		$('#opHistory').modal('show');
		$('#opHistoryBody').html(result.response);
		

        
      }
	}


  </script>

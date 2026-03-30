

<div class="main-content">

  <style>
  #tooltip {
    z-index: 9999;
    position: absolute;
    display: none;
    top:0px;
    left:0px;
    width: 250px;
    background-color: #fff;
    padding: 5px 10px 5px 10px;
    color: #000;
    border: 1px solid #888;
    border-radius: 5px;
    box-shadow: 0 1px 2px #555;
    box-sizing: ;
  }
  </style>



  <script>

  $(function(){
      $("[data-tooltip]").mousemove(function (eventObject) {
          $data_tooltip = $(this).attr("data-tooltip");
          $("#tooltip").html($data_tooltip).css({
                "top" : (eventObject.pageY / 2) + 150,
                "left" : eventObject.pageX / 2
              }).show();

          }).mouseout(function () {
            $("#tooltip").hide()
              .html("");
      });
});

    function renewProgressPayment(month) {
      rentSum = 0;
      $(".rent-amount-"+month).each(function() {
        thisValue = parseFloat($(this).html());
        if (!isNaN(thisValue) && thisValue != 0) {
          rentSum += thisValue;
        }
      });

      rentPayments = 0;
      $(".rent-payments-"+month).each(function() {
        thisValue = parseFloat($(this).html());
          console.log($(this).html());
        if (!isNaN(thisValue) && thisValue != 0) {
          rentPayments += thisValue;
        }
      });

      communalSum = 0;
      $(".commumal-amount-"+month).each(function() {
        thisValue = parseFloat($(this).html());
        if (!isNaN(thisValue) && thisValue != 0) {
          communalSum += thisValue;
        }
      });

      communalPayments = 0;
      $(".commumal-payments-"+month).each(function() {
        thisValue = parseFloat($(this).html());
        if (!isNaN(thisValue) && thisValue != 0) {
          communalPayments += thisValue;
        }
      });

      countSum = rentSum + communalSum;
      countPayments = rentPayments + communalPayments;

      percent = ((100 * countPayments) / countSum).toFixed();


      if (percent < 50) {
        bgColor = 'red';
      } else if (percent >= 50 && percent < 100) {
        bgColor = 'orange';
      } else {
        bgColor = 'green';
      }

      $('#progress'+month).css("width", percent+"%");
      $('#progress'+month).css("background-color", bgColor);

      $('#count_sum'+month).html("Аренда: "+rentPayments+" из "+rentSum+" Остаток: "+ (rentSum - rentPayments) +" | Комм. платежи: "+communalPayments+" из "+communalSum+" Остаток: "+ (communalSum - communalPayments));

    }
  </script>
    <!-- Top navbar -->
    <?php include ('tpl/cab/tpl_header.tpl'); ?>
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <?php if (isset($msg)) { ?>
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
    <!-- Page content -->
    <div class="container-fluid mt--7">

      <div class="row">
        <div class="col-sm-12">
          <div class="card shadow">

            <div class="card-header border-0">
              <div class="row align-items-center">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#salons-list" role="tab" aria-controls="salons-list" aria-selected="true">Список салонов</a>
                  </li>
                  <!--li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#salons-payments" role="tab" aria-controls="salons-payments" aria-selected="false">Платежи</a>
                  </li-->
                </ul>
                <div class="col text-right">



                </div>

              </div>
            </div>


            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="salons-list" role="tabpanel" aria-labelledby="salons-list-tab">

                <div class="row" style="margin-left: 5px;">
                  <div class="col-md-2">
                    <a href="new_salon" class="btn btn-sm btn-primary" style="margin-bottom: 10px;">Добавить салон</a>
                  </div>

                <?php if ($user_profile['edit_salons']) { ?>

                  <div class="col-md-2">
                    <a href="salons_fields" class="btn btn-sm btn-primary" style="margin-bottom: 10px;">Настройка полей</a>
                  </div>
                </div>
                <?php } ?>

                <div class="table-responsive">
                  <!-- Projects table -->
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" style="width: 20px;">#</th>
                        <th scope="col" class="text-left">Салон</th>
                        <?php foreach ($fields as $field) { ?>
                          <th scope="col" ><?=$field['name']?></th>
                        <?php } ?>

                        <th style="width: 20px;"></th>
                        <th style="width: 20px;"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($salons as $salon) { ?>
                      <tr>
                        <th scope="row"><?=$salon['id']?></th>
                        <td class="text-left"><a href="/cab/salon_edit?id=<?=$salon['id']?>" ><?=$salon['name']?></a></td>
                        <?php foreach ($fields as $field) { ?>
                          <td scope="col" style="max-width: 200px; overflow: hidden; white-space: break-spaces;"><?=$core->getSalonFieldValue($salon['id'], $field['id'])?></td>
                        <?php } ?>
                        <td>
                          <a href="/cab/salon_edit?id=<?=$salon['id']?>" class="mdc-button mdc-button--unelevated">
                            <?php if ($user_profile['edit_salons']) { ?>
                            <i class="fas fa-edit"></i>
                            <?php } else { ?>
                            <i class="far fa-eye"></i>
                            <?php } ?>
                          </a>
                        </td>
                        <td>
                          <?php if ($user_profile['edit_salons']) { ?>
                          <a href="/cab/salons?a=del&id=<?=$salon['id']?>"class="mdc-button mdc-button--unelevated secondary-filled-button mdc-ripple-upgraded">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php } ?>

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="salons-payments" role="tabpanel" aria-labelledby="salons-payments-tab">
                <div id="accordion">


                  <?php for ($i=(date("m") - 3); $i <= date("m"); $i++ ) { ?>
                    <?php if ($i == date("m")) { $show = 'show'; } else { $show = ''; } ?>
                    <div class="card">
                      <div class="card-header" id="heading<?=$i?>" style="padding-top: 0; padding-bottom: 0;">
                        <div class="row">
                          <div class="col-mb-2">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?=$i?>" aria-expanded="false" aria-controls="collapse<?=$i?>" style="width: 200px;    text-align: left;">
                                <?=$core->getMonthName($i)?> <?=date("Y")?>
                              </button>
                            </h5>
                          </div>
                          <div class="col-mb-4" style="width: 200px; padding-top: 17px;">
                            <div class="progress">
                              <div id="progress<?=$i?>" class="progress-bar " role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                          <div class="col-mb-6" style="padding-top: 10px; padding-left: 20px; font-size: 14px;" id="count_sum<?=$i?>">
                            Фонд аренды: 50 000 | Комм. платежи: 40 000
                          </div>
                        </div>

                      </div>
                      <div id="collapse<?=$i?>" class="collapse <?=$show?>" aria-labelledby="heading<?=$i?>" data-parent="#accordion">
                        <div class="card-body">
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
                                      $tooltip_data = $db->getAll("SELECT * FROM salons_payments WHERE payment_salon_id = ?i AND payment_date between ?s AND ?s ",
                                      $salon_payments['id'],
                                      date("Y").'-'.$i.'-01 00:00:00',
                                      date("Y").'-'.$i.'-'.date("t", strtotime(date("Y").'-'.$i.'-01 00:00:00')).' 23:59:59');
                                      foreach ($tooltip_data as $value) {
                                        if ($value['payment_type'] == 1) {
                                          $tooltip_rent .= date("d.m.y H:i", strtotime($value['payment_date'])).' | '.$value['payment_amount'].'<br>';
                                        } else {
                                          $tooltip_communal .= date("d.m.y H:i", strtotime($value['payment_date'])).' | '.$value['payment_amount'].'<br>';
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
                                      <td scope="col" id="rent-payments-<?=$i?>-<?=$salon_payments['id']?>" class="text-center" style="cursor:copy;"><span data-tooltip="<?=$tooltip_rent?>" class="rent-payments-<?=$i?>" onClick="changeRentPayments(<?=$i?>, <?=$salon_payments['id']?>)"><?=$core->getSalonRentSum($salon_payments['id'], $i, date("Y"))?></span></td>
                                      <td scope="col" class="text-center commumal-amount-<?=$i?>"><?=$salon_payments['communal_amount']?></td>
                                      <td scope="col" id="commumal-payments-<?=$i?>-<?=$salon_payments['id']?>" class="text-center " style="cursor:copy;"><span data-tooltip="<?=$tooltip_communal?>" class="commumal-payments-<?=$i?>" onClick="changeCommunalPayments(<?=$i?>, <?=$salon_payments['id']?>)"><?=$core->getSalonCommunalSum($salon_payments['id'], $i, date("Y"))?></span></td>
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
                    <div id="tooltip"></div>
                    <script>

                      renewProgressPayment(<?=$i?>);
                    </script>
                  <?php } ?>

                  <script>
                  function changeRentPayments(month, salon) {
                    $('#rent-payments-'+month+'-'+salon).html('<form method="POST" onSubmit="savePayments(this); return false;">+ <input type="hidden" name="rentMonth" value="'+month+'"> <input type="hidden" name="rentSalon" value="'+salon+'"> <input type="hidden" name="paymentType" value="1"> <input name="rentPayment" style="width: 60px; margin-left: 5px; margin-right: 5px;"  type="text" /><button type="submit" class="btn btn-outline-primary btn-sm" title="Сохранить"><i class="fas fa-save"></i></button></form>');

                  }

                  function savePayments(form) {

                    $.post(
                      "/pages/cab/ajax/saveRentPayments.php",
                      $(form).serialize(),
                      onAjaxSuccess
                    );

                    function onAjaxSuccess(data)
                    {
                      console.log(data);
                      result = JSON.parse(data);
                      console.log(result);

                      if (result.status == 'OK') {
                        $(form).parent().html(result.response.html);
                        renewProgressPayment(result.response.month);
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

                  function changeCommunalPayments(month, salon) {
                    $('#commumal-payments-'+month+'-'+salon).html('<form method="POST" onSubmit="savePayments(this); return false;">+ <input type="hidden" name="rentMonth" value="'+month+'"> <input type="hidden" name="rentSalon" value="'+salon+'"> <input type="hidden" name="paymentType" value="2"> <input name="rentPayment" style="width: 60px; margin-left: 5px; margin-right: 5px;"  type="text" /><button type="submit" class="btn btn-outline-primary btn-sm" title="Сохранить"><i class="fas fa-save"></i></button></form>');
                  }
                  </script>

                  <!---------------------------------------->

                  <!--
                  <div class="card">
                    <div class="card-header" id="headingOne">
                      <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="width: 200px;    text-align: left;">
                          Февраль 2021
                        </button>
                        <i class="far fa-money-bill-alt" style="font-size: 2em; margin-top: 9px; position: fixed; color: green;"></i>
                      </h5>
                    </div>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header" id="headingTwo">
                      <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="width: 200px;    text-align: left;">
                          Март 2021
                        </button>
                        <i class="far fa-money-bill-alt" style="font-size: 2em; margin-top: 9px; position: fixed; color: orange;"></i>
                      </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                      <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header" id="headingThree">
                      <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="width: 200px;    text-align: left;">
                          Апрель 2021
                        </button>
                        <i class="far fa-money-bill-alt" style="font-size: 2em; margin-top: 9px; position: fixed; color: red;"></i>
                      </h5>
                    </div>
                    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
                      <div class="card-body">
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
                              <tr>
                                <td scope="col" class="text-left">Сипягина 34</td>
                                <td scope="col" class="text-center">1 - 10</td>
                                <td scope="col" class="text-center">Н</td>
                                <td scope="col" class="text-center">50 000</td>
                                <td scope="col" class="text-center">40 000</td>
                                <td scope="col" class="text-center">--</td>
                                <td scope="col" class="text-center">0</td>
                                <td scope="col" class="text-center">4276300040187799</td>
                                <td scope="col" class="text-center">ИП Варданян Арамис</td>
                              </tr>
                              <tr>
                                <td scope="col" class="text-left">Сипягина 34</td>
                                <td scope="col" class="text-center">1 - 10</td>
                                <td scope="col" class="text-center">Н</td>
                                <td scope="col" class="text-center">50 000</td>
                                <td scope="col" class="text-center">40 000</td>
                                <td scope="col" class="text-center">--</td>
                                <td scope="col" class="text-center">0</td>
                                <td scope="col" class="text-center">4276300040187799</td>
                                <td scope="col" class="text-center">ИП Варданян Арамис</td>
                              </tr>
                              <tr>
                                <td scope="col" class="text-left">Сипягина 34</td>
                                <td scope="col" class="text-center">1 - 10</td>
                                <td scope="col" class="text-center">Н</td>
                                <td scope="col" class="text-center">50 000</td>
                                <td scope="col" class="text-center">40 000</td>
                                <td scope="col" class="text-center">--</td>
                                <td scope="col" class="text-center">0</td>
                                <td scope="col" class="text-center">4276300040187799</td>
                                <td scope="col" class="text-center">ИП Варданян Арамис</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  -->
                </div>
              </div>
            </div>



          </div>
        </div>


      </div>
    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

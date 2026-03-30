<div class="main-content">
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
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Редактирование салона</h3>
                </div>
                <div class="col text-right">
                  <?php if (!$disabled) { ?>
                  <a href="#" class="btn btn-sm btn-primary" onClick="document.getElementById('salonEdit').submit()">Сохранить</a>
                  <?php } ?>
                  <a href="#" class="btn btn-sm btn-primary" onClick="window.location='salons'">Закрыть</a>
                </div>

              </div>
            </div>
            <div style="padding-left: 20px; padding-right: 20px;">
            <form id="salonEdit" method="POST" action="?a=save&id=<?=$salon_data['id']?>">
              <div class="row" style="padding-bottom: 20px;">
                <div class="col-md-6">

                  <div class="form-group" style="margin-bottom: 1.5rem !important;">
                    <div class="custom-control custom-switch">
                      <input name="franchising" type="checkbox" value="1" class="custom-control-input" id="customSwitch_edit_franchising" <?php if ($salon_data['franchising']) echo 'checked';?> <?=$disabled?> >
                      <label class="custom-control-label" for="customSwitch_edit_franchising">Франчайзи</label>
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="salonName">Название салона</label>
                    <input type="text" name="salonName" id="salonName" placeholder="Название салона" class="form-control" value="<?=$salon_data['name']?>" <?=$disabled?> />
                  </div>

                  <div class="form-group">
                    <label for="rent_day_pay">Дата оплаты аренды</label>
                    <input type="text" name="rent_day_pay" id="rent_day_pay" class="form-control" value="<?=$salon_data['rent_day_pay']?>" <?=$disabled?> />
                  </div>

                  <div class="form-group">
                    <label for="rent_amount">Сумма аренды</label>
                    <input type="nubmer" name="rent_amount" id="rent_amount" class="form-control" value="<?=$salon_data['rent_amount']?>" <?=$disabled?> />
                  </div>
                  
                  <?php
                  if ($salon_data['rent_type'] == 0) {
                    $check_r_1 = 'checked';
                    $check_r_2 = '';
                  } else {
                    $check_r_1 = '';
                    $check_r_2 = 'checked';
                  }
                  ?>

                  <fieldset class="form-group">
                    <div class="row">
                      <legend class="col-form-label col-sm-4 pt-0">Тип оплаты</legend>
                      <div class="col-sm-8">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="rent_type" id="gridRadios1" value="0" <?=$check_r_1?>>
                          <label class="form-check-label" for="gridRadios1">
                            Наличные
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="rent_type" id="gridRadios2" value="1" <?=$check_r_2?>>
                          <label class="form-check-label" for="gridRadios2">
                            Безнал
                          </label>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  <div class="form-group">
                    <label for="communal_amount">Сумма комм. платежей</label>
                    <input type="nubmer" name="communal_amount" id="communal_amount" class="form-control" value="<?=$salon_data['communal_amount']?>" <?=$disabled?> />
                  </div>

                  <div class="form-group">
                    <label for="payment_card">Карта/телефон для оплаты</label>
                    <input type="text" name="payment_card" id="payment_card" class="form-control" value="<?=$salon_data['payment_card']?>" <?=$disabled?> />
                  </div>

                  <div class="form-group">
                    <label for="payment_person">ИП / ООО</label>
                    <input type="text" name="payment_person" id="payment_person" class="form-control" value="<?=$salon_data['payment_person']?>" <?=$disabled?> />
                  </div>

                  <hr>



                  <?php foreach ($fields_list as $field) { ?>
                    <div class="form-group">
                      <label for="salonFields<?=$field['id']?>"><?=$field['name']?></label>
                      <input type="text" name="salonFields[<?=$field['id']?>]" id="salonFields<?=$field['id']?>" placeholder="<?=$field['name']?>" class="form-control" value="<?=$core->getSalonFieldValue($salon_data['id'], $field['id'])?>" <?=$disabled?> />
                    </div>
                  <?php } ?>
                </div>
              </div>

              <div class="row"></div>

            </form>
            </div>
          </div>
        </div>

      </div>
    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

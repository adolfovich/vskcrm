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
      <?php if (!$error_open) { ?>
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Редактирование профиля: <?=$profile_data['name']?></h3>
                </div>
                <div class="col text-right">
                  <a href="#" class="btn btn-sm btn-primary" onClick="document.getElementById('profileEdit').submit()">Сохранить</a>
                  <a href="#" class="btn btn-sm btn-primary" onClick="window.location='users'">Закрыть</a>
                </div>

              </div>
            </div>
            <div style="padding-left: 20px; padding-right: 20px;">
            <form id="profileEdit" method="POST" action="?a=save&id=<?=$profile_data['id']?>">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" name="profileName" id="userName" placeholder="Название профиля" value="<?=$profile_data['name']?>">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="card-header border-0">
                    <div class="row align-items-center">
                      <div class="col">
                        <h3 class="mb-0">Разрешения:</h3>
                      </div>

                    </div>
                  </div>
                  <?php foreach ($menu as $value) {?>
                    <?php if (in_array($value['id'], $access)) {$checked = 'checked';} else {$checked = '';} ?>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input name="access[]" type="checkbox" value="<?=$value['id']?>" class="custom-control-input" id="customSwitch<?=$value['id']?>" <?=$checked?>>
                          <label class="custom-control-label" for="customSwitch<?=$value['id']?>"><?=$value['name']?></label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input name="edit_salons" type="checkbox" value="1" class="custom-control-input" id="customSwitch_edit_salons" <?php if ($profile_data['edit_salons']) echo 'checked';?>>
                          <label class="custom-control-label" for="customSwitch_edit_salons">Может редактировать салоны</label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input name="edit_education" type="checkbox" value="1" class="custom-control-input" id="customSwitch_editEdu" <?php if ($profile_data['edit_education']) echo 'checked';?>>
                          <label class="custom-control-label" for="customSwitch_editEdu">Редактирование раздела "Обучение"</label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input name="edit_finance" type="checkbox" value="1" class="custom-control-input" id="customSwitch_editFin" <?php if ($profile_data['edit_finance']) echo 'checked';?>>
                          <label class="custom-control-label" for="customSwitch_editFin">Редактирование раздела "Финансы"</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card-header border-0">
                    <div class="row align-items-center">
                      <div class="col">
                        <h3 class="mb-0">Доступные статистики:</h3>
                      </div>
                    </div>
                  </div>

                  <?php foreach ($statistics as $value) {?>
                    <?php if (in_array($value['id'], $stat_access)) {$checked = 'checked';} else {$checked = '';} ?>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input name="stat_access[]" type="checkbox" value="<?=$value['id']?>" class="custom-control-input" id="customSwitchStat<?=$value['id']?>" <?=$checked?>>
                          <label class="custom-control-label" for="customSwitchStat<?=$value['id']?>"><?=$value['name']?></label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="card-header border-0">
                    <div class="row align-items-center">
                      <div class="col">
                        <h3 class="mb-0">Задачи:</h3>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input name="change_ticket_status" type="checkbox" value="1" class="custom-control-input" id="customSwitch_changeTicket" <?php if ($profile_data['change_ticket_status']) echo 'checked';?>>
                          <label class="custom-control-label" for="customSwitch_changeTicket">Может измениять статусы задач</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input name="change_close_tickets" type="checkbox" value="1" class="custom-control-input" id="customSwitch_changeCloseTicket" <?php if ($profile_data['change_close_tickets']) echo 'checked';?>>
                          <label class="custom-control-label" for="customSwitch_changeCloseTicket">Может измениять закрытые задачи</label>
                        </div>
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input name="delete_tickets" type="checkbox" value="1" class="custom-control-input" id="customSwitch_delTicket" <?php if ($profile_data['delete_tickets']) echo 'checked';?>>
                          <label class="custom-control-label" for="customSwitch_delTicket">Может удалять задачи</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card-header border-0">
                    <div class="row align-items-center">
                      <div class="col">
                        <h3 class="mb-0">Доступные статусы задач:</h3>
                      </div>
                    </div>
                  </div>
                  <?php foreach ($tickets_statuses as $tickets_status) { ?>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input name="accepted_ticket_statuses[]" type="checkbox" value="<?=$tickets_status['id']?>" class="custom-control-input" id="customSwitch_ticketStatus<?=$tickets_status['id']?>" <?php if (in_array($tickets_status['id'],$accepted_statuses) || $profile_data['accepted_ticket_statuses'] == 0) echo 'checked';?>>
                          <label class="custom-control-label" for="customSwitch_ticketStatus<?=$tickets_status['id']?>"><?=$tickets_status['name']?></label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>

                </div>
              </div>
            </div>
            </div>
            </form>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>

  </div>

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

    <div class="modal" id="addStatus"  tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form id="addStatusForm" method="POST">
          <input type="hidden" name="action_type" value="add_status">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Новый статус</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group" >
                <label for="statusName">Название</label>
                <input type="text" name="statusName" class="form-control" id="statusName" placeholder="Название" value="<?php if(isset($_POST['statusName'])) echo $_POST['statusName']; ?>">
              </div>

              <div class="form-group">
                <label for="statusColor">Цвет</label>
                <input type="color" name="statusColor" class="form-control" id="statusColor" placeholder="" value="<?php if(isset($_POST['statusColor'])) echo $_POST['statusColor']; ?>">
              </div>

              <div class="form-group">
                <label for="statusNext">След. статусы</label>
              </div>

              <?php foreach($statuses as $status) { ?>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="statusNext[]" value="<?=$status['id']?>">
                <label class="form-check-label" for="exampleCheck1"><?=$status['name']?></label>
              </div>
              <?php } ?>

            </div>
            <div class="modal-error text-danger">
              <?php if (isset($msg) && $msg['type'] == 'error') { echo $msg['text']; } ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
              <button type="submit" class="btn btn-primary submit" >Сохранить</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal" id="editStatus"  tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form id="editStatusForm" method="POST">
          <input type="hidden" name="action_type" value="edit_status">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Изменить статус</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="editStatusBody">

            </div>
            <div class="modal-error text-danger">
              <?php if (isset($msg) && $msg['type'] == 'error') { echo $msg['text']; } ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
              <button type="submit" class="btn btn-primary submit" >Сохранить</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-sm-12">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col-md-8">
                  <h3 class="mb-0">Статусы заявок</h3>
                </div>
                <div class="col-md-4 text-right">
                  <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addStatus">Новый статус</button>
                  <a href="tickets_settings" class="btn btn-primary mb-2" >Закрыть</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-sm" style="max-width: 60%;">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" style="text-align: center;">Названме</th>
                    <th scope="col" style="text-align: center;">Цвет</th>
                    
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="table-striped">
                  <?php $i = 1; ?>
                  <?php foreach ($statuses as $status) { ?>
                    <tr>
                      <td style="text-align: center;"><?=$status['name']?></td>
                      <td style="text-align: center;"><span
                        class="status"
                        style="color:<?=$status['color']?>; background-color:<?=$core->hex2rgba($status['color'], 0.3)?>">
                          <?=$status['name']?>
                      </span></td>

                      <td style="text-align: center;">
                        <?php if ($i == 1) { ?>
                          <a href="?sort=down&status_id=<?=$status['id']?>"><i class="fas fa-chevron-down"></i></a>
                        <?php } else if ($i == count($statuses)) { ?>
                          <a href="?sort=up&status_id=<?=$status['id']?>"><i class="fas fa-chevron-up"></i></a>
                        <?php } else { ?>
                          <a href="?sort=down&status_id=<?=$status['id']?>"><i class="fas fa-chevron-down"></i></a>
                          &nbsp;
                          <a href="?sort=up&status_id=<?=$status['id']?>"><i class="fas fa-chevron-up"></i></a>
                        <?php } ?>
                      </td>
                      <td style="text-align: center;">
                        <a href="#" class="btn btn-outline-primary btn-sm" title="Редактировать" onClick="openModalEditStatus(<?=$status['id']?>);">
                            <i class="fas fa-edit"></i>
                        </a>
                      </td>
                      <td style="text-align: center;">
                        <a href="?delete&status_id=<?=$status['id']?>" class="btn btn-outline-danger btn-sm" title="Удалить">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                      </td>
                    </tr>
                    <?php $i++; ?>
                  <?php } ?>
                </tbody>
              </table>
              <script>
                function openModalEditStatus(statusId) {
                  $.post(
                    "/pages/cab/ajax/loadStatusData.php?id="+statusId,

                    onAjaxSuccess
                  );

                  function onAjaxSuccess(data)
                  {
                    console.log(data);

                    result = JSON.parse(data);

                    if (result.status == 'OK') {
                      document.getElementById('editStatusBody').innerHTML = result.response.html;
                      $('#editStatus').modal('show');
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
              </script>
            </div>
          </div>
        </div>
        <div class="col-sm-4">

        </div>
      </div>

    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

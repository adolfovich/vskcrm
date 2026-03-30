



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
          <input type="hidden" name="action_type" value="add_type">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Новый тип заявки</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group" >
                <label for="typeName">Название</label>
                <input type="text" name="typeName" class="form-control" id="typeName" placeholder="Название" value="<?php if(isset($_POST['typeName'])) echo $_POST['typeName']; ?>">
              </div>


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


    <div class="modal" id="editType"  tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form id="editTypeForm" method="POST">
          <input type="hidden" name="action_type" value="edit_type">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Изменить тип заявки</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="editTypeBody">

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
                  <h3 class="mb-0">Типы заявок</h3>
                </div>
                <div class="col-md-4 text-right">
                  <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addStatus">Новый тип</button>
                  <a href="tickets_settings" class="btn btn-primary mb-2" >Закрыть</a>
                </div>

              </div>
            </div>

            <div class="card-body">

              <table class="table table-sm" style="max-width: 60%;">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" style="text-align: center;">Название</th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="table-striped">
                  <?php $i = 1; ?>
                  <?php foreach ($types as $type) { ?>
                    <tr>
                      <td style="text-align: center;"><?=$type['name']?></td>


                      <td style="text-align: center;">
                        <a href="#" class="btn btn-outline-primary btn-sm" title="Редактировать" onClick="openModalEditType(<?=$type['id']?>);">
                            <i class="fas fa-edit"></i>
                        </a>
                      </td>
                      <td style="text-align: center;">
                        <a href="?delete&type_id=<?=$type['id']?>" class="btn btn-outline-danger btn-sm" title="Удалить">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                      </td>
                    </tr>
                    <?php $i++; ?>
                  <?php } ?>
                </tbody>
              </table>
              <script>
                function openModalEditType(typeId) {
                  $.post(
                    "/pages/cab/ajax/loadTypeData.php?id="+typeId,

                    onAjaxSuccess
                  );

                  function onAjaxSuccess(data)
                  {
                    console.log(data);

                    result = JSON.parse(data);

                    if (result.status == 'OK') {
                      document.getElementById('editTypeBody').innerHTML = result.response.html;
                      $('#editType').modal('show');
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

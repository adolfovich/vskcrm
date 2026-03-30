



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


    <div class="modal" id="add"  tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form id="addForm" method="POST">
          <input type="hidden" name="action_type" value="add">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Новый поставщик</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group" >
                <label for="providerName">Название</label>
                <input type="text" name="providerName" class="form-control" id="providerName" placeholder="Название" value="<?php if(isset($_POST['providerName'])) echo $_POST['providerName']; ?>">
              </div>

              <div class="form-group" >
                <label for="providerDescription">Описание</label>
                <input type="text" name="providerDescription" class="form-control" id="providerDescription" placeholder="Описание" value="<?php if(isset($_POST['providerDescription'])) echo $_POST['providerDescription']; ?>">
              </div>

              <div class="form-group" >
                <label for="providerEmail">Email</label>
                <input type="text" name="providerEmail" class="form-control" id="providerEmail" placeholder="Email" value="<?php if(isset($_POST['providerEmail'])) echo $_POST['providerEmail']; ?>">
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


    <div class="modal" id="edit"  tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form id="editForm" method="POST">
          <input type="hidden" name="action_type" value="edit">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Изменить поставщика</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="editBody">

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
                  <h3 class="mb-0">Поставщики</h3>
                </div>
                <div class="col-md-4 text-right">
                  <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#add">Новый поставщик</button>
                  <a href="tickets_settings" class="btn btn-primary mb-2" >Закрыть</a>
                </div>

              </div>
            </div>

            <div class="card-body">

              <table class="table table-sm" style="max-width: 60%;">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" style="text-align: center;">Название</th>
                    <th scope="col" style="text-align: center;">Описание</th>
                    <th scope="col" style="text-align: center;">Email</th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="table-striped">
                  <?php $i = 1; ?>
                  <?php foreach ($providers as $provider) { ?>
                    <tr>
                      <td style="text-align: center;"><?=$provider['name']?></td>
                      <td style="text-align: center;"><?=$provider['desctiption']?></td>
                      <td style="text-align: center;"><?=$provider['email']?></td>

                      <td style="text-align: center;">
                        <a href="#" class="btn btn-outline-primary btn-sm" title="Редактировать" onClick="openModalEditProvider(<?=$provider['id']?>);">
                            <i class="fas fa-edit"></i>
                        </a>
                      </td>
                      <td style="text-align: center;">
                        <a href="?delete&provider_id=<?=$provider['id']?>" class="btn btn-outline-danger btn-sm" title="Удалить">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                      </td>
                    </tr>
                    <?php $i++; ?>
                  <?php } ?>
                </tbody>
              </table>
              <script>
                function openModalEditProvider(id) {
                  $.post(
                    "/pages/cab/ajax/loadProviderData.php?id="+id,

                    onAjaxSuccess
                  );

                  function onAjaxSuccess(data)
                  {
                    console.log(data);

                    result = JSON.parse(data);

                    if (result.status == 'OK') {
                      document.getElementById('editBody').innerHTML = result.response.html;
                      $('#edit').modal('show');
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

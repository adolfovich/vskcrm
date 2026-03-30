<div class="main-content">
    <!-- Top navbar -->
    <?php include ('tpl/cab/tpl_header.tpl'); ?>
    <!-- Header -->

    <div class="modal" id="editField"  tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form id="editFieldForm" method="POST">
          <input type="hidden" id="editFieldId" name="editFieldId" value="">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Редактирование поля</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="EditFieldName">Название</label>
                <input type="text" name="EditFieldName" class="form-control" id="EditFieldName" placeholder="Название" value="<?php if (isset($_POST['EditFieldName'])) echo $_POST['EditFieldName'];?>">
              </div>

              <div class="form-group">
                <label for="EditFieldOrdering">Сортировка</label>
                <input type="number" name="EditFieldOrdering" class="form-control" id="EditFieldOrdering" value="<?php if (isset($_POST['EditFieldOrdering'])) echo $_POST['EditFieldOrdering'];?>">
              </div>

              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="EditfieldShow" id="EditfieldShow" value="1">
                <label class="form-check-label" for="exampleCheck1">Показывать в таблице</label>
              </div>

            </div>

            <div class="modal-error text-danger" style="text-align: center; margin-bottom: 10px;">
              <?php if (isset($msg) && $msg['type'] == 'error') { echo $msg['text']; } ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
              <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal" id="addField"  tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form id="addFieldForm" method="POST">
          <input type="hidden" name="action" value="addField">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Добавление поля</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="addFieldName">Название</label>
                <input type="text" name="addFieldName" class="form-control" id="addFieldName" placeholder="Название" value="<?php if (isset($_POST['addFieldName'])) echo $_POST['addFieldName'];?>">
              </div>

              <div class="form-group">
                <label for="addFieldOrdering">Сортировка</label>
                <input type="number" name="addFieldOrdering" class="form-control" id="addFieldOrdering" value="<?php if (isset($_POST['addFieldOrdering'])) {echo $_POST['addFieldOrdering'];} else {echo 100;}?>">
              </div>

              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="addFieldShow" id="addFieldShow" value="1">
                <label class="form-check-label" for="addFieldShow">Показывать в таблице</label>
              </div>

            </div>

            <div class="modal-error text-danger" style="text-align: center; margin-bottom: 10px;">
              <?php if (isset($msg) && $msg['type'] == 'error') { echo $msg['text']; } ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
              <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <?php if (isset($msg) && $msg['type'] != 'error') { ?>
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
                <div class="col">
                  <h3 class="mb-0">Список полей</h3>
                </div>
                <div class="col text-right">
                  <div class="row">
                    <div class="col">
                      <button class="btn btn-sm btn-primary" style="margin-bottom: 10px;" data-toggle="modal" data-target="#addField">Добавить поле</button>
                      <a href="salons" class="btn btn-sm btn-primary" style="margin-bottom: 10px;">Закрыть</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table table-sm align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" style="width: 20px;">#</th>
                    <th scope="col" class="text-left">Название поля</th>
                    <th scope="col" style="width: 150px;">Сортировка</th>
                    <th class="text-center" scope="col" style="width: 150px;">Показывать<br>в таблице</th>
                    <th scope="col" style="width: 100px;"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($fields) { ?>
                    <?php foreach($fields as $field) { ?>
                    <tr>
                      <th scope="row"><?=$field['id']?></th>
                      <td class="text-left" id="fieldName<?=$field['id']?>"><?=$field['name']?></td>
                      <td style="padding-top: 17px;">
                        <form class="form-inline" method="POST">
                          <div class="form-group">
                            <input type="hidden" name="field_id" value="<?=$field['id']?>" >
                            <input type="number" name="field_ordering" id="fieldOrdering<?=$field['id']?>" class="form-control" style="width: 70px; margin-right: 10px; padding: 5px; height: 28px;" value="<?=$field['ordering']?>">
                            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="far fa-save"></i></button>
                          </div>
                        </form>
                      </td>
                      <td style="font-size: 20px; text-align: center; color: #5e72e4;" id="fieldShow<?=$field['id']?>">
                        <?php if ($field['show_in_table']) echo '<i class="fas fa-check"></i>'; ?>
                      </td>
                      <td>
                        <a class="btn btn-outline-primary btn-sm" href="#" onClick="editField(<?=$field['id']?>)"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-outline-danger btn-sm" href="?deleteField=<?=$field['id']?>"><i class="fas fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    <?php } ?>
                  <?php } else { ?>
                    <tr>
                      <td colspan="4" style="text-align: center;">Нет данных</td>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>


      </div>
    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

  <?php if (isset($msg) && $msg['type'] == 'error') { ?>
    <script>
      $('#<?=$msg['window']?>').modal('show');
    </script>
  <?php } ?>

  <script>
    function editField(id) {

      document.getElementById("EditFieldName").value = document.getElementById("fieldName"+id).innerHTML;
      document.getElementById("EditFieldOrdering").value = document.getElementById("fieldOrdering"+id).value;
      fieldShow = document.getElementById("fieldShow"+id).innerHTML;
      fieldShow = fieldShow.replace(/\s/g, '');
      console.log('fieldShow "'+fieldShow+'"');
      if (fieldShow != '') {
        document.getElementById("EditfieldShow").checked = true;
      }

      document.getElementById("editFieldId").value = id;

      $('#editField').modal('show');
    }
  </script>

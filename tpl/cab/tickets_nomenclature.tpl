
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
              <h5 class="modal-title">Новый товар</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group" >
                <label for="productName">Название</label>
                <input type="text" name="productName" class="form-control" id="productName" placeholder="Название" value="<?php if(isset($_POST['productName'])) echo $_POST['productName']; ?>">
              </div>

              <div class="form-group" >
                <label for="productDescription">Описание</label>
                <input type="text" name="productDescription" class="form-control" id="productDescription" placeholder="Описание" value="<?php if(isset($_POST['productDescription'])) echo $_POST['productDescription']; ?>">
              </div>

              <div class="form-group">
                <label for="productProvider">Поставщик</label>
                <select class="form-control" id="productProvider" name="productProvider">
                <?php foreach($providers as $provider) { ?>
                  <option value="<?=$provider['id']?>"><?=$provider['name']?></option>
                <?php } ?>
                </select>
              </div>

              <div class="form-group" >
                <label for="productType">Ед. изм.</label>
                <input type="text" name="productType" class="form-control" id="productType" placeholder="Ед. изм." value="<?php if(isset($_POST['productType'])) echo $_POST['productType']; ?>">
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
              <h5 class="modal-title">Изменить товар</h5>
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
                <div class="col-md-12">
                <h3 class="mb-0">Номенклатура</h3>
                </div>
              </div>
              <br>
              <div class="row align-items-center">

                <div class="col-md-8">

                  <form class="form-inline" id="searchForm">

                    <div class="form-row">
                      <div class="form-group mx-sm-3 mb-2">
                        <label for="searchProvider" style="padding-right: 60px;">Поставщик</label>
                        <select name="searchProvider" id="searchProvider" class="form-control chosen-select  sm-6" style="margin-left: 10px; max-width: 140px;" onChange="searchNomenclature()" >
                          <option value="all" >Все</option>
                          <?php foreach ($providers as $provider) { ?>
                            <option value="<?=$provider['id']?>" ><?=$provider['name']?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="searchName">Название</label>
                        <input type="text" name="searchName" id="searchName" class="form-control mx-sm-3" onkeyup="searchNomenclature()">
                      </div>
                    </div>

                  </form>

                </div>

                <div class="col-md-4 text-right">
                  <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#add">Новый товар</button>
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
                    <th scope="col" style="text-align: center;">Поставщик</th>
                    <th scope="col" style="text-align: center;">Ед.Изм</th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="table-striped" id="product_table">
                  <?php $i = 1; ?>
                  <?php foreach ($nomenclature as $product) { ?>
                    <tr>
                      <td style="text-align: center;"><?=$product['name']?></td>
                      <td style="text-align: center;"><?=$product['description']?></td>
                      <td style="text-align: center;"><?=$product['provider_name']?></td>
                      <td style="text-align: center;"><?=$product['type']?></td>


                      <td style="text-align: center;">
                        <a href="#" class="btn btn-outline-primary btn-sm" title="Редактировать" onClick="openModalEditProduct(<?=$product['id']?>);">
                            <i class="fas fa-edit"></i>
                        </a>
                      </td>
                      <td style="text-align: center;">
                        <a href="?delete&product_id=<?=$product['id']?>" class="btn btn-outline-danger btn-sm" title="Удалить">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                      </td>
                    </tr>
                    <?php $i++; ?>
                  <?php } ?>
                </tbody>
              </table>
              <script>
                function openModalEditProduct(id) {
                  $.post(
                    "/pages/cab/ajax/loadProductData.php?id="+id,

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
  <script>
    function searchNomenclature() {
      $.ajax({
         type: "POST",
         url: "/pages/cab/ajax/searchNomenclature.php",
         data: $("#searchForm").serialize(),
         success: function(data)
         {
             result = JSON.parse(data);
             if (result.status == 'OK') {
               document.getElementById('product_table').innerHTML = result.response.html;
             }
         }
       });
    }
  </script>

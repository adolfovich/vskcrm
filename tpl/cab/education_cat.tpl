<div class="main-content">

  <div class="modal" id="delete"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form id="deleteForm" method="POST">
        <input type="hidden" id="editActionType" name="action_type" value="delete_subcat">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div id="deleteBody" class="modal-body">

          </div>
          <div id="deleteError" class="modal-error text-danger">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            <button type="submit" class="btn btn-danger">Удалить</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal" id="edit"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form id="editForm" method="POST">
        <input type="hidden" id="editActionType" name="action_type" value="edit_subcat">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div id="editBody" class="modal-body">

          </div>
          <div id="editError" class="modal-error text-danger">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            <button type="submit" class="btn btn-primary submit" >Сохранить</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal" id="addCat"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form id="addCatForm" method="POST">
        <input type="hidden" name="action_type" value="add_subcat">
        <input type="hidden" name="cat" value="<?=$_GET['cat']?>">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Добавлeние подкатегории</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="catName">Название</label>
              <input type="text" name="subCatName" class="form-control" id="catName" placeholder="Название" value="<?php if(isset($_POST['subCatName'])) echo $_POST['subCatName']; ?>">
            </div>

            <div class="form-group">
              <label for="catColor">Цвет</label>
              <input type="color" name="subCatColor" class="form-control" id="catColor" placeholder="" value="<?php if(isset($_POST['subCatColor'])) echo $_POST['subCatColor']; ?>">
            </div>

            <div class="form-group">
              <label for="catOrdering">Сортировка</label>
              <input type="text" name="subCatOrdering" class="form-control" id="catOrdering" placeholder="" value="<?php if(isset($_POST['subCatOrdering'])) echo $_POST['subCatOrdering']; ?>">
            </div>

          </div>

          <div class="modal-error text-danger">
            <?php if (isset($msg) && $msg['type'] == 'error') { echo $msg['text']; } ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            <button type="submit" class="btn btn-primary submit">Сохранить</button>
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
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1"></h6>
                  <h2 class="mb-0">
                    <a href="/cab/education">Категории</a> <i class="fas fa-long-arrow-alt-right"></i>
                    <span style="color: <?=$cat_data['color']?>;"><?=$cat_data['name']?></span>
                  </h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm">
                  <?php if($user_profile['edit_education']) { ?>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCat">Добавить подкатегорию</button>
                  <?php } ?>
                </div>
                <div class="col-sm" style="text-align: right;">
                  <a href="#" class="btn btn-primary" onClick="getOnceLink(<?=$cat_data['id']?>, 'cat')">Одноразовая ссылка</a>
                  <a href="/cab/education?>" class="btn btn-primary">Назад</a>
                </div>
              </div>
              <div class="row" style="text-align: center;">
                <?php foreach($subcats as $subcat) { ?>
                  <style>
                    #subcatstyle<?=$subcat['id']?> {
                      border: 1px <?=$subcat['color']?> solid;
                      color: <?=$subcat['color']?>;
                    }
                  </style>
                  <div class="col mt-5 ">
                    <div class="row">
                    <a href="/cab/education?cat=<?=$cat_data['id']?>&subcat=<?=$subcat['id']?>" style="margin: 0 auto;">
                      <div class="cat " id="subcatstyle<?=$subcat['id']?>">
                        <span class="cat-name"><?=$subcat['name']?></span>
                      </div>
                    </a>
                    </div>
                    <?php if($user_profile['edit_education']) { ?>
                    <div class="row" style="text-align: center;">
                      <span style="margin: 0 auto;">
                        <a class="btn text-success" onClick="modalEdit('editSubcat', <?=$subcat['id']?>)"><i class="far fa-edit"></i></a>
                        <a class="btn text-danger" onClick="modalDelete('deleteSubcat', <?=$subcat['id']?>)"><i class="far fa-trash-alt"></i></a>
                      </span>
                    </div>
                    <?php } ?>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

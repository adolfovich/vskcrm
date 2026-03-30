<div class="main-content">

  <div class="modal" id="delete"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form id="deleteForm" method="POST">
        <input type="hidden" id="editActionType" name="action_type" value="delete_cat">
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
      <form id="editForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="editActionType" name="action_type" value="edit_cat">
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
      <form id="addCatForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action_type" value="add_cat">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Добавлeние категории</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group" >
              <label for="catName">Название</label>
              <input type="text" name="catName" class="form-control" id="catName" placeholder="Название" value="<?php if(isset($_POST['catName'])) echo $_POST['catName']; ?>">
            </div>

            <div class="form-group">
              <label for="catColor">Цвет</label>
              <input type="color" name="catColor" class="form-control" id="catColor" placeholder="" value="<?php if(isset($_POST['catColor'])) echo $_POST['catColor']; ?>">
            </div>

            <div class="form-group">
              <label for="catOrdering">Сортировка</label>
              <input type="text" name="catOrdering" class="form-control" id="catOrdering" placeholder="" value="<?php if(isset($_POST['catOrdering'])) echo $_POST['catOrdering']; ?>">
            </div>

            <div class="form-group">
              <label for="catIco">Иконка</label>
              <input type="file" name="catIco" class="form-control" id="catIco">
            </div>

            <div class="form-group">
              <label for="catName">Профили</label>
              <?php foreach($profiles as $profile) { ?>
                <?php if ($profile['id'] == 1) {$checked = 'checked onclick="return false;"';} else {$checked = '';} ?>
              <div class="form-check">
                <input name="profiles[]" class="form-check-input" type="checkbox" value="<?=$profile['id']?>" id="profiles<?=$profile['id']?>" <?=$checked?>>
                  <label class="form-check-label" for="profiles<?=$profile['id']?>">
                    <?=$profile['name']?>
                  </label>
              </div>
              <?php } ?>
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
                  <h2 class="mb-0">Категории</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm">
                  <?php if($user_profile['edit_education']) { ?>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCat">Добавить категорию</button>
                  <?php } ?>
                </div>
              </div>
              <div class="row" style="text-align: center;">
                <?php foreach($cats as $cat) { ?>
                  <style>
                    #catstyle<?=$cat['id']?> {
                      border: 1px <?=$cat['color']?> solid;
                      color: <?=$cat['color']?>;

                    }
                    #caticon<?=$cat['id']?> {
                      background-image:url(<?=$cat['icon']?>);
                      background-repeat: no-repeat;
                      background-size: 80%;
                      background-position: center;
                      width: 100%;
                      height: 100%;
                      position: absolute;
                      top: 0;
                      left: 0;
                      margin: 0;
                      opacity: 0.1;
                    }
                  </style>
                  <?php $cat_access = explode(',', $cat['access']) ?>
                  <?php if (in_array($user_profile['id'], $cat_access)) { ?>
                  <div class="col mt-5 ">
                    <div class="row">
                      <a href="/cab/education?cat=<?=$cat['id']?>" style="margin: 0 auto;">

                        <div class="cat " id="catstyle<?=$cat['id']?>">


                          <div class="cat-icon" id="caticon<?=$cat['id']?>" style="z-index: 99;"></div>
                          <div class="cat-name" style="z-index: 101;"><?=$cat['name']?></div>
                        </div>
                      </a>
                    </div>
                    <?php if($user_profile['edit_education']) { ?>
                    <div class="row" style="text-align: center;">
                      <span style="margin: 0 auto;">
                        <a class="btn text-success" onClick="modalEdit('editCat', <?=$cat['id']?>)"><i class="far fa-edit"></i></a>
                        <a class="btn text-danger" onClick="modalDelete('deleteCat', <?=$cat['id']?>)"><i class="far fa-trash-alt"></i></a>
                      </span>
                    </div>
                    <?php } ?>
                  </div>
                  <?php } ?>

                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

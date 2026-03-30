<div class="main-content">

  <div class="modal" id="delete"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form id="deleteForm" method="POST">
        <input type="hidden" id="editActionType" name="action_type" value="delete_video">
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
        <input type="hidden" id="editActionType" name="action_type" value="edit_video">
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
            <button type="submit" class="btn btn-primary submit">Сохранить</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal" id="addCat"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form id="addCatForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action_type" value="add_video">
        <input type="hidden" name="subcat" value="<?=$_GET['subcat']?>">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Добавлeние видео</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="videoName">Название</label>
              <input type="text" name="videoName" class="form-control" id="videoName" placeholder="Название" value="<?php if(isset($_POST['videoName'])) echo $_POST['videoName']; ?>">
            </div>

            <div class="form-group">
              <label for="videoFile">Файл видеоролика</label>
              <input type="file" name="videoFile" class="form-control" id="videoFile" aria-describedby="fileHelp" >
              <small id="fileHelp" class="form-text text-muted">Файл должен быть в формате MP4</small>
            </div>

            <ul class="list-group">
              <li class="list-group-item">Дополнительные файлы</li>
              <li class="list-group-item" id="dopFiles">
                <div class="form-group">
                  <input type="file" name="dopFile1" class="form-control" id="dopFile1" aria-describedby="dopFileHelp1" >
                  <small id="dopFileHelp1" class="form-text text-muted">Файл должен быть в формате MP3, Word, Excel, PDF</small>
                </div>

              </li>
              <li class="list-group-item">
                <a href="#" class="btn btn-outline-primary btn-sm" onClick="addFileField()">Добавить еще один файл</a>
              </li>
            </ul>
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
                    <a style="color: <?=$cat_data['color']?>" href="/cab/education?cat=<?=$cat_data['id']?>"><?=$cat_data['name']?></a> <i class="fas fa-long-arrow-alt-right"></i>
                    <span style="color: <?=$subcat_data['color']?>"><?=$subcat_data['name']?></span>
                  </h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm">
                  <?php if($user_profile['edit_education']) { ?>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCat">Добавить видео</button>
                  <?php } ?>
                </div>
                <div class="col-sm" style="text-align: right;">
                  <a href="#" class="btn btn-primary" onClick="getOnceLink(<?=$subcat_data['id']?>, 'subcat')">Одноразовая ссылка</a>
                  <a href="/cab/education?cat=<?=$cat_data['id']?>" class="btn btn-primary">Назад</a>
                </div>
              </div>
              <div class="row" style="text-align: center;">
                <?php foreach($videos as $video) { ?>
                  <div class="col mt-5 ">
                    <div class="row">
                      <a href="/cab/education?cat=<?=$cat_data['id']?>&subcat=<?=$subcat_data['id']?>&video=<?=$video['id']?>" style="margin: 0 auto;">
                        <div class="cat ">
                          <span class="cat-name"><?=$video['name']?></span>
                        </div>
                      </a>
                    </div>
                    <div class="row" style="text-align: center;">
                      <span style="margin: 0 auto;">
                        <a class="btn text-success" onClick="modalEdit('editVideo', <?=$video['id']?>)"><i class="far fa-edit"></i></a>
                        <a class="btn text-danger" onClick="modalDelete('deleteVideo', <?=$video['id']?>)"><i class="far fa-trash-alt"></i></a>
                      </span>
                    </div>
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
  <?php if (isset($msg) && isset($msg['video_id'])) { ?>
    <script>
      modalEdit('editVideo', 28, '<?=$msg["text"]?>');
    </script>
  <?php } ?>

  <?php if (isset($msg) && $msg['type'] == 'error') { ?>
    <script>
      $('#<?=$msg["window"]?>').modal('show');
    </script>
  <?php } ?>

  <script>
    function deleteDopFile(id) {
      $("#modalEditDopFile"+id).remove();

      newElems = $('<input type="hidden" name="deleteDopFile[]" value="'+id+'">');
      $('#dopFiles').append(newElems);
    }

  function addFileField() {
    countFileFields = $("#dopFiles .form-group").length;
    fileFields = document.getElementById("dopFiles");
    newFieldNum = countFileFields + 1;

    newElems = $('<div class="form-group"><input type="file" name="dopFile[]" class="form-control" id="dopFile'+newFieldNum+'" aria-describedby="dopFileHelp'+newFieldNum+'" ><small id="dopFileHelp'+newFieldNum+'" class="form-text text-muted">Файл должен быть в формате MP3, Word, Excel, PDF</small></div>')

    $('#dopFiles').append(newElems);
  }
  </script>

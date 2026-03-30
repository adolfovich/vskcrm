<div class="main-content">

  <style>
  
  /* картинка на странице */
.minimized {
  width: 100px;
  cursor: pointer;
  border: 1px solid #FFF;
}
.minimized:hover {

}
/* увеличенная картинка */
#magnify {
  display: none;
  /* position: absolute; upd: 24.10.2016 */
  position: fixed;
  max-width: 600px;
  height: auto;
  z-index: 9999;
}
#magnify img {
  width: 100%;
}
/* затемняющий фон */
#overlay {
  display: none;
  background: #000;
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  opacity: 0.5;
  z-index: 9990;
}
/* кнопка закрытия */
#close-popup {
  padding-top: 2px;
  padding-left: 9px;
  width: 30px;
  height: 30px;
  background: #FFFFFF;
  border: 1px solid #AFAFAF;
  border-radius: 15px;
  cursor: pointer;
  position: absolute;
  top: 15px;
  right: 15px;
}



  </style>



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
                    <a href="/cab/education?cat=<?=$cat_data['id']?>"><?=$cat_data['name']?></a> <i class="fas fa-long-arrow-alt-right"></i>
                    <a href="/cab/education?cat=<?=$cat_data['id']?>&subcat=<?=$subcat_data['id']?>"><?=$subcat_data['name']?></a> <i class="fas fa-long-arrow-alt-right"></i>
                    <?=$video_data['name']?>
                  </h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm">
                  <?=$video_data['name']?>
                </div>
                <div class="col-sm" style="text-align: right;">
                  <a href="#" class="btn btn-primary" onClick="getOnceLink(<?=$video_data['id']?>, 'video')">Одноразовая ссылка</a>
                  <a href="/cab/education?cat=<?=$cat_data['id']?>&subcat=<?=$subcat_data['id']?>" class="btn btn-primary">Закрыть</a>
                </div>
              </div>
              <br>
              <?php if ($video_data["path"]) { ?>
              <div class="row" style="text-align: center;" >
                <div class="embed-responsive embed-responsive-16by9">
                  <video style="margin: 0 auto;" src="<?=$video_data['path']?>" controls></video>
                </div>
              </div>
              <?php } ?>
              <?php if ($dopFiles) { ?>
                <?php if ($video_data["path"]) { ?>
                <div class="row" style="text-align: center;">
                  <div class="col-sm" style="margin-top: 20px;">
                    Дополнительные файлы
                  </div>
                </div>
                <?php } ?>
              <div class="row" style="text-align: center;">
                <?php foreach ($dopFiles as $dopFile) { ?>
                  <?php
                    $dopFileName = explode("/", $dopFile['path']);
                    $dopFileName = $dopFileName[3];
                    $dopFileExtention = explode(".", $dopFileName);
                    $dopFileExtention = end($dopFileExtention);
                    //var_dump($dopFileExtention);
                    if ($dopFileExtention == 'jpg' || $dopFileExtention == 'jpeg' || $dopFileExtention == 'png' || $dopFileExtention == 'gif') {
                  ?>
                  <div class="card" style="width: 10rem;">
                   <span class="card-img-top" style="font-size: 5em;"><img class="minimized" style="width: 100px;" src="<?=$dopFile['path']?>"  /></span>
                    <div class="card-body" style="padding-top: 0;padding: 0.5rem; ">
                      <h5 class="card-title" style="margin-bottom: 0;"><?=$dopFileName?></h5>
                    </div>
                    <a href="<?=$dopFile['path']?>" target="_blank" class="btn btn-primary" style="margin: 10px;">Скачать</a>
                  </div>
                  <?php
                  } else {
                   ?>
                    <div class="card" style="width: 10rem;">
                     <span class="card-img-top" style="font-size: 5em;"><?=$core->getFileIco($dopFileExtention)?></span>
                      <div class="card-body" style="padding-top: 0;padding: 0.5rem; ">
                        <h5 class="card-title" style="margin-bottom: 0;"><?=$dopFileName?></h5>
                      </div>
                      <a href="<?=$dopFile['path']?>" target="_blank" class="btn btn-primary" style="margin: 10px;">Скачать</a>
                    </div>
                  <?php } ?>
                <?php } ?>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

<script>

$(function(){
  $('.minimized').click(function(event) {
    var i_path = $(this).attr('src');
    $('body').append('<div id="overlay"></div><div id="magnify"><img src="'+i_path+'"><div id="close-popup"><i class="fa fa-times" aria-hidden="true"></i></div></div>');
    $('#magnify').css({
     left: ($(document).width() - $('#magnify').outerWidth())/2,
     // top: ($(document).height() - $('#magnify').outerHeight())/2 upd: 24.10.2016
            top: ($(window).height() - $('#magnify').outerHeight())/2
   });
    $('#overlay, #magnify').fadeIn('fast');
  });

  $('body').on('click', '#close-popup, #overlay', function(event) {
    event.preventDefault();
    $('#overlay, #magnify').fadeOut('fast', function() {
      $('#close-popup, #magnify, #overlay').remove();
    });
  });
});

</script>

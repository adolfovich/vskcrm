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
      <div class="row">
        <div class="col-sm-12">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col-md-8">
                  <h3 class="mb-0">Настройки заявок</h3>
                </div>

                <div class="col-md-4 text-right">

                  <a href="tickets" class="btn btn-primary mb-2" >Закрыть</a>
                </div>


              </div>
            </div>

            <div class="card-body">

              <a href="tickets_statuses" class="btn btn-primary mb-2" onclick="">Статусы заявок</a>
              <a href="tickets_types" class="btn btn-primary mb-2" onclick="">Типы заявок</a>
              <a href="tickets_providers" class="btn btn-primary mb-2" onclick="">Поставщики</a>
              <a href="tickets_nomenclature" class="btn btn-primary mb-2" onclick="">Номенклатура</a>


            </div>

          </div>
        </div>
        <div class="col-sm-4">

        </div>
      </div>


    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

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
        <div class="col-sm-8">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Список статистик</h3>
                </div>
                <div class="col text-right">
                  <a href="new_statistic" class="btn btn-sm btn-primary">Добавить статистику</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" style="width: 20px;">#</th>
                    <th scope="col" class="text-left">Статистика</th>
                    <th scope="col" ></th>
                    <th scope="col" ></th>
                    <th style="width: 20px;"></th>
                    <th style="width: 20px;"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($statistics as $statistic) { ?>
                  <tr>
                    <th scope="row"><?=$statistic['id']?></th>
                    <td class="text-left"><?=$statistic['name']?></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href="/cab/statistic_edit?id=<?=$statistic['id']?>" class="mdc-button mdc-button--unelevated">
                        <i class="fas fa-edit"></i>
                      </a>
                    </td>
                    <td>
                      <a href="/cab/stat_settings?a=del&id=<?=$statistic['id']?>"class="mdc-button mdc-button--unelevated secondary-filled-button mdc-ripple-upgraded">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-sm-4">

        </div>
      </div>
    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

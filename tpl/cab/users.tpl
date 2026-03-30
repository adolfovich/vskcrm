

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
                <div class="col">
                  <h3 class="mb-0">Список пользователей</h3>
                </div>
                <div class="col-7 text-right">
                  <a href="user_edit?a=new" class="btn btn-sm btn-primary">Добавить пользователя</a>
                  <a href="users?a=all_users" class="btn btn-sm btn-primary">Показать удаленных</a>
                </div>

              </div>
              <!--div class="row">
                <div class="col">
                  <form class="form-inline" style="margin-top: 20px;" method="GET" action="?search">
                    <div class="form-row" style="width: 100%;">
                      <div class="col-10">
                        <input type="text" class="form-control-plaintext" id="search_user" name="search_user" placeholder="Поиск по ФИО или логину" value="<?php if (isset($_GET['search_user'])) echo $_GET['search_user'] ?>">
                      </div>
                      <div class="col" style="text-align: right;">
                        <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </form>
                </div>
              </div-->
            </div>
            <div class="table-responsive" style="overflow-x: hidden;">
              <style>
                .card .table td, .card .table th {
                  padding-right: 0.2rem;
                  padding-left: 0.2rem;
                }
              </style>
              <!-- Projects table -->
              <table class="table table-sm align-items-center table-flush">
                <thead class="thead-light">
                  <tr>

                    <th scope="col" class="text-left pl-2">Логин</th>
                    <th scope="col" >ФИО</th>
                    <th scope="col" >Бригада</th>
                    <th style="width: 20px;"></th>
                    <th style="width: 20px;"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($users as $user) { ?>
                  <tr>

                    <td class="text-left pl-2" ><a href="/cab/user_edit?id=<?=$user['user_id']?>"><?=$user['login']?></a></td>
                    <td><?=$user['surname'].' '.mb_substr($user['firstname'], 0, 1).'.'.mb_substr($user['patronymic'], 0, 1).'.'?></td>
                    <td><?=$user['crew_name']?></td>
                    <td>
                      <?php if ($user['user_id'] != 1) { ?>
                      <a href="/cab/user_edit?id=<?=$user['user_id']?>" class="btn btn-outline-success btn-sm" title="Редактировать пользователя">
                        <i class="fas fa-user-edit"></i>
                      </a>
                    <?php } ?>
                    </td>
                    <td>
                      <?php if ($user['user_id'] != 1) { ?>
                        <?php if ($user['status'] == 1) { ?>
                        <a href="/cab/users?a=del&id=<?=$user['user_id']?>" class="btn btn-outline-danger btn-sm" title="Удалить пользователя">
                          <i class="fas fa-user-minus"></i>
                        </a>
                      <?php } else if ($user['status'] == 0) { ?>
                          <a href="/cab/users?a=return&id=<?=$user['user_id']?>" class="btn btn-outline-success btn-sm" title="Восстановить пользователя">
                            <i class="fas fa-undo-alt"></i>
                          </a>
                    <?php }} ?>
                    </td>
                  </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!--div class="col-sm-4">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Профили</h3>
                </div>
                <div class="col text-right">
                  <a href="new_profile" class="btn btn-sm btn-primary">Добавить профиль</a>
                </div>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-sm align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="text-left">Название</th>
                    <th style="width: 20px;"></th>
                    <th style="width: 20px;"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($profiles as $profile) { ?>
                    <tr>
                      <th scope="row"><?=$profile['name']?></th>
                      <td>
                        <?php if ($profile['id'] != 1) { ?>
                          <a href="/cab/profile_edit?id=<?=$profile['id']?>"class="btn btn-outline-success btn-sm" title="Редактировать профиль">
                            <i class="fas fa-edit"></i>
                          </a>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if ($profile['id'] != 1) { ?>
                          <a href="/cab/users?a=del_profile&id=<?=$profile['id']?>"class="btn btn-outline-danger btn-sm" title="Удалить профиль">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div-->
      </div>
    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

<div class="main-content">
    <!-- Top navbar -->
    <?php include ('tpl/cab/tpl_header.tpl'); ?>
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <?php if (isset($msg)) {
				foreach ($msg as $ms) {?>
        <div class="row" style="padding-left: 40px; padding-right: 40px;">
          <div class="col-sm-8">
            <div class="alert alert-<?=$ms['type']?> alert-dismissible fade show" role="alert">
                <span class="alert-inner--icon"></span>
                <span class="alert-inner--text"><?=$ms['text']?></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          </div>
        </div>
      <?php }} ?>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
					<?php if (isset($get['a']) && $get['a'] == 'new') { ?>
						<h3 class="mb-0">Новый пользователь</h3>
					<?php } else { ?>
						<h3 class="mb-0">Редактирование: <?=$user_data['surname']?> <?=$user_data['firstname']?> <?=$user_data['patronymic']?></h3>
					<?php } ?>
                </div>
                

              </div>
            </div>
            <div style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;">
            <form id="userEdit" method="POST">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" name="userLogin" id="userLogin" class="form-control" placeholder="Логин" value="<?=$user_data['login']?>"/>
                  </div>
                </div>
				<div class="col-md-6">
                  <div class="form-group">
                    <select class="custom-select" name="userProfile">
                      <option selected disabled>Профиль: <?=$user_profile['name']?></option>\
                      <?php foreach($profiles as $profile) { ?>
                        <option value="<?=$profile['id']?>"><?=$profile['name']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div id="showPassIco" class="input-group-text" style="cursor: pointer;" onClick="showPass()"><i class="fas fa-eye"></i></div>
                    </div>
                    <input type="password" class="form-control" name="userPass" id="userPass" placeholder="Новый пароль">
                  </div>

                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="password" class="form-control" name="userRePass" id="userRePass" placeholder="Повтор пароля">
                  </div>
                </div>
              </div>

              <div class="row">                
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control" name="userSurname" id="userSurname" placeholder="Фамилия" value="<?=$user_data['surname']?>">
                  </div>
                </div>
				<div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control" name="userFirstname" id="userFirstname" placeholder="Имя" value="<?=$user_data['firstname']?>">
                  </div>
                </div>
				<div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control" name="userPatronymic" id="userPatronymic" placeholder="Отчество" value="<?=$user_data['patronymic']?>">
                  </div>
                </div>
              </div>
			  
			  <div class="row">                
                <div class="col-md-6">
                  <div class="form-group">
					<div class="input-group mb-2">
						<input type="text" class="form-control" name="userPhone" id="userPhone" placeholder="Номер телефона" value="<?=$user_data['phone']?>">
						<div class="input-group-prepend">
							<div class="input-group-text"><a href="tel:<?=$user_data['phone']?>"><i class="fas fa-phone"></i></a></div>
						</div>
					</div>
                  </div>
                </div>
				<div class="col-md-6">
                  <div class="form-group">
				  <div class="input-group mb-2">
						<input type="text" class="form-control" name="userEmail" id="userEmail" placeholder="Email" value="<?=$user_data['email']?>">
						<div class="input-group-prepend">
							<div class="input-group-text"><a href="mailto:<?=$user_data['email']?>"><i class="fas fa-envelope"></i></a></div>
						</div>
					</div>
                    
                  </div>
                </div>
				
              </div>
			  
			  <div class="row">
				<div class="col-md-6">
                  <div class="form-group">
                    <select class="custom-select" name="userCrew">
                      <option selected disabled>Бригада: <?=$user_data['crew_name']?></option>\
                      <?php foreach($crews as $crew) { ?>
                        <option value="<?=$crew['id']?>"><?=$crew['name']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
				<div class="col-md-6">
                  <div class="custom-control custom-checkbox">					  
					  <input type="checkbox" class="custom-control-input" id="userCrew_leader" name="userCrew_leader" value="1" <?php if ($user_data['crew_leader'] == 1) echo 'checked' ?>>
					  <label class="custom-control-label" for="userCrew_leader">Бригадир</label>
					</div>
                </div>
			  </div>
			  <div class="row pt-3">
					<div class="col-md-6 text-center" style="margin-bottom: 10px;"><input type="submit" name="save" class="btn btn-primary" value="Сохранить" /></div>
					<div class="col-md-6 text-center"><input type="submit" name="saveclose" class="btn btn-primary" value="Сохранить  и закрыть" /></div>
			   </div>
            </form>
            </div>
          </div>
        </div>

      </div>
    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

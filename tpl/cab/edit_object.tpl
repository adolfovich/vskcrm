<div class="main-content">

  <style>
  #tooltip {
    z-index: 9999;
    position: absolute;
    display: none;
    top:0px;
    left:0px;
    width: 250px;
    background-color: #fff;
    padding: 5px 10px 5px 10px;
    color: #000;
    border: 1px solid #888;
    border-radius: 5px;
    box-shadow: 0 1px 2px #555;
    box-sizing: ;
  }
  
  </style>
  
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
			  <?php
				if (isset($get['a']) && $get['a'] == 'new') {
					echo 'Создание объекта';
				} else {
					echo 'Редактирование объекта:&nbsp;<b>'.$object['name'].'</b>';
				}
			  ?>
              </div>
            </div>


            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="salons-list" role="tabpanel" aria-labelledby="salons-list-tab">

                <div class="row" style="margin-left: 5px; margin-right: 5px;">
				
				<form method="POST" style="width: 90%; margin-left: 20px; margin-bottom: 20px;">
					<?php 
					if (isset($object)) {
						echo '<input type="hidden" name="objAction" value="update">';
						echo '<input type="hidden" name="objId" value="'.$object['id'].'">';
					} else {
						echo '<input type="hidden" name="objAction" value="new">';
					} ?>
				  <div class="form-group">
					<label for="objDirection">Дирекция</label>
					<select class="form-control" id="objDirection" name="objDirection">
						<?php
							foreach ($directions as $direction) {
								if (isset($object) && $object['direction'] == $direction['id']) {
									echo '<option value="'.$direction['id'].'" selected>'.$direction['name'].'</option>';
								} else {
									echo '<option value="'.$direction['id'].'">'.$direction['name'].'</option>';
								}								
							}
						?>
					</select>
				  </div>
				  <div class="form-group">
					<label for="objName">Название</label>
					<input type="text" class="form-control" id="objName" name="objName" aria-describedby="objNameHelp" placeholder="" value="<?php if (isset($object)) echo $object['name']; ?>">
					<small id="objNameHelp" class="form-text text-muted">Название объекта полное</small>
				  </div>
				  
				  <div class="form-group">
					<label for="objAddress">Адрес</label>
					<input type="text" class="form-control" id="objAddress" name="objAddress" aria-describedby="objAddressHelp" placeholder="" value="<?php if (isset($object)) echo $object['address']; ?>">
					<small id="objAddressHelp" class="form-text text-muted">Полный адрес местонахождения</small>
				  </div>				  
				  
				  <div class="form-group">
					<label for="objCrew">Бригада</label>
					<select class="form-control" id="objCrew" name="objCrew" onChange="getOptionsCrewEmployees(this.value)">
						<?php 
							if (!isset($object)) echo '<option selected disabled>Выберите бригаду</option>'; 						
							
							foreach ($crews as $crew) {
								if (isset($object) && $object['crew'] == $crew['id']) {
									echo '<option value="'.$crew['id'].'" selected>'.$crew['name'].'</option>';
								} else {
									echo '<option value="'.$crew['id'].'">'.$crew['name'].'</option>';
								}								
							}
						?>
					</select>
				  </div>
				  
				  <div class="form-group">
					<label for="objCrewEmployees">Сотрудники</label>
					<select multiple="multiple" class="form-control" id="objCrewEmployees" name="objCrewEmployees[]">
					<?php 
						if (!isset($object)) {
							echo '<option selected disabled>Выберите бригаду</option>'; 
						} else {
							$employees_arr = explode(",", $object['employees']);
							foreach ($employees as $employe) {
								if (in_array($employe['id'], $employees_arr)) {
									echo '<option value="'.$employe['id'].'" selected>'.$employe['surname'].' '.$employe['firstname'].'</option>';
								} else {
									echo '<option value="'.$employe['id'].'">'.$employe['surname'].' '.$employe['firstname'].'</option>';
								}								
							}
						}
					?>
					</select>
				  </div>
				  <br>
				  <div class="row pt-3">
					<div class="col-md-6 text-center" style="margin-bottom: 10px;"><input type="submit" name="save" class="btn btn-primary" value="Сохранить" /></div>
					<div class="col-md-6 text-center"><input type="submit" name="saveclose" class="btn btn-primary" value="Сохранить  и закрыть" /></div>
			   </div>
				  
				</form>
                
              </div>
				
            </div>
          </div>
        </div>


      </div>
	  </div>
    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

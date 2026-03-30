

<div class="main-content">
  <style>
  .hovered-tr:hover {
    background: #ddd;
    cursor: pointer;
  }
  
  .lightbox-gallery{background-image: linear-gradient(#4A148C, #E53935);background-repeat: no-repeat;color: #000;overflow-x: hidden}
  .lightbox-gallery p{color:#fff}
  .lightbox-gallery h2{font-weight:bold;margin-bottom:40px;padding-top:40px;color:#fff}
  @media (max-width:767px){.lightbox-gallery h2{margin-bottom:25px;padding-top:25px;font-size:24px}}
  .lightbox-gallery .intro{font-size:16px;max-width:500px;margin:0 auto 40px}
  .lightbox-gallery .intro p{margin-bottom:0}
  .lightbox-gallery .photos{padding-bottom:20px}
  .lightbox-gallery .item{padding-bottom:30px}
  
  </style>
    <!-- Top navbar -->
    <?php include ('tpl/cab/tpl_header.tpl'); ?>
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">

        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-8 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header bg-transparent" style="/*padding-bottom: 0;*/">
              <div class="row align-items-center">
                <div class="col">
                  <div class="row">
                    <div class="col-md-12">
                      <h6 class="text-uppercase text-muted ls-1 mb-1"></h6>
                      <div class="row">
                        <div class="col-10">
                          <h2 class="mb-0">Заявка #<?=$ticket['rzhd_id']?></h2>
                        </div>
                        <div class="col-2">
                           <span class="status"
                                   style="color:<?=$ticket['status_color']?>; background-color:<?=$core->hex2rgba($ticket['status_color'], 0.3)?>">
                            <?=$ticket['status_name']?>
                          </span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <?=$ticket['object_name']?>
                        </div>
                      </div>

                    </div>
                    <div class="col-md-3 text-right">
                      <?php if ($ticket['type'] == 100 || $ticket['type'] == 0) { ?>
                      <a href="/reports/purchase.php?ticket=<?=$ticket['id']?>" class="btn btn-outline-primary btn-sm" title="Печать" target="_blank"><i class="fas fa-print"></i></a>
                      <a href="#" class="btn btn-outline-primary btn-sm disabled" title="Сохранить"><i class="far fa-save"></i></a>
                      <a href="#" class="btn btn-outline-primary btn-sm <?php if(!$ticket['provider_email']) echo disabled; ?>" title="Отправить по Email" onClick="sendPurchse(<?=$ticket['id']?>)"><i class="far fa-envelope"></i></a>

                      <?php } ?>
                    </div>
                    <script>
                      function sendPurchse(id) {
                        //console.log(id);
                        $('.loading').show();
                        $.post(
                          "/pages/cab/ajax/sendPurchaseEmail.php?id="+id,
                          onAjaxSuccess
                        );
                        function onAjaxSuccess(data)
                        {
                          $('.loading').hide();
                          console.log(data);
                          result = JSON.parse(data);
                          console.log(result);
                          if (result.status == 'OK') {
                            Swal.fire({
                              text: 'Письмо отправлено успешно',
                              type: 'success',
                              confirmButtonText: 'ОК'
                            })
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
            </div>
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Текст заявки:</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="3" disabled><?=$ticket['text']?></textarea>
                  </div>
                </div>

                <!--div class="form-group row">
                  <label class="col-sm-3 col-form-label">Тип заявки:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?=$ticket['type_name']?>" disabled>
                  </div>
                </div>
				
				<div class="form-group row">
                  <label class="col-sm-3 col-form-label">Ответственный:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?=$ticket['responsible_user_name']?>" disabled>
                  </div>
                </div-->
				
				<div class="form-group row">
                  <label class="col-sm-3 col-form-label">Выезд запланирован:</label>
                  <div class="col-sm-8">
                    <input type="date" name="dep_plan" class="form-control" onChange="enSaveButton()" value="<?php if ($ticket['date_visit_plane']) echo date('Y-m-d', strtotime($ticket['date_visit_plane']))?>">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Выезд осуществлен:</label>
                  <div class="col-sm-8">
                    <input type="date" name="dep_fact" class="form-control" onChange="enSaveButton()" value="<?php if ($ticket['date_visit_fact']) echo date('Y-m-d', strtotime($ticket['date_visit_fact']))?>">
                  </div>
                </div>

                <style>
                  .btn-active {
                    background-color: #324cdd;
                  }

                </style>

                <script>
                  function showInput(button) {

                    if ($("."+button.name).css("display") == "none") {
                      $("."+button.name).show();
                      $(button).removeClass("btn-primary");
                      $(button).addClass("btn-secondary");
                    } else {
                      $("."+button.name).hide();
                      $(button).removeClass("btn-secondary");
                      $(button).addClass("btn-primary");
                    }
                  }
                </script>

                <div class="form-group row">

                    <button style=" margin: 0 auto; margin-top: 5px;" type="button" name="dv_input" onclick="showInput(this)" class="btn btn-primary">Загрузить ДВ</button>
                    <button style=" margin: 0 auto; margin-top: 5px;" type="button" name="av_input" onclick="showInput(this)" class="btn btn-primary">Загрузить АВ</button>
                    <button style=" margin: 0 auto; margin-top: 5px;" type="button" name="ra_input" onclick="showInput(this)" class="btn btn-primary">Загрузить РА</button>

                </div>

                <div class="form-group row dv_input" style="display: none">
                  <label class="col-sm-3 col-form-label">Дефектная ведомость:</label>
                  <div class="col-sm-8">
                    <input type="file" name="dv_photo[]" class="form-control" onChange="enSaveButton()" multiple/>
                    <small id="dv_photo" class="form-text text-muted">Файл должен быть в формате jpg, jpeg, png</small>
                  </div>
                </div>

                <div class="form-group row av_input" style="display: none">
                  <label class="col-sm-3 col-form-label">Акт восстановления:</label>
                  <div class="col-sm-8">
                    <input type="file" name="av_photo[]" class="form-control" onChange="enSaveButton()" multiple/>
                    <small id="av_photo" class="form-text text-muted">Файл должен быть в формате jpg, jpeg, png</small>
                  </div>
                </div>

                <div class="form-group row ra_input" style="display: none">
                  <label class="col-sm-3 col-form-label">Рекламационный акт:</label>
                  <div class="col-sm-8">
                    <input type="file" name="ra_photo[]" class="form-control" onChange="enSaveButton()" multiple/>
                    <small id="ra_photo" class="form-text text-muted">Файл должен быть в формате jpg, jpeg, png</small>
                  </div>
                </div>



                <div class="content form-group row" >
                  <?php foreach ($ticket_photos as $ticket_photo) { ?>
                    <!--<div class="col">
                      <img src="<?=$ticket_photo['path']?>" style="width: 200px;" />
                    </div>-->
                    <a class="elem" href="<?=$ticket_photo['path']?>" data-lcl-thumb="<?=$ticket_photo['path']?>">
                    	<span style="background-image: url(<?=$ticket_photo['path']?>);"></span>
                    </a>
                  <?php } ?>
                </div>
				
				<style>
				.comment {
					border: #9fe3ca 1px solid;
					border-radius: 15px;
					background: aliceblue!important;
					padding-top: 12px;
				}
				</style>
                

                

                <?php if ($next_statuses[0] != 0) {?>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Добавить коментарий:</label>
                    <div class="col-sm-8">
                      <textarea name="comment" class="form-control" rows="5" onKeyUp="enSaveButton()"></textarea>
                    </div>
                  </div>
				  
				  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Добавить фото:</label>
                    <div class="col-sm-8">
                      <input type="file" name="comment_photo[]" class="form-control" onChange="enSaveButton()" multiple/>
					  <small id="comment_photo" class="form-text text-muted">Файл должен быть в формате jpg, jpeg, png</small>
                    </div>
                  </div>

                <?php } ?>



                <?php if (($user_profile['change_ticket_status'] && $next_statuses[0] != 0) || $user_profile['change_close_tickets']) {?>

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Изменить статус:</label>
                  <div class="col-sm-8">
                    <select name="changeStatus" id="changeStatus" class="form-control has-success" data-toggle="select" onChange="enSaveButton()">
                      <option selected disabled>---</option>
                      <?php $accepted_ticket_statuses = explode(',', $user_profile['accepted_ticket_statuses']); ?>
                      <?php foreach($next_statuses as $status) { ?>
                        <?php if (in_array($status, $accepted_ticket_statuses) || $user_profile['accepted_ticket_statuses'] == 0) { ?>
                          <?php $status_info = $core->getTicketStatusInfo($status); ?>
                          <option value="<?=$status?>"><?=$status_info['name']?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <?php } ?>

                <div class="form-group">
                  <?php if ($ticket['edited'] || $user_profile['change_ticket_status']) { ?>
                    <?php if ($next_statuses[0] != 0) {?>
                    <button id="saveButton" type="submit" onclick="" class="btn btn-primary" disabled>Сохранить</button>
                    <?php } ?>
                  <?php } ?>
                  <button onclick="location.href = 'tickets'; return false;" class="btn btn-primary" >Закрыть</button>
                  <?php if (isset($get['return_to']) && $get['return_to'] > 0) { ?>
                  <button onclick="location.href = 'ticket?id=<?=$get['return_to']?>'; return false;" class="btn btn-primary" >Вернуться</button>
                  <?php } ?>
                </div>
              </form>


            </div>
          </div>

        </div>

        <div class="col-xl-4">
          <div class="card shadow" >
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1"></h6>
                  <h2 class="mb-0">История</h2>
                </div>
              </div>
            </div>
            <div class="card-body" style="max-height: 595px; overflow-x: auto;">
              <div class="row">
                <div class="col-md-12">
                  <?php foreach ($ticket_log as $log) { ?>
                  <div class="alert" role="alert" style="border: 1px solid #ccc;">
                      <b><?=date("d.m H:i", strtotime($log['date']))?> <?=$log['user_name']?></b><br>
                      <?=$log['text']?>
					  
					  <div class="row photos">
					  <?php
						if ($log['attachments']) {
							$attachments = json_decode($log['attachments'], true);
							var_dump($attachments);
							foreach ($attachments as $attachment){
                                //var_dump($attachment);
								if ($attachment['type'] == "img") {?>
									<div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?=$attachment['path']?>" data-toggle="lightbox"><img class="img-fluid" src="<?=$attachment['path']?>"></a></div>
								<?php } else { ?>
									<a href="<?=$attachment['path']?>" target="_blank"><i class="far fa-file-alt"></i> <span style="font-size: 12px;"><?=end(explode("/", $attachment['path']));?></span></a>
									</br>
								 <?php }
							}
							
						}
					  ?>
						
					  </div>
                  </div>
                  <?php } ?>
                </div>
              </div>

              <form id="newTicket">

              </form>

            </div>
          </div>
        </div>
      </div>

      <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>


  <script>
  
  $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
			
			
    function enSaveButton()
    {
      document.getElementById("saveButton").disabled = false;
    }
  </script>

  <?php /*if (isset($saved)) { ?>
    <script>
    alert("Изменения сохранены");
    </script>
  <?php } */?>

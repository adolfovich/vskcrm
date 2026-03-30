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
              </div>
            </div>


            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="salons-list" role="tabpanel" aria-labelledby="salons-list-tab">

                <div class="row" style="margin-left: 5px;">
                  <div class="col-md-2">
                    <a href="edit_object?a=new" class="btn btn-sm btn-primary" style="margin-bottom: 10px;">Добавить объект</a>
                  </div>
				  
				 <?php foreach($objects as $object) { ?>
                      <div class="row container-fluid" style="border-bottom: 1px #ccc solid; margin-top: 10px; margin-left: -6px; margin-right: 12px;">
                        <div class="col-sm text-left"><?=$object['direction_name']?></div>
                        <div class="col-sm text-left"><a href="/cab/edit_object?id=<?=$object['id']?>" ><?=$object['name']?></a></div>
						<div class="col-sm text-left"><?=$object['address']?></div>
                        
                        <div class="col-sm text-left">
                          <a href="/cab/edit_object?id=<?=$object['id']?>" class="btn btn-link">
                            <?php if ($user_profile['edit_objects']) { ?>
                            <i class="fas fa-edit"></i>
                            <?php } else { ?>
                            <i class="far fa-eye"></i>
                            <?php } ?>
                          </a>
						  <?php if ($user_profile['edit_objects']) { ?>
                          <a href="/cab/objects?a=del&id=<?=$object['id']?>"class="btn btn-link">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                          <?php } ?>
                        </div>
                        
                      </div>
                      <?php } ?> 
					<hr/>
                
              </div>

            </div>



          </div>
        </div>


      </div>
    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

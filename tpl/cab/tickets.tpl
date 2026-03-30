<div class="main-content">

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
  <script>
    function loadTickets(fieldText)
    {

      $.ajax({
        type: 'POST',
        url: "/pages/cab/ajax/loadTickets.php",
        data: {
          text: fieldText,
          crew: <?=$employe['crew']?>,
        },
        success: function (dataJson) {
          //console.log(dataJson);
          data = JSON.parse(dataJson);
          if (data.status == 'OK') {
            document.getElementById('tickets-table').innerHTML = data.response;
          }
        },
        dataType: "html"
      });
    }
  </script>


    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="form-group">
            <input onkeyup="loadTickets(this.value)" type="text" class="form-control" id="searchTicketField" aria-describedby="searchTicketHelp" placeholder="Номер заявки или объект">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header bg-transparent" style="padding-bottom: 0;">
            </div>
            <div class="card-body" id="tickets-table">

              <?php foreach ($tickets as $ticket) { ?>
                <a href="ticket?id=<?=$ticket['id']?>">
                  <div class="card" >
                    <div class="card-body">
                      <div class="alert alert-warning ticket-status" style="background: <?=$ticket['status_color']?>"><?=$ticket['status_name']?></div>
                      <h3 class="card-title row">
                        <div class="col-sm text-left">
                          Заявка №<?=$ticket['rzhd_id']?> от <?=date("d.m.y", strtotime($ticket['create_date']))?>
                        </div>
                        <div class="col-sm text-right"><?=$ticket['object_name']?></div>
                      </h3>
                      <p class="card-text"><?=$ticket['text']?></p>
                    </div>
                  </div>
                </a>
              <?php } ?>

            </div>
          </div>
        </div>
      </div>
      <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>



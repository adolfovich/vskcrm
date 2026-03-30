
<div class="main-content">
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
            <div class="card-header bg-transparent" style="padding-bottom: 0;">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1"></h6>
                  <h2 class="mb-0">Ваши заявки</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <div>
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Пользователь</th>
                            <th scope="col">Тип заявки</th>
                            <th scope="col">Статус</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="ticketsLIst">
                      <?php foreach ($tickets as $ticket) {?>
                        <tr class = "ticketsTable" onClick="location.href = 'view_ticket?id=<?=$ticket['id']?>'" style="">
                          <td class="budget"><?=$ticket['id']?></td>
                          <td class="budget"><?=date("d.m.Y", strtotime($ticket['create_date']))?></td>
                          <td class="budget"><?=$ticket['user_name']?></td>
                          <td class="budget"><?=$ticket['type_name']?></td>
                          <td class="budget"><span class="badge <?=$ticket['status_color']?>"><?=$ticket['status_name']?></span></td>
                        </tr>
                      <?php } ?>

                    </tbody>
                  </table>
                </div>
              </div></div></div>

        </div>
        <div class="col-xl-4">
          <div class="card shadow">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1"></h6>
                  <h2 class="mb-0">Создание заявки</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="selectType">Тип заявки</label>
                    <select id="selectType" class="form-control has-success" data-toggle="select" onChange="loadForm(this.value)">
                      <?php foreach($tickets_types as $type) { ?>
                        <option value="<?=$type['id']?>"><?=$type['name']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>

              <form id="newTicket">

              </form>

            </div>
          </div>
        </div>
      </div>

      <script>

      function sendTiket()
      {
        ticketForm = $('#newTicket');

        //console.log(ticketForm.serialize());

        $.ajax({
          type: 'POST',
          url: "/pages/cab/ajax/setTicket.php",
          data: ticketForm.serialize(),
          success: function (data) {
            //console.log(data);
            if (data.status == 'OK') {
              swtype = 'success';
              swtitile = 'Успешно!';
              swtext = data.response;

            } else {
              swtype = 'error';
              swtitile = 'Ошибка!';
              swtext = data.error;
            }

            Swal.fire({
              title: swtitile,
              text: swtext,
              type: swtype,
              confirmButtonText: 'ОК'
            })

            loadTickets();

            //
          },
          dataType: "json"
        });

      }





      function loadForm(type)
      {


        $.post(
          "/pages/cab/ajax/getTicketForm.php",
          {
            ticket_type: type
          },
          onAjaxSuccess
        );

        function onAjaxSuccess(data)
        {
          //console.log(data);
          var result = JSON.parse(data);
          //console.log(result);

          if (result.status == 'OK') {
            document.getElementById('newTicket').innerHTML = result.response;
          }

        }
      }

      window.onload = function()
      {
          loadForm(document.getElementById('selectType').value);
      }
      </script>


      <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

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
      <div class="col">
        <div class="card shadow">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col">
                <h3 class="mb-0">Редактирование данных</h3>
              </div>
              <div class="col text-right"></div>
            </div>
          </div>
          <div style="padding-left: 20px; padding-right: 20px;">
            <div class="table-responsive">
              <div>
                <table class="table align-items-center">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">
                        Дата
                      </th>
                      <th scope="col">
                        Салон
                      </th>
                      <th scope="col">
                        Статистика
                      </th>
                      <th scope="col">
                        Данные
                      </th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    <?php foreach ($statistics as $statistic) { ?>
                    <tr>
                      <th scope="row" class="name"><?=date("d.m.Y", strtotime($statistic['date']))?></th>
                      <td class="budget"><?=$statistic['salon_name']?></td>
                      <td class="budget"><?=$statistic['stat_name']?></td>
                      <td class="budget" id="value-<?=$statistic['id']?>"><?=$statistic['value']?></td>
                      <td class="budget" id="icon-<?=$statistic['id']?>"><a href="#" onClick="editValue(<?=$statistic['id']?>)" ><i class="fas fa-edit"></i></a></td>
                    </tr>
                    <?php } ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group" style="padding: 20px; text-align: right;">
                <button type="button" onClick="window.location.href = '/cab/?<?=$url_params[1]?>'" class="btn btn-primary">Готово</button>
              </div>
            </div>
          </div>
        </div>
      </div>



    </div>

    <?php include ('tpl/cab/tpl_footer.tpl'); ?>
  </div>
</div>


<script>
  function editValue(stringId)
  {
    var tdValue =  document.getElementById('value-'+stringId);
    var tdIcon =  document.getElementById('icon-'+stringId);
    var oldValue = tdValue.innerHTML;

    tdValue.innerHTML = '<input style="width: 40px;" id="newValue-'+stringId+'" type="text" value="'+oldValue+'">';
    tdIcon.innerHTML = '<a href="#" onClick="saveValue('+stringId+')"><i class="fas fa-save"></i></a>';

  }

  function saveValue(stringId)
  {
    var tdValue =  document.getElementById('value-'+stringId);
    var tdIcon =  document.getElementById('icon-'+stringId);
    var newValue =  document.getElementById('newValue-'+stringId).value;

    $.post(
      "/pages/cab/ajax/editStat.php",
      {
        id: stringId,
        value: newValue
      },
      onAjaxSuccess
    );

    function onAjaxSuccess(data)
    {
      //console.log(data);
      var result = JSON.parse(data);
      if (result.status == 'OK') {
        tdValue.innerHTML = newValue;
        tdIcon.innerHTML = '<a href="#" onClick="editValue('+stringId+')" ><i class="fas fa-edit"></i></a>';
      } else {
        Swal.fire({
          title: 'Ошибка!',
          text: result.error,
          type: 'error',
          confirmButtonText: 'ОК'
        })
      }
    }

    //console.log('newValue '+newValue);
  }
</script>

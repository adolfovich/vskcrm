<!-- Footer -->
<footer class="footer">
  <div class="row align-items-center justify-content-xl-between">
    <div class="col-xl-6">
      <div class="copyright text-center text-xl-left text-muted">
        © <?=date("Y")?><a href="https://exeptional.ru" class="font-weight-bold ml-1" target="_blank" style="color: #6c757d; font-weight: 100 !important;">e<span style="color: green;">[x]</span>eptional software</a>
      </div>
    </div>
  </div>
</footer>



<script>

  function getOptionsCrewEmployees(crewId) {
	$.post(
      "/pages/cab/ajax/getOptionsCrewEmployees.php",
      {        
        id: crewId
      },
      onAjaxSuccess
    );
	
	function onAjaxSuccess(data)
    {
      console.log(data);
      var result = JSON.parse(data);
	  console.log(result);
      if (result.status == 'OK') {
        document.getElementById('objCrewEmployees').innerHTML = result.response; //response
       
      } else {
      //  Swal.fire({
      //    title: 'Ошибка!',
      //    text: result.error,
      //    type: 'error',
      //    confirmButtonText: 'ОК'
      //  })
      }
    }
  }

  $("form").submit(
     function() {
          $('.submit').prop('disabled', true);
          return true;
     }
  );

  function modalDelete(type, id) {
    $.post(
      "/pages/cab/ajax/getModalEdu.php",
      {
        type: type,
        id: id
      },
      onAjaxSuccess
    );

    function onAjaxSuccess(data)
    {
      var result = JSON.parse(data);
      if (result.status == 'OK') {
        document.getElementById('deleteBody').innerHTML = result.response; //response
        $('#delete').modal('show');
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

  function modalEdit(type, id, msg = '') {
    $.post(
      "/pages/cab/ajax/getModalEdu.php",
      {
        type: type,
        id: id
      },
      onAjaxSuccess
    );

    function onAjaxSuccess(data)
    {
      var result = JSON.parse(data);
      if (result.status == 'OK') {
        document.getElementById('editBody').innerHTML = result.response; //response
        if (msg != '') {
          document.getElementById('editError').innerHTML = msg;
        }
        $('#edit').modal('show');
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

<script type="text/javascript">
$(document).ready(function(e) {

	// live handler
	lc_lightbox('.elem', {
		wrap_class: 'lcl_fade_oc',
		gallery : true,
		thumb_attr: 'data-lcl-thumb',

		skin: 'minimal',
		radius: 0,
		padding	: 0,
		border_w: 0,
	});

});
</script>

<script>

function getOnceLink(videoId, videoType) {
  $.post(
    "/pages/cab/ajax/getOnceLink.php",
    {
      type: videoType,
      id: videoId
    },
    onAjaxSuccess
  );

  function onAjaxSuccess(data)
  {
    console.log(data);
    var result = JSON.parse(data);
    console.log(result);
    if (result.status == 'OK') {
      document.getElementById('onceLinkModalBody').innerHTML = result.response; //response
      $('#onceLinkModal').modal('show');
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

function copyUrl(){
  var copyText = document.getElementById("inputUrl");
  copyText.select();
  document.execCommand("copy");
}

function showPass() {
  if ($('#userPass').get(0).type == 'password') {
    $('#userPass').get(0).type = 'text';
    $('#userRePass').get(0).type = 'text';
    $('#showPassIco').html('<i class="fas fa-eye-slash"></i>');
  } else {
    $('#userPass').get(0).type = 'password';
    $('#userRePass').get(0).type = 'password';
    $('#showPassIco').html('<i class="fas fa-eye"></i>');
  }
}

  var config = {
  '.chosen-select'           : {},
  '.chosen-select-deselect'  : { allow_single_deselect: true },
  '.chosen-select-no-single' : { disable_search_threshold: 10 },
  '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
  '.chosen-select-rtl'       : { rtl: true },
  '.chosen-select-width'     : { width: '95%' }
  }
  for (var selector in config) {
    $(selector).chosen(config[selector]);
  }

  function openReport(form, file) {
    getString = file + '?' + $("#"+form).serialize();
    window.open(getString);
  }
</script>

</body>

</html>

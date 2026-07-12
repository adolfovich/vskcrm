<div class="main-content">

    <!-- Top navbar -->

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

        function loadChecklist(listId)
        {

            console.log(listId);
            $.ajax({
                type: 'POST',
                url: "/pages/cab/ajax/loadChecklist.php",
                data: {
                    checklist_id: listId,
                },
                success: function (dataJson) {
                    //console.log(dataJson);
                    data = JSON.parse(dataJson);
                    if (data.status == 'OK') {
                        document.getElementById('OpList').innerHTML = data.response;
                        processingallbuttons();
                    }
                },
                dataType: "html"
            });

        }
    </script>

    <style>
        .row-striped > div:nth-of-type(odd) {
            background-color: #dddfe1; /* Используется цвет фона из Bootstrap 4 (.bg-light) */
        }
    </style>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <!--div class="form-group">
                    <input id="findInput" onkeyup="loadBase(this.value)" type="text" class="form-control" placeholder="Поиск по базе">
                </div-->
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header bg-transparent" style="padding-bottom: 0;">
                        <div class="form-group">
                            <select class="custom-select" name="checklistSelect" onchange="loadChecklist(this.value)">
                                <option selected="" disabled="">Выберите чеклист </option>
                                <?php foreach ($checklists as $checklist) { ?>
                                    <option value="<?=$checklist['id']?>"><?=$checklist['name']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-body" id="OpList">

                    </div>
                </div>
            </div>
        </div>
        <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
</div>



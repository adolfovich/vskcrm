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
        function changeLoadBase(text) {
            $('#findInput').val(text);
            loadBase(text);
        }
        function loadBase(fieldText)
        {

            //console.log(fieldText);
            $.ajax({
                type: 'POST',
                url: "/pages/cab/ajax/loadRecords.php",
                data: {
                    text: fieldText,
                },
                success: function (dataJson) {
                    //console.log(dataJson);
                    data = JSON.parse(dataJson);
                    if (data.status == 'OK') {
                        document.getElementById('records-table').innerHTML = data.response;
                        processingallbuttons();
                    }
                },
                dataType: "html"
            });

        }
    </script>

    <script>
        //$(document).ready(function() {
        function processingallbuttons() {
            // Обработка всех кнопок спойлеров
            $('.toggle-spoiler').click(function() {
                var targetId = $(this).data('target');
                var content = $(targetId);
                var button = $(this);

                // Используем Bootstrap Collapse API
                if (content.hasClass('show')) {
                    content.removeClass('show');
                    button.text('Развернуть');
                } else {
                    content.addClass('show');
                    button.text('Свернуть');
                }
            });
        };

        $(document).ready(function() {
            processingallbuttons();
        });
    </script>


    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <!--div class="form-group">
                    <input id="findInput" onkeyup="loadBase(this.value)" type="text" class="form-control" placeholder="Поиск по базе">
                </div-->

            </div>
        </div>

        <style>
            .collapse-text {
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
            }

            .collapse-text.show {
                -webkit-line-clamp: unset;
            }

            .keywords {
                font-size: small;
                font-weight: 300;
            }

            .keyword {
                cursor: pointer;
                text-decoration: underline;
            }
        </style>

        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header bg-transparent" style="padding-bottom: 0;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text" style="cursor: pointer" onclick="changeLoadBase('')"><i class="fa fa-window-close" aria-hidden="true"></i></div>
                            </div>
                            <input type="text" id="findInput" onkeyup="loadBase(this.value)" class="form-control" placeholder="Поиск по базе знаний">
                            <a class="btn btn-primary" href="kbrecord?action=new">+</a>
                        </div>
                    </div>
                    <div class="card-body" id="records-table">

                        <?php foreach ($records as $record) { ?>

                                <div class="card" >
                                    <div class="card-body">

                                        <h3 class="card-title row">
                                            <div class="col-sm text-left">
                                                <?=$record['subject']?>
                                                <span class="keywords" style="">(<?=$core->hashtags($record['keywords'])?>)</span>
                                            </div>
                                        </h3>
                                        <p class="card-text collapse-text" id="spoilerText<?=$record['id']; ?>"><?=$record['text']; ?></p>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <button class="btn btn-outline-primary toggle-spoiler mt-2"
                                                        data-target="#spoilerText<?=$record['id']; ?>"
                                                        aria-expanded="false"
                                                        style="width: 100%;">
                                                    Развернуть
                                                </button>
                                            </div>
                                            <div class="col-md-2">
                                                <a class="btn btn-primary mt-2" href="kbrecord?id=<?=$record['id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if ($record['author'] == $user_id || $user_profile['delete_kbrecords'] == 1 ) { ?>
                                                <a class="btn btn-danger mt-2" href="kbrecord?action=del&id=<?=$record['id']; ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                                <?php } ?>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                        <?php } ?>



                    </div>
                </div>
            </div>
        </div>
        <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
</div>



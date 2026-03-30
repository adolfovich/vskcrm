


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
    <?php include('tpl/cab/tpl_header.tpl'); ?>
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
            <div class="col-xl-12 mb-12 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header bg-transparent" style="/*padding-bottom: 0;*/">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-uppercase text-muted ls-1 mb-1"></h6>
                                        <div class="row">
                                            <div class="col-12">
                                                <h2 class="mb-0">Тема: </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-right">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Тема:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="subject" class="form-control" value="<?=$subject?>">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">
                                    Ключевые слова:<br>
                                    <span style="font-size: small;">(через пробел)</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" name="keywords" class="form-control" value="<?=$keywords?>">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Текст:</label>
                                <div class="col-sm-8">
                                    <textarea name="text" class="form-control summernote" rows="8" ><?=$text?></textarea>
                                </div>
                            </div>


                            <style>
                                .comment {
                                    border: #9fe3ca 1px solid;
                                    border-radius: 15px;
                                    background: aliceblue!important;
                                    padding-top: 12px;
                                }
                            </style>


                            <div class="form-group">

                                <button id="saveButton" type="submit" onclick="" class="btn btn-primary">Сохранить</button>

                                <button onclick="location.href = 'knowledgebase'; return false;" class="btn btn-primary" >Закрыть</button>

                            </div>
                        </form>


                    </div>
                </div>

            </div>


        </div>

        <?php include('tpl/cab/tpl_footer.tpl'); ?>
    </div>
</div>
<script>
$(document).ready(function() {
$('.summernote').summernote();
});
</script>
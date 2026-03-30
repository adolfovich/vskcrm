<html lang="ru" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Пример на bootstrap 4: Прижатый футер отображается в нижней части страницы, когда содержимое окна слишком короткое. Панель навигации в верхней части. Версия v4.3.1.">

    <title>Обучающие материалы</title>

    <!-- Bootstrap core CSS -->
    <link href="../assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="../assets/css/argon.css?v=1.0.0" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!--script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script-->

    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="../assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Optional JS -->
    <script src="../assets/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="../assets/vendor/chart.js/dist/Chart.extension.js"></script>
    <!-- Argon JS -->
    <script src="../assets/js/argon.js?v=1.0.0"></script>



    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .cat {
        min-width: 150px;
          max-width: 150px;
      height: 150px;
      display: table-cell;
      vertical-align: middle;

      border: 1px #5e72e4 solid;

      position: relative;

      background-color:rgba(85, 85, 85, 0.1);
      border-radius: 20px;
      }

      .cat-name {
      font-weight: 600;
      }

      .cat-icon {
      position: absolute;

      font-size: 100px;
      text-align: center;
      margin-left: 35px;
      color:rgba(85, 85, 85, 0.2)
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="sticky-footer-navbar.css" rel="stylesheet">


</head>

  <body class="d-flex flex-column h-100">




    <header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">

        <li class="nav-item">
          <a class="btn btn-secondary " href="/">Войти</a>
        </li>

      </ul>

    </div>
  </nav>
</header>

<!-- Begin page content -->
<div class="container-fluid mt--7">
  <div class="container" style="margin-top: 150px;">
    <?php if (isset($arr['error'])) { ?>
      <div class="row">
        <h2 style="text-align: center; color:red;"><?=$arr['error']?></h2>
      </div>
    <?php } else if (isset($video)){ ?>

    <div class="row">
      <h2 style="text-align: center;"><?=$video['name']?></h2>
    </div>
    <?php if ($video["path"]) { ?>
    <div class="row" style="text-align: center;" >
      <div class="embed-responsive embed-responsive-16by9">
        <video style="margin: 0 auto;" src="<?=$video['path']?>" controls></video>
      </div>
    </div>
    <?php } ?>
    <?php if ($dopFiles) { ?>
      <?php if ($video["path"]) { ?>
      <div class="row" style="text-align: center;">
        <div class="col-sm" style="margin-top: 20px;">
          Дополнительные файлы
        </div>
      </div>
      <?php } ?>
    <div class="row" style="text-align: center;">
      <?php foreach ($dopFiles as $dopFile) { ?>
        <?php
          $dopFileName = explode("/", $dopFile['path']);
          $dopFileName = $dopFileName[3];
          $dopFileExtention = explode(".", $dopFileName);
          $dopFileExtention = end($dopFileExtention);
         ?>
         <div class="card" style="width: 10rem;">
           <span class="card-img-top" style="font-size: 5em;"><?=$core->getFileIco($dopFileExtention)?></span>
            <div class="card-body" style="padding-top: 0;padding: 0.5rem; ">
              <h5 class="card-title" style="margin-bottom: 0;"><?=$dopFileName?></h5>
            </div>
            <a href="<?=$dopFile['path']?>" target="_blank" class="btn btn-primary" style="margin: 10px;">Скачать</a>
          </div>
      <?php } ?>
    </div>
    <?php } ?>

  <?php } else if (isset($subcats)) { ?>
    <div class="row" style="text-align: center;">
    <?php foreach($subcats as $subcat) { ?>
      <style>
        #subcatstyle<?=$subcat['id']?> {
          border: 1px <?=$subcat['color']?> solid;
          color: <?=$subcat['color']?>;
        }
      </style>
      <div class="col mt-5 ">
        <div class="row">
        <a href="video?id=<?=$_GET['id']?>&subcat=<?=$subcat['id']?>" style="margin: 0 auto;">
          <div class="cat " id="subcatstyle<?=$subcat['id']?>">
            <span class="cat-name"><?=$subcat['name']?></span>
          </div>
        </a>
        </div>

      </div>
    <?php } ?>
    </div>
  <?php } else if (isset($videos)) {?>
    <div class="row" style="text-align: center;">
      <?php foreach($videos as $video) { ?>

        <div class="col mt-5 ">
          <div class="row">
            <a href="video?id=<?=$_GET['id']?>&subcat=<?=$video['subcat']?>&video=<?=$video['id']?>" style="margin: 0 auto;">
              <div class="cat ">
                <span class="cat-name"><?=$video['name']?></span>
              </div>
            </a>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } ?>
  </div>
</div>

<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted"><p class="mt-5 mb-3 text-muted"><a href="https://exeptional.ru" class="font-weight-bold ml-1" target="_blank" style="color: #6c757d; font-weight: 100 !important;">e<span style="color: green;">[x]</span>eptional software</a> &copy; <?=date("Y")?></p></span>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<script>window.jQuery || document.write('<script src="/docs/4.3.1/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js" ></script>

</body>
</html>

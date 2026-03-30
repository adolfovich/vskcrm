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
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card">
            <div class="card-header bg-transparent" style="padding-bottom: 0;">
              <div class="row align-items-center">
				Карта объектов
                
              </div>
            </div>
            <div class="card-body">
              <div id="map" style="width: 100%; height: 400px"></div>
            </div>
          </div>
        </div>
        
      </div>

      <script>

  let yamap;

  main();
  async function main() {
      // Промис `ymaps3.ready` будет зарезолвлен, когда загрузятся все компоненты API
      await ymaps3.ready;
	  const {
                YMap,
                YMapDefaultSchemeLayer,
                YMapMarker,
                YMapControls,
                YMapDefaultFeaturesLayer
            } = ymaps3;
      const {YMapZoomControl} = await ymaps3.import('@yandex/ymaps3-controls@0.0.1');
	  const {YMapDefaultMarker} = await ymaps3.import('@yandex/ymaps3-markers@0.0.1');

      // Создание карты
      yamap = new ymaps3.YMap(document.getElementById('map'), {
          location: {
              // Координаты центра карты
              // Порядок по умолчанию: «долгота, широта»
              center: [37.765204, 44.725180],

              // Уровень масштабирования
              // Допустимые значения: от 0 (весь мир) до 21.
              zoom: 10
          }
      });

      // Добавляем слой для отображения схематической карты
      yamap.addChild(new ymaps3.YMapDefaultSchemeLayer());
	  
	  yamap.addChild(new YMapControls({position: 'right'}).addChild(new YMapZoomControl({})));
	  yamap.addChild(new YMapDefaultFeaturesLayer({id: 'features'}));
	  
	
	const INC_POINT = {coordinates: [37.765204, 44.725180], title: 'Marker inc #0'};
	const marker = new YMapDefaultMarker(INC_POINT);
    yamap.addChild(marker);

  }
        

      </script>

      <?php include ('tpl/cab/tpl_footer.tpl'); ?>
    </div>
  </div>

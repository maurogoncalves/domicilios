<!DOCTYPE html>
<html>
  <head>
  <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	 <script type='text/javascript'>
     google.charts.load('current', {'packages': ['geochart']});
     google.charts.setOnLoadCallback(drawMarkersMap);

      function drawMarkersMap() {
      var data = google.visualization.arrayToDataTable([
        ['Cidade'],
		<?php
			foreach ($cidades as $cidade) {
				$cid = utf8_decode($cidade->cidade);
				echo "['$cid - $cidade->estado - Sim: $cidade->sim - Não: $cidade->nao - Nada Consta: $cidade->nc'],";
			}
		?>			

      ]);

      var options = {
        region: 'BR',
		resolution: 'provinces',
        displayMode: 'markers',
		datalessRegionColor: '#29ABE2',
		keepAspectRatio: false,
		legend: false,
		backgroundColor: '#dedede', //eg. red
        colorAxis: {colors: ['green', 'blue']}
		
      };
	
      var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    };
    </script> 
	
	  <style type="text/css">
	html {
		height: 100%;
	}
	body {
		height: 100%;
		margin: 0;
		padding: 0;
	}
	#map-canvas {
		height: 100%;
	}
	</style>

  </head>
  <body>
	<input type='hidden' id='base' value='<?php echo $base = $this->config->base_url(); ?>' >
    <div id="chart_div">
	</div>
  </body>
</html>
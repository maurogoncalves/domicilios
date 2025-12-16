<!DOCTYPE html>
<html>
  <head>
  <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
jQuery(function($) {

var base = $("#base").val();

	// *
// * Adicionar um marcador simples
// * 2013 - www.marnoto.com
// *

 // variável que indica as coordenadas do centro do mapa
 var praiaBarra = new google.maps.LatLng(-15.7213874,-48.0783231);


 function initialize() {
   var mapOptions = {
      center: praiaBarra, // variável com as coordenadas Lat e Lng
      zoom: 5,
      mapTypeId: google.maps.MapTypeId.HYBRID
   };
   var map = new google.maps.Map(document.getElementById("map-canvas"),
 mapOptions);
   
    // variável que define o URL para a nova imagem do marcador
   var minhaImagem = base+'assets/icons/pin.png';

   	 // variável que indica as coordenadas do marcador
	 var farolAveiro1 = new google.maps.LatLng(-11.0010333,-37.2435551);
	 

	  
	 // variável que indica as coordenadas do marcador
	 <?php foreach($estados as $key => $est){ ?>
  	  var <?php echo $est->estado?> = new google.maps.LatLng(<?php echo $est->lat1 ?>,<?php echo $est->lat2 ?>);
	
	   // variável que define as opções do marcador
	   var marker = new google.maps.Marker({
		  position: <?php echo $est->estado?>, // variável com as coordenadas Lat e Lng
		  map: map,
		  title:"<?php echo $est->estado.' - '.$est->total ?> CNDs Mobiliarias ",
		  icon: minhaImagem // define a nova imagem do marcador
	  });
	  
	  <?php
	  }								  
	?>
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);

	});



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
    <div id="map-canvas">
	</div>
  </body>
</html>
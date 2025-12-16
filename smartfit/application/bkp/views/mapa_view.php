<!--
Mapa do Brasil mapeado em CSS ( https://github.com/insign/mapa_Brasil_CSS )
- Arquivos fontes em alta resolução e mapa em SVG via https://commons.wikimedia.org/wiki/File:Brazil_Blank_Map_light.svg
- Arquivos finais em 16 cores e extremamente leve
- Sprite em 16 cores e criado via http://css.spritegen.com
- Ao mudar o tamanho, infelizmente as regras de "margin" das tags ul e li deverão ser reescritas manualmente

Changelog:

	* 23/07/2012 - Arquivos em alta resolução e sprite por Hélio Oliveira <insign@gmail.com>

    * Criado por @rafaelpvale http://www.upalele.com

    * Técnica desenvolvida por Roman Cortes
    http://www.romancortes.com/blog/xhtmlcss-mapmapa/

-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
	$('#table').hide();   
	
	$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/mapa/buscaDados?estado=csp",
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	
					if (data == undefined ) {
						$('#tudo2').html('');
					} else {
						$('#tudo2').html(data);
					}						
				}
		 }); 	
		 
	$(".estado").click(function(){	
		var estado = $(this).attr('id');
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/mapa/buscaDados?estado=" + estado,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	
					if (data == undefined ) {
						$('#tudo2').html('');
					} else {
						$('#tudo2').html(data);
					}						
				}
		 }); 	
			 
		//$('#table').show();        
	});
	
	$(".estado").mouseleave(function(){	
		$('#table tr').css('background-color','#fff');        
	});
		
		

	});
 </script> 
 
 <style>
#tudo {
	width: 100%;
	height: 800px;
}
#tudo1 {
	position:relative;
	width: 200px;
	float: left;
}
#tudo2 {
	position: relative;
	width: 48%;
	height: 200px;
	float: right;
}


</style>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Mapa do Brasil</title>
		<style type="text/css">
			.active { display:inherit; }
			ul#map {display: block; margin: 0; padding: 0; width: 570px; height: 585px; background-image: url('<?php echo $this->config->base_url(); ?>assets/mapa_css/img/map.gif');}
			ul#map li {display: block; padding: 0; position: absolute;}
			li#crs {margin-top: 485px; margin-left: 237px; }
			li#csc {margin-top: 467px; margin-left: 292px;}
			li#cpr {margin-top: 416px; margin-left: 281px;}
			li#csp {margin-top: 375px; margin-left: 303px; z-index:9999; }
			li#cms {margin-top: 336px; margin-left: 229px;}
			li#crj {margin-top: 390px; margin-left: 422px; z-index:9999; }
			li#ces {margin-top: 347px; margin-left: 467px; z-index:9999; }
			li#cmg {margin-top: 292px; margin-left: 333px; z-index:9998; }
			li#cgo {margin-top: 264px; margin-left: 301px; z-index:9999; }
			li#cdf {margin-top: 511px; margin-left: 400px; z-index:9999; }
			li#cba {margin-top: 207px; margin-left: 397px;}
			li#cmt {margin-top: 189px; margin-left: 180px;}
			li#cro {margin-top: 199px; margin-left: 104px; z-index:9998; }
			li#cac {margin-top: 185px; margin-left: 0px;}
			li#cam {margin-top: 46px; margin-left: 3px;}
			li#crr {margin-top: 0; margin-left: 133px;}
			li#cpa {margin-top: 40px; margin-left: 219px;}
			li#cap {margin-top: 13px; margin-left: 278px;}
			li#cma {margin-top: 94px; margin-left: 366px; z-index:9999;}
			li#cto {margin-top: 156px; margin-left: 338px;}

			li#cse {margin-top: 221px; margin-left: 519px; z-index:9998;}
			li#cal {margin-top: 211px; margin-left: 518px; z-index:9999;}
			li#cpe {margin-top: 188px; margin-left: 473px;}
			li#cpb {margin-top: 169px; margin-left: 511px; z-index:9999;}
			li#crn {margin-top: 151px; margin-left: 514px;}
			li#cce {margin-top: 121px; margin-left: 473px;}
			li#cpi {margin-top: 120px; margin-left: 406px; z-index:9997;}

			ul#map li a {display: block; text-decoration: none; position: absolute;}
			a#rs {width: 116px; height: 101px; }
			a#sc {width: 81px; height: 53px; }
			a#pr {width: 97px; height: 64px; }
			a#sp {width: 131px; height: 84px; }
			a#ms {width: 106px; height: 104px; }
			a#rj {width: 58px; height: 40px; }
			a#es {width: 33px; height: 51px; }
			a#mg {width: 163px; height: 131px; }
			a#go {width: 108px; height: 108px; }
			a#df {width: 50px; height: 50px; }
			a#ba {width: 136px; height: 148px; }
			a#mt {width: 166px; height: 161px; }
			a#ro {width: 104px; height: 87px; }
			a#ac {width: 108px; height: 62px; }
			a#am {width: 258px; height: 181px;}
			a#rr {width: 87px; height: 103px; }
			a#pa {width: 188px; height: 187px; }
			a#ap {width: 73px; height: 85px; }
			a#ma {width: 102px; height: 139px; }
			a#to {width: 74px; height: 125px; }
			a#se {width: 28px; height: 32px; }
			a#al {width: 46px; height: 27px; }
			a#pe {width: 97px; height: 34px; }
			a#pb {width: 59px; height: 35px; }
			a#rn {width: 53px; height: 33px; }
			a#ce {width: 61px; height: 76px; }
			a#pi {width: 83px; height: 124px; }

			/* Código pronto via http://css.spritegen.com (com alterações nos seletores) */
			{ display: block; background: url('<?php echo $this->config->base_url(); ?>assets/mapa_css/img/sprite.gif') no-repeat; }

			a#pa:hover, a#pa:active { background-position: -10px -0px; width: 188px; height: 187px; }
			a#am:hover, a#am:active { background-position: -10px -197px; width: 258px; height: 181px; }
			a#mt:hover, a#mt:active { background-position: -10px -388px; width: 166px; height: 161px; }
			a#ba:hover, a#ba:active { background-position: -10px -559px; width: 136px; height: 148px; }
			a#ma:hover, a#ma:active { background-position: -156px -559px; width: 102px; height: 139px; }
			a#mg:hover, a#mg:active { background-position: -10px -717px; width: 163px; height: 131px; }
			a#to:hover, a#to:active { background-position: -183px -717px; width: 74px; height: 125px; }
			a#pi:hover, a#pi:active { background-position: -10px -858px; width: 83px; height: 124px; }
			a#go:hover, a#go:active { background-position: -103px -858px; width: 108px; height: 108px; }
			a#ms:hover, a#ms:active { background-position: -103px -976px; width: 106px; height: 104px; }
			a#rr:hover, a#rr:active { background-position: -10px -992px; width: 87px; height: 103px; }
			a#rs:hover, a#rs:active { background-position: -107px -1090px; width: 116px; height: 101px; }
			a#ro:hover, a#ro:active { background-position: -10px -1201px; width: 104px; height: 87px; }
			a#ap:hover, a#ap:active { background-position: -10px -1105px; width: 73px; height: 85px; }
			a#sp:hover, a#sp:active { background-position: -124px -1201px; width: 131px; height: 84px; }
			a#ce:hover, a#ce:active { background-position: -186px -388px; width: 61px; height: 76px; }
			a#pr:hover, a#pr:active { background-position: -124px -1295px; width: 97px; height: 64px; }
			a#ac:hover, a#ac:active { background-position: -10px -1298px; width: 108px; height: 62px; }
			a#sc:hover, a#sc:active { background-position: -128px -1369px; width: 81px; height: 53px; }
			a#es:hover, a#es:active { background-position: -208px -0px; width: 33px; height: 51px; }
			a#rj:hover, a#rj:active { background-position: -186px -474px; width: 58px; height: 40px; }
			a#pb:hover, a#pb:active { background-position: -10px -1370px; width: 59px; height: 35px; }
			a#pe:hover, a#pe:active { background-position: -10px -1415px; width: 97px; height: 34px; }
			a#rn:hover, a#rn:active { background-position: -186px -524px; width: 53px; height: 33px; }
			a#se:hover, a#se:active { background-position: -208px -61px; width: 28px; height: 32px; }
			a#al:hover, a#al:active { background-position: -208px -103px; width: 46px; height: 27px; }
			a#df:hover, a#df:active { background-position: -208px -140px; width: 50px; height: 50px; }

			/* Fim sprite */

			ul#map li a img {border: 0; width: inherit; height: inherit;}
			
			
		</style>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	</head>

	<body>
	<div id='tudo'>

		<div id='tudo1'>
		<ul id="map">
			
			<?php foreach($estados as $key => $estado){ 
				$estMinus = strtolower($estado->uf);
				if($estado->nao_tem <> '0'){					
					?>	  
					<li id="c<?php echo$estMinus ?>" estado="<?php echo$estMinus ?>" class='estado' ><a href="#<?php echo$estMinus ?>" id="<?php echo$estado->uf ?>" ><img src="<?php echo $this->config->base_url(); ?>assets/mapa_css/img/map/<?php echo$estMinus ?>.gif" /></a></li>
					<?php
				}else{
					?>	  
					<li id="c<?php echo$estMinus ?>" estado="<?php echo$estMinus ?>" class='estado' ><a href="" id="<?php echo$estado->uf ?>" title="<?php echo$estado->uf ?>"><img src="<?php echo $this->config->base_url(); ?>assets/mapa_css/img/null.gif" alt="<?php echo$estado->uf ?>" /></a></li>
					<?php
				}
			}	
			?>	  
			
			
		</ul>
		</div>
		<div id='tudo2' style='overflow: scroll;height:90%;font-size:10px'>	
		</div>
	</div>	
	</body>
</html>
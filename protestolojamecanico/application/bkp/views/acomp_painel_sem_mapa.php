<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <style>
#tudo {
	width: 100%;
	height: 800px;
}
#tudo1 {
	position:relative;
	width: 100%;
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
  
  <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.8.3.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
$( "#esfera" ).change(function() {
	
	var esfera = $('#esfera').val();	
	var estado = $('#estado').val();
	$.ajax({
		url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/listarEstadoByEsfera?esfera=" + esfera,
		type : 'GET', /* Tipo da requisição */ 
		contentType: "application/json; charset=utf-8",
	   	dataType: 'json', /* Tipo de transmissão */
		success: function(data){	
			if (data == undefined ) {
				console.log('Undefined');
			} else {
				$('#estado').html(data);
			}						
		}
	}); 

	$.ajax({
	url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/listarCidadeByEsfera?esfera="+esfera,
		type : 'GET', /* Tipo da requisição */ 
		contentType: "application/json; charset=utf-8",
	   	dataType: 'json', /* Tipo de transmissão */
		success: function(data){	
			if (data == undefined ) {
				console.log('Undefined');
			} else {
				$('#municipio').html(data);
			}						
		}
	 }); 

	$.ajax({
	url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/buscaDadosByEsfera?esfera="+esfera,
		type : 'GET', /* Tipo da requisição */ 
		contentType: "application/json; charset=utf-8",
	   	dataType: 'json', /* Tipo de transmissão */
		success: function(data1){	
			if (data1 == undefined ) {
				console.log('Undefined');
			} else {
				$('#lista').html(data1);					
			}	
			
		}
	 }); 	 
});	
		 
$( "#estado" ).change(function() {
		var estado = $('#estado').val();
		var esfera = $('#esfera').val();		
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/listarCidade?estado=" + estado + "&esfera="+esfera,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						$('#municipio').html(data);
					}						
				}
			 }); 		

		$.ajax({
		url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/buscaDadosByEsferaEstado?esfera="+esfera+"&estado="+estado,
			type : 'GET', /* Tipo da requisição */ 
			contentType: "application/json; charset=utf-8",
			dataType: 'json', /* Tipo de transmissão */
			success: function(data){	
				$('#lista').html(data);					
			}
		}); 	 
						 
				
			
	});
	
	$( "#area" ).change(function() {

	var area = $('#area').val();
	var esfera = $('#esfera').val();		
	
			$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/tipoDebito?area=" + area,
				type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 
				contentType: "application/json; charset=utf-8",
				dataType: 'json', /* Tipo de transmiss&atilde;o */
				success: function(data){
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						$('#tipo_debito').html(data);
					}
				}
			});
			
		$.ajax({
		url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/buscaDadosByArea?area="+area+"&esfera="+esfera,
			type : 'GET', /* Tipo da requisição */ 
			contentType: "application/json; charset=utf-8",
			dataType: 'json', /* Tipo de transmissão */
			success: function(data){	
				$('#lista').html(data);					
			}
		}); 						 
				
				 
				
			
	});
	
	$( "#tipo_debito" ).change(function() {

	var tipo_debito = $('#tipo_debito').val();
	var esfera = $('#esfera').val();		
	var sub_area = $('#area').val();	
	
		
		$.ajax({
		url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/buscaDadosByTipoDeb?tipo="+tipo_debito+"&esfera="+esfera+"&sub_area="+sub_area,
			type : 'GET', /* Tipo da requisição */ 
			contentType: "application/json; charset=utf-8",
			dataType: 'json', /* Tipo de transmissão */
			success: function(data){	
				$('#lista').html(data);					
			}
		}); 						 
				
				 
				
			
	});
	
$( "#municipio" ).change(function() {

	var municipio = $('#municipio').val();
	var esfera = $('#esfera').val();	
		
	
		$.ajax({
		url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/buscaDadosByEsferaCidade?esfera="+esfera+"&municipio="+municipio,
			type : 'GET', /* Tipo da requisição */ 
			contentType: "application/json; charset=utf-8",
			dataType: 'json', /* Tipo de transmissão */
			success: function(data){	
				$('#lista').html(data);					
			}
		}); 						 
				
				 
				
			
	});
		
	
	
	$( "#limpar" ).click(function() {
		location.reload();
	});

	
});		
</script>
<script type="text/javascript">
$(document).ready(function(){
	$( "#limpar" ).click(function() {
		location.reload();
	});
});		
</script>
 </head>

	<body>
	<div id='tudo'>
		<br><BR><BR>
		<p style='text-align:center;'>
		<select name="esfera" id="esfera" required="" class='procuraImovel'>
			<option value="0">Escolha uma &acirc;mbito</option>	
			<option value="1">Municipal</option>	
			<option value="2">Estadual</option>	
			<option value="3">Federal</option>	
		 </select>
 		 &nbsp;
		<select name="estado" id="estado" required="" class='procuraImovel'>
			<option value="0">Escolha um estado</option>	
			<?php foreach($estados as $key => $estado){ ?>
			 <option value="<?php echo $estado->estado ?>"><?php echo $estado->estado?></option>	
			<?php }	?>
		  </select>
		  &nbsp;
		  <select name="municipio" id="municipio" required="" class='procuraImovel'>
			<option value="0">Todos</option>	
			<?php foreach($cidades as $key => $cidade){ ?>
			<option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>	
			<?php }?> 
		  </select>		
		  &nbsp;
		  		<select name="area" id="area" required="" class='procuraImovel'>
			<option value="0">Escolha uma area</option>	
			<?php foreach($subAreas as $key => $sub){ ?>
			 <option value="<?php echo $sub->id_subarea ?>"><?php echo $sub->nome?></option>	
			<?php }	?>
		  </select>
		  &nbsp;
		  <select name="tipo_debito" id="tipo_debito" required=""  class='custom-select' style='width:230px'>
			<option value="0">Escolha Tipo D&eacute;bito</option>	
  		  </select>  
		 &nbsp;
		   <a id='limpar' href="#" class="btn btn-primary btn-xs"> Limpar Filtro</a>
			
		</p>
		<br><BR>
		<div id='tudo1' >

		<table class="table table-fixedheader  table-striped table-advance table-hover " style="background-color:#dedede;text-align:center">
        <thead >
        <tr>
        <th colspan=40 style='text-align:center'> Painel de Acompanhamento - CND Brasil</th>
        </tr>
        <tr>
        <th colspan=40 style='text-align:center'> &Aacute;reas Envolvidas</th>
        </tr>		
        <tr style='text-align:center;font-size:11px' >
        <th > </th>
		<th > </th>
		<th > </th>
		<th > </th>
		<th > </th>
		<?php 	
		$this->load->helper("tabela");
		foreach($areas as $key => $area){ 	
		?>									
		<th colspan=9 style='text-align:center;font-size:15px'> <?php echo$area->nome_area ?></th>
		<?php
		}
		?>
        </tr>		
        <tr style='text-align:center;font-size:11px'>
        <th > </th>
		<th > </th>
		<th > </th>
		<th > </th>
		<th > </th>
		<th > </th>
		<th > </th>
		
		<th colspan=9 style='text-align:center;color:#FA0616; border: 3px solid black;'> 
		<?php 	
		foreach($subAreasUm as $key => $subUm){ 	
			echo$subUm->sigla.'-'.$subUm->nome.'&nbsp;&nbsp;';
		}	
		?>		
		</th>
		<th colspan=9 style='text-align:center;color:#175516; border: 3px solid black;'> 		
		<?php 	
		foreach($subAreasDois as $key => $subDois){ 	
			echo$subDois->sigla.'-'.$subDois->nome.'&nbsp;&nbsp;';
		}	
		?>	
		</th>
		<th colspan=9 style='text-align:center;color:#161D55; border: 3px solid black;' > 		
		<?php 	
		foreach($subAreasTres as $key => $subTres){ 	
			echo$subTres->sigla.'-'.$subTres->nome.'&nbsp;&nbsp;';
		}	
		?>
		</th>
		<th colspan=9 style='text-align:center;color:#161D55; border: 3px solid black;' > 		
		<?php 	
		foreach($subAreasQuatro as $key => $subQuatro){ 
			
			echo$subQuatro->sigla.'-'.$subQuatro->nome.'&nbsp;&nbsp;';
		}	
		?>
		</th>		
        </tr>				
        </thead>
		
		<tr style='text-align:center;font-size:11px; border-top: 3px solid black;'>
		<td >UF</td>
		<td >MUN.</td>
		<td >PROJ.</td>
		<td >CNPJ</td>
		<td >INSC. MOB.</td>
		<td >ENTRADA CADIN</td>
		<td ></td>
		<?php 	
		foreach($subAreas as $key => $subArea){ 	
		?>									
			<td colspan=3 style='text-align:center;font-size:11px;border: 3px solid black;'> <?php echo$subArea->nome ?></td>
		<?php
		}
		?>
		</tr>
		<tbody id='lista'>
		<tr style='text-align:center;font-size:11px;border: 3px solid black;' >
		<?php 					
			echo imprime(7);
		?>	
		<td  >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >A&Ccedil;&Atilde;O </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>	
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>		
		</tr>		
		
		<?php 	
		foreach($dados as $key => $dado){ 	
		?>	
		<tr style='text-align:center;font-size:11px;border: 3px solid black;'>		
		<td  > <?php echo$dado->estado ?></td>
		<td  > <?php echo$dado->cidade ?></td>
		<td  > <?php echo$dado->proj_desc ?></td>
		<td  > <?php echo$dado->cpf_cnpj ?></td>
		<td  > <?php echo$dado->ins_cnd_mob ?></td>
		<td  > <?php echo$dado->entrada_cadin ?></td>
		<td  > </td>
		<?php 
			switch ($dado->id_area) {
			case 1:
				if($dado->id_subarea == 1){
			?>	
				<td  > <?php echo$dado->tipo_deb_desc ?></td>
				<td  > <?php echo$dado->data_envio ?></td>
				<td  > <?php echo$dado->sla ?></td>
				<?php 					
					echo imprime(33);
				?>	
			<?php 
			}elseif($dado->id_subarea == 2){
			?>	

				<td > - </td>
				<td > - </td>
				<td > -  </td>
				<td  > <?php echo$dado->tipo_deb_desc ?></td>
				<td  > <?php echo$dado->data_envio ?></td>
				<td  > <?php echo$dado->sla ?></td>				
				<?php 	
					
					echo imprime(30);
					
				?>
			<?php 
			}else{
				echo imprime(6);
			?>					
				<td  >  <?php echo$dado->tipo_deb_desc ?></td>
				<td  > <?php echo$dado->data_envio ?></td>
				<td  > <?php echo$dado->sla ?></td>	
				<?php 
					echo imprime(27);
				?>							
			<?php
			}	
			break;
			case 2:
			if($dado->id_subarea == 4){
				echo imprime(9);
			?>					
				<td  > <?php echo$dado->tipo_deb_desc ?></td>
				<td  > <?php echo$dado->data_envio ?></td>
				<td  > <?php echo$dado->sla ?></td>	
			<?php 
				echo imprime(24);
			}elseif($dado->id_subarea == 5){
				echo imprime(12);
			?>	

				
				<td  > <?php echo$dado->tipo_deb_desc ?></td>
				<td  > <?php echo$dado->data_envio ?></td>
				<td  > <?php echo$dado->sla ?></td>				
				
				<?php 	
					echo imprime(21);
			}else{
					echo imprime(15);
				?>		

				<td  > <?php echo$dado->tipo_deb_desc ?></td>
				<td  > <?php echo$dado->data_envio ?></td>
				<td  > <?php echo$dado->sla ?></td>				
				<?php 	
					echo imprime(18);
			}	
			break;
			case 3:
			if($dado->id_subarea == 7){
				echo imprime(18);
			?>		
			<td  > <?php echo$dado->tipo_deb_desc ?></td>
			<td  > <?php echo$dado->data_envio ?></td>
			<td  > <?php echo$dado->sla ?></td>
			<?php 	
				echo imprime(15);
			}elseif($dado->id_subarea == 8){
				echo imprime(21);
			?>		

			<td  > <?php echo$dado->tipo_deb_desc ?></td>
			<td  > <?php echo$dado->data_envio ?></td>
			<td  > <?php echo$dado->sla ?></td>	
			<?php 	
				echo imprime(12);
			}else{
				echo imprime(24);
			?>		

				<td  > <?php echo$dado->tipo_deb_desc ?></td>
				<td  > <?php echo$dado->data_envio ?></td>
				<td  > <?php echo$dado->sla ?></td>				
				<?php 	
					echo imprime(9);
			}				
				break;
			case 4:
			if($dado->id_subarea == 10){
				echo imprime(27);
			?>		
			<td  > <?php echo$dado->tipo_deb_desc ?></td>
			<td  > <?php echo$dado->data_envio ?></td>
			<td  > <?php echo$dado->sla ?></td>
			<?php 	
				echo imprime(6);
			}elseif($dado->id_subarea == 11){
				echo imprime(30);
			?>		

			<td  > <?php echo$dado->tipo_deb_desc ?></td>
			<td  > <?php echo$dado->data_envio ?></td>
			<td  > <?php echo$dado->sla ?></td>	
			<?php 
				echo imprime(3);
			}else{
				echo imprime(33);
			?>		

				<td  > <?php echo$dado->tipo_deb_desc ?></td>
				<td  > <?php echo$dado->data_envio ?></td>
				<td  > <?php echo$dado->sla ?></td>				
				<?php 	
					echo imprime(0);
			}					
				break;				
		}
			 
		?>
		</tr>
		<tr>
		<?php
		}
		echo imprime(43);
		?>
		</tr>
		</tbody>
		
		</div>
	</div>	
	</body>
</html>
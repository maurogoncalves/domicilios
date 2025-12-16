<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.js'></script>
<link href='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.css' rel='stylesheet' />
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		$('.auto').autoNumeric('init');
		
	});
		var mask = {
		 money: function() {
			var el = this
			,exec = function(v) {
			v = v.replace(/\D/g,"");
			v = new String(Number(v));
			var len = v.length;
			if (1== len)
			v = v.replace(/(\d)/,"0.0$1");
			else if (2 == len)
			v = v.replace(/(\d)/,"0.$1");
			else if (len > 2) {
			v = v.replace(/(\d{2})$/,'.$1');
			}
			return v;
			};

			setTimeout(function(){
			el.value = exec(el.value);
			},1);
		}}
</script>		
<script type="text/javascript">	
		$(document).ready(function(){
		
		 $('input').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);                
        return (code == 13) ? false : true;
		});
		
		$('#form').submit(function(event){
		  if (form.checkValidity()) {
			send.attr('disabled', 'disabled');
		  }
		});

		
			$('#cep').blur(function(){
			   var cep = $("#cep").val();
				   if(cep != '__.___-___'){
						$.ajax({

							url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaCep?cep=" + cep,

							type : 'get',

							contentType: "application/json; charset=utf-8",

							dataType: 'json', 

							success: function(data){

								if(data !== 0){									

									$("#logradouro").val(data.logradouro);
									$("#bairro").val(data.bairro);
									$("#cidade").val(data.cidade);
									$("#estado").val(data.uf);


								}

							}

						});

					}		

				})
				
			$( "#emitente" ).change(function() {
				var emitente = $('#emitente').val();				
				$.ajax({

					url: "<?php echo $this->config->base_url(); ?>index.php/loja/busca?emitente=" + emitente,
					type : 'GET', 
					contentType: "application/json; charset=utf-8",
					dataType: 'json', 
					success: function(data){	

						if (data == undefined ) {
							console.log('Undefined');
						} else {

							$('#imovel').html(data);
						}
							
					}
				 }); 
				 
				 $.ajax({

					url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaCPFCNPJ?emitente=" + emitente,
					type : 'GET', 
					contentType: "application/json; charset=utf-8",
					dataType: 'json', 
					success: function(data){	

						if (data == 0 ) {
							$('#cpf_cnpj').val('CPF/CNPJ n\u00e3o foi cadastrado');
						} else {

							$('#cpf_cnpj').val(data);
						}
							
					}
				 }); 
				 
				 
				 $.ajax({

					url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/buscaLojaByEmitente?emitente=" + emitente,
					type : 'GET', 
					contentType: "application/json; charset=utf-8",
					dataType: 'json', 
					success: function(data){							
						$('#id_loja').html(data);
					}
				 }); 
				 
				 
			})
			
			$( "#id_estado" ).change(function() {
				var id_estado = $('#id_estado').val();	
				
				$.ajax({

					url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaCidadeImByEstado?id_estado=" + id_estado,
					type : 'GET', 
					contentType: "application/json; charset=utf-8",
					dataType: 'json', 
					success: function(data){	
						if (data == undefined ) {
							console.log('Undefined');
						} else {
							$('#id_cidade').html(data);
						}						
					}
				 }); 
				 
				 $.ajax({

					url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaEmitente?id_estado=" + id_estado,
					type : 'GET', 
					contentType: "application/json; charset=utf-8",
					dataType: 'json', 
					success: function(data){	

						if (data == undefined ) {
							console.log('Undefined');
						} else {

							$('#emitente').html(data);
						}
							
					}
				 }); 
			
			})

			$( "#id_cidade" ).change(function() {	
				var id_cidade = $('#id_cidade').val();	
				 $.ajax({

					url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaEmitenteByCidade?id_cidade=" + id_cidade,
					type : 'GET', 
					contentType: "application/json; charset=utf-8",
					dataType: 'json', 
					success: function(data){	

						if (data == undefined ) {
							console.log('Undefined');
						} else {

							$('#emitente').html(data);
						}
							
					}
				 }); 
			})
			
			$( "#cei" ).blur(function() {
				var cei = $('#cei').val();	
				$.ajax({

					url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/buscaceiExistente?cei=" + cei,
					type : 'GET', 
					contentType: "application/json; charset=utf-8",
					dataType: 'json', 
					success: function(data){	

						if (data.total !== '0' ) {
							alert('Esse n\u00famero de Cei j\u00e1 existe')
							$('#cei').focus();	
						} 
							
					}
				 }); 
			})		

			$("#area_existente" ).blur(function() {
				
				var area_existente = $("#area_existente").val();
				if(area_existente=="" || area_existente == undefined){
					area_existente = '0,00';
				}
				area_existente = area_existente.replace(".","");
				area_existente = area_existente.replace(",",".");
				area_existente = parseFloat( area_existente );

				
				
				var area_reforma = $("#area_reforma").val();
				if(area_reforma=="" || area_reforma == undefined){
					area_reforma = '0,00';
				}
				area_reforma = area_reforma.replace(".","");
				area_reforma = area_reforma.replace(",",".");
				area_reforma = parseFloat( area_reforma );

				
				var area_demolicao = $("#area_demolicao").val();
				if(area_demolicao=="" || area_demolicao == undefined){
					area_demolicao = '0,00';
				}
				area_demolicao = area_demolicao.replace(".","");
				area_demolicao = area_demolicao.replace(",",".");
				area_demolicao = parseFloat( area_demolicao );

				
				var area_acres_nova = $("#area_acres_nova").val();
				if(area_acres_nova=="" || area_acres_nova == undefined){
					area_acres_nova = '0,00';
				}
				area_acres_nova = area_acres_nova.replace(".","");
				area_acres_nova = area_acres_nova.replace(",",".");
				area_acres_nova = parseFloat( area_acres_nova );

				
				var total = area_existente + area_demolicao + area_acres_nova ;
				total = total.toFixed(2);	
				
				
				 $.ajax({
						url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/converter?total=" + total,
						type : 'GET', /* Tipo da requisição */ 
						contentType: "application/json; charset=utf-8",
						dataType: 'json', /* Tipo de transmissão */
						success: function(data){						
							if (data == undefined ) {
								console.log('Undefined');
							} else {
								$("#area_total").val(data);
							}
								
						}
					 });
								
			});
			
			$("#area_reforma" ).blur(function() {
				
				var area_existente = $("#area_existente").val();
				if(area_existente=="" || area_existente == undefined){
					area_existente = '0,00';
				}
				area_existente = area_existente.replace(".","");
				area_existente = area_existente.replace(",",".");
				area_existente = parseFloat( area_existente );

				
				
				var area_reforma = $("#area_reforma").val();
				if(area_reforma=="" || area_reforma == undefined){
					area_reforma = '0,00';
				}
				area_reforma = area_reforma.replace(".","");
				area_reforma = area_reforma.replace(",",".");
				area_reforma = parseFloat( area_reforma );

				
				var area_demolicao = $("#area_demolicao").val();
				if(area_demolicao=="" || area_demolicao == undefined){
					area_demolicao = '0,00';
				}
				area_demolicao = area_demolicao.replace(".","");
				area_demolicao = area_demolicao.replace(",",".");
				area_demolicao = parseFloat( area_demolicao );

				
				var area_acres_nova = $("#area_acres_nova").val();
				if(area_acres_nova=="" || area_acres_nova == undefined){
					area_acres_nova = '0,00';
				}
				area_acres_nova = area_acres_nova.replace(".","");
				area_acres_nova = area_acres_nova.replace(",",".");
				area_acres_nova = parseFloat( area_acres_nova );

				
				var total = area_reforma ;
				total = total.toFixed(2);	
				
				
				 $.ajax({
						url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/converter?total=" + total,
						type : 'GET', /* Tipo da requisição */ 
						contentType: "application/json; charset=utf-8",
						dataType: 'json', /* Tipo de transmissão */
						success: function(data){						
							if (data == undefined ) {
								console.log('Undefined');
							} else {
								$("#area_total").val(data);
							}
								
						}
					 });
								
			});
			
			$("#area_demolicao" ).blur(function() {
				
				var area_existente = $("#area_existente").val();
				if(area_existente=="" || area_existente == undefined){
					area_existente = '0,00';
				}
				area_existente = area_existente.replace(".","");
				area_existente = area_existente.replace(",",".");
				area_existente = parseFloat( area_existente );

				
				
				var area_reforma = $("#area_reforma").val();
				if(area_reforma=="" || area_reforma == undefined){
					area_reforma = '0,00';
				}
				area_reforma = area_reforma.replace(".","");
				area_reforma = area_reforma.replace(",",".");
				area_reforma = parseFloat( area_reforma );

				
				var area_demolicao = $("#area_demolicao").val();
				if(area_demolicao=="" || area_demolicao == undefined){
					area_demolicao = '0,00';
				}
				area_demolicao = area_demolicao.replace(".","");
				area_demolicao = area_demolicao.replace(",",".");
				area_demolicao = parseFloat( area_demolicao );

				
				var area_acres_nova = $("#area_acres_nova").val();
				if(area_acres_nova=="" || area_acres_nova == undefined){
					area_acres_nova = '0,00';
				}
				area_acres_nova = area_acres_nova.replace(".","");
				area_acres_nova = area_acres_nova.replace(",",".");
				area_acres_nova = parseFloat( area_acres_nova );

				
				var total = area_existente +  area_demolicao + area_acres_nova ;
				total = total.toFixed(2);	
				
				
				 $.ajax({
						url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/converter?total=" + total,
						type : 'GET', /* Tipo da requisição */ 
						contentType: "application/json; charset=utf-8",
						dataType: 'json', /* Tipo de transmissão */
						success: function(data){						
							if (data == undefined ) {
								console.log('Undefined');
							} else {
								$("#area_total").val(data);
							}
								
						}
					 });
								
			});
			
			$("#area_acres_nova" ).blur(function() {
				
				var area_existente = $("#area_existente").val();
				if(area_existente=="" || area_existente == undefined){
					area_existente = '0,00';
				}
				area_existente = area_existente.replace(".","");
				area_existente = area_existente.replace(",",".");
				area_existente = parseFloat( area_existente );

				
				
				var area_reforma = $("#area_reforma").val();
				if(area_reforma=="" || area_reforma == undefined){
					area_reforma = '0,00';
				}
				area_reforma = area_reforma.replace(".","");
				area_reforma = area_reforma.replace(",",".");
				area_reforma = parseFloat( area_reforma );

				
				var area_demolicao = $("#area_demolicao").val();
				if(area_demolicao=="" || area_demolicao == undefined){
					area_demolicao = '0,00';
				}
				area_demolicao = area_demolicao.replace(".","");
				area_demolicao = area_demolicao.replace(",",".");
				area_demolicao = parseFloat( area_demolicao );

				
				var area_acres_nova = $("#area_acres_nova").val();
				if(area_acres_nova=="" || area_acres_nova == undefined){
					area_acres_nova = '0,00';
				}
				area_acres_nova = area_acres_nova.replace(".","");
				area_acres_nova = area_acres_nova.replace(",",".");
				area_acres_nova = parseFloat( area_acres_nova );

				
				var total = area_existente +  area_demolicao + area_acres_nova ;
				total = total.toFixed(2);	
				
				
				 $.ajax({
						url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/converter?total=" + total,
						type : 'GET', /* Tipo da requisição */ 
						contentType: "application/json; charset=utf-8",
						dataType: 'json', /* Tipo de transmissão */
						success: function(data){						
							if (data == undefined ) {
								console.log('Undefined');
							} else {
								$("#area_total").val(data);
							}
								
						}
					 });
								
			});
		});



    </script>      <div id="wrapper">                <div class="content-wrapper container">                    <div class="row">                        <div class="col-sm-12">                            <div class="page-title">                                <h1>Cadastrar Matricula Cei<small></small></h1>                                <ol class="breadcrumb">                                    <li><a href="<?php echo $this->config->base_url();?>index.php/matricula_cei/listar"><i class="fa fa-home"></i>Listar  Matricula Cei</a></li>                                    <li class="active">Cadastrar  Matricula Cei</li>                                </ol>                            </div>                        </div>                    </div><!-- end .page title-->                                <div class="row">                                               <div class="col-md-12">                            <div class="panel panel-card margin-b-30">                                <!-- Start .panel -->                                <div class="panel-heading">                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da  Matricula Cei</h4>                                    <div class="panel-actions">                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>                                    </div>                                </div>								<?php								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );								echo form_open('matricula_cei/cadastrar_cei', $attributes); 								?>                                <div class="panel-body">                                 <form class="form-horizontal">                                <div class="form-group">									<label class="col-lg-2 control-label">Estado</label>                                    <div class="col-lg-1">										<select name="id_estado" id="id_estado" required=""  class='custom-select' style='height:30px'>											 <option value="0">Escolha</option>										  											 <?php foreach($estados as $key => $estado){ ?>									 											 <option value="<?php echo $estado->estado ?>"><?php echo $estado->estado?></option>											 <?php									  											 }								  									 											 ?>																				 </select>                                         </div>									<label class="col-lg-2 control-label">Cidade</label>                                    <div class="col-lg-1">										<select name="id_cidade" id="id_cidade" required=""  class='custom-select' style='height:30px'>												<option value="0">Escolha</option>																					<?php foreach($cidades as $key => $cidade){ ?>									 											<option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>												<?php									  											}								  									  											?>																			</select>      										</div>									<label class="col-lg-2 control-label">Emitente</label>                                    <div class="col-lg-2">									<select name="id_emitente" id="emitente" required=""  class='custom-select' style='height:30px'>										<option value="0">Escolha</option>										 										<?php foreach($emitentes as $key => $emitente){ ?>									 										<option value="<?php echo $emitente->id ?>"><?php echo $emitente->nome_fantasia?></option>												<?php									  }								  									  										?>																			</select>                                              </div>										                                </div>                                <div class="form-group">																		<label class="col-lg-2 control-label">Im&oacute;vel</label>									<div class="col-lg-4">										<select name="id_imovel" id="imovel" required=""  class='form-control' style='height:30px'> </select>    									                                    </div>																		<label class="col-sm-2 control-label">CPF/CNPJ do Emitente</label>                                    <div class="col-lg-4">                                      	<input type="text" readonly='yes' name='cpf_cnpj' id='cpf_cnpj' class="form-control"  required="">                                     </div>																											                                </div>								<div class="form-group">									<label class="col-sm-2 control-label">Loja</label>                                    <div class="col-lg-2">                                      	 <select name="id_loja" id="id_loja"  class='custom-select' style='height:30px'>										</select>                                    </div>																		<label class="col-lg-2 control-label">CEI</label>                                    <div class="col-lg-2">									 <input type="text" name='cei' id='cei'  class="form-control"   required="" data-masked="" data-inputmask="'mask': '99.999.99999/99' " >                                    </div>									<label class="col-lg-2 control-label">Data de Abertura da CEI</label>									                                    <div class="col-lg-2">									<input type="text" name='data_abertura_cei' id='data_abertura_cei'   class="form-control"  required="" data-masked="" data-inputmask="'mask': '99/99/9999' ">							                                    </div>																		                                </div>								                                <div class="form-group">									                                </div>	                                <div class="form-group">									<label class="col-lg-2 control-label">Tipo de Empreitada</label>                                    <div class="col-lg-1">									 <select name="tipo_empreitada" id="tipo_empreitada" required=""  class='custom-select' style='height:30px'>										<option value="0">Escolha</option>											<?php foreach($tipo_empreitada as $key => $tipo){ ?>											<option value="<?php echo $tipo->id ?>"><?php echo $tipo->descricao?></option>											<?php   }  ?>									</select>                                    </div>									<label class="col-lg-2 control-label">Tipo de Obra</label>                                    <div class="col-lg-1">									<select name="tipo_obra" id="tipo_obra" required=""  class='custom-select' style='height:30px'>									<option value="0">Escolha</option>										<?php foreach($tipo_obra as $key => $tipo){ ?>										<option value="<?php echo $tipo->id ?>"><?php echo $tipo->descricao?></option>										<?php  } ?>									</select>                                    </div>																		<label class="col-lg-2 control-label">Status de Obra</label>                                    <div class="col-lg-1">										<select name="status_obra" id="tipo_empreitada" required=""  class='custom-select' style='height:30px'>										<option value="0">Escolha</option>											<option value="1">Aberta</option>											<option value="2">Encerrada</option>											</select>                                    </div>																		<label class="col-lg-2 control-label">Averbado?</label>                                    <div class="col-lg-1">										<select name="averbado" id="averbado" required=""  class='custom-select' style='height:30px'>											<option value="0">Escolha</option>												<option value="1">N&atilde;o</option>												<option value="2">Sim</option>											</select>                                    </div>									                                </div>																			<div class="form-group">									<label class="col-lg-2 control-label">Data Início da Obra</label>                                    <div class="col-lg-2"><input type="text" name='data_ini_obra' id='data_ini_obra'   class="form-control"  required="" data-masked="" data-inputmask="'mask': '99/99/9999' ">							                                    </div>									<label class="col-lg-2 control-label">&Aacute;rea Existente</label>                                    <div class="col-lg-2"><input type="text"  id='area_existente' name='area_existente' data-a-dec="," data-a-sep="."  class="auto form-control"     >                                    </div>																		<label class="col-lg-2 control-label">&Aacute;rea Reforma</label>                                    <div class="col-lg-2"><input type="text"  id='area_reforma' name='area_reforma' data-a-dec="," data-a-sep="."  class="auto form-control"     >                                      </div>                                </div>																<div class="form-group">																		<label class="col-lg-2 control-label">&Aacute;rea Demoli&ccedil;&atilde;o</label>                                    <div class="col-lg-2"><input type="text"  id='area_demolicao' name='area_demolicao' data-a-dec="," data-a-sep="."  class="auto form-control"     >                                      </div>																		<label class="col-lg-2 control-label">&Aacute;rea Acr&eacute;scimo/Nova Obra</label>                                    <div class="col-lg-2"><input type="text"  id='area_acres_nova' name='area_acres_nova' data-a-dec="," data-a-sep="."  class="auto form-control"     >  									                                    </div>									<label class="col-lg-2 control-label">&Aacute;rea Resultante</label>                                    <div class="col-lg-2"><input type="text"  id='area_total' name='area_total' data-a-dec="," data-a-sep="."  class="auto form-control"     >                                      </div>																		                                </div>																								<div class="form-group">									<label class="col-lg-2 control-label">Alvar&aacute;</label>                                    <div class="col-lg-1">									<input type="radio" id="alvara" name="alvara" value="1" checked> Sim 									<bR>									<input type="radio" id="alvara" name="alvara" value="2"> N&atilde;o								                                    </div>																		<label class="col-lg-2 control-label">Projeto</label>                                    <div class="col-lg-1">									<input type="radio" id="projeto" name="projeto" value="1" checked> Sim 									<bR>									<input type="radio" id="projeto" name="projeto" value="2"> N&atilde;o                                    </div>																			<label class="col-lg-2 control-label">Contrato Obra</label>																		 <div class="col-lg-1">										<input type="radio" id="contrato_obra" name="contrato_obra" value="1" checked> Sim 										<br>										<input type="radio" id="contrato_obra" name="contrato_obra" value="2"> N&atilde;o									 </div>									 									 <label class="col-lg-2 control-label">Contrato Loca&ccedil;&atilde;o Matr&iacute;cula Im&oacute;vel Escritura</label>																		 <div class="col-lg-1">										<input type="radio" id="contr_loc_matr_escr" name="contr_loc_matr_escr" value="1" checked> Sim 										<br>										<input type="radio" id="contr_loc_matr_escr" name="contr_loc_matr_escr" value="2"> N&atilde;o									 </div>								</div>																<div class="form-group">																		 									 <label class="col-lg-2 control-label">Habite-se</label>																		 <div class="col-lg-1">										<input type="radio" id="habitese" name="habitese" value="1" checked> Sim &nbsp;&nbsp;&nbsp;										<br>										<input type="radio" id="habitese" name="habitese" value="2"> N&atilde;o &nbsp;&nbsp;&nbsp;									 </div>									 									 <label class="col-lg-2 control-label">Nota Fiscal</label>																		 <div class="col-lg-1">										<input type="radio" id="nota_fiscal" name="nota_fiscal" value="1" checked> Sim &nbsp;&nbsp;&nbsp;										<br>										<input type="radio" id="nota_fiscal" name="nota_fiscal" value="2"> N&atilde;o &nbsp;&nbsp;&nbsp;									 </div>									 									<label class="col-lg-2 control-label">GPS 2631</label>																		 <div class="col-lg-1">										<input type="radio" id="gps_2631" name="gps_2631" value="1" checked> Sim 										<br>										<input type="radio" id="gps_2631" name="gps_2631" value="2"> N&atilde;o &nbsp;&nbsp;&nbsp;									 </div>									 									  <label class="col-lg-2 control-label">Relatório SEFIP</label>																		 <div class="col-lg-1">										<input type="radio" id="relatorio_sefip" name="relatorio_sefip" value="1" checked> Sim										<br>											<input type="radio" id="relatorio_sefip" name="relatorio_sefip" value="2"> N&atilde;o 									</div>																</div>																								<div class="form-group">																		 									 									 																									</div>																<div class="form-group">									<label class="col-lg-2 control-label">Regional</label>									<div class="col-lg-3">									 <select name="regional" id="regional" required=""  class='custom-select' style='width:350px;height:30px'>									<option value="0">Escolha</option>										<?php foreach($regionais as $key => $regional){ ?>									<option value="<?php echo $regional->id ?>"><?php echo $regional->descricao?></option>										<?php }	 ?>									</select>									 </div>									 									 <label class="col-lg-2 control-label">Bandeira</label>									<div class="col-lg-3">									<select name="bandeira" id="bandeira" required=""  class='custom-select' style='width:350px;height:30px'>									<option value="0" selected>Escolha</option>										<?php foreach($bandeiras as $key => $bandeira){ ?>										<option value="<?php echo $bandeira->id ?>"><?php echo $bandeira->descricao_bandeira?></option>									<?php }  ?>									</select>									 </div>																 </div>								 								 <div class="form-group">									<label class="col-lg-2 control-label">Observações</label>									<div class="col-lg-10">									 <input type="text" name='obs' id='obs' class="form-control" >									 </div>									 																									 </div>								 								<div class="form-group">									<label class="col-lg-2 control-label">CEP</label>                                    <div class="col-lg-1"><input type="text" id='cep' name='cep' class="form-control"  data-masked="" data-inputmask="'mask': '99.999-999' ">                                          </div>									<label class="col-lg-2 control-label">N&uacute;mero</label>                                    <div class="col-lg-1"><input type="text" name='numero' class="form-control"  >                                       </div>									<label class="col-lg-2 control-label">Endere&ccedil;o</label>                                    <div class="col-lg-4"><input type="text" name='logradouro' id='logradouro' class="form-control" >                                     </div>                                </div>																									<div class="form-group">									<label class="col-lg-2 control-label">Bairro</label>                                    <div class="col-lg-3"><input type="text" name='bairro' id='bairro' class="form-control" >                                       </div>									<label class="col-lg-2 control-label">Cidade</label>                                    <div class="col-lg-3"><input type="text" name='cidade' id='cidade' class="form-control" >                                      </div>																		<label class="col-lg-1 control-label">UF</label>                                    <div class="col-lg-1"><input type="text" name='estado' id='uf' class="form-control" >  									                                    </div>                                </div>																								<div class="hr-line-dashed"></div>                                <div class="form-group">                                    <div class="col-sm-4 col-sm-offset-2">                                        <button class="btn btn-white" type="submit">Cancelar</button>                                        <button class="btn btn-primary" type="submit">Salvar</button>                                    </div>                                </div>                            </form>                                </div>                            </div>                        </div>                    </div>                                    </div>             </div>
	 
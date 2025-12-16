<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>


<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script> 
<script type="text/javascript">     

jQuery(function($) {
    $('.auto').autoNumeric('init');
	
});



var mask = {		 
	money: function() {			
		var el = this,exec = function(v) {			
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
	el.value = exec(el.value);			},1);		
	}
}			

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

	$( "#id_estado" ).change(function() {				

		var id_estado = $('#id_estado').val();									

		$.ajax({					

			url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaCidadeByEstadoTipo?id_estado=" + id_estado,

			type : 'GET', /* Tipo da requisição */ 					

			contentType: "application/json; charset=utf-8",					

			dataType: 'json', /* Tipo de transmissão */					

			success: function(data){							

				if (data == undefined ) {							

					console.log('Undefined');						

				} else {							

					$('#id_cidade').html(data);						

				}												

			}				 

		}); 				 				 

		$.ajax({					

			url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaLojaByEstadoTipo?id_estado=" + id_estado,

			type : 'GET', /* Tipo da requisição */ 					

			contentType: "application/json; charset=utf-8",					

			dataType: 'json', /* Tipo de transmissão */					

			success: function(data){							

				if (data == undefined ) {							

					console.log('Undefined');					

				} else {							

					$('#loja').html(data);						

				}												

			}				 

		}); 						

	})			

	$( "#loja" ).change(function() {				
		var loja = $('#loja').val();								
		$.ajax({					
			url: "<?php echo $this->config->base_url(); ?>index.php/infracoes/buscaDadosLoja?loja=" + loja,					
			type : 'GET', /* Tipo da requisição */ 					
			contentType: "application/json; charset=utf-8",					
			dataType: 'json', /* Tipo de transmissão */					
			success: function(data){							
				if (data == 0 ) {							

					$('#cnpj').val(data.cpf_cnpj);						
					$('#codloja').val(data.cod1);						
					$('#bandeira').val(data.bandeira);						
					$('#regional').val(data.regional);						

				} else {

					$('#cnpj').val(data.cpf_cnpj);						
					$('#codloja').val(data.cod1);						
					$('#bandeira').val(data.bandeira);						
					$('#regional').val(data.regional);						

				}												
				}				 
		}); 				 				  			 				 				 			
	})
	
	$( "#id_cidade" ).change(function() {				

		var id_cidade = $('#id_cidade').val();									 				 

			$.ajax({					

				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaLojaByCidadeTipo?id_cidade=" + id_cidade,	

				type : 'GET', /* Tipo da requisição */ 					

				contentType: "application/json; charset=utf-8",					

				dataType: 'json', /* Tipo de transmissão */					

				success: function(data){							

					if (data == undefined ) {							

						console.log('Undefined');					

					} else {							

						$('#loja').html(data);						

					}												

				}				 

			}); 						

		})	

		
	$( "#valor_principal" ).blur(function() {	
		var total = 0;
		var valor_principal = $("#valor_principal").val();
		var atualizacao_monetaria = $("#atualizacao_monetaria").val();
		var multa = $("#multa").val();
		var juros = $("#juros").val();
		
		valor_principal = valor_principal.replace(".","");
		valor_principal = valor_principal.replace(",",".");
		valor_principal = parseFloat( valor_principal );
		
		atualizacao_monetaria = atualizacao_monetaria.replace(".","");
		atualizacao_monetaria = atualizacao_monetaria.replace(",",".");
		atualizacao_monetaria = parseFloat( atualizacao_monetaria );
		//atualizacao_monetaria = atualizacao_monetaria.toFixed(2);
		
		multa = multa.replace(".","");
		multa = multa.replace(",",".");
		multa = parseFloat( multa );
		//multa = multa.toFixed(2);
		
		juros = juros.replace(".","");
		juros = juros.replace(",",".");
		juros = parseFloat( juros );
		//juros = juros.toFixed(2);
		
		var total = valor_principal + atualizacao_monetaria + multa + juros;
		
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/converter?total=" + total,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						//$('#totalVlrPago').val(data);
						$("#total").val(data);
					}
						
				}
			 });
			 

		
	})
	
	$( "#atualizacao_monetaria" ).blur(function() {	
		var total = 0;
		var valor_principal = $("#valor_principal").val();
		var atualizacao_monetaria = $("#atualizacao_monetaria").val();
		var multa = $("#multa").val();
		var juros = $("#juros").val();
		
		valor_principal = valor_principal.replace(".","");
		valor_principal = valor_principal.replace(",",".");
		valor_principal = parseFloat( valor_principal );
		
		atualizacao_monetaria = atualizacao_monetaria.replace(".","");
		atualizacao_monetaria = atualizacao_monetaria.replace(",",".");
		atualizacao_monetaria = parseFloat( atualizacao_monetaria );
		//atualizacao_monetaria = atualizacao_monetaria.toFixed(2);
		
		multa = multa.replace(".","");
		multa = multa.replace(",",".");
		multa = parseFloat( multa );
		//multa = multa.toFixed(2);
		
		juros = juros.replace(".","");
		juros = juros.replace(",",".");
		juros = parseFloat( juros );
		//juros = juros.toFixed(2);
		
		var total = valor_principal + atualizacao_monetaria + multa + juros;
		
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/converter?total=" + total,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						//$('#totalVlrPago').val(data);
						$("#total").val(data);
					}
						
				}
			 });
			 

		
	})	
	
	$( "#multa" ).blur(function() {	
		var total = 0;
		var valor_principal = $("#valor_principal").val();
		var atualizacao_monetaria = $("#atualizacao_monetaria").val();
		var multa = $("#multa").val();
		var juros = $("#juros").val();
		
		valor_principal = valor_principal.replace(".","");
		valor_principal = valor_principal.replace(",",".");
		valor_principal = parseFloat( valor_principal );
		
		atualizacao_monetaria = atualizacao_monetaria.replace(".","");
		atualizacao_monetaria = atualizacao_monetaria.replace(",",".");
		atualizacao_monetaria = parseFloat( atualizacao_monetaria );
		//atualizacao_monetaria = atualizacao_monetaria.toFixed(2);
		
		multa = multa.replace(".","");
		multa = multa.replace(",",".");
		multa = parseFloat( multa );
		//multa = multa.toFixed(2);
		
		juros = juros.replace(".","");
		juros = juros.replace(",",".");
		juros = parseFloat( juros );
		//juros = juros.toFixed(2);
		
		var total = valor_principal + atualizacao_monetaria + multa + juros;
		
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/converter?total=" + total,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						//$('#totalVlrPago').val(data);
						$("#total").val(data);
					}
						
				}
			 });
			 

	})	
	
	$( "#juros" ).blur(function() {	
		var total = 0;
		var valor_principal = $("#valor_principal").val();
		var atualizacao_monetaria = $("#atualizacao_monetaria").val();
		var multa = $("#multa").val();
		var juros = $("#juros").val();
		
		valor_principal = valor_principal.replace(".","");
		valor_principal = valor_principal.replace(",",".");
		valor_principal = parseFloat( valor_principal );
		
		atualizacao_monetaria = atualizacao_monetaria.replace(".","");
		atualizacao_monetaria = atualizacao_monetaria.replace(",",".");
		atualizacao_monetaria = parseFloat( atualizacao_monetaria );
		//atualizacao_monetaria = atualizacao_monetaria.toFixed(2);
		
		multa = multa.replace(".","");
		multa = multa.replace(",",".");
		multa = parseFloat( multa );
		//multa = multa.toFixed(2);
		
		juros = juros.replace(".","");
		juros = juros.replace(",",".");
		juros = parseFloat( juros );
		//juros = juros.toFixed(2);
		
		var total = valor_principal + atualizacao_monetaria + multa + juros;
		
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/converter?total=" + total,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						//$('#totalVlrPago').val(data);
						$("#total").val(data);
					}
						
				}
			 });
			 
	})	

	$( "#total" ).blur(function() {
		var total = 0;
		var valor_principal = $("#valor_principal").val();
		var atualizacao_monetaria = $("#atualizacao_monetaria").val();
		var multa = $("#multa").val();
		var juros = $("#juros").val();
		
		valor_principal = valor_principal.replace(".","");
		valor_principal = valor_principal.replace(",",".");
		valor_principal = parseFloat( valor_principal );
		
		atualizacao_monetaria = atualizacao_monetaria.replace(".","");
		atualizacao_monetaria = atualizacao_monetaria.replace(",",".");
		atualizacao_monetaria = parseFloat( atualizacao_monetaria );
		//atualizacao_monetaria = atualizacao_monetaria.toFixed(2);
		
		multa = multa.replace(".","");
		multa = multa.replace(",",".");
		multa = parseFloat( multa );
		//multa = multa.toFixed(2);
		
		juros = juros.replace(".","");
		juros = juros.replace(",",".");
		juros = parseFloat( juros );
		//juros = juros.toFixed(2);
		
		var total = valor_principal + atualizacao_monetaria + multa + juros;
		$("#total").val(total);		
	})	

});   

 </script>           

 
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Cadastrar Infra&ccedil;&atilde;o<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/infracoes/listar"><i class="fa fa-home"></i>Listar Infra&ccedil;&atilde;o</a></li>
                                    <li class="active">Cadastrar Infra&ccedil;&atilde;o</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da Infra&ccedil;&atilde;o</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('infracoes/cadastrar_infracao', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group">
									<label class="col-lg-2 control-label">Estado</label>
                                    <div class="col-lg-4">
										<select name="id_estado" id="id_estado" required=""  class='custom-select' style='width:350px;height:30px'>
											 <option value="0">Escolha</option>										  
											 <?php foreach($estados as $key => $estado){ ?>									 
											 <option value="<?php echo $estado->estado ?>"><?php echo $estado->estado?></option>
											 <?php									  
											 }								  									 
											 ?>									
											 </select>     
                                    </div>
									<label class="col-lg-2 control-label">Cidade</label>
                                    <div class="col-lg-4">
										<select name="id_cidade" id="id_cidade" required=""  class='custom-select' style='width:350px;height:30px'>	
											<option value="0">Escolha</option>										
											<?php foreach($cidades as $key => $cidade){ ?>									 
											<option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>	
											<?php									  
											}								  									  
											?>								
											</select>      
										</div>									
                                </div>
                                <div class="form-group">
									<label class="col-lg-2 control-label">Loja</label>
                                    <div class="col-lg-4">
									<select name="id_loja" id="loja" required=""  class='custom-select' style='width:350px;height:30px'>
										<option value="0">Escolha</option>										 
										<?php foreach($lojas as $key => $loja){ ?>									  
											<option value="<?php echo $loja->id ?>"><?php echo $loja->nome_fantasia?></option>		
										<?php	}?>										
										</select>          
                                    </div>
									<label class="col-sm-2 control-label">CNPJ</label>
                                    <div class="col-lg-4">
                                      	<input type="text" readonly='yes' name='cnpj' id='cnpj' class="form-control"  required=""> 
                                    </div>
									
                                </div>
								<div class="form-group">
									<label class="col-sm-2 control-label">C&oacute;d. 1</label>
                                    <div class="col-lg-2">
                                      	<input type="text" readonly='yes'  id='codloja' name='codloja' class="form-control" required=""    >
                                    </div>									
									<label class="col-sm-2 control-label">Bandeira</label>
                                    <div class="col-lg-2">
                                      	<input type="text" readonly='yes' id='bandeira' name='bandeira' class="form-control" required=""    >
                                    </div>		
									<label class="col-lg-2 control-label">Regional</label>
                                    <div class="col-lg-2">
									<input type="text" readonly='yes' id='regional' name='regional' class="form-control" required=""    >
                                    </div>									
                                </div>
		
                                <div class="form-group">
									<label class="col-lg-2 control-label">C&oacute;digo da Infra&ccedil;&atilde;o</label>
                                    <div class="col-lg-4">
									<input type="text"  id='infracao' name='infracao' class="form-control" tabindex="5"   >
                                    </div>
									<label class="col-lg-2 control-label">Tipo do Auto</label>
                                    <div class="col-lg-4">
									<select name="tipo_auto" id="tipo_auto" required="" tabindex="6" class='custom-select' style='width:160px;height:30px'>
										<option value="0">Escolha</option>										 										<?php foreach($tiposAuto as $key => $tipoAuto){ ?>												<option value="<?php echo $tipoAuto->id ?>" ><?php echo $tipoAuto->descricao?></option>												<?php  }	?>									
									</select>   

                                    </div>
									
									
                                </div>	
											<div class="form-group">									<label class="col-lg-2 control-label">Motivo da Infra&ccedil;&atilde;o</label>                                    <div class="col-lg-4">									<select name="motiv_infracao" id="motiv_infracao" required="" tabindex="7" class='custom-select' style='width:160px;height:30px'>										<option value="0">Escolha</option>										 											<?php foreach($motivoInfra as $key => $motivo){ ?>									  												<option value="<?php echo $motivo->id ?>"><?php echo $motivo->descricao?></option>														<?php									  											}?>																	</select> 						                                    </div>																		<label class="col-lg-2 control-label">Classifica&ccedil;&atilde;o</label>                                    <div class="col-lg-4">									<select name="class_infra" id="class_infra" required="" tabindex="7" class='custom-select' style='width:160px;height:30px'>										<option value="0">Escolha</option>										 										<?php foreach($classInfra as $key => $class){ 													if ($infracao[0]->id_classificacao == $class->id){	?>									  													<option value="<?php echo $class->id ?>" selected><?php echo $class->descricao?></option>															<?php }else{ ?>														<option value="<?php echo $class->id ?>"><?php echo $class->descricao?></option>															<?php }}?>																	</select> 												                                    </div>																		                                </div>								
                                <div class="form-group">
									
									<label class="col-lg-2 control-label">Breve Relato da Infra&ccedil;&atilde;o</label>
                                    <div class="col-lg-10"><input type="text"  id='breve_relato' name='breve_relato' tabindex="8" class="form-control"     >
                                    </div>
                                </div>
								
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Data Recebimento da Infra&ccedil;&atilde;o</label>
                                    <div class="col-lg-2">
									<input type="text" data-masked="" data-inputmask="'mask': '99/99/9999' " id='dt_receb_infra' name='dt_receb_infra' tabindex="9" class="form-control"   >
                                    </div>
									<label class="col-lg-2 control-label">Compet&ecirc;ncia Inicio </label>
                                    <div class="col-lg-2">
									<input type="text" data-masked="" data-inputmask="'mask': '99/9999' " id='dt_ini_comp' required="" name='dt_ini_comp' tabindex="10" class="form-control" required=""    >
                                    </div>
									<label class="col-lg-2 control-label">Compet&ecirc;ncia Fim</label>
                                    <div class="col-lg-2">
									<input type="text" data-masked="" data-inputmask="'mask': '99/9999' " id='dt_fim_comp' required="" name='dt_fim_comp' tabindex="11" class="form-control" required=""    >
                                    </div>
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Valor Principal</label>
                                    <div class="col-lg-2"><input type="text"  id='valor_principal' data-a-dec="," data-a-sep="." tabindex="12" name='valor_principal' class="auto  form-control" required="" value='0'    >  
                                    </div>
									<label class="col-lg-2 control-label">Atualiza&ccedil;&atilde;o Monet&aacute;ria </label>
                                    <div class="col-lg-2"><input type="text"  id='atualizacao_monetaria' data-a-dec="," data-a-sep="."  tabindex="13" name='atualizacao_monetaria' class="auto  form-control" required="" value='0'   >
                                    </div>
									
									<label class="col-lg-2 control-label">Multa</label>
                                    <div class="col-lg-2"><input type="text"  id='multa' name='multa' data-a-dec="," data-a-sep="." tabindex="14" class="auto  form-control" required="" value='0'   >
									
                                    </div>
									
									
									
                                </div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Juros </label>   
									<div class="col-lg-2">
										<input type="text"  id='juros' name='juros' data-a-dec="," data-a-sep="." tabindex="15" class="auto form-control" required=""  value='0'   >
									</div>																		<label class="col-lg-2 control-label">Total</label>                                    <div class="col-lg-2"><input type="text"  id='total' name='total' readonly='yes' class="form-control" required=""   > </div>																		<label class="col-lg-2 control-label">Valor Total Revisado </label>                                    <div class="col-lg-2"><input type="text"  id='total' name='total_revisado' tabindex="16" data-a-dec="," data-a-sep="."  class="auto form-control"    ></div>
								</div>

								<div class="form-group">

									<label class="col-lg-2 control-label">Valor Efetivo Pago </label>
                                    <div class="col-lg-2"><input type="text"  id='valor_efetivo_pago' data-a-dec="," data-a-sep="." tabindex="17" name='valor_efetivo_pago' class="auto form-control"   ></div>																		<label class="col-lg-2 control-label">Data planejada fim processo</label>									<div class="col-lg-2"><input type="text" data-masked="" data-inputmask="'mask': '99/99/9999' " id='dt_plan_fim' name='dt_plan_fim' tabindex="18" class="form-control"   ></div>									<label class="col-lg-2 control-label">Data de encerramento efetivo</label>									<div class="col-lg-2"><input type="text" data-masked="" data-inputmask="'mask': '99/99/9999' " id='dt_encer_efetivo' name='dt_encer_efetivo' tabindex="19" class="form-control"   ></div>																		
								</div>
								
								<div class="form-group">									<label class="col-lg-2 control-label">Status</label>                                    <div class="col-lg-2">									<select name="status" id="status" required=""  class='custom-select' style=''>										<option value="0">Escolha</option>								  									<?php foreach($status as $key => $st){ ?>										<option value="<?php echo $st->id ?>" ><?php echo $st->descricao?></option>										<?php								  									}								  							 									?>																	</select>   																		</div>									
									<label class="col-lg-2 control-label">Observa&ccedil;&otilde;es</label>
									<div class="col-lg-6"><input type="text"  id='obs' name='obs'  class="form-control" tabindex="20"    ></div>
								</div>
								
								
								
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($visitante == 0){ ?>
											<button class="btn btn-white" type="submit">Cancelar</button>
											<button class="btn btn-primary" type="submit">Salvar</button>
										<?php } ?>
                                    </div>
                                </div>
                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div> 
            </div>

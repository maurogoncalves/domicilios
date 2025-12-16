<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>

<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script>

<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>

<script src='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.js'></script>

<link href='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.css' rel='stylesheet' /> 



<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script> 

<script type="text/javascript">jQuery(function($) {    $('.auto').autoNumeric('init');	});</script>   

 

<script>		

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



	$( "#emitente" ).change(function() {				

		var emitente = $('#emitente').val();								

		var loja = $('#loja').val();								 				

		$.ajax({					

			url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaCPFCNPJ?emitente=" + emitente,					

			type : 'GET', /* Tipo da requisição */ 					

			contentType: "application/json; charset=utf-8",					

			dataType: 'json', /* Tipo de transmissão */					

			success: function(data){							

				if (data == 0 ) {							

					$('#cpf_cnpj').val('CPF/CNPJ n\u00e3o foi cadastrado');						

				} else {

				$('#cpf_cnpj').val(data);						

				}												

				}				 

		}); 				 				  

		$.ajax({					

			url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/buscaLojaEmitente?emitente=" + emitente+'&loja='+loja,

			type : 'GET', /* Tipo da requisição */ 					

			contentType: "application/json; charset=utf-8",					

			dataType: 'json', /* Tipo de transmissão */					

			success: function(data){							

				if (data !== "0" ) {							

					alert('Essa loja e Emitente j\u00e1 existem sublocados!');						

				} 					

			}				 

		}); 				 				 				 			

	})						

	

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

	$( "#dtini" ).blur(function() {							

		var dtini = $('#dtini').val();					

		var vigencia = $('#vigencia').val();								

			if(vigencia == 0){					

				alert('Escolha uma vig\u00eancia');					

				$('#vigencia').focus();				

			}

		$.ajax({					

			url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/calcularDataFinal?dtini=" + dtini +'&vigencia='+vigencia ,					

			type : 'GET', /* Tipo da requisição */ 					

			contentType: "application/json; charset=utf-8",					

			dataType: 'json', /* Tipo de transmissão */					

			success: function(data){							

				if (data == undefined ) {							

					console.log('Undefined');						

				} else {							

					$('#dtfim').val(data);							

					$('#receita').focus();						

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

});   

 </script>           

 

<div id="wrapper">
					<div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>SubLoca&ccedil;&atilde;o <small>		</small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/sublocacoes/listar"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Cadastro de SubLoca&ccedil;&atilde;o</li>
									
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da SubLoca&ccedil;&atilde;o</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('sublocacoes/editar_sublocacao', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group">
									<label class="col-lg-2 control-label">Estado</label>
                                    <div class="col-lg-4">
										<select name="id_estado" id="id_estado" required=""  tabindex="1" class='custom-select' style='width:350px;height:30px'>									  
										<option value="0">Escolha</option>										 
										<?php foreach($estados as $key => $estado){
										if ($dados[0]->estado == $estado->estado){
										?>									 
										<option value="<?php echo $estado->estado ?>" selected><?php echo $estado->estado?></option>
										<?php }else{	?>
										<option value="<?php echo $estado->estado ?>"><?php echo $estado->estado?></option>
										<?php }}?>								
									</select>                                 
                                    </div>
									<label class="col-lg-2 control-label">Cidade</label>
                                    <div class="col-lg-4">
										<select name="id_cidade" id="id_cidade" required=""  class='custom-select' style='width:350px;height:30px'>	
											<option value="0">Escolha</option>										
												<?php foreach($cidades as $key => $cidade){
													  if ($dados[0]->cidade == $cidade->cidade){
												?>
												<option value="<?php echo $cidade->cidade ?>" selected><?php echo $cidade->cidade?></option>
												<?php }else{	?>
												<option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>
												<?php									  
												}
												}								  									  

												?>							
											</select>      
										</div>									
                                </div>
                                <div class="form-group">
									<label class="col-lg-2 control-label">Lojas</label>
                                    <div class="col-lg-4">
									<select name="id_loja" id="loja" required="" tabindex="3" class='custom-select' style='width:350px;height:30px'>
										<option value="0">Escolha</option>										 
											<?php foreach($lojas as $key => $loja){
												 if ($dados[0]->id_loja == $loja->id){
												 ?>									  
												 <option value="<?php echo $loja->id ?>" selected><?php echo $loja->nome_fantasia?></option>
												 <?php }else{?>
												 <option value="<?php echo $loja->id ?>" ><?php echo $loja->nome_fantasia?></option>
												<?php }}?>				
									</select>      										
                                    </div>
									<label class="col-lg-2 control-label">Emitente</label>
									<div class="col-lg-4">
										<select name="id_emitente" id="emitente" required="" tabindex="4" class='custom-select' style='width:350px;height:30px'>									  
											<option value="0">Escolha</option>										 
											<?php foreach($emitentes as $key => $emitente){
												if ($dados[0]->id_emitente == $emitente->id){
												 ?>									 

													<option value="<?php echo $emitente->id ?>" selected><?php echo $emitente->nome_fantasia?></option>

													<?php } else {?>
													<option value="<?php echo $emitente->id ?>" ><?php echo $emitente->nome_fantasia?></option>
													  <?php

													} }

												?>
										</select>
                                    </div>
									
                                </div>
								<div class="form-group">
								<label class="col-sm-2 control-label">CPF/CNPJ do Emitente</label>
                                    <div class="col-lg-4">
										<input type="text" readonly='yes' name='cpf_cnpj' id='cpf_cnpj' class="form-control" value='<?php echo $dados[0]->cnpj ?>'> 
                                    </div>
									
									<label class="col-sm-2 control-label">Metragem locada</label>
                                    <div class="col-lg-4">
										<input type="text" name='metragem' required="" data-a-dec="," data-a-sep="."  class="auto form-control" value='<?php echo $dados[0]->metragem ?>'>                              
                                    </div>
									
                                </div>
								
                                <div class="form-group">
									<label class="col-lg-2 control-label">Atividade SubLocada</label>
                                    <div class="col-lg-4">
										<input type="text" name='atividade_sub_locada' tabindex="6" id='atividade_sub_locada' class="form-control" value='<?php echo $dados[0]->atividade_sublocada ?>' required=""> 
                                    </div>
									<label class="col-lg-2 control-label">Vig&ecirc;ncia do Contrato</label>
                                    <div class="col-lg-4">
									<select name="vigencia" id="vigencia" required="" tabindex="7" class='custom-select' style='width:350px;height:30px'>
											<option value="0">Escolha</option>
										<?php foreach($prazos as $key => $prazo){
											if ($dados[0]->prazo == $prazo->prazo){ ?>
											<option value="<?php echo $prazo->prazo;?>" selected><?php echo $prazo->prazo;?></option>
										   <?php }else{ ?>
										   <option value="<?php echo $prazo->prazo;?>"><?php echo $prazo->prazo;?></option>
										   <?php } ?>


										<?php

											}

										?>
									</select>  
                                    </div>
									
                                </div>	

                                <div class="form-group">
									<label class="col-lg-2 control-label">Data Inicial</label>
                                    <div class="col-lg-4">
										<input type="text" name='dtini' id='dtini' tabindex="8" class="form-control" value='<?php echo $dados[0]->data_ini_vigencia_br ?>' required="" data-masked="" data-inputmask="'mask': '99/99/9999' " >                              
                                    </div>
									<label class="col-lg-2 control-label">Data Final</label>
                                    <div class="col-lg-4">
										<input type="text" readonly='yes' name='dtfim' id='dtfim' class="form-control" value='<?php echo $dados[0]->data_fim_vigencia_br ?>' required="" data-masked="" data-inputmask="'mask': '99/99/9999' " >                              
                                    </div>
									
                                </div>	
								
								<div class="form-group">
									
									<label class="col-lg-2 control-label">Data Vencimento</label>
                                    <div class="col-lg-3">
										<input type="text"  name='dtvenc' tabindex="9" id='dtvenc' class="form-control"  required="" data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo $dados[0]->data_vencimento_br ?>' >                              
                                    </div>
									
									<label class="col-lg-2 control-label">Valor Aluguel (Mensal)</label>
                                    <div class="col-lg-4">
										<input type="text" name='valor' tabindex="9"  data-a-dec="," data-a-sep="." placeholder='<?php echo $dados[0]->valor_base; ?>' class="auto form-control" >
										<input type="hidden" name='valor_escondido' value='<?php echo $dados[0]->valor_base; ?>'  >
                                    </div>
                                </div>
		
                                <div class="form-group">
									<label class="col-lg-2 control-label">Tipo de Aluguel</label>
                                    <div class="col-lg-4">
									
											<?php foreach($receitas as $key => $receita){ ?>									
										   <?php if($receita->tem <> 0 ){?>
											<input type="checkbox" name="receita[]" disabled="disabled" checked="checked"  class='id_empresa' value="<?php echo $receita->id;?>">
											<?php echo $receita->descricao_receita?>
											 <?php }else{?>
											 <input type="checkbox" name="receita[]"  class='id_empresa' value="<?php echo $receita->id;?>">
											<?php echo $receita->descricao_receita?>
											  <?php }?>
												&nbsp;	&nbsp;&nbsp;										

											<?php								

												}

											?>        							
                                    </div>
									
                                </div>
								
								
																
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<input type="hidden" name='id_sub' id='id_sub' value='<?php echo $dados[0]->idsub ?>'   >
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

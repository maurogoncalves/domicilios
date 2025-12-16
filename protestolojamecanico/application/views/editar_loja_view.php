<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script> 
<script type="text/javascript">
jQuery(function($) {    
	$('.auto').autoNumeric('init');	});
</script>    
<script>		
	var mask = {		
		money: function() {			
		var el = this,
			exec = function(v) {			
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
	}
}	
</script>	
<script>		
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
		
		$('#insc').blur(function(){				
			var insc = $("#insc").val();				
			var emitente = $("#emitente").val();												 
				if(insc !== ''){				 					
					$.ajax({							
						url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaInscricao?inscricao=" + insc +"&emitente="+emitente,							
						type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 							
						contentType: "application/json; charset=utf-8",							
						dataType: 'json', /* Tipo de transmiss&atilde;o */							
						success: function(data){								
							if(data.total !== '0'){																		
								alert('Esse n\u00famero de inscri\u00e7\u00e3o, j\u00e1 existe para essa unidade');									
								$("#cpf_cnpj").focus();								
							}							
						}						
					});				 				 
				}								
		});						
		$('#cep').blur(function(){			   
			var cep = $("#cep").val();				   
			if(cep != '__.___-___'){						
			$.ajax({							
				url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaCep?cep=" + cep,							
				type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 							
				contentType: "application/json; charset=utf-8",							
				dataType: 'json', /* Tipo de transmiss&atilde;o */							
				success: function(data){								
					if(data !== 0){																		
					$("#logradouro").val(data.logradouro);									
					$("#bairro").val(data.bairro);									
					$("#cidade").val(data.cidade);									
					$("#uf").val(data.uf);								
					}							
					}						
				});					
			}						
		});							
		
		$( "#emitente" ).change(function() {				
			var emitente = $('#emitente').val();								
				$.ajax({					
					url: "<?php echo $this->config->base_url(); ?>index.php/loja/busca?emitente=" + emitente,					
					type : 'GET', /* Tipo da requisição */ 					
					contentType: "application/json; charset=utf-8",					
					dataType: 'json', /* Tipo de transmissão */					
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
		});						
		
		$( "#id_estado" ).change(function() {				
			var id_estado = $('#id_estado').val();									
			$.ajax({					
				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaCidadeImByEstado?id_estado=" + id_estado,
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
				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaEmitente?id_estado=" + id_estado,
				type : 'GET', /* Tipo da requisição */ 					
				contentType: "application/json; charset=utf-8",					
				dataType: 'json', /* Tipo de transmissão */					
					success: function(data){							
						if (data == undefined ) {							
							console.log('Undefined');						
						} else {							
							$('#emitente').html(data);						
						}												
					}				 
			}); 						
		});			
		 
		$( "#id_cidade" ).change(function() {	
			
			
				$.ajax({					
					url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaEmitenteByCidade?id_cidade=" + id_cidade,
					type : 'GET', /* Tipo da requisição */ 					
					contentType: "application/json; charset=utf-8",					
					dataType: 'json', /* Tipo de transmissão */					
						success: function(data){							
							if (data == undefined ) {							
								console.log('Undefined');						
							} else {							
								$('#emitente').html(data);						
							}												
						}				 
				});
		});	

		var id_emitente_bd = $('#id_emitente_bd').val();				
				$.ajax({

					url: "<?php echo $this->config->base_url(); ?>index.php/loja/busca?emitente=" + id_emitente_bd,
					type : 'GET', /* Tipo da requisição */ 
					contentType: "application/json; charset=utf-8",
					dataType: 'json', /* Tipo de transmissão */
					success: function(data){	

						if (data == undefined ) {
							console.log('Undefined');
						} else {

							$('#imovel').html(data);
						}
							
					}
				 }); 		
});   
 </script>
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Editar Unidade de Negócio<small>	<?php echo utf8_encode($mensagemLoja);?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/loja/listar"><i class="fa fa-home"></i>Listar Unidade de Negócio</a></li>
                                    <li class="active"></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da Unidade de Negócio </h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('loja/atualizar_loja', $attributes); 
								?>
								<input type="hidden" readonly='yes' name='id' id='id'  value='<?php echo $dados_loja[0]->id ?>'>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group">
									<label class="col-lg-2 control-label">Estado</label>
                                    <div class="col-lg-4">
										<select name="id_estado" id="id_estado" required=""  class='custom-select' style='width:350px;height:30px'>
											<option value="0">Escolha</option>	

												  <?php foreach($estados as $key => $estado){
												   if($dados_loja[0]->est == $estado->estado ){ ?>	
														<option value="<?php echo $estado->estado ?>" selected><?php echo $estado->estado?></option>	
														 <?php }else{ ?>
														 <option value="<?php echo $estado->estado ?>"><?php echo $estado->estado?></option>	
														 
												  <?php
													}
												  }								  

												  ?>						
											 </select>     
                                    </div>
									<label class="col-lg-2 control-label">Cidade</label>
                                    <div class="col-lg-4">
										
									<select name="id_cidade" id="id_cidade" required=""  class='custom-select' style='width:320px;height:30px'>
										<option value="0">Escolha</option>	
										<?php foreach($cidades as $key => $cidade){ 
										  if($dados_loja[0]->cid == $cidade->cidade ){ ?>	
												<option value="<?php echo $cidade->cidade ?>" selected><?php echo $cidade->cidade?></option>	
											 <?php }else{ ?>
												<option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>	
										  <?php
											}
										  }								  

										  ?>
									</select>
								
										</div>									
                                </div>
                                <div class="form-group">
									<label class="col-lg-2 control-label">Empresa</label>
                                    <div class="col-lg-4">
									<input type="hidden" readonly='yes' name='id_emitente_bd' id='id_emitente_bd'  value='<?php echo $dados_loja[0]->id_emitente ?>'>
									<select name="id_emitente" id="emitente" required=""  class='custom-select' style='width:350px;height:30px'>
									  <?php foreach($emitentes as $key => $emitente){ 
										if($dados_loja[0]->id_emitente == $emitente->id ){ ?>
											<option value="<?php echo $emitente->id ?>" selected ><?php echo $emitente->nome_fantasia?></option>	
									  <?php }else{ ?>
											<option value="<?php echo $emitente->id ?>"  ><?php echo $emitente->nome_fantasia?></option>	
									  <?php		
										}
									  }								  

									  ?>

									</select>        
                                    </div>
									<label class="col-lg-2 control-label">Im&oacute;vel</label>
									<div class="col-lg-4">
										<select name="id_imovel" id="imovel" required=""  class='form-control' style='width:320px;height:30px'> </select>    									
                                    </div>
									
                                </div>
								<div class="form-group">
								<label class="col-sm-2 control-label">CNPJ/CPF do Emitente</label>
                                    <div class="col-lg-4">
                                      	<input type="text" readonly='yes' name='cpf_cnpj' id='cpf_cnpj' class="form-control"  required="" value='<?php echo $dados_loja[0]->cpf_cnpj; ?>'>
                                    </div>
									
									
									
                                </div>
								
                                	<input type="hidden" name='cod1' id='cod1'  value='0' class="form-control"  > 
								<input type="hidden" name='cod2' id='cod2'  value='0' class="form-control"  > 
								<input type="hidden" name='cc' id='cc' value='0'  class="form-control"  >
								<input type="hidden" name='regional' id='regional' value='0'  class="form-control"  >
								<input type="hidden" name='bandeira' id='bandeira' value='0'  class="form-control"  >
								<input type="hidden" name='insc' id='insc'  value='0'>
                               
							   
                               
                                <div class="form-group">
								
									<label class="col-lg-2 control-label">CEP</label>
                                    <div class="col-lg-4"><input type="text" id='cep' name='cep' class="form-control"  data-masked="" data-inputmask="'mask': '99.999-999' " value='<?php echo $dados_loja[0]->cep; ?>'>      
                                    </div>
									
										<label class="col-lg-2 control-label">N&uacute;mero</label>
                                    <div class="col-lg-4"><input type="text" name='numero' class="form-control" value='<?php echo $dados_loja[0]->numero; ?>' >   
                                    </div>
                                </div>
								
								
								<div class="form-group">
								
									<label class="col-lg-2 control-label">Endere&ccedil;o</label>
                                    <div class="col-lg-4"><input type="text" name='logradouro' id='logradouro' class="form-control" value='<?php echo $dados_loja[0]->endereco; ?>'> 
                                    </div>
									
									<label class="col-lg-2 control-label">Bairro</label>
                                    <div class="col-lg-4"><input type="text" name='bairro' id='bairro' class="form-control" value='<?php echo $dados_loja[0]->bairro; ?>' >   
                                    </div>
                                </div>
								
								<div class="form-group">
									
									<label class="col-lg-2 control-label">Cidade</label>
                                    <div class="col-lg-4"><input type="text" name='cidade' id='cidade' class="form-control" value='<?php echo $dados_loja[0]->cidade; ?>'>  
									</div>
									<label class="col-lg-2 control-label">UF</label>
                                    <div class="col-lg-4"><input type="text" name='estado' id='estado' class="form-control" value='<?php echo $dados_loja[0]->estado; ?>'>  
									
                                    </div>
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

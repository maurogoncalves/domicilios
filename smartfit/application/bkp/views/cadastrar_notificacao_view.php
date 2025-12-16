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
		  $('.summernote').summernote();	
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
								alert('Esse n\u00famero de inscri\u00e7\u00e3o, j\u00e1 existe para essa loja');									
								$("#insc").focus();								
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
					$("#estado").val(data.uf);								
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
			
		
		});			
		 
		$( "#id_cidade" ).change(function() {	
			
				var id_cidade = $('#id_cidade').val();		
				$.ajax({					
					url: "<?php echo $this->config->base_url(); ?>index.php/notificacao/buscaLojasByCidadeNotificacao?id_cidade=" + id_cidade,
					type : 'GET', /* Tipo da requisição */ 					
					contentType: "application/json; charset=utf-8",					
					dataType: 'json', /* Tipo de transmissão */					
						success: function(data){							
							if (data == undefined ) {							
								console.log('Undefined');						
							} else {							
								$('#id_loja').html(data);						
							}												
						}				 
				});
		});	

	$( "#data_atendimento" ).blur(function() {							
		var dtAtendi = $('#data_atendimento').val();					
		var dataEnvio = $('#data_envio').val();	
			if(dataEnvio == 0){					
				alert('Digite a Data de Envio');					
				//$('#vigencia').focus();				
			}

			if(dtAtendi == 0){					
				alert('Digite a Data de Atendimento');					
				//$('#vigencia').focus();				
			}
			
		$.ajax({					
			url: "<?php echo $this->config->base_url(); ?>index.php/notificacao/calcularDias?dtAtendi=" + dtAtendi +'&dataEnvio='+dataEnvio ,					
			type : 'GET', /* Tipo da requisição */ 					
			contentType: "application/json; charset=utf-8",					
			dataType: 'json', /* Tipo de transmissão */					
			success: function(data){							
				if (data == undefined ) {							
					console.log('Undefined');						
				} else {							
					if(data.status == 1){
						alert('Data Envio não pode ser maior que a data de atendimento');
					}else{
						$('#dias_atendimento').val(data.dias);							
					}
					//$('#dtfim').val(data);	
					//$('#dtvenc').val(data);		
					
				}												
			}				 
		}); 			
	});			
});   
 </script>
 
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Cadastrar Notificação<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/notificacao/listar"><i class="fa fa-home"></i>Listar Notificação</a></li>
                                    <li class="active">Cadastrar Notificação</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da Loja</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('notificacao/cadastrar_noti', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group">
									<label class="col-lg-2 control-label">Estado</label>
                                    <div class="col-lg-4">
										<select name="id_estado" id="id_estado" required=""  class='custom-select' style='width:350px;height:30px'>
											 <option value="0">Escolha</option>										  
											 <?php foreach($estados as $key => $estado){ ?>									 
											 <option value="<?php echo $estado->uf ?>"><?php echo $estado->uf?></option>
											 <?php									  
											 }								  									 
											 ?>									
											 </select>     
                                    </div>
									<label class="col-lg-2 control-label">Cidade</label>
                                    <div class="col-lg-4">
										<select name="id_cidade" id="id_cidade" required=""  class='custom-select' style='width:320px;height:30px'>	
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
									<select name="id_loja" id="id_loja" required=""  class='custom-select' style='width:350px;height:30px'>
										<option value="0">Escolha</option>										 
										<?php foreach($emitentes as $key => $emitente){ ?>									 
										<option value="<?php echo $emitente->id ?>"><?php echo $emitente->nome_fantasia?></option>		
										<?php									  
										}								  									  
										?>									
										</select>          
                                    </div>	

									<label class="col-sm-2 control-label">Nome da empresa</label>
										<div class="col-lg-4">
											<input type="text"  name='nome_empresa' id='nome_empresa' class="form-control"  required=""> 
										</div>									
									</div>
								
                                <div class="form-group">
								
								
								
									<label class="col-lg-2 control-label">Data da Ciência da Notificação</label>
                                    <div class="col-lg-4">
									<input type="text" id='data_ciencia' name='data_ciencia' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' ">  
                                    </div>
									
									<label class="col-lg-2 control-label">Esfera</label>
                                    <div class="col-lg-2">
									<select name="esfera" id="esfera" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>								  
									<?php foreach($esferas as $key => $esfera){ ?>								 
									<option value="<?php echo $esfera->id ?>"><?php echo $esfera->descricao_esfera?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
									
									</div>
									
                                </div>	

                                <div class="form-group">
									<label class="col-lg-2 control-label">Ano Competência</label>
                                    <div class="col-lg-2"><input type="text" name='ano_competencia' id='ano_competencia'  placeholder="Competência" class="form-control" data-masked="" data-inputmask="'mask': '9999' "  > 
                                    </div>
									<label class="col-lg-4 control-label">Nº do processo/Notificação</label>
                                    <div class="col-lg-4"><input type="text" name='numero_processo' id='numero_processo'  placeholder="Nº do processo/Notificação" class="form-control"  > 
                                    </div>
									
                                </div>	
		
                                <div class="form-group">
									<label class="col-lg-2 control-label">Descrição da solicitação</label>
                                    <div class="col-lg-4"><input type="text" name='descr_solic' id='descr_solic'  placeholder="Descrição da solicitação" class="form-control"  > 
                                    </div>
									<label class="col-lg-2 control-label">Tipo de solicitação</label>
                                    <div class="col-lg-4"><input type="text" name='tipo_solic' id='tipo_solic'  placeholder="Tipo de solicitação" class="form-control"  > 
                                    </div>
                                </div>
								
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Ação a ser tomada</label>
                                    <div class="col-lg-4"><input type="text" name='acoes' class="form-control" placeholder="Ação a ser tomada">   
                                    </div>
									<label class="col-lg-2 control-label">Responsável</label>
                                    <div class="col-lg-4"><input type="text" name='resp' class="form-control" placeholder="Responsável pelo atendimento">   
                                    </div>

									
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Prazo de atendimento</label>
                                    <div class="col-lg-4">
									<input type="text" id='prazo_atendimento' name='prazo_atendimento' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' ">  
                                    </div>
									
									<label class="col-lg-2 control-label">Alerta no prazo</label>
                                    <div class="col-lg-2">
									<select name="alerta" id="alerta" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>								  
									<?php foreach($alertas as $key => $alerta){ ?>								 
									<option value="<?php echo $alerta->id ?>"><?php echo $alerta->descricao?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
									
									</div>
								
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Direcionado para</label>
                                    <div class="col-lg-4"><input type="text" name='direcionado' class="form-control" placeholder="Responsável pela solução">   
                                    </div>
									<label class="col-lg-2 control-label">Data de Envio</label>
                                    <div class="col-lg-4">
									<input type="text" id='data_envio' name='data_envio' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' ">  
                                    </div>

									
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Data de atendimento</label>
                                    <div class="col-lg-4">
									<input type="text" id='data_atendimento' name='data_atendimento' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' ">  
                                    </div>
									
									<label class="col-lg-2 control-label">Dias de atendimento</label>
                                    <div class="col-lg-2">
									<input type="text" readonly='yes' id='dias_atendimento' name='dias_atendimento' class="form-control"  >  
									
									</div>
								
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Número da solicitação</label>
                                    <div class="col-lg-4"><input type="text" name='num_solic' id='num_solic'  placeholder="Número da solicitação" class="form-control"  > 
                                    </div>
									
									<label class="col-lg-2 control-label">Prioridade</label>
                                    <div class="col-lg-2">
									<select name="prioridade" id="prioridade" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>								  
									<?php foreach($prioridades as $key => $prior){ ?>								 
									<option value="<?php echo $prior->id ?>"><?php echo $prior->descricao?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
									
									</div>
								
                                </div>
								
								
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Nome do auditor</label>
                                    <div class="col-lg-4"><input type="nome_auditor" name='nome_auditor' class="form-control" placeholder="Nome do auditor">   
                                    </div>
									<label class="col-lg-2 control-label">Contato do auditor</label>
                                    <div class="col-lg-4"><input type="contato_auditor" name='contato_auditor' class="form-control" placeholder="Contato do auditor">   
                                    </div>

									
                                </div>
								
								<div class="form-group">
									
									
									<label class="col-lg-2 control-label">Risco da autuação</label>
                                    <div class="col-lg-4">
									<select name="risco" id="risco" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>								  
									<?php foreach($prioridades as $key => $prior){ ?>								 
									<option value="<?php echo $prior->id ?>"><?php echo $prior->descricao?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
									
									</div>
									
									<label class="col-lg-2 control-label">Status</label>
                                    <div class="col-lg-4">
									<select name="status" id="status" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>								  
									<?php foreach($status as $key => $st){ ?>								 
									<option value="<?php echo $st->id ?>"><?php echo $st->descricao?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
									
									</div>
									
								
                                </div>
								
								<div class="form-group">
									
									
									
									<label class="col-lg-2 control-label">Data de encerramento fiscalização</label>
                                    <div class="col-lg-4">
									<input type="text" id='data_encerra' name='data_encerra' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' ">  
                                    </div>
									
										<label class="col-lg-2 control-label">Data de recebimento do Termo de Encerramento</label>
                                    <div class="col-lg-4">
									<input type="text" id='data_recebe_termo' name='data_recebe_termo' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' ">  
                                    </div>
								
                                </div>
								
								<div class="form-group">
									
									
								
									
									<label class="col-lg-2 control-label">Observações/Tratativas</label>
                                    <div class="col-lg-10">
									<input type="text" name='observacao' id='observacao'  placeholder="Nova Observação / Tratativa" class="form-control"  value=''> 
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

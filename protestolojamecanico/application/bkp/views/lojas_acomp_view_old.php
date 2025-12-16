<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script><script src='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.js'></script><link href='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.css' rel='stylesheet' /> 
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script>
		jQuery(function($) {			 $("#emitente").customselect();		});		$(document).ready(function(){		$('input').keypress(function (e) {        var code = null;        code = (e.keyCode ? e.keyCode : e.which);                        return (code == 13) ? false : true;	});      $('#form').submit(function(event){		  if (form.checkValidity()) {			send.attr('disabled', 'disabled');		  }	});			$( "#area" ).change(function() {			var area = $("#area").val();		if(area !== '0'){			$.ajax({				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/buscarSubArea?area=" + area,				type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 				contentType: "application/json; charset=utf-8",				dataType: 'json', /* Tipo de transmiss&atilde;o */				success: function(data){					if (data == undefined ) {						console.log('Undefined');					} else {						$('#sub_area').html(data);					}				}			});						$.ajax({				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/buscarEtapa?area=" + area,				type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 				contentType: "application/json; charset=utf-8",				dataType: 'json', /* Tipo de transmiss&atilde;o */				success: function(data){					if (data == undefined ) {						console.log('Undefined');					} else {						$('#etapa').html(data);					}				}			});						$.ajax({				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/tipoDebito?area=" + area,				type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 				contentType: "application/json; charset=utf-8",				dataType: 'json', /* Tipo de transmiss&atilde;o */				success: function(data){					if (data == undefined ) {						console.log('Undefined');					} else {						$('#tipo_debito').html(data);					}				}			});					 }				})$( "#data_envio" ).blur(function() {									var data_envio = $('#data_envio').val();							$.ajax({								url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/calcularSLA?data_envio=" + data_envio ,								type : 'GET', /* Tipo da requisição */ 								contentType: "application/json; charset=utf-8",								dataType: 'json', /* Tipo de transmissão */								success: function(data){											if (data == undefined ) {												console.log('Undefined');										} else {												$('#sla').val(data);															}															}				 		}); 				})	});
    </script>      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row mt">
                  <div class="col-lg-12">
				  
				  <a  href="listar" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Listar</a>									 <span class='pull-right' style='font-weight:bold'> 					<?php echo utf8_encode($this->session->flashdata('mensagem')); ?>				  </span>
                      <div class="form-panel">
					
							<?php								
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form');
								echo form_open('acomp_cnd/cadastrar_acomp_cnd', $attributes); 							 
							?>							 
							<div class="form-group">                             
							<label class="col-sm-2 col-sm-2 control-label">Nome Emitente</label>                              
							<div class="col-sm-4">                                 
							<input type="text" name='nomeImovel' class="form-control"  required="" value='<?php echo $dados_acomp[0]->nome_fantasia; ?>'>                              
							</div>                                                          
							<label class="col-sm-2 col-sm-2 control-label">CPF/CNPJ</label>                              
								<div class="col-sm-4">                                  
								<input type="text" name='nomeImovel' class="form-control"  required="" value='<?php echo $dados_acomp[0]->cpf_cnpj; ?>'>                              
								</div>							
								</div>														
								<div class="form-group">							  							 
								<label class="col-sm-2 col-sm-2 control-label">Inscri&ccedil;&atilde;o</label> 
								<div class="col-sm-4">                                 
								<input type="text" name='nomeImovel' class="form-control"  required="" value='<?php echo $dados_acomp[0]->ins_cnd_mob; ?>'>                              
								</div>                              
								<label class="col-sm-2 col-sm-2 control-label">Data de Entrada</label>                             
								<div class="col-sm-4">									
								<input type="text" name='data_entrada_cadin' id='data_entrada_cadin' class="form-control"  required="" data-mask="99/99/9999" value='<?php echo $dados_acomp[0]->entrada_cadin_br; ?>' >							  
								</div>								
								</div>
							 <div class="form-group">																						 
							 <label class="col-sm-2 col-sm-2 control-label">&Aacuterea </label>                              
							 <div class="col-sm-4">                                  
							 <select name="area" id="area" required=""  class='custom-select' style='width:230px'>								  
							 <option value="0">Escolha</option>								  
							 <?php foreach($areas as $key => $area){ ?>									
								<option value="<?php echo $area->id ?>"><?php echo $area->nome_area?></option>								  
								<?php								  }	 ?>								
							</select>                              
							</div>							
							<label class="col-sm-2 col-sm-2 control-label">Sub &Aacute;rea  </label>                             
							<div class="col-sm-4">                                  
							<select name="sub_area" id="sub_area" required=""  class='custom-select' style='width:230px'>
							<option value="0">Escolha</option>									
							</select>                              
							</div>							  
							</div>							
							<div class="form-group">							  					
							<label class="col-sm-2 col-sm-2 control-label">Etapa  </label>                              
							<div class="col-sm-4">                                  
							<select name="etapa" id="etapa" required=""  class='custom-select' style='width:230px'>
							<option value="0">Escolha</option>									
							</select>                              
							</div>							  							  
							<label class="col-sm-2 col-sm-2 control-label">Tipo do D&eacute;bito</label> 
							<div class="col-sm-4">								  								 
							<select name="tipo_debito" id="tipo_debito" required=""  class='custom-select' style='width:230px'>								  
							<option value="0">Escolha</option>									
							</select>                              
							</div>							
							</div>							  													
							<div class="form-group">							   
							<label class="col-sm-2 col-sm-2 control-label">Data Envio</label>                             
							<div class="col-sm-4">                                  
							<input type="text" name='data_envio' id='data_envio' class="form-control"  required="" data-mask="99/99/9999" >                              
							</div>							                                
							<label class="col-sm-2 col-sm-2 control-label">SLA</label>                              
							<div class="col-sm-4">                                  
							<input type="text" readonly='yes' name='sla' id='sla' class="form-control"  required=""  >                              
							</div>							  							
							</div>															
							<div class="form-group">														 
							<label class="col-sm-2 col-sm-2 control-label">&Acirc;mbito </label>                              
							<div class="col-sm-4">                              
							<select name="tipo_acomp" id="tipo_acomp" required=""  class='custom-select' style='width:200px'>
							<option value="0">Escolha</option>								  
							<?php foreach($tipo_acomp as $key => $tipo){ ?>									
							<option value="<?php echo $tipo->id ?>"><?php echo $tipo->descricao?></option>
							<?php								  }		 ?>								
							</select>                              
							</div>							  							 
							<label class="col-sm-2 col-sm-2 control-label">Obs.:</label>
							<div class="col-sm-4">                                  
							<input type="text" name='observacoes' id='observacoes' class="form-control" > 
							</div>															
							</div>															
							<div class="form-group">							 
							<label class="col-sm-2 col-sm-2 control-label">Projeto</label>                              
							<div class="col-sm-4">                              
							<select name="projeto" id="projeto" required=""  class='custom-select' style='width:200px'>
							<option value="0">Escolha</option>								  
							<?php foreach($projetos as $key => $proj){ ?>									
							<option value="<?php echo $proj->id ?>"><?php echo $proj->descricao?></option>
							<?php	 }	 ?>								
							</select>							 
							</div>							  
							<label class="col-sm-2 col-sm-2 control-label"></label>                              
							<div class="col-sm-2">							   
							<input type="hidden" id='id' name='id'  value='<?php echo $dados_acomp[0]->id_loja; ?>'>
							<button style='font-size:13px;width:120px' type="submit" class="btn btn-success">Inserir Acomp.</button>	                              
							</div>							
							</div>														 
							</form>	  							  
							<table class="table table-striped table-advance table-hover">	                  	  	  
							<h4><i class="fa fa-angle-right"></i> Lista de Acomp.</h4>	                  	  	  
							<hr>                             
							<thead>                              
							<tr>                                  
							<th width="20%"> &Aacute;rea / Sigla / Sub&Aacute;rea</th>
							<th width="13%"> Projeto</th>			  								  
							<th width="13%"> Tipo de D&eacute;bito</th>			  								  
							<th width="10%"> Data de Entrada</th>			  								  
							<th width="12%"> Data Envio </th>			  								  
							<th width="5%"> SLA </th>										  
							<th width="12%"> &Acirc;mbito </th>		                                  
							<th width="15%">A&ccedil;&otilde;es</th>                              
							</tr>                              
							</thead>                              
							<tbody>								 
							<?php if(empty($dados_acomp)){?>								
							<tr>                                  
							<td></td>                                 
							<td></td>                                 
							<td></td>								  
							<td></td>								  
							</tr>								
							<?php	
							}else{
								foreach($dados_acomp as $key => $dados){
							?>								
							<tr>								 
							<?php									
								if(empty($dados->arquivo)){	
							?>									
								<td width="20%" class="hidden-phone"><?php echo $dados->nome_area.'-'.$dados->sigla_sub_area.'-'.$dados->nome_etapa; ?> </td>
							<?php									
								}else{								 
							?>										
								<td width="20%" class="hidden-phone">									
									<a href="<?php echo $this->config->base_url(); ?>assets/acomp_cnd/<?php echo $dados->arquivo?>" download> 									
									<?php echo $dados->nome_area.'-'.$dados->sigla_sub_area.'-'.$dados->nome_etapa; ?>									
									</a>									 
								</td>
							<?php }	?>									 	
								<td width="13%" class="hidden-phone"><?php echo $dados->proj_desc ?>  </td>	
								<td width="13%" class="hidden-phone"><?php echo $dados->desc_tipo_deb ?> </td>
								<td width="10%" class="hidden-phone"><?php echo $dados->entrada_cadin_br ?> </td>
								<td width="12%" class="hidden-phone"><?php echo $dados->data_envio_br ?> </td>
								<td width="5%" class="hidden-phone"><?php echo $dados->sla ?> </td>
								<td width="12%" class="hidden-phone"><?php echo $dados->descricao ?> </td>
								<td width="15%">									 
									<a href="<?php echo $this->config->base_url();?>index.php/loja/upload_loja_acomp?id_acomp=<?php echo $dados->id_acomp; ?>&id_loja=<?php echo $dados->id_loja ?>" class="btn btn-success btn-xs"><i class="fa fa-upload"></i></a>
									<a href="<?php echo $this->config->base_url();?>index.php/loja/editar_loja_acomp?id_acomp=<?php echo $dados->id_acomp; ?>&id_loja=<?php echo $dados->id_loja ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
									<a href="<?php echo $this->config->base_url();?>index.php/loja/excluir_loja_acomp?id_acomp=<?php echo $dados->id_acomp; ?>&id_loja=<?php echo $dados->id_loja ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
								</td>								  
							</tr>								 								  
								<?php								  
							}								  
							}								  
							?>                              
							</tbody>                          
							</table>                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      
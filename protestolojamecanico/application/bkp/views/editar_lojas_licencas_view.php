<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script><script src='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.js'></script><link href='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.css' rel='stylesheet' /> 
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script>		var mask = {		 money: function() {			var el = this			,exec = function(v) {			v = v.replace(/\D/g,"");			v = new String(Number(v));			var len = v.length;			if (1== len)			v = v.replace(/(\d)/,"0.0$1");			else if (2 == len)			v = v.replace(/(\d)/,"0.$1");			else if (len > 2) {			v = v.replace(/(\d{2})$/,'.$1');			}			return v;			};			setTimeout(function(){			el.value = exec(el.value);			},1);		}}	
		$(document).ready(function(){			$('#areaDestinada').bind('keypress',mask.money);						$('#form').submit(function(event){				if (form.checkValidity()) {					send.attr('disabled', 'disabled');				}			});
		});
		jQuery(function($) {			 $("#emitente").customselect();		});
    </script>      
      
	  
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Editar Licenças<small>	</small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/loja/listar"><i class="fa fa-home"></i>Listar Loja</a></li>
                                    <li class="active">Editar Licenças</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es  </h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('licencas/atualizar_licenca_loja', $attributes); 
								?>
								<input type="hidden" readonly='yes' name='id' id='id'  value='<?php echo $dados_loja[0]->id ?>'>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group">
									<label class="col-lg-2 control-label">Nome Emitente</label>
                                    <div class="col-lg-4">
										<input type="text" name='nomeImovel' class="form-control"  required="" value='<?php echo $dados_licenca[0]->nome_fantasia; ?>'>                                 
                                    </div>
									<label class="col-lg-2 control-label">CPF/CNPJ</label>
                                    <div class="col-lg-4">
									<input type="text" name='nomeImovel' class="form-control"  required="" value='<?php echo $dados_licenca[0]->cpf_cnpj; ?>'> 	
						
									</div>									
                                </div>
                               
							    <div class="form-group">
									<label class="col-lg-2 control-label">Inscri&ccedil;&atilde;o</label>
                                    <div class="col-lg-4">
										<input type="text" name='nomeImovel' class="form-control"  required="" value='<?php echo $dados_licenca[0]->ins_cnd_mob; ?>'>                              
                                    </div>
									<label class="col-lg-2 control-label">Data Vencimento Licen&ccedil;a</label>
                                    <div class="col-lg-4">
									<input type="text" name='data_vencto' id='data_vencto' class="form-control"  required="" data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo $dados_licenca[0]->data_vencimento_br; ?>'>							 
						
									</div>									
                                </div>
                               
							    <div class="form-group">
									<label class="col-lg-2 control-label">Tipo de Licen&ccedil;a</label>
                                    <div class="col-lg-4">
										<select name="tipo_licenca" id="tipo_licenca" required=""  class='custom-select' style='width:350px;height:30px'  required="" >
										<option value="0">Escolha</option>								 
										<?php foreach($tipos_licencas as $key => $tipo){ ?>									
										<?php if($dados_licenca[0]->tipo_licenca_taxa == $tipo->id){ ?>		
										<option value="<?php echo $tipo->id ?>" selected><?php echo $tipo->descricao?></option>
										<?php }else{ ?>									
										<option value="<?php echo $tipo->id ?>"><?php echo $tipo->descricao?></option>
										<?php } ?>							  
										<?php								  
										}
										?>								
										</select> 
                                    </div>
									<label class="col-lg-2 control-label">Observa&ccedil;&otilde;es</label>
                                    <div class="col-lg-4">
									<input type="text" name='observacoes' id='observacoes' class="form-control"  value='<?php echo $dados_licenca[0]->observacoes; ?>' >                              
									<input type="hidden" id='id_licenca' name='id_licenca'  value='<?php echo $dados_licenca[0]->id_licenca; ?>'>								
									<input type="hidden" id='id_loja' name='id_loja'  value='<?php echo $dados_licenca[0]->id_loja; ?>'>  

									</div>									
                                </div>

                               
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white" type="submit">Cancelar</button>
                                        <button class="btn btn-primary" type="submit">Salvar</button>
                                    </div>
                                </div>
                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div> 
            </div>

      
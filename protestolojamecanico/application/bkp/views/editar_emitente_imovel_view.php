<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script> 
    <script>		var mask = {		 money: function() {			var el = this			,exec = function(v) {			v = v.replace(/\D/g,"");			v = new String(Number(v));			var len = v.length;			if (1== len)			v = v.replace(/(\d)/,"0.0$1");			else if (2 == len)			v = v.replace(/(\d)/,"0.$1");			else if (len > 2) {			v = v.replace(/(\d{2})$/,'.$1');			}			return v;			};			setTimeout(function(){			el.value = exec(el.value);			},1);		}}	
		$(document).ready(function(){				 $('input').keypress(function (e) {        var code = null;        code = (e.keyCode ? e.keyCode : e.which);                        return (code == 13) ? false : true;   });			$('#areaDestinada').bind('keypress',mask.money);
		});

    </script>      
    
     
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Editar Empresa no Imóvel<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/imovel/listar"><i class="fa fa-home"></i>Listar Imóvel</a></li>
                                    <li class="active">Editar Empresa no Imóvel</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es do Imóvel</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								
								 <?php
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('imovel/atualizar_emitente_imovel', $attributes); 
									?>
									<div class="panel-body">
									 <form class="form-horizontal">
									<div class="form-group">
										<label class="col-lg-2 control-label">Nome Im&oacute;vel</label>
										<div class="col-lg-10"><input type="text" id='nomeImovel' name='nomeImovel'  placeholder="Nome Im&oacute;vel" class="form-control" required="" value='<?php echo $imovel[0]->nome; ?>'> 
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">&Aacute;rea do Emitente (%)</label>
										<div class="col-lg-4"><input type="text" name='areaDestinada' id='areaDestinada'  placeholder="&Aacute;rea Total (Mt)" data-a-dec="," data-a-sep="." class="auto form-control" required="" value='<?php echo $imovel[0]->area; ?>'> 
										</div>
										
									</div>
									
									
																		
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-4 col-sm-offset-2">
											 <input type="hidden" id='id' name='id'  value='<?php echo $imovel[0]->id; ?>'>								  
											 <input type="hidden" id='id_im' name='id_im'  value='<?php echo $id_im; ?>'>                                  
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

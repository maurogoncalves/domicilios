<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script> 
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
		
		
});   
 </script>
 
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Perfil do Usuário<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/home/"><i class="fa fa-home"></i> Voltar</a></li>
                                    <li class="active">Perfil do Usuário</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es do Usuário</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>								<div class="form-group">									<div class="col-lg-12" style='color:#ff0000;'>									<?php echo$this->session->flashdata('message');?>									  </div>                                  								</div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('home/atualizar_perfil', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                               
								

                                
								
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Nome Completo</label>
                                    <div class="col-lg-8"><input type="text" name='nome' class="form-control" required='' value='<?php echo $dadosUsu[0]->nome_usuario?>' >   
                                    </div>
                                </div>
								
								<div class="form-group">									
									<label class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-8"><input type="email" readonly='yes' name='email' id='email' class="form-control" required='' value='<?php echo $dadosUsu[0]->email?>'> 
                                    </div>
                                </div>
								
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Telefone</label>
                                    <div class="col-lg-8"><input type="text" name='tel' class="form-control" required='' data-masked="" data-inputmask="'mask': '(99)9999-9999' "  value='<?php echo $dadosUsu[0]->telefone?>'>   
                                    </div>
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Celular</label>
                                    <div class="col-lg-4"><input type="text" name='cel' class="form-control" required='' data-masked="" data-inputmask="'mask': '(99)99999-9999' " value='<?php echo $dadosUsu[0]->celular?>'>   
									WhatsApp? &nbsp;&nbsp;&nbsp; 
									
									<?php if($dadosUsu[0]->whatsapp == 1){?>								
										<input type="radio" id="whats" name='whats' value="1" checked="" > Sim </label> &nbsp;&nbsp;&nbsp; <label> <input type="radio" id="whats" name='whats' value="2"> Não</label>
									<?php }else{?>
										<input type="radio" id="whats" name='whats' value="1"  > Sim </label> &nbsp;&nbsp;&nbsp; <label> <input type="radio" id="whats" name='whats' value="2" checked=""> Não</label>
									<?php }?>
                                    </div>

                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Nova Senha</label>
                                    <div class="col-lg-4"><input type="password" name='senha' class="form-control"  >   
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

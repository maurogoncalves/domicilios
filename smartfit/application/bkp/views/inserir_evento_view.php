<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Inserir Evento<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/calendario/montar"><i class="fa fa-home"></i>Calend&aacute;rio</a></li>
                                    <li class="active">Inserir Evento</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es do Evento</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('calendario/inserir_evento', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">

		
                                <div class="form-group">
									<label class="col-lg-2 control-label">Data Evento</label>
                                    <div class="col-lg-4"><input type="text" id='data' name='data' class="form-control"  data-masked="" data-inputmask="'mask': '99-99-9999' ">      
                                    </div>
                                </div>
								
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Evento</label>
                                    <div class="col-lg-4"><input type="text" name='evento' class="form-control"  >   
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

	<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Ver CND Obras<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/dados_agrupados"><i class="fa fa-home"></i>Listar CND Obras</a></li>
                                    <li class="active">Ver CND Obras</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
					<div class="row">
					<?php
						$attributes = array('class' => 'form-horizontal style-form');
						echo form_open_multipart('cnd_obras/enviar', $attributes); 							
					?>
						<div class="col-md-12">
							<div class="panel panel-card margin-b-30">
										
										<div class="form-group">
									<label class="col-lg-2 control-label" > Inscri&ccedil;&atilde;o</label>
										<div class="col-lg-4">
											<input type="text"  id='nome' readonly='yes' name='nome' class="form-control" value=' <?php echo $imovel[0]->cei?>'   >
							 
										</div>
									
									</div>	
									
									<div class="form-group">
									<label class="col-lg-2 control-label" ></label>
										<div class="col-lg-4">
											<?php if($imovel[0]->possui_cnd == 1){?>								
											 <a href="<?php echo $this->config->base_url(); ?>assets/cnd_obras/<?php echo $imovel[0]->arquivo_cnd?>" download> Baixar Inscri&ccedil;&atilde;o</a>	
											 <?php }elseif($imovel[0]->possui_cnd == 2){?>
											 <a href="<?php echo $this->config->base_url(); ?>assets/cnd_obras/<?php echo $imovel[0]->arquivo_cnd?>" download> Baixar Inscri&ccedil;&atilde;o</a>
											 <?php }else{ ?>
											 <a href="<?php echo $this->config->base_url(); ?>assets/cnd_obras_pend/<?php echo $imovel[0]->arquivo_pendencias?>" download> Baixar Inscri&ccedil;&atilde;o</a>
											<?php } ?>
										</div>
									
									</div>	
									
									</div>
							</div>
						
						 </div>
	                   
					   
                </div> 
            </div>
			

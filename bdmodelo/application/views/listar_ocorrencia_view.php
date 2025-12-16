<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>		
	
				
	 <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Ocorr&ecirc;ncia <small>	<?php if(!empty($_SESSION['mensagemIptu'])){echo utf8_encode($_SESSION['mensagemIptu']);}?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Ocorr&ecirc;ncia</li>
									
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-card ">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> 
									<a href="<?php echo $this->config->base_url();?>index.php/ocorrencia/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Nova Ocorr&ecirc;ncia</a> 
									
									</h4>
									
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                 <div class="panel-body">
                                    <table id="basic-datatables" class="table table-bordered" cellspacing="0" width="100%">                                        <thead>                                            <tr>                                                <th>Texto Ocorr&ecirc;ncia</th>												<th>Mensagem Suporte</th>                                                <th>Data Abertura</th>                                                <th>Data Fechamento</th>                                                <th>Urg&ecirc;ncia</th>												<th>M&oacutedulo</th>                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>Texto Ocorr&ecirc;ncia</th>											   <th>Mensagem Suporte</th>                                                <th>Data Abertura</th>                                                <th>Data Fechamento</th>                                                <th>Urg&ecirc;ncia</th>												<th>M&oacutedulo</th>                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($ocorrencia) ? '1' : '0';			
										if($isArray == 0){ ?>
										<?php 	
								 }else{								 
									 foreach($ocorrencia as $key => $oco){ 											$cor ='#FF0000';																				if($oco->status_suporte == 1){																					$cor ='#1bbf89';																					}																		if($oco->urgencia == 1){																					$urgencia ='Alta';																				}elseif($oco->urgencia == 2){																					$urgencia ='Média';																				}else{											$urgencia ='Baixa';																				}		

									 ?>										 <tr >												<td ><?php echo $oco->texto_ocorrencia; ?></td>													<td ><?php echo $oco->obs_suporte; ?></td>													
												<td ><?php echo $oco->data_abertura; ?></td>								 
												<td style='color:<?php echo $cor; ?>' ><?php echo $oco->data_fechamento; ?></td>	
												<td style='color:<?php echo $urgencia; ?>'> 	<?php echo $urgencia; ?>	</td>													<td ><?php echo $oco->nome_modulo; ?></td>													
												<td>  													<?php if($oco->status_suporte==1){ ?>														Ocorr&ecirc;ncia atendida													<?php }else{ ?>
														<a href="<?php echo $this->config->base_url();?>index.php/ocorrencia/upload?id=<?php echo $oco->id; ?>" class="btn btn-success btn-xs" title='Upload de Imagem'><i class="fa fa-upload"></i></a>																											<a href="<?php echo $this->config->base_url();?>index.php/ocorrencia/ver?id=<?php echo $oco->id; ?>" class="btn btn-success btn-xs" title='Ver Arquivo'><i class="fa fa-eye"></i></a>                                      														<a href="<?php echo $this->config->base_url();?>index.php/ocorrencia/editar?id=<?php echo $oco->id; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>                                      														<?php if($adm == 1){ ?>															<a href="<?php echo $this->config->base_url();?>index.php/ocorrencia/atender?id=<?php echo $oco->id; ?>" class="btn btn-primary btn-xs" title='Atender Ocorr&ecirc;ncia'><i class="fa fa-wrench "></i></a>									  														<?php } ?>														<?php if($visitante == 0){ ?>															<a href="<?php echo $this->config->base_url();?>index.php/ocorrencia/inativar?id=<?php echo $oco->id; ?>" class="btn btn-danger btn-xs" title='Fechar Ocorr&ecirc;ncia'><i class="fa fa-trash-o "></i></a>									  														<?php } ?>													<?php } ?>																										
												</td>					          
                                            </tr>
									  <?php
									}//fim foreach
								  }//fim if
								  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- End .panel -->  
                        </div><!--end .col-->
                    </div><!--end .row-->


                </div> 
            </div>


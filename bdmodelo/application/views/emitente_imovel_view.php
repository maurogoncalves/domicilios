<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script> 
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>    <script>	
		$(document).ready(function(){					 $('input').keypress(function (e) {			var code = null;			code = (e.keyCode ? e.keyCode : e.which);                			return (code == 13) ? false : true;	   });		});
    </script>      
     
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Empresas Associadas </h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/imovel/listar"><i class="fa fa-home"></i> Listar Imóvel</a></li>
                                    <li class="active">Vincular Empresa ao Imóvel</li>
                                </ol>
                            </div>
							<br>
								<?php if($soma < 100){ ?>
									<?php if($visitante == 0){ ?>
										<a  href="<?php echo $this->config->base_url();?>index.php/imovel/outro_emitente_imovel?id=<?php echo $imovel[0]->id; ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Inserir Empresa Nesse Im&oacute;vel</a>
									<?php } ?>
								<?php }else{ ?>
									<h5>Não é possivel vincular outra empresa ao imóvel, porque a soma das áreas chegou a 100%</h5>									
								<?php } ?>
								 
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es do Imóvel : <?php echo $imovel[0]->nome; ?></h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group">
									
									<label class="col-lg-2 control-label">&Aacute;rea Total (Mt)</label>
									<?php $areaTotal = str_replace('.','',$imovel[0]->area_total); ?>
                                    <div class="col-lg-4"><input type="text" name='areaTotal' id='areaTotal'  placeholder="&Aacute;rea Total (Mt)" data-a-dec="," data-a-sep="." class="auto form-control" required="" value='<?php echo $areaTotal ?>'> 
                                    </div>
									<label class="col-lg-2 control-label">&Aacute;rea Construida (Mt)</label>
									<?php $areaConstruida = str_replace('.','',$imovel[0]->area_construida); ?>
									<div class="col-lg-4"><input type="text" name='areaConstruida' id='areaConstruida'  placeholder="&Aacute;rea Construida (Mt)" data-a-dec="," data-a-sep="."  class="auto form-control" required="" value='<?php echo $areaConstruida; ?>'> 
                                    </div>
									
									
                                </div>

								<div class="hr-line-dashed"></div>
								
							 
								 <h4 class="panel-title"> Lista das Empresas Associadas</h4>
                                </div>
								<table class="table table-striped table-advance table-hover">	                  	  	  
							<hr>                              
							<thead>                              
							<tr>                                  
							<th> Raz&atilde;o Social</th>                                 
							<th >Nome Fantasia</th>								  
							<th> Tipo de Empresa</th>								  								  
							<th> % da Area Constru&iacute;da</th>                                  
							<th>A&ccedil;&otilde;es</th>                              
							</tr>                              
							</thead>                             
							<tbody>                              								
							<?php 											 
								$total = 0;								
								$porcentagem = 0;								 								
									if(empty($emitentes)){								
							?>								
									<tr>                                  
										<td><a href="#"></a></td>                                  
										<td class="hidden-phone"></td>                                  
										<td> <span style='font-weight:bold'  label-mini"></span></td>								  
										<td class="hidden-phone">%</td>                                  
										<td>                                                                        
										</td>								  
									</tr>								
							<?php								
								}else{																 
									foreach($emitentes as $key => $emitente){ 										
										if(empty($imovel[0]->area_construida)){										
										$imovel[0]->area_construida =1;									
										}									
										if($imovel[0]->area_construida <> '0,00'){																		
										$porcentagem = ($emitente->area / $imovel[0]->area_construida) * 100;
										$porcentagem = round($porcentagem,2); 										
										$total = $total + $emitente->area;									
										}else{										
										$porcentagem = '0.00'; 										
										$total = '0.00';									
								}																	 
							?>								 
							<tr>                                  
							<td><a href="#"><?php echo $emitente->razao_social; ?></a></td>                                  
							<td class="hidden-phone"><?php echo $emitente->nome_fantasia; ?></td>                                 
							<td> <span style='font-weight:bold' class="label label-<?php echo $emitente->cor; ?> label-mini"><?php echo $emitente->descricao; ?></span></td>								 
							<td class="hidden-phone"><?php echo $emitente->area ?> %</td>                                  
							<td> 
							<?php if($visitante == 0){ ?>
							<a href="<?php echo $this->config->base_url();?>index.php/imovel/editar_emitente?id=<?php echo $emitente->id_emitente_imovel; ?>&id_im=<?php echo $id_im; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
							<a href="<?php echo $this->config->base_url();?>index.php/imovel/excluir_emitente_imovel?id=<?php echo $emitente->id_emitente_imovel; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>                                  
							<?php } ?>
							</td>								  
							</tr>								 								 
							<?php								 
							}								  
							}								  								  
							?>								
							<tr>                                  
								<td></td>                                 
								<td class="hidden-phone"></td>                                  
								<td> </td>								 
								<td class="hidden-phone">								 
									<?php 								  
										if($total <> 0){									
											echo $total ;								  
										}
									?> %</td>                                  
								<td>                                 
								</td>								 
								</tr>                                                           
								</tbody>                          
								</table>  
                            </div>
                        </div>
                    </div>
                    
                </div> 
            </div>

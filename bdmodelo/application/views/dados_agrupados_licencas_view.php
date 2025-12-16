<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Lojas X Licenças<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/licencas/dados_agrupados"><i class="fa fa-home"></i> Dados Agrupados</a></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                   <div class="row">
				   	<?php 	
					$total = 0;
					$isArray = is_array($iptus) ? '1' : '0';								
					if($isArray == 1){								
						foreach($iptus as $key => $iptu){

							if($iptu['possui_cnd'] == 1){										
									$possui ='Vigente';				
									$arquivo = 'listarVigentes';	
									$WMBR = $regionalVig[1]['total'];
									$BPBA = $regionalVig[2]['total'];
									$BPNE = $regionalVig[3]['total'];
									$WMS = $regionalVig[4]['total'];	
							
							}else{										
									$possui ='Vencida';										
									$arquivo = 'listarVencidas';
									$WMBR = $regionalNVig[1]['total'];
									$BPBA = $regionalNVig[2]['total'];
									$BPNE = $regionalNVig[3]['total'];
									$WMS = $regionalNVig[4]['total'];		

							}
							
					
					?>
                        <div class="col-sm-3 margin-b-30">
                            <div class="price-box">
                                <h3><?php echo $possui; ?> </h3>
                                <h4><?php echo $iptu['total']; ?></h4>
                                <ul class="list-unstyled">
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/listarPorSituacao?tipo=<?php echo $iptu['possui_cnd'] ?>&situacao=2" >Norte </a>: <?php echo  $WMBR ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/listarPorSituacao?tipo=<?php echo $iptu['possui_cnd'] ?>&situacao=1" >Sul </a> : <?php echo $BPBA ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/listarPorSituacao?tipo=<?php echo $iptu['possui_cnd'] ?>&situacao=1" >Leste </a> : <?php echo $BPNE ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/listarPorSituacao?tipo=<?php echo $iptu['possui_cnd']?>&situacao=1" >Oeste </a> : <?php echo $WMS ?></li>                               
								</ul>

								<a href="<?php echo $this->config->base_url();?>index.php/<?php echo $modulo; ?>/<?php echo $arquivo; ?>"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Ver Detalhado</a>
                            </div>
                        </div><!--col-->
						
                        <?php }} ?> 
                        
                        
                    </div>
                    
                </div> 
            </div>

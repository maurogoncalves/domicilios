<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1><?php echo $nome_modulo; ?> <small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/<?php echo $modulo; ?>/dados_agrupados"><i class="fa fa-home"></i> Dados Agrupados</a></li>
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
							if($iptu->possui_cnd == 1){										
								$possui ='Sim';				
								$arquivo = 'listarPorTipoSim';	
								$WMBR = $regionalSim[1]['total'];
								$BPBA = $regionalSim[2]['total'];
								$BPNE = $regionalSim[3]['total'];
								$WMS = $regionalSim[4]['total'];
								$TB = $regionalSim[5]['total'];	

								
							}elseif($iptu->possui_cnd == 2){										
								$possui ='Não';										
								$arquivo = 'listarPorTipoNao';
								
								$WMBR = $regionalNao[1]['total'];
								$BPBA = $regionalNao[2]['total'];
								$BPNE = $regionalNao[3]['total'];
								$WMS = $regionalNao[4]['total'];
								$TB = $regionalNao[5]['total'];	
								
							}elseif($iptu->possui_cnd == 3){										
								$possui ='Pendência';			
								$arquivo = 'listarPorTipoPendencia';
								$WMBR = $regionalPend[1]['total'];
								$BPBA = $regionalPend[2]['total'];
								$BPNE = $regionalPend[3]['total'];
								$WMS = $regionalPend[4]['total'];
								$TB = $regionalPend[5]['total'];	
								
							}elseif($iptu->possui_cnd == 99){										
								$possui ='Nada Consta';			
								$arquivo = 'listarLoja';
								$WMBR = $regionalNC[1]['total'];
								$BPBA = $regionalNC[2]['total'];
								$BPNE = $regionalNC[3]['total'];
								$WMS = $regionalNC[4]['total'];
								$TB = $regionalNC[5]['total'];
							}else{
								$possui ='Sem Definição';
								$arquivo = 'listarPorTipo';	
								$WMBR = 0;
								$BPBA = 0;
								$BPNE = 0;	
								$WMS = 0;
								$TB = 0;
								
							}
							$total = $total + $iptu->total;							
							if(($iptu->possui_cnd == 1) || ($iptu->possui_cnd == 3)){
								echo"<div class='col-sm-2 margin-b-20'>";	
							}else{
								echo"<div class='col-sm-3 margin-b-20'>";	
							}
							
						?>
                            <div class="price-box">
                                <h3><?php echo $possui; ?> </h3>
                                <h4><?php echo $iptu->total; ?></h4>
								<h3>Regionais</h3>
								
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/listarPorRegional?tipo=<?php echo $iptu->possui_cnd ?>&reg=1"  >  WMBR : <?php echo  $WMBR ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/listarPorRegional?tipo=<?php echo $iptu->possui_cnd ?>&reg=2"  >  BPBA : <?php echo  $BPBA ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/listarPorRegional?tipo=<?php echo $iptu->possui_cnd ?>&reg=3"  >  BPNE : <?php echo $BPNE ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/listarPorRegional?tipo=<?php echo $iptu->possui_cnd ?>&reg=4"  >  WMS : <?php echo $WMS ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/listarPorRegional?tipo=<?php echo $iptu->possui_cnd ?>&reg=5"  > TB : <?php echo $TB ?></li>

                                </ul>

								<a href="<?php echo $this->config->base_url();?>index.php/<?php echo $modulo; ?>/<?php echo $arquivo; ?>"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Ver Detalhado</a>
                            </div>
                        </div><!--col-->
                        <?php }} ?> 
                        <div class="col-sm-2 margin-b-20">
                            <div class="price-box">
                                <h3>Todos</h3>
                                <h4>
								<?php echo  $soma = $regionalTodos[1]['total']+$regionalTodos[2]['total']+$regionalTodos[3]['total']+$regionalTodos[4]['total']+$regionalTodos[5]['total']; ?>
								</h4>
								<h3>Regionais</h3>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/listarPorRegional?tipo=5&reg=1"  >  WMBR : <?php echo  $regionalTodos[1]['total'] ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/listarPorRegional?tipo=5&reg=2"  >  BPBA : <?php echo  $regionalTodos[2]['total'] ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/listarPorRegional?tipo=5&reg=3"  >  BPNE : <?php echo  $regionalTodos[3]['total'] ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/listarPorRegional?tipo=5&reg=4"  >  WMS : <?php echo  $regionalTodos[4]['total'] ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/listarPorRegional?tipo=5&reg=5"  > TB : <?php echo  $regionalTodos[5]['total'] ?></li>

                                </ul>

								<a href="<?php echo $this->config->base_url();?>index.php/<?php echo $modulo; ?>/listarTodos"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Ver Detalhado</a>
                            </div>
                        </div><!--col-->
                        
                    </div>
                    
                </div> 
            </div>

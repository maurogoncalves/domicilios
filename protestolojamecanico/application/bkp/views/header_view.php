<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Walmart</title>

        <!-- Bootstrap -->
        <link href="<?php echo $this->config->base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $this->config->base_url(); ?>assets/css/waves.min.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/nanoscroller.css">
        <link href="<?php echo $this->config->base_url(); ?>assets/css/menu-light.css" type="text/css" rel="stylesheet">
        <link href="<?php echo $this->config->base_url(); ?>assets/css/style.css" type="text/css" rel="stylesheet">
		<link href="<?php echo $this->config->base_url(); ?>assets/css/chartist.min.css" type="text/css" rel="stylesheet">
        <link href="<?php echo $this->config->base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- Static navbar -->

        <?php include('header_include.php');?>
        <section class="page">

            <?php include('sidebar.php');?>

            <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Dashboard <small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title
					 <div class="row">
						 <div class="col-lg-4">
								<div class="widget-box clearfix">
									<div class="pull-left">
										<h4>Quantidade de Upload CND</h4>
										<h2><?php echo$cndAtual[0]['total']; ?> </h2>
									</div>
									<div class="text-right">

										<span id="sparkline8"></span>
									</div>
								</div>
							</div>
					   </div>
					   -->
					   
					  					
                    <div class="row">
						
						
						<div class="row">
						<div class="col-sm-12">
								<div class="panel panel-card recent-activites" style='margin-bottom: -5px;'>
									<h1 style='color:#00B2A9'>CND </h1>
								</div>
						 </div>
						</div>
						
						 <div class="row">
								<div class="col-sm-12">  <br>
								</div>
							</div>
			

                        <div class="col-sm-12">
                            <div class="row">
								<div class="col-md-1">

                                </div>
                                <div class="col-md-2">
                                    <div class="widget-box clearfix">
                                        <div>
                                            <h4>Tot. Inscrições Mobiliárias <a id='export'  href="<?php echo $this->config->base_url();?>index.php/cnd_mob/export_total_mob"><i  style='color:#01A2FF' class="fa fa-file-excel-o" ></i> </a></h4>
                                            <h2><?php echo $totalCNDM ?></h2>
                                        </div>
                                    </div>
                                </div>
								<div class="col-md-2">                                   
									<div class="widget-box clearfix">                                        
										<div>                                            
										<h4>Tot. Inscrições Imobiliárias <a id='export'  href="<?php echo $this->config->base_url();?>index.php/cnd_imob/export_total_imob"><i  style='color:#01A2FF' class="fa fa-file-excel-o" ></i> </a></h4>                                            
										<h2><?php echo $totalCNDIm ?> </h2>                                        
										</div>                                    
									</div>                                
								</div>

                               <div class="col-md-2">
                                    <div class="widget-box clearfix">
                                        <div>
                                            <h4>Tot. Inscrições Estaduais <a id='export'  href="<?php echo $this->config->base_url();?>index.php/cnd_est/export_total"><i  style='color:#01A2FF' class="fa fa-file-excel-o" ></i> </a></h4>
                                            <h2><?php echo $totalCNDE ?> </h2>
                                        </div>
                                    </div>
                                </div>
								<div class="col-md-2">
                                    <div class="widget-box clearfix">
                                        <div>
                                            <h4>Tot. Inscrições Federais * <a id='export'  href=""><i  style='color:#01A2FF' class="fa fa-file-excel-o" ></i> </a></h4>
                                            <h2><?php echo '0' ?> </h2>
                                        </div>
                                    </div>
                                </div>
							    <div class="col-md-2">
                                    <div class="widget-box clearfix">
                                        <div>
                                            <h4>Total Matriculas CEI <a id='export'  href="<?php echo $this->config->base_url();?>index.php/matricula_cei/export_total"><i  style='color:#01A2FF' class="fa fa-file-excel-o" ></i> </a></h4>
                                            <h2><?php echo $totalMatrCei ?> </h2>
                                        </div>
                                    </div>
                                </div>
								
                            </div>
                        </div>
                    </div>
					


                    <div class="row">
					<div class="row">
						<div class="col-sm-12">
								<div class="panel panel-card recent-activites" style='margin-bottom: -5px;'>
									<h3>Por situação &nbsp; </a>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									E - Emitida | NE - Não emitida | NT - Não Tratada | P - Pendente </h3>
									
									
								</div>
						 </div>
					 </div>
					 <div class="row">
								<div class="col-sm-12"> <br>
								</div>
							</div>
					
						<div class="col-sm-3">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h3 class="panel-title">Mobili&aacute;ria &nbsp; 
										<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_mob/export_total_mob"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
									</h3>
                                    <div class="panel-actions">
                                        
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartMob" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>

                                </div>
                            </div><!-- End .panel --> 
                        </div>					
                         <div class="col-sm-3">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h3 class="panel-title">Imobili&aacute;ria &nbsp; 
										<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_imob/export_total_imob"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
									</h3>
                                    <div class="panel-actions">
                                        
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartImob" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>

                                </div>
                            </div><!-- End .panel --> 
                        </div>
                        <div class="col-sm-3">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h3 class="panel-title">Estadual &nbsp; 
									<a id='export'  href="<?php echo $this->config->base_url();?>index.php/cnd_est/export_total"><i  style='color:#01A2FF' class="fa fa-file-excel-o" ></i> </a>
									</h3>
                                    <div class="panel-actions">
                                        
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartEst" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>


                                </div>
                            </div><!-- End .panel --> 
                        </div>
						<div class="col-sm-3">
							<div class="panel panel-card recent-activites">
							<div class="panel-heading">
                                    <h4 class="panel-title">Federal * </h4>
                                    <div class="panel-actions">
                                        
                                    </div>
                                </div>
								
								<div class="panel-body text-center">
                                    <div>
                                       <canvas id="doughnutChartFed" height="150"></canvas>										
									   <div id="js-legend" class="chart-legend"></div>
                                    </div>


                                </div>
							  </div>	
						</div>
						<!--
						<div class="col-sm-2">
							<div class="panel panel-card recent-activites">
							<div class="panel-heading">
                                    <h4 class="panel-title">Obras &nbsp; 
										<a id='export'  href="<?php echo $this->config->base_url();?>index.php/matricula_cei/export_total"><i  style='color:#01A2FF' class="fa fa-file-excel-o" ></i> </a>
									</h4>
                                    <div class="panel-actions">
                                        
                                    </div>
                                </div>
								<div class="panel-body text-center">
                                    <div>
                                     <canvas id="doughnutChartObras" height="150"></canvas>									
									 <div id="js-legend" class="chart-legend"></div>  
                                    </div>


                                </div>
							 </div>		
						</div>
						--> 
                    </div>
					<div class="row">	
						
						<div class="col-sm-12">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading-minus">
								<h3>CND Estaduais por estado <a id='export'  href="<?php echo $this->config->base_url();?>index.php/cnd_est/export_todos_estados"><i  style='color:#01A2FF' class="fa fa-file-excel-o" ></i> </a></h3>
                                </div>
                                <div class="panel-body text-center">
                                    <div>
										 <canvas id="barChartCND" height="110"></canvas>
                                    </div>
                                </div>
                            </div><!-- End .panel --> 
                        </div>
						
						<div class="row">
								<div class="col-sm-12"> <br>
								</div>
						</div>
					 
					</div>
					
					<div class="row">	
					<div class="row">
						<div class="col-sm-12">
								<div class="panel panel-card recent-activites" style='margin-bottom: -5px;'>
									<h1 style='color:#00B2A9'>IPTU <small></small></h1>
								</div>
						 </div>
					 </div>
					 <div class="row">
								<div class="col-sm-12"> <br>
								</div>
							</div>
		
					 <div class="col-sm-3">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
								<BR><br><BR><BR><BR><BR>
                                <div class="panel-heading-minus">
                                    <h3 class="panel-title">Total (R$) &nbsp;&nbsp; <?php echo$palavra.' '.$diferencaIptu. '%'; ?> &nbsp;<a id='export' href="<?php echo $this->config->base_url();?>index.php/iptu/export_total_valores"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a></h3>
									<BR>
                                </div>

                               <div class="panel-body text-center">									
                                    <div id="iptuValores" ></div>
                                </div>
								<Br><Br><Br><br><br>								
                            </div><!-- End .panel --> 
                        </div>		
						<div class="col-sm-9">
							
                           <div class="panel panel-card recent-activites" style='margin-bottom: -5px;'>
								<h3 class="panel-title">Por região (CNPJ) - R$ &nbsp;<a id='export' href="<?php echo $this->config->base_url();?>index.php/iptu/export_total_regiao"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a></h3>                                   
                            </div>
							<div class="row">
								<div class="col-sm-12"> <br>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title">Norte  <?php  echo$palavraWMBR.' '.$diferencaWMBR. '%'; ?></h3>
										</div>
									   <div class="panel-body text-center">									
											<div id="WMBR" ></div>
										</div>
									</div><!-- End .panel --> 								
								</div>		
							
							
								<div class="col-sm-6">
									<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title">Sul <?php  echo$palavraWMS.' '.$diferencaWMS. '%'; ?></h3>
										</div>
									   <div class="panel-body text-center">									
											<div id="WMS" ></div>
										</div>
									</div><!-- End .panel --> 								
								</div>		
							
								
							</div>
							<div class="row">
								
								<div class="col-sm-6">
									<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title">Leste  <?php  echo$palavraBPBA.' '.$diferencaBPBA. '%'; ?></h3>
										</div>
									   <div class="panel-body text-center">									
											<div id="BPBA" ></div>
										</div>
									</div><!-- End .panel --> 								
								</div>		
								
								<div class="col-sm-6">
									<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title">Oeste <?php  echo$palavraBPNE.' '.$diferencaBPNE. '%'; ?></h3>
										</div>
									   <div class="panel-body text-center">									
											<div id="BPNE" ></div>
										</div>
									</div><!-- End .panel --> 								
								</div>		
								
								
							</div>
                        </div>								
					<div class="col-sm-12">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading-minus">
                                    <h4 class="panel-title"> 
									Por estados (R$) &nbsp;&nbsp;
									<span style='background-color:#66b5dd'> &nbsp;&nbsp;  </span><strong><?php echo '&nbsp; '.$anoAtual ?></strong>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<span style='background-color:#01a8fe'> &nbsp;&nbsp;  </span><strong><?php echo '&nbsp; '.$anoPassado ?></strong>
									&nbsp;
									&nbsp;<a id='export' href="<?php echo $this->config->base_url();?>index.php/iptu/export_estado"><i  style='color:#01A2FF' class="fa fa-file-excel-o"></i></a>
									<BR><BR>
                                    <div class="panel-actions">
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div>
                                        <canvas id="barChart" height="110"></canvas>
                                    </div>

                                </div>
                            </div><!-- End .panel --> 
                        </div>
					</div>
                   <div class="row">
				    <div class="row">
						<div class="col-sm-12">
								<div class="panel panel-card recent-activites" style='margin-bottom: -5px;'>
									<h1 style='color:#00B2A9'>LICENÇAS <small></small></h1>
								</div>
						 </div>
					 </div>
					 <div class="row">
								<div class="col-sm-12"> <br>
								</div>
							</div>
					 <div class="col-sm-4">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading-minus">
                                    <h3 class="panel-title">Por Inscrição mobili&aacute;ria / loja 
									&nbsp;<a id='export' href="<?php echo $this->config->base_url();?>index.php/licencas/export_status_licenca?tipo=T"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a>
									</h3>
									<br><br>
                                    <div class="panel-actions">
                                        
                                    </div>
                                </div>
                               <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartLicTot" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>

                                </div>
                            </div><!-- End .panel --> 
                        </div>		
						<div class="col-sm-2">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading-minus">
                                    <h3 class="panel-title">Vencida por região &nbsp;<a id='export' href="<?php echo $this->config->base_url();?>index.php/licencas/export_status_licenca?tipo=V"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a></h3>
									<BR><BR><BR>
                                    <div class="panel-actions">
                                        
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartLicV" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>
									<BR><BR>
                                </div>
                            </div><!-- End .panel --> 
                        </div>		
						<div class="col-sm-2">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading-minus">
                                    <h3 class="panel-title">Pendente por região  &nbsp;<a id='export' href="<?php echo $this->config->base_url();?>index.php/licencas/export_status_licenca?tipo=P"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a></h3>
									<BR><BR><BR>
                                    <div class="panel-actions">
                                        
                                    </div>
                                </div>
                               <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartLicP" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>
									<BR><BR>
                                </div>
                            </div><!-- End .panel --> 
                        </div>	
						<div class="col-sm-2">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading-minus">
                                    <h3 class="panel-title">A vencer 60 dias / reg.  &nbsp;<a id='export' href="<?php echo $this->config->base_url();?>index.php/licencas/export_dias_regiao?dias=60"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a> </h3>
									<BR><BR><BR>
                                    <div class="panel-actions">
                                        
                                    </div>
                                </div>
                               <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartLicSessenta" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>
									<BR><BR>
                                </div>
                            </div><!-- End .panel --> 
                        </div>		
						<div class="col-sm-2">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading-minus">
                                    <h3 class="panel-title">A vencer 30 dias / reg.  &nbsp;<a id='export' href="<?php echo $this->config->base_url();?>index.php/licencas/export_dias_regiao?dias=30"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a> </h3>
									<BR><BR><BR>
                                    <div class="panel-actions">
                                        
                                    </div>
                                </div>
                               <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartLicTrinta" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>
									<BR><BR>
                                </div>
                            </div><!-- End .panel --> 
                        </div>								
				   </div>
				    <div class="row">
						<div class="row">
						<div class="col-sm-12">
								<div class="panel panel-card recent-activites" style='margin-bottom: -5px;'>
									<h3>Tipos de licenças vencidas por região
									&nbsp;
									<a id='export' href="<?php echo $this->config->base_url();?>index.php/licencas/export_status_licenca?tipo=V"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a>
									<small></small></h3>
								</div>
						 </div>
						
						 
						 </div>
						  <div class="row">
								<div class="col-sm-12"> <br>
								</div>
							</div>
						 <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<!-- Start .panel -->
									<div class="panel-heading">
										<h3 class="panel-title">Norte  </h3>
										<div class="panel-actions">
											
										</div>
									</div>
								   <div class="panel-body text-center">
										<div>
											<canvas id="doughnutChartLicWMBR" height="150"></canvas>
											<div id="js-legend" class="chart-legend"></div>
										</div>

									</div>
								</div><!-- End .panel --> 
							</div>

							<div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<!-- Start .panel -->
									<div class="panel-heading">
										<h3 class="panel-title">Sul</h3>
										<div class="panel-actions">
											
										</div>
									</div>
								   <div class="panel-body text-center">
										<div>
										<?php if(count($licencasWMSArr)){
											
										?>	
											<canvas id="doughnutChartLicWMS" height="150"></canvas>
											<div id="js-legend" class="chart-legend"></div>
										<?php	
										}else{
											echo'Sem Dados';
										}
										?>
											
										</div>

									</div>
								</div><!-- End .panel --> 
							</div>	
							
							<div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<!-- Start .panel -->
									<div class="panel-heading">
										<h3 class="panel-title">Leste </h3>
										<div class="panel-actions">
											
										</div>
									</div>
								   <div class="panel-body text-center">
										<div>
										<?php if(count($licencasBPBAArr)){
											
										?>	
											<canvas id="doughnutChartLicBPBA" height="150"></canvas>
											<div id="js-legend" class="chart-legend"></div>
										<?php	
										}else{
											echo'Sem Dados';
										}
										?>
											
										</div>

									</div>
								</div><!-- End .panel --> 
							</div>

							<div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<!-- Start .panel -->
									<div class="panel-heading">
										<h3 class="panel-title">Oeste </h3>
										<div class="panel-actions">
											
										</div>
									</div>
								   <div class="panel-body text-center">
										<div>
										<?php if(count($licencasBPNEArr)){
											
										?>	
											<canvas id="doughnutChartLicBPNE" height="150"></canvas>
											<div id="js-legend" class="chart-legend"></div>
										<?php	
										}else{
											echo'Sem Dados';
										}
										?>
											
										</div>

									</div>
								</div><!-- End .panel --> 
							</div>		

							

							
					 </div>
					 
					 <div class="row">
						<div class="row">
						<div class="col-sm-12">
								<div class="panel panel-card recent-activites">
									<h3>Tipos de licenças pendentes por região
									&nbsp;
									<a id='export' href="<?php echo $this->config->base_url();?>index.php/licencas/export_status_licenca?tipo=P"><i class="fa fa-file-excel-o"></i></a>
									<small></small></h3>
								</div>
						 </div>
						 
						 </div>
						 <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<!-- Start .panel -->
									<div class="panel-heading">
										<h3 class="panel-title">Norte </h3>
										<div class="panel-actions">
											
										</div>
									</div>
								   <div class="panel-body text-center">
										<div>
										<?php if(count($licencasPWArr)){
											
										?>	
											<canvas id="doughnutChartLicPW" height="150"></canvas>
											<div id="js-legend" class="chart-legend"></div>
										<?php	
										}else{
											echo'Sem Dados';
										}
										?>
											
										</div>

									</div>
								</div><!-- End .panel --> 
						</div>	
						
						<div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<!-- Start .panel -->
									<div class="panel-heading">
										<h3 class="panel-title">Sul  </h3>
										<div class="panel-actions">
											
										</div>
									</div>
								   <div class="panel-body text-center">
										<div>
										<?php if(count($licencaPWMSArr)){
											
										?>	
											<canvas id="doughnutChartLicPWMS" height="150"></canvas>
											<div id="js-legend" class="chart-legend"></div>
										<?php	
										}else{
											echo'Sem Dados';
										}
										?>
											
										</div>

									</div>
								</div><!-- End .panel --> 
						</div>		
						<div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<!-- Start .panel -->
									<div class="panel-heading">
										<h3 class="panel-title">Leste </h3>
										<div class="panel-actions">
											
										</div>
									</div>
								   <div class="panel-body text-center">
										<div>
										<?php if(count($licencaPBPBAArr)){
											
										?>	
											<canvas id="doughnutChartLicPBPBA" height="150"></canvas>
											<div id="js-legend" class="chart-legend"></div>
										<?php	
										}else{
											echo'Sem Dados';
										}
										?>
											
										</div>

									</div>
								</div><!-- End .panel --> 
						</div>
						<div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<!-- Start .panel -->
									<div class="panel-heading">
										<h3 class="panel-title">Oeste </h3>
										<div class="panel-actions">
											
										</div>
									</div>
								   <div class="panel-body text-center">
										<div>
										<?php if(count($licencaPBPNEArr)){
											
										?>	
											<canvas id="doughnutChartLicPBPNE" height="150"></canvas>
											<div id="js-legend" class="chart-legend"></div>
										<?php	
										}else{
											echo'Sem Dados';
										}
										?>
											
										</div>

									</div>
								</div><!-- End .panel --> 
						</div>
				
						
                  </div>
				   <div class="row">
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-card recent-activites" style='margin-bottom: -5px;'>
								<h1 style='color:#00B2A9'>INFRAÇÃO<small></small></h1>
							</div>
						 </div>

					</div>
					<div class="row">
						<div class="col-sm-12"> <br>
						</div>
					</div>
					<div class="col-sm-2"> <br>
						</div>
					<div class="col-sm-4">
						<div class="panel panel-card recent-activites">
								<!-- Start .panel -->
								<div class="panel-heading">										
									<h3 class="panel-title">Total (R$)  &nbsp;&nbsp; <?php echo$palavraTotInfra.' '.$diferencaTotInfra. '%'; ?>
									&nbsp;
									 <a id='export' href="<?php echo $this->config->base_url();?>index.php/infracoes/exporTodosGrafico"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a>
									</h3>										
									<br>
								</div>
							   <div class="panel-body text-center">									
									<div id="infraAnos" ></div>
									<br>
								</div>
						</div><!-- End .panel --> 		
					</div>
					<div class="col-sm-4">
						<div class="panel panel-card recent-activites">
							<div class="panel-heading-minus">
								<h3 class="panel-title">Total de infrações &nbsp;
									 <a id='export' href="<?php echo $this->config->base_url();?>index.php/infracoes/exporTodosGrafico"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a> </h3>
								<br>
							</div>
							<div class="panel-body text-center">									
								   <?php if(count($totalInfraPorc)){	?>	
										<canvas id="doughnutChartInfra" height="95"></canvas>
										<div id="js-legend" class="chart-legend"></div>
									<?php	
										}else{
											echo'Sem Dados';
										}
									?>
							</div>		
						</div>
					
					</div>
						<div class="col-sm-3"> <br>
						</div>
						
						<div class="row">
						<div class="col-sm-12">
								<div class="panel panel-card recent-activites">
									<h3>Status da infração por região (CNPJ)
										&nbsp;
										<a id='export' href="<?php echo $this->config->base_url();?>index.php/infracoes/exporTodosGrafico"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a>
										<small></small></h3>
								</div>
						 </div>						 
						 </div>
						 <div class="row">
							 <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<div class="panel-heading-minus">
											<h3 class="panel-title">Norte</h3>
										</div>								
									   <div class="panel-body text-center">									
												<canvas id="doughnutChartInfraWMBR" height="150"></canvas>
												<div id="js-legend" class="chart-legend"></div>
										</div>
								</div>
							 </div>						 
							 <div class="col-sm-3">		
								<div class="panel panel-card recent-activites">
									<div class="panel-heading-minus">
										<h3 class="panel-title">Sul</h3>
									</div>								
									<div class="panel-body text-center">									
										<canvas id="doughnutChartInfraWMS" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
									</div>							
								</div>	
							 </div>					
							 <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
										<div class="panel-heading-minus">
											<h3 class="panel-title">Leste</h3>
										</div>								
									   <div class="panel-body text-center">									
												<canvas id="doughnutChartInfraBPBA" height="150"></canvas>
												<div id="js-legend" class="chart-legend"></div>
										</div>
									</div>
							 </div>						 							 
							 <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
										<div class="panel-heading-minus">
											<h3 class="panel-title">Oeste</h3>
										</div>								
									   <div class="panel-body text-center">									
												<canvas id="doughnutChartInfraBPNE" height="150"></canvas>
												<div id="js-legend" class="chart-legend"></div>
										</div>
									</div>
							 </div>						 							 
						 </div>	 
							 
						
						
						<div class="row">
						<div class="col-sm-12">
								<div class="panel panel-card recent-activites">
									<h3>Total por região (CNPJ) - R$
										&nbsp;
										<a id='export' href="<?php echo $this->config->base_url();?>index.php/infracoes/exporTodosGrafico"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a>
										<small></small></h3>
								</div>
						 </div>
						 
						 </div>
						 
						<div class="row">
	

							 <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<?php if( ($infracoesAnoAtualWMBR[0]['total'] == 0) && ($infracoesAnoPassWMBR[0]['total'] == 0)){ ?>
											<h3 class="panel-title">Norte &nbsp;&nbsp;  0</h3>
											<?php }else{ ?>
											<h3 class="panel-title">Norte &nbsp;&nbsp; <?php echo$palavraInfraWMBR.' '.$diferencaInfraWMBR. '%'; ?></h3>
											<?php } ?>
										</div>
									   <div class="panel-body text-center">									
											<div id="infraWMBR" ></div>
										</div>										
								</div><!-- End .panel --> 				
							 </div>
							 
							 <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<?php if( ($infracoesAnoAtualWMS[0]['total'] == 0) && ($infracoesAnoPassWMS[0]['total'] == 0)){ ?>
											<h3 class="panel-title">Sul &nbsp;&nbsp;  0</h3>
											<?php }else{ ?>
											<h3 class="panel-title">Sul &nbsp;&nbsp; <?php echo$palavraInfraWms.' '.$diferencaInfraWms. '%'; ?></h3>
											<?php } ?>
										</div>
									   <div class="panel-body text-center">									
											  <div id="infraWms" ></div>
										</div>
									</div><!-- End .panel --> 			
							 </div>
							  <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title">Leste </h3>
										</div>
									   <div class="panel-body text-center">									
											<div id="infraBPBA" ></div>
										</div>
									</div><!-- End .panel --> 			
							 </div>
							 <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<?php if( ($infracoesAnoAtualBPNE[0]['total'] == 0) && ($infracoesAnoPassBPNE[0]['total'] == 0)){ ?>
											<h3 class="panel-title">Oeste &nbsp;&nbsp;  0</h3>
											<BR>
											<?php }else{ ?>
											<h3 class="panel-title">Oeste &nbsp;&nbsp; <?php echo$palavraInfraBPNE.' '.$diferencaInfraBPNE. '%'; ?></h3>
											<?php } ?>
										</div>
									   <div class="panel-body text-center">									
											<div id="infraBPNE" ></div>
										</div>
									</div><!-- End .panel --> 					
							 </div>
							
						 
						 </div>
						 
						 <div class="row">
							<div class="col-sm-12">
									<div class="panel panel-card recent-activites">
										<h3>Valores pagos por região (CNPJ) - R$
											&nbsp;
											<a id='export' href="<?php echo $this->config->base_url();?>index.php/infracoes/exporTodosGraficoPagos"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a>
											<small></small></h3>
									</div>
							 </div>						 
						 </div>
						 <div class="row">
								 <div class="col-sm-3">
									<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<?php if( ($infracoesValorPagoAnoAtualWMBR[0]['total'] == 0) && ($infracoesValorPagoAnoPassWMBR[0]['total'] == 0)){ ?>
												<h3 class="panel-title">Norte &nbsp;&nbsp;  0</h3>
											<?php }else{ ?>
												<h3 class="panel-title">Norte &nbsp;&nbsp; <?php echo$palavraInfraValorPagoWMBR.' '.$diferencaInfraValorPagoWMBR. '%'; ?></h3>
											<?php } ?>
										</div>
									   <div class="panel-body text-center">									
											<div id="infraValorPagoWMBR" ></div>
										</div>
									</div><!-- End .panel --> 			
								</div>	
								<div class="col-sm-3">
										<div class="panel panel-card recent-activites">
											<!-- Start .panel -->
											<div class="panel-heading">
												<?php if( ($infracoesValorPagoAnoAtualWMS[0]['total'] == 0) && ($infracoesValorPagoAnoPassWMS[0]['total'] == 0)){ ?>
												<h3 class="panel-title">Sul &nbsp;&nbsp;  0</h3>
												<?php }else{ ?>
												<h3 class="panel-title">Sul &nbsp;&nbsp; <?php echo$palavraInfraValorPagoWms.' '.$diferencaInfraValorPagoWms. '%'; ?></h3>
												<?php } ?>
											</div>
										   <div class="panel-body text-center">									
												<div id="infraValorPagoWMS" ></div>
											</div>
										</div><!-- End .panel --> 					
								</div>	
								<div class="col-sm-3">								
									<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<?php if( ($infracoesValorPagoAnoAtualBPBA[0]['total'] == 0) && ($infracoesValorPagoAnoPassBPBA[0]['total'] == 0)){ ?>
												<h3 class="panel-title">Leste  &nbsp;&nbsp;  0</h3>
											<?php }else{ ?>
												<h3 class="panel-title">Leste &nbsp;&nbsp; <?php echo$palavraInfraValorPagoBPBA.' '.$diferencaInfraValorPagoBPBA. '%'; ?></h3>
											<?php } ?>
										</div>
									   <div class="panel-body text-center">									
											<div id="infraValorPagoBPBA" ></div>
										</div>
									</div><!-- End .panel --> 			
								</div>	
								<div class="col-sm-3">	
									<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<?php if( ($infracoesValorPagoAnoAtualBPNE[0]['total'] == 0) && ($infracoesValorPagoAnoPassBPNE[0]['total'] == 0)){ ?>
												<h3 class="panel-title">Oeste &nbsp;&nbsp;  0</h3>
											<?php }else{ ?>
												<h3 class="panel-title">Oeste &nbsp;&nbsp; <?php echo$palavraInfraValorPagoBPNE.' '.$diferencaInfraValorPagoBPNE. '%'; ?></h3>
											<?php } ?>
										</div>
									   <div class="panel-body text-center">									
											<div id="infraValorPagoBPNE" ></div>
										</div>
									</div><!-- End .panel --> 			
								</div>									
						 </div>
						<div class="row">
							<div class="col-sm-12">
									<div class="panel panel-card recent-activites">
										<h3>Valores defendidos por região (CNPJ) - R$
											&nbsp;
											<a id='export' href="<?php echo $this->config->base_url();?>index.php/infracoes/exporTodosGraficoPagos"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a>
											<small></small></h3>
									</div>
							 </div>						 
						 </div>	
						 <div class="row">
							<div class="col-sm-3">	
								<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<?php if( ($infracoesValorDefAnoPassWMBR == 0) && ($infracoesValorDefAnoAtualWMBR == 0)){ ?>
												<h3 class="panel-title">Norte &nbsp;&nbsp;  0</h3>
											<?php }else{ ?>
												<h3 class="panel-title">Norte &nbsp;&nbsp; <?php echo$palavraInfraValorDefWMBR.' '.$diferencaInfraValorDefWMBR. '%'; ?></h3>
											<?php } ?>
										</div>
									   <div class="panel-body text-center">									
											<div id="infraValorDefWMBR" ></div>
										</div>
									</div><!-- End .panel --> 			
							</div>
							<div class="col-sm-3">	
								<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<?php if( ($infracoesValorDefAnoPassWMS == 0) && ($infracoesValorDefAnoAtualWMS == 0)){ ?>
												<h3 class="panel-title">Sul &nbsp;&nbsp;  0</h3>
											<?php }else{ ?>
												<h3 class="panel-title">Sul &nbsp;&nbsp; <?php echo$palavraInfraValorDefWMS.' '.$diferencaInfraValorDefWMS. '%'; ?></h3>
											<?php } ?>
										</div>
									   <div class="panel-body text-center">									
											<div id="infraValorDefWMS" ></div>
										</div>
									</div><!-- End .panel --> 					
							</div>
							<div class="col-sm-3">	
								<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<?php if( ($infracoesValorDefAnoPassBPNE == 0) && ($infracoesValorDefAnoAtualBPNE == 0)){ ?>
												<h3 class="panel-title">Leste &nbsp;&nbsp;  0</h3>
											<?php }else{ ?>
												<h3 class="panel-title">Leste &nbsp;&nbsp; <?php echo$palavraInfraValorDefBPNE.' '.$diferencaInfraValorDefBPNE. '%'; ?></h3>
											<?php } ?>
										</div>
									   <div class="panel-body text-center">									
											<div id="infraValorDefBPNE" ></div>
										</div>
									</div><!-- End .panel --> 				
							</div>
							<div class="col-sm-3">	
								<div class="panel panel-card recent-activites">
										<!-- Start .panel -->
										<div class="panel-heading">
											<?php if( ($infracoesValorDefAnoPassBPBA == 0) && ($infracoesValorDefAnoAtualBPBA == 0)){ ?>
												<h3 class="panel-title">Oeste &nbsp;&nbsp;  0</h3>
											<?php }else{ ?>
												<h3 class="panel-title">Oeste &nbsp;&nbsp; <?php echo$palavraInfraValorDefBPBA.' '.$diferencaInfraValorDefBPBA. '%'; ?></h3>
											<?php } ?>
										</div>
									   <div class="panel-body text-center">									
											<div id="infraValorDefBPBA" ></div>
										</div>
									</div><!-- End .panel --> 					
							</div>
						 </div>	
						<div class="row">
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-card recent-activites" style='margin-bottom: -5px;'>
								<h1 style='color:#00B2A9'>NOTIFICAÇÃO<small></small></h1>
							</div>
						 </div>

					</div>
					<div class="row">
						<div class="col-sm-12"> <br>
						</div>
					</div>
					<div class="col-sm-4">
					</div>
					<div class="col-sm-4">
						<div class="panel panel-card recent-activites">
							<div class="panel-heading-minus">
								<h3 class="panel-title">Total de notificações  &nbsp;
									 <a id='export' href="<?php echo $this->config->base_url();?>index.php/notificacao/export"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a> </h3>
								<br>
							</div>
							<div class="panel-body text-center">									
								   <?php if(count($totalNotif)){	?>	
										<canvas id="doughnutChartNot" height="95"></canvas>
										<div id="js-legend" class="chart-legend"></div>
									<?php	
										}else{
											echo'Sem Dados';
										}
									?>
							</div>		
						</div>
					
					</div>
					<div class="col-sm-4">
					</div>
					
					<div class="row">
						<div class="col-sm-12"> <br>
						</div>
					</div>
					
						<div class="col-sm-12">
								<div class="panel panel-card recent-activites">
									<h3>Status da Notificação por região (CNPJ)
										&nbsp;
										<a id='export' href="<?php echo $this->config->base_url();?>index.php/notificacao/export"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i></a>
										<small></small></h3>
								</div>
						 </div>						 
						 </div>
						 <div class="row">
						 
							<div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<div class="panel-heading-minus">
											<h3 class="panel-title">Norte</h3>
										</div>								
									   <div class="panel-body text-center">									
												<?php if(count($totalNotifWBMRArr) <> 0){ ?>
													<canvas id="doughnutChartNotWMBR" height="150"></canvas>
													<div id="js-legend" class="chart-legend"></div>
												<?php }else{ ?>
													Não há dados.
												<?php } ?>
												
										</div>
								</div>
							 </div>					
						 
						 <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<div class="panel-heading-minus">
											<h3 class="panel-title">Sul</h3>
										</div>								
									   <div class="panel-body text-center">	
												<?php if(count($totalNotifBPBAArr) <> 0){ ?>
													<canvas id="doughnutChartNotBPBA" height="150"></canvas>
													<div id="js-legend" class="chart-legend"></div>
												<?php }else{ ?>
													Não há dados.
												<?php } ?>

										</div>
								</div>
							 </div>					
						 
						  <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<div class="panel-heading-minus">
											<h3 class="panel-title">Leste</h3>
										</div>			
										
									   <div class="panel-body text-center">		
												<?php if(count($totalNotifBPNEArr) <> 0){ ?>
													<canvas id="doughnutChartNotBPNE" height="150"></canvas>
													<div id="js-legend" class="chart-legend"></div>
												<?php }else{ ?>
													Não há dados.
												<?php } ?>

										</div>
								</div>
							 </div>			
						 
						  <div class="col-sm-3">
								<div class="panel panel-card recent-activites">
									<div class="panel-heading-minus">
											<h3 class="panel-title">Oeste</h3>
										</div>								
									   <div class="panel-body text-center">		
												<?php if(count($totalNotifWMSArr) <> 0){ ?>
													<canvas id="doughnutChartNotWMS" height="150"></canvas>
													<div id="js-legend" class="chart-legend"></div>
												<?php }else{ ?>
													Não há dados.
												<?php } ?>
										</div>
								</div>
							 </div>			
						 </div>
						
					
						
				   </div>
                </div> 
            </div>
        </section>
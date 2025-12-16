
            <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Dashboard <?php echo $empresa; ?><small> </small></h1>

                            </div>
                        </div>
                    </div><!-- end .page title-->
					<div class="row">

                        <div class="col-md-12">

                            <div class="panel panel-card ">

								<div class="panel-body">
									<div class="row">
										<div class="col-sm-12" style='text-align:center'>
											<h1 style='color:#00B2A9'>CNDs Estaduais Por IE - Vencimento  </h1>
										</div>
										
									</div>
									<BR>
									<div class="row">
										<div class="col-sm-12">
											<h3 class="panel-title" style='color:#002060;font-size:20px' >  Débito Fiscal&nbsp; </h3>
										</div>
										
									</div>
									<div class="row">
									<div class="col-sm-6">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>A vencer - 30 a 16 dias &nbsp;
												<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportDebFiscalTrintaDiasVencer"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
											</h3>
											<div class="panel-actions">
												
											</div>
										</div>
										<div class="panel-body text-center">
											<div>
												<?php  if(count($dadosEmitidasDebFiscalTotalTrintaDiasVencer) <> 0){ ?>
													<canvas id="barChartTrinta" ></canvas>
												<?php  }else{ ?>
													<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
												<?php }?>
											</div>

										</div>
										
										
									</div>
									
									<div class="col-sm-6">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>A vencer - 15 a 0 dias &nbsp;
												<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportDebFiscalQuinzeDiasVencer"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
											</h3>
											<div class="panel-actions">
												
											</div>
										</div>
										<div class="panel-body text-center">
											<div>
												<?php  if(count($dadosEmitidasDebFiscalTotalQuinzeDiasVencer) <> 0){ ?>
													<canvas id="barChartQuinze" ></canvas>
												<?php  }else{ ?>
													<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
												<?php }?>
												
												
											</div>

										</div>
										
										
									</div>
									</div>
									<div class="row">
									<div class="col-sm-6">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>Vencidas - 1 a 15 dias &nbsp;
												<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportDebFiscalQuinzeDiasVencida"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
											</h3>
											<div class="panel-actions">
												
											</div>
										</div>
										<div class="panel-body text-center">
											<div>
												<?php  if(count($dadosEmitidasDebFiscalTotalQuinzeDiasVencida) <> 0){ ?>
													<canvas id="barChartQuinzeV" ></canvas>
												<?php  }else{ ?>
													<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
												<?php }?>
												
												
											</div>

										</div>
										
										
									</div>
									
									<div class="col-sm-6">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>Vencidas - a partir 16 dias &nbsp;
												<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportDebFiscalDezesseisDiasVencida"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
											</h3>
											<div class="panel-actions">
												
											</div>
										</div>
										<div class="panel-body text-center">
											<div>
												<?php  if(count($dadosEmitidasDebFiscalTotalTrintaDiasVencida) <> 0){ ?>
													<canvas id="barChartDezesseisV" ></canvas>
												<?php  }else{ ?>
													<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
												<?php }?>
												
												
											</div>

										</div>
										
										
									</div>
									</div>
									<BR>
									<div class="row">
										<div class="col-sm-12">
											<hr style='background-color:#002060;height: 3px;'>
											<h3 class="panel-title" style='color:#002060;font-size:20px' > Dívida Ativa&nbsp;</h3>
										</div>
										<div class="row">
											<div class="col-sm-6">
											<!-- Start .panel -->
											<div class="panel-heading">
												<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>A vencer - 30 a 16 dias &nbsp;
													<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportDivAtivTrintaDiasVencer"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
												</h3>
												<div class="panel-actions">
													
												</div>
											</div>
											<div class="panel-body text-center">
												<div>
													<?php  if(count($dadosEmitidasDivAtivTotalTrintaDiasVencer) <> 0){ ?>
														<canvas id="barChartDivAtivTrintaV" ></canvas>
													<?php  }else{ ?>
														<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
													<?php }?>
												</div>

											</div>
											
											
											</div>
											<div class="col-sm-6">
											<!-- Start .panel -->
											<div class="panel-heading">
												<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>A vencer - 15 a 0 dias &nbsp;
													<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportDivAtivQuinzeDiasVencer"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
												</h3>
												<div class="panel-actions">
													
												</div>
											</div>
											<div class="panel-body text-center">
												<div>
													<?php  if(count($dadosEmitidasDivAtivTotalQuinzeDiasVencer) <> 0){ ?>
														<canvas id="barChartDivAtivQuinzeV" ></canvas>
													<?php  }else{ ?>
														<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
													<?php }?>
												</div>

											</div>
											
											
											</div>
											</div>
											<div class="row">
											<div class="col-sm-6">
											<!-- Start .panel -->
											<div class="panel-heading">
												<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>Vencidas - 1 a 15 dias &nbsp;
													<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportDivAtivQuinzeDiasVencida"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
												</h3>
												<div class="panel-actions">
													
												</div>
											</div>
											<div class="panel-body text-center">
												<div>
													<?php  if(count($dadosEmitidasDivAtivTotalQuinzeDiasVencida) <> 0){ ?>
														<canvas id="barChartDivAtivQuinzeVenc" ></canvas>
													<?php  }else{ ?>
														<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
													<?php }?>
												</div>

											</div>
											
											
											</div>
											
											<div class="col-sm-6">
											<!-- Start .panel -->
											<div class="panel-heading">
												<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>Vencidas - a partir 16 dias &nbsp;
													<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportDivAtivDezesseisDiasVencida"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
												</h3>
												<div class="panel-actions">
													
												</div>
											</div>
											<div class="panel-body text-center">
												<div>
													<?php  if(count($dadosEmitidasDivAtivTotalTrintaDiasVencida) <> 0){ ?>
														<canvas id="barChartDivAtivTrintaVenc" ></canvas>
													<?php  }else{ ?>
														<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
													<?php }?>
												</div>

											</div>
											
											
											</div>

										</div>
										
									</div>
									<BR>
									<div class="row">
										<div class="col-sm-12">
											<hr style='background-color:#002060;height: 3px;'>
											<h3 class="panel-title" style='color:#002060;font-size:20px' > Conjunta&nbsp; 
										</div>
										
										<div class="col-sm-6">
											<!-- Start .panel -->
											<div class="panel-heading">
												<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>A vencer - 30 a 16 dias  &nbsp;
													<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportConjTrintaDiasVencer"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
												</h3>
												<div class="panel-actions">
													
												</div>
											</div>
											<div class="panel-body text-center">
												<div>
													<?php  if(count($dadosEmitidasAmbasTotalTrintaDiasVencer) <> 0){ ?>														
														<canvas id="barChartAmbasTrintaVenc" ></canvas>
													<?php  }else{ ?>
														<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
													<?php }?>
												</div>

											</div>
											
											
										</div>
										
										<div class="col-sm-6">
											<!-- Start .panel -->
											<div class="panel-heading">
												<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>A vencer - 15 a 0 dias  &nbsp;
													<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportConjQuinzeDiasVencer"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
												</h3>
												<div class="panel-actions">
													
												</div>
											</div>
											<div class="panel-body text-center">
												<div>
													<?php  if(count($dadosEmitidasAmbasTotalQuinzeDiasVencer) <> 0){ ?>														
														<canvas id="barChartAmbasQuinzeVenc" ></canvas>
													<?php  }else{ ?>
														<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
													<?php }?>
												</div>

											</div>
											
											
										</div>
										</div>
											<div class="row">
										<div class="col-sm-6">
											<!-- Start .panel -->
											<div class="panel-heading">
												<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>Vencidas - 1 a 15 dias   &nbsp;
													<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportConjQuinzeDiasVencida"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
												</h3>
												<div class="panel-actions">
													
												</div>
											</div>
											<div class="panel-body text-center">
												<div>
													<?php  if(count($dadosEmitidasAmbasTotalQuinzeDiasVencida) <> 0){ ?>														
														<canvas id="barChartAmbasQuinzeVencida" ></canvas>
													<?php  }else{ ?>
														<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
													<?php }?>
												</div>

											</div>
											
											
										</div>
										
										<div class="col-sm-6">
											<!-- Start .panel -->
											<div class="panel-heading">
												<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>Vencidas - a partir 16 dias   &nbsp;
													<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_estadual/exportConjDezesseisDiasVencida"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
												</h3>
												<div class="panel-actions">
													
												</div>
											</div>
											<div class="panel-body text-center">
												<div>
													<?php  if(count($dadosEmitidasAmbasTotalTrintaDiasVencida) <> 0){ ?>														
														<canvas id="barChartAmbasTrintaVencida" ></canvas>
													<?php  }else{ ?>
														<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
													<?php }?>
												</div>

											</div>
											
											
										</div>
										
									</div>
									
									
								</div>
	

                            </div><!-- End .panel -->  

                        </div><!--end .col-->

                    </div><!--end .row-->

                </div> 
            </div>
        </section>		<script src="<?php echo $this->config->base_url(); ?>assets/js/chartjs/Chart.min.js"></script><script type="text/javascript">
					<?php
						$data = '';
						$data .= 'data: [';					
						$count = count($dadosEmitidasDebFiscalTotalTrintaDiasVencer);
						$i=1;
						if($count <> 0){
						foreach ($dadosEmitidasDebFiscalTotalTrintaDiasVencer as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';						
					?>		
				var barData = {
					<?php echo$labelsDebFiscalTrintaDiasVencer; ?>
					datasets: [											
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				var ctx = document.getElementById("barChartTrinta").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);				
				<?php
						}//fim if count totalTrintaDiasVencer
						
						
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasDebFiscalTotalQuinzeDiasVencer);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasDebFiscalTotalQuinzeDiasVencer as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsDebFiscalQuinzeDiasVencer; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartQuinze").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasDebFiscalTotalQuinzeDiasVencer ?> 
				
				<?php
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasDebFiscalTotalQuinzeDiasVencida);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasDebFiscalTotalQuinzeDiasVencida as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsDebFiscalQuinzeDiasVencida; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartQuinzeV").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasDebFiscalTotalQuinzeDiasVencer ?> 
				
				
				<?php
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasDebFiscalTotalTrintaDiasVencida);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasDebFiscalTotalTrintaDiasVencida as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsDebFiscalTrintaDiasVencida; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartDezesseisV").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasDebFiscalTotalTrintaDiasVencida ?> 
				
				<?php
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasDivAtivTotalTrintaDiasVencer);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasDivAtivTotalTrintaDiasVencer as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsDivAtivTrintaDiasVencer; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartDivAtivTrintaV").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasDivAtivTotalTrintaDiasVencer ?> 
				
				<?php
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasDivAtivTotalQuinzeDiasVencer);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasDivAtivTotalQuinzeDiasVencer as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsDivAtivQuinzeDiasVencer; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartDivAtivQuinzeV").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasDivAtivTotalQuinzeDiasVencer ?> 
				
				<?php
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasDivAtivTotalQuinzeDiasVencida);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasDivAtivTotalQuinzeDiasVencida as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsDivAtivQuinzeDiasVencida; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartDivAtivQuinzeVenc").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasDivAtivTotalQuinzeDiasVencer ?> 
				
				<?php
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasDivAtivTotalTrintaDiasVencida);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasDivAtivTotalTrintaDiasVencida as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsDivAtivTrintaDiasVencida; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartDivAtivTrintaVenc").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasDivAtivTotalQuinzeDiasVencer ?> 

			<?php
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasAmbasTotalTrintaDiasVencer);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasAmbasTotalTrintaDiasVencer as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsAmbasTrintaDiasVencer; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartAmbasTrintaVenc").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasAmbasTotalQuinzeDiasVencer ?> 

				<?php
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasAmbasTotalQuinzeDiasVencer);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasAmbasTotalQuinzeDiasVencer as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsAmbasQuinzeDiasVencer; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartAmbasQuinzeVenc").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasAmbasTotalQuinzeDiasVencer ?> 	


			<?php
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasAmbasTotalQuinzeDiasVencida);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasAmbasTotalQuinzeDiasVencida as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsAmbasQuinzeDiasVencida; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartAmbasQuinzeVencida").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasAmbasTotalQuinzeDiasVencida ?> 	

<?php
						$data = '';
						$data .= 'data: [';						
						$count = count($dadosEmitidasAmbasTotalTrintaDiasVencida);
						if($count <> 0){
						$i=1;						
						foreach ($dadosEmitidasAmbasTotalTrintaDiasVencida as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] ;
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}							
							$i++;
						}						
						$data .= ']';
					?>		

				var barData = {
					<?php echo$labelsAmbasTrintaDiasVencida; ?>
					datasets: [												
						{
							label: "My First dataset",
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data; ?>
						}						
					]
				};
				var barOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#002060'
				};
				
				var ctx = document.getElementById("barChartAmbasTrintaVencida").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				<?php } //fim if count dadosEmitidasAmbasTotalTrintaDiasVencida ?> 					
  </script>


 <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/metisMenu.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.nanoscroller.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-jvectormap-1.2.2.min.js"></script>
        <!-- Flot -->
        <script src="<?php echo $this->config->base_url(); ?>assets/js/flot/jquery.flot.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/flot/jquery.flot.tooltip.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/flot/jquery.flot.resize.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/flot/jquery.flot.pie.js"></script>
        
        <script src="<?php echo $this->config->base_url(); ?>assets/js/pace.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/waves.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/morris_chart/raphael-2.1.0.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/morris_chart/morris.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.sparkline.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-jvectormap-world-mill-en.js"></script>
        <!--        <script src="js/jquery.nanoscroller.min.js"></script>-->
        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/custom.js"></script>
        <!-- ChartJS-->
        
		<script src="<?php echo $this->config->base_url(); ?>assets/js/chartist/chartist.min.js" type="text/javascript"></script>
		
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <!--page js-->
        <script>
			
			//grafico - conta upload cnd
			$("#sparkline8").sparkline([<?php echo$contaUploadCNDs; ?>], {
			type: 'bar',
			barWidth: 4,
			height: '40px',
			barColor: '#01a8fe',
			negBarColor: '#c6c6c6'});
				
			<?php
			$sparkMob=0;
			foreach ($cndMobiliariaUFS as $mobUF) {
				$totalPossui = ($mobUF->total_possui);
				$total = utf8_encode($mobUF->total);
				echo'$(".sparklineMob'.$sparkMob.'").sparkline(['.$totalPossui.', '.$total.'], {
					type: "pie",
					sliceColors: ["#01a8fe", "#ddd"]
					});';
				$sparkMob++;	
			}
				

			$sparkImob=0;
			$isArrayCndImobUF =  is_array($cndImobiliariaUFS) ? '1' : '0';		
			if($isArrayCndImobUF == 0){ 
				echo'$(".sparklineImob000").sparkline([0,0], {
						type: "pie",
						sliceColors: ["#01a8fe", "#ddd"]
						});';
			}else{
				foreach ($cndImobiliariaUFS as $imobUF) {
					$totalPossui = ($imobUF->total_possui);
					$total = utf8_encode($imobUF->total);

					echo'$(".sparklineImob'.$sparkImob.'").sparkline(['.$totalPossui.', '.$total.'], {
						type: "pie",
						sliceColors: ["#01a8fe", "#ddd"]
						});';
					$sparkImob++;	
				}				

			}
			?>		
          

            
            $(function () {
               
			   <?php
						$dataCND = '';
						$dataCND .= 'data: [';						
						$countCND = count($cndEstadualEstados);
						$iCND=1;
						foreach ($cndEstadualEstados as $est) {	
							$uf = $est->estado;
							$tot = $est->total;
							if($iCND <> $countCND){
								$dataCND .= "'$tot'";
								$dataCND .= ',';
							}else{
								$dataCND .= "'$tot'";
							}
							
							$iCND++;
						}						
						$dataCND .= ']';
						
				?>

					var barDataCnd = {
					<?php echo$labelCND; ?>
					//labels: ["January", "February", "March", "April", "May", "June", "July"],
					datasets: [						
						
						{
							label: "My First dataset",
							fillColor: "rgba(102, 181, 221,1)",
							strokeColor: "rgba(102, 181, 221,1)",
							highlightFill: "rgba(102, 181, 221,1)",
							highlightStroke: "rgba(102, 181, 221,1)",
							<?php echo$dataCND; ?>
						},
						
					]
				};

				var barCNDOptions = {
					scaleBeginAtZero: true,
					scaleShowGridLines: true,
					scaleGridLineColor: "rgba(255,255,255,.05)",
					scaleGridLineWidth: 1,
					barShowStroke: true,
					barStrokeWidth: 2,
					barValueSpacing: 5,
					barDatasetSpacing: 1,
					responsive: true,
					scaleFontColor:'#949ba2'
				};


				var ctxCND = document.getElementById("barChartCND").getContext("2d");
				var myNewChartCND = new Chart(ctxCND).Bar(barDataCnd, barCNDOptions);
				
					<?php
						$data = '';
						$data .= 'data: [';
						
						$count = count($iptuEstadoAtual);
						$i=1;
						
						foreach ($iptuEstadoAtual as $est) {	
							$uf = $est['estado'];
							$tot = $est['total'] * '0.001';
							$tot = number_format($tot, 3, '.', '');
							if($i <> $count){
								$data .= "'$tot'";
								$data .= ',';
							}else{
								$data .= "'$tot'";
							}
							
							$i++;
						}
						
						$data .= ']';
						
						
						$j=1;
						$data1 = '';
						$data1 .= 'data: [';
						foreach ($iptuEstadoPassado as $ip) {
							$uf = $ip->estado;
							$tot = $ip->total * '0.001';
							$tot = number_format($tot, 3, '.', '');
							if($j <> $count){
								$data1 .= "'$tot'";
								$data1 .= ',';
							}else{
								$data1 .= "'$tot'";
							}
							
							$j++;
							
						}
						$data1 .= ']';
						
						$jj=1;
						$data11 = '';
						$data11 .= 'data: [';
						foreach ($iptuEstadoPassado as $ip) {
						
							$totalPassado = $ip->total * '0.001';
							$totalPassado = number_format($totalPassado, 3, '.', '');
							if($jj <> $count){
								$data11 .= "'$totalPassado'";
								$data11 .= ',';
							}else{
								$data11 .= "'$totalPassado'";
							}
							
							
							$jj++;
							
						}
						$data11 .= ']';
						//echo$label;
					?>		

				var barData = {
					<?php echo$label; ?>
					//labels: ["January", "February", "March", "April", "May", "June", "July"],
					datasets: [						
						
						{
							label: "My First dataset",
							fillColor: "rgba(102, 181, 221,1)",
							strokeColor: "rgba(102, 181, 221,1)",
							highlightFill: "rgba(102, 181, 221,1)",
							highlightStroke: "rgba(102, 181, 221,1)",
							
	
							<?php echo$data; ?>
						},{
							label: "My Second dataset",			
							fillColor: "rgba(1, 168, 254,1)",
							strokeColor: "rgba(1, 168, 254,1)",
							highlightFill: "rgba(1, 168, 254,1)",
							highlightStroke: "rgba(1, 168, 254,1)",
							<?php echo$data1; ?>
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
					scaleFontColor:'#949ba2'
				};


				var ctx = document.getElementById("barChart").getContext("2d");
				var myNewChart = new Chart(ctx).Bar(barData, barOptions);
				
				
				/*CND IMobiliária Por Situação*/
                var doughnutDataImob = [
				<?php
				foreach ($cndImobiliaria as $imob) {
						$tipo = utf8_encode($imob['tipo']);
						$porc = $imob['porc'];
						$total = $imob['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";						  					
					}
																	
				?>		
                ];
                var doughnutImobOptions = {
                    <?php include("include_grafico_donut.php");?>
                };			
                var ctxImob = document.getElementById("doughnutChartImob").getContext("2d");
                var myNewChartImob = new Chart(ctxImob).Doughnut(doughnutDataImob, doughnutImobOptions);
				var legendImob = myNewChartImob.generateLegend();
				$('#doughnutChartImob').append(legendImob);
				//fim CND IMobiliária Por Situação
				
				//CND Estadual Por Situação
                var doughnutDataEst = [
				<?php				
				foreach ($cndEstadual as $est) {
					$tipo = utf8_encode($est['tipo']);
					$porc = $est['porc'];
					$total = $est['total'];						
					echo "{ 
						value:$total,
						color:'#01a8fe',
						highlight:'#3d3f4b',
						label: ' $porc% $tipo '
					  },";			
				}
				?>		
                ];

                var doughnutEstOptions = {
                    <?php include("include_grafico_donut.php");?>

                };
				
                var ctxEst = document.getElementById("doughnutChartEst").getContext("2d");
                var myNewChartEst = new Chart(ctxEst).Doughnut(doughnutDataEst, doughnutEstOptions);
				var legendEst = myNewChartEst.generateLegend();
				$('#doughnutChartEst').append(legendEst);
				/* fim CND Estadual Por Situação */
				/* CND Federal Por Situação   */             
				var doughnutDataFed = [				
				{ 						
				value:100,										
				color:'#01a8fe',						
				highlight:'#3d3f4b',						
				label: 'S'					  
				},		               
				];                
				var doughnutFedOptions = {                    
				<?php include("include_grafico_donut.php");?>                
				};				               
				var ctxFed = document.getElementById("doughnutChartFed").getContext("2d");                
				var myNewChartFed = new Chart(ctxFed).Doughnut(doughnutDataFed, doughnutFedOptions);				
				var legendFed = myNewChartFed.generateLegend();				
				$('#doughnutChartFed').append(legendFed);				
				/*fim CND Estadual Por Situação								
				inicio grafico iptu valores*/
				google.charts.load('current', {'packages':['bar']});
				google.charts.setOnLoadCallback(drawChart);
						  function drawChart() {
							var data = google.visualization.arrayToDataTable([
							  ['', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$iptuTotalAtual; ?>, <?php echo$iptuTotalAnterior; ?>],
							]);

							var options = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							   height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chart = new google.charts.Bar(document.getElementById('iptuValores'));

							chart.draw(data, options);
						  }
						
						google.charts.setOnLoadCallback(drawChartWMBR);
						  function drawChartWMBR() {
							var dataWMBR = google.visualization.arrayToDataTable([
							  ['', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$iptuRegiaoWMBRAnoAtual[0]['valor']; ?>,<?php echo$iptuRegiaoWMBRAnoPass[0]['valor']; ?>],
							]);

							var optionsWMBR = {
							  colors: ['#66b5dd','#01a8fe'],
							   height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartWMBR = new google.charts.Bar(document.getElementById('WMBR'));

							chartWMBR.draw(dataWMBR, optionsWMBR);
							}
						  
						  google.charts.setOnLoadCallback(drawChartBPBA);
						  function drawChartBPBA() {
							var dataBPBA = google.visualization.arrayToDataTable([
							  ['', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$iptuRegiaoBPBAAnoAtual[0]['valor']; ?>,<?php echo$iptuRegiaoBPBAAnoPass[0]['valor']; ?>],
							]);

							var optionsBPBA = {
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartBPBA = new google.charts.Bar(document.getElementById('BPBA'));

							chartBPBA.draw(dataBPBA, optionsBPBA);
							}
							
							 google.charts.setOnLoadCallback(drawChartWMS);
						  function drawChartWMS() {
							var dataWMS = google.visualization.arrayToDataTable([
							  ['', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$iptuRegiaoWMSAnoAtual[0]['valor']; ?>,<?php echo$iptuRegiaoWMSAnoPass[0]['valor']; ?>],
							]);

							var optionsWMS = {
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartWMS = new google.charts.Bar(document.getElementById('WMS'));

							chartWMS.draw(dataWMS, optionsWMS);
							}
							
							
						  google.charts.setOnLoadCallback(drawChartBPNE);
						  function drawChartBPNE() {
							var dataBPNE = google.visualization.arrayToDataTable([
							  ['', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$iptuRegiaoBPNEAnoAtual[0]['valor']; ?>,<?php echo$iptuRegiaoBPNEAnoPass[0]['valor']; ?>],
							]);

							var optionsBPNE = {
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartBPNE = new google.charts.Bar(document.getElementById('BPNE'));

							chartBPNE.draw(dataBPNE, optionsBPNE);
							}
							
				/*CND Obras Por Situação           
				var doughnutDataObras = [				
				<?php								
				foreach ($cndObras as $est) {					
				$tipo = utf8_encode($est['tipo']);					
				$porc = $est['porc'];					
				$total = $est['total'];											
				echo "{ 						
					value:$total,						
					color:'#01a8fe',						
					highlight:'#3d3f4b',						
					label: ' $porc% $tipo '					 
					},";							
					}				
					?>				               
					];                
					var doughnutObrasOptions = {                    
						<?php include("include_grafico_donut.php");?>                
						};				                
						var ctxObras = document.getElementById("doughnutChartObras").getContext("2d");               
						var myNewChartObras = new Chart(ctxObras).Doughnut(doughnutDataObras, doughnutObrasOptions);				
						var legendObras = myNewChartObras.generateLegend();				
						//$('#doughnutChartObras').append(legendObras);				
						/*fim CND Estadual Por Situação	*/	
						 
				
				
				/*	Licencas Por Situação*/
                var doughnutDataLicTot = [
				<?php
				foreach ($licencasArr as $lic) {
						$tipo = ($lic['tipo']);
						$porc = $lic['porc'];
						$total = $lic['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";								  
					}
																	
				?>		
                ];
                var doughnutLicTotOptions = {
					 <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicTot = document.getElementById("doughnutChartLicTot").getContext("2d");
                var myNewChartLicTot = new Chart(ctxLicTot).Doughnut(doughnutDataLicTot, doughnutLicTotOptions);
				var legendLicTot = myNewChartLicTot.generateLegend();
				$('#myNewChartLicTot').append(legendLicTot);
				/*fim Licencas Por Situação*/
				
				
			
				
				/*Licencas Vencida*/
                var doughnutDataLicV = [
				<?php
				foreach ($licencasVArr as $licV) {
						$tipo = ($licV['tipo']);
						$porc = $licV['porc'];
						$total = $licV['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";						  					
					}
																	
				?>		
                ];
                var doughnutLicVOptions = {
                    <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicV = document.getElementById("doughnutChartLicV").getContext("2d");
                var myNewChartLicV = new Chart(ctxLicV).Doughnut(doughnutDataLicV, doughnutLicVOptions);
				var legendLicV = myNewChartLicV.generateLegend();
				$('#myNewChartLicV').append(legendLicV);
				/*fim Licencas Vencida*/
				
				
				/*Licencas Pendente*/
                var doughnutDataLicP = [
				<?php
				foreach ($licencasPArr as $licP) {
						$tipo = ($licP['tipo']);
						$porc = $licP['porc'];
						$total = $licP['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";					  					
					}
																	
				?>		
                ];
                var doughnutLicPOptions = {
                    <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicP = document.getElementById("doughnutChartLicP").getContext("2d");
                var myNewChartLicP = new Chart(ctxLicP).Doughnut(doughnutDataLicP, doughnutLicPOptions);
				var legendLicP = myNewChartLicP.generateLegend();
				$('#myNewChartLicP').append(legendLicP);
				/*fim Licencas Pendente*/
				
				<?php if(count($licencasWArr) <> 0){ ?>
				
				/*Licencas Vencida Regional WMBR*/
                var doughnutDataLicWMBR = [
				<?php
				foreach ($licencasWArr as $licW) {
						$tipo = ($licW['tipo']);
						$porc = $licW['porc'];
						$total = $licW['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";						  					
					}
																	
				?>		
                ];
                var doughnutLicWMBROptions = {
					<?php include("include_grafico_donut.php");?>
                };			
                var ctxLicWMBR = document.getElementById("doughnutChartLicWMBR").getContext("2d");
                var myNewChartLicWMBR = new Chart(ctxLicWMBR).Doughnut(doughnutDataLicWMBR, doughnutLicWMBROptions);
				var legendLicWMBR = myNewChartLicWMBR.generateLegend();
				$('#myNewChartLicWMBR').append(legendLicWMBR);
				/*fim Licencas WMBR*/
				<?php } ?>
				
				<?php if(count($licencasBPBAArr) <> 0){ ?>
				/*Licencas Vencida Regional BPBA*/
                var doughnutDataLicBPBA = [
				<?php
				foreach ($licencasBPBAArr as $licBPBA) {
						$tipo = ($licBPBA['tipo']);
						$porc = $licBPBA['porc'];
						$total = $licBPBA['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutLicBPBAOptions = {
                    segmentShowStroke: true,
                    segmentStrokeColor: "#fff",
                    segmentStrokeWidth: 4,
                    percentageInnerCutout: 45, // This is 0 for Pie charts
                    animationSteps: 100,
                    animationEasing: "easeOutBounce",
                    animateRotate: true,
                    animateScale: false,
                    responsive: true,
					legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
                };			
                var ctxLicBPBA = document.getElementById("doughnutChartLicBPBA").getContext("2d");
                var myNewChartLicBPBA = new Chart(ctxLicBPBA).Doughnut(doughnutDataLicBPBA, doughnutLicBPBAOptions);
				var legendLicBPBA = myNewChartLicBPBA.generateLegend();
				$('#myNewChartLicBPBA').append(legendLicBPBA);
				/*fim Licencas BPBA*/
				<?php } ?>
				
				<?php if(count($licencasBPNEArr) <> 0){ ?>
				/*Licencas Vencida Regional BPNE*/
                var doughnutDataLicBPNE = [
				<?php
				foreach ($licencasBPNEArr as $licBPNE) {
						$tipo = ($licBPNE['tipo']);
						$porc = $licBPNE['porc'];
						$total = $licBPNE['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";						  					
					}													
				?>	
				
                ];
                var doughnutLicBPNEOptions = {
                  <?php include("include_grafico_donut.php");?> 
                };			
                var ctxLicBPNE = document.getElementById("doughnutChartLicBPNE").getContext("2d");
                var myNewChartLicBPNE = new Chart(ctxLicBPNE).Doughnut(doughnutDataLicBPNE, doughnutLicBPNEOptions);
				var legendLicBPNE = myNewChartLicBPNE.generateLegend();
				$('#myNewChartLicBPNE').append(legendLicBPNE);
				/*fim Licencas BPNE*/
				<?php } ?>
			
			<?php if(count($licencasWMSArr) <> 0){ ?>
				/*Licencas Vencida Regional WMS*/
                var doughnutDataLicWMS = [
				<?php
				foreach ($licencasWMSArr as $licWMS) {
						$tipo = ($licWMS['tipo']);
						$porc = $licWMS['porc'];
						$total = $licWMS['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";						  					
					}													
				?>	
				
                ];
                var doughnutLicWMSOptions = {
                  <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicWMS = document.getElementById("doughnutChartLicWMS").getContext("2d");
                var myNewChartLicWMS = new Chart(ctxLicWMS).Doughnut(doughnutDataLicWMS, doughnutLicWMSOptions);
				var legendLicWMS = myNewChartLicWMS.generateLegend();
				$('#myNewChartLicWMS').append(legendLicWMS);
				/*fim Licencas WMS*/
				<?php } ?>
				
				<?php if(count($licencasTBArr) <> 0){ ?>
				/*Licencas Vencida Regional TB*/
                var doughnutDataLicTB = [
				<?php
				foreach ($licencasTBArr as $licTB) {
						$tipo = ($licTB['tipo']);
						$porc = $licTB['porc'];
						$total = $licTB['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";						  					
					}													
				?>	
				
                ];
                var doughnutLicTBOptions = {
                    <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicTB = document.getElementById("doughnutChartLicTB").getContext("2d");
                var myNewChartLicTB = new Chart(ctxLicTB).Doughnut(doughnutDataLicTB, doughnutLicTBOptions);
				var legendLicTB = myNewChartLicTB.generateLegend();
				$('#myNewChartLicTB').append(legendLicTB);
				/*fim Licencas TB*/
				<?php } ?>
				
				<?php if(count($licencasPWArr) <> 0){ ?>
				/*Licencas Pendente Regional WMBR*/
                var doughnutDataLicPW = [
				<?php
				foreach ($licencasPWArr as $licPw) {
						$tipo = ($licPw['tipo']);
						$porc = $licPw['porc'];
						$total = $licPw['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutLicPWOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicPW = document.getElementById("doughnutChartLicPW").getContext("2d");
                var myNewChartLicPW = new Chart(ctxLicPW).Doughnut(doughnutDataLicPW, doughnutLicPWOptions);
				var legendLicPW = myNewChartLicPW.generateLegend();
				$('#myNewChartLicPW').append(legendLicPW);
				/*fim Licencas PW*/
				
			
				
				<?php } ?>
				
				<?php if(count($licencaTrintaArr) <> 0){ ?>
				/*Licencas A VENCER 30 dias*/
                var doughnutDataLicTrinta = [
				<?php
				foreach ($licencaTrintaArr as $licTrinta) {
						$tipo = ($licTrinta['tipo']);
						$porc = $licTrinta['porc'];
						$total = $licTrinta['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutLicTrintaOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicTrinta = document.getElementById("doughnutChartLicTrinta").getContext("2d");
                var myNewChartLicTrinta = new Chart(ctxLicTrinta).Doughnut(doughnutDataLicTrinta, doughnutLicTrintaOptions);
				var legendLicTrinta = myNewChartLicTrinta.generateLegend();
				$('#myNewChartLicTrinta').append(legendLicTrinta);
				/*fim A VENCER 30 dias*/
				<?php } ?>
				
				<?php if(count($licencaSessentaArr) <> 0){ ?>
				/*Licencas A VENCER 60 dias*/
                var doughnutDataLicSessenta = [
				<?php
				foreach ($licencaSessentaArr as $licSessenta) {
						$tipo = ($licSessenta['tipo']);
						$porc = $licSessenta['porc'];
						$total = $licSessenta['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutLicSessentaOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicSessenta = document.getElementById("doughnutChartLicSessenta").getContext("2d");
                var myNewChartLicSessenta = new Chart(ctxLicSessenta).Doughnut(doughnutDataLicSessenta, doughnutLicSessentaOptions);
				var legendLicSessenta = myNewChartLicSessenta.generateLegend();
				$('#myNewChartLicSessenta').append(legendLicSessenta);
				/*fim A VENCER 60 dias*/
				
				<?php } ?>
				
				
				<?php if(count($licencaPBPBAArr) <> 0){ ?>
				/*Licencas Pendente Regional BPBA*/
                var doughnutDataLicPBPBA = [
				<?php
				foreach ($licencaPBPBAArr as $licPw) {
						$tipo = ($licPw['tipo']);
						$porc = $licPw['porc'];
						$total = $licPw['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutLicBPBAOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicPBPBA = document.getElementById("doughnutChartLicPBPBA").getContext("2d");
                var myNewChartLicPBPBA = new Chart(ctxLicPBPBA).Doughnut(doughnutDataLicPBPBA, doughnutLicBPBAOptions);
				var legendLicPBPBA = myNewChartLicPBPBA.generateLegend();
				$('#myNewChartLicPBPBA').append(legendLicPBPBA);
				/*fim Licencas PBPBA*/
				<?php } ?>
				
				<?php if(count($licencaPBPNEArr) <> 0){ ?>
				/*Licencas Pendente Regional BPNE*/
                var doughnutDataLicPBPNE = [
				<?php
				foreach ($licencaPBPNEArr as $licPw) {
						$tipo = ($licPw['tipo']);
						$porc = $licPw['porc'];
						$total = $licPw['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutLicBPNEOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicPBPNE = document.getElementById("doughnutChartLicPBPNE").getContext("2d");
                var myNewChartLicPBPNE = new Chart(ctxLicPBPNE).Doughnut(doughnutDataLicPBPNE, doughnutLicBPNEOptions);
				var legendLicPBPNE = myNewChartLicPBPNE.generateLegend();
				$('#myNewChartLicPBPNE').append(legendLicPBPNE);
				/*fim Licencas PBPNE*/
				<?php } ?>
				
				<?php if(count($licencaPWMSArr) <> 0){ ?>
				/*Licencas Pendente Regional WMS*/
                var doughnutDataLicPWMS = [
				<?php
				foreach ($licencaPWMSArr as $licPw) {
						$tipo = ($licPw['tipo']);
						$porc = $licPw['porc'];
						$total = $licPw['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutLicWMSOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicPWMS = document.getElementById("doughnutChartLicPWMS").getContext("2d");
                var myNewChartLicPWMS = new Chart(ctxLicPWMS).Doughnut(doughnutDataLicPWMS, doughnutLicWMSOptions);
				var legendLicPWMS = myNewChartLicPWMS.generateLegend();
				$('#myNewChartLicPWMS').append(legendLicPWMS);
				/*fim Licencas PWMS*/
				<?php } ?>
				
				/*grafico total infracao*/
				google.charts.setOnLoadCallback(drawChartInfraAnos);
						  function drawChartInfraAnos() {
							var dataInfraAnos = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesAnoAtual[0]['total']; ?>, <?php echo$infracoesAnoPass[0]['total']; ?>],
							]);

							var optionsInfraAnos = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraAnos = new google.charts.Bar(document.getElementById('infraAnos'));

							chartInfraAnos.draw(dataInfraAnos, optionsInfraAnos);
						  }
						  
				/*grafico total infracao*/
				
				<?php if(count($totalInfraPorc) <> 0){ ?>
				/*Grafico Infra Total Donut*/
                var doughnutDataInfra = [
				<?php
				foreach ($totalInfraPorc as $infra) {
						$tipo = ($infra['status']);
						$porc = $infra['porc'];
						$total = $infra['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutInfraOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxLicInfra = document.getElementById("doughnutChartInfra").getContext("2d");
                var myNewChartInfra = new Chart(ctxLicInfra).Doughnut(doughnutDataInfra, doughnutInfraOptions);
				var legendInfra = myNewChartInfra.generateLegend();
				$('#myNewChartInfra').append(legendInfra);
				<?php } ?>
				
				
							
								
				/*grafico infracao regional WMBR*/
				
				<?php if(count($totalInfraWBMRArr) <> 0){ ?>
				/*Grafico Infra Total Donut*/
                var doughnutDataInfraWMBR = [
				<?php
				foreach ($totalInfraWBMRArr as $infra) {
						$tipo = ($infra['status']);
						$porc = $infra['porc'];
						$total = $infra['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutInfraWMBROptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxInfraWMBR = document.getElementById("doughnutChartInfraWMBR").getContext("2d");
                var myNewChartInfraWMBR = new Chart(ctxInfraWMBR).Doughnut(doughnutDataInfraWMBR, doughnutInfraWMBROptions);
				var legendInfraWMBR = myNewChartInfraWMBR.generateLegend();
				$('#myNewChartInfraWMBR').append(legendInfraWMBR);
				<?php } ?>
				
				/*grafico infracao regional BPNE*/
				
				<?php if(count($totalInfraBPNEArr) <> 0){ ?>
				/*Grafico Infra Total Donut*/
                var doughnutDataInfraBPNE = [
				<?php
				foreach ($totalInfraBPNEArr as $infra) {
						$tipo = ($infra['status']);
						$porc = $infra['porc'];
						$total = $infra['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutInfraBPNEOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxInfraBPNE = document.getElementById("doughnutChartInfraBPNE").getContext("2d");
                var myNewChartInfraBPNE = new Chart(ctxInfraBPNE).Doughnut(doughnutDataInfraBPNE, doughnutInfraBPNEOptions);
				var legendInfraBPNE = myNewChartInfraBPNE.generateLegend();
				$('#myNewChartInfraBPNE').append(legendInfraBPNE);
				<?php } ?>
				
				
				/*grafico infracao regional BPBA*/
				
				<?php if(count($totalInfraBPBAArr) <> 0){ ?>
				/*Grafico Infra Total Donut*/
                var doughnutDataInfraBPBA = [
				<?php
				foreach ($totalInfraBPBAArr as $infra) {
						$tipo = ($infra['status']);
						$porc = $infra['porc'];
						$total = $infra['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutInfraBPBAOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxInfraBPBA = document.getElementById("doughnutChartInfraBPBA").getContext("2d");
                var myNewChartInfraBPBA = new Chart(ctxInfraBPBA).Doughnut(doughnutDataInfraBPBA, doughnutInfraBPBAOptions);
				var legendInfraBPBA = myNewChartInfraBPBA.generateLegend();
				$('#myNewChartInfraBPBA').append(legendInfraBPBA);
				<?php } ?>
				
				
				<?php if(count($totalInfraWMSArr) <> 0){ ?>
				/*Grafico Infra Total Donut*/
                var doughnutDataInfraWMS = [
				<?php
				foreach ($totalInfraWMSArr as $infra) {
						$tipo = ($infra['status']);
						$porc = $infra['porc'];
						$total = $infra['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutInfraWMSOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxInfraWMS = document.getElementById("doughnutChartInfraWMS").getContext("2d");
                var myNewChartInfraWMS = new Chart(ctxInfraWMS).Doughnut(doughnutDataInfraWMS, doughnutInfraWMSOptions);
				var legendInfraWMS = myNewChartInfraWMS.generateLegend();
				$('#myNewChartInfraWMS').append(legendInfraWMS);
				<?php } ?>
				
				
			/*grafico total infracao WMS*/
				google.charts.setOnLoadCallback(drawChartInfraWMS);
						  function drawChartInfraWMS() {
							var dataInfraWMS = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesAnoAtualWMS[0]['total']; ?>, <?php echo$infracoesAnoPassWMS[0]['total']; ?>],
							]);

							var optionsInfraWMS = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraWMS = new google.charts.Bar(document.getElementById('infraWms'));

							chartInfraWMS.draw(dataInfraWMS, optionsInfraWMS);
						  }
						  
				/*grafico total infracao WMS*/
				
					/*grafico total infracao WMBR*/
				google.charts.setOnLoadCallback(drawChartInfraWMBR);
						  function drawChartInfraWMBR() {
							var dataInfraWMBR = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesAnoAtualWMBR[0]['total']; ?>, <?php echo$infracoesAnoPassWMBR[0]['total']; ?>],
							]);

							var optionsInfraWMBR = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraWMBR = new google.charts.Bar(document.getElementById('infraWMBR'));

							chartInfraWMBR.draw(dataInfraWMBR, optionsInfraWMBR);
						  }
						  
				/*grafico total infracao WMBR*/
				
			/*grafico total infracao BPNE*/
				google.charts.setOnLoadCallback(drawChartInfraBPNE);
						  function drawChartInfraBPNE() {
							var dataInfraBPNE = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesAnoAtualBPNE[0]['total']; ?>, <?php echo$infracoesAnoPassBPNE[0]['total']; ?>],
							]);

							var optionsInfraBPNE = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraBPNE = new google.charts.Bar(document.getElementById('infraBPNE'));

							chartInfraBPNE.draw(dataInfraBPNE, optionsInfraBPNE);
						  }
						  
				/*grafico total infracao BPNE*/
				
				/*grafico total infracao BPBA*/
				google.charts.setOnLoadCallback(drawChartInfraBPBA);
						  function drawChartInfraBPBA() {
							var dataInfraBPBA = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesAnoAtualBPBA[0]['total']; ?>, <?php echo$infracoesAnoPassBPBA[0]['total']; ?>],
							]);

							var optionsInfraBPBA = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraBPBA = new google.charts.Bar(document.getElementById('infraBPBA'));

							chartInfraBPBA.draw(dataInfraBPBA, optionsInfraBPBA);
						  }
						  
				/*grafico total infracao BPBA*/
				
				/*grafico total valor pago infracao WMS*/
				google.charts.setOnLoadCallback(drawChartInfraValorPagoWMS);
						  function drawChartInfraValorPagoWMS() {
							var dataInfraValorPagoWMS = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesValorPagoAnoAtualWMS[0]['total']; ?>, <?php echo$infracoesValorPagoAnoPassWMS[0]['total']; ?>],
							]);

							var optionsInfraValorPagoWMS = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraValorPagoWMS = new google.charts.Bar(document.getElementById('infraValorPagoWMS'));

							chartInfraValorPagoWMS.draw(dataInfraValorPagoWMS, optionsInfraValorPagoWMS);
						  }
						  
				/*grafico total valor pago infracao WMS*/
				
				/*grafico total valor pago infracao WMBR*/
				google.charts.setOnLoadCallback(drawChartInfraValorPagoWMBR);
						  function drawChartInfraValorPagoWMBR() {
							var dataInfraValorPagoWMBR = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesValorPagoAnoAtualWMBR[0]['total']; ?>, <?php echo$infracoesValorPagoAnoPassWMBR[0]['total']; ?>],
							]);

							var optionsInfraValorPagoWMBR = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraValorPagoWMBR = new google.charts.Bar(document.getElementById('infraValorPagoWMBR'));

							chartInfraValorPagoWMBR.draw(dataInfraValorPagoWMBR, optionsInfraValorPagoWMBR);
						  }
						  
				/*grafico total valor pago infracao WMBR*/
				
				
				/*grafico total valor pago infracao BPNE*/
				google.charts.setOnLoadCallback(drawChartInfraValorPagoBPNE);
						  function drawChartInfraValorPagoBPNE() {
							var dataInfraValorPagoBPNE = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesValorPagoAnoAtualBPNE[0]['total']; ?>, <?php echo$infracoesValorPagoAnoPassBPNE[0]['total']; ?>],
							]);

							var optionsInfraValorPagoBPNE = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraValorPagoBPNE = new google.charts.Bar(document.getElementById('infraValorPagoBPNE'));

							chartInfraValorPagoBPNE.draw(dataInfraValorPagoBPNE, optionsInfraValorPagoBPNE);
						  }
						  
				/*grafico total valor pago infracao BPNE*/
				
				/*grafico total valor pago infracao BPBA*/
				google.charts.setOnLoadCallback(drawChartInfraValorPagoBPBA);
						  function drawChartInfraValorPagoBPBA() {
							var dataInfraValorPagoBPBA = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesValorPagoAnoAtualBPBA[0]['total']; ?>, <?php echo$infracoesValorPagoAnoPassBPBA[0]['total']; ?>],
							]);

							var optionsInfraValorPagoBPBA = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraValorPagoBPBA = new google.charts.Bar(document.getElementById('infraValorPagoBPBA'));

							chartInfraValorPagoBPBA.draw(dataInfraValorPagoBPBA, optionsInfraValorPagoBPBA);
						  }
						  
				/*grafico total valor pago infracao BPBA*/
				
				/*grafico total valor def infracao WMS*/
				google.charts.setOnLoadCallback(drawChartInfraValorDefWMS);
						  function drawChartInfraValorDefWMS() {
							var dataInfraValorDefWMS = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesValorDefAnoAtualWMS; ?>, <?php echo$infracoesValorDefAnoPassWMS; ?>],
							]);

							var optionsInfraValorDefWMS = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraValorDefWMS = new google.charts.Bar(document.getElementById('infraValorDefWMS'));

							chartInfraValorDefWMS.draw(dataInfraValorDefWMS, optionsInfraValorDefWMS);
						  }
						  
				/*grafico total valor def infracao WMS*/
				
				
				/*grafico total valor def infracao WMBR*/
				google.charts.setOnLoadCallback(drawChartInfraValorDefWMBR);
						  function drawChartInfraValorDefWMBR() {
							var dataInfraValorDefWMBR = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesValorDefAnoAtualWMBR; ?>, <?php echo$infracoesValorDefAnoPassWMBR; ?>],
							]);

							var optionsInfraValorDefWMBR = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraValorDefWMBR = new google.charts.Bar(document.getElementById('infraValorDefWMBR'));

							chartInfraValorDefWMBR.draw(dataInfraValorDefWMBR, optionsInfraValorDefWMBR);
						  }
						  
				/*grafico total valor def infracao WMBR*/
				
				
				/*grafico total valor def infracao BPNE*/
				google.charts.setOnLoadCallback(drawChartInfraValorDefBPNE);
						  function drawChartInfraValorDefBPNE() {
							var dataInfraValorDefBPNE = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesValorDefAnoAtualBPNE; ?>, <?php echo$infracoesValorDefAnoPassBPNE; ?>],
							]);

							var optionsInfraValorDefBPNE = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraValorDefBPNE = new google.charts.Bar(document.getElementById('infraValorDefBPNE'));

							chartInfraValorDefBPNE.draw(dataInfraValorDefBPNE, optionsInfraValorDefBPNE);
						  }
						  
				/*grafico total valor def infracao BPNE*/
				
				/*grafico total valor def infracao BPBA*/
				google.charts.setOnLoadCallback(drawChartInfraValorDefBPBA);
						  function drawChartInfraValorDefBPBA() {
							var dataInfraValorDefBPBA = google.visualization.arrayToDataTable([
							  [' ', <?php echo$anosIptuValores; ?>],
							  [' ', <?php echo$infracoesValorDefAnoAtualBPBA; ?>, <?php echo$infracoesValorDefAnoPassBPBA; ?>],
							]);

							var optionsInfraValorDefBPBA = {
							  chart: {
								title: '',
								subtitle: '',
							  },
							  colors: ['#66b5dd','#01a8fe'],
							  height: 70,
							  bars: 'horizontal' // Required for Material Bar Charts.
							};

							var chartInfraValorDefBPBA = new google.charts.Bar(document.getElementById('infraValorDefBPBA'));

							chartInfraValorDefBPBA.draw(dataInfraValorDefBPBA, optionsInfraValorDefBPBA);
						  }
						  
				/*grafico total valor def infracao BPBA*/
				
				
			/*grafico notificacao regional WMBR*/
				
				<?php 
				
				if(count($totalNotif) <> 0){ ?>
				/*Grafico notificacao Total Donut*/
                var doughnutDataNot = [
				<?php
				foreach ($totalNotif as $not) {
						$tipo = ($not['status']);
						$porc = $not['porc'];
						$total = $not['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutNotOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxNot = document.getElementById("doughnutChartNot").getContext("2d");
                var myNewChartNot = new Chart(ctxNot).Doughnut(doughnutDataNot, doughnutNotOptions);
				var legendNot = myNewChartNot.generateLegend();
				$('#myNewChartNot').append(legendNot);
				
			
				<?php }
				if(count($totalNotifWBMRArr) <> 0){ ?>
				/*Grafico notificacao Total Donut*/
                var doughnutDataNotWMBR = [
				<?php
				foreach ($totalNotifWBMRArr as $not) {
						$tipo = ($not['status']);
						$porc = $not['porc'];
						$total = $not['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutNotWMBROptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxNotWMBR = document.getElementById("doughnutChartNotWMBR").getContext("2d");
                var myNewChartNotWMBR = new Chart(ctxNotWMBR).Doughnut(doughnutDataNotWMBR, doughnutNotWMBROptions);
				var legendNotWMBR = myNewChartNotWMBR.generateLegend();
				$('#myNewChartNotWMBR').append(legendNotWMBR);
				
			
				<?php }
				
				if(count($totalNotifBPBAArr) <> 0){ ?>
				/*Grafico notificacao Total Donut*/
                var doughnutDataNotBPBA = [
				<?php
				foreach ($totalNotifBPBAArr as $not) {
						$tipo = ($not['status']);
						$porc = $not['porc'];
						$total = $not['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutNotBPBAOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxNotBPBA = document.getElementById("doughnutChartNotBPBA").getContext("2d");
                var myNewChartNotBPBA = new Chart(ctxNotBPBA).Doughnut(doughnutDataNotBPBA, doughnutNotBPBAOptions);
				var legendNotBPBA = myNewChartNotBPBA.generateLegend();
				$('#myNewChartNotBPBA').append(legendNotBPBA);
				
				<?php }
				
				if(count($totalNotifBPNEArr) <> 0){ ?>
				/*Grafico notificacao Total Donut*/
                var doughnutDataNotBPNE = [
				<?php
				foreach ($totalNotifBPNEArr as $not) {
						$tipo = ($not['status']);
						$porc = $not['porc'];
						$total = $not['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutNotBPNEOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxNotBPNE = document.getElementById("doughnutChartNotBPNE").getContext("2d");
                var myNewChartNotBPNE = new Chart(ctxNotBPNE).Doughnut(doughnutDataNotBPNE, doughnutNotBPNEOptions);
				var legendNotBPNE = myNewChartNotBPNE.generateLegend();
				$('#myNewChartNotBPNE').append(legendNotBPNE);
				
				<?php }
				
				if(count($totalNotifWMSArr) <> 0){ ?>
				/*Grafico notificacao Total Donut*/
                var doughnutDataNotWMS = [
				<?php
				foreach ($totalNotifWMSArr as $not) {
						$tipo = ($not['status']);
						$porc = $not['porc'];
						$total = $not['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: ' $porc% $tipo '							
						  },";							  					
					}													
				?>	
				
                ];
                var doughnutNotWMSOptions = {
                   <?php include("include_grafico_donut.php");?>
                };			
                var ctxNotWMS = document.getElementById("doughnutChartNotWMS").getContext("2d");
                var myNewChartNotWMS = new Chart(ctxNotWMS).Doughnut(doughnutDataNotWMS, doughnutNotWMSOptions);
				var legendNotWMS = myNewChartNotWMS.generateLegend();
				$('#myNewChartNotWMS').append(legendNotWMS);
				
				<?php }
				?>
				
				
            });/* fim function*/

        </script>
    </body>
</html>

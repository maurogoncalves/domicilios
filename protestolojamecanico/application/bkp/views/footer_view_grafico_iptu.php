

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
        <script src="<?php echo $this->config->base_url(); ?>assets/js/chartjs/Chart.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/pace.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/waves.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/morris_chart/raphael-2.1.0.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/morris_chart/morris.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.sparkline.min.js"></script>
        <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-jvectormap-world-mill-en.js"></script>
        <!--        <script src="js/jquery.nanoscroller.min.js"></script>-->
        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/custom.js"></script>
        <!-- ChartJS-->
        <script src="<?php echo $this->config->base_url(); ?>assets/js/chartjs/Chart.min.js"></script>
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
			foreach ($cndImobiliariaUFS as $imobUF) {
				$totalPossui = ($imobUF->total_possui);
				$total = utf8_encode($imobUF->total);

				echo'$(".sparklineImob'.$sparkImob.'").sparkline(['.$totalPossui.', '.$total.'], {
					type: "pie",
					sliceColors: ["#01a8fe", "#ddd"]
					});';
				$sparkImob++;	
			}				
			?>		
          

            //moris chart
            $(function () {
                var lineData = {
					
					<?php
						$arrayPorc = array();
						$data = '';
						$data .= 'data: [';
						
						$count = count($iptuEstadoAtual);
						$i=1;
						foreach ($iptuEstadoAtual as $est) {	
							$uf = $est->estado;
							$tot = $est->total;
							$tot = $est->total * '0.01';
							$tot = number_format($tot, 2, '.', '');
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
							$tot = $ip->total;
							$tot = $ip->total * '0.01';
							$tot = number_format($tot, 2, '.', '');
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
						
							$totalPassado = $ip->total * '0.01';
							$tot = number_format($tot, 2, '.', '');
							if($jj <> $count){
								$data11 .= "'$totalPassado'";
								$data11 .= ',';
							}else{
								$data11 .= "'$totalPassado'";
							}
							
							
							$jj++;
							
						}
						$data11 .= ']';
						echo$label;
					?>					
                    //labels: ["January", "February", "March", "April", "May", "June", "July"],
					//data: [65, 59, 80, 81, 56, 55, 40]
                    datasets: [
                        {
                            label:  <?php echo$anoAtual; ?>,
                            fillColor: "rgba(176,196,222,0.3)",
                            strokeColor: "rgba(176,196,222,0.7)",
                            pointColor: "rgba(176,196,222,0.7)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(0, 0, 0,1)",
							<?php echo$data; ?>
                            
                        },
                        {
							
                            label: <?php echo$anoPassado; ?>,
                            fillColor: "rgba(173,216,230,0.3)",
                            strokeColor: "rgba(173,216,230,0.7)",
                            pointColor: "rgba(173,216,230,0.7)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(0, 0, 0,1)",

                            <?php echo$data1; ?>
                        }
						
						
						
                    ]
                };
				
                var lineOptions = {
					
                    scaleShowGridLines: true,
                    scaleGridLineColor: "#ddd",
                    scaleGridLineWidth: 2,
                    bezierCurve: true,
                    bezierCurveTension: 0.5,
                    pointDot: true,
                    pointDotRadius: 5,
                    pointDotStrokeWidth: 1,
                    pointHitDetectionRadius: 20,
                    datasetStroke: true,
                    datasetStrokeWidth: 5,
                    datasetFill: true,
                    responsive: true,
					xLabelAngle: 60,
					
					
                };


                var ctx = document.getElementById("lineChart").getContext("2d");
                var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
				
				//CND Mobiliária Por Situação
                var doughnutDataMob = [
				<?php
				foreach ($cndMobiliaria as $mob) {
						$tipo = utf8_encode($mob['tipo']);
						$porc = $mob['porc'];
						$total = $mob['total'];						
						echo "{ 
							value:$porc,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: '$tipo'
						  },";
					}											
				?>		
                ];
                var doughnutMobOptions = {
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
                var ctxMob = document.getElementById("doughnutChartMob").getContext("2d");
                var myNewChartMob = new Chart(ctxMob).Doughnut(doughnutDataMob, doughnutMobOptions);
				var legendMob = myNewChartMob.generateLegend();
				$('#doughnutChartMob').append(legendMob);
				//fim CND Mobiliária Por Situação
				
				//CND IMobiliária Por Situação
                var doughnutDataImob = [
				<?php
				foreach ($cndImobiliaria as $imob) {
						$tipo = utf8_encode($imob['tipo']);
						$porc = $imob['porc'];
						$total = $imob['total'];						
						echo "{ 
							value:$porc,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: '$tipo'
						  },";						  					
					}
																	
				?>		
                ];
                var doughnutImobOptions = {
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
						value:$porc,
						color:'#01a8fe',
						highlight:'#3d3f4b',
						label: '$tipo'
					  },";			
				}
				?>		
                ];

                var doughnutEstOptions = {
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
				
                var ctxEst = document.getElementById("doughnutChartEst").getContext("2d");
                var myNewChartEst = new Chart(ctxEst).Doughnut(doughnutDataEst, doughnutEstOptions);
				var legendEst = myNewChartEst.generateLegend();
				$('#doughnutChartEst').append(legendEst);
				//fim CND Estadual Por Situação
				
				
            });

        </script>
    </body>
</html>

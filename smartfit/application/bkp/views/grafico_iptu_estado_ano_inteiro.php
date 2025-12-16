<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/loader.js"></script>
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> DashBoard</h3>
          	<div class="row mt">
          		<div class="col-lg-12">
                      <!-- CHART PANELS -->
                      <div class="row">
						<div class="col-md-8 col-sm-8 mb">
                      		<div class="grey-panel pn donut-chart">
                      			<div class="grey-header">
						  			<h5>Iptu por Estado/Ano</h5>
                      			</div>
								<script type="text/javascript">
							  google.charts.load('current', {'packages':['bar']});							  
							  google.charts.setOnLoadCallback(drawChart1);
							  function drawChart1() {
								var data1 = google.visualization.arrayToDataTable([
								  <?php
									$tot = count($anos);
									$i = 1;
									echo'[';
									foreach ($anos as $ano) {
										if($i == $tot){
											echo "'$ano'";
										}else{
											echo "'$ano',";
										}	
									$i++;	
									}
									echo'],';									
									echo "['".
											$iptuByAnoUm[0][0]->estado."',
											".$iptuByAnoUm[0][0]->primeiro.",
											".$iptuByAnoUm[1][0]->primeiro.",
											".$iptuByAnoUm[2][0]->primeiro.",
											".$iptuByAnoUm[3][0]->primeiro.",
											".$iptuByAnoUm[4][0]->primeiro."],
											";
									echo "['".
											$iptuByAnoUm[0][1]->estado."',
											".$iptuByAnoUm[0][1]->primeiro.",
											".$iptuByAnoUm[1][1]->primeiro.",
											".$iptuByAnoUm[2][1]->primeiro.",
											".$iptuByAnoUm[3][1]->primeiro.",
											".$iptuByAnoUm[4][1]->primeiro."],
											";	
									echo "['".
											$iptuByAnoUm[0][2]->estado."',
											".$iptuByAnoUm[0][2]->primeiro.",
											".$iptuByAnoUm[1][2]->primeiro.",
											".$iptuByAnoUm[2][2]->primeiro.",
											".$iptuByAnoUm[3][2]->primeiro.",
											".$iptuByAnoUm[4][2]->primeiro."],
											";	
									echo "['".
											$iptuByAnoUm[0][3]->estado."',
											".$iptuByAnoUm[0][3]->primeiro.",
											".$iptuByAnoUm[1][3]->primeiro.",
											".$iptuByAnoUm[2][3]->primeiro.",
											".$iptuByAnoUm[3][3]->primeiro.",
											".$iptuByAnoUm[4][3]->primeiro."],
											";	
									echo "['".
											$iptuByAnoUm[0][4]->estado."',
											".$iptuByAnoUm[0][4]->primeiro.",
											".$iptuByAnoUm[1][4]->primeiro.",
											".$iptuByAnoUm[2][4]->primeiro.",
											".$iptuByAnoUm[3][4]->primeiro.",
											".$iptuByAnoUm[4][4]->primeiro."],
											";	
									echo "['".
											$iptuByAnoUm[0][5]->estado."',
											".$iptuByAnoUm[0][5]->primeiro.",
											".$iptuByAnoUm[1][5]->primeiro.",
											".$iptuByAnoUm[2][5]->primeiro.",
											".$iptuByAnoUm[3][5]->primeiro.",
											".$iptuByAnoUm[4][5]->primeiro."],
											";	
									echo "['".
											$iptuByAnoUm[0][6]->estado."',
											".$iptuByAnoUm[0][6]->primeiro.",
											".$iptuByAnoUm[1][6]->primeiro.",
											".$iptuByAnoUm[2][6]->primeiro.",
											".$iptuByAnoUm[3][6]->primeiro.",
											".$iptuByAnoUm[4][6]->primeiro."],
											";	
									echo "['".
											$iptuByAnoUm[0][7]->estado."',
											".$iptuByAnoUm[0][7]->primeiro.",
											".$iptuByAnoUm[1][7]->primeiro.",
											".$iptuByAnoUm[2][7]->primeiro.",
											".$iptuByAnoUm[3][7]->primeiro.",
											".$iptuByAnoUm[4][7]->primeiro."],
											";	
									echo "['".
											$iptuByAnoUm[0][8]->estado."',
											".$iptuByAnoUm[0][8]->primeiro.",
											".$iptuByAnoUm[1][8]->primeiro.",
											".$iptuByAnoUm[2][8]->primeiro.",
											".$iptuByAnoUm[3][8]->primeiro.",
											".$iptuByAnoUm[4][8]->primeiro."],
											";	
									echo "['".
											$iptuByAnoUm[0][9]->estado."',
											".$iptuByAnoUm[0][9]->primeiro.",
											".$iptuByAnoUm[1][9]->primeiro.",
											".$iptuByAnoUm[2][9]->primeiro.",
											".$iptuByAnoUm[3][9]->primeiro.",
											".$iptuByAnoUm[4][9]->primeiro."],
											";												
											
									?>	
								]);
								var options1 = {
								  chart: {
									title: '',
									subtitle: '',
								  },
								  bars: 'vertical',
								  vAxis: {format: 'decimal'},
								  legend:{textStyle:{fontSize:'8'}},
								  tooltip: {textStyle:  {fontSize: '8',bold: false}}
								};
								var chart1 = new google.charts.Bar(document.getElementById('donutchart1'));
								chart1.draw(data1, options1);
							  }
							</script>								
								<div id="donutchart1"></div>		
	                      	</div>
                      	</div>
 <br>

				<div class="col-md-8 col-sm-8 mb">
                      		<div class="grey-panel pn donut-chart">
                      			<div class="grey-header">
						  			<h5>Iptu por Estado/Ano</h5>
                      			</div>
								<script type="text/javascript">
							  google.charts.setOnLoadCallback(drawChart2);
							  function drawChart2() {
								var data2 = google.visualization.arrayToDataTable([
								  <?php
								 
									$tot = count($anos);
									$j = 1;
									echo'[';
									foreach ($anos as $ano) {
										if($j == $tot){
											echo "'$ano'";
										}else{
											echo "'$ano',";
										}	
									$j++;	
									}
									echo'],';
echo "['".
$iptuByAnoDois[0][0]->estado."',
".$iptuByAnoDois[0][0]->primeiro.",
".$iptuByAnoDois[1][0]->primeiro.",
".$iptuByAnoDois[2][0]->primeiro.",
".$iptuByAnoDois[3][0]->primeiro.",
".$iptuByAnoDois[4][0]->primeiro."],
";
echo "['".
$iptuByAnoDois[0][1]->estado."',
".$iptuByAnoDois[0][1]->primeiro.",
".$iptuByAnoDois[1][1]->primeiro.",
".$iptuByAnoDois[2][1]->primeiro.",
".$iptuByAnoDois[3][1]->primeiro.",
".$iptuByAnoDois[4][1]->primeiro."],
";	
echo "['".
$iptuByAnoDois[0][2]->estado."',
".$iptuByAnoDois[0][2]->primeiro.",
".$iptuByAnoDois[1][2]->primeiro.",
".$iptuByAnoDois[2][2]->primeiro.",
".$iptuByAnoDois[3][2]->primeiro.",
".$iptuByAnoDois[4][2]->primeiro."],
";	
echo "['".
$iptuByAnoDois[0][3]->estado."',
".$iptuByAnoDois[0][3]->primeiro.",
".$iptuByAnoDois[1][3]->primeiro.",
".$iptuByAnoDois[2][3]->primeiro.",
".$iptuByAnoDois[3][3]->primeiro.",
".$iptuByAnoDois[4][3]->primeiro."],
";	
echo "['".
$iptuByAnoDois[0][4]->estado."',
".$iptuByAnoDois[0][4]->primeiro.",
".$iptuByAnoDois[1][4]->primeiro.",
".$iptuByAnoDois[2][4]->primeiro.",
".$iptuByAnoDois[3][4]->primeiro.",
".$iptuByAnoDois[4][4]->primeiro."],
";	
echo "['".
$iptuByAnoDois[0][5]->estado."',
".$iptuByAnoDois[0][5]->primeiro.",
".$iptuByAnoDois[1][5]->primeiro.",
".$iptuByAnoDois[2][5]->primeiro.",
".$iptuByAnoDois[3][5]->primeiro.",
".$iptuByAnoDois[4][5]->primeiro."],
";	
echo "['".
$iptuByAnoDois[0][6]->estado."',
".$iptuByAnoDois[0][6]->primeiro.",
".$iptuByAnoDois[1][6]->primeiro.",
".$iptuByAnoDois[2][6]->primeiro.",
".$iptuByAnoDois[3][6]->primeiro.",
".$iptuByAnoDois[4][6]->primeiro."],
";	
echo "['".
$iptuByAnoDois[0][7]->estado."',
".$iptuByAnoDois[0][7]->primeiro.",
".$iptuByAnoDois[1][7]->primeiro.",
".$iptuByAnoDois[2][7]->primeiro.",
".$iptuByAnoDois[3][7]->primeiro.",
".$iptuByAnoDois[4][7]->primeiro."],
";	
echo "['".
$iptuByAnoDois[0][8]->estado."',
".$iptuByAnoDois[0][8]->primeiro.",
".$iptuByAnoDois[1][8]->primeiro.",
".$iptuByAnoDois[2][8]->primeiro.",
".$iptuByAnoDois[3][8]->primeiro.",
".$iptuByAnoDois[4][8]->primeiro."],
";	
										
									 /*
									foreach ($iptuByAnoDois as $dois) {
										echo "['$dois->estado',$dois->primeiro,$dois->segundo,$dois->terceiro,$dois->quarto,$dois->quinto],";
									}*/
									?>	
								]);
								var options2 = {
								  chart: {
									title: '',
									subtitle: '',
								  },
								  bars: 'vertical',
								  vAxis: {format: 'decimal'},
								  legend:{textStyle:{fontSize:'8'}},
								  tooltip: {textStyle:  {fontSize: '8',bold: false}}
								};
								var chart2 = new google.charts.Bar(document.getElementById('donutchart2'));
								chart2.draw(data2, options2);
							  }
							</script>								
								<div id="donutchart2"></div>		
	                      	</div>
                      	</div>
						
                    </div><!-- /END CHART - 4TH ROW OF PANELS -->

					
          		</div>
          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
     
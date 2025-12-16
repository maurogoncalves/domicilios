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
                                            	
						<div class="col-md-4 col-sm-4 mb">
                      		<div class="grey-panel pn donut-chart">
                      			<div class="grey-header">
						  			<h5>Im&oacute;veis por Situa&ccedil;&atilde;o</h5>
                      			</div>
								
								<script type="text/javascript">
								
								 google.charts.load("current", {packages:["corechart"]});
								  google.charts.setOnLoadCallback(drawChart1);
								  function drawChart1() {
								  
									var data1 = google.visualization.arrayToDataTable([
									  ['Estado', '%'],
										<?php
										foreach ($imSituacao as $im) {
											echo "['$im->estado',$im->total],";
										}
										?>											  
									]);

									var options1 = {
									  title: '',
									  pieHole: 0.6,
									  legend:'none',
									  is3D: true,
									};

									var chart1 = new google.visualization.PieChart(document.getElementById('donutchart1'));
									chart1.draw(data1, options1);
								  }
								</script>
								
								<div id="donutchart1"></div>
		
	                      	</div>
                      	</div>

						
                    </div><!-- /END CHART - 4TH ROW OF PANELS -->
                    


					
          		</div>
          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
     
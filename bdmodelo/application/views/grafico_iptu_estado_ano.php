<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
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
			foreach ($iptuByAno as $ip) {
				echo "['$ip->estado',$ip->primeiro,$ip->segundo,$ip->terceiro,$ip->quarto,$ip->quinto],";
			}
			?>	

        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          },
		  bars: 'vertical',
          vAxis: {format: 'decimal'},
		  legend:{textStyle:{fontSize:'8'}},
		  tooltip: {textStyle:  {fontSize: '8',bold: false}}
        };

        var chart = new google.charts.Bar(document.getElementById('donutchart1'));

        chart.draw(data, options);
      }
</script>

<div style='width:440px;height:185px' id="donutchart1"></div>
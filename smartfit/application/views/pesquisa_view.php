<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>		
<script type="text/javascript">

$(document).ready(function(){
	$( "#export" ).click(function() {				
		$( "#export_dados" ).submit();		
	});		
	
	$( "#exportWord" ).click(function() {				
		$( "#export_dados_word" ).submit();		
	});	
});		

</script>     

            <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Pesquisa - Base <small> </small></h1>

                            </div>
                        </div>
                    </div><!-- end .page title-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-card ">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                   
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>																<BR><BR>
                                <div class="panel-body">									<?php									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );									echo form_open('home/pesquisa', $attributes); 									?>									<select class="form-control select2" multiple style='width:300px!important' name='loja[]' placeholder="Escolha a unidade de negócio" >										<?php foreach($lojas as $key => $loja){ ?>					 										<option value="<?php echo $loja->id ?>"><?php echo $loja->razao_social?></option>					   										<?php															}								    				  										?>				                                      </select>									 &nbsp;&nbsp;&nbsp;									 <select class="form-control select2" multiple style='width:300px!important' name='cnd[]' placeholder="Escolha o tipo de CND" >										<?php foreach($tipos as $key => $tipo){ ?>					 										<option value="<?php echo $tipo->pagina ?>"><?php echo $tipo->nome?></option>					   										<?php															}								    				  										?>				                                      </select>									 &nbsp;&nbsp;&nbsp;									 <select class="form-control select2" multiple style='width:300px!important' name='status[]' placeholder="Escolha o status" >										<option value="1">Emitida</option>					   										<option value="2">Não Emitida</option>					   										<option value="3">Pendente</option>					                                        </select>									 &nbsp;&nbsp;&nbsp;
									 
																		 <button class="btn btn-primary" type="submit">Filtrar</button>
									  &nbsp;&nbsp;&nbsp;
									 <a id='export' href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;
									</form>									 									<BR><BR>
                                     <table id="basic-datatables" class="table table-bordered" cellspacing="0" width="100%">                                        <thead>                                            <tr>                                                <th>Nome Imóvel</th>
                                                <th>Possui CND?</th>                                                <th>Data Vecto/Verificação</th>												<th>Módulo</th>                                                <th>A&ccedil;&otilde;es</th>                                            </tr>                                        </thead>                                        <tfoot>                                            <tr>												<th>Nome Imóvel</th>                                                <th>Possui CND?</th>                                                <th>Data Vecto/Verificação</th>												<th>Módulo</th>                                                <th>A&ccedil;&otilde;es</th>                                            </tr>                                        </tfoot>                                        <tbody>										<?php 								 											 foreach($iptus as $key => $iptu){ 													if($iptu['ativo'] == 0){																							$status ='Ativo';																							$cor = '#009900';									 												}else{																							$status ='Inativo';																							$cor = '#CC0000';									 												}														if($iptu['possui_cnd'] == 1){																							$possui ='Emitida';																							$dataVArr = explode("-",$iptu['data_vencto']);														$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									 												}elseif($iptu['possui_cnd'] == 2){																							$possui ='Não Emitida';																							$dataVArr = explode("-",$iptu['data_vencto']);													$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];										 												}elseif($iptu['possui_cnd'] == 3){																							$possui ='Pendente';																							$dataVArr = explode("-",$iptu['data_pendencias']);														$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];										 												}else{													$possui ='Sem Definição';													$dataV = '00-00-0000';												}
												
												if(empty($iptu['id'])){
													
												}else{
													
																							 ?>												 <tr>												 <td ><a href="#"><?php echo $iptu['nome_fantasia']; ?></a></td>													<td ><?php echo $possui; ?></td>												<td ><?php echo $dataV; ?></td>													<td ><?php echo $iptu['modulo'] ?></td>												<td >                                 													
													<a href="<?php echo $this->config->base_url();?>index.php/<?php echo$iptu['modulo'] ?>/visao_interna?id=<?php echo  $iptu['id_cnd']; ?>" class="btn btn-primary btn-xs" title='Tratativas'><i class="fa fa fa-eye"></i></a>                                      													<?php if($visitante == 0){ ?>																																<a href="<?php echo $this->config->base_url();?>index.php/<?php echo$iptu['modulo'] ?>/inativar?id=<?php echo $iptu['id_cnd']; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>									  																<a href="<?php echo $this->config->base_url();?>index.php/<?php echo$iptu['modulo'] ?>/ativar?id=<?php echo $iptu['id_cnd']; ?>" class="btn btn-primary btn-xs" title='Ativar'><i class="fa fa-check-square-o"></i></a>                                  														<?php } ?>														</td>								  																						</tr>											  <?php												}//fim if											}//fim foreach																			  ?>                                        </tbody>                                    </table>									<form  id='export_dados' action='<?php echo $this->config->base_url(); ?>index.php/home/export' method='post'>	
									<input type='hidden' id='lojasEscolhidos' name='lojasEscolhidos' value='<?php echo$lojasEscolhidos ?>'>	
									<input type='hidden' id='statusEscolhidos' name='statusEscolhidos' value='<?php echo$statusEscolhidos ?>'>	
									<input type='hidden' id='cnds' name='cnds' value='<?php echo$cnds ?>'>
									</form>
									
									<form  id='export_dados_word' action='<?php echo $this->config->base_url(); ?>index.php/home/exportWord' method='post'>	
									<input type='hidden' id='lojasEscolhidos' name='lojasEscolhidos' value='<?php echo$lojasEscolhidos ?>'>	
									<input type='hidden' id='statusEscolhidos' name='statusEscolhidos' value='<?php echo$statusEscolhidos ?>'>	
									<input type='hidden' id='cnds' name='cnds' value='<?php echo$cnds ?>'>
									</form>
									
                                </div>
                            </div><!-- End .panel -->  
                        </div><!--end .col-->
                    </div><!--end .row-->


                </div> 
            </div>
        </section>				<script src="<?php echo $this->config->base_url(); ?>assets/js/chartjs/Chart.min.js"></script><script>/*unidadesTipoCnd*/                var doughnutDataMob = [				<?php				foreach ($unidadesTipoCnd as $mob) {						$tipo = ($mob['nome']);						//$porc = $mob['porc'];						$total = $mob['total'];												echo "{ 							value:$total,							color:'#01a8fe',							highlight:'#3d3f4b',							label: '$tipo'						  },";					}															?>		                ];                var doughnutMobOptions = {                     <?php include("include_grafico_donut.php");?>                };				                var ctxMob = document.getElementById("doughnutChartMob").getContext("2d");                var myNewChartMob = new Chart(ctxMob).Doughnut(doughnutDataMob, doughnutMobOptions);				var legendMob = myNewChartMob.generateLegend();				$('#doughnutChartMob').append(legendMob);				/*unidadesTipoCnd*/
				
</script>	
<script src="<?php echo $this->config->base_url(); ?>assets/js/chartjs/Chart.min.js"></script>
<script>
/*TipoCndTrinta*/
                var doughnutDataMob = [
				<?php
				foreach ($tipoCndTrintaDias as $mob) {
						$tipo = ($mob['nome']);
						//$porc = $mob['porc'];
						$total = $mob['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: '$tipo'
						  },";
					}											
				?>		
                ];
                var doughnutMobOptions = {
                     <?php include("include_grafico_donut.php");?>
                };				
                var ctxMob = document.getElementById("doughnutChartTrinta").getContext("2d");
                var myNewChartMob = new Chart(ctxMob).Doughnut(doughnutDataMob, doughnutMobOptions);
				var legendMob = myNewChartMob.generateLegend();
				$('#doughnutChartTrinta').append(legendMob);
				/*unidadesTipoCnd*/
					</script><script src="<?php echo $this->config->base_url(); ?>assets/js/chartjs/Chart.min.js"></script>
<script>
/*TipoCndTrinta*/
                var doughnutDataMob = [
				<?php
				foreach ($tipoCndDezDias as $mob) {
						$tipo = ($mob['nome']);
						//$porc = $mob['porc'];
						$total = $mob['total'];						
						echo "{ 
							value:$total,
							color:'#01a8fe',
							highlight:'#3d3f4b',
							label: '$tipo'
						  },";
					}											
				?>		
                ];
                var doughnutMobOptions = {
                     <?php include("include_grafico_donut.php");?>
                };				
                var ctxMob = document.getElementById("doughnutChartDez").getContext("2d");
                var myNewChartMob = new Chart(ctxMob).Doughnut(doughnutDataMob, doughnutMobOptions);
				var legendMob = myNewChartMob.generateLegend();
				$('#doughnutChartDez').append(legendMob);
				/*unidadesTipoCnd*/
					

</script>
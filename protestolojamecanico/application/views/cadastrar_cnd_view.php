<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script> 
<script type="text/javascript">
jQuery(function($) {    
	$('.auto').autoNumeric('init');	});
</script>    
<script>		
	var mask = {		
		money: function() {			
		var el = this,
			exec = function(v) {			
			v = v.replace(/\D/g,"");			
			v = new String(Number(v));			
			var len = v.length;			
				if (1== len)			
					v = v.replace(/(\d)/,"0.0$1");			
				else if (2 == len)			
						v = v.replace(/(\d)/,"0.$1");			
				else if (len > 2) {			
					v = v.replace(/(\d{2})$/,'.$1');			
				}			
			return v;			
			};			
	setTimeout(function(){			
	el.value = exec(el.value);			
	},1);		
	}
}	
</script>	
<script>		
	$(document).ready(function(){				
		$('input').keypress(function (e) {        
			var code = null;        
			code = (e.keyCode ? e.keyCode : e.which);                        
			return (code == 13) ? false : true;		
		});				
		
		$('#form').submit(function(event){		  
			if (form.checkValidity()) {			
				send.attr('disabled', 'disabled');		  
			}		
		});				
			
				
		$.getJSON('<?php echo $this->config->base_url(); ?>assets/estados_cidades.json', function (data) {

				var items = [];
				var options = '<option value="">Escolha um estado</option>';	

				$.each(data, function (key, val) {
					options += '<option value="' + val.sigla + '">' + val.sigla + '</option>';
				});					
				$("#estados").html(options);
				$("#cidades").html('');
				
				$("#estados").change(function () {				
				
					var options_cidades = '';
					var str = "";					
					
					$("#estados option:selected").each(function () {
						str += $(this).text();
					});
					
					$.each(data, function (key, val) {
						if(val.sigla == str) {							
							$.each(val.cidades, function (key_city, val_city) {
								options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
							});							
						}
					});

					$("#cidades").html(options_cidades);
					
				}).change();		
			
			});
			
			
		
		
		
});   
 </script>
 
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Cadastrar Unidade de Negócio<small></small></h1>
                                <ol class="breadcrumb">
                                    <li class="active">Cadastrar Unidade de Negócio</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da Unidade</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('cnd_estadual/cadastrar_cnd', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                               
								<div class="form-group">
								<label class="col-sm-2 control-label">CNPJ/CPF da Empresa</label>
                                    <div class="col-lg-4">
										<select name="id_loja" id="cpf_cnpj" required=""  class='custom-select' style='width:320px;height:30px'>	
											<option value="">Escolha</option>										
											<?php foreach($cnpjs as $key => $cnpj){ 
											if($cnpj['matriz_filial'] == 1){
												$matrizFilial ='Matriz';
											}else{
												$matrizFilial ='Filial';
											}
											?>									 
											<option value="<?php echo $cnpj['id_loja'] ?>"><?php echo $cnpj['cpf_cnpj'].' - '.$matrizFilial?></option>	
											<?php									  
											}								  									  
											?>								
											</select>   
                                    </div>
									
									<label class="col-sm-2 control-label">Inscri&ccedil;&atilde;o Estadual</label>
                                    <div class="col-lg-4">
                                      	<input type="text" name='insc' id='insc'  class="form-control"  required=""> 
                                    </div>
									
                                </div>
								
                             
								
								<div class="form-group">
									
									<label class="col-lg-2 control-label">UF IE</label>
                                    <div class="col-lg-4">	
											<select name="uf_ie"  required=""   class='custom-select' style='width:320px;height:30px'>	
											<option value="">Escolha</option>										
											<option value="AC">Acre</option>
											<option value="AL">Alagoas</option>
											<option value="AP">Amapá</option>
											<option value="AM">Amazonas</option>
											<option value="BA">Bahia</option>
											<option value="CE">Ceará</option>
											<option value="DF">Distrito Federal</option>
											<option value="ES">Espírito Santo</option>
											<option value="GO">Goiás</option>
											<option value="MA">Maranhão</option>
											<option value="MT">Mato Grosso</option>
											<option value="MS">Mato Grosso do Sul</option>
											<option value="MG">Minas Gerais</option>
											<option value="PA">Pará</option>
											<option value="PB">Paraíba</option>
											<option value="PR">Paraná</option>
											<option value="PE">Pernambuco</option>
											<option value="PI">Piauí</option>
											<option value="RJ">Rio de Janeiro</option>
											<option value="RN">Rio Grande do Norte</option>
											<option value="RS">Rio Grande do Sul</option>
											<option value="RO">Rondônia</option>
											<option value="RR">Roraima</option>
											<option value="SC">Santa Catarina</option>
											<option value="SP">São Paulo</option>
											<option value="SE">Sergipe</option>
											<option value="TO">Tocantins</option>							
											</select>   
                                    </div>
								
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">UF ORIGEM</label>
                                    <div class="col-lg-4">
											<select name="uf_origem" id="estados" required=""   class='custom-select' style='width:320px;height:30px'>	
													<option value=""></option>				
											</select>   
									
                                    </div>
									<label class="col-lg-2 control-label">Municipio Origem</label>
                                    <div class="col-lg-4">
											<select name="municipio_ie" id="cidades" required=""  class='custom-select' style='width:320px;height:30px'>	
																
											</select>   
									
                                    </div>
                                </div>
								
								
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($visitante == 0){ ?>
											<button class="btn btn-white" type="submit">Cancelar</button>
											<button class="btn btn-primary" type="submit">Salvar</button>
										<?php } ?>
                                    </div>
                                </div>
                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div> 
            </div>

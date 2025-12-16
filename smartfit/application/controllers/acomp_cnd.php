<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acomp_Cnd extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('acomp_cnd_model','',TRUE);
   $this->load->model('log_model','',TRUE);
   $this->load->model('tipo_emitente_model','',TRUE);
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->model('emitente_model','',TRUE);
   $this->load->model('loja_model','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');   session_start();
   
  
 }
 
 function index()
 {
   if( $_SESSION['login_walmart'])
   {
	
     $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
     $this->load->view('home_view', $data);
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }
 function painel(){	
	
	$esfera=1;
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	if(empty($idContratante)){
		$idContratante= 1;
	}
	$data['areas'] = $this->acomp_cnd_model->buscarAreas(); 
	$data['subAreasUm'] = $this->acomp_cnd_model->buscarSubArea(1); 
	$data['subAreasDois'] = $this->acomp_cnd_model->buscarSubArea(2); 
	$data['subAreasTres'] = $this->acomp_cnd_model->buscarSubArea(3); 
	$data['subAreasQuatro'] = $this->acomp_cnd_model->buscarSubArea(4); 
	$data['subAreas'] = $this->acomp_cnd_model->buscarSubAreas(); 
	
	$data['estados'] = $this->acomp_cnd_model->buscaTodosEstados($idContratante,$esfera); 
	$data['cidades'] = $this->acomp_cnd_model->buscaTodasCidades($idContratante,$esfera); 
	$data['dados'] = $this->acomp_cnd_model->buscaDados($idContratante,0); 
	
	//$data['esfera'] = $esfera;
	
	$this->load->view('acomp_painel_sem_mapa',$data);
 }
 
 function buscaDadosByEsfera(){
	$base = $this->config->base_url();
	$base .='index.php';
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$esfera = $this->input->get('esfera');
	$dados = $this->acomp_cnd_model->buscaDados($idContratante,$esfera);
	
	$retorno ='';	
	$retorno .="<tr style='text-align:center;font-size:11px;border: 3px solid black;' >
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td  >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >A&Ccedil;&Atilde;O </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>	
		<td >- </td>
		<td >- </td>
		<td >- </td>		
		</tr>";
		
		foreach($dados as $key => $dado){ 
		$retorno .="<tr style='text-align:center;font-size:11px;border: 3px solid black;'>";		
		$retorno .="<td> ".$dado->estado."</td>";
		$retorno .="<td> ".$dado->cidade."</td>";
		$retorno .="<td> ".$dado->proj_desc."</td>";
		$retorno .="<td> ".$dado->cpf_cnpj."</td>";
		$retorno .="<td> ".$dado->ins_cnd_mob."</td>";
		$retorno .="<td> ".$dado->entrada_cadin."</td>";
		
			switch ($dado->id_area) {
				case 1:
					
					if($dado->id_subarea == 1){
						$retorno .="<td>".$dado->tipo_deb_desc."</td>";
						$retorno .="<td>".$dado->data_envio."</td>";
						$retorno .="<td>".$dado->sla."</td>";
						for($i=1;$i<=24;$i++){ 	
							$retorno .="<td > - </td>";
						}

					}elseif($dado->id_subarea == 2){
						$retorno .="
						<td > - </td>
						<td > - </td>
						<td > -  </td>
						<td  > ".$dado->tipo_deb_desc."</td>
						<td  > ".$dado->data_envio."</td>
						<td  > ".$dado->sla."</td>	";			
						for($i=1;$i<=21;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}else{
					
						$retorno .="<td > -  </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > ".$dado->tipo_deb_desc."</td>
						<td > ".$dado->data_envio."</td>
						<td > ".$dado->sla."</td>";
						
						for($i=1;$i<=18;$i++){ 	
							$retorno .="<td > - </td>";
						}

					}
					
				break;
				case 2:
					if($dado->id_subarea == 4){	
						for($i=1;$i<=9;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						
						for($i=1;$i<=15;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 5){
						for($i=1;$i<=12;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=12;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}else{
						for($i=1;$i<=15;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=9;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}						
				break;	
				case 3:
					if($dado->id_subarea == 7){
						for($i=1;$i<=18;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=6;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 8){
						for($i=1;$i<=21;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=3;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}
				break;
				
			}	
		$retorno .='</tr>';			
		}
			
		$retorno .='<tr>';		
		for($i=1;$i<=32;$i++){ 	
			$retorno .="<td > </td>";
		}		
		
		$retorno .='</tr>';		
	echo json_encode($retorno);
	
 }
 
 function buscaDadosByEsferaCidade(){
	$base = $this->config->base_url();
	$base .='index.php';
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$esfera = $this->input->get('esfera');
	$municipio = $this->input->get('municipio');
	$dados = $this->acomp_cnd_model->buscaDadosMunicipio($idContratante,$esfera,$municipio);
	
	$retorno ='';	
	$retorno .="<tr style='text-align:center;font-size:11px;border: 3px solid black;' >
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td  >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >A&Ccedil;&Atilde;O </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>	
		<td >- </td>
		<td >- </td>
		<td >- </td>		
		</tr>	";
		foreach($dados as $key => $dado){ 
		$retorno .="	
		<tr style='text-align:center;font-size:11px;border: 3px solid black;'>		
		<td  > ".$dado->estado."</td>
		<td  > ".$dado->cidade."</td>
		<td  > ".$dado->proj_desc."</td>
		<td  > ".$dado->cpf_cnpj."</td>
		<td  > ".$dado->ins_cnd_mob."</td>
		<td  > ".$dado->entrada_cadin."</td>";
			switch ($dado->id_area) {
				case 1:
					if($dado->id_subarea == 1){
						$retorno .="		
						<td  > ".$dado->tipo_deb_desc."</td>
						<td  > ".$dado->data_envio."</td>
						<td  > ".$dado->sla."</td>
						";
						for($i=1;$i<=24;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 2){
						$retorno .="
						<td > - </td>
						<td > - </td>
						<td > -  </td>
						<td  > ".$dado->tipo_deb_desc."</td>
						<td  > ".$dado->data_envio."</td>
						<td  > ".$dado->sla."</td>	";			
						for($i=1;$i<=21;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}else{
						$retorno .="<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > ".$dado->tipo_deb_desc."</td>
						<td > ".$dado->data_envio."</td>
						<td > ".$dado->sla."</td>";
						for($i=1;$i<=18;$i++){ 	
							$retorno .="<td > - </td>";
						}

					}
				break;
				case 2:
					if($dado->id_subarea == 4){	
						for($i=1;$i<=9;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						
						for($i=1;$i<=15;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 5){
						for($i=1;$i<=12;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=12;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}else{
						for($i=1;$i<=15;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
					}						
				break;	
				case 3:
					if($dado->id_subarea == 7){
						for($i=1;$i<=18;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=6;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 8){
						for($i=1;$i<=21;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=3;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}
				break;
			$retorno .='</tr>';		
			}	
				
		}	
		$retorno .='<tr>';		
				for($i=1;$i<=32;$i++){ 	
					$retorno .="<td > - </td>";
				}			
			$retorno .='</tr>';		
	echo json_encode($retorno);
	
 }
 
 function buscaDadosByTipoDeb(){
	$base = $this->config->base_url();
	$base .='index.php';
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$esfera = $this->input->get('esfera');
	$tipo = $this->input->get('tipo');
	$sub_area = $this->input->get('sub_area');
	$dados = $this->acomp_cnd_model->buscaDadosTipoDeb($idContratante,$tipo,$esfera,$sub_area);
	
	$retorno ='';	
	$retorno .="<tr style='text-align:center;font-size:11px;border: 3px solid black;' >
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td  >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >A&Ccedil;&Atilde;O </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>	
		<td >- </td>
		<td >- </td>
		<td >- </td>		
		</tr>	";
		foreach($dados as $key => $dado){ 
		$retorno .="	
		<tr style='text-align:center;font-size:11px;border: 3px solid black;'>		
		<td  > ".$dado->estado."</td>
		<td  > ".$dado->cidade."</td>
		<td  > ".$dado->proj_desc."</td>
		<td  > ".$dado->cpf_cnpj."</td>
		<td  > ".$dado->ins_cnd_mob."</td>
		<td  > ".$dado->entrada_cadin."</td>";
			switch ($dado->id_area) {
				case 1:
					if($dado->id_subarea == 1){
						$retorno .="		
						<td  > ".$dado->tipo_deb_desc."</td>
						<td  > ".$dado->data_envio."</td>
						<td  > ".$dado->sla."</td>
						";
						for($i=1;$i<=24;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 2){
						$retorno .="
						<td > - </td>
						<td > - </td>
						<td > -  </td>
						<td  > ".$dado->tipo_deb_desc."</td>
						<td  > ".$dado->data_envio."</td>
						<td  > ".$dado->sla."</td>	";			
						for($i=1;$i<=21;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}else{
						$retorno .="<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > ".$dado->tipo_deb_desc."</td>
						<td > ".$dado->data_envio."</td>
						<td > ".$dado->sla."</td>";
						for($i=1;$i<=18;$i++){ 	
							$retorno .="<td > - </td>";
						}

					}
				break;
				case 2:
					if($dado->id_subarea == 4){	
						for($i=1;$i<=9;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						
						for($i=1;$i<=15;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 5){
						for($i=1;$i<=12;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=12;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}else{
						for($i=1;$i<=15;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
					}						
				break;	
				case 3:
					if($dado->id_subarea == 7){
						for($i=1;$i<=18;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=6;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 8){
						for($i=1;$i<=21;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=3;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}
				break;
			$retorno .='</tr>';		
			}	
				
		}	
		$retorno .='<tr>';		
				for($i=1;$i<=32;$i++){ 	
					$retorno .="<td > - </td>";
				}			
			$retorno .='</tr>';		
	echo json_encode($retorno);
	
 }
 
 function buscaDadosByArea(){
	$base = $this->config->base_url();
	$base .='index.php';
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$esfera = $this->input->get('esfera');
	$area = $this->input->get('area');
	$dados = $this->acomp_cnd_model->buscaDadosArea($idContratante,$area,$esfera);
	
	$retorno ='';	
	$retorno .="<tr style='text-align:center;font-size:11px;border: 3px solid black;' >
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td  >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >A&Ccedil;&Atilde;O </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>	
		<td >- </td>
		<td >- </td>
		<td >- </td>		
		</tr>	";
		foreach($dados as $key => $dado){ 
		$retorno .="	
		<tr style='text-align:center;font-size:11px;border: 3px solid black;'>		
		<td  > ".$dado->estado."</td>
		<td  > ".$dado->cidade."</td>
		<td  > ".$dado->proj_desc."</td>
		<td  > ".$dado->cpf_cnpj."</td>
		<td  > ".$dado->ins_cnd_mob."</td>
		<td  > ".$dado->entrada_cadin."</td>";
			switch ($dado->id_area) {
				case 1:
					if($dado->id_subarea == 1){
						$retorno .="		
						<td  > ".$dado->tipo_deb_desc."</td>
						<td  > ".$dado->data_envio."</td>
						<td  > ".$dado->sla."</td>
						";
						for($i=1;$i<=24;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 2){
						$retorno .="
						<td > - </td>
						<td > - </td>
						<td > -  </td>
						<td  > ".$dado->tipo_deb_desc."</td>
						<td  > ".$dado->data_envio."</td>
						<td  > ".$dado->sla."</td>	";			
						for($i=1;$i<=21;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}else{
						$retorno .="<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > ".$dado->tipo_deb_desc."</td>
						<td > ".$dado->data_envio."</td>
						<td > ".$dado->sla."</td>";
						for($i=1;$i<=18;$i++){ 	
							$retorno .="<td > - </td>";
						}

					}
				break;
				case 2:
					if($dado->id_subarea == 4){	
						for($i=1;$i<=9;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						
						for($i=1;$i<=15;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 5){
						for($i=1;$i<=12;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=12;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}else{
						for($i=1;$i<=15;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
					}						
				break;	
				case 3:
					if($dado->id_subarea == 7){
						for($i=1;$i<=18;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=6;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 8){
						for($i=1;$i<=21;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=3;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}
				break;
			$retorno .='</tr>';		
			}	
				
		}	
		$retorno .='<tr>';		
				for($i=1;$i<=32;$i++){ 	
					$retorno .="<td > - </td>";
				}			
			$retorno .='</tr>';		
	echo json_encode($retorno);
	
 }
 
 function buscaDadosByEsferaEstado(){
	$base = $this->config->base_url();
	$base .='index.php';
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$esfera = $this->input->get('esfera');
	$estado = $this->input->get('estado');
	$dados = $this->acomp_cnd_model->buscaDadosEstado($idContratante,$esfera,$estado);
	
	$retorno ='';	
	$retorno .="<tr style='text-align:center;font-size:11px;border: 3px solid black;' >
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td  >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >TIPO DEBITO </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>
		<td >A&Ccedil;&Atilde;O </td>
		<td >DATA ENVIO </td>
		<td >SLA </td>	
		<td >- </td>
		<td >- </td>
		<td >- </td>		
		</tr>	";
		foreach($dados as $key => $dado){ 
		$retorno .="	
		<tr style='text-align:center;font-size:11px;border: 3px solid black;'>		
		<td  > ".$dado->estado."</td>
		<td  > ".$dado->cidade."</td>
		<td  > ".$dado->proj_desc."</td>
		<td  > ".$dado->cpf_cnpj."</td>
		<td  > ".$dado->ins_cnd_mob."</td>
		<td  > ".$dado->entrada_cadin."</td>";
			switch ($dado->id_area) {
				case 1:
					if($dado->id_subarea == 1){
						$retorno .="		
						<td  > ".$dado->tipo_deb_desc."</td>
						<td  > ".$dado->data_envio."</td>
						<td  > ".$dado->sla."</td>
						";
						for($i=1;$i<=24;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 2){
						$retorno .="
						<td > - </td>
						<td > - </td>
						<td > -  </td>
						<td  > ".$dado->tipo_deb_desc."</td>
						<td  > ".$dado->data_envio."</td>
						<td  > ".$dado->sla."</td>	";			
						for($i=1;$i<=21;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}else{
						$retorno .="<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > - </td>
						<td > ".$dado->tipo_deb_desc."</td>
						<td > ".$dado->data_envio."</td>
						<td > ".$dado->sla."</td>";
						for($i=1;$i<=18;$i++){ 	
							$retorno .="<td > - </td>";
						}

					}
				break;
				case 2:
					if($dado->id_subarea == 4){	
						for($i=1;$i<=9;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						
						for($i=1;$i<=15;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 5){
						for($i=1;$i<=12;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=12;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}else{
						for($i=1;$i<=15;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
					}						
				break;	
				case 3:
					if($dado->id_subarea == 7){
						for($i=1;$i<=18;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=6;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}elseif($dado->id_subarea == 8){
						for($i=1;$i<=21;$i++){ 	
							$retorno .="<td > - </td>";
						}
						$retorno .="
						<td>".$dado->tipo_deb_desc."</td>
						<td>".$dado->data_envio."</td>
						<td>".$dado->sla."</td>";
						for($i=1;$i<=3;$i++){ 	
							$retorno .="<td > - </td>";
						}
					}
				break;
			$retorno .='</tr>';		
			}	
				
		}	
		$retorno .='<tr>';		
				for($i=1;$i<=32;$i++){ 	
					$retorno .="<td > - </td>";
				}			
			$retorno .='</tr>';		
	echo json_encode($retorno);
	
 }
 
 
 function buscaDados(){
	$base = $this->config->base_url();
	$base .='index.php';
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$estado = strtoupper(substr($this->input->get('estado'),1,2));
	$esfera = $this->input->get('esfera');
 }
 function listar_projetos(){	
	$this->load->helper('Paginate_helper');        
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$data['perfil'] = $session_data['perfil'];
	
	/*
	
	
	$data['bandeiras'] = $this->acomp_cnd_model->listarBandeira();
	
	
	*/
	$result = $this->acomp_cnd_model->listarProjetos($idContratante,numRegister4PagePaginate(), $page,0);
	//print_r($this->db->last_query());exit;
	$total =  $this->acomp_cnd_model->somarTodosProjetos($idContratante);
	//print_r($total);exit;
	$data['paginacao'] = createPaginate('projetos_acomp_cnd', $total[0]->total) ;
	//print_r($result);exit;
	$data['emitentes'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_projetos_acomp_cnd_view', $data);
	$this->load->view('footer_pages_view');
	
 }
 function listar(){	
    
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	
	$total =  $this->acomp_cnd_model->somarTodos($idContratante);

	$data['perfil'] = $session_data['perfil'];
	$data['estados'] = $this->acomp_cnd_model->listarEstado($idContratante);
	$data['cidades'] = $this->acomp_cnd_model->listarCidade($idContratante,'X');
	$data['todas_lojas'] = $this->acomp_cnd_model->listarTodasLojas($idContratante,'X');
	
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->acomp_cnd_model->listar($idContratante,0);
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];		
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result = $this->acomp_cnd_model->listarIdCidadeEstado($idContratante,3,$municipioListar);
			}else if($estadoListar <> '0'){
				$result = $this->acomp_cnd_model->listarIdCidadeEstado($idContratante,2,$estadoListar);				
			}else{
				$result = $this->acomp_cnd_model->listar($idContratante,0);
			}
		}else{	
			$result = $this->acomp_cnd_model->listarIdCidadeEstado($idContratante,1,$idImovelListar);
		}
	   
		
	}	

	if(empty($_SESSION["cidadeLojaACBD"])){		
		$data['cidadeBD'] = 0;	
	}else{		
		$data['cidadeBD'] = $_SESSION["cidadeLojaACBD"];	
	}	
	if(empty($_SESSION["estadoLojaACBD"])){		
		$data['estadoBD'] = 0;		
	}else{		
		$data['estadoBD'] = $_SESSION["estadoLojaACBD"];	
	}	
	if(empty($_SESSION["idLojaACBD"])){		
		$data['idLojaBD'] = 0;	
	}else{		
		$data['idLojaBD'] = $_SESSION["idLojaACBD"];	
	}		
	if(empty($_SESSION["mensagemAcomp"])){
		$data['mensagemAcomp'] = '';
	}else{
		$data['mensagemAcomp'] = $_SESSION['mensagemAcomp'];
	}	
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$data['emitentes'] = $result;
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_acomp_view', $data);
	$this->load->view('footer_pages_view');
	
 }
 
  function listarLojasByIdDCidadeEstado(){	
	$this->load->helper('Paginate_helper');        
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	$result = $this->acomp_cnd_model->listarIdCidadeEstado($idContratante,$tipo,$id);
	//print_r($result);exit;
	$isArray =  is_array($result) ? '1' : '0';
	$base = $this->config->base_url();
	$base .='index.php';
	$retorno ='';
	if($isArray == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$retorno .="</tr>";
	}else{
		foreach($result as $dado){ 
			$id_acomp = $dado->id_acomp;
			$retorno .="<tr>";
			$retorno .="<td width='25%' >".$dado->nome_fantasia."</td>";
			$retorno .="<td width='20%' >".$dado->cidade."</td>";
			$retorno .="<td width='10%'>".$dado->ins_cnd_mob."</td>";
			$retorno .="<td width='30%'>".$dado->nome_area.'-'.$dado->sigla_sub_area.'-'.$dado->nome_etapa."</td>";
			$retorno .="<td width='15%'>";
			$retorno .="<a href='$base/acomp_cnd/ativar?id=$id_acomp' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/loja/acomp?id=$id_acomp' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="<a href='$base/acomp_cnd/excluir?id=$id_acomp' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";										  
			$retorno .="</td>";
			
			$retorno .="</tr>";
			
		}	
	
	}
	
	echo json_encode($retorno);
	
 }
 
 function listarCidade(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$estado = $this->input->get('estado');
	
	$esfera = $this->input->get('esfera');
	if(empty($esfera)){
		$esfera = 0;
	}
	
	$result = $this->acomp_cnd_model->listarCidadeByEstadoEsfera($idContratante,$estado,$esfera);
	
	$isArray =  is_array($result) ? '1' : '0';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{	
		$retorno .="<option value='0'>Escolha</option>";
		foreach($result as $key => $loja){ 	
			$retorno .="<option value='".$loja->cidade."'>".$loja->cidade."</option>";		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
 
 }
 
 function listarCidadeByEsfera(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$esfera = $this->input->get('esfera');
	$result = $this->acomp_cnd_model->buscaTodasCidades($idContratante,$esfera);
	
	$isArray =  is_array($result) ? '1' : '0';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{	
		$retorno .="<option value='0'>Escolha</option>";
		foreach($result as $key => $loja){ 	
			$retorno .="<option value='".$loja->cidade."'>".$loja->cidade."</option>";		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
 
 }

  function listarEstadoByEsfera(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$esfera = $this->input->get('esfera');
	$result = $this->acomp_cnd_model->buscaTodosEstados($idContratante,$esfera);
	
	$isArray =  is_array($result) ? '1' : '0';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{	
		$retorno .="<option value='0'>Escolha</option>";
		foreach($result as $key => $estado){ 	
			$retorno .="<option value='".$estado->estado."'>".$estado->estado."</option>";		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
 
 }
 function listarLojas(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$cidade = $this->input->get('cidade');
	$result = $this->acomp_cnd_model->listarTodasLojas($idContratante,$cidade);
	
	$isArray =  is_array($result) ? '1' : '0';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{	
			$retorno .="<option value='0'>Escolha</option>";
		foreach($result as $key => $loja){ 				
			$retorno .="<option value='".$loja->id."'>".$loja->nome_fantasia."</option>";		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
 
 }
 
  function listarIdCidadeEstado(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$cidade = $this->input->get('cidade');
	
	$result = $this->acomp_cnd_model->listarTodasLojas($idContratante,$cidade);
	
	$isArray =  is_array($result) ? '1' : '0';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{	
		$retorno .="<option value='0'>Escolha</option>";
		foreach($result as $key => $loja){ 			 
			$retorno .="<option value='".$loja->id."'>".$loja->nome_fantasia."</option>";		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
 
 }
 function cadastrar(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$data['todas_lojas'] = $this->loja_model->listarTodasLojas($idContratante);
	$data['areas'] = $this->acomp_cnd_model->listarAreas();
	$data['tipo_acomp'] = $this->acomp_cnd_model->listarTipoAcomp();
	//$data['subareas'] = $this->acomp_cnd_model->listarSubArea(0);
	//$data['etapas'] = $this->acomp_cnd_model->listarEtapa(0);
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_acomp_cnd_view', $data);
	$this->load->view('footer_pages_view');
 
 }
 
  function cadastrar_proj(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_proj_acomp_cnd_view', $data);
	$this->load->view('footer_pages_view');
 
 }
 
   function editar_proj(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$data['perfil'] = $session_data['perfil'];
	$id = $this->input->get('id');
	$data['dados'] = $this->acomp_cnd_model->buscarProjeto($id);
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_proj_acomp_cnd_view', $data);
	$this->load->view('footer_pages_view');
 
 }
 
  function editar(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$id = $this->input->get('id');
	$data['todas_lojas'] = $this->loja_model->listarTodasLojas($idContratante);
	$dadosAcomp = $this->acomp_cnd_model->listarIdCidadeEstado($idContratante,4,$id);			$_SESSION["cidadeLojaACBD"] = $dadosAcomp[0]->cidade;	$_SESSION["estadoLojaACBD"] = $dadosAcomp[0]->estado;	$_SESSION["idLojaACBD"] = $dadosAcomp[0]->id_loja;
	$data['dados_acomp'] = $dadosAcomp ;
	$data['areas'] = $this->acomp_cnd_model->listarAreas();
	$data['tipo_acomp'] = $this->acomp_cnd_model->listarTipoAcomp();
	$data['subareas'] = $this->acomp_cnd_model->listarSubArea($dadosAcomp[0]->id_area);
	$data['etapas'] = $this->acomp_cnd_model->listarEtapa($dadosAcomp[0]->id_area);
	$data['tipoDebito'] = $this->acomp_cnd_model->tipoDebito(0);

	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_acomp_cnd_view', $data);
	$this->load->view('footer_pages_view');
 
 }
 
 function calcularSLA(){

	$data_envio = $this->input->get('data_envio');
	
	$dtiniArr = explode('/',$data_envio);
	
	
	$data = $this->acomp_cnd_model->calcularSLA($dtiniArr[2].'-'.$dtiniArr[1].'-'.$dtiniArr[0]);
	
	echo json_encode($data[0]->dias);
	

}
 
 function editar_acomp_cnd(){
  
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	$id = $this->input->post('id');	
	$loja = $this->input->post('loja');	
	$dataEntradaCadin = $this->input->post('data_entrada_cadin');	
	$area = $this->input->post('area');	
	$subArea = $this->input->post('sub_area');	
	$etapa = $this->input->post('etapa');	
	$tipoDebito = $this->input->post('tipo_debito');	
	$dataEnvio = $this->input->post('data_envio');	
	$tipoAcomp = $this->input->post('tipo_acomp');	
	$observacoes = $this->input->post('observacoes');	
	$sla = $this->input->post('sla');
	$projeto = $this->input->post('projeto');
	
	if($subArea == 0){
		echo "<script>alert('Escolha uma SubArea'); window.history.go(-1);</script>";
		exit;
	}
	if($etapa == 0){
		echo "<script>alert('Escolha uma Etapa'); window.history.go(-1);</script>";
		exit;
	}
	$dataEntradaCadinArr = explode('/',$dataEntradaCadin);
	$dataEnvioArr = explode('/',$dataEnvio);
 
	 $dados = array('id_loja' => $loja,
			'id_area' => $area,
			'id_subarea' => $subArea,
			'id_etapa' => $etapa,
			'entrada_cadin' => $dataEntradaCadinArr[2].'-'.$dataEntradaCadinArr[1].'-'.$dataEntradaCadinArr[0],
			'tipo_acomp' => $tipoAcomp,
			'tipo_debito' => $tipoDebito,
			'data_envio' => $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0],
			'obs' => $observacoes,
			'id_projeto' => $projeto,
			'sla' => $sla
		);
		
	$dadosAtuais = $this->acomp_cnd_model->listarIdCidadeEstado($idContratante,4,$id);
	
	$dadosAlterados = '';
	
	if($dadosAtuais[0]->id_emitente <> $loja){
		$dadosAlterados .= ' - Loja: '.$dadosAtuais[0]->nome_fantasia;	
	}
	if($dadosAtuais[0]->entrada_cadin_br <> $dataEntradaCadinArr[2].'-'.$dataEntradaCadinArr[1].'-'.$dataEntradaCadinArr[0]){
		$dadosAlterados .= ' - Data Entrada Cadin: '.$dadosAtuais[0]->entrada_cadin_br;	
	}		
	if($dadosAtuais[0]->id_area <> $area){
		$dadosAlterados .= ' - Area: '.$dadosAtuais[0]->nome_area;	
	}
	if($dadosAtuais[0]->id_subarea <> $subArea){
		$dadosAlterados .= ' - SubArea: '.$dadosAtuais[0]->sigla_sub_area;	
	}
	if($dadosAtuais[0]->id_etapa <> $etapa){
		$dadosAlterados .= ' - Etapa: '.$dadosAtuais[0]->nome_etapa;	
	}	
	if($dadosAtuais[0]->tipo_debito <> $tipoDebito){
		$dadosAlterados .= ' - Tipo Débito: '.$dadosAtuais[0]->tipo_debito;	
	}	
	


	if($dadosAtuais[0]->data_envio_br <> $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0]){
		$dadosAlterados .= ' - Data Envio: '.$dadosAtuais[0]->data_envio_br;	
	}		
	if($dadosAtuais[0]->sla <> $sla){
		$dadosAlterados .= ' - SLA.: '.$dadosAtuais[0]->sla;	
	}	
	if($dadosAtuais[0]->tipo_acomp <> $tipoAcomp){
		$dadosAlterados .= ' - Comp.: '.$dadosAtuais[0]->descricao;	
	}	
	if($dadosAtuais[0]->obs <> $observacoes){
		$dadosAlterados .= ' - Obs.: '.$dadosAtuais[0]->obs;	
	}	
		
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'acomp',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => utf8_encode($dadosAlterados),
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
	
	
	if($this->acomp_cnd_model->atualizar($dados,$id)) {
		$this->session->set_flashdata('mensagem','Cadastro Atualizado Com Sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	redirect('/loja/acomp?id='.$loja, 'refresh');	
			
 }
 function export(){
 	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->post('id');	
	$tipo = $this->input->post('tipo');	
	
	$result = $this->acomp_cnd_model->listarExpIdCidadeEstado($idContratante,$tipo,$id);
	
	//print_r($result);exit;
	$isArray =  is_array($result) ? '1' : '0';
	$base = $this->config->base_url();
	$base .='index.php';
	$retorno ='';
	if($isArray == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$retorno .="</tr>";
	}else{
	
	$file="acomp_cnd.xls";

				
		$test="<table border=1>
		<tr>
		<td>Id</td>
		
		<td>Nome Fantasia</td>
		<td>Cidade</td>
		<td>Estado</td>
		<td>N&uacute;mero Inscri&ccedil;&atilde;o</td>		
		<td>CPF/CNPJ</td>
		<td>Data Entrada Cadin</td>
		<td>Area</td>
		<td>SubArea</td>
		<td>Etapa</td>
		<td>Tipo D&eacute;bito</td>
		
		<td>Data Envio</td>
		<td>Tipo Acompanhamento</td>
		<td>SLA</td>
		<td>Obs.</td>
		

		<td>Alterado Por </td>
		<td>Data Altera&ccedil;&atilde;o </td>
		<td>Dados Alterados </td>	
		</tr>
		";
		
		foreach($result as $dado){ 
			$id_acomp = $dado->id_acomp;
			$dadosLog = $this->log_model->listarLog($id_acomp,'acomp');				
			$isArrayLog =  is_array($dadosLog) ? '1' : '0';
		  
			$test .="<tr>";
			$test .="<td  >".$dado->id_acomp."</td>";
			$test .="<td  >".utf8_decode($dado->nome_fantasia)."</td>";
			$test .="<td  >".utf8_decode($dado->cidade)."</td>";
			$test .="<td  >".$dado->estado."</td>";
			$test .="<td >".$dado->ins_cnd_mob."</td>";
			$test .="<td >".$dado->cpf_cnpj."</td>";
			$test .="<td >".$dado->entrada_cadin_br	."</td>";
			$test .="<td >".utf8_decode($dado->nome_area)."</td>";
			$test .="<td >".$dado->subarea."</td>";
			$test .="<td >".utf8_decode($dado->nome_etapa)."</td>";
			$test .="<td >".utf8_decode($dado->tipo_debito)."</td>";
			$test .="<td >".$dado->data_envio_br."</td>";
			$test .="<td >".utf8_decode($dado->descricao)."</td>";
			$test .="<td >".$dado->sla."</td>";
			$test .="<td >".utf8_decode($dado->obs)."</td>";
				if($isArrayLog <> 0){
					 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
					 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
					 $test .="<td>".$dadosLog[0]->email."</td>";
					 $test .="<td>".$dataFormatada."</td>";
					 $test .="<td>"."'".utf8_decode($dadosLog[0]->texto)."'"."</td>";
				}else{
					$test .="<td></td>";
					$test .="<td></td>";
					$test .="<td></td>";
				}			
			$test .="</tr>";
			
		}	
	
	}
	$test .='</table>';
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $test;	

	
 
 }
 
  function editar_proj_acomp_cnd(){
  
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	$data['perfil'] = $session_data['perfil'];
	
	$id = $this->input->post('id');	
	$nome = $this->input->post('projeto');	
	
	$tem = $this->acomp_cnd_model->verificarNomeProjeto($nome,$idContratante);
	//print($tem[0]->total);exit;
	
	if($tem[0]->total <> 0){
		echo "<script>alert('Esse Nome já existe'); window.history.go(-1);</script>";
		exit;
	}
	$dados = array(			
		'descricao' => $nome
	);
		
	if($this->acomp_cnd_model->atualiza_proj($dados,$id)) {
		$this->session->set_flashdata('mensagem','Cadastro Atualizado Com Sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	redirect('/acomp_cnd/listar_projetos', 'refresh');	
 }
 
 function cadastrar_proj_acomp_cnd(){
  
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	$data['perfil'] = $session_data['perfil'];
	
	$nome = $this->input->post('projeto');	
	
	$tem = $this->acomp_cnd_model->verificarNomeProjeto($nome,$idContratante);
	//print($tem[0]->total);exit;
	
	if($tem[0]->total <> 0){
		echo "<script>alert('Esse Nome já existe'); window.history.go(-1);</script>";
		exit;
	}
	$dados = array(			
			'descricao' => $nome,
			'id_contratante' => $idContratante		
	);
		
	if($this->acomp_cnd_model->add_proj($dados)) {
		$this->session->set_flashdata('mensagem','Cadastro Feito Com Sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	redirect('/acomp_cnd/listar_projetos', 'refresh');	
 }
 
  function cadastrar_acomp_cnd(){
  
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$loja = $this->input->post('id');
	$dataEntradaCadin = $this->input->post('data_entrada_cadin');	
	$area = $this->input->post('area');
	$subArea = $this->input->post('sub_area');	
	$etapa = $this->input->post('etapa');	
	$tipoDebito = $this->input->post('tipo_debito');	
	$dataEnvio = $this->input->post('data_envio');	
	$tipoAcomp = $this->input->post('tipo_acomp');	
	$observacoes = $this->input->post('observacoes');	
	$sla = $this->input->post('sla');
	$projeto = $this->input->post('projeto');
	
	
	
	$dataEntradaCadinArr = explode('/',$dataEntradaCadin);
	$dataEnvioArr = explode('/',$dataEnvio);
	
	 $dados = array('id_contratante' => $idContratante,
			'id_loja' => $loja,
			'id_area' => $area,
			'id_subarea' => $subArea,
			'id_etapa' => $etapa,
			'entrada_cadin' => $dataEntradaCadinArr[2].'-'.$dataEntradaCadinArr[1].'-'.$dataEntradaCadinArr[0],
			'tipo_acomp' => $tipoAcomp,
			'tipo_debito' => $tipoDebito,
			'data_envio' => $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0],
			'obs' => $observacoes,
			'id_projeto' => $projeto,
			'sla' => $sla
		);
	
	if($area == 0){
		echo "<script>alert('Escolha uma área para cadastro'); window.history.go(-1);</script>";
		exit;
	}else{
		if($this->acomp_cnd_model->add($dados)) {
			$this->session->set_flashdata('mensagem','Cadastro Feito Com Sucesso');
		}else{	
			$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
		}
	}
	
	redirect('/loja/acomp?id='.$loja, 'refresh');	
			
 }
 
 function excluir(){
 
	$id = $this->input->get('id');
	$session_data = $_SESSION['login_walmart'];
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	
	if($podeExcluir[0]['total'] == 1){		
		$this->user->excluirFisicamente($id,'acomp_cnd');
		$_SESSION['mensagemAcomp'] =  CADASTRO_INATIVO;
	}else{
		/*
		if($this->infracao_model->excluir($id)) {
			$data['mensagem'] = 'Infração foi inativada';
		}else{	
			$data['mensagem'] = 'Algum Erro Aconteceu';
		}
		*/
	}	

	
	redirect('/acomp_cnd/listar', 'refresh');
	
 }
 
  function buscarSubArea(){
	$area = $this->input->get('area');
	$subAreas = $this->acomp_cnd_model->listarSubArea($area);
	
	$isArray =  is_array($subAreas) ? '1' : '0';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
		$retorno .="<option value=0>Escolha</option>";
		foreach($subAreas as $key => $sub){ 			 
			$retorno .="<option value='".$sub->id_subarea."'>".$sub->nome."</option>";		 
		}	
	}
	//print($retorno);
	echo json_encode($retorno);
	
 
 }
 function buscarEtapa(){
	$area = $this->input->get('area');
	$etapas = $this->acomp_cnd_model->listarEtapa($area);
	
	$isArray =  is_array($etapas) ? '1' : '0';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
		$retorno .="<option value=0>Escolha</option>";
		foreach($etapas as $key => $etapa){ 			 
			$retorno .="<option value='".$etapa->id_etapa."'>".$etapa->nome."</option>";		 
		}	
	}
	//print($retorno);
	echo json_encode($retorno);
	
 
 }
 
  function tipoDebito(){
	$area = $this->input->get('area');
	$etapas = $this->acomp_cnd_model->tipoDebito($area);
	
	$isArray =  is_array($etapas) ? '1' : '0';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
		$retorno .="<option value=0>Escolha</option>";
		foreach($etapas as $key => $etapa){ 			 
			$retorno .="<option value='".$etapa->id."'>".$etapa->descricao."</option>";		 
		}	
	}
	//print($retorno);
	echo json_encode($retorno);
	
 
 }
 
  function buscaCPFCNPJ(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->get('emitente');
	
	$retorno ='';
	$result = $this->acomp_cnd_model->buscaCPFCNPJ($id,$idContratante);
	//print_r($result);exit;
	
	if(empty($result[0]->cpf_cnpj)){
		echo json_encode(0);
	}else{
		$obj = array();
		$obj['cpf_cnpj']=$result[0]->cpf_cnpj; 
		$obj['insc']=$result[0]->ins_cnd_mob; 
		echo json_encode($obj);
	
	}	
	
 }
 
}
 
?>
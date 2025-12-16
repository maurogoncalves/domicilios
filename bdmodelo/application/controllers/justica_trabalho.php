<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Justica_trabalho extends CI_Controller {

 function __construct(){
	parent::__construct();
	$this->load->model('log_model','',TRUE);		$this->load->model('notificacao_model','',TRUE);		$this->load->model('justica_trabalho_model','',TRUE);	
	$this->load->model('cnd_mobiliaria_model','',TRUE);
    $this->load->model('emitente_imovel_model','',TRUE);
    $this->load->model('tipo_emitente_model','',TRUE);
    $this->load->model('situacao_imovel_model','',TRUE);
    $this->load->model('informacoes_inclusas_iptu_model','',TRUE);
    $this->load->model('user','',TRUE);
    $this->load->model('contratante','',TRUE);
    $this->load->model('emitente_model','',TRUE);
    $this->load->model('imovel_model','',TRUE);
    $this->load->model('iptu_model','',TRUE);
    $this->load->library('Cep');
    $this->load->library('session');   
    $this->load->library('form_validation');
    $this->load->helper('url');
	
	session_start();

 }


 


 function index(){


   if($_SESSION['login']){

     $session_data = $_SESSION['login'];

     $data['email'] = $session_data['email'];


	 $data['empresa'] = $session_data['empresa'];


	 $data['perfil'] = $session_data['perfil'];


     $this->load->view('home_view', $data);


   }else{


     //If no session, redirect to login page


     redirect('login', 'refresh');


   }


 }


 function dados_agrupados(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
	
	$cidade = '0';
	$estado = '0';
	
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	      

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login'];
	$ano = date('Y');
	
	$regionais = $this->justica_trabalho_model->regionais();	
	$regionalSim = array();
	$regionalNao = array();
	$regionalPend = array();
	$regionalTodos = array();
	$regionalNC = array();
	
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->justica_trabalho_model->contaCndRegional($idContratante,$ano,1,$reg->id);
		$regionalSim[$i]['regional'] = $reg->descricao;
		$regionalSim[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->justica_trabalho_model->contaCndRegional($idContratante,$ano,2,$reg->id);
		$regionalNao[$i]['regional'] = $reg->descricao;
		$regionalNao[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->justica_trabalho_model->contaCndRegional($idContratante,$ano,3,$reg->id);
		$regionalPend[$i]['regional'] = $reg->descricao;
		$regionalPend[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->justica_trabalho_model->contaCndRegional($idContratante,$ano,4,$reg->id);
		$regionalNC[$i]['regional'] = $reg->descricao;
		$regionalNC[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	//seleciona todos
	foreach($regionais as $reg){
		$result = $this->justica_trabalho_model->contaCndRegional($idContratante,$ano,0,$reg->id);
		$regionalTodos[$i]['regional'] = $reg->descricao;
		$regionalTodos[$i]['total'] = $result[0]->total;
		$i++;
	}

	//print_r($regionalNC);exit;
	$data['regionalSim'] = $regionalSim ;
	$data['regionalNao'] = $regionalNao;
	$data['regionalPend'] = $regionalPend;
	//$data['regionalNC'] = $regionalNC;
	$data['regionalTodos'] = $regionalTodos;
	
	$data['modulo'] = 'justica_trabalho';
	$data['nome_modulo'] = 'Justiça do trabalho';
	$data['iptus'] = $this->justica_trabalho_model->contaCnd($idContratante,$ano);

	
	$data['perfil'] = $session_data['perfil'];
	
	$_SESSION["idCNDMBD"]='0';
  	$_SESSION["cidadeCNDMBD"] = 0;
	$_SESSION["estadoCNDMBD"] = 0;
	$_SESSION["modulo"] ='';
	
	
	
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('dados_agrupados_cnd_mob_view', $data);

	$this->load->view('footer_pages_view');
	


 }


 function cadastrar(){
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }



	$session_data = $_SESSION['login'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$idContratante = $_SESSION['cliente'] ;
	
	$id_loja = $this->input->get('id');

	$data['emitente'] = $this->justica_trabalho_model->listarEmitenteById($id_loja);
	
	//$data['info_inc'] = $this->informacoes_inclusas_iptu_model->listar();
		
 	$data['perfil'] = $session_data['perfil'];


	$this->load->view('header_pages_view',$data);


    $this->load->view('cadastrar_cnd_mob_view', $data);


	$this->load->view('footer_pages_view');


 }
 function upload_obs(){			$session_data = $_SESSION['login'];		$data['controller'] = 'justica_trabalho';	$controller = 'justica_trabalho';		$id = $this->input->post('obsId');			$id_cnd_mob = $this->input->post('id_cnd_mob');				$dados =  $this->justica_trabalho_model->listarUltimaObsTratById($id);		$file = $_FILES["userfile"]["name"];					$extensao = str_replace('.','',strrchr($file, '.'));							$base = base_url();		        	$config['upload_path'] = './assets/observacoes/';			$config['allowed_types'] = '*';			$config['overwrite'] = 'true';					$config['file_name'] = 'justica_trabalho-'.$id.'.'.$extensao;					$this->load->library('upload', $config);		$this->upload->initialize($config);			$field_name = "userfile";					if (!$this->upload->do_upload($field_name)){					$error = array('error' => $this->upload->display_errors());								$_SESSION['mensagemIptu'] =  $this->upload->display_errors();	}else{						$dados = array('arquivo' => 'justica_trabalho-'.$id.'.'.$extensao);									$this->justica_trabalho_model->atualizar_tratativa_obs($dados,$id);				$data = array('upload_data' => $this->upload->data($field_name));				$_SESSION['mensagemIptu'] =  UPLOAD;		}redirect('/'.$controller.'/visao_interna?id='.$id_cnd_mob, 'refresh');		 } 
 function enviar(){		
	$session_data = $_SESSION['login'];
		$data['controller'] = 'justica_trabalho';	
	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/cnds_mob/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = 'justica_trabalho-'.$id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";				
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{			
	
		$dadosLog = array(
		'id_contratante' => $session_data['id_contratante'],
		'tabela' => 'cnd_mob',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo CND Mobiliária',
		'data' => date("Y-m-d"),
		'upload' => 1
		);

		$dados = array('arquivo_cnd' => 'justica_trabalho-'.$id.'.'.$extensao);							
		$this->justica_trabalho_model->atualizar($dados,$id);		
		$data = array('upload_data' => $this->upload->data($field_name));		
		
		echo'1';
		
		
	}

//redirect('/iptu/listar', 'refresh');		 
} 

 
 function enviarOld(){
		
		$id = $this->input->post('id');
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnds_mob/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		$config['overwrite'] = 'true';	
		$this->load->library('upload', $config);
		
		// Alternativamente você pode configurar as preferências chamando a função initialize. É útil se você auto-carregar a classe:
		$this->upload->initialize($config);
		$field_name = "userfile";
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			
			$mensagem = $this->upload->display_errors();
			$this->session->set_flashdata('mensagem',$mensagem);

		}else{
			$dados = array('arquivo_cnd' => $id.'.'.$extensao);
				
			$this->justica_trabalho_model->atualizar($dados,$id);
			$data = array('upload_data' => $this->upload->data($field_name));
			$this->session->set_flashdata('mensagem','Upload Feito com Sucesso');	
		}		
		
			
		$dadosImovel = $this->justica_trabalho_model->listarCidadeEstadoById($id);
		$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
		$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
		$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;

		$modulo = $_SESSION["CNDMob"];
	
		redirect('/justica_trabalho/'.$modulo, 'refresh');		
 }
 function enviar_extrato(){			$session_data = $_SESSION['login'];		$id = $this->input->get('id');				$tipo = $this->input->get('tipo');			$file = $_FILES["userfile"]["name"];		$extensao = str_replace('.','',strrchr($file, '.'));							$base = base_url();		        	if($tipo == 1){		$config['upload_path'] = './assets/cnd_mob_extrato_pdf/';				}else{		$config['upload_path'] = './assets/cnd_mob_extrato_xls/';			}		$config['allowed_types'] = '*';			$config['overwrite'] = 'true';					$config['file_name'] = 'justica_trabalho-'.$id.'.'.$extensao;					$this->load->library('upload', $config);		$this->upload->initialize($config);			$field_name = "userfile";					if (!$this->upload->do_upload($field_name)){					$error = array('error' => $this->upload->display_errors());								$_SESSION['mensagemIptu'] =  $this->upload->display_errors();		echo '0'; 	}else{								if($tipo == 1){			$dados = array(				'extrato_pend_pdf' => 'justica_trabalho-'.$id.'.'.$extensao			);				$dadosLog = array(					'id_contratante' => $session_data['id_contratante'],					'tabela' => 'cnd_mob',					'id_usuario' => $session_data['id'],					'id_operacao' => $id,					'tipo' => 2,					'texto' => 'Upload de Arquivo CND Mobiliária - Pendência PDF',					'data' => date("Y-m-d"),					'upload' => 1					);			$this->log_model->log($dadosLog);				}else{			$dados = array(				'extrato_pend_xls' => 'justica_trabalho-'.$id.'.'.$extensao			);					$dadosLog = array(					'id_contratante' => $session_data['id_contratante'],					'tabela' => 'cnd_mob',					'id_usuario' => $session_data['id'],					'id_operacao' => $id,					'tipo' => 2,					'texto' => 'Upload de Arquivo CND Mobiliária - Pendência XLS',					'data' => date("Y-m-d"),					'upload' => 1					);			$this->log_model->log($dadosLog);					}							$this->justica_trabalho_model->atualizar($dados,$id);				$data = array('upload_data' => $this->upload->data($field_name));				$_SESSION['mensagemIptu'] =  UPLOAD;		echo'1';					}//redirect('/iptu/listar', 'refresh');		 } 
 function enviar_pend(){		
	$session_data = $_SESSION['login'];
	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/cnd_pend/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = 'justica_trabalho-'.$id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";				
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{		
	
		$dadosLog = array(
		'id_contratante' => $session_data['id_contratante'],
		'tabela' => 'cnd_mob',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo CND Mobiliária - Pendência',
		'data' => date("Y-m-d"),
		'upload' => 1
		);
		$this->log_model->log($dadosLog);
	
		
		$dados = array(
			'arquivo_pendencias' => 'justica_trabalho-'.$id.'.'.$extensao
			);	
			
		$this->justica_trabalho_model->atualizar($dados,$id);		
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}

//redirect('/iptu/listar', 'refresh');		 
} 

 function enviar_pend_old(){
		
		$id = $this->input->post('id');
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnd_pend/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		$config['overwrite'] = 'true';	
		$this->load->library('upload', $config);

		// Alternativamente você pode configurar as preferências chamando a função initialize. É útil se você auto-carregar a classe:
		$this->upload->initialize($config);
		$field_name = "userfile";
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			$mensagem = $this->upload->display_errors();
			$this->session->set_flashdata('mensagem',$mensagem);
			
		}else{
			$data = date('Y-m-d');
			$dados = array(
			'arquivo_pendencias' => $id.'.'.$extensao
			);
			
				
			$this->justica_trabalho_model->atualizar($dados,$id);
			//print_r($this->db->last_query());exit;
			$data = array('upload_data' => $this->upload->data($field_name));
			$mensagem = 'Upload Feito com Sucesso';
			
			
			
		}
		
		$dadosImovel = $this->justica_trabalho_model->listarCidadeEstadoById($id);
		$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
		$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
		$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;

		$modulo = $_SESSION["CNDMob"];
		
		//print_r($this->db->last_query());exit;
		$_SESSION['msgCNDMob'] =  $mensagem;
		
		redirect('/cnd_mob/editar?id='.$id);
		

		
 }
 function upload_cnd(){
	
	
  $session_data = $_SESSION['login'];	
 
  if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $data['dataEmissao'] = $this->justica_trabalho_model->listarTodasDataEmissao($id,'mob');		

  $dados = $this->justica_trabalho_model->listarInscricaoById($id);
	$data['imovel'] = $dados;
	if($dados[0]->possui_cnd == 1){
		$data['modulo'] = 'listarPorTipoSim';
	}else if($dados[0]->possui_cnd == 2){
		$data['modulo'] = 'listarPorTipoNao';
	}else{
		$data['modulo'] = 'listarPorTipoPendencia';
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('upload_cnd_mob', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
  function upload_pend(){
	
	
  $session_data = $_SESSION['login'];	
 
  if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  
  $dados = $this->justica_trabalho_model->listarInscricaoById($id);
  $data['imovel'] = $dados;
	if($dados[0]->possui_cnd == 1){
		$data['modulo'] = 'listarPorTipoSim';
	}else if($dados[0]->possui_cnd == 2){
		$data['modulo'] = 'listarPorTipoNao';
	}else{
		$data['modulo'] = 'listarPorTipoPendencia';
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('upload_pendencia', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
 function ver(){
	
	
  $session_data = $_SESSION['login'];	
 
  if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $data['imovel'] = $this->justica_trabalho_model->listarInscricaoById($id);

	
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('ver-cnd-mob', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
 

 function cadastrar_cnd_mob(){
 
   if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }


	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	//$inscricao = $this->input->post('inscricao');	
	
	$id_loja = $this->input->post('id_loja');	
	if(empty($id_loja )){
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
		redirect('/loja/listar', 'refresh');
		exit;
	}
	
	$possui_cnd = $this->input->post('possui_cnd');		
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');	
	
	$data_vencto = $this->input->post('data_vencto');
	if(!empty($data_vencto )){
		$arrDataVencto = explode("/",$data_vencto);
		$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
	}else{
		$dataVencto ='0000-00-00';
	}
	if($possui_cnd == 1){

		$_SESSION["CNDMob"] = 'listarPorTipoSim';
		$dados = array(
			'id_loja' => $id_loja,
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 1,
			'ativo' => 1,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		
		$data_emissao = $this->input->post('data_emissao');
	
		if(!empty($data_emissao )){
			$arrDataEmissao = explode("/",$data_emissao);
			$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		}else{
			$dataEmissao ='0000-00-00';
		}
		
		
	}elseif($possui_cnd == 2){
		$_SESSION["CNDMob"] = 'listarPorTipoNao';
		$dados = array(
			'id_loja' => $id_loja,
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 2,
			'ativo' => 1,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
			
		);
		
	}else{
		$_SESSION["CNDMob"] = 'listarPorTipoPendencia';
		$dados = array(
			'id_loja' => $id_loja,
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 3,
			'ativo' => 1,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		
	}

	
	$id = $this->justica_trabalho_model->add($dados);
	
	if($id) {
		$this->db->cache_off();
		$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'mob',
			'data_emissao' =>$dataEmissao,
			);
			
		$this->justica_trabalho_model->addDataEmissao($dadosDataEmissao,$id,'mob');
		$_SESSION['msgCNDMob'] =  CADASTRO_FEITO;
		$this->session->set_flashdata('mensagem','Cadastro Realizado com sucesso');
		$url = 'cnd_mob/editar?id='.$id;
	}else{
		$_SESSION['msgCNDMob'] =  ERRO;	
	}


	redirect($url, 'refresh');
				


 }

  function excluir(){
	if(!$_SESSION['login']){
			redirect('login', 'refresh');
	  }

  
	$id = $this->input->get('id');

	$session_data = $_SESSION['login'];

	$idContratante = $_SESSION['cliente'] ;


	$dados = array('ativo' => 0);

	if($this->iptu_model->atualizar($dados,$id)) {
		$_SESSION['mensagemCNDMOB'] =  CADASTRO_INATIVO;	
	}else{	
		$_SESSION['mensagemCNDMOB'] =  ERRO;
	}
	redirect('/cnd_mob/listar', 'refresh');
				

 }
 

 function inativar(){
	if(!$_SESSION['login']){
			redirect('login', 'refresh');
	  } 
	$id = $this->input->get('id');
	$session_data = $_SESSION['login'];
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	$dadosImovel = $this->justica_trabalho_model->listarCidadeEstadoById($id);
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
		
	if($podeExcluir[0]['total'] == 1){		
		$this->justica_trabalho_model->excluirFisicamente($id);
		$_SESSION['mensagemImovel'] =  CADASTRO_APAGADO;		
	}else{	
		$dados = array('ativo' => 1);
		if($this->justica_trabalho_model->atualizar($dados,$id)) {
			$_SESSION['mensagemCNDMOB'] =  CADASTRO_INATIVO;	
		}else{	
			$_SESSION['mensagemCNDMOB'] =  ERRO;	
		}
		
	}
	
	$modulo = $_SESSION["CNDMob"];
	
	redirect('/justica_trabalho/'.$modulo, 'refresh');
 }
 
 function ativar(){
	if(!$_SESSION['login']){
			redirect('login', 'refresh');
	  }  
	$id = $this->input->get('id');

	$dados = array('ativo' => 0);

	if($this->justica_trabalho_model->atualizar($dados,$id)) {
		$_SESSION['mensagemCNDMOB'] =  CADASTRO_ATIVO;	
	}else{	
		$_SESSION['mensagemCNDMOB'] = ERRO;
	}
	
	$dadosImovel = $this->justica_trabalho_model->listarCidadeEstadoById($id);
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
	
	$modulo = $_SESSION["CNDMob"];
	
	redirect('/justica_trabalho/'.$modulo, 'refresh');

 }
 
 function enviar_email(){	 $session_data = $_SESSION['login'];	 $empresa = $session_data['empresa'];	 $this->load->library('email');	 $this->email->from('notificacao-smartfit@bdservicos.com.br', '+G Consult');	 	 	$id_cnd = $this->input->post('id-cnd-mob');		$dados = $this->justica_trabalho_model->listarInscricaoByLoja($id_cnd);	$nome_fantasia = $dados[0]->nome_fantasia;	$emails = $this->input->post('email');	$contaEmails = count($emails);				$i=1;	$stringEmails = '';	foreach($emails as $email){						$dados = $this->user->buscaEmailById($email);		if($i==$contaEmails){			$stringEmails .= $dados[0]->email;		}else{			$stringEmails .= $dados[0]->email.',';			}		$i++;	}		$list = array($stringEmails);	$this->email->to($list);	$this->email->subject('Nova Ocorrência - '.$empresa.' - '.$nome_fantasia);		$texto = 'Prezado, <BR> <BR> existem novas ocorrências no Sistema WebGestor. <BR> <BR>  Atenciosamente, <BR> <BR> +G Consult <BR>  (11) 2729-9165 / (11) 2729-9168';	$html = "    <html>    <body>        ".$texto."    </body>    </html>	";	$this->email->set_mailtype("html");	$this->email->set_alt_message($texto);	$this->email->message($html);	$this->email->send();				redirect('/justica_trabalho/visao_interna?id='.$id_cnd);		    }
 function atualizar_cnd(){
	if(!$_SESSION['login']){
			redirect('login', 'refresh');
	  }
	  
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;	$perfilUsuarioLocal = $session_data['local'];
	$idUsuario = $session_data['id'];
	$id = $this->input->post('id');
	$id_emitente = $this->input->post('id_emitente');
	$inscricao = $this->input->post('inscricao');
	$possui_cnd = $this->input->post('possui_cnd');
	$data_vencto = $this->input->post('data_vencto');	
	$arrDataVencto = explode("/",$data_vencto);	
	$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');			$respInt = $this->input->post('resp_int');			$respExt = $this->input->post('resp_ext');			$observacao_tratativa = $this->input->post('observacao_tratativa');		
	$modulo = $_SESSION["CNDMob"];		
	if($possui_cnd == 1){
		$dados = array(
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 1,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt
		);
		$_SESSION["CNDMob"] = 'listarPorTipoSim';
		
		$data_emissao = $this->input->post('data_emissao');	
		if(empty($data_emissao)){
			$this->session->set_flashdata('mensagem','Data de Emiss&atilde;o n&atilde;o pode ser vazia');
			redirect('/justica_trabalho/'.$modulo);	
			exit;
		}
		$arrDataEmissao = explode("/",$data_emissao);	
		$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		
		$dadosDataDb = $this->justica_trabalho_model->listarDataEmissao($id,'mob');
		
		$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'mob',
			'data_emissao' =>$dataEmissao,
			);
        $isArray =  is_array($dadosDataDb) ? '1' : '0';
		if($isArray == 1){
		
			if($dadosDataDb[0]->data_emissao <> $dataEmissao ){
				$this->justica_trabalho_model->addDataEmissao($dadosDataEmissao);
			}
			
			
		}else{
			$this->justica_trabalho_model->addDataEmissao($dadosDataEmissao);
		}
		
		
	}elseif($possui_cnd == 2){
		$dados = array(
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 2,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt
		);
		$_SESSION["CNDMob"] = 'listarPorTipoNao';
	}else{
		$dados = array(
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 3,
			'ativo' => 0,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt
		);
		$_SESSION["CNDMob"] = 'listarPorTipoPendencia';
	
	}		if(!empty($observacao_tratativa)){		$dadosObs = array(			'id_cnd_mob'=>$id,			'data'=>date("Y-m-d"),			'hora'=>date("h:i:s"),			'id_usuario'=>$session_data['id'],			'observacao'=>$observacao_tratativa,			'modulo'=>1			);				$this->justica_trabalho_model->addObs($dadosObs);		}		
	$dadosImovel = $this->justica_trabalho_model->listarCidadeEstadoById($id);
	
	
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
	
	
	
	//print_r($this->session->userdata);exit;
	$dadosAtuais = $this->justica_trabalho_model->listarCNDById($id);
	
	$dadosAlterados ='';
	$arrDataAtual = explode("-",$dadosAtuais[0]->data_vencto);	
	$dataAtual = $arrDataAtual[2].'/'.$arrDataAtual[1].'/'.$arrDataAtual[0];
	$arrDataPAtual = explode("-",$dadosAtuais[0]->data_pendencias);	
	$dataPAtual = $arrDataPAtual[2].'/'.$arrDataPAtual[1].'/'.$arrDataPAtual[0];
	
	if($dadosAtuais[0]->possui_cnd <> $possui_cnd){
		if($dadosAtuais[0]->possui_cnd == 1){
			$dadosAlterados .= ' - Possui CND: Sim';
			if($dadosAtuais[0]->data_vencto <> $dataVencto){
				$dadosAlterados .= ' - Data Vencimento: '.$dataAtual;			
			}
		}else if($dadosAtuais[0]->possui_cnd == 2){
			$dadosAlterados .= ' - Possui CND: Não';
			if($dadosAtuais[0]->data_vencto <> $dataVencto){
				$dadosAlterados .= ' - Data Vencimento: '.$dataAtual;			
			}			
		}
		else{
			$dadosAlterados .= ' - Possui CND: Pendência';		
			if($dadosAtuais[0]->data_pendencias <> $dataVencto){
				$dadosAlterados .= ' - Data Pendência: '.$dataPAtual;			
			}

		}
	}
	
	if($dadosAtuais[0]->observacoes <> $observacoes){

		$dadosAlterados .= ' - Observações: '.$dadosAtuais[0]->observacoes;	
	}
	

	if(!empty($dadosAlterados)){
		$dadosLog = array(
		'id_contratante' => $idContratante,
		'tabela' => 'cnd_mob',
		'id_usuario' => $idUsuario,
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => $dadosAlterados,
		'data' => date("Y-m-d"),
		);
		$this->log_model->log($dadosLog);
	}
	
	
	
	
		if($perfilUsuarioLocal == 1){		if($this->justica_trabalho_model->atualizar($dados,$id)){					$this->justica_trabalho_model->atualizar_loja($inscricao,$id_emitente);		}	}
		
	//print_r($this->db->last_query());exit;
	$_SESSION['msgCNDMob'] =  CADASTRO_ATUALIZADO;
	
	redirect('/justica_trabalho/visao_interna?id='.$id);

 } function listaObsTrat(){	$base = $this->config->base_url().'index.php';	$session_data = $_SESSION['login'];	$idContratante = $_SESSION['cliente'] ;	$id = $this->input->get('id');	$controller = 'justica_trabalho';	$data ='';	$dados =  $this->justica_trabalho_model->listarObsTratById($id);		$base = $this->config->base_url();		$isArrayLog =  is_array($dados) ? '1' : '0';	if($isArrayLog == 1) {		foreach($dados as $dado){						//$dataHoraArr = explode(' ',$dado->data_hora);			//$dataArr = explode('-',$dataHoraArr[0]);						if(!empty($dado->arquivo)){				$arquivo = "<a href=".$base."assets/observacoes/".$dado->arquivo." target='_blank'>  <i class='fa fa-eye' aria-hidden='true'></i></a>";								$data .= "<span>".$dado->data.' - '.$dado->hora.' - '.$dado->email.' - '.$dado->observacao.' - '.$arquivo."	</span> <BR>";			}else{				$data .= "<span>".$dado->data.' - '.$dado->hora.' - '.$dado->email.' - '.$dado->observacao."	</span> <BR>";				}					}	}else{		$data .= "0";	}				echo json_encode($data);	 }	   function listaObsTratCheck(){	 $base = $this->config->base_url().'index.php';	$session_data = $_SESSION['login'];	$idContratante = $_SESSION['cliente'] ;	$id = $this->input->get('id');	$controller = 'justica_trabalho';	$data ='';	$dados =  $this->justica_trabalho_model->listarObsTratById($id);		$isArrayLog =  is_array($dados) ? '1' : '0';	if($isArrayLog == 1) {		foreach($dados as $dado){			$data .= "<span> <input type='radio' name='obsId' value='$dado->id'>".$dado->data.' - '.$dado->hora.' - '.$dado->email.' - '.$dado->observacao."	</span> <BR>";		}	}else{		$data .= "<span></span>";	}				echo json_encode($data);	 }	   function calcularDias(){	$dtAtendi = $this->input->get('dtAtendi');	$dataEnvio = $this->input->get('dataEnvio');		$dtAtendiArr = explode("/",$dtAtendi);			$dataEncerrArr = explode("/",$dataEnvio);				$dtAtend = $dtAtendiArr[2].'-'.$dtAtendiArr[1].'-'.$dtAtendiArr[0];	$dtEnvio = $dataEncerrArr[2].'-'.$dataEncerrArr[1].'-'.$dataEncerrArr[0];		$obj = array();	if($dtEnvio > $dtAtend){		$obj['status']=1;		$obj['dias']=0;	}else{		$obj['status']=0;		$result = $this->notificacao_model->calcularDias($dtAtend,$dtEnvio);		$obj['dias']=$result[0]->dias;			}		echo json_encode($obj);		}  function calcularEscalonamento(){	$dtEnvio = $this->input->get('dtEnvio');		$dataEnvioArr = explode("/",$dtEnvio);				$dtEnvio = $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0];			$data['data1'] =  date('d/m/Y', strtotime("+5 days",strtotime($dtEnvio))); 	$data['data2'] =  date('d/m/Y', strtotime("+10 days",strtotime($dtEnvio))); 	$data['data3'] =  date('d/m/Y', strtotime("+15 days",strtotime($dtEnvio))); 	echo json_encode($data);		}
function listarTratativaById(){	$session_data = $_SESSION['login'];	$idContratante = $_SESSION['cliente'] ;	$id = $this->input->get('id');		$data = array();	$dados =  $this->justica_trabalho_model->listarTratativaById($idContratante,$id);		$data['id'] = $dados[0]->id;	$data['tipo_tratativa'] = $dados[0]->tipo_tratativa;	$data['pendencia'] = $dados[0]->pendencia;	$data['esfera'] = $dados[0]->esfera;	$data['etapa'] = $dados[0]->etapa;	$data['data_informe_pendencia'] = $dados[0]->data_informe_pendencia;	$data['id_sis_ext'] = $dados[0]->id_sis_ext;	$data['data_inclusao_sis_ext'] = $dados[0]->data_inclusao_sis_ext;	$data['prazo_solucao_sis_ext'] = $dados[0]->prazo_solucao_sis_ext;	$data['data_encerramento_sis_ext'] = $dados[0]->data_encerramento_sis_ext;	$data['status_chamado_sis_ext'] = $dados[0]->status_chamado_sis_ext;	$data['id_sla_sis_ext'] = $dados[0]->sla_sis_ext;	$data['usu_inc'] = $dados[0]->usu_inc;	$data['area_focal'] = $dados[0]->area_focal;	$data['sub_area_focal'] = $dados[0]->sub_area_focal;	$data['contato'] = $dados[0]->contato;	$data['data_envio'] = $dados[0]->data_envio;	$data['prazo_solucao'] = $dados[0]->prazo_solucao;	$data['data_retorno'] = $dados[0]->data_retorno;	$data['sla'] = $dados[0]->sla;	$data['status_demanda'] = $dados[0]->status_demanda;	$data['esc_data_prazo_um'] = $dados[0]->esc_data_prazo_um;	$data['esc_data_retorno_um'] = $dados[0]->esc_data_retorno_um;	$data['esc_status_um'] = $dados[0]->esc_status_um;	$data['esc_data_prazo_dois'] = $dados[0]->esc_data_prazo_dois;	$data['esc_data_retorno_dois'] = $dados[0]->esc_data_retorno_dois;	$data['esc_status_dois'] = $dados[0]->esc_status_dois;	$data['esc_data_prazo_tres'] = $dados[0]->esc_data_prazo_tres;	$data['esc_data_retorno_tres'] = $dados[0]->esc_data_retorno_tres;	$data['esc_status_tres'] = $dados[0]->esc_status_tres;	echo json_encode($data);	}	function visao_externa(){	  if(!$_SESSION['login']){		redirect('login', 'refresh');  }   $session_data = $_SESSION['login'];	$id = $this->input->get('id');	$idContratante = $_SESSION['cliente'] ;	if(empty($_SESSION['idTratativa'])){		$idTratativa = 0;	}else{		$idTratativa = $_SESSION['idTratativa'];	}		$data['idTratativa'] = $idTratativa;	  $data['respInterno']  = $this->justica_trabalho_model->listaResponsaveis($idContratante,1);// 1 para internos  $data['respExterno']  = $this->justica_trabalho_model->listaResponsaveis($idContratante,2);// 2 para externos    $data['obs'] = $this->justica_trabalho_model->buscaTodasObservacoes($id,1);		  $dados = $this->justica_trabalho_model->listarInscricaoByLoja($id);  $data['imovel'] = $dados;    $data['tratativas'] =  $this->justica_trabalho_model->listarTodasTratativas($idContratante,$id,1);	if($dados[0]->possui_cnd == 1){		$data['modulo'] = 'listarPorTipoSim';	}else if($dados[0]->possui_cnd == 2){		$data['modulo'] = 'listarPorTipoNao';	}else{		$data['modulo'] = 'listarPorTipoPendencia';	}		if(empty($session_data['visitante'])){		$data['visitante'] = 0;	}else{		$data['visitante'] = $session_data['visitante'];		}	$data['local'] = $session_data['local'];		$data['id_cnd'] = $id;	$data['esferas'] = $this->justica_trabalho_model->listarEsfera();	$data['etapas'] = $this->justica_trabalho_model->listarEtapa();	$data['statusInterno'] = $this->justica_trabalho_model->listarStatusInterno();	$data['statusDemanda'] = $this->justica_trabalho_model->listarStatusDemanda();	$data['perfil'] = $session_data['perfil'];		$data['nome_modulo'] = 'Justiça do trabalho';		$data['controller'] = 'justica_trabalho';	$this->load->view('header_pages_view',$data);    $this->load->view('cnd_mob_visao_externa_view', $data);	$this->load->view('footer_pages_view');	}function atualizar_cnd_mob_tratativa(){		$session_data = $_SESSION['login'];	$idContratante = $_SESSION['cliente'] ;	$idUsu = $session_data['id'];	$acao 	= $this->input->post('acao');			$data_entrada_cadin 	= $this->input->post('data_entrada_cadin');		if(empty($data_entrada_cadin)){		$dtCadin = '0000-00-00';		}else{		$dtCadinArr = explode("/",$data_entrada_cadin);			$dtCadin = $dtCadinArr[2].'-'.$dtCadinArr[1].'-'.$dtCadinArr[0];	}	$id_cnd 	= $this->input->post('id');	$tipo_tratativa 	= $this->input->post('tipo_tratativa');	if(empty($tipo_tratativa)){		$tipo_tratativa = $this->input->post('tipo_tratativa_bd');	}			$id_tratativa 	= $this->input->post('id_tratativa');	$id_pendencia 	= $this->input->post('id_pendencia');	$id_esfera 	= $this->input->post('id_esfera');	$id_etapa 	= $this->input->post('id_etapa');	$data_informe_pendencia 	= $this->input->post('data_informe_pendencia');	$id_sis_ext 	= $this->input->post('id_sis_ext');	$data_inclusao_sis_ext 	= $this->input->post('data_inclusao_sis_ext');	$prazo_solucao_sis_ext 	= $this->input->post('prazo_solucao_sis_ext');	$data_encerramento_sis_ext 	= $this->input->post('data_encerramento_sis_ext');	$status_chamado_sis_ext 	= $this->input->post('status_chamado_sis_ext');	$id_sla = $this->input->post('id_sla');	$usu_inc 	= $this->input->post('usu_inc');	$area_focal 	= $this->input->post('area_focal');	$sub_area_focal 	= $this->input->post('sub_area_focal');	$contato 	= $this->input->post('contato');	$data_envio 	= $this->input->post('data_envio');	$prazo_solucao 	= $this->input->post('prazo_solucao');	$data_retorno 	= $this->input->post('data_retorno');	$sla 	= $this->input->post('sla');	$status_demanda 	= $this->input->post('status_demanda');	$esc_data_prazo_um 	= $this->input->post('esc_data_prazo_um');	$esc_data_retorno_um 	= $this->input->post('esc_data_retorno_um');	$esc_status_um 	= $this->input->post('esc_status_um');	$esc_data_prazo_dois 	= $this->input->post('esc_data_prazo_dois');	$esc_data_retorno_dois 	= $this->input->post('esc_data_retorno_dois');	$esc_status_dois 	= $this->input->post('esc_status_dois');	$esc_data_prazo_tres 	= $this->input->post('esc_data_prazo_tres');	$esc_data_retorno_tres 	= $this->input->post('esc_data_retorno_tres');	$esc_status_tres 	= $this->input->post('esc_status_tres');	$nova_tratativa 	= $this->input->post('nova_tratativa');		if(empty($data_informe_pendencia)){		$dtInforme = '0000-00-00';		}else{		$dataInformeArr = explode("/",$data_informe_pendencia);			$dtInforme = $dataInformeArr[2].'-'.$dataInformeArr[1].'-'.$dataInformeArr[0];	}		if(empty($data_inclusao_sis_ext)){		$dtInclusaoSisExt = '0000-00-00';		}else{		$dataInformeArr = explode("/",$data_inclusao_sis_ext);			$dtInclusaoSisExt = $dataInformeArr[2].'-'.$dataInformeArr[1].'-'.$dataInformeArr[0];	}		if(empty($prazo_solucao_sis_ext)){		$dtSolSisExt = '0000-00-00';		}else{		$dataSolArr = explode("/",$prazo_solucao_sis_ext);			$dtSolSisExt = $dataSolArr[2].'-'.$dataSolArr[1].'-'.$dataSolArr[0];	}		if(empty($data_encerramento_sis_ext)){		$dtEncerSisExt = '0000-00-00';		}else{		$dataEncerramentoSisExtArr = explode("/",$data_encerramento_sis_ext);		$dtEncerSisExt = $dataEncerramentoSisExtArr[2].'-'.$dataEncerramentoSisExtArr[1].'-'.$dataEncerramentoSisExtArr[0];	}		if(empty($prazo_solucao)){		$dtPrazoSolucao = '0000-00-00';		}else{		$dtPrazoSolucaoArr = explode("/",$prazo_solucao);		$dtPrazoSolucao = $dtPrazoSolucaoArr[2].'-'.$dtPrazoSolucaoArr[1].'-'.$dtPrazoSolucaoArr[0];	}		if(empty($data_envio)){		$dtEnvio = '0000-00-00';		}else{		$dataEnvioArr = explode("/",$data_envio);		$dtEnvio = $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0];	}		if(empty($data_retorno)){		$dtRetorno = '0000-00-00';		}else{		$dataRetornoArr = explode("/",$data_retorno);		$dtRetorno = $dataRetornoArr[2].'-'.$dataRetornoArr[1].'-'.$dataRetornoArr[0];	}		if(empty($esc_data_prazo_um)){		$escDtPrazoUm = '0000-00-00';		}else{		$escDataPrazoUmArr = explode("/",$esc_data_prazo_um);		$escDtPrazoUm = $escDataPrazoUmArr[2].'-'.$escDataPrazoUmArr[1].'-'.$escDataPrazoUmArr[0];	}		if(empty($esc_data_retorno_um)){		$escDtRetUm = '0000-00-00';		}else{		$escDataPrazoUmArr = explode("/",$esc_data_retorno_um);		$escDtRetUm = $escDataPrazoUmArr[2].'-'.$escDataPrazoUmArr[1].'-'.$escDataPrazoUmArr[0];	}		if(empty($esc_data_prazo_dois)){		$escDtPrazoDois = '0000-00-00';		}else{		$escDataPrazoDoisArr = explode("/",$esc_data_prazo_dois);		$escDtPrazoDois = $escDataPrazoDoisArr[2].'-'.$escDataPrazoDoisArr[1].'-'.$escDataPrazoDoisArr[0];	}		if(empty($esc_data_retorno_dois)){		$escDtRetDois = '0000-00-00';		}else{		$escDataRetornoDoisArr = explode("/",$esc_data_retorno_dois);		$escDtRetDois = $escDataRetornoDoisArr[2].'-'.$escDataRetornoDoisArr[1].'-'.$escDataRetornoDoisArr[0];	}		if(empty($esc_data_prazo_tres)){		$escDtPrazoTres = '0000-00-00';		}else{		$escDataPrazoTresArr = explode("/",$esc_data_prazo_tres);		$escDtPrazoTres = $escDataPrazoTresArr[2].'-'.$escDataPrazoTresArr[1].'-'.$escDataPrazoTresArr[0];	}		if(empty($esc_data_retorno_tres)){		$escDtRetTres = '0000-00-00';		}else{		$escDataRetornoDoisArr = explode("/",$esc_data_retorno_tres);		$escDtRetTres = $escDataRetornoDoisArr[2].'-'.$escDataRetornoDoisArr[1].'-'.$escDataRetornoDoisArr[0];	}		$dados = array(		'id_contratante' => $idContratante,		'tipo_tratativa' => $tipo_tratativa,		'id_sis_ext' => $id_sis_ext,		'id_cnd_mob' => $id_cnd,		'pendencia' => $id_pendencia,		'esfera' => $id_esfera,		'etapa' => $id_etapa,		'data_informe_pendencia' => $dtInforme ,		'data_inclusao_sis_ext' => $dtInclusaoSisExt,		'prazo_solucao_sis_ext' => $dtSolSisExt ,		'data_encerramento_sis_ext' => $dtEncerSisExt,		'sla_sis_ext' => $id_sla,		'status_chamado_sis_ext' => $status_chamado_sis_ext , 		'usu_inc' => $usu_inc,		'area_focal' => $area_focal,		'sub_area_focal' => $sub_area_focal,		'contato' => $contato ,		'data_envio' =>$dtEnvio,		'prazo_solucao' => $dtPrazoSolucao,		'data_retorno' =>$dtRetorno,		'sla' => $sla,		'status_demanda' => $status_demanda,		'esc_data_prazo_um' =>$escDtPrazoUm,		'esc_data_retorno_um' =>$escDtRetUm,		'esc_status_um' => $esc_status_um,		'esc_data_prazo_dois' =>$escDtPrazoDois,		'esc_data_retorno_dois' =>$escDtRetDois,		'esc_status_dois' => $esc_status_dois ,		'esc_data_prazo_tres' =>$escDtPrazoTres,		'esc_data_retorno_tres' =>$escDtRetTres ,		'esc_status_tres' => $esc_status_tres,		'modulo'=>2		);				if($acao == 1){			$id_tratativa = $this->justica_trabalho_model->add_tratativa($dados);					}else{			$this->justica_trabalho_model->atualizar_tratativa($dados,$id_tratativa);							}		$_SESSION['idTratativa'] = $id_tratativa;				if(!empty($nova_tratativa)){			$dadosNovaTratativa = array(				'id_contratante' => $idContratante,			'id_cnd_trat' => $id_tratativa,			'observacao' =>$nova_tratativa,			'id_usuario' => $idUsu,			'data' => date("Y-m-d"),			'hora'=> date("h:i:s"),					);			$this->justica_trabalho_model->addObsTrat($dadosNovaTratativa);		}				$dadosEntradaCadin = array('data_entrada_cadin' =>$dtCadin);				$this->justica_trabalho_model->atualizar($dadosEntradaCadin,$id_cnd);				redirect('/justica_trabalho/visao_externa?id='.$id_cnd);		}function atualizar_cnd_mob_tratativa_unica(){		$session_data = $_SESSION['login'];	$idContratante = $_SESSION['cliente'] ;	$idUsu = $session_data['id'];	$acao 	= $this->input->post('acao');			$data_entrada_cadin 	= $this->input->post('data_entrada_cadin');			if(empty($data_entrada_cadin)){		$dtCadin = '0000-00-00';		}else{		$dtCadinArr = explode("/",$data_entrada_cadin);			$dtCadin = $dtCadinArr[2].'-'.$dtCadinArr[1].'-'.$dtCadinArr[0];	}	$id_cnd 	= $this->input->post('id');	$tipo_tratativa 	= $this->input->post('tipo_tratativa');	if(empty($tipo_tratativa)){		$tipo_tratativa = $this->input->post('tipo_tratativa_bd');	}	$id_tratativa 	= $this->input->post('id_tratativa');	$id_pendencia 	= $this->input->post('id_pendencia');	$id_esfera 	= $this->input->post('id_esfera');	$id_etapa 	= $this->input->post('id_etapa');	$data_informe_pendencia 	= $this->input->post('data_informe_pendencia');	$id_sis_ext 	= $this->input->post('id_sis_ext');	$data_inclusao_sis_ext 	= $this->input->post('data_inclusao_sis_ext');	$prazo_solucao_sis_ext 	= $this->input->post('prazo_solucao_sis_ext');	$data_encerramento_sis_ext 	= $this->input->post('data_encerramento_sis_ext');	$status_chamado_sis_ext 	= $this->input->post('status_chamado_sis_ext');	$id_sla = $this->input->post('id_sla');	$usu_inc 	= $this->input->post('usu_inc');	$area_focal 	= $this->input->post('area_focal');	$sub_area_focal 	= $this->input->post('sub_area_focal');	$contato 	= $this->input->post('contato');	$data_envio 	= $this->input->post('data_envio');	$prazo_solucao 	= $this->input->post('prazo_solucao');	$data_retorno 	= $this->input->post('data_retorno');	$sla 	= $this->input->post('sla');	$status_demanda 	= $this->input->post('status_demanda');	$esc_data_prazo_um 	= $this->input->post('esc_data_prazo_um');	$esc_data_retorno_um 	= $this->input->post('esc_data_retorno_um');	$esc_status_um 	= $this->input->post('esc_status_um');	$esc_data_prazo_dois 	= $this->input->post('esc_data_prazo_dois');	$esc_data_retorno_dois 	= $this->input->post('esc_data_retorno_dois');	$esc_status_dois 	= $this->input->post('esc_status_dois');	$esc_data_prazo_tres 	= $this->input->post('esc_data_prazo_tres');	$esc_data_retorno_tres 	= $this->input->post('esc_data_retorno_tres');	$esc_status_tres 	= $this->input->post('esc_status_tres');	$nova_tratativa 	= $this->input->post('nova_tratativa');		if(empty($data_informe_pendencia)){		$dtInforme = '0000-00-00';		}else{		$dataInformeArr = explode("/",$data_informe_pendencia);			$dtInforme = $dataInformeArr[2].'-'.$dataInformeArr[1].'-'.$dataInformeArr[0];	}		if(empty($data_inclusao_sis_ext)){		$dtInclusaoSisExt = '0000-00-00';		}else{		$dataInformeArr = explode("/",$data_inclusao_sis_ext);			$dtInclusaoSisExt = $dataInformeArr[2].'-'.$dataInformeArr[1].'-'.$dataInformeArr[0];	}		if(empty($prazo_solucao_sis_ext)){		$dtSolSisExt = '0000-00-00';		}else{		$dataSolArr = explode("/",$prazo_solucao_sis_ext);			$dtSolSisExt = $dataSolArr[2].'-'.$dataSolArr[1].'-'.$dataSolArr[0];	}		if(empty($data_encerramento_sis_ext)){		$dtEncerSisExt = '0000-00-00';		}else{		$dataEncerramentoSisExtArr = explode("/",$data_encerramento_sis_ext);		$dtEncerSisExt = $dataEncerramentoSisExtArr[2].'-'.$dataEncerramentoSisExtArr[1].'-'.$dataEncerramentoSisExtArr[0];	}		if(empty($prazo_solucao)){		$dtPrazoSolucao = '0000-00-00';		}else{		$dtPrazoSolucaoArr = explode("/",$prazo_solucao);		$dtPrazoSolucao = $dtPrazoSolucaoArr[2].'-'.$dtPrazoSolucaoArr[1].'-'.$dtPrazoSolucaoArr[0];	}		if(empty($data_envio)){		$dtEnvio = '0000-00-00';		}else{		$dataEnvioArr = explode("/",$data_envio);		$dtEnvio = $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0];	}		if(empty($data_retorno)){		$dtRetorno = '0000-00-00';		}else{		$dataRetornoArr = explode("/",$data_retorno);		$dtRetorno = $dataRetornoArr[2].'-'.$dataRetornoArr[1].'-'.$dataRetornoArr[0];	}		if(empty($esc_data_prazo_um)){		$escDtPrazoUm = '0000-00-00';		}else{		$escDataPrazoUmArr = explode("/",$esc_data_prazo_um);		$escDtPrazoUm = $escDataPrazoUmArr[2].'-'.$escDataPrazoUmArr[1].'-'.$escDataPrazoUmArr[0];	}		if(empty($esc_data_retorno_um)){		$escDtRetUm = '0000-00-00';		}else{		$escDataPrazoUmArr = explode("/",$esc_data_retorno_um);		$escDtRetUm = $escDataPrazoUmArr[2].'-'.$escDataPrazoUmArr[1].'-'.$escDataPrazoUmArr[0];	}		if(empty($esc_data_prazo_dois)){		$escDtPrazoDois = '0000-00-00';		}else{		$escDataPrazoDoisArr = explode("/",$esc_data_prazo_dois);		$escDtPrazoDois = $escDataPrazoDoisArr[2].'-'.$escDataPrazoDoisArr[1].'-'.$escDataPrazoDoisArr[0];	}		if(empty($esc_data_retorno_dois)){		$escDtRetDois = '0000-00-00';		}else{		$escDataRetornoDoisArr = explode("/",$esc_data_retorno_dois);		$escDtRetDois = $escDataRetornoDoisArr[2].'-'.$escDataRetornoDoisArr[1].'-'.$escDataRetornoDoisArr[0];	}		if(empty($esc_data_prazo_tres)){		$escDtPrazoTres = '0000-00-00';		}else{		$escDataPrazoTresArr = explode("/",$esc_data_prazo_tres);		$escDtPrazoTres = $escDataPrazoTresArr[2].'-'.$escDataPrazoTresArr[1].'-'.$escDataPrazoTresArr[0];	}		if(empty($esc_data_retorno_tres)){		$escDtRetTres = '0000-00-00';		}else{		$escDataRetornoDoisArr = explode("/",$esc_data_retorno_tres);		$escDtRetTres = $escDataRetornoDoisArr[2].'-'.$escDataRetornoDoisArr[1].'-'.$escDataRetornoDoisArr[0];	}		$dados = array(		'id_contratante' => $idContratante,		'tipo_tratativa' => $tipo_tratativa,		'id_sis_ext' => $id_sis_ext,		'id_cnd_mob' => $id_cnd,		'pendencia' => $id_pendencia,		'esfera' => $id_esfera,		'etapa' => $id_etapa,		'data_informe_pendencia' => $dtInforme ,		'data_inclusao_sis_ext' => $dtInclusaoSisExt,		'prazo_solucao_sis_ext' => $dtSolSisExt ,		'data_encerramento_sis_ext' => $dtEncerSisExt,		'sla_sis_ext' => $id_sla,		'status_chamado_sis_ext' => $status_chamado_sis_ext , 		'usu_inc' => $usu_inc,		'area_focal' => $area_focal,		'sub_area_focal' => $sub_area_focal,		'contato' => $contato ,		'data_envio' =>$dtEnvio,		'prazo_solucao' => $dtPrazoSolucao,		'data_retorno' =>$dtRetorno,		'sla' => $sla,		'status_demanda' => $status_demanda,		'esc_data_prazo_um' =>$escDtPrazoUm,		'esc_data_retorno_um' =>$escDtRetUm,		'esc_status_um' => $esc_status_um,		'esc_data_prazo_dois' =>$escDtPrazoDois,		'esc_data_retorno_dois' =>$escDtRetDois,		'esc_status_dois' => $esc_status_dois ,		'esc_data_prazo_tres' =>$escDtPrazoTres,		'esc_data_retorno_tres' =>$escDtRetTres ,		'esc_status_tres' => $esc_status_tres,		'modulo'=>7		);		if($acao == 1){			$id_tratativa = $this->justica_trabalho_model->add_tratativa($dados);					}else{			$this->justica_trabalho_model->atualizar_tratativa($dados,$id_tratativa);							}				//guardando id para abrir novamente apos salvar		$_SESSION['idTratativa'] = $id_tratativa;						if($status_chamado_sis_ext > 1){						if(!empty($nova_tratativa)){				$dadosNovaTratativa = array(					'id_contratante' => $idContratante,				'id_cnd_trat' => $id_tratativa,				'observacao' =>$nova_tratativa,				'id_usuario' => $idUsu,				'data' => date("Y-m-d"),				'hora'=> date("H:i:s"),				'data_hora' => date("Y-m-d H:i:s") 							);				$this->justica_trabalho_model->addObsTrat($dadosNovaTratativa);			}					$email = $this->user->buscaEmailById($idUsu);						$dadosNovaTratativa = array(				'id_contratante' => $idContratante,			'id_cnd_trat' => $id_tratativa,			'observacao' =>'Tratativa Cancelada/Encerrada',			'id_usuario' => $idUsu,			'data' => date("Y-m-d"),			'hora'=> date("h:i:s"),			'data_hora' => date("Y-m-d H:i:s") 					);			$this->justica_trabalho_model->addObsTrat($dadosNovaTratativa);					}else{						$dados =  $this->justica_trabalho_model->listarObsTratById($id_tratativa);			$isArray =  is_array($dados) ? '1' : '0';			if($isArray == 0){							$email = $this->user->buscaEmailById($idUsu);								$dadosNovaTratativa = array(					'id_contratante' => $idContratante,				'id_cnd_trat' => $id_tratativa,				'observacao' =>'Tratativa Aberta',				'id_usuario' => $idUsu,				'data' => date("Y-m-d"),				'hora'=> date("H:i:s"),				'data_hora' => date("Y-m-d H:i:s") 						);				$this->justica_trabalho_model->addObsTrat($dadosNovaTratativa);			}									if(!empty($nova_tratativa)){				$dadosNovaTratativa = array(					'id_contratante' => $idContratante,				'id_cnd_trat' => $id_tratativa,				'observacao' =>$nova_tratativa,				'id_usuario' => $idUsu,				'data' => date("Y-m-d"),				'hora'=> date("H:i:s"),				'data_hora' => date("Y-m-d H:i:s") 							);				$this->justica_trabalho_model->addObsTrat($dadosNovaTratativa);			}		}						//$dadosEntradaCadin = array('data_entrada_cadin' =>$dtCadin);				//$this->justica_trabalho_model->atualizar($dadosEntradaCadin,$id_cnd);								$perfilUsuarioLocal = $session_data['local'];	$idUsuario = $session_data['id'];	$modulo = $_SESSION["CNDMob"];					redirect('/justica_trabalho/visao_interna?id='.$id_cnd);		}
function atualizar_cnd_mob_tratativa_unica_cnd(){			$session_data = $_SESSION['login'];	$idContratante = $_SESSION['cliente'] ;	$idUsu = $session_data['id'];			$perfilUsuarioLocal = $session_data['local'];	$idUsuario = $session_data['id'];	$id = $this->input->post('id');	$id_emitente = $this->input->post('id_emitente');	$inscricao = $this->input->post('inscricao');	$possui_cnd = $this->input->post('possui_cnd');	$data_vencto = $this->input->post('data_vencto');		$arrDataVencto = explode("/",$data_vencto);		$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];	$observacoes = $this->input->post('observacoes');		$plano = $this->input->post('plano');			$respInt = $this->input->post('resp_int');			$respExt = $this->input->post('resp_ext');			$observacao_tratativa = $this->input->post('observacao_tratativa');		$data_emissao = $this->input->post('data_emissao');		$arrDataEmissao = explode("/",$data_emissao);		$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];			$modulo = $_SESSION["CNDMob"];			if($possui_cnd == 1){		$dados1 = array(			//'inscricao' => $inscricao,			'id_contratante' => $idContratante,			'possui_cnd' => 1,			'ativo' => 0,			'data_vencto' => $dataVencto,						'data_emissao' => $dataEmissao,			'observacoes' => $observacoes,			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt		);		$_SESSION["CNDMob"] = 'listarPorTipoSim';						}elseif($possui_cnd == 2){		$dados1 = array(			//'inscricao' => $inscricao,			'id_contratante' => $idContratante,			'possui_cnd' => 2,			'ativo' => 0,			'data_vencto' => $dataVencto,			'data_emissao' => $dataEmissao,			'observacoes' => $observacoes,			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt		);		$_SESSION["CNDMob"] = 'listarPorTipoNao';	}else{		$dados1 = array(			//'inscricao' => $inscricao,			'id_contratante' => $idContratante,			'possui_cnd' => 3,			'ativo' => 0,			'data_pendencias' => $dataVencto,						'data_emissao' => $dataEmissao,			'observacoes' => $observacoes,			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt		);		$_SESSION["CNDMob"] = 'listarPorTipoPendencia';		}	$this->justica_trabalho_model->atualizar($dados1,$id);		redirect('/justica_trabalho/visao_interna?id='.$id);		}function visao_interna(){		  if(!$_SESSION['login']){		redirect('login', 'refresh');  }   $session_data = $_SESSION['login'];   if(empty($_SESSION['idTratativa'])){		$idTratativa = 0;	}else{		$idTratativa = $_SESSION['idTratativa'];	}		$data['idTratativa'] = $idTratativa;		$id = $this->input->get('id');	$idContratante = $_SESSION['cliente'] ;	  //$data['respInterno']  = $this->justica_trabalho_model->listaResponsaveis($idContratante,1);// 1 para internos  //$data['respExterno']  = $this->justica_trabalho_model->listaResponsaveis($idContratante,2);// 2 para externos    $data['obs'] = $this->justica_trabalho_model->buscaTodasObservacoes($id,7);		  $dados = $this->justica_trabalho_model->listarInscricaoByLoja($id);  	$data['imovel'] = $dados;	if($dados[0]->possui_cnd == 1){		$data['modulo'] = 'listarPorTipoSim';	}else if($dados[0]->possui_cnd == 2){		$data['modulo'] = 'listarPorTipoNao';	}else{		$data['modulo'] = 'listarPorTipoPendencia';	}		if(empty($session_data['visitante'])){		$data['visitante'] = 0;	}else{		$data['visitante'] = $session_data['visitante'];		}	$data['local'] = $session_data['local'];		$dadosImovel = $this->justica_trabalho_model->listarCidadeEstadoById($id);	//$dadosDataDb = $this->justica_trabalho_model->listarDataEmissao($id,'falencia');	//$data['data_emissao'] = $dadosDataDb;	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;	$data['perfil'] = $session_data['perfil'];		$data['id_cnd'] = $id;	$data['tratativas'] =  $this->justica_trabalho_model->listarTodasTratativas($idContratante,$id,7);		$data['esferas'] = $this->justica_trabalho_model->listarEsfera();	$data['etapas'] = $this->justica_trabalho_model->listarEtapa();	$data['statusInterno'] = $this->justica_trabalho_model->listarStatusInterno();	$data['statusDemanda'] = $this->justica_trabalho_model->listarStatusDemanda();		$data['empresa'] = $session_data['empresa'];	$data['nome_modulo'] = 'Justiça do trabalho';	$data['controller'] = 'justica_trabalho';		$this->load->view('header_pages_view',$data);    $this->load->view('cnd_mob_visao_unica_view', $data);	$this->load->view('footer_pages_view');	}
 

  function editar(){	
    
  if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
   $session_data = $_SESSION['login'];
	$id = $this->input->get('id');
	$idContratante = $_SESSION['cliente'] ;
	
  $dados = $this->justica_trabalho_model->listarInscricaoByLoja($id);
	$data['imovel'] = $dados;
	if($dados[0]->possui_cnd == 1){
		$data['modulo'] = 'listarPorTipoSim';
	}else if($dados[0]->possui_cnd == 2){
		$data['modulo'] = 'listarPorTipoNao';
	}else{
		$data['modulo'] = 'listarPorTipoPendencia';
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$dadosImovel = $this->justica_trabalho_model->listarCidadeEstadoById($id);
	$dadosDataDb = $this->justica_trabalho_model->listarDataEmissao($id,'mob');
	$data['data_emissao'] = $dadosDataDb;
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_cnd_mob_view', $data);
	$this->load->view('footer_pages_view');
 } function csvTratativaExt($result){	$file="justica_trabalho.xls";	if($result == 0){			$test="<table border=1>		<tr>		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>		</tr>		";		$test .='</table>';    }else{				$test="<table border=1>			<tr>			<td>Estado</td>			<td>Cidade</td>			<td>Bairro</td>			<td>Endere&ccedil;o</td>			<td>N&uacute;mero</td>			<td>CEP</td>			<td>Loja</td>			<td>Emitente</td>			<td>CPF/CNPJ</td>			<td>Status CND</td>			<td>Data &Uacute;ltima CND </td>			<td>Data Vencto. &Uacute;ltima CND </td>			<td>Regional</td>			<td>Bandeira</td>			<td>Centro de Custo</td>			<td>C&oacute;digo 1</td>			<td>C&oacute;digo 2</td>			</tr>			";			foreach($result as $key => $iptu){ 				 $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_mob');							 $isArrayLog =  is_array($dadosLog) ? '1' : '0';			 			 $dataEmissao = $this->justica_trabalho_model->listarDataEmissao($iptu->id_cnd,'falencia');										if($iptu->possui_cnd == 1){					$possui_cnd ='Sim';					$data = 'Vencimento';				}else{					$possui_cnd ='Não';					$data = 'Pend&ecirc;ncia';				}								if($iptu->possui_cnd == 1){					$cnd ='Emitido';					$corCnd = '#000099';						$dataVArr = explode("-",$iptu->data_vencto);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}elseif($iptu->possui_cnd == 2){					$cnd ='N&atilde;o Emitido';					$corCnd = '#000099';					$dataVArr = explode("-",$iptu->data_vencto);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}elseif($iptu->possui_cnd == 3){					$cnd ='Pendente';					$corCnd = '#000099';					$dataVArr = explode("-",$iptu->data_pendencias);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}								$arrDataVencto = explode("-",$iptu->data_vencto);				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];				$cor='#fff';				$test .= "<tr >";				$test .= "<td>".utf8_decode($iptu->estado)."</td>";				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";				$test .= "<td>".utf8_decode($iptu->bairro)."</td>";				$test .= "<td>".utf8_decode($iptu->endereco)."</td>";				$test .= "<td>".utf8_decode($iptu->numero)."</td>";				$test .= "<td>".utf8_decode($iptu->cep)."</td>";				$test .= "<td>".utf8_decode($iptu->nome)."</td>";				$test .= "<td>".utf8_decode($iptu->nome_fantasia)."</td>";								$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				$test .= "<td>".utf8_decode($cnd)."</td>";				$test .= "<td>".utf8_decode($iptu->data_emissao_br)."</td>";								$test .= "<td>".utf8_decode($dataV)."</td>";				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";				$test .= "<td>".utf8_decode($iptu->cc)."</td>";				$test .= "<td>".utf8_decode($iptu->cod1)."</td>";				$test .= "<td>".utf8_decode($iptu->cod1)."</td>";				$test .= "</tr>";			}				$session_data = $_SESSION['login'];				$idContratante = $_SESSION['cliente'] ;				$dadosPendencia = $this->justica_trabalho_model->listarTratativasIdCnd($iptu->id_cnd);												$test .= "<tr >";				$test .= "<td >".utf8_decode('Tratativa')."</td>";				$test .= "<td >".utf8_decode('Tipo Pendência')."</td>";				$test .= "<td >".utf8_decode('Esfera')."</td>";				$test .= "<td >".utf8_decode('Etapa')."</td>";				$test .= "<td >".utf8_decode('Data da Pendência')."</td>";				$test .= "<td >".utf8_decode('Tratativa da Pendência')."</td>";				$test .= "<td >".utf8_decode('Área Focal')."</td>";				$test .= "<td >".utf8_decode('Sub Área Focal')."</td>";				$test .= "<td >".utf8_decode('Contato')."</td>";				$test .= "<td >".utf8_decode('Data Envio')."</td>";				$test .= "<td >".utf8_decode('Prazo Solução')."</td>";				$test .= "<td >".utf8_decode('Status Chamado')."</td>";				$test .= "<td >".utf8_decode('Data Encerramento')."</td>";				$test .= "<td >".utf8_decode('SLA')."</td>";				$test .= "<td >".utf8_decode('Histórico')."</td>";							$test .= "</tr>";				foreach($dadosPendencia as $key => $pend){ 										$observacoes='';										$observacoes ='';					$dados =  $this->justica_trabalho_model->listarObsTratById($pend->id);					 $isArrayHist =  is_array($dados) ? '1' : '0';					 if($isArrayHist == 1){						foreach($dados as $dado){							$observacoes .= $dado->data.' - '.$dado->hora.' - '.$dado->email.' - '.$dado->observacao."<BR>";						} 					 }else{						$observacoes .= 'Sem históricos';					  }					  					  					if($pend->tipo_tratativa == 1){						$tipoTratavia ='Áreas Externas';					}else{						$tipoTratavia ='Áreas Internas';					}					if($pend->status_chamado_sis_ext ==1){						$statusChamado ='Em Atendimento';					}elseif($pend->status_chamado_sis_ext ==2){						$statusChamado ='Cancelado';					}elseif($pend->status_chamado_sis_ext ==3){						$statusChamado ='Encerrado';					}else{						$statusChamado ='Sem Status Definido';					}					$test .= "<tr >";					$test .= "<td >".utf8_decode($pend->id)."</td>";					$test .= "<td >".utf8_decode($pend->pendencia)."</td>";					$test .= "<td >".utf8_decode($pend->descricao_esfera)."</td>";					$test .= "<td >".utf8_decode($pend->descricao_etapa)."</td>";					$test .= "<td >".utf8_decode($pend->data_informe_pendencia)."</td>";					$test .= "<td >".utf8_decode($tipoTratavia)."</td>";					$test .= "<td >".utf8_decode($pend->area_focal)."</td>";					$test .= "<td >".utf8_decode($pend->sub_area_focal)."</td>";					$test .= "<td >".utf8_decode($pend->contato)."</td>";					$test .= "<td >".utf8_decode($pend->data_envio)."</td>";					$test .= "<td >".utf8_decode($pend->prazo_solucao)."</td>";					$test .= "<td >".utf8_decode($statusChamado)."</td>";					$test .= "<td >".utf8_decode($pend->data_encerramento_sis_ext)."</td>";					$test .= "<td >".utf8_decode($pend->sla_sis_ext)."</td>";					$test .= "<td >".utf8_decode($observacoes)."</td>";															$test .= "</tr>";				}							$test .='</table>';		}		header("Content-type: application/vnd.ms-excel");		header("Content-Disposition: attachment; filename=$file");		echo $test;	 } 
 function csvTratativa($result){	$file="cnd_mob.xls";	if($result == 0){			$test="<table border=1>		<tr>		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>		</tr>		";		$test .='</table>';    }else{				$test="<table border=1>			<tr>			<td>Estado</td>			<td>Cidade</td>			<td>Bairro</td>			<td>Endere&ccedil;o</td>			<td>N&uacute;mero</td>			<td>CEP</td>			<td>Loja</td>			<td>Emitente</td>			<td>CPF/CNPJ</td>			<td>N&uacute;mero Inscri&ccedil;&atilde;o</td>			<td>Inscri&ccedil;&atilde;o</td>			<td>Data &Uacute;ltima CND </td>			<td>Data Vencto. &Uacute;ltima CND </td>			<td>Regional</td>			<td>Bandeira</td>			<td>Centro de Custo</td>			<td>C&oacute;digo 1</td>			<td>C&oacute;digo 2</td>			<td>Históric&oacute;</td>			</tr>			";			foreach($result as $key => $iptu){ 				 $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_mob');							 $isArrayLog =  is_array($dadosLog) ? '1' : '0';			 			 $dataEmissao = $this->justica_trabalho_model->listarDataEmissao($iptu->id_cnd,'mob');			//$datasEmissao = $this->justica_trabalho_model->listarTodasDataEmissao($iptu->id_cnd,'mob');						//$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';				 			  			$observacoes='';			$obsArray = $this->justica_trabalho_model->buscaTodasObservacoes($iptu->id_cnd,1);							foreach($obsArray as $key => $ob){ 				$observacoes .= $ob->data.' - '.$ob->hora.' - '.$ob->email.' - '.$ob->observacao;				$observacoes .= '<BR>';				}							if($iptu->possui_cnd == 1){					$possui_cnd ='Sim';					$data = 'Vencimento';				}else{					$possui_cnd ='Não';					$data = 'Pend&ecirc;ncia';				}								if($iptu->possui_cnd == 1){					$cnd ='Emitido';					$corCnd = '#000099';						$dataVArr = explode("-",$iptu->data_vencto);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}elseif($iptu->possui_cnd == 2){					$cnd ='N&atilde;o Emitido';					$corCnd = '#000099';					$dataVArr = explode("-",$iptu->data_vencto);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}elseif($iptu->possui_cnd == 3){					$cnd ='Pendente';					$corCnd = '#000099';					$dataVArr = explode("-",$iptu->data_pendencias);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}								$arrDataVencto = explode("-",$iptu->data_vencto);				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];				$cor='#fff';				$test .= "<tr >";				$test .= "<td>".utf8_decode($iptu->estado)."</td>";				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";				$test .= "<td>".utf8_decode($iptu->bairro)."</td>";				$test .= "<td>".utf8_decode($iptu->endereco)."</td>";				$test .= "<td>".utf8_decode($iptu->numero)."</td>";				$test .= "<td>".utf8_decode($iptu->cep)."</td>";				$test .= "<td>".utf8_decode($iptu->nome)."</td>";				$test .= "<td>".utf8_decode($iptu->nome_fantasia)."</td>";								$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				$test .= "<td>"."'".utf8_decode($iptu->ins_cnd_mob)."'"."</td>";				$test .= "<td>".utf8_decode($cnd)."</td>";				$test .= "<td>".utf8_decode($dataEmissao[0]->data_emissao_br)."</td>";								$test .= "<td>".utf8_decode($dataV)."</td>";				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";				$test .= "<td>".utf8_decode($iptu->cc)."</td>";				$test .= "<td>".utf8_decode($iptu->cod1)."</td>";				$test .= "<td>".utf8_decode($iptu->cod1)."</td>";				$test .= "<td>".utf8_decode($observacoes )."</td>";				$test .= "</tr>";			}			$test .='</table>';		}		header("Content-type: application/vnd.ms-excel");		header("Content-Disposition: attachment; filename=$file");		echo $test;	 }
 function csvGrafico($result){
	 
	 $file="cnd_mob.xls";

	if($result == 0){	
		$test="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$test .='</table>';

    }else{	
			
			$test="<table border=1>
			<tr>
			<td>Nome Fantasia</td>
			<td>CPF/CNPJ</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Regional</td>
			<td>Bandeira</td>
			<td>Cidade</td>
			<td>Estado</td>			
			<td>Possui CND</td>
			<td>Data Vencto/Pend </td>
			</tr>
			";
			
			
	 
			foreach($result as $key => $iptu){ 	
			 $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_mob');				
			 $isArrayLog =  is_array($dadosLog) ? '1' : '0';

			$datasEmissao = $this->justica_trabalho_model->listarTodasDataEmissao($iptu->id_cnd,'mob');
			$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';				 
			  
				if($iptu->status_cnd == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->possui_cnd == 1){
					$possui_cnd ='Sim';
					$data = 'Vencimento';
				}else{
					$possui_cnd ='Não';
					$data = 'Pend&ecirc;ncia';
				}
				
				if($iptu->possui_cnd == 1){
					$cnd ='Emitido';
					$corCnd = '#000099';	
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 2){
					$cnd ='N&atilde;o Emitido';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 3){
					$cnd ='Pendente';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_pendencias);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}
				
				$arrDataVencto = explode("-",$iptu->data_vencto);
				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->ins_cnd_mob)."'"."</td>";
				
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
				
				$test .= "<td>".utf8_decode($cnd)."</td>";
				$test .= "<td>".$dataV."</td>";					
				$test .= "</tr>";
			
				
			}
			$test .='</table>';
		}

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
 }
 
 function csv($result){
	 
	 $file="cnd_mob.xls";

	if($result == 0){	
		$test="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$test .='</table>';

    }else{	
			
			$test="<table border=1>
			<tr>
			<td>Id</td>
			<td>Raz&atilde;o Social</td>
			<td>CPF/CNPJ</td>
			<td>Inscri&ccedil;&atilde;o</td>			<td>Cod. 1</td>
			<td>Cod. 2</td>
			<td>Regional</td>
			<td>Bandeira</td>
			<td>Cidade</td>
			<td>Estado</td>			
			<td>Observa&ccedil;&otilde;es</td>	
			<td>Plano de A&ccedil;&atilde;o</td>	
			<td>Status CND</td>
			<td>Possui CND</td>
			<td>Data Vencto/Pend </td>
			<td>Data de Emiss&atilde;o </td>	
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>				
			
			</tr>
			";
			
			
	 
			foreach($result as $key => $iptu){ 	
			 $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_mob');				
			 $isArrayLog =  is_array($dadosLog) ? '1' : '0';

			$datasEmissao = $this->justica_trabalho_model->listarTodasDataEmissao($iptu->id_cnd,'mob');
			$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';				 
			  
				if($iptu->status_cnd == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->possui_cnd == 1){
					$possui_cnd ='Sim';
					$data = 'Vencimento';
				}else{
					$possui_cnd ='Não';
					$data = 'Pend&ecirc;ncia';
				}
				
				if($iptu->possui_cnd == 1){
					$cnd ='Sim';
					$corCnd = '#000099';	
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 2){
					$cnd ='N&atilde;o';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 3){
					$cnd ='Pend&ecirc;ncia';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_pendencias);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}
				
				$arrDataVencto = explode("-",$iptu->data_vencto);
				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->id_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->ins_cnd_mob)."'"."</td>";
								$test .= "<td>".utf8_decode($iptu->cod1)."</td>";
				$test .= "<td>".utf8_decode($iptu->cod2)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
				$test .= "<td>".utf8_decode($iptu->observacoes)."</td>";
				$test .= "<td>".utf8_decode($iptu->plano)."</td>";
				$test .= "<td>".utf8_encode($ativo)."</td>";
				
				$test .= "<td>".utf8_decode($cnd)."</td>";
				$test .= "<td>".$dataV."</td>";
				if($isdatasEmissao <> 0){
					$test .="<td>";					
					foreach($datasEmissao as $dataE){ 					
						$test .= $dataE->data_emissao.' ';					
					}	
					$test .="</td>";				
				}else{
					$test .="<td>";
					$test .="</td>";						
				}
				if($isArrayLog <> 0){
					 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
					 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
					 $test .="<td>".$dadosLog[0]->email."</td>";
					 $test .="<td>".$dataFormatada."</td>";
					 $test .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
				}else{
					$test .="<td></td>";
					$test .="<td></td>";
					$test .="<td></td>";
				}		
				$test .= "</tr>";
			
				
			}
			$test .='</table>';
		}
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
 }

 
function export_mun(){	  
  if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
	$id = $this->input->post('id_mun_export');
	$tipo = $this->input->post('possuiCnd');
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;	
	$result = $this->justica_trabalho_model->listarIptuCsvByCidade($id,$tipo);
	$this->csv($result);		
 }
 
 function export_est(){	  
  if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
	$id = $this->input->post('id_estado_export');
	$tipo = $this->input->post('possuiCnd');
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->justica_trabalho_model->listarIptuCsvByEstado($id,$tipo);
	$this->csv($result);
 }
 

  function export(){	
  
  if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }

	$id = $this->input->post('id_imovel_export');
	$tipo = $this->input->post('possuiCnd');
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	

	if($id == 0){
	
		$result = $this->justica_trabalho_model->listarIptuCsv($idContratante,$tipo);
	}else{

		$result = $this->justica_trabalho_model->listarIptuCsvById($id,$tipo);
	}
	
	$this->csv($result);
	
		
 }
 function export_tratativas(){		$id = $this->input->get('id');	$dados = $this->justica_trabalho_model->listarInscricaoByLoja($id);	$this->csvTratativa($dados);	  }  function export_tratativas_ext(){		$id = $this->input->get('id');	$dados = $this->justica_trabalho_model->listarInscricaoByLoja($id);		$this->csvTratativaExt($dados);	  }  
 function export_total_mob(){	
  
  if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }

	$id = $this->input->post('id_imovel_export');
	$tipo = 'X';
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	

	$result = $this->justica_trabalho_model->listarIptuCsv($idContratante,$tipo);
	$this->csvGrafico($result);
	
		
 }
 
 function buscaCidade(){	
 
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->get('estado');
	$tipo = $this->input->get('tipo');
	
	
	$retorno ='';
	$result = $this->justica_trabalho_model->listarCidadeByEstado($idContratante,$id,$tipo);
	
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaTodasCidades(){	
	$cidadeFiltro = $this->input->get('cidadeFiltro');
	$tipo = $this->input->get('tipo');
	$session_data = $_SESSION['login'];
	
	$idContratante = $_SESSION['cliente'] ;
	
	$retorno ='';
	$result = $this->justica_trabalho_model->listarCidade($idContratante,$tipo);
	
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $iptu){ 	
			if($iptu->cidade == $cidadeFiltro){
				$retorno .="<option value='".$iptu->cidade."' selected>".$iptu->cidade."</option>";
			}else{
				$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";
			}
		 
		}
		
	
	}
	echo json_encode($retorno);
	
 }
 function buscaInscricaoByEstado(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->justica_trabalho_model->listarImovelByEstado($id,$tipo);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha um Imóvel</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaLoja(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->justica_trabalho_model->listarImovelByCidade($id,$tipo);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha um Imóvel</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function busca(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->justica_trabalho_model->listarLojaByImovel($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }


	 if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
	 
	 
								
	 $base = $this->config->base_url().'index.php';
	  $retorno .="<tr style='color:$cor'>";
      $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  $retorno .="<td width='14%'>".$iptu->cpf_cnpj."</td>";
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaPendentes(){	
	//$id = $this->input->get('id');
	
	$retorno ='';
	$result = $this->justica_trabalho_model->listarImovelPendente();
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='6'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	 if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
								 
	//$arrDataVencto = explode("-",$iptu->data_vencto);
	//$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];

								
	  $base = $this->config->base_url().'index.php';	
	  $retorno .="<tr style='color:$cor'>";
	  $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  if($iptu->loja_acomp){
		$retorno .="<td width='14%'><a href='$base/acomp_cnd/painel?id=$iptu->loja_acomp'>".$iptu->cpf_cnpj."</a></td>";
	  }else{
		$retorno .="<td width='14%'><a style='color:#000' href='$base/loja/acomp?id=$iptu->id_loja'>".$iptu->cpf_cnpj."</a></td>";
	  }
	  
	  
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
  function buscaEstado(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->justica_trabalho_model->listarImovelByUf($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='6'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	 if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
								 
	//$arrDataVencto = explode("-",$iptu->data_vencto);
	//$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];

								
	  $base = $this->config->base_url().'index.php';	
	  $retorno .="<tr style='color:$cor'>";
	  $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  $retorno .="<td width='14%'>".$iptu->cpf_cnpj."</td>";
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaMunicipio(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->justica_trabalho_model->listarImovelByMunicipio($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	 if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
	 

								
      $base = $this->config->base_url().'index.php';
	  $retorno .="<tr style='color:$cor'>";
	  $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  $retorno .="<td width='14%'>".$iptu->cpf_cnpj."</td>";
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
 function listarTodos(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
  
	$tipo = 'X';
	$cidade = '0';
	$estado = '0';
	
	$session_data = $_SESSION['login'];		$_SESSION['idTratativa'] = '';
	$idContratante = $_SESSION['cliente'] ;				
	$data['perfil'] = $session_data['perfil'];
	$data['lojas'] = $this->justica_trabalho_model->listarLoja($idContratante,$tipo);	
	$data['estados'] = $this->justica_trabalho_model->listarEstado($idContratante,$tipo);	
	$data['cidades'] = $this->justica_trabalho_model->listarCidade($idContratante,$tipo);
	$session_data = $_SESSION['login'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		$result = $this->justica_trabalho_model->listarCndTipo($idContratante,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->justica_trabalho_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->justica_trabalho_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->justica_trabalho_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}
	}

	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

		
	$_SESSION["CNDMob"] = 'listarTodos';
	$data['CNDMob'] = 'listarTodos';
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
			$data['nome_modulo'] = 'Justiça do trabalho';	$data['modulo'] = 'justica_trabalho';
	
	$this->load->view('header_pages_view',$data);    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);	$this->load->view('footer_pages_view');
	


 }
 
 function listarPorTipoSim(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
  
	$tipo = '1';
	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;				
	$data['perfil'] = $session_data['perfil'];
	$data['lojas'] = $this->justica_trabalho_model->listarLoja($idContratante,$tipo);	
	$data['estados'] = $this->justica_trabalho_model->listarEstado($idContratante,$tipo);	
	$data['cidades'] = $this->justica_trabalho_model->listarCidade($idContratante,$tipo);
	$session_data = $_SESSION['login'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	if(empty($_POST)){
		$result = $this->justica_trabalho_model->listarCndTipo($idContratante,$tipo);
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->justica_trabalho_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->justica_trabalho_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->justica_trabalho_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
			//print_r($this->db->last_query());exit;
		}
	}

	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

		
	$_SESSION["CNDMob"] = 'listarPorTipoSim';
	$data['CNDMob'] = 'listarPorTipoSim';
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
			$_SESSION['idTratativa'] = '';
		$data['nome_modulo'] = 'Justiça do trabalho';
	$data['modulo'] = 'justica_trabalho';
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 
 function listarPorRegional(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
  
	$tipo  = $this->input->get('tipo');
	$regional  = $this->input->get('reg');
	
	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;				
	$data['perfil'] = $session_data['perfil'];
	$data['lojas'] = $this->justica_trabalho_model->listarLoja($idContratante,$tipo);	
	$data['estados'] = $this->justica_trabalho_model->listarEstado($idContratante,$tipo);	
	$data['cidades'] = $this->justica_trabalho_model->listarCidade($idContratante,$tipo);
	$session_data = $_SESSION['login'];
	
	
	$result =  $this->justica_trabalho_model->listarCndTipoReg($idContratante,$regional,$tipo);

	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

	if(empty($_SESSION["cidadeCNDMBD"])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION["cidadeCNDMBD"];
	}
	if(empty($_SESSION["estadoCNDMBD"])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $_SESSION["estadoCNDMBD"];
	}
	if(empty($_SESSION["idCNDMBD"])){
		$data['idCNDMBD'] = 0;
	}else{
		$data['idCNDMBD'] = $_SESSION["idCNDMBD"];
	}
	
	$_SESSION["CNDMob"] = 'listarPorTipoSim';
	$data['CNDMob'] = 'listarPorTipoSim';
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
		
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function listarPorTipoPendencia(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
	$tipo = '3';
	
	$session_data = $_SESSION['login'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->justica_trabalho_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->justica_trabalho_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->justica_trabalho_model->listarCidade($idContratante,$tipo);
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}

	$session_data = $_SESSION['login'];
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		
		$result = $this->justica_trabalho_model->listarCndTipo($idContratante,$tipo);		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->justica_trabalho_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->justica_trabalho_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->justica_trabalho_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}	   
	}
	//print'<BR>';
	//print_r($this->db->last_query());exit;
	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];
		
	
	$_SESSION["CNDMob"] = 'listarPorTipoPendencia';
	
	$data['CNDMob'] = 'listarPorTipoPendencia';
	
	
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
	$_SESSION['idTratativa'] = '';		$data['modulo'] = 'justica_trabalho';	$data['nome_modulo'] = 'Justiça do trabalho';	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
function listarPorTipoNao(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
	$tipo = '2';
	$cidade = '0';
	$estado = '0';
	
	$session_data = $_SESSION['login'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->justica_trabalho_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->justica_trabalho_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->justica_trabalho_model->listarCidade($idContratante,$tipo);
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login'];
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		$result = $this->justica_trabalho_model->listarCndTipo($idContratante,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->justica_trabalho_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->justica_trabalho_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->justica_trabalho_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}
	   
	   	
		

	}


	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

		
	$_SESSION["CNDMob"] = 'listarPorTipoNao';
	
	$data['CNDMob'] = 'listarPorTipoNao';
	
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}		$_SESSION['idTratativa'] = '';
	$data['modulo'] = 'justica_trabalho';	$data['nome_modulo'] = 'Justiça do trabalho';
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
  function limpar_filtro(){	
 
	$_SESSION["idCNDMBD"]=0;
  	$_SESSION["cidadeCNDMBD"] = 0;
	$_SESSION["estadoCNDMBD"] = 0;

	$modulo = $_SESSION["CNDMob"];
	redirect('/justica_trabalho/'.$modulo, '');

 }
 
 function listarLoja(){	
 
	redirect('loja/listar_status?status=4', '');

 }
 
  function listar(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }

	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->justica_trabalho_model->listarLoja($idContratante,'X');
	
	$data['estados'] = $this->justica_trabalho_model->listarEstado($idContratante,'X');
	
	$data['cidades'] = $this->justica_trabalho_model->listarCidade($idContratante,'X');
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login'];
	
	$result = $this->justica_trabalho_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	
	$total = $this->justica_trabalho_model->somarTodos($idContratante,$cidade,$estado);
	$data['paginacao'] = createPaginate('cnd_mob', $total[0]->total) ;

	$_SESSION["CNDMob"] = 'listar';

	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->session->set_userdata('CNDMob', 'listar');
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 function listar_old(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }

	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->justica_trabalho_model->listarLoja($idContratante,'X');
	
	$data['estados'] = $this->justica_trabalho_model->listarEstado($idContratante,'X');
	
	$data['cidades'] = $this->justica_trabalho_model->listarCidade($idContratante,'X');
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login'];
	
	$result = $this->justica_trabalho_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	
	$total = $this->justica_trabalho_model->somarTodos($idContratante,$cidade,$estado);
	$data['paginacao'] = createPaginate('cnd_mob', $total[0]->total) ;

	$_SESSION["CNDMob"] = 'listar';

	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->session->set_userdata('CNDMob', 'listar');
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_view', $data);

	$this->load->view('footer_pages_view');
	


 }

 function listarComParametro(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }

	$cidade  = $this->input->get('cidade');
	$estado  = $this->input->get('uf');
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->justica_trabalho_model->listarLoja($idContratante);
	
	$data['estados'] = $this->justica_trabalho_model->listarEstado($idContratante);
	
	$data['cidades'] = $this->justica_trabalho_model->listarCidade($idContratante);
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login'];
	
	$result = $this->justica_trabalho_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	//print_r($this->db->last_query());exit;
	$total = $this->justica_trabalho_model->somarTodos($idContratante,$cidade,$estado);
	$data['paginacao'] = createPaginate('cnd_mob', $total[0]->total) ;

	
	$data['iptus'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_cnd_mobiliaria_view', $data);
	$this->load->view('footer_pages_view');
	

 }
 

}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cnd_imob extends CI_Controller {
	 function __construct(){
		parent::__construct();
		$this->load->model('cnd_imobiliaria_model','',TRUE);	
		$this->load->model('log_model','',TRUE);
		$this->load->model('cnd_imobiliaria_model','',TRUE);
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
		$this->db->cache_on();
		session_start();
		

	 }
  function index(){
   if(!$_SESSION['login']) {
     
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
     $this->load->view('home_view', $data);
   }else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }


 }
  function cadastrar(){	 
	if(!$_SESSION['login']) {
				redirect('login', 'refresh');
		}
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$id_iptu = $this->input->get('id');
	$data['inscricao'] = $this->cnd_imobiliaria_model->listarInscricaoByIptu($id_iptu);
	$data['emitentes'] = $this->iptu_model->listarEmitentes($idContratante);
 	$data['perfil'] = $session_data['perfil'];
	if(empty($session_data['visitante'])){

		$data['visitante'] = 0;

	}else{

		$data['visitante'] = $session_data['visitante'];	

	}
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_cnd_imob_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function enviar_pend(){		

	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/cnd_imob_pend/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = $id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";		
	$dadosArquivo = $this->cnd_imobiliaria_model->listarInscricaoById($id);
		if($dadosArquivo[0]->arquivo_pendencias){
			$b = getcwd();
			$a = @unlink($b.'/assets/cnd_imob_pend/'.$dadosArquivo[0]->arquivo);
		}
		
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{	
	
		$session_data = $_SESSION['login'];
		$dadosLog = array(
		'id_contratante' => $session_data['id_contratante'],
		'tabela' => 'cnd_imob',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo CND Imobiliária - Pendência',
		'data' => date("Y-m-d"),
		'upload' => 1
		);
		$this->log_model->log($dadosLog);
		
		
		$dados = array('arquivo_pendencias' => $id.'.'.$extensao);
		$this->cnd_imobiliaria_model->atualizar($dados,$id);
			
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}

	 
}

 function enviar_pend_old(){
		
		$id = $this->input->post('id');
		
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnd_imob_pend/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		$config['overwrite'] = 'true';	
		
		$this->load->library('upload', $config);

		$this->upload->initialize($config);
		$field_name = "userfile";
		
		$dadosArquivo = $this->cnd_imobiliaria_model->listarInscricaoById($id);
		if($dadosArquivo[0]->arquivo_pendencias){
			$b = getcwd();
			//unlink("teste.txt");
			//$this->config->base_url().'assets/cnd_imob_pend/'.$dadosArquivo[0]->arquivo_pendencias;exit;
			$a = @unlink($b.'/assets/cnd_imob_pend/'.$dadosArquivo[0]->arquivo_pendencias);
		}
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			
			$data['mensagem'] = $this->upload->display_errors();
		}else{
			$dados = array('arquivo_pendencias' => $id.'.'.$extensao);
				
			$this->cnd_imobiliaria_model->atualizar($dados,$id);
			$data = array('upload_data' => $this->upload->data($field_name));
			$this->session->set_flashdata('mensagem','Upload Feito com Sucesso');
		}
		$modulo = $_SESSION["CNDImob"];
		if(empty($modulo)){
			$modulo ='listar';
		}

		redirect('/cnd_imob/'.$modulo);		
 }
 
 function enviar(){		

	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/cnds/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = $id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";		
	$dadosArquivo = $this->cnd_imobiliaria_model->listarInscricaoById($id);
		if($dadosArquivo[0]->arquivo){
			$b = getcwd();
			//unlink("teste.txt");
			//$this->config->base_url().'assets/cnd_imob_pend/'.$dadosArquivo[0]->arquivo_pendencias;exit;
			$a = @unlink($b.'/assets/cnds/'.$dadosArquivo[0]->arquivo);
		}
		
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{	
		$session_data = $_SESSION['login'];
		$dadosLog = array(
		'id_contratante' => $session_data['id_contratante'],
		'tabela' => 'cnd_imob',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo CND Imobiliária',
		'data' => date("Y-m-d"),
		'upload' => 1
		);
		$this->log_model->log($dadosLog);
		
		$dados = array(
			'arquivo' => $id.'.'.$extensao,
			'possui_cnd' => 1
			);
				
		$this->cnd_imobiliaria_model->atualizar($dados,$id);
					
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}

//redirect('/iptu/listar', 'refresh');		 
} 

 function enviar_old(){
		
		$id = $this->input->post('id');
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnds/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		$config['overwrite'] = 'true';	
		
		$this->load->library('upload', $config);

		// Alternativamente você pode configurar as preferências chamando a função initialize. É útil se você auto-carregar a classe:
		$this->upload->initialize($config);
		$field_name = "userfile";
		
		$dadosArquivo = $this->cnd_imobiliaria_model->listarInscricaoById($id);
		if($dadosArquivo[0]->arquivo){
			$b = getcwd();
			//unlink("teste.txt");
			//$this->config->base_url().'assets/cnd_imob_pend/'.$dadosArquivo[0]->arquivo_pendencias;exit;
			$a = @unlink($b.'/assets/cnds/'.$dadosArquivo[0]->arquivo);
		}
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			
			$data['mensagem'] = $this->upload->display_errors();
		}else{
			$dados = array(
			'arquivo' => $id.'.'.$extensao,
			'possui_cnd' => 1
			);
				
			$this->cnd_imobiliaria_model->atualizar($dados,$id);
			$data = array('upload_data' => $this->upload->data($field_name));
			$this->session->set_flashdata('mensagem','Upload Feito com Sucesso');
			
		}
	
		$modulo = $_SESSION["CNDImob"];
		if(empty($modulo)){
			$modulo ='listar';
		}
	
		
		redirect('/cnd_imob/'.$modulo);
		
 }
 function upload_cnd(){
	if(!$_SESSION['login']) {
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];  
	$id = $this->input->get('id');
	$dados = $this->cnd_imobiliaria_model->listarInscricaoById($id);
	$data['dataEmissao'] = $this->cnd_imobiliaria_model->listarTodasDataEmissao($id,'imob');
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
	$this->load->view('upload_cnd', $data);
	$this->load->view('footer_pages_view');
 }
 
function upload_cnd_pend(){
	if(!$_SESSION['login']) {
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];
	$id = $this->input->get('id'); 
	$dados = $this->cnd_imobiliaria_model->listarInscricaoById($id);
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
	$this->load->view('upload_cnd_pend', $data);
	$this->load->view('footer_pages_view');
}
 
 function ver(){
	
	
 if(!$_SESSION['login']) {
	redirect('login', 'refresh');
 }
 $session_data = $_SESSION['login'];

  
  $id = $this->input->get('id');
  
  $data['imovel'] = $this->cnd_imobiliaria_model->listarInscricaoById($id);

	
  $data['perfil'] = $session_data['perfil'];

 $this->load->view('header_pages_view',$data);

  $this->load->view('ver-cnd', $data);

 $this->load->view('footer_pages_view');
				
 
 }
 
 

 function cadastrar_cnd_imob(){
 
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];


	


	$idContratante = $_SESSION['cliente'] ;

	$possui_cnd = $this->input->post('possui_cnd');	
	

	$id_iptu = $this->input->post('id_iptu');	
	
	if(empty($id_iptu)){
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
		redirect('/iptu/listar');
	}
	
	$data_vencto = $this->input->post('data_vencto');
	
	if(!empty($data_vencto )){
		$arrDataVencto = explode("/",$data_vencto);
		$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
	}else{
		$dataVencto ='0000-00-00';
	}
	


	
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');	
	
	if($possui_cnd == 1){
		
		$dados = array(

			'id_iptu' => $id_iptu,
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,

		);
		$data_emissao = $this->input->post('data_emissao');
	
		if(!empty($data_emissao )){
			$arrDataEmissao = explode("/",$data_emissao);
			$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		}else{
			$dataEmissao ='0000-00-00';
		}
		
		
	
		
	
		$_SESSION["CNDImob"]='listarPorTipoSim';
	}elseif ($possui_cnd == 2){
		$dados = array(
			'id_iptu' => $id_iptu,
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
		);
		$_SESSION["CNDImob"] = 'listarPorTipoNao';
	
	}else{

	$dados = array(
			'id_iptu' => $id_iptu,
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
		);
		$_SESSION["CNDImob"] = 'listarPorTipoPendencia';
	}

    $id = $this->cnd_imobiliaria_model->add($dados);
	if($id){
		$this->db->cache_off();
		$this->session->set_flashdata('mensagem','Cadastro Feito com sucesso');
		if($possui_cnd == 1){
			
			$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'imob',
			'data_emissao' =>$dataEmissao,
			);
			
			$this->cnd_imobiliaria_model->addDataEmissao($dadosDataEmissao,$id,'imob');
		
			redirect('/cnd_imob/upload_cnd?id='.$id, 'refresh');
		}elseif ($possui_cnd == 2){
			redirect('/cnd_imob/listar', 'refresh');
		}else{
			redirect('/cnd_imob/upload_cnd_pend?id='.$id, 'refresh');
		}
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	redirect('/cnd_imob/listar', 'refresh');

 }

  function excluir(){
		if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];

	$id = $this->input->get('id');
	
	$idContratante = $_SESSION['cliente'] ;
	$dados = array('ativo' => 0);
	if($this->iptu_model->atualizar($dados,$id)) {
		$this->session->set_flashdata('mensagem','Cadastro Inativo com Sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	redirect('/cnd_imob/listar', 'refresh');
 }
 

 function inativar(){
		if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];

	
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
  
	$id = $this->input->get('id');

	$dados = array('ativo' => 1);
	$dadosAlterados ='';
	
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	if($podeExcluir[0]['total'] == 1){		
		$dadosAlterados .= ' - CND Imob. Excluida';
	
		//print'-'.$dadosAlterados;exit;
		$dadosLog = array(
		'id_contratante' => $idContratante,
		'tabela' => 'cnd_imob',
		'id_usuario' => $idUsuario,
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => $dadosAlterados,
		'data' => date("Y-m-d"),
		);
		$this->log_model->log($dadosLog);
		
		$this->cnd_imobiliaria_model->excluirFisicamente($id);
		$_SESSION['mensagemImovel'] =  CADASTRO_APAGADO;
		
	}else{
		$dadosAlterados .= ' - Status Ativo';
		
		//print'-'.$dadosAlterados;exit;
		$dadosLog = array(
		'id_contratante' => $idContratante,
		'tabela' => 'cnd_imob',
		'id_usuario' => $idUsuario,
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => $dadosAlterados,
		'data' => date("Y-m-d"),
		);
		$this->log_model->log($dadosLog);
		
		
		if($this->cnd_imobiliaria_model->atualizar($dados,$id)) {
			$this->session->set_flashdata('mensagem','Cadastro Atualizado com Sucesso');
		}else{	
			$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
		}
		
		$dadosImovel = $this->cnd_imobiliaria_model->listarCidadeEstadoById($id);
		
		$_SESSION["cidadeCNDIBD"] = $dadosImovel[0]->cidade;
		$_SESSION["estadoCNDIBD"] = $dadosImovel[0]->estado;
		$_SESSION["idCNDIBD"] =  $dadosImovel[0]->id;
	}
	
	$modulo = $_SESSION["CNDImob"];
	//print_r($dadosImovel);exit;
	redirect('/cnd_imob/'.$modulo, 'refresh');
				

 }
 
 function ativar(){
		if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];


	
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	
	$id = $this->input->get('id');

	$dados = array('ativo' => 0);

	$dadosAlterados ='';
	
	$dadosAlterados .= ' - Status Inativo';
	
	//print'-'.$dadosAlterados;exit;
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'cnd_imob',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => $dadosAlterados,
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	

	if($this->cnd_imobiliaria_model->atualizar($dados,$id)) {
		$_SESSION['mensagemCNDIMOB'] =  CADASTRO_ATIVO;	
	}else{	
		$_SESSION['mensagemCNDIMOB'] = ERRO;
	}
	
	$dadosImovel = $this->cnd_imobiliaria_model->listarCidadeEstadoById($id);
	$_SESSION["cidadeCNDIBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDIBD"] = $dadosImovel[0]->estado;
	$_SESSION["idCNDIBD"] =  $dadosImovel[0]->id;
	
	
	$modulo = $_SESSION["CNDImob"];

	
	redirect('/cnd_imob/'.$modulo, 'refresh');

 }
 

 function atualizar_cnd(){
		if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];

    
	
	
	
	

	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	
	
	$id = $this->input->post('id_cnd');	
	$possui_cnd = $this->input->post('possui_cnd');
	
	$data_vencto = $this->input->post('data_vencto');	
	
	$arrDataVencto = explode("/",$data_vencto);	
	$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
	
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');
	
	$dadosImovel = $this->cnd_imobiliaria_model->listarCidadeEstadoById($id);
	
	
	
	$_SESSION["cidadeCNDIBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDIBD"] = $dadosImovel[0]->estado;
	$_SESSION["idCNDIBD"] = $dadosImovel[0]->id;
	$modulo = $_SESSION["CNDImob"];

	
	
	if($possui_cnd == 1){
		$dados = array(
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
		);
		$data_emissao = $this->input->post('data_emissao');	
		if(empty($data_emissao)){
			$this->session->set_flashdata('mensagem','Data de Emiss&atilde;o n&atilde;o pode ser vazia');
			redirect('/cnd_imob/'.$modulo);	
			exit;
		}
		$arrDataEmissao = explode("/",$data_emissao);	
		$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		
		$dadosDataDb = $this->cnd_imobiliaria_model->listarDataEmissao($id,'imob');
		
		$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'imob',
			'data_emissao' =>$dataEmissao,
			);
        $isArray =  is_array($dadosDataDb) ? '1' : '0';
		if($isArray == 1){
		
			if($dadosDataDb[0]->data_emissao <> $dataEmissao ){
				$this->cnd_imobiliaria_model->addDataEmissao($dadosDataEmissao,$id,'imob');
			}
			
			
		}else{
			$this->cnd_imobiliaria_model->addDataEmissao($dadosDataEmissao,$id,'imob');
		}

		$_SESSION["CNDImob"] = 'listarPorTipoSim';
	}elseif ($possui_cnd == 2){
		$dados = array(
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
		);
		$_SESSION["CNDImob"] = 'listarPorTipoNao';
	
	}else{
	$dados = array(
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
		);
		$_SESSION["CNDImob"] = 'listarPorTipoPendencia';
	}

	
	
	$dadosAtuais = $this->cnd_imobiliaria_model->listarCNDById($id);
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
	//print'-'.$dadosAlterados;exit;
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'cnd_imob',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => $dadosAlterados,
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
	
	$this->cnd_imobiliaria_model->atualizar($dados,$id);
	

	
	if($possui_cnd == 1){
		redirect('/cnd_imob/upload_cnd?id='.$id);
	}elseif ($possui_cnd == 2){
		$this->session->set_flashdata('mensagem','Cadastro Atualizado com sucesso');
		redirect('/cnd_imob/'.$modulo);	
	}else{
		redirect('/cnd_imob/upload_cnd_pend?id='.$id);
	}
	

 }


 

  function editar(){	
  
		if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];

	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$id = $this->input->get('id');
	
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->iptu_model->listarImovelByIdIptu($id);
	
	$dadosImovel = $this->cnd_imobiliaria_model->listarCidadeEstadoById($id);
	
	$_SESSION["cidadeCNDIBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDIBD"] = $dadosImovel[0]->estado;
	$_SESSION["idCNDIBD"] = $dadosImovel[0]->id;
	$_SESSION["CNDImob"]='listarPorTipo';
	
	
	if($dadosImovel[0]->cidade == 'possui_cnd'){
		$url = 'listarPorTipoSim';
	}elseif($dadosImovel[0]->cidade == 'Nao'){
		$url = 'listarPorTipoNao';
	}else{
		$url = 'listarPorTipoPendencia';
	}
	
	$modulo = $url ;
	
	$dadosDataDb = $this->cnd_imobiliaria_model->listarDataEmissao($id,'imob');
	
	$data['data_emissao'] = $dadosDataDb;
	
	$data['emitentes'] = $this->iptu_model->listarEmitentes($idContratante);
	$data['imovel'] = $this->cnd_imobiliaria_model->listarInscricaoById($id);
	$data['info_inc'] = $this->informacoes_inclusas_iptu_model->listar();
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_cnd_imob_view', $data);
	$this->load->view('footer_pages_view');


 }
function export_mun(){	
 	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];

	$id = $this->input->post('id_mun_export');
	$possuiCnd = $this->input->post('possuiCnd');
	
	$idContratante = $_SESSION['cliente'] ;
	
	
	$result = $this->cnd_imobiliaria_model->listarIptuCsvByCidade($id,$possuiCnd);
	//print_r($this->db->last_query());exit;
	//$result = $this->iptu_model->listarIptuCsv($idContratante);
	
	//print_r($result);exit;
	$file="cnd_imob.xls";

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
			<td>Nome Im&oacute;vel</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Nome Prop.</td>
			<td>CPF/CNPJ</td>
			<td>Possui CND</td>
			<td>Data Vencimento CND</td>
			<td>Observa&ccedil;&otilde;es da CND</td>
			<td>Plano de A&ccedil;&atilde;o</td>
			<td>Cidade</td>
			<td>Estado</td>
			<td>Data de Emiss&atilde;o </td>				
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>								
			</tr>
			";
			
			
	 
			  foreach($result as $key => $iptu){ 	
			  
			  $dadosLog = $this->log_model->listarLog($iptu->id,'cnd_imob');				
			  $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
			  $datasEmissao = $this->cnd_imobiliaria_model->listarTodasDataEmissao($iptu->id_cnd,'imob');
				$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';	

				if($iptu->ativo == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->cnd == 1){									
					$possuiCnd ='Sim';
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}elseif($iptu->cnd == 2){
					$possuiCnd ='N&atildeo';	
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}elseif($iptu->cnd == 3){
					$possuiCnd ='Pend&ecirc;ncia';
					$arrDataVencto = explode("-",$iptu->data_pendencias);
					$dataVencto =$arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}else{
					$possuiCnd ='Nada Consta';
					$dataVencto ='';
				}
					/*
				if($iptu->cnd){									
					if($iptu->cnd == 1){									
						$possuiCnd ='Sim, sem Pend&ecirc;ncias';
						$arrDataVencto = explode("-",$iptu->data_vencto);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}else{
						$possuiCnd ='Sim, com Pend&ecirc;ncias';	
						$arrDataVencto = explode("-",$iptu->data_pendencias);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}
				}else{
					$possuiCnd ='Sem registro de cnd ou pend&ecirc;ncias';
					$dataVencto ='';
				}
				*/
				
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->id_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'</td>";
				$test .= "<td>".utf8_decode($iptu->razao_social)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				
				$test .= "<td>".utf8_decode($possuiCnd)."</td>";
				$test .= "<td>".$dataVencto."</td>";
				$test .= "<td>".utf8_decode($iptu->obs_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->plano)."</td>";
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
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
 
 function export_est(){	
  
  	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];


	$id = $this->input->post('id_estado_export');
	$possuiCnd = $this->input->post('possuiCnd');
	
	$idContratante = $_SESSION['cliente'] ;
	
	
	$result = $this->cnd_imobiliaria_model->listarIptuCsvByEstado($id,$possuiCnd);
	
	//$result = $this->iptu_model->listarIptuCsv($idContratante);
	
	//print_r($result);exit;
	$file="cnd_imob.xls";

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
			<td>Nome Im&oacute;vel</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Nome Prop.</td>
			<td>CPF/CNPJ</td>
			<td>Possui CND</td>
			<td>Data Vencimento CND</td>
			<td>Observa&ccedil;&otilde;es da CND</td>
			<td>Plano de A&ccedil;&atilde;o</td>
			<td>Cidade</td>
			<td>Estado</td>
			<td>Data de Emiss&atilde;o </td>				
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>								
			</tr>
			";
			
			
	 
			  foreach($result as $key => $iptu){ 	
			  $dadosLog = $this->log_model->listarLog($iptu->id_iptu,'cnd_imob');			  
			  $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
				$datasEmissao = $this->cnd_imobiliaria_model->listarTodasDataEmissao($iptu->id_cnd,'imob');
				$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';				  
			  

				if($iptu->ativo == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->cnd == 1){									
					$possuiCnd ='Sim';
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];

				}elseif($iptu->cnd == 2){
					$possuiCnd ='N&atildeo';	
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}elseif($iptu->cnd == 3){
					$possuiCnd ='Pend&ecirc;ncia';
					$arrDataVencto = explode("-",$iptu->data_pendencias);
					$dataVencto =$arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}else{
					$possuiCnd ='Nada Consta';
					$dataVencto ='';
				}
					/*
				if($iptu->cnd){									
					if($iptu->cnd == 1){									
						$possuiCnd ='Sim, sem Pend&ecirc;ncias';
						$arrDataVencto = explode("-",$iptu->data_vencto);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}else{
						$possuiCnd ='Sim, com Pend&ecirc;ncias';	
						$arrDataVencto = explode("-",$iptu->data_pendencias);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}
				}else{
					$possuiCnd ='Sem registro de cnd ou pend&ecirc;ncias';
					$dataVencto ='';
				}
				*/
				
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->id_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'</td>";
				$test .= "<td>".utf8_decode($iptu->razao_social)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				
				$test .= "<td>".utf8_decode($possuiCnd)."</td>";
				$test .= "<td>".$dataVencto."</td>";
				$test .= "<td>".utf8_decode($iptu->obs_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->plano)."</td>";
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";

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
 
 function csvGrafico($result){
	 //print_r($result);exit;
	$file="cnd_imob.xls";

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
			<td>Nome Im&oacute;vel</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Nome Prop.</td>
			<td>CPF/CNPJ</td>
			<td>Possui CND</td>
			<td>Data Vencimento CND</td>
			<td>Cidade</td>
			<td>Estado</td>
			
			</tr>
			";
			
			
	 
			  foreach($result as $key => $iptu){ 	
			   $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_imob');			   				
			   $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
				$datasEmissao = $this->cnd_imobiliaria_model->listarTodasDataEmissao($iptu->id_cnd,'imob');
				$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';
			   
				if($iptu->ativo == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->cnd == 1){									
					$possuiCnd ='Sim';
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}elseif($iptu->cnd == 2){
					$possuiCnd ='Não';	
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}elseif($iptu->cnd == 3){
					$possuiCnd ='Pend&ecirc;ncia';
					$arrDataVencto = explode("-",$iptu->data_pendencias);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}else{
					$possuiCnd ='Nada Consta';
					$dataVencto = '00-00-0000';
				}
					/*
				if($iptu->cnd){									
					if($iptu->cnd == 1){									
						$possuiCnd ='Sim, sem Pend&ecirc;ncias';
						$arrDataVencto = explode("-",$iptu->data_vencto);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}else{
						$possuiCnd ='Sim, com Pend&ecirc;ncias';	
						$arrDataVencto = explode("-",$iptu->data_pendencias);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}
				}else{
					$possuiCnd ='Sem registro de cnd ou pend&ecirc;ncias';
					$dataVencto ='';
				}
				*/
				
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'</td>";
				$test .= "<td>".utf8_decode($iptu->razao_social)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";
				$test .= "<td>".utf8_decode($possuiCnd)."</td>";
				$test .= "<td>".$dataVencto."</td>";				
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
								
				$test .= "</tr>";
			
				
			}
			$test .='</table>';
		}

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
	 
 }	 
  function export_total_imob(){	
  
 	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];

	$id = $this->input->post('id_imovel_export');
	$possuiCnd = 'X';
	
	$idContratante = $_SESSION['cliente'] ;
	
	
	$result = $this->cnd_imobiliaria_model->listarIptuCsv($idContratante,$possuiCnd);
	//$result = $this->iptu_model->listarIptuCsv($idContratante);
	
	$this->csvGrafico($result);
	
		
 }

  function export(){	
  
 	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];

	$id = $this->input->post('id_imovel_export');
	$possuiCnd = $this->input->post('possuiCnd');
	
	$idContratante = $_SESSION['cliente'] ;
	
	
	if($id == 0){

		$result = $this->cnd_imobiliaria_model->listarIptuCsv($idContratante,$possuiCnd);
		
	}else{

		$result = $this->cnd_imobiliaria_model->listarIptuCsvById($id,$possuiCnd);
	}
	
	//$result = $this->iptu_model->listarIptuCsv($idContratante);
	
	//print_r($result);exit;
	$file="cnd_imob.xls";

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
			<td>Nome Im&oacute;vel</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Nome Prop.</td>
			<td>CPF/CNPJ</td>
			<td>Possui CND</td>
			<td>Data Vencimento CND</td>
			<td>Observa&ccedil;&otilde;es da CND</td>
			<td>Plano de A&ccedil;&atilde;o</td>
			<td>Cidade</td>
			<td>Estado</td>
			<td>Data de Emiss&atilde;o </td>							
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>			
			<td>Dados Alterados </td>	
			
			</tr>
			";
			
			
	 
			  foreach($result as $key => $iptu){ 	
			   $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_imob');			   				
			   $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
				$datasEmissao = $this->cnd_imobiliaria_model->listarTodasDataEmissao($iptu->id_cnd,'imob');
				$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';
			   
				if($iptu->ativo == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->cnd == 1){									
					$possuiCnd ='Sim';
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}elseif($iptu->cnd == 2){
					$possuiCnd ='Não';	
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}elseif($iptu->cnd == 3){
					$possuiCnd ='Pend&ecirc;ncia';
					$arrDataVencto = explode("-",$iptu->data_pendencias);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}else{
					$possuiCnd ='Nada Consta';
					$dataVencto = '00-00-0000';
				}
					/*
				if($iptu->cnd){									
					if($iptu->cnd == 1){									
						$possuiCnd ='Sim, sem Pend&ecirc;ncias';
						$arrDataVencto = explode("-",$iptu->data_vencto);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}else{
						$possuiCnd ='Sim, com Pend&ecirc;ncias';	
						$arrDataVencto = explode("-",$iptu->data_pendencias);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}
				}else{
					$possuiCnd ='Sem registro de cnd ou pend&ecirc;ncias';
					$dataVencto ='';
				}
				*/
				
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->id_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'</td>";
				$test .= "<td>".utf8_decode($iptu->razao_social)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";
				$test .= "<td>".utf8_decode($possuiCnd)."</td>";
				$test .= "<td>".$dataVencto."</td>";				
				$test .= "<td>".utf8_decode($iptu->obs_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->plano)."</td>";				
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
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
 
 function buscaCidade(){	
	$id = $this->input->get('estado');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarCidadeByEstado($id,$tipo);
	
	
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
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarTodasCidades($tipo);
	
	
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
	$result = $this->cnd_imobiliaria_model->listarImovelByEstado($id,$tipo);
	
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
 
 function buscaImovel(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarImovelByCidade($id,$tipo);
	
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
 function limpar_filtro(){	
	  
	$_SESSION["cidadeCNDIBD"] = 0;
	$_SESSION["estadoCNDIBD"] = 0;
	$_SESSION["idCNDIBD"]  = 0;
	
	$modulo = $_SESSION["CNDImob"];
	redirect('/cnd_imob/'.$modulo);	

 }
 function busca(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarImovelByImovel($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_inscr == 0){
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
	}elseif($iptu->possui_cnd == 3){
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Sem Definição';
		$dataVencto = '00-00-0000';	
	}
	 
								
	  $base = $this->config->base_url().'index.php';	
	  $retorno .="<tr style='color:$cor'>";
      $retorno .="<td width='30%'><a href='#'>".$iptu->nome."</a></td>";
      $retorno .="<td width='17%'class='hidden-phone'>";
	  
		if($iptu->possui_cnd == 1){
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}elseif($iptu->possui_cnd == 3){	
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}else{
			$retorno .=$iptu->inscricao;
		}
		
		$retorno .="</td>";
		$retorno .="<td width='14%'class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%'class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='13%'>";            
		if( ($iptu->possui_cnd == 1 )) {
			$retorno .="<a href='$base/cnd_imob/upload_cnd?id=$iptu->id' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  
		}else{
			$retorno .="<a href='$base/cnd_imob/upload_cnd_pend?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  								
		}		
		$retorno .="<a href='$base/cnd_imob/editar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_imob/inativar?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_imob/ativar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
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
	$result = $this->cnd_imobiliaria_model->listarImovelByUf($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='6'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	 if($iptu->status_inscr == 0){
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
	}elseif($iptu->possui_cnd == 3){
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Sem Definição';
		$dataVencto = '00-00-0000';	
	}
									 
	
	 $base = $this->config->base_url().'index.php';
	  $retorno .="<tr style='color:$cor'>";
      $retorno .="<td width='30%'><a href='#'>".$iptu->nome."</a></td>";
      $retorno .="<td width='17%'class='hidden-phone'>";
		if($iptu->possui_cnd == 1){
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}elseif($iptu->possui_cnd == 3){	
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}else{
			$retorno .=$iptu->inscricao;
		}
		$retorno .="</td>";
		$retorno .="<td width='14%'class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%'class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='13%'>";            
		if( ($iptu->possui_cnd == 1 )) {
			$retorno .="<a href='$base/cnd_imob/upload_cnd?id=$iptu->id' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  
		}else{
			$retorno .="<a href='$base/cnd_imob/upload_cnd_pend?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  								
		}		
		$retorno .="<a href='$base/cnd_imob/editar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_imob/inativar?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_imob/ativar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }

 
 function buscaPendentes(){	
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarImovelPendente();
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_inscr == 0){
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
      $retorno .="<td width='30%'><a href='#'>".$iptu->nome."</a></td>";
      $retorno .="<td width='17%'class='hidden-phone'>";
		if($iptu->possui_cnd == 1){
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}elseif($iptu->possui_cnd == 3){	
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}else{
			$retorno .=$iptu->inscricao;
		}
		$retorno .="</td>";
		$retorno .="<td width='14%'class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%'class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='13%'>";            
		if( ($iptu->possui_cnd == 1 )) {
			$retorno .="<a href='$base/cnd_imob/upload_cnd?id=$iptu->id' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  
		}else{
			$retorno .="<a href='$base/cnd_imob/upload_cnd_pend?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  								
		}		
		$retorno .="<a href='$base/cnd_imob/editar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_imob/inativar?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_imob/ativar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
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
	$result = $this->cnd_imobiliaria_model->listarImovelByMunicipio($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_inscr == 0){
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
	}elseif($iptu->possui_cnd == 3){
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Sem Definição';
		$dataVencto = '00-00-0000';	
	}
	 
	

								
	  $base = $this->config->base_url().'index.php';	
	  $retorno .="<tr style='color:$cor'>";
      $retorno .="<td width='30%'><a href='#'>".$iptu->nome."</a></td>";
      $retorno .="<td width='17%'class='hidden-phone'>";
		if($iptu->possui_cnd == 1){
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}elseif($iptu->possui_cnd == 3){	
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}else{
			$retorno .=$iptu->inscricao;
		}
		$retorno .="</td>";
		$retorno .="<td width='14%'class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%'class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='13%'>";            
		if( ($iptu->possui_cnd == 1 )) {
			$retorno .="<a href='$base/cnd_imob/upload_cnd?id=$iptu->id' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  
		}else{
			$retorno .="<a href='$base/cnd_imob/upload_cnd_pend?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  								
		}		
		$retorno .="<a href='$base/cnd_imob/editar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_imob/inativar?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_imob/ativar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 


function dados_agrupados(){	
 
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];
  
	$cidade = '0';
	$estado = '0';
	
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['imoveis'] = $this->cnd_imobiliaria_model->listarImovel($idContratante,'X');
	
	$data['estados'] = $this->cnd_imobiliaria_model->listarEstado($idContratante,'X');
	
	$ano = date('Y');	
	//$ano = '2016';
	$situacao = $this->cnd_imobiliaria_model->situacao();
	$situacaoSim = array();
	$situacaoNao = array();
	$situacaoPend = array();
	$situacaoNC = array();
	
	$i=1;
	foreach($situacao as $sit){
		$result = $this->cnd_imobiliaria_model->contaSituacao($idContratante,$ano,1,$sit->id);
		$situacaoSim[$i]['situacao'] = $sit->descricao;
		$situacaoSim[$i]['total'] = $result[0]->total;
		$i++;
	}
	// ultimo parametro 1 para vigente, 2 para não vigente
	$data['vigentes'] = $this->cnd_imobiliaria_model->contaVigente($idContratante,$ano,1,1);
	//print_r($this->db->last_query());
	$data['naoVigentes'] = $this->cnd_imobiliaria_model->contaVigente($idContratante,$ano,1,2);
	//print_r($this->db->last_query());exit;
	
	$i=1;
	foreach($situacao as $sit){
		$result = $this->cnd_imobiliaria_model->contaSituacao($idContratante,$ano,2,$sit->id);
		$situacaoNao[$i]['situacao'] = $sit->descricao;
		$situacaoNao[$i]['total'] = $result[0]->total;
		$i++;
	}
		
	$i=1;
	foreach($situacao as $sit){
		$result = $this->cnd_imobiliaria_model->contaSituacao($idContratante,$ano,3,$sit->id);
		$situacaoPend[$i]['situacao'] = $sit->descricao;
		$situacaoPend[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($situacao as $sit){
		$result = $this->cnd_imobiliaria_model->contaSituacao($idContratante,$ano,4,$sit->id);
		$situacaoNC[$i]['situacao'] = $sit->descricao;
		$situacaoNC[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	
	$data['situacaoSim'] = $situacaoSim;
	$data['situacaoNao'] = $situacaoNao;
	$data['situacaoPend'] = $situacaoPend;
	$data['situacaoNC'] = $situacaoNC;
	
	
	//$resultTodas = $this->cnd_imobiliaria_model->contaTodasCnd($idContratante,$ano);
	$data['modulo'] = 'cnd_imob';
	$data['ano_ref'] =  $ano;
	$data['iptus'] = $this->cnd_imobiliaria_model->contaCnd($idContratante,$ano);
	//$data['todasCnd'] = $resultTodas;

	$data['perfil'] = $session_data['perfil'];
	$data['nome_modulo'] = 'CND Imobiliária';
	
	$_SESSION["CNDImob"]='';
  	$_SESSION["cidadeCNDIBD"] = 0;
	$_SESSION["estadoCNDIBD"] = 0;
	$_SESSION["idCNDIBD"] =0;
	
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('dados_agrupados_cnd_imob_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
  function listarLoja(){	
 
	$_SESSION["status_iptu"]=4;
	
	redirect('iptu/listar', '');

 }
 
 function listarPorTipo(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
  
	$cidade = '0';
	$estado = '0';
	
	$tipo  = '0';
	
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['imoveis'] = $this->cnd_imobiliaria_model->listarImovel($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_imobiliaria_model->listarEstado($tipo);
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	

	$result = $this->cnd_imobiliaria_model->listarCndTipo($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado,$tipo);

	$total = $this->cnd_imobiliaria_model->somarTodosTipo($idContratante,0,0,$tipo);

	$data['paginacao'] = createPaginateTipo('cnd_imob', $total[0]->total);

	$data['tipo'] = $tipo;
	
	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];
	$_SESSION["CNDImob"]='listarPorTipo';
  
	$cidadeBD = $_SESSION["cidadeCNDIBD"];
	$estadoBD = $_SESSION["estadoCNDIBD"];
	$idCNDIBD = $_SESSION["idCNDIBD"] ;
	
	if(empty($cidadeBD)){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION["cidadeCNDIBD"];
	}
	if(empty($estadoBD)){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] =$_SESSION["estadoCNDIBD"];
	}
	if(empty($idCNDIBD)){
		$data['idCNDIBD'] = 0;
	}else{
		$data['idCNDIBD'] = $_SESSION["idCNDIBD"];
	}
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_imobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function listarComParam(){	
 
	$tipo = $this->input->get('tipo');	
	if($tipo == 'Sim'){
		$url = 'listarPorTipoSim';
	}elseif($tipo == 'Nao'){
		$url = 'listarPorTipoNao';
	}else{
		$url = 'listarPorTipoPendencia';
	}

	$_SESSION["cidadeCNDIBD"] =0;
	$_SESSION["estadoCNDIBD"]=0;
	$_SESSION["idCNDIBD"] =0;
	
	redirect('/cnd_imob/'.$url, '');

 }
 
 function listarPorTipoPendencia(){	
 
 if(!$_SESSION['login']){
		redirect('login', 'refresh');
  }
  $session_data = $_SESSION['login'];
	$cidade = '0';
	$estado = '0';
	
	$tipo  = 3;
	
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];
	$data['imoveis'] = $this->cnd_imobiliaria_model->listarImovel($idContratante,$tipo);
	$data['estados'] = $this->cnd_imobiliaria_model->listarEstado($idContratante,$tipo);
	$data['cidades'] = $this->cnd_imobiliaria_model->listarCidade($idContratante,$tipo);
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;
		$data['idCNDIBD'] = 0;
		$result = $this->cnd_imobiliaria_model->listarCndTipo($idContratante,$cidade,$estado,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		$data['cidadeBD'] = $municipioListar;
		$data['estadoBD'] = $estadoListar;
		$data['idCNDIBD'] = $idImovelListar;
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_imobiliaria_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_imobiliaria_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_imobiliaria_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}
	}

	$data['tipo'] = $tipo;
	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$_SESSION["CNDImob"]='listarPorTipoPendencia';
	$data['CNDImob'] = 'listarPorTipoPendencia';
  
	if(!empty($_SESSION["mensagemCNDIMOB"])){
		$data['mensagemCNDIMOB'] =  $_SESSION["mensagemCNDIMOB"];
	}else{
		$data['mensagemCNDIMOB'] =  '';
	}
	

	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_imobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function listarPorSituacao(){	
 
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];

  
	$cidade = '0';
	$estado = '0';
	
	
	$tipo  = $this->input->get('tipo');
	$situacao  = $this->input->get('situacao');
		
	$idContratante = $_SESSION['cliente'] ;		
	$data['perfil'] = $session_data['perfil'];
	$data['imoveis'] = $this->cnd_imobiliaria_model->listarImovel($idContratante,$tipo);
	$data['estados'] = $this->cnd_imobiliaria_model->listarEstado($tipo);
	
	
	$result =  $this->cnd_imobiliaria_model->listarCndTipoSituacao($idContratante,$situacao,$tipo);
	//print_r($this->db->last_query());exit;
	$data['tipo'] = $tipo;
	$data['iptus'] = $result;
	$data['perfil'] = $session_data['perfil'];
 
	$_SESSION["CNDImob"]='listarPorTipoSim';
	$data['CNDImob'] = 'listarPorTipoSim';
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_cnd_imobiliaria_tipo_view', $data);
	$this->load->view('footer_pages_view');
	

 }
 
 
 function listarVigentes(){	
 
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];

  
	$cidade = '0';
	$estado = '0';
	
	
	$situacao  = $this->input->get('situacao');
		
	$idContratante = $_SESSION['cliente'] ;		
	$data['perfil'] = $session_data['perfil'];
	$data['imoveis'] = $this->cnd_imobiliaria_model->listarImovel($idContratante,1);
	$data['estados'] = $this->cnd_imobiliaria_model->listarEstado($idContratante,1);
	
	
	$result =  $this->cnd_imobiliaria_model->listarCndVigente($idContratante,$situacao);
	//print_r($this->db->last_query());exit;
	$data['tipo'] = 1;
	$data['iptus'] = $result;
	$data['perfil'] = $session_data['perfil'];
 
	$_SESSION["CNDImob"]='listarPorTipoSim';
	$data['CNDImob'] = 'listarPorTipoSim';
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_cnd_imobiliaria_tipo_view', $data);
	$this->load->view('footer_pages_view');
	

 }
 
 function listarPorTipoSim(){	
 
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];

  
	$cidade = '0';
	$estado = '0';
	
	$tipo  = 1;
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$idContratante = $_SESSION['cliente'] ;		
	$data['perfil'] = $session_data['perfil'];
	$data['imoveis'] = $this->cnd_imobiliaria_model->listarImovel($idContratante,$tipo);
	$data['estados'] = $this->cnd_imobiliaria_model->listarEstado($idContratante,$tipo);
	$data['cidades'] = $this->cnd_imobiliaria_model->listarCidade($idContratante,$tipo);
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;
		$data['idCNDIBD'] = 0;
		
		$result = $this->cnd_imobiliaria_model->listarCndTipo($idContratante,$cidade,$estado,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		$data['cidadeBD'] = $municipioListar;
		$data['estadoBD'] = $estadoListar;
		$data['idCNDIBD'] = $idImovelListar;
		
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_imobiliaria_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_imobiliaria_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_imobiliaria_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}
	}
	
	$data['tipo'] = $tipo;
	$data['iptus'] = $result;
	$data['perfil'] = $session_data['perfil'];
 
	$_SESSION["CNDImob"]='listarPorTipoSim';
	$data['CNDImob'] = 'listarPorTipoSim';

		
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_cnd_imobiliaria_tipo_view', $data);
	$this->load->view('footer_pages_view');
	

 }
 
 function listarPorTipoNao(){	
  if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];
  
 	$cidade = '0';
	$estado = '0';	
	$tipo  = 2;	
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;	
		
	$idContratante = $_SESSION['cliente'] ;

	$_SESSION["CNDImob"]='listarPorTipoNao';
	$data["CNDImob"]='listarPorTipoNao';
	$cidadeBD = $_SESSION["cidadeCNDIBD"];
	$estadoBD = $_SESSION["estadoCNDIBD"];
	$idCNDIBD = $_SESSION["idCNDIBD"] ;
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$data['imoveis'] = $this->cnd_imobiliaria_model->listarImovel($idContratante,$tipo);
	$data['estados'] = $this->cnd_imobiliaria_model->listarEstado($idContratante,$tipo);
	$data['cidades'] = $this->cnd_imobiliaria_model->listarCidade($idContratante,$tipo);
	
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;
		$data['idCNDIBD'] = 0;
		$result = $this->cnd_imobiliaria_model->listarCndTipo($idContratante,$cidade,$estado,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		$data['cidadeBD'] = $municipioListar;
		$data['estadoBD'] = $estadoListar;
		$data['idCNDIBD'] = $idImovelListar;
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_imobiliaria_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_imobiliaria_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_imobiliaria_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}
	}
	
	$data['tipo'] = $tipo;
	$data['iptus'] = $result;
	$data['perfil'] = $session_data['perfil'];
		
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_cnd_imobiliaria_tipo_view', $data);
	$this->load->view('footer_pages_view');	

 }
 
 function listar(){	
 
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];
  
	$cidade = '0';
	$estado = '0';
	$tipo = 'X';
	$data['tipo'] =$tipo;
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['imoveis'] = $this->cnd_imobiliaria_model->listarImovel($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_imobiliaria_model->listarEstado($idContratante,$tipo);
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	
	
	$result = $this->cnd_imobiliaria_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	
	$total = $this->cnd_imobiliaria_model->somarTodos($idContratante,0,0);
	
	$_SESSION["CNDImob"]='listar';
	$data['CNDImob'] ='listar';
	
	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_imobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }


function listarComParametro(){	
 
 if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];
  
	$cidade  = $this->input->get('cidade');
	$estado  = $this->input->get('uf');
	
	
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['imoveis'] = $this->cnd_imobiliaria_model->listarImovel($idContratante);
	
	$data['estados'] = $this->cnd_imobiliaria_model->listarEstado();
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	
	
	$result = $this->cnd_imobiliaria_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	//print_r($this->db->last_query());exit;
	$total = $this->cnd_imobiliaria_model->somarTodos($idContratante,$cidade,$estado);
	$data['paginacao'] = createPaginate('cnd_imob', $total[0]->total) ;

	
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_imobiliaria_view', $data);

	$this->load->view('footer_pages_view');
	


 }


}

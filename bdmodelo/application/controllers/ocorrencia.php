<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ocorrencia extends CI_Controller {
 
 function __construct(){	
 parent::__construct();    
 session_start();
 
 $this->load->model('ocorrencia_model','',TRUE);    
 $this->load->model('emitente_imovel_model','',TRUE);	
 $this->load->model('log_model','',TRUE);    
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
 $this->load->helper('general_helper');	
  
 }
 
 function index(){
   if( $_SESSION['login_walmart']){
     $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];	 	 
     $this->load->view('home_view', $data);
   }else{
     
     redirect('login', 'refresh');
   }
 }
 
 
function listar(){
	
	$session_data = $_SESSION['login_walmart'];
	
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	if($podeExcluir[0]['total'] == 1){
		$data['ocorrencia'] = $this->ocorrencia_model->listar(0);	
	}else{
		$data['ocorrencia'] = $this->ocorrencia_model->listar($session_data['id']);	
	}
	
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	
	$data['adm'] =$podeExcluir[0]['total'];	
	$this->load->view('header_pages_view',$data);
	$this->load->view('listar_ocorrencia_view', $data);
	$this->load->view('footer_pages_view');
	
}

 function cadastrar(){
	if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	
	$data['modulos'] =  $this->ocorrencia_model->listarModulos();
	
	$idContratante = $_SESSION['cliente'] ;	
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view');
	$this->load->view('cadastrar_ocorrencia_view',$data);
	$this->load->view('footer_pages_view');
	 	 
 }
 
 function atender(){
	if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	
	$data['modulos'] =  $this->ocorrencia_model->listarModulos();
	$data['prioridade'] =  $this->ocorrencia_model->listarPrioridade();
	
	$idContratante = $_SESSION['cliente'] ;	
	$id = $this->input->get('id');
	$data['dados'] =  $this->ocorrencia_model->listarOcorrenciaById($id);
	
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view');
	$this->load->view('atender_ocorrencia_view',$data);
	$this->load->view('footer_pages_view');
	 	 
 }
  function editar(){
	if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	
	$data['modulos'] =  $this->ocorrencia_model->listarModulos();
	$data['prioridade'] =  $this->ocorrencia_model->listarPrioridade();
	
	$idContratante = $_SESSION['cliente'] ;	
	$id = $this->input->get('id');
	$data['dados'] =  $this->ocorrencia_model->listarOcorrenciaById($id);

	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view');
	$this->load->view('editar_ocorrencia_view',$data);
	$this->load->view('footer_pages_view');
	 	 
 }
 
 function atender_ocorrencia(){

	 $session_data = $_SESSION['login_walmart'];
	 $observacoes = $this->input->post('observacoes');
	 $id = $this->input->post('id');	 
	 $idUsuFecho = $session_data['id'];
	  
	 $dados = array(
					'obs_suporte' => $observacoes,	
					'id_usuario_fecho' => $idUsuFecho,	
					'data_fechamento' => date("Y-m-d"),
					'status_suporte' => 1,
				);
	
	if($this->ocorrencia_model->atualizar($dados,$id)) {
		$this->session->set_flashdata('mensagem','Registro Realizado com Sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	//print_r($this->db->last_query());exit;
	
	redirect('/ocorrencia/listar', 'refresh');
	
 }
 function editar_ocorrencia(){

	 $session_data = $_SESSION['login_walmart'];
	 $urgencia = $this->input->post('urgencia');		
	 $modulo = $this->input->post('modulo');		
	 $descricao = $this->input->post('areadetexto');
	 $id = $this->input->post('id');	 
	 
	 $dados = array(
					'urgencia' => $urgencia,					
					'texto_ocorrencia' => $descricao,					
					'id_modulo' => $modulo,
					'ativo' => 0,
				);
	
	if($this->ocorrencia_model->atualizar($dados,$id)) {
		$this->session->set_flashdata('mensagem','Registro Realizado com Sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}

	
	redirect('/ocorrencia/listar', 'refresh');
	
 }
 
  function enviar(){		

	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/ocorrencia/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = $id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";				
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{			
		$dados = array('img' => $id.'.'.$extensao);							
		$this->ocorrencia_model->atualizar($dados,$id);						
		$data = array('upload_data' => $this->upload->data($field_name));			
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}

//redirect('/iptu/listar', 'refresh');		 
} 

  function upload(){		  
	if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
	 }
	 $session_data = $_SESSION['login_walmart'];
	 $id = $this->input->get('id');    
	 $data['dados'] =  $this->ocorrencia_model->listarOcorrenciaById($id);
	 
	 if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	 $this->load->view('header_pages_view',$data);
	 $this->load->view('upload_ocorrencia', $data);
	 $this->load->view('footer_pages_view');
			  
 }
 
 function inativar(){
	 $id = $this->input->get('id');   
	 $dados = array('ativo' => '1');							
	 $this->ocorrencia_model->atualizar($dados,$id);	
	 redirect('/ocorrencia/listar', 'refresh');	 
 }
 
function ver(){		  
	if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
	 }
	 $session_data = $_SESSION['login_walmart'];
	 $id = $this->input->get('id');    
	 $data['dados'] =  $this->ocorrencia_model->listarOcorrenciaById($id);
	 
	 if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	 $this->load->view('header_pages_view',$data);
	 $this->load->view('ver_ocorrencia', $data);
	 $this->load->view('footer_pages_view');
			  
 } 
 function cadastrar_ocorrencia(){

	 $session_data = $_SESSION['login_walmart'];
	 $urgencia = $this->input->post('urgencia');		
	 $modulo = $this->input->post('modulo');		
	 $descricao = $this->input->post('areadetexto');		
	 $idContratante = $_SESSION['cliente'] ;
	 $idUsuAbriu = $session_data['id'];
	 
	 $dados = array(
					'id_contratante' => $idContratante,
					'id_usuario_abriu' => $idUsuAbriu,										
					'urgencia' => $urgencia,					
					'texto_ocorrencia' => $descricao,					
					'data_abertura' => date("Y-m-d"),
					'id_modulo' => $modulo,
					'ativo' => 0,
				);
	
	if($this->ocorrencia_model->add($dados)) {
		$this->session->set_flashdata('mensagem','Registro Atualizado com Sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}

	
	redirect('/ocorrencia/listar', 'refresh');
	
 }


}
 
?>
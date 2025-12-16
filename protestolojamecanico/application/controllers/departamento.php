<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departamento extends CI_Controller {
 
 function __construct(){
   parent::__construct();
   $this->load->model('departamento_model','',TRUE);
    $this->load->model('estado_model','',TRUE);
	$this->load->model('cnpj_model','',TRUE);
	$this->load->model('user','',TRUE);
	$this->load->model('contratante','',TRUE);
	$this->load->library('session');
	$this->load->library('form_validation');
	$this->load->helper('url');
    session_start();
  
 }
 
 function index(){
	$this->logado();   
 }
 
  
 function listarDepartamentoInterno(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$data['deptos'] = $this->departamento_model->listarDepartamento(0);
	
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('departamento_interno/listar_departamento_view', $data);
	$this->load->view('footer_pages_view');
	
  
 }
 
  function excluir(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$id = $this->input->get('id');
	$this->departamento_model->excluirFisicamente('depto_interno',$id);
	redirect('/departamento/listarDepartamentoInterno');	
 }
 
 function cadastrar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('departamento_interno/cadastrar_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function editar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$id = $this->input->get('id');
	$data['depto'] = $this->departamento_model->listarDepartamento($id);
	$this->load->view('header_pages_view',$data);
	$this->load->view('departamento_interno/editar_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 
 
 function inserir(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
		
	
	$nome = $this->input->post('nome');
	$nomeResp = $this->input->post('nome_resp');
	$emailResp = $this->input->post('email_resp');
	$telResp = $this->input->post('tel_resp');
	$id = $this->input->post('id');
	$op = $this->input->post('op');
	
	$dados = array(
		'nome_departamento' => $nome,
		'nome_resp' => $nomeResp,
		'email_resp' => $emailResp,
		'telefone' => $telResp,
		'id_contratante' => $_SESSION['cliente']
	);
	
	if($op == 0){
		$id = $this->departamento_model->inserir('depto_interno',$dados);

	}else{
		$this->departamento_model->atualizar('depto_interno',$dados,$id);
	}
	redirect('/departamento/listarDepartamentoInterno');	
	
 }
 
   
function logado(){	
	if(! $_SESSION['login_walmart']) {	
     redirect('login', 'refresh');
	}			
}  


 
 
}
 
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cadastro extends CI_Controller {
 
 function __construct(){
   parent::__construct();
	$this->load->model('email_model','',TRUE);
    $this->load->model('estado_model','',TRUE);
	$this->load->model('cadastro_model','',TRUE);
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
 
  
 function listar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];	
	$data['deptos'] = $this->cadastro_model->listar(0);
	$this->load->view('header_pages_view',$data);
	$this->load->view('cadastro/listar_view', $data);
	$this->load->view('footer_pages_view');
 }
 
  function excluir(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$id = $this->input->get('id');
	$this->email_model->excluirFisicamente('email',$id);
	redirect('/email/listarEmail');	
 }
 
 function cadastrar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('cadastro/cadastrar_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function editar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$id = $this->input->get('id');
	$data['depto'] = $this->cadastro_model->listar($id);
	$this->load->view('header_pages_view',$data);
	$this->load->view('cadastro/editar_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 
 
 function inserir(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
		
	
	$descricao_natureza = $this->input->post('descricao');
	$id = $this->input->post('id');
	$op = $this->input->post('op');
	
	$dados = array(
		'descricao_natureza' => $descricao_natureza,
	);
	
	if($op == 0){
		$id = $this->cadastro_model->inserir('natureza',$dados);

	}else{
		$this->cadastro_model->atualizar('natureza',$dados,$id);
	}
	redirect('/cadastro/listar');	
	
 }
 
   
function logado(){	
	if(! $_SESSION['login_walmart']) {	
     redirect('login', 'refresh');
	}			
}  


 
 
}
 
?>
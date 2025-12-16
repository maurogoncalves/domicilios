<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller {
 
 function __construct(){
   parent::__construct();
	$this->load->model('email_model','',TRUE);
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
 
  
 function listarEmail(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$data['deptos'] = $this->email_model->listarEmail(0);
	
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('emails/listar_view', $data);
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
	$this->load->view('emails/cadastrar_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function editar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$id = $this->input->get('id');
	$data['depto'] = $this->email_model->listarEmail($id);
	$this->load->view('header_pages_view',$data);
	$this->load->view('emails/editar_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 
 
 function inserir(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
		
	
	$nome = $this->input->post('nome');
	$cargo = $this->input->post('cargo');
	$email = $this->input->post('email');
	$id = $this->input->post('id');
	$op = $this->input->post('op');
	
	$dados = array(
		'nome' => $nome,
		'cargo' => $cargo,
		'email' => $email,
	);
	
	if($op == 0){
		$id = $this->email_model->inserir('email',$dados);

	}else{
		$this->email_model->atualizar('email',$dados,$id);
	}
	redirect('/email/listarEmail');	
	
 }
 
   
function logado(){	
	if(! $_SESSION['login_walmart']) {	
     redirect('login', 'refresh');
	}			
}  


 
 
}
 
?>
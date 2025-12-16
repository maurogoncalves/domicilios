<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parceiro extends CI_Controller {
 
 function __construct(){
   parent::__construct();
   $this->load->model('parceiro_model','',TRUE);
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
 
  
 function listarParceiros(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$data['deptos'] = $this->parceiro_model->listarParceiro(0);
	
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('parceiros/listar_parceiro_view', $data);
	$this->load->view('footer_pages_view');
	
  
 }
 
 
 function cadastrar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('parceiros/cadastrar_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function editar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$id = $this->input->get('id');
	$data['depto'] = $this->parceiro_model->listarParceiro($id);
	$this->load->view('header_pages_view',$data);
	$this->load->view('parceiros/editar_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function excluir(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$id = $this->input->get('id');
	$this->parceiro_model->excluirFisicamente('parceiros',$id);
	redirect('/parceiro/listarParceiros');	
 }
 
 function inserir(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
		
	
	$nome = $this->input->post('nome');
	$email = $this->input->post('email');
	$tel = $this->input->post('tel');
	$id = $this->input->post('id');
	$op = $this->input->post('op');
	
	$dados = array(
		'nome' => $nome,
		'email' => $email,
		'telefone' => $tel,
		'id_contratante' => $_SESSION['cliente']
	);
	
	if($op == 0){
		$id = $this->parceiro_model->inserir('parceiros',$dados);

	}else{
		$this->parceiro_model->atualizar('parceiros',$dados,$id);
	}
	redirect('/parceiro/listarParceiros');	
	
 }
 
   
function logado(){	
	if(! $_SESSION['login_walmart']) {	
     redirect('login', 'refresh');
	}			
}  


 
 
}
 
?>
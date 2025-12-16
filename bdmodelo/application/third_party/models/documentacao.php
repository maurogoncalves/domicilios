<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
class Documentacao extends CI_Controller {
 
 function __construct(){
   parent::__construct();
   
   $this->load->model('user','',TRUE);
   $this->load->model('conteudo','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->model('perfil','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');
 }
 
 function index(){
   if($this->session->userdata('logged_in')){
     $session_data = $this->session->userdata('logged_in');
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
	 $this->load->view('header_view',$data);
     $this->load->view('usuario_login_view', $data);
	 $this->load->view('footer_view');
   }else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }
 

 function editar(){
	$modulo = $this->input->get('modulo');
	$session_data = $this->session->userdata('logged_in');
	$data['info']  = $this->conteudo->listarDadosByModulo($modulo);
	//print_r($data['empresas']);exit;
	//print_r($this->db->last_query());exit;
	$this->load->view('header_view',$data);
    $this->load->view('editar_modulo_view', $data);
	$this->load->view('footer_view');
 }
 
 function atualizar_conteudo(){
	$id = $this->input->post('id');
	$texto = $this->input->post('texto');
	$dados = array('conteudo' => $texto);
	if($this->conteudo->atualizar_conteudo($dados,$id)) {
		$data['mensagem'] = 'Conteúdo foi alterado';
	}else{	
		$data['mensagem'] = 'Algum Erro Aconteceu';
	}
	
	redirect('/documentacao/editar?modulo=emitente', 'refresh');
	
 }
 
 
}

?>
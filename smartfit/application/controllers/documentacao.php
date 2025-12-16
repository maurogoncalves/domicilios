<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
class Documentacao extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('conteudo','',TRUE);
   $this->load->model('tipo_emitente_model','',TRUE);
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->model('emitente_model','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');   $this->db->cache_on();
   
  
 }
 
 function index()
 {
   if($this->session->userdata('logged_in'))
   {
	
     $session_data = $this->session->userdata('logged_in');
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
 

 
 function ler(){
 
	$modulo = $this->input->get('modulo');
	
	$data['info']  = $this->conteudo->listarDadosByModulo($modulo);
	//print_r($data['empresas']);exit;
	//print_r($this->db->last_query());exit;
	$this->load->view('header_view',$data);
    $this->load->view('ler_modulo_view', $data);
	$this->load->view('footer_view');
 }
 



}
//session_destroy(); //we need to call PHP's session object to access it through CI
?>
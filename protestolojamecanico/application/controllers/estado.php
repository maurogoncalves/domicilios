<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estado extends CI_Controller {
 
 function __construct(){
   parent::__construct();
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
 
  
 function listarEstado(){
	
	echo json_encode($this->estado_model->listarEstados(0));
  
 }
 
 function listarEstadoComCnpj(){
	
	echo json_encode($this->estado_model->listarEstadosComCnpj());
  
 }
 
 function listarCidades(){
	$estado = $this->input->get('estado');	
	echo json_encode($this->estado_model->listarCidades($estado));
  
 }
 
 function listarCidadesComCnpj(){
	$estado = $this->input->get('estado');	
	echo json_encode($this->estado_model->listarCidadesComCnpj($estado));
  
 }
	
function listarCidadesComCnpjRaiz(){
	$estado = $this->input->get('estado');	
	$cnpjRaiz = $this->input->get('cnpjRaiz');	
	echo json_encode($this->estado_model->listarCidadesComCnpjRaiz($estado,$cnpjRaiz));
  
 }	
function logado(){	
	if(! $_SESSION['login_walmart']) {	
     redirect('login', 'refresh');
	}			
}  


 
 
}
 
?>
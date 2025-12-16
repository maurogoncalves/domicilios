<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grafico extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
   $this->load->library('session');
   $this->load->helper('url');
   $this->load->library('form_validation');
      $this->load->model('imovel_model','',TRUE);	  
 }
 
 function iptu_estado_ano(){
	
	$id = $this->input->get('id');
	
	$session_data = $this->session->userdata('logged_in');
    $data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
	$idContratante = $_SESSION['cliente'] ;
	 
	//$id = $this->input->get('id');
	$hoje = date("Y-m-d");
	$hojeMenosUm = strtotime("-1 year", strtotime($hoje));
	$hojeMenosDois = strtotime("-2 year", strtotime($hoje));
	$hojeMenosTres = strtotime("-3 year", strtotime($hoje));
	$hojeMenosQuatro = strtotime("-4 year", strtotime($hoje));
	
	$anoAtual =  date("Y");
	$esseAnoMenosUm =  date("Y", $hojeMenosUm);
	$esseAnoMenosDois =  date("Y", $hojeMenosDois);
	$esseAnoMenosTres =  date("Y", $hojeMenosTres);
	$esseAnoMenosQuatro =  date("Y", $hojeMenosQuatro);
	
	$anos = array('Estado',$anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro);
	if($id == 1){
		$estados = "'RS', 'BA', 'PE', 'SP', 'PB', 'PR', 'SC', 'CE', 'MG', 'RN'";
	}else{
		$estados = "'AL', 'MS', 'RJ', 'PI', 'SE', 'GO', 'DF', 'MA', 'ES'";
	}	
	$data['iptuByAno']  = $this->imovel_model->buscaIptuEstadoAno($anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro,$idContratante,$estados);
	$data['anos']  = $anos; 
	
	$this->load->view('grafico_iptu_estado_ano', $data);
 }
 
 function iptu_estado_ano_inteiro(){
	$session_data = $this->session->userdata('logged_in');
    $data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
	$idContratante = $_SESSION['cliente'] ;
	 
	//$id = $this->input->get('id');
	$hoje = date("Y-m-d");
	$hojeMenosUm = strtotime("-1 year", strtotime($hoje));
	$hojeMenosDois = strtotime("-2 year", strtotime($hoje));
	$hojeMenosTres = strtotime("-3 year", strtotime($hoje));
	$hojeMenosQuatro = strtotime("-4 year", strtotime($hoje));
	
	$anoAtual =  date("Y");
	$esseAnoMenosUm =  date("Y", $hojeMenosUm);
	$esseAnoMenosDois =  date("Y", $hojeMenosDois);
	$esseAnoMenosTres =  date("Y", $hojeMenosTres);
	$esseAnoMenosQuatro =  date("Y", $hojeMenosQuatro);
	
	$anos = array('Estado',$anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro);
	$estados1 = "'RS', 'BA', 'PE', 'SP', 'PB', 'PR', 'SC', 'CE', 'MG', 'RN'";
	$estados2 = "'AL', 'MS', 'RJ', 'PI', 'SE', 'GO', 'DF', 'MA', 'ES'";
	
	$valores1 = array();
	$valores2 = array();
	
	foreach($anos as $ano){
		
		$valores1[] = $this->imovel_model->buscaIptuEstadoAnoUnico($ano,$idContratante,$estados1);
		
	}
	
	foreach($anos as $ano){
		
		$valores2[] = $this->imovel_model->buscaIptuEstadoAnoUnico($ano,$idContratante,$estados2);
		
	}
	
	//print_r($valores1);exit;
	//$data['iptuByAnoUm']  = $this->imovel_model->buscaIptuEstadoAno($anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro,$idContratante,$estados1);
	//$data['iptuByAnoDois']  = $this->imovel_model->buscaIptuEstadoAno($anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro,$idContratante,$estados2);
	$data['iptuByAnoUm']  = $valores1;
	$data['iptuByAnoDois']  = $valores2;
	
	//$data['iptuByAnoUm']  = $this->imovel_model->buscaIptuEstadoAno($anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro,$idContratante,$estados1);
	//$data['iptuByAnoDois']  = $this->imovel_model->buscaIptuEstadoAno($anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro,$idContratante,$estados2);
	//print_r($this->db->last_query());exit;
	$data['anos']  = $anos; 
	
	$this->load->view('header_view',$data);
    $this->load->view('grafico_iptu_estado_ano_inteiro', $data);
	$this->load->view('footer_view');
	 
	
 }
 
 function situacao_estado()
 {
   if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 $idContratante = $_SESSION['cliente'] ;
	 
	 $id = $this->input->get('id');
	 
	 $data['imSituacao']  = $this->imovel_model->buscaEstadoPorSituacao($id,$idContratante);
	 
	 
	 $this->load->view('header_view',$data);
     $this->load->view('grafico_view', $data);
	 $this->load->view('footer_view');
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }
 
 function index()
 {
   if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
	 $idContratante = $_SESSION['cliente'] ;
	 
	 $data['estados'] = $this->imovel_model->buscaEstado($idContratante);
	 $data['imSituacao'] = $this->imovel_model->buscaImSituacao($idContratante);
	 
	 $data['iptuEstado']  = $this->imovel_model->buscaIptuEstado($idContratante);
	 
	 
	 $this->load->view('header_view',$data);
     $this->load->view('home_view', $data);
	 $this->load->view('footer_view');
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }

 
 function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }
 
  function troca_senha()
 {
    $session_data = $this->session->userdata('logged_in');
	
	//print_r($session_data);exit;
	$data['id'] = $session_data['id'];
    $data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
    $this->load->view('header_view',$data);
    $this->load->view('troca_senha', $data);
	$this->load->view('footer_view');


	 
   
 }
 
 function atualizar_senha(){
 
	$senha = md5($this->input->post('senha'));
	$id_usuario = $this->input->post('id');
	
	$this->user->atualizar($senha,$id_usuario);
	$session_data = $this->session->userdata('logged_in');
	$data['id'] = $session_data['id'];
    $data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
	$data['mensagem'] = 'Senha Alterada Com Sucesso';
	
	$this->load->view('header_view',$data);
    $this->load->view('troca_senha', $data);
	$this->load->view('footer_view');
	
 
 }
 
}
 
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
class Home_Fiscal extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
   $this->load->library('session');
   $this->load->helper('url');
   $this->load->library('form_validation');
   $this->load->model('estado_model','',TRUE);
   $this->load->model('notificacao_model','',TRUE);
   $this->load->model('infracao_model','',TRUE);
   $this->load->model('intimacao_model','',TRUE);
   $this->load->model('protesto_model','',TRUE);
   session_start();
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, OPTIONS, POST');
	header('Access-Control-Allow-Headers: origin, x-requested-with,Content-Type, Content-Range, Content-Disposition, Content-Description');
 }

	function index(){	
	
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	 if($session_data['primeiro_acesso'] == 0){
		 redirect('home/perfil', 'refresh');	
	 }	 
		
	
	$estados = $this->estado_model->listarEstados(0);
	$estadosCnds = array();
	$i=1;
	
	foreach($estados as $est){		
		$contagemIntimacao = $this->intimacao_model->contaIntimacaoesByUf($est->uf);
		$total = $contagemIntimacao[0]->total;		
		if($total <> 0){
			if(($est->uf =='DF')|| ($est->uf =='RJ')|| ($est->uf =='ES')|| ($est->uf =='SE')|| ($est->uf =='AL')||  ($est->uf =='RN')){
				$estadosCnds[$i]['cor'] ='#01a8fe';
			}else{
				$estadosCnds[$i]['cor'] ='#01a8fe';
			}		
		}else{
			if(($est->uf =='DF')|| ($est->uf =='RJ')|| ($est->uf =='ES')|| ($est->uf =='SE')|| ($est->uf =='AL')||  ($est->uf =='RN')){
				$estadosCnds[$i]['cor'] ='#bababa';
			}else{
				$estadosCnds[$i]['cor'] ='#dedede';
			}		
		}
		$i++;		
	}
	$data['dadosNotificacao'] = '';
	if($_POST){
		$estadoPost = $this->input->post('uf_home_fiscal');
		$contagemIntimacao =  $this->intimacao_model->contaIntimacaoesByUf($estadoPost);
		$data['totalIntimacaoEst'] = $contagemIntimacao[0]->total;
		$data['estadoSelecionado'] = $estadoPost;
		$data['dadosIntimacao'] = $this->intimacao_model->listarInfracoesByEstado($estadoPost);
	}else{
		$data['totalIntimacaoEst'] = 0;	
		$data['dadosIntimacao'] = $data['estadoSelecionado'] = '';
	}
	$contagemIntimacao = $this->intimacao_model->contaIntimacaoesByUf(0);
	$data['totalIntimacaoBR'] = $contagemIntimacao[0]->total;
	
	$data['cndEstado'] = $estadosCnds;
	
	$this->load->view('header_pages_fiscal_view',$data);
	$this->load->view('dados_agrupados_mapa_fiscal', $data);
	$this->load->view('footer_pages_view');

 }
 
 

 
 function logout()
 {
   $_SESSION['login_walmart'] = '';
   redirect('https://bdwebgestora.com.br/domicilios/bdmodelo', 'refresh');
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

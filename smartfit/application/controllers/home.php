<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
class Home extends CI_Controller {
 
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
   $this->load->model('protesto_model','',TRUE);
   session_start();
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, OPTIONS, POST');
	header('Access-Control-Allow-Headers: origin, x-requested-with,Content-Type, Content-Range, Content-Disposition, Content-Description');
 }
 
  function contagem(){	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$estadosCnds = array();
	
	$estado = $this->input->get('estado');	
	$contagemNotificacao = $this->notificacao_model->contaNotificacaoByUf($estado);
	$contagemInfracao = $this->infracao_model->contaInfracoesByUf($estado);
	$contagemProtesto = $this->protesto_model->contaProtestoByUf($estado);
	
	$estadosCnds['contagemNotificacao'] = $contagemNotificacao[0]->total;
	$estadosCnds['contagemInfracao'] = $contagemInfracao[0]->total;
	$estadosCnds['contagemProtesto'] = $contagemProtesto[0]->total;
	
	
	echo json_encode($estadosCnds);
	
 }	
 public function listaApp(){	
	
	$estados = $this->estado_model->contarCndByEstadoApp();
	echo json_encode($estados);
 }
 function lista(){	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$estadosCnds = array();
	
	$base = $this->config->base_url();
	$base .='index.php';
	
	$estado = $this->input->get('estado');	
	
	$dadosNotificacao = $this->notificacao_model->listarNotificacoesByEstado($estado);
	$dadosInfracao = $this->infracao_model->listarInfracoesByEstado($estado);
	$dadosProtesto = $this->protesto_model->listarProtestoByEstado($estado);
	$retornoNot='';
	if(!empty($dadosNotificacao)){
		
		$retornoNot .="<tr style='font-weight:bold!important'>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Cnpj Raiz</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Cnpj</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>I.E.</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>I.M.</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Num. Lançamento ou Débito</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Num. Processo</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Data Ciência</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Prazo</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Breve Relato</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Tracking</td></tr>";
		foreach($dadosNotificacao as $dados){
			$id = $dados->id;
			$cnpj = $dados->cnpj;
			$cnpjRaiz = $dados->cnpj_raiz;
			$cnpjRaiz = $dados->cnpj_raiz;
			$num_ie = ($dados->num_ie) ? $dados->num_ie : "" ;	
			$num_im = ($dados->num_im) ? $dados->num_im : "" ;		
			$num_lancamento = $dados->num_lancamento;
			$num_processo = $dados->num_processo;
			$data_ciencia_br = $dados->data_ciencia_br;
			$prazo_br = $dados->prazo_br;
			$relato_infracao = $dados->relato_infracao;
			$retornoNot .="<tr >
			<td style='padding-left:4px;border:1px solid #002060;width:5%;'>$cnpjRaiz</td>
			<td style='padding-left:4px;border:1px solid #002060;width:11%;'>$cnpj </td>
			<td style='padding-left:4px;border:1px solid #002060;width:5%;'>$num_ie</td>
			<td style='padding-left:4px;border:1px solid #002060;width:5%;'>$num_im </td>
			<td style='padding-left:4px;border:1px solid #002060;width:18%;'>$num_lancamento</td>
			<td style='padding-left:4px;border:1px solid #002060;width:8%;'>$num_processo</td>
			<td style='padding-left:4px;border:1px solid #002060;width:7%;'>$data_ciencia_br</td>
			<td style='padding-left:4px;border:1px solid #002060;width:7%;'>$prazo_br</td>
			<td style='padding-left:4px;border:1px solid #002060;width:30%;'>$relato_infracao</td>
			<td style='padding-left:4px;border:1px solid #002060;width:8%;'><a target='_blank' title='Tracking' href='$base/notificacao/tracking?id=$id' class='btn'> <i title='Tracking' class='fa fa-cogs'></i></a></td></tr>";
			
		}
	}
	$retornoInfra='';
	if(!empty($dadosInfracao)){
		
		$retornoInfra .="<tr style='font-weight:bold!important'>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Cnpj Raiz</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Cnpj</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>I.E.</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>I.M.</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Num. Lançamento ou Débito</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Num. Processo</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Data Ciência</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Prazo</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Breve Relato</td>
			<td style='text-align:center;width:10%;border:1px solid #002060;'>Tracking</td></tr>";
		foreach($dadosInfracao as $dados){
			$id = $dados->id;
			$cnpj = $dados->cnpj;
			$cnpjRaiz = $dados->cnpj_raiz;
			$cnpjRaiz = $dados->cnpj_raiz;
			$num_ie = ($dados->num_ie) ? $dados->num_ie : "" ;	
			$num_im = ($dados->num_im) ? $dados->num_im : "" ;		
			$num_lancamento = $dados->num_lancamento;
			$num_processo = $dados->num_processo;
			$data_ciencia_br = $dados->data_ciencia_br;
			$prazo_br = $dados->prazo_br;
			$relato_infracao = $dados->relato_infracao;
			
			$retornoInfra .="<tr >
			<td style='padding-left:4px;border:1px solid #002060;width:5%;'>$cnpjRaiz</td>
			<td style='padding-left:4px;border:1px solid #002060;width:11%;'>$cnpj </td>
			<td style='padding-left:4px;border:1px solid #002060;width:5%;'>$num_ie</td>
			<td style='padding-left:4px;border:1px solid #002060;width:5%;'>$num_im </td>
			<td style='padding-left:4px;border:1px solid #002060;width:18%;'>$num_lancamento</td>
			<td style='padding-left:4px;border:1px solid #002060;width:8%;'>$num_processo</td>
			<td style='padding-left:4px;border:1px solid #002060;width:7%;'>$data_ciencia_br</td>
			<td style='padding-left:4px;border:1px solid #002060;width:7%;'>$prazo_br</td>
			<td style='padding-left:4px;border:1px solid #002060;width:30%;'>$relato_infracao</td>
			<td style='padding-left:4px;border:1px solid #002060;width:8%;'><a target='_blank' title='Tracking' href='$base/notificacao/tracking?id=$id' class='btn'> <i title='Tracking' class='fa fa-cogs'></i></a></td></tr>";
			
			//$retornoInfra .="<hr>";		
		}
	}
	$retornoProtesto='';
	if(!empty($dadosProtesto)){
		
		
		$retornoProtesto .="<tr style='font-weight:bold!important'>			
			<td style='text-align:center;width:5%;border:1px solid #002060;'>Cnpj Raiz</td>
			<td style='text-align:center;width:11%;border:1px solid #002060;'>Cnpj</td>
			<td style='text-align:center;width:5%;border:1px solid #002060;'>I.E.</td>
			<td style='text-align:center;width:5%;border:1px solid #002060;'>I.M.</td>
			<td style='text-align:center;width:18%;border:1px solid #002060;'>Num. Lançamento ou Débito</td>
			<td style='text-align:center;width:8%;border:1px solid #002060;'>Num. Processo</td>
			<td style='text-align:center;width:7%;border:1px solid #002060;'>Data Ciência</td>
			<td style='text-align:center;width:7%;border:1px solid #002060;'>Prazo</td>
			<td style='text-align:center;width:30%;border:1px solid #002060;'>Breve Relato</td>
			<td style='text-align:center;width:8%;border:1px solid #002060;'>Tracking</td></tr>";
		foreach($dadosProtesto as $dados){
			$id = $dados->id;
			$cnpj = $dados->cnpj;
			$cnpjRaiz = $dados->cnpj_raiz;
			$cnpjRaiz = $dados->cnpj_raiz;
			$num_ie = ($dados->num_ie) ? $dados->num_ie : "" ;	
			$num_im = ($dados->num_im) ? $dados->num_im : "" ;		
			
			$numero_titulo = $dados->numero_titulo;
			$valor_titulo = $dados->valor_titulo;
			$data_protesto = $dados->data_protesto_br;
			$vencimento = $dados->vencimento_br;
			$relato_protesto = $dados->relato_protesto;
			
			$retornoProtesto .="<tr >
			<td style='padding-left:4px;border:1px solid #002060;width:5%;'>$cnpjRaiz</td>
			<td style='padding-left:4px;border:1px solid #002060;width:11%;'>$cnpj </td>
			<td style='padding-left:4px;border:1px solid #002060;width:5%;'>$num_ie</td>
			<td style='padding-left:4px;border:1px solid #002060;width:5%;'>$num_im </td>
			<td style='padding-left:4px;border:1px solid #002060;width:18%;'>$num_lancamento</td>
			<td style='padding-left:4px;border:1px solid #002060;width:8%;'>$num_processo</td>
			<td style='padding-left:4px;border:1px solid #002060;width:7%;'>$data_ciencia_br</td>
			<td style='padding-left:4px;border:1px solid #002060;width:7%;'>$prazo_br</td>
			<td style='padding-left:4px;border:1px solid #002060;width:30%;'>$relato_infracao</td>
			<td style='padding-left:4px;border:1px solid #002060;width:8%;'><a target='_blank' title='Tracking' href='$base/notificacao/tracking?id=$id' class='btn'> <i title='Tracking' class='fa fa-cogs'></i></a></td></tr>";
			
			
			
		}
	}
	$estadosCnds['listagemNotificacao'] = $retornoNot;
	$estadosCnds['listagemInfracao'] = $retornoInfra;
	$estadosCnds['listagemProtesto'] = $retornoProtesto;
	echo json_encode($estadosCnds);
	
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
	
	$totalNotificacao =$totalProtesto = $totalInfracao = 0;
	
	
	
	
	foreach($estados as $est){		
	
		$contagemNotificacao = $this->notificacao_model->contaNotificacaoByUf($est->uf);
		$contagemInfracao = $this->infracao_model->contaInfracoesByUf($est->uf);
		$contagemProtesto = $this->protesto_model->contaProtestoByUf($est->uf);
		
		$total = $contagemNotificacao[0]->total + $contagemInfracao[0]->total + $contagemProtesto[0]->total;
	
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

	$contagemNotificacao = $this->notificacao_model->contaNotificacaoByUf(0);
	
	$contagemInfracao = $this->infracao_model->contaInfracoesByUf(0);
	$contagemProtesto = $this->protesto_model->contaProtestoByUf(0);
	$data['totalNotificacao'] =$contagemNotificacao[0]->total;
	$data['totalInfracao'] = $contagemInfracao[0]->total;
	$data['totalProtesto'] =$contagemProtesto[0]->total;

	
	$data['cndEstado'] = $estadosCnds;
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('dados_agrupados_mapa', $data);
	$this->load->view('footer_pages_view');

 }
 
	
 function perfil(){
	 $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
	$data['dadosUsu'] = $this->user->dadosUsu($session_data['id'] ,$session_data['id_contratante']);
	
	 
	$this->load->view('header_pages_view',$data);
	$this->load->view('perfil', $data);
	$this->load->view('footer_pages_view');
 }
 
 	
 
 function atualizar_perfil(){
	  $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
	 
	 $nome = $this->input->post('nome');
	 $tel = $this->input->post('tel');
	 $cel = $this->input->post('cel');
	 $whats = $this->input->post('whats');
	 $senha = $this->input->post('senha');
	 
	 if(empty($senha)){
		 $dados = array(
			'nome_usuario' => $nome,
			'telefone' => $tel,
			'celular' => $cel,
			'whatsapp' => $whats,
			'primeiro_acesso' => 1
		);
	 }else{
		 $dados = array(
			'nome_usuario' => $nome,
			'telefone' => $tel,
			'celular' => $cel,
			'whatsapp' => $whats,
			'primeiro_acesso' => 1,
			'senha' => md5($senha)
		);
	 }
	 
	 $this->session->set_flashdata('message', 'Dados Atualizados');	
	 $dados = $this->user->atualizar_dados_usuario($dados,$session_data['id']);
	 redirect('/home/logout');

 }
 
 
 
 function logout()
 {
   $_SESSION['login_walmart'] = '';
    redirect(URL_LOGOUT, 'refresh');
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
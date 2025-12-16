<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sublocacoes extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('sublocacao_model','',TRUE);	
   $this->load->model('log_model','',TRUE);
   $this->load->model('tipo_emitente_model','',TRUE);
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->model('emitente_model','',TRUE);
   $this->load->model('loja_model','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');
  
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

 
function cadastrar(){	
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);

	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	$data['lojas'] = $this->loja_model->listarLojaByTipo($idContratante,1);
	
	$data['emitentes'] = $this->emitente_model->listarEmitenteByTipo($idContratante,3);
	$data['receitas'] = $this->sublocacao_model->listarTipoAluguel();

	$this->load->view('header_view',$data);
    $this->load->view('cadastrar_sublocacoes_view', $data);
	$this->load->view('footer_view');
	
}

function cadastrar_sublocacao(){	
	
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	$id_loja = $this->input->post('id_loja');
	$id_emitente = $this->input->post('id_emitente');
	$vigencia = $this->input->post('vigencia');
	$dtini = $this->input->post('dtini');
	$dtfim = $this->input->post('dtfim');
	$receitas = $this->input->post('receita');
	$valor = $this->input->post('valor');
	$msg = '';
	
	$dtiniArr = explode('/',$dtini);
	$dtfimArr = explode('/',$dtfim);
	
	
	
	if($id_loja == 0){
		$msg .='Escolha uma Loja \n';
	}
	if($id_emitente == 0){
		$msg .='Escolha um Emitente \n';
	}
	if($vigencia == 0){
		$msg .='Escolha uma Vigência \n';
	}
	if(empty($receitas)){
		$msg .='Escolha uma Receita \n';	
	}
	if(empty($valor)){
		$msg .='Digite um valor \n';	
	}
	if(!empty($msg)){
		echo "<script>alert('".$msg."'); window.history.go(-1);</script>";
		exit;
	}else{
		$dados = array(
		'id_contratante' => $idContratante,	
		'id_loja' => $id_loja,
		'id_emitente' => $id_emitente,				
		'prazo' => $vigencia,
		'data_ini_vigencia' => $dtiniArr[2].'-'.$dtiniArr[1].'-'.$dtiniArr[0],
		'data_fim_vigencia' => $dtfimArr[2].'-'.$dtfimArr[1].'-'.$dtfimArr[0],
		'receita' => 1,
		'status' => 0,
		'valor_base' => $valor,
		);
		//print_r($receitas);exit;
		$idSub = $this->sublocacao_model->add($dados);
			if($idSub){				foreach($receitas as $receita){					//print$receita;exit;				
					$dadosParcela = array(
						'id_receita' => $receita,
						'id_sublocacao' => $idSub,		
						'numero_parcela' => 1,			
						'data_vencimento' => $dtiniArr[2].'-'.$dtiniArr[1].'-'.$dtiniArr[0], 
						'status' => 0,
					);						
					$this->sublocacao_model->addParcela($dadosParcela);						
					$date = $dtiniArr[2].'-'.$dtiniArr[1].'-'.$dtiniArr[0];
					$j=2;
					for($i=1;$i<=$vigencia-1;$i++){					
						$ultimaData = $this->sublocacao_model->getProximaData($date,$i);
						$dadosParcela = array(
							'id_receita' => $receita,
							'id_sublocacao' => $idSub,				
							'numero_parcela' => $j,				
							'data_vencimento' => $ultimaData->ultima_data, 
							'status' => 0,
						);
						$j++;
						$this->sublocacao_model->addParcela($dadosParcela);		
					}	
				}
				echo "<script>alert('Cadastro Feito com sucesso')</script>";
				redirect('/sublocacoes/listar', 'refresh');
				
			}else{
				$msg = 'Algum erro inesperado aconteceu';
				echo "<script>alert('".$msg."'); window.history.go(-1);</script>";
				exit;
			}
		
	}

	
}

function buscaLojaEmitente(){

	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;

	$emitente = $this->input->get('emitente');
	$loja = $this->input->get('loja');
	
	$result = $this->sublocacao_model->buscaEmitenteLoja($idContratante ,$emitente,$loja);
	echo json_encode($result->total);
	

}

function calcularDataFinal(){

	$dtini = $this->input->get('dtini');
	$vigencia = $this->input->get('vigencia');
	
	if($vigencia == 12){
		$dias = 365;
	}elseif($vigencia == 24){
		$dias = 730;
	}else{
		$dias = 1095;
	}
	
	$dtIniArr = explode('/',$dtini);
	$dtIniAux = $dtIniArr[2].'/'.$dtIniArr[1].'/'.$dtIniArr[0];
	$data = date('d/m/Y', strtotime("+".$dias." days", strtotime($dtIniAux)));
	echo json_encode($data);
	

}
function parcelas(){
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->get('id');
	
	$hoje = date("Y-m-d");
	
	$hojeMenosUm = strtotime("-1 month", strtotime($hoje));
	$hojeMenosDois = strtotime("-2 month", strtotime($hoje));
	$hojeMenosTres = strtotime("-3 month", strtotime($hoje));
	$hojeMenosQuatro = strtotime("-4 month", strtotime($hoje));
	$hojeMenosCinco = strtotime("-5 month", strtotime($hoje));
	$hojeMenosSeis = strtotime("-6 month", strtotime($hoje));
	

	$esseMes = date("m/Y");
	$esseMesMenosUm =  date("m/Y", $hojeMenosUm);
	$esseMesMenosDois =  date("m/Y", $hojeMenosDois);
	$esseMesMenosTres =  date("m/Y", $hojeMenosTres);
	$esseMesMenosQuatro =  date("m/Y", $hojeMenosQuatro);
	$esseMesMenosCinco =  date("m/Y", $hojeMenosCinco);
	$esseMesMenosSeis =  date("m/Y", $hojeMenosSeis);
	
	$primeiroDia = date("Y-m-".'01');
	
	$ultimoDiaAux = date("Y-m", $hojeMenosSeis);
	
	$mes =  date("m", $hojeMenosSeis);   // Mês desejado, pode ser por ser obtido por POST, GET, etc.
	$ano =  date("Y", $hojeMenosSeis);
	$ultimoDia = $ultimoDiaAux.'-'.date("t", mktime(0,0,0,$mes,'01',$ano)); // Mágica, plim!
	
	
	$data['meses'] = array($esseMes,$esseMesMenosUm,$esseMesMenosDois,$esseMesMenosTres,$esseMesMenosQuatro,$esseMesMenosCinco,$esseMesMenosSeis);

	$dados = $this->sublocacao_model->listarSubLocacaoById($idContratante,$id,1);
	$todasReceitas = $this->sublocacao_model->listarTipoAluguel();
	$aluguel = array();
	foreach($todasReceitas as $key => $receita){
		$aluguel[] = $this->sublocacao_model->listarReceita($idContratante,$id,$receita->id,$ultimoDia,$primeiroDia);
		//print_r($this->db->last_query());
		//print'<BR>';
		//print'<BR>';print'<BR>';
	}
	
	//print_r($aluguel);exit;
	//exit;
	//$aluguel = $this->sublocacao_model->listarReceita($idContratante,$id,1,$ultimoDia,$primeiroDia);//print_r($this->db->last_query());exit;
	//$fundo = $this->sublocacao_model->listarReceita($idContratante,$id,2,$ultimoDia,$primeiroDia);
	//$cond = $this->sublocacao_model->listarReceita($idContratante,$id,3,$ultimoDia,$primeiroDia);
	//$agua = $this->sublocacao_model->listarReceita($idContratante,$id,4,$ultimoDia,$primeiroDia);
	//$luz = $this->sublocacao_model->listarReceita($idContratante,$id,5,$ultimoDia,$primeiroDia);
	//$iptu = $this->sublocacao_model->listarReceita($idContratante,$id,6,$ultimoDia,$primeiroDia);
	
	//print_r($this->db->last_query());exit;
	$receitas = $this->sublocacao_model->listarReceitas($idContratante,$id);//print_r($this->db->last_query());exit;
	
	$data['dados'] = $dados;
	
	$data['aluguel'] = $aluguel;
	//$data['fundo'] = $fundo;
	//$data['cond'] = $cond;
	//$data['agua'] = $agua;
	//$data['luz'] = $luz;
	//$data['iptu'] = $iptu;
	
	$data['receitas'] = $receitas;
	$this->load->view('header_view',$data);
    $this->load->view('listar_parcelas_view', $data);
	$this->load->view('footer_view');

}

function baixar(){
	
	//print_r($_POST);exit;
	$data = date('Y-m-d');
	foreach ($_POST as $key => $valor) {
		$id = $key;
		if($valor <> '0,00'){
			$dadosParcela = array(
			'valor_pago' => $valor,				
			'data_pagamento' => $data, 
			'status' => 1,
			);
			$this->sublocacao_model->baixar($dadosParcela,$id);
			
		}
	
	}
	
	$result = $this->sublocacao_model->getNumeroSubLocacao($id);
	echo "<script>alert('Parcela Atualizada com sucesso')</script>";
	redirect('/sublocacoes/parcelas?id='.$result->id_sublocacao, 'refresh');


}

 function listar(){	
	$this->load->helper('Paginate_helper');        
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	//$data['estados'] = $this->loja_model->listarEstado();
	//$data['cidades'] = $this->loja_model->listarCidade();
	//$data['bandeiras'] = $this->loja_model->listarBandeira();
	//$data['todas_lojas'] = $this->loja_model->listarTodasLojas($idContratante);
	
	$result = $this->sublocacao_model->listarSubLocacao($idContratante,numRegister4PagePaginate(), $page);
	//print_r($this->db->last_query());exit;
	$total =  $this->sublocacao_model->somarTodos($idContratante);
	//print_r($total);exit;
	$data['paginacao'] = createPaginate('loja', $total[0]->total) ;
	
	$data['sublocacoes'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_view',$data);
    $this->load->view('listar_sublocacoes_view', $data);
	$this->load->view('footer_view');
	
	
 
 }
 
 
}
 
?>
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
   
   session_start();
  
 }
 
 function index()
 {
   if( $_SESSION['login_walmart'])
   {
	
     $session_data = $_SESSION['login_walmart'];
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
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);
    $data['prazos'] = $this->sublocacao_model->listarPrazo();
	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	$data['lojas'] = $this->loja_model->listarLojaByTipo($idContratante,1);
	
	$data['emitentes'] = $this->emitente_model->listarEmitenteByTipo($idContratante,3);
	$data['receitas'] = $this->sublocacao_model->listarTipoAluguel();

	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_sublocacoes_view', $data);
	$this->load->view('footer_pages_view');
	
}

function editar_sublocacao(){

 	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
    $id_sub = $this->input->post('id_sub');
	$id_loja = $this->input->post('id_loja');
	$id_emitente = $this->input->post('id_emitente');
	$vigencia = $this->input->post('vigencia');
	$dtini = $this->input->post('dtini');
	$dtfim = $this->input->post('dtfim');
	$receitas = $this->input->post('receita');
	$metragem = $this->input->post('metragem');
	$atividade_sub_locada = $this->input->post('atividade_sub_locada');
	$msg = '';
	
	$dadosImovel = $this->sublocacao_model->listarLojasById($id_loja);
			
	$_SESSION["cidadeSubL"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoSubL"] = $dadosImovel[0]->estado;
	$_SESSION["idSubL"] = $id_loja;	


    if($this->input->post('valor')){
		$valor = $this->input->post('valor');
    }else{
		$valor = $this->input->post('valor_escondido');
    }
    
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
		'metragem' => $metragem,
		'atividade_sublocada' => $atividade_sub_locada
		);

		$this->sublocacao_model->atualiza($dados,$id_sub);
		
		$date1 = $dtiniArr[2].'-'.$dtiniArr[1].'-'.$dtiniArr[0];
		$date2 = $dtfimArr[2].'-'.$dtfimArr[1].'-'.$dtfimArr[0];
		
		$receitasBKP =  $this->sublocacao_model->guardarReceitasExistentesById($id_sub);
		$totaisBKP =  $this->sublocacao_model->guardarTotaisExistentesById($id_sub);
		$receitasAtuais =  $this->sublocacao_model->listarReceitasExistentesById($id_sub);
		
		
		$this->sublocacao_model->copiarReceitasExistentesById($id_sub);
		
		foreach($receitasAtuais as $key => $receita){
			$dadosParcela = array(
				'id_receita' => $receita->id_receita,
				'id_sublocacao' => $id_sub,
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
					'id_receita' => $receita->id_receita,
					'id_sublocacao' => $id_sub,
					'numero_parcela' => $j,
					'data_vencimento' => $ultimaData->ultima_data,
					'status' => 0,
					);
					$j++;
					$this->sublocacao_model->addParcela($dadosParcela);
				}
		}
		
		$dadosTotal= array(
			'id_sublocacao' => $id_sub,
			'data' => $dtiniArr[2].'-'.$dtiniArr[1].'-'.$dtiniArr[0],
			'valor_pago'=> '0,00'
		);
		$this->sublocacao_model->addTotalParcela($dadosTotal);
		
		
		for($i=1;$i<=$vigencia-1;$i++){
			$ultimaData = $this->sublocacao_model->getProximaData($date1,$i);
			$dadosTotal= array(
				'id_sublocacao' => $id_sub,
				'data' => $ultimaData->ultima_data,
				'valor_pago'=> '0,00'
			);
			$this->sublocacao_model->addTotalParcela($dadosTotal);

		}
		/* atualizar valores existentes */
		
		foreach($receitasBKP as $key => $receitaAnt){
			$receitasAntigas =  $this->sublocacao_model->listarReceitasAntigasExistentesById($receitaAnt->id);
			if($receitasAntigas){
			$dadosUpdate = array(
				'data_pagamento' => $receitasAntigas[0]->data_pagamento,
				'valor_pago' => $receitasAntigas[0]->valor_pago,
				'status' =>  $receitasAntigas[0]->status
			);
			$update = $this->sublocacao_model->atualizaDados($dadosUpdate,$receitasAntigas[0]->id_receita,$receitasAntigas[0]->id_sublocacao,$receitasAntigas[0]->data_vencimento);
			}
		}
		/* fim atualizar valores existentes */
		
		
		/* atualizar totais */
		
		foreach($totaisBKP as $key => $totAnt){
			$totaisAntigos =  $this->sublocacao_model->listarTotaisAntigos($totAnt->id);
			if($totaisAntigos){
			$dadosUpdate = array(
				'valor_pago' => $totaisAntigos[0]->valor_pago
			);
			$update = $this->sublocacao_model->atualizaTotais($dadosUpdate,$totaisAntigos[0]->id_sublocacao,$totaisAntigos[0]->data);
			}
		}
		/* fim atualizar totais */
		
		/* novas receitas */		
		if($receitas){
			foreach($receitas as $receita){
				$dadosParcela = array(
				'id_receita' => $receita,
				'id_sublocacao' => $id_sub,
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
					'id_sublocacao' => $id_sub,
					'numero_parcela' => $j,
					'data_vencimento' => $ultimaData->ultima_data,
					'status' => 0,
					);
					$j++;
					$this->sublocacao_model->addParcela($dadosParcela);
				}
			}
			$dadosLog = array(
				'id_contratante' => $idContratante,
				'tabela' => 'sublocacoes',
				'id_usuario' => $idUsuario,
				'id_operacao' => $id_sub,
				'tipo' => 2,
				'texto' => utf8_encode('Alteração de Dados'),
				'data' => date("Y-m-d"),
			);
			$this->log_model->log($dadosLog);
			
			
			
			$this->session->set_flashdata('mensagem',CADASTRO_ATUALIZADO);
			redirect('/sublocacoes/listar', 'refresh');
		}else{
			$this->session->set_flashdata('mensagem',CADASTRO_ATUALIZADO);
			redirect('/sublocacoes/listar', 'refresh');
		}
		/* fim novas receitas*/

	}

}
function excluir(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	$id = $this->input->get('id');
	
	if($podeExcluir[0]['total'] == 1){		
		$this->user->excluirFisicamente($id,'sublocacoes');
		$_SESSION['mensagemSub'] =  CADASTRO_INATIVO;		
	}else{
		$_SESSION['mensagemSub'] =  'Sem permissão para exclusão';
	}	
	
	
	redirect('/sublocacoes/listar', 'refresh');
	
	
}	
function editar(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$id = $this->input->get('id');

	$dadosImovel = $this->sublocacao_model->listarLojasComLocacaoById($id);
			
	$_SESSION["cidadeSubL"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoSubL"] = $dadosImovel[0]->estado;
	$_SESSION["idSubL"] = $dadosImovel[0]->id;	
	
    $data['dados'] = $this->sublocacao_model->listarSubLocacaoById($idContratante,$id);
    $data['prazos'] = $this->sublocacao_model->listarPrazo();
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);
	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	$data['lojas'] = $this->loja_model->listarLojaByTipo($idContratante,1);
	$data['emitentes'] = $this->emitente_model->listarEmitenteByTipo($idContratante,3);
	$data['receitas'] = $this->sublocacao_model->listarReceitasExistentes($id);
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_sublocacoes_view', $data);
	$this->load->view('footer_pages_view');
}
function cadastrar_sublocacao(){
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	
	$id_loja = $this->input->post('id_loja');
	$id_emitente = $this->input->post('id_emitente');
	$vigencia = $this->input->post('vigencia');
	$dtini = $this->input->post('dtini');
	$dtfim = $this->input->post('dtfim');
	$dtvenc = $this->input->post('dtvenc');
	$receitas = $this->input->post('receita');
	$valor = $this->input->post('valor');
	$metragem = $this->input->post('metragem');
	$atividade_sub_locada = $this->input->post('atividade_sub_locada');
	$msg = '';
	
	$dadosImovel = $this->sublocacao_model->listarLojasById($id_loja);
			
	$_SESSION["cidadeSubL"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoSubL"] = $dadosImovel[0]->estado;
	$_SESSION["idSubL"] = $id_loja;	
	
	$dtiniArr = explode('/',$dtini);
	$dtfimArr = explode('/',$dtfim);
	$dtvencArr = explode('/',$dtvenc);
	
	//print_r($receitas);exit;
	
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
		'data_vencimento' => $dtvencArr[2].'-'.$dtvencArr[1].'-'.$dtvencArr[0],
		'receita' => 1,
		'status' => 0,
		'valor_base' => $valor,
		'metragem' => $metragem,
		'atividade_sublocada' => $atividade_sub_locada
		);
		//print_r($receitas);exit;
		$idSub = $this->sublocacao_model->add($dados);
			if($idSub){
				$date1 = $dtiniArr[2].'-'.$dtiniArr[1].'-'.$dtiniArr[0];
				
				$dadosTotal= array(
						'id_sublocacao' => $idSub,		
						'data' => $dtiniArr[2].'-'.$dtiniArr[1].'-'.$dtiniArr[0], 
						'valor_pago'=> '0,00'
					);	
				$this->sublocacao_model->addTotalParcela($dadosTotal);			
				
				for($i=1;$i<=$vigencia-1;$i++){					
					$ultimaData = $this->sublocacao_model->getProximaData($date1,$i);
					$dadosTotal= array(
						'id_sublocacao' => $idSub,		
						'data' => $ultimaData->ultima_data, 
						'valor_pago'=> '0,00'
					);	
					
					$this->sublocacao_model->addTotalParcela($dadosTotal);
						
					//print_r($this->db->last_query());
					//print'<BR>';
				}	
				//exit;	
				foreach($receitas as $receita){					//print$receita;exit;				
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
				
				$dadosLog = array(
				'id_contratante' => $idContratante,
				'tabela' => 'sublocacoes',
				'id_usuario' => $idUsuario,
				'id_operacao' => $idSub,
				'tipo' => 2,
				'texto' => utf8_encode('Inserção de Dados'),
				'data' => date("Y-m-d"),
				);
				$this->log_model->log($dadosLog);
				$this->db->cache_off();
				$this->session->set_flashdata('mensagem',CADASTRO_FEITO);
				redirect('/sublocacoes/listar', 'refresh');
				
			}else{
				$this->session->set_flashdata('mensagem',ERRO);
				redirect('/sublocacoes/listar', 'refresh');

			}
		
	}

	
}

function buscaLojaEmitente(){

	$session_data = $_SESSION['login_walmart'];
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
function export_mun(){

$session_data = $_SESSION['login_walmart'];
$idContratante = $_SESSION['cliente'] ;
	
$id = $this->input->post('id_mun_export');
$dados = $this->sublocacao_model->listarSubLocacaoByMunicipio($idContratante,$id);

//print_r($dados);

$isArray =  is_array($dados) ? '1' : '0';
	
$file="sublocacoes.xls";

$test="<table border=1>
<tr>
<td>Id</td>
<td>Locador</td>
<td>CPF/CNPJ Locador</td>
<td>Cidade Locador</td>
<td>Estado Locador</td>
<td>Locatário</td>
<td>CPF/CNPJ Locatário</td>
<td>Prazo</td>
<td>Vigência</td>
<td>Data Vencimento</td>
<td>Valor Base Aluguel</td>
<td>Metragem</td>
<td>Status</td>
<td>Alterado Por </td>
<td>Data Altera&ccedil;&atilde;o </td>
<td>Dados Alterados </td>	
</tr>
";
foreach($dados as $key => $emitente){ 	
		
	$dadosLog = $this->log_model->listarLog($emitente->idsub,'sublocacoes');				
	$isArrayLog =  is_array($dadosLog) ? '1' : '0';

	if($emitente->metragem == 0 ){
		$status ='Ativo';
	}else{
		$status ='Inativo';
	}			
	$test .= "<tr>";
	$test .= "<td>".utf8_decode($emitente->idsub)."</td>";
	$test .= "<td>".utf8_decode($emitente->locador)."</td>";
	$test .= "<td>".utf8_decode($emitente->locador_cpf_cnpj)."</td>";
	$test .= "<td>".utf8_decode($emitente->cidade)."</td>";
	$test .= "<td>".utf8_decode($emitente->estado)."</td>";
	$test .= "<td>".utf8_decode($emitente->locatario)."</td>";
	$test .= "<td>".utf8_decode($emitente->cpf_cnpj)."</td>";
	$test .= "<td>".utf8_decode($emitente->prazo)."</td>";
	$test .= "<td>".$emitente->data_ini_vigencia_br." a ".$emitente->data_fim_vigencia_br."</td>";
	$test .= "<td>".utf8_decode($emitente->data_vencimento)."</td>";
	$test .= "<td>".utf8_decode($emitente->valor_base)."</td>";
	$test .= "<td>".utf8_decode($emitente->metragem)."</td>";
	$test .= "<td>".utf8_decode($status)."</td>";

	if($isArrayLog <> 0){
		$dataFormatadaArr = explode('-',$dadosLog[0]->data);
		$dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
		$test .="<td>".$dadosLog[0]->email."</td>";
		$test .="<td>".$dataFormatada."</td>";
		$test .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
	}else{
		$test .="<td></td>";
		$test .="<td></td>";
		$test .="<td></td>";
	}	

	$test .= "</tr>";
			
}
$test .='</table>';
header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	

}

function export(){

$session_data = $_SESSION['login_walmart'];
$idContratante = $_SESSION['cliente'] ;
	
$id = $this->input->post('id_imovel_export');
$dados = $this->sublocacao_model->listarSubLocacaoId($idContratante,$id);

//print_r($dados);

$isArray =  is_array($dados) ? '1' : '0';
	
$file="sublocacoes.xls";

$test="<table border=1>
<tr>
<td>Id</td>
<td>Locador</td>
<td>CPF/CNPJ Locador</td>
<td>Cidade Locador</td>
<td>Estado Locador</td>
<td>Locatário</td>
<td>CPF/CNPJ Locatário</td>
<td>Prazo</td>
<td>Vigência</td>
<td>Data Vencimento</td>
<td>Valor Base Aluguel</td>
<td>Metragem</td>
<td>Status</td>
<td>Alterado Por </td>
<td>Data Altera&ccedil;&atilde;o </td>
<td>Dados Alterados </td>	
</tr>
";
foreach($dados as $key => $emitente){ 	
		
	$dadosLog = $this->log_model->listarLog($emitente->idsub,'sublocacoes');				
	$isArrayLog =  is_array($dadosLog) ? '1' : '0';

	if($emitente->metragem == 0 ){
		$status ='Ativo';
	}else{
		$status ='Inativo';
	}			
	$test .= "<tr>";
	$test .= "<td>".utf8_decode($emitente->idsub)."</td>";
	$test .= "<td>".utf8_decode($emitente->locador)."</td>";
	$test .= "<td>".utf8_decode($emitente->locador_cpf_cnpj)."</td>";
	$test .= "<td>".utf8_decode($emitente->cidade)."</td>";
	$test .= "<td>".utf8_decode($emitente->estado)."</td>";	
	$test .= "<td>".utf8_decode($emitente->locatario)."</td>";
	$test .= "<td>".utf8_decode($emitente->cpf_cnpj)."</td>";
	$test .= "<td>".utf8_decode($emitente->prazo)."</td>";
	$test .= "<td>".$emitente->data_ini_vigencia_br." a ".$emitente->data_fim_vigencia_br."</td>";
	$test .= "<td>".utf8_decode($emitente->data_vencimento)."</td>";
	$test .= "<td>".utf8_decode($emitente->valor_base)."</td>";
	$test .= "<td>".utf8_decode($emitente->metragem)."</td>";
	$test .= "<td>".utf8_decode($status)."</td>";

	if($isArrayLog <> 0){
		$dataFormatadaArr = explode('-',$dadosLog[0]->data);
		$dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
		$test .="<td>".$dadosLog[0]->email."</td>";
		$test .="<td>".$dataFormatada."</td>";
		$test .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
	}else{
		$test .="<td></td>";
		$test .="<td></td>";
		$test .="<td></td>";
	}	

	$test .= "</tr>";
			
}
$test .='</table>';
header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	

}

function export_est(){

$session_data = $_SESSION['login_walmart'];
$idContratante = $_SESSION['cliente'] ;
	
$id = $this->input->post('id_estado_export');
$dados = $this->sublocacao_model->listarSubLocacaoByEstado($idContratante,$id);

//print_r($dados);

$isArray =  is_array($dados) ? '1' : '0';
	
$file="sublocacoes.xls";

$test="<table border=1>
<tr>
<td>Id</td>
<td>Locador</td>
<td>CPF/CNPJ Locador</td>
<td>Cidade Locador</td>
<td>Estado Locador</td>
<td>Locatário</td>
<td>CPF/CNPJ Locatário</td>
<td>Prazo</td>
<td>Vigência</td>
<td>Data Vencimento</td>
<td>Valor Base Aluguel</td>
<td>Metragem</td>
<td>Status</td>
<td>Alterado Por </td>
<td>Data Altera&ccedil;&atilde;o </td>
<td>Dados Alterados </td>	
</tr>
";
foreach($dados as $key => $emitente){ 	
		
	$dadosLog = $this->log_model->listarLog($emitente->idsub,'sublocacoes');				
	$isArrayLog =  is_array($dadosLog) ? '1' : '0';

	if($emitente->metragem == 0 ){
		$status ='Ativo';
	}else{
		$status ='Inativo';
	}			
	$test .= "<tr>";
	$test .= "<td>".utf8_decode($emitente->idsub)."</td>";
	$test .= "<td>".utf8_decode($emitente->locador)."</td>";
	$test .= "<td>".utf8_decode($emitente->locador_cpf_cnpj)."</td>";
	$test .= "<td>".utf8_decode($emitente->cidade)."</td>";
	$test .= "<td>".utf8_decode($emitente->estado)."</td>";		
	$test .= "<td>".utf8_decode($emitente->locatario)."</td>";
	$test .= "<td>".utf8_decode($emitente->cpf_cnpj)."</td>";
	$test .= "<td>".utf8_decode($emitente->prazo)."</td>";
	$test .= "<td>".$emitente->data_ini_vigencia_br." a ".$emitente->data_fim_vigencia_br."</td>";
	$test .= "<td>".utf8_decode($emitente->data_vencimento)."</td>";
	$test .= "<td>".utf8_decode($emitente->valor_base)."</td>";
	$test .= "<td>".utf8_decode($emitente->metragem)."</td>";
	$test .= "<td>".utf8_decode($status)."</td>";

	if($isArrayLog <> 0){
		$dataFormatadaArr = explode('-',$dadosLog[0]->data);
		$dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
		$test .="<td>".$dadosLog[0]->email."</td>";
		$test .="<td>".$dataFormatada."</td>";
		$test .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
	}else{
		$test .="<td></td>";
		$test .="<td></td>";
		$test .="<td></td>";
	}	

	$test .= "</tr>";
			
}
$test .='</table>';
header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	

}

function limpar_filtro(){	
	$_SESSION["cidadeSubL"] = 0;
	$_SESSION["estadoSubL"] = 0;
	$_SESSION["idSubL"] = 0;	
	redirect('/sublocacoes/listar');	

 }

function export_detalhado(){

$session_data = $_SESSION['login_walmart'];
$idContratante = $_SESSION['cliente'] ;
	
$id = $this->input->get('id');
$dados = $this->sublocacao_model->listarSubLocacaoById($idContratante,$id);
$locador = $dados[0]->locador;
$locatario = $dados[0]->locatario;
$valor_base = $dados[0]->valor_base;
$dtini = $dados[0]->data_ini_vigencia_br;
$dtfim = $dados[0]->data_fim_vigencia_br;
$metragem = (empty($dados[0]->metragem)) ? 'Nada Consta' : $dados[0]->metragem; 

$meses = $this->sublocacao_model->listarMesesAsc($id,$dados[0]->data_ini_vigencia,$dados[0]->data_fim_vigencia);

$todasReceitas = $this->sublocacao_model->listarTipoAluguelByLocacao($id);

$totais = $this->sublocacao_model->listarReceitaTotaisAsc($id,$dados[0]->data_ini_vigencia,$dados[0]->data_fim_vigencia);
$somaComposicao = $this->sublocacao_model->listarReceitaSomaComposicaoAsc($idContratante,$id,$dados[0]->data_ini_vigencia,$dados[0]->data_fim_vigencia);

$file="detalhe_sublocacao.xls";

$test="<table border=1>
	<tr >
	<td colspan=2 >Locador: ".utf8_decode($locador)."  </td>
	<td colspan=2 >Locatário: ".utf8_decode($locatario)."  </td>
	<td colspan=2 >Valor Base: $valor_base  </td>
	<td colspan=2 >Vigência: $dtini - $dtfim  </td>
	<td colspan=2 >Metragem: $metragem  </td>
	</tr>
	<tr>";		
	$test .="<td>";
	$test .= '';
	$test .="</td>";
 foreach($meses as $key => $mes){ 		
	$test .="<td>";
	$test .=$mes->data_vencimento;
	$test .="</td>";
 }
 $test .= '</tr>';
 $test .= '<tr>';
 
 foreach($todasReceitas as $key => $receita){	
	$parcela = $this->sublocacao_model->listarReceitaAsc($idContratante,$id,$receita->id_receita,$dados[0]->data_ini_vigencia,$dados[0]->data_fim_vigencia);		
	//print_r($parcela);
	//print'<BR>';
	$test .="<td>";
	$test .= utf8_decode($receita->descricao_receita);
	$test .="</td>";
	$valor = 0;
	foreach($parcela as $chave =>$parc){
	
	if($parc->status == 1){
		$valorPago = $parc->valor_pago; 
	}else{
		$valorPago = 'Nada Consta';
	}
	
	
	
	$test .="<td>".$valorPago."</td>";
	
	}
	$test .= '</tr>';

 }
 
 $test .= '<tr>';
 $test .="<td>Total Composição</td>";
  foreach($somaComposicao as $key => $comp){
	
	$test .="<td>".number_format($comp->soma, 2, ',', '.')."</td>";
 } 
 $test .= '</tr>';
 
 $test .= '<tr>';
 $test .="<td>Valor Pago</td>";
 foreach($totais as $key => $tot){
	$test .="<td>".$tot->valor_pago."</td>";
 } 
 $test .= '</tr>';
 //echo $test;		exit;
header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;				

}
function parcelas(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->get('id');
	
	$dados = $this->sublocacao_model->listarSubLocacaoById($idContratante,$id);
	$maiorReceita = $this->sublocacao_model->buscaReceitasCadastradas($id);
	
	//print_r($dados);exit;
	
	$hoje = (date("Y-m-d"));
	
	$dataFinalVigencia = ($dados[0]->data_fim_vigencia);
	
	$hojeSTR = strtotime(date("Y-m-d"));
	
	$dataFinalVigenciaSTR = strtotime($dados[0]->data_fim_vigencia);
	
	if($dataFinalVigenciaSTR < $hojeSTR){
		//print'menor';
		$hoje = $dataFinalVigencia;
		$hojeArr = explode('-',$dataFinalVigencia);
		//print_r($hojeArr);exit;
		//$dataFinalVigencia = $dados[0]->data_fim_vigencia;
		
		
		$hojeMenosUm = strtotime("-1 month", strtotime($hoje));
		$hojeMenosDois = strtotime("-2 month", strtotime($hoje));
		$hojeMenosTres = strtotime("-3 month", strtotime($hoje));
		$hojeMenosQuatro = strtotime("-4 month", strtotime($hoje));
		$hojeMenosCinco = strtotime("-5 month", strtotime($hoje));
		$hojeMenosSeis = strtotime("-6 month", strtotime($hoje));
		
		
		$esseMes = $hojeArr[1].'/'.$hojeArr[0];
		//date("m/Y");
		$esseMesMenosUm =  date("m/Y", $hojeMenosUm);
		$esseMesMenosDois =  date("m/Y", $hojeMenosDois);
		$esseMesMenosTres =  date("m/Y", $hojeMenosTres);
		$esseMesMenosQuatro =  date("m/Y", $hojeMenosQuatro);
		$esseMesMenosCinco =  date("m/Y", $hojeMenosCinco);
		$esseMesMenosSeis =  date("m/Y", $hojeMenosSeis);
		
		//$primeiroDia = date("Y-m-".'01');
		$primeiroDia = $hojeArr[0].'-'.$hojeArr[1].'-01';
		//print'<BR>';
		$ultimoDiaAux = date("Y-m", $hojeMenosSeis);
		
		$mes =  date("m", $hojeMenosSeis);   // Mês desejado, pode ser por ser obtido por POST, GET, etc.
		$ano =  date("Y", $hojeMenosSeis);
		$ultimoDia = $ultimoDiaAux.'-'.date("t", mktime(0,0,0,$mes,'01',$ano)); // Mágica, plim!
	//exit;
	}else{
		//print'maior';
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
		//exit;
	}
	
	
	
	
	//$data['meses'] = array($esseMes,$esseMesMenosUm,$esseMesMenosDois,$esseMesMenosTres,$esseMesMenosQuatro,$esseMesMenosCinco);
	
	$data['meses'] = $this->sublocacao_model->listarMeses($id,$ultimoDia,$primeiroDia);
	//print_r($this->db->last_query());exit;
	//print_r($data['meses']);
	//exit;
	$totais = $this->sublocacao_model->getTotalSublocacao($id,$ultimoDia,$primeiroDia);
	//print_r($this->db->last_query());exit;
	//print_r($totais);exit;
	$todasReceitas = $this->sublocacao_model->listarTipoAluguel();
	//print_r($this->db->last_query());exit;
	$aluguel = array();
	$somaComposicao = $this->sublocacao_model->listarReceitaSomaComposicao($idContratante,$id,$ultimoDia,$primeiroDia);
	//print_r($this->db->last_query());exit;
	$totais = $this->sublocacao_model->listarReceitaTotais($id,$ultimoDia,$primeiroDia);
	foreach($todasReceitas as $key => $receita){	
		$aluguel[] = $this->sublocacao_model->listarReceita($idContratante,$id,$receita->id,$ultimoDia,$primeiroDia);		
	}
	

	$receitas = $this->sublocacao_model->listarReceitas($idContratante,$id);//print_r($this->db->last_query());exit;
	
	$data['dados'] = $dados;
	$data['totalComposicao'] = $somaComposicao;
	$data['totais'] = $totais;
	$data['maiorReceita'] = $maiorReceita;
	$data['aluguel'] = $aluguel;
	$data['sublocacao'] = $this->input->get('id');
	$data['idsublocacao'] = $this->input->get('id');
	//$data['cond'] = $cond;
	//$data['agua'] = $agua;
	//$data['luz'] = $luz;
	//$data['iptu'] = $iptu;
	
	$data['receitas'] = $receitas;

	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_parcelas_view', $data);
	$this->load->view('footer_pages_view');

}
function buscarTotal(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$mes = $this->input->get('mes');
	$idSubLoc = $this->input->get('idSubLoc');
	
	$receitas = $this->sublocacao_model->buscarTotal($mes,$idSubLoc);
	//print_r($receitas);exit;
	echo json_encode($receitas[0]->valor_pago);
	
	

}
function buscaValores(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$mes = $this->input->get('mes');
	$idSubLoc = $this->input->get('idSubLoc');
	
	$maiorReceita = $this->sublocacao_model->buscaReceitasCadastradas($idSubLoc );
	$maiorReceitaMaisUm = $maiorReceita[0]->maior_receita+1;
	
	$receitas = $this->sublocacao_model->buscarValores($mes,$idSubLoc);
	
	echo json_encode($receitas);

}

function converter(){
	$total = $this->input->get('total');
	
	$total = number_format($total, 2, ',', '.');
	echo json_encode($total);
}

function composicao(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	
	$id = $this->input->get('id');
	
	$ultimoDiaCorrente = date ( 'Y-m' ) . '-' . date ( 't' );
	$meses = $this->sublocacao_model->listarMesesSubLocacaoById($id,$ultimoDiaCorrente);
	$dados = $this->sublocacao_model->listarSubLocacaoById($idContratante,$id);
	//print_r($dados);exit;
	$maiorReceita = $this->sublocacao_model->buscaReceitasCadastradas($id);
	$receitas = $this->sublocacao_model->listarReceitas($idContratante,$id);
	//print_r($this->db->last_query());exit;
	
	$ultimaAlteracao = $this->log_model->ultimaAlteracao($idContratante,$id,$idUsuario);
	//print_r($this->db->last_query());exit;
	$data['maiorReceita'] = $maiorReceita;
	$data['ultimaAlteracao'] = $ultimaAlteracao;
	$data['dados'] = $dados;
	$data['receitas'] = $receitas;
	$data['meses'] = $meses;
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	$this->load->view('header_pages_view',$data);
    $this->load->view('composicao_view', $data);
	$this->load->view('footer_pages_view');

}

function baixar_parcela(){
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	
	$idSubLocacao = $this->input->post('idSubLocacao');
	$mes = $this->input->post('mes');
	$maiorReceita = $this->input->post('maiorReceita');
	$totalVlrPago = $this->input->post('totalVlrPago');	
	$data = date('Y-m-d');
	$dataBR = date('d-m-Y');
	$texto = '';
	
	switch ($maiorReceita) {
    case 1:
        $receita_um = $this->input->post('receita_um');
		
		$receita_um = $this->input->post('receita_1');
		$dadosParcela1 = array(
			'valor_pago' => $receita_um,				
			'data_pagamento' => $data, 
			'status' => 1,
		);		
		
		$dadosTotal = array(
			'valor_pago' => $totalVlrPago				
		);
		
		//$this->log_model->log($dadosLog);
				
		$this->sublocacao_model->baixar_parcela($dadosParcela1,$idSubLocacao,1,$mes);
		$this->sublocacao_model->gravar_total($dadosTotal,$idSubLocacao,$mes);

		$texto .= ' Data Pagamento - : '.$dataBR;	
		$texto .= ' Receita 1 - Valor Pago: '.$receita_um;
		$texto .= ' Valor Total - : '.$totalVlrPago;
		
		
        break;
    case 2:	
        $receita_um = $this->input->post('receita_1');
		$receita_dois = $this->input->post('receita_2');		
		
		$dadosParcela1 = array(
			'valor_pago' => $receita_um,				
			'data_pagamento' => $data, 
			'status' => 1,
		);		
		$dadosParcela2 = array(
			'valor_pago' => $receita_dois,				
			'data_pagamento' => $data, 
			'status' => 1,
		);
		
		$dadosTotal = array(
			'valor_pago' => $totalVlrPago				
		);
		
		$this->sublocacao_model->baixar_parcela($dadosParcela1,$idSubLocacao,1,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela2,$idSubLocacao,2,$mes);
		//print_r($this->db->last_query());exit;
		$this->sublocacao_model->gravar_total($dadosTotal,$idSubLocacao,$mes);
		
		$texto .= ' Data Pagamento - : '.$dataBR;
		$texto .= ' Receita 1 - Valor Pago: '.$receita_um;		
		$texto .= ' Receita 2 - Valor Pago: '.$receita_dois;		
		$texto .= ' Valor Total - : '.$totalVlrPago;

				
        break;
    case 3:
        $receita_um = $this->input->post('receita_1');
		$receita_dois = $this->input->post('receita_2');
		$receita_tres = $this->input->post('receita_3');
		
		$dadosParcela1 = array(
			'valor_pago' => $receita_um,				
			'data_pagamento' => $data, 
			'status' => 1,
		);		
		$dadosParcela2 = array(
			'valor_pago' => $receita_dois,				
			'data_pagamento' => $data, 
			'status' => 1,
		);
		$dadosParcela3 = array(
			'valor_pago' => $receita_tres,				
			'data_pagamento' => $data, 
			'status' => 1,
		);	

		$dadosTotal = array(
			'valor_pago' => $totalVlrPago				
		);
		
		$this->sublocacao_model->baixar_parcela($dadosParcela1,$idSubLocacao,1,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela2,$idSubLocacao,2,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela3,$idSubLocacao,3,$mes);
		
		$this->sublocacao_model->gravar_total($dadosTotal,$idSubLocacao,$mes);
		
		$texto .= ' Data Pagamento - : '.$dataBR;
		$texto .= ' Receita 1 - Valor Pago: '.$receita_um;		
		$texto .= ' Receita 2 - Valor Pago: '.$receita_dois;		
		$texto .= ' Receita 3 - Valor Pago: '.$receita_tres;		
		$texto .= ' Valor Total - : '.$totalVlrPago;
		

		
        break;
	case 4:
        $receita_um = $this->input->post('receita_1');
		$receita_dois = $this->input->post('receita_2');
		$receita_tres = $this->input->post('receita_3');
		$receita_quatro = $this->input->post('receita_4');
		
		$dadosParcela1 = array(
			'valor_pago' => $receita_um,				
			'data_pagamento' => $data, 
			'status' => 1,
		);		
		$dadosParcela2 = array(
			'valor_pago' => $receita_dois,				
			'data_pagamento' => $data, 
			'status' => 1,
		);
		$dadosParcela3 = array(
			'valor_pago' => $receita_tres,				
			'data_pagamento' => $data, 
			'status' => 1,
		);	
		$dadosParcela4 = array(
			'valor_pago' => $receita_quatro,				
			'data_pagamento' => $data, 
			'status' => 1,
		);	

		$dadosTotal = array(
			'valor_pago' => $totalVlrPago				
		);
		
		$this->sublocacao_model->baixar_parcela($dadosParcela1,$idSubLocacao,1,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela2,$idSubLocacao,2,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela3,$idSubLocacao,3,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela4,$idSubLocacao,4,$mes);
		
		$this->sublocacao_model->gravar_total($dadosTotal,$idSubLocacao,$mes);
		
		$texto .= ' Data Pagamento - :'.$dataBR;
		$texto .= ' Receita 1 - Valor Pago: '.$receita_um;		
		$texto .= ' Receita 2 - Valor Pago: '.$receita_dois;		
		$texto .= ' Receita 3 - Valor Pago: '.$receita_tres;		
		$texto .= ' Receita 4 - Valor Pago: '.$receita_quatro;		
		$texto .= ' Valor Total - : '.$totalVlrPago;
	
		
        break;
	case 5:
        $receita_um = $this->input->post('receita_1');
		$receita_dois = $this->input->post('receita_2');
		$receita_tres = $this->input->post('receita_3');
		$receita_quatro = $this->input->post('receita_4');
		$receita_cinco = $this->input->post('receita_5');

		$dadosParcela1 = array(
			'valor_pago' => $receita_um,				
			'data_pagamento' => $data, 
			'status' => 1,
		);		
		$dadosParcela2 = array(
			'valor_pago' => $receita_dois,				
			'data_pagamento' => $data, 
			'status' => 1,
		);
		$dadosParcela3 = array(
			'valor_pago' => $receita_tres,				
			'data_pagamento' => $data, 
			'status' => 1,
		);	
		$dadosParcela4 = array(
			'valor_pago' => $receita_quatro,				
			'data_pagamento' => $data, 
			'status' => 1,
		);			
		$dadosParcela5 = array(
			'valor_pago' => $receita_cinco,				
			'data_pagamento' => $data, 
			'status' => 1,
		);	

		$dadosTotal = array(
			'valor_pago' => $totalVlrPago				
		);
		
		$this->sublocacao_model->baixar_parcela($dadosParcela1,$idSubLocacao,1,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela2,$idSubLocacao,2,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela3,$idSubLocacao,3,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela4,$idSubLocacao,4,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela5,$idSubLocacao,5,$mes);
		
		$this->sublocacao_model->gravar_total($dadosTotal,$idSubLocacao,$mes);
		
		$texto .= ' Data Pagamento - : '.$dataBR;
		$texto .= ' Receita 1 - Valor Pago: '.$receita_um;		
		$texto .= ' Receita 2 - Valor Pago: '.$receita_dois;		
		$texto .= ' Receita 3 - Valor Pago: '.$receita_tres;		
		$texto .= ' Receita 4 - Valor Pago: '.$receita_quatro;		
		$texto .= ' Receita 5 - Valor Pago: '.$receita_cinco;		
		$texto .= ' Valor Total - : '.$totalVlrPago;
		
		
        break;
	case 6:
        $receita_um = $this->input->post('receita_1');
		$receita_dois = $this->input->post('receita_2');
		$receita_tres = $this->input->post('receita_3');
		$receita_quatro = $this->input->post('receita_4');
		$receita_cinco = $this->input->post('receita_5');
		$receita_seis = $this->input->post('receita_6');
		
		$dadosParcela1 = array(
			'valor_pago' => $receita_um,				
			'data_pagamento' => $data, 
			'status' => 1,
		);		
		$dadosParcela2 = array(
			'valor_pago' => $receita_dois,				
			'data_pagamento' => $data, 
			'status' => 1,
		);
		$dadosParcela3 = array(
			'valor_pago' => $receita_tres,				
			'data_pagamento' => $data, 
			'status' => 1,
		);	
		$dadosParcela4 = array(
			'valor_pago' => $receita_quatro,				
			'data_pagamento' => $data, 
			'status' => 1,
		);			
		$dadosParcela5 = array(
			'valor_pago' => $receita_cinco,				
			'data_pagamento' => $data, 
			'status' => 1,
		);		
		$dadosParcela6 = array(
			'valor_pago' => $receita_seis,				
			'data_pagamento' => $data, 
			'status' => 1,
		);	

		$dadosTotal = array(
			'valor_pago' => $totalVlrPago				
		);
		
		$this->sublocacao_model->baixar_parcela($dadosParcela1,$idSubLocacao,1,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela2,$idSubLocacao,2,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela3,$idSubLocacao,3,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela4,$idSubLocacao,4,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela5,$idSubLocacao,5,$mes);
		$this->sublocacao_model->baixar_parcela($dadosParcela6,$idSubLocacao,6,$mes);
		
		$this->sublocacao_model->gravar_total($dadosTotal,$idSubLocacao,$mes);
		
		$texto .= ' Data Pagamento - : '.$dataBR;
		$texto .= ' Receita 1 - Valor Pago: '.$receita_um;		
		$texto .= ' Receita 2 - Valor Pago: '.$receita_dois;		
		$texto .= ' Receita 3 - Valor Pago: '.$receita_tres;		
		$texto .= ' Receita 4 - Valor Pago: '.$receita_quatro;		
		$texto .= ' Receita 5 - Valor Pago: '.$receita_cinco;		
		$texto .= ' Receita 6 - Valor Pago: '.$receita_seis;		
		$texto .= ' Valor Total - : '.$totalVlrPago;

		
        break;		
	}
	
			
	$dadosLog = array(
		'id_contratante' => $idContratante,
		'tabela' => 'sublocacoes',
		'id_usuario' => $idUsuario,
		'id_operacao' => $idSubLocacao,
		'tipo' => 2,
		'texto' => utf8_encode($texto),
		'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);	
	$this->session->set_flashdata('mensagem','Parcela Atualizada com sucesso');
	redirect('/sublocacoes/composicao?id='.$idSubLocacao, 'refresh');


}

function baixar(){
	
	//print_r($_POST);exit;
	$data = date('Y-m-d');
	foreach ($_POST as $key => $valor) {
		
		$id = $key;
		$naoTem  = strripos($id, '-');		
		if($naoTem == false){
			if($valor <> '0,00'){
				$dadosParcela = array(
				'valor_pago' => $valor,				
				'data_pagamento' => $data, 
				'status' => 1,
				);
				$this->sublocacao_model->baixar($dadosParcela,$id);
				
			}
		}else{		
			$idArr = explode('-',$id);		
			if($valor <> '0,00'){
				$dadosTotal = array(
				'valor_pago' => $valor,				
				);
				//print_r($dadosTotal);
				//print'<BR>';
				$this->sublocacao_model->gravarTotalMes($dadosTotal,$idArr[0]);
				
			}
		}
	
	}

	$result = $this->sublocacao_model->getNumeroSubLocacao($id);
	echo "<script>alert('Parcela Atualizada com sucesso')</script>";
	redirect('/sublocacoes/parcelas?id='.$idArr[0], 'refresh');


}

 function listar(){	
	if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	
	$this->load->helper('Paginate_helper');        
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
	$idContratante = $_SESSION['cliente'] ;
	
	$data['estados'] = $this->sublocacao_model->buscaEstado($idContratante);
	
	$data['cidades'] = $this->sublocacao_model->buscaCidades($idContratante);
	$data['lojas'] = $this->sublocacao_model->listarLojasComLocacao($idContratante);
	//print_r($this->db->last_query());exit;

	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->sublocacao_model->listarSubLocacao($idContratante);
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result = $this->sublocacao_model->listarSubLocacaoByMunicipio($idContratante,$municipioListar);
			}else if($estadoListar <> '0'){
				$result = $this->sublocacao_model->listarSubLocacaoByEstado($idContratante,$estadoListar);				
			}else{
				$result = $this->sublocacao_model->listarSubLocacaoId($idContratante,$idImovelListar);
			}
		}else{	
			$result = $this->sublocacao_model->listarSubLocacaoId($idContratante,$idImovelListar);
		}
	}	
	
	
	$total =  $this->sublocacao_model->somarTodos($idContratante);
	
	
	$data['sublocacoes'] = $result;
	$data['perfil'] = $session_data['perfil'];
	
	
	if(empty($_SESSION["cidadeSubL"])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION["cidadeSubL"];
	}
	if(empty($_SESSION["estadoSubL"])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] =$_SESSION["estadoSubL"];
	}
	if(empty($_SESSION["idSubL"])){
		$data['idSubL'] = 0;
	}else{
		$data['idSubL'] = $_SESSION["idSubL"];
	}
	
	if(empty($_SESSION["mensagemSub"])){
		$data['mensagemSub'] = '';
	}else{
		$data['mensagemSub'] = $_SESSION['mensagemSub'];
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_sublocacoes_view', $data);
	$this->load->view('footer_pages_view');
	
	
 
 }
 function buscaSubLocacaoById(){
 
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->get('id');
	$result = $this->sublocacao_model->listarSubLocacaoId($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	$base = $this->config->base_url();
	$base .='index.php';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$retorno .="</tr>";
	}else{
		foreach($result as $imovel){ 
		
			$idSub = $imovel->idsub;
			$retorno .="<tr>";
			$retorno .="<td width='25%' > <a href='#'>".$imovel->locador."</a></td>";
			$retorno .="<td width='30%' > ".$imovel->locatario."</td>";
			$retorno .="<td width='15%' > ".$imovel->prazo."</td>";
			$retorno .="<td width='10%' > ".$imovel->descricao_receita."</td>";
			$retorno .="<td width='20%' >";			
			$retorno .="<a href='$base/sublocacoes/parcelas?id=$idSub' class='btn btn-primary btn-xs'><i class='fa fa-bars'></i></a>";
			$retorno .="<a href='$base/sublocacoes/ativar?id=$idSub' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/sublocacoes/excluir?id=$idSub' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";
			$retorno .="<a href='$base/sublocacoes/composicao?id=$idSub' class='btn btn-primary btn-xs'><i class='fa fa-rss'></i></a>";
			$retorno .="<a href='$base/sublocacoes/editar?id=$idSub' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i></a>";
			
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
	
 
 }
 function buscaSubLocacaoByCidade(){
 
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$municipio = $this->input->get('municipio');
	$result = $this->sublocacao_model->listarSubLocacaoByMunicipio($idContratante,$municipio);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	$base = $this->config->base_url();
	$base .='index.php';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$retorno .="</tr>";
	}else{
		foreach($result as $imovel){ 
		
			$idSub = $imovel->idsub;
			$retorno .="<tr>";
			$retorno .="<td width='25%' > <a href='#'>".$imovel->locador."</a></td>";
			$retorno .="<td width='30%' > ".$imovel->locatario."</td>";
			$retorno .="<td width='15%' > ".$imovel->prazo."</td>";
			$retorno .="<td width='10%' > ".$imovel->descricao_receita."</td>";
			$retorno .="<td width='20%' >";			
			$retorno .="<a href='$base/sublocacoes/parcelas?id=$idSub' class='btn btn-primary btn-xs'><i class='fa fa-bars'></i></a>";
			$retorno .="<a href='$base/sublocacoes/ativar?id=$idSub' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/sublocacoes/excluir?id=$idSub' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";
			$retorno .="<a href='$base/sublocacoes/composicao?id=$idSub' class='btn btn-primary btn-xs'><i class='fa fa-rss'></i></a>";
			$retorno .="<a href='$base/sublocacoes/editar?id=$idSub' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i></a>";
			
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
	
 
 }
 function buscaSubLocacaoByEstado(){
 
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$estado = $this->input->get('id');
	$result = $this->sublocacao_model->listarSubLocacaoByEstado($idContratante,$estado);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	$base = $this->config->base_url();
	$base .='index.php';
	$retorno = '';
	if($isArray == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$retorno .="</tr>";
	}else{
		foreach($result as $imovel){ 
		
			$idSub = $imovel->idsub;
			$retorno .="<tr>";
			$retorno .="<td width='25%' > <a href='#'>".$imovel->locador."</a></td>";
			$retorno .="<td width='30%' > ".$imovel->locatario."</td>";
			$retorno .="<td width='15%' > ".$imovel->prazo."</td>";
			$retorno .="<td width='10%' > ".$imovel->descricao_receita."</td>";
			$retorno .="<td width='20%' >";			
			$retorno .="<a href='$base/sublocacoes/parcelas?id=$idSub' class='btn btn-primary btn-xs'><i class='fa fa-bars'></i></a>";
			$retorno .="<a href='$base/sublocacoes/ativar?id=$idSub' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/sublocacoes/excluir?id=$idSub' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";
			$retorno .="<a href='$base/sublocacoes/composicao?id=$idSub' class='btn btn-primary btn-xs'><i class='fa fa-rss'></i></a>";
			$retorno .="<a href='$base/sublocacoes/editar?id=$idSub' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
	
 
 }
 function buscaCidadeByEstado(){	
	$id = $this->input->get('estado');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->sublocacao_model->buscaCidade($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $imovel){ 	
		 
			$retorno .="<option value='".$imovel->cidade."'>".$imovel->cidade."</option>";
		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
	
	
	
 }
 
 function buscaSubByEstado(){	
	$id = $this->input->get('estado');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->sublocacao_model->buscaSub($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Loja</option>";
		foreach($result as $key => $imovel){ 	
		 
			$retorno .="<option value='".$imovel->id."'>".$imovel->nome_fantasia."</option>";
		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
	
	
	
 }
 
 function buscaSubByMunicipio(){	
	$id = $this->input->get('municipio');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->sublocacao_model->buscaSubByMun($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Loja</option>";
		foreach($result as $key => $imovel){ 	
		 
			$retorno .="<option value='".$imovel->id."'>".$imovel->nome_fantasia."</option>";
		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
	
	
	
 }
 
}
 
?>

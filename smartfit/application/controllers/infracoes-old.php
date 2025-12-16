<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infracoes extends CI_Controller {
 
 function __construct(){   parent::__construct();   $this->load->model('infracao_model','',TRUE);		   $this->load->model('sublocacao_model','',TRUE);	   $this->load->model('log_model','',TRUE);   $this->load->model('tipo_emitente_model','',TRUE);   $this->load->model('user','',TRUE);   $this->load->model('contratante','',TRUE);   $this->load->model('emitente_model','',TRUE);   $this->load->model('loja_model','',TRUE);   $this->load->library('session');   $this->load->library('form_validation');   $this->load->helper('url');    date_default_timezone_set('America/Sao_Paulo');	session_start();	
}
 
 function index() {   if($_SESSION['login'])   {     $session_data = $_SESSION['login'];     $data['email'] = $session_data['email'];	 $data['empresa'] = $session_data['empresa'];	 $data['perfil'] = $session_data['perfil'];     $this->load->view('home_view', $data);   }else{     //If no session, redirect to login page     redirect('login', 'refresh');   } }
 function buscaDadosLoja(){	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$loja = $this->input->get('loja');
	
	$retorno ='';
	$result = $this->infracao_model->buscaDadosLoja($idContratante,$loja);
	if(!$result){
		echo json_encode(0);
	}else{
		$obj = array();
		$obj['cpf_cnpj']=$result[0]->cpf_cnpj; 
		$obj['cod1']=$result[0]->cod1; 
		$obj['regional']=$result[0]->regional; 
		$obj['bandeira']=$result[0]->bandeira; 
		echo json_encode($obj);
	}	
	
	
	
 }
 function cadastrar_infracao(){
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$idLoja = $this->input->post('id_loja');
	$infracao  = $this->input->post('infracao'); 
	$dtRecebInfra  = $this->input->post('dt_receb_infra');
	$tipoAuto  = $this->input->post('tipo_auto');  
	$motivInfracao  = $this->input->post('motiv_infracao'); 
	$classInfracao  = $this->input->post('class_infra'); 
	$breveRelato  = $this->input->post('breve_relato');
	$dtIniComp  = $this->input->post('dt_ini_comp');
	$dtFimComp  = $this->input->post('dt_fim_comp');
	$valorPrincipal  = $this->input->post('valor_principal'); 
	$atualizacaoMonetaria  = $this->input->post('atualizacao_monetaria'); 
	$multa  = $this->input->post('multa');  
	$juros  = $this->input->post('juros'); 
	$total  = $this->input->post('total'); 
	$totalRevisado  = $this->input->post('total_revisado'); 
	$valorEfetivoPago  = $this->input->post('valor_efetivo_pago'); 
	
	$dtPlanFim  = $this->input->post('dt_plan_fim');
	$dtEncerEfetivo  = $this->input->post('dt_encer_efetivo');
	$obs  = $this->input->post('obs');
	$msg= '';
	if($idLoja == 0){
		$msg .='Escolha uma Loja \n';
	}
	
	if(!empty($msg)){
		echo "<script>alert('".$msg."'); window.history.go(-1);</script>";
		exit;
	}	
	if(!empty($dtRecebInfra)){
		$dtRecebInfraArr = explode('/',$dtRecebInfra);
	}else{		
		$dtRecebInfraArr = explode('/','0000/00/00');
	}	
	
	if(!empty($dtPlanFim)){
		$dtPlanFimArr = explode('/',$dtPlanFim);
	}else{		
		$dtPlanFimArr = explode('/','0000/00/00');
	}	

	if(!empty($dtEncerEfetivo)){
		$dtEncerEfetivoArr = explode('/',$dtEncerEfetivo);
	}else{		
		$dtEncerEfetivoArr = explode('/','0000/00/00');
	}		

	if(empty($dtIniComp)){
		$dtIniComp = '00/0000';
	}		

	if(empty($dtFimComp)){
		$dtFimComp = '00/0000';
	}		
	

	$dados = array(
		'id_contratante' => $idContratante,	
		'id_loja' => $idLoja,
		'cod_infracao' => $infracao,				
		'data_recebimento' => $dtRecebInfraArr[2].'-'.$dtRecebInfraArr[1].'-'.$dtRecebInfraArr[0],
		'id_auto' => $tipoAuto,
		'id_classificacao' => $classInfracao,
		'motivo_infracao' => $motivInfracao,
		'relato_infracao' => $breveRelato,
		'dt_ini_competencia' => $dtIniComp ,
		'dt_fim_competencia' => $dtFimComp,
		'valor_principal' => $valorPrincipal ,
		'atualizacao_monetaria' => $atualizacaoMonetaria,
		'multa' => $multa,
		'juros' => $juros,
		'total' => $total,
		'valor_total_revisao' => $totalRevisado,
		'valor_real_pago' => $valorEfetivoPago,
		'observacoes' => $obs,
		'data_plan_fim_processo' => $dtPlanFimArr[2].'-'.$dtPlanFimArr[1].'-'.$dtPlanFimArr[0],
		'data_encerramento_real' => $dtEncerEfetivoArr[2].'-'.$dtEncerEfetivoArr[1].'-'.$dtEncerEfetivoArr[0]
		);
			$id = $this->infracao_model->add($dados);		$dadosObs = array(		'id_infra'=>$id,		'data'=>date("Y-m-d"),		'hora'=>date("h:i:s"),		'id_usuario'=>$session_data['id'],		'observacao'=>$obs,		);		$this->infracao_model->addObs($dadosObs);	
	if($id){
		$data['mensagem'] = 'Cadastro Realizado com Sucesso';
	}else{	
		$data['mensagem'] = 'Algum Erro Aconteceu';
	}
	redirect('/infracoes/listar', 'refresh');
 }
 
 function buscaInfraByCidade(){	
	$cidade = $this->input->get('municipio');
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->infracao_model->buscaInfraByCidade($idContratante,$cidade);
	
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
 
 function buscaInfraByEstado(){	
	$id = $this->input->get('estado');
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->infracao_model->buscaInfra($idContratante,$id);
	
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
 
 function editar_responsavel_infracao(){
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->post('id');
	$emitente  = $this->input->post('emitente'); 
	$dataEnvio  = $this->input->post('data_envio');
	$posicionamento  = $this->input->post('posicionamento');  
	$probabilidade  = $this->input->post('probabilidade');  
	
	
	$msg= '';
	if($emitente == 0){
		$msg .='Escolha um Emitente \n';
	}
	
	if(!empty($msg)){
		echo "<script>alert('".$msg."'); window.history.go(-1);</script>";
		exit;
	}	
	if(!empty($dataEnvio)){
		$dataEnvioArr = explode('/',$dataEnvio);
	}else{		
		$dataEnvioArr = explode('/','0000/00/00');
	}	
	
	
	

	$dados = array(
		'id_emitente' => $emitente,
		'data_envio' => $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0],
		'posicao_resp' => $posicionamento,
		'probabilidade_exito' => $probabilidade,
		);
		

	
	
	if($this->infracao_model->atualiza_resp($dados,$id)) {
		$data['mensagem'] = 'Cadastro do Responsável Atualizado com Sucesso';
	}else{	
		$data['mensagem'] = 'Algum Erro Aconteceu';
	}
	redirect('/infracoes/listar', 'refresh');
 }
 
 function inserir_responsavel_infracao(){
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->post('id');
	$emitente  = $this->input->post('emitente'); 
	$dataEnvio  = $this->input->post('data_envio');
	$posicionamento  = $this->input->post('posicionamento');  
	$probabilidade  = $this->input->post('probabilidade');  
	
	
	$msg= '';
	if($emitente == 0){
		$msg .='Escolha um Emitente \n';
	}
	
	if(!empty($msg)){
		echo "<script>alert('".$msg."'); window.history.go(-1);</script>";
		exit;
	}	
	if(!empty($dataEnvio)){
		$dataEnvioArr = explode('/',$dataEnvio);
	}else{		
		$dataEnvioArr = explode('/','0000/00/00');
	}	
	

	$dados = array(
		'id_infracao' => $id,	
		'id_emitente' => $emitente,
		'data_envio' => $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0],
		'posicao_resp' => $posicionamento,
		'probabilidade_exito' => $probabilidade,
		);
		
	if($this->infracao_model->add_resp($dados)) {
		
		$_SESSION["mensagemInfra"]  = 'Cadastro do Responsável Realizado com Sucesso';
	}else{	
		$_SESSION["mensagemInfra"]  = 'Algum Erro Aconteceu';
	}

	
	
	redirect('/infracoes/inserir_responsavel?id='.$id, 'refresh');
 }
 function editar_infracao(){
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	$idInfracao  = $this->input->post('id_infracao'); 
	$idLoja = $this->input->post('id_loja');
	$infracao  = $this->input->post('infracao'); 
	$dtRecebInfra  = $this->input->post('dt_receb_infra');
	$tipoAuto  = $this->input->post('tipo_auto');  
	$motivInfracao  = $this->input->post('motiv_infracao'); 
	$classInfracao  = $this->input->post('class_infra'); 
	$breveRelato  = $this->input->post('breve_relato');
	$dtIniComp  = $this->input->post('dt_ini_comp');
	$dtFimComp  = $this->input->post('dt_fim_comp');
	$valorPrincipal  = $this->input->post('valor_principal'); 
	$atualizacaoMonetaria  = $this->input->post('atualizacao_monetaria'); 
	$multa  = $this->input->post('multa');  
	$juros  = $this->input->post('juros'); 
	$total  = $this->input->post('total'); 
	$totalRevisado  = $this->input->post('total_revisado'); 
	$valorEfetivoPago  = $this->input->post('valor_efetivo_pago'); 
	
	$dtPlanFim  = $this->input->post('dt_plan_fim');
	$dtEncerEfetivo  = $this->input->post('dt_encer_efetivo');
	$obs  = $this->input->post('obs');
	$msg= '';
	if($idLoja == 0){
		$msg .='Escolha uma Loja \n';
	}
	
	if(!empty($msg)){
		echo "<script>alert('".$msg."'); window.history.go(-1);</script>";
		exit;
	}	
	if(!empty($dtRecebInfra)){
		$dtRecebInfraArr = explode('/',$dtRecebInfra);
	}else{		
		$dtRecebInfraArr = explode('/','0000/00/00');
	}	
	
	if(!empty($dtPlanFim)){
		$dtPlanFimArr = explode('/',$dtPlanFim);
	}else{		
		$dtPlanFimArr = explode('/','0000/00/00');
	}	

	if(!empty($dtEncerEfetivo)){
		$dtEncerEfetivoArr = explode('/',$dtEncerEfetivo);
	}else{		
		$dtEncerEfetivoArr = explode('/','0000/00/00');
	}		

	if(empty($dtIniComp)){
		$dtIniComp = '00/0000';
	}		

	if(empty($dtFimComp)){
		$dtFimComp = '00/0000';
	}		
	
	if( (empty($valorEfetivoPago)) && (empty($totalRevisado))){
	
	$dadosUpdt = array(
		'id_contratante' => $idContratante,	
		'id_loja' => $idLoja,
		'cod_infracao' => $infracao,				
		'data_recebimento' => $dtRecebInfraArr[2].'-'.$dtRecebInfraArr[1].'-'.$dtRecebInfraArr[0],
		'id_auto' => $tipoAuto,
		'id_classificacao' => $classInfracao,
		'motivo_infracao' => $motivInfracao,
		'relato_infracao' => $breveRelato,
		'dt_ini_competencia' => $dtIniComp ,
		'dt_fim_competencia' => $dtFimComp,
		'valor_principal' => $valorPrincipal ,
		'atualizacao_monetaria' => $atualizacaoMonetaria,
		'multa' => $multa,
		'juros' => $juros,
		'total' => $total,
		'observacoes' => $obs,
		'data_plan_fim_processo' => $dtPlanFimArr[2].'-'.$dtPlanFimArr[1].'-'.$dtPlanFimArr[0],
		'data_encerramento_real' => $dtEncerEfetivoArr[2].'-'.$dtEncerEfetivoArr[1].'-'.$dtEncerEfetivoArr[0]
		);
		
	}elseif(empty($totalRevisado)){
	
	$dadosUpdt = array(
		'id_contratante' => $idContratante,	
		'id_loja' => $idLoja,
		'cod_infracao' => $infracao,				
		'data_recebimento' => $dtRecebInfraArr[2].'-'.$dtRecebInfraArr[1].'-'.$dtRecebInfraArr[0],
		'id_auto' => $tipoAuto,
		'id_classificacao' => $classInfracao,
		'motivo_infracao' => $motivInfracao,
		'relato_infracao' => $breveRelato,
		'dt_ini_competencia' => $dtIniComp ,
		'dt_fim_competencia' => $dtFimComp,
		'valor_principal' => $valorPrincipal ,
		'atualizacao_monetaria' => $atualizacaoMonetaria,
		'multa' => $multa,
		'juros' => $juros,
		'total' => $total,
		'valor_real_pago' => $valorEfetivoPago,
		'observacoes' => $obs,
		'data_plan_fim_processo' => $dtPlanFimArr[2].'-'.$dtPlanFimArr[1].'-'.$dtPlanFimArr[0],
		'data_encerramento_real' => $dtEncerEfetivoArr[2].'-'.$dtEncerEfetivoArr[1].'-'.$dtEncerEfetivoArr[0]
		);
	}elseif(empty($valorEfetivoPago)){
	
	$dadosUpdt = array(
		'id_contratante' => $idContratante,	
		'id_loja' => $idLoja,
		'cod_infracao' => $infracao,				
		'data_recebimento' => $dtRecebInfraArr[2].'-'.$dtRecebInfraArr[1].'-'.$dtRecebInfraArr[0],
		'id_auto' => $tipoAuto,
		'id_classificacao' => $classInfracao,
		'motivo_infracao' => $motivInfracao,
		'relato_infracao' => $breveRelato,
		'dt_ini_competencia' => $dtIniComp ,
		'dt_fim_competencia' => $dtFimComp,
		'valor_principal' => $valorPrincipal ,
		'atualizacao_monetaria' => $atualizacaoMonetaria,
		'multa' => $multa,
		'juros' => $juros,
		'total' => $total,
		'valor_total_revisao' => $totalRevisado,
		'observacoes' => $obs,
		'data_plan_fim_processo' => $dtPlanFimArr[2].'-'.$dtPlanFimArr[1].'-'.$dtPlanFimArr[0],
		'data_encerramento_real' => $dtEncerEfetivoArr[2].'-'.$dtEncerEfetivoArr[1].'-'.$dtEncerEfetivoArr[0]
		);
		
	}else{
	
		$dadosUpdt = array(
		'id_contratante' => $idContratante,	
		'id_loja' => $idLoja,
		'cod_infracao' => $infracao,				
		'data_recebimento' => $dtRecebInfraArr[2].'-'.$dtRecebInfraArr[1].'-'.$dtRecebInfraArr[0],
		'id_auto' => $tipoAuto,
		'id_classificacao' => $classInfracao,
		'motivo_infracao' => $motivInfracao,
		'relato_infracao' => $breveRelato,
		'dt_ini_competencia' => $dtIniComp ,
		'dt_fim_competencia' => $dtFimComp,
		'valor_principal' => $valorPrincipal ,
		'atualizacao_monetaria' => $atualizacaoMonetaria,
		'multa' => $multa,
		'juros' => $juros,
		'total' => $total,
		'valor_total_revisao' => $totalRevisado,
		'valor_real_pago' => $valorEfetivoPago,
		'observacoes' => $obs,
		'data_plan_fim_processo' => $dtPlanFimArr[2].'-'.$dtPlanFimArr[1].'-'.$dtPlanFimArr[0],
		'data_encerramento_real' => $dtEncerEfetivoArr[2].'-'.$dtEncerEfetivoArr[1].'-'.$dtEncerEfetivoArr[0]
		);
		
    }	
		
	$dados = $this->infracao_model->listarInfracaoById($idInfracao);
	$dadosAlterados = '';
	if($dados[0]->id_loja <> $idLoja){
		$dadosAlterados .= ' - Loja : '.($dados[0]->nome_fantasia);
	}
	
	if($dados[0]->cod_infracao <> $infracao){
		$dadosAlterados .= ' - Infra. : '.$dados[0]->cod_infracao;
	}
	
	if($dados[0]->data_recebimento <> $dtRecebInfra){
		$dadosAlterados .= ' - Data Recebimento : '.$dados[0]->data_recebimento_br;
	}
	
	if($dados[0]->id_auto <> $tipoAuto){
		$dadosAlterados .= ' - Auto : '.($dados[0]->auto_desc);
	}
	
	if($dados[0]->id_classificacao <> $classInfracao){
		$dadosAlterados .= ' - Classi. : '.($dados[0]->desc_classif);
	}
	
	if($dados[0]->motivo_infracao <> $motivInfracao){
		$dadosAlterados .= ' - Motivo : '.($dados[0]->desc_motivo);
	}
	
	if($dados[0]->relato_infracao <> $breveRelato){
		$dadosAlterados .= ' - Relato : '.($dados[0]->relato_infracao);
	}
	
	if($dados[0]->dt_ini_competencia <> $dtIniComp){
		$dadosAlterados .= ' - Inicio Comp. : '.$dados[0]->dt_ini_competencia;
	}
	
	if($dados[0]->dt_fim_competencia <> $dtFimComp){
		$dadosAlterados .= ' - Fim Comp. : '.$dados[0]->dt_fim_competencia;
	}
	
	if($dados[0]->valor_principal <> $valorPrincipal){
		$dadosAlterados .= ' - Valor Principal : '.$dados[0]->valor_principal;
	}
	
	if($dados[0]->atualizacao_monetaria <> $atualizacaoMonetaria){
		$dadosAlterados .= ' - Atualiz. Monet. : '.$dados[0]->atualizacao_monetaria;
	}
	
	
	if($dados[0]->juros <> $juros){
		$dadosAlterados .= ' - Juros : '.$dados[0]->juros;
	}
	
	if($dados[0]->total <> $total){
		$dadosAlterados .= ' - Total : '.$dados[0]->total;
	}
	
	if($dados[0]->valor_total_revisao <> $totalRevisado){
		$dadosAlterados .= ' - Valor Total Revisado : '.$dados[0]->valor_total_revisao;
	}
	
	if($dados[0]->valor_real_pago <> $valorEfetivoPago){
		$dadosAlterados .= ' - Valor Real Pago : '.$dados[0]->valor_real_pago;
	}
	
	if($dados[0]->data_plan_fim_processo <> $dtPlanFim){
		$dadosAlterados .= ' - Data Plan. para Fim : '.$dados[0]->data_plan_fim_processo;
	}
	
	if($dados[0]->data_encerramento_real <> $dtEncerEfetivo){
		$dadosAlterados .= ' - Data Encer. Real : '.$dados[0]->data_encerramento_real;
	}
	
	if($dados[0]->observacoes <> $obs){
		$dadosAlterados .= ' - Obs. : '.($dados[0]->observacoes);
	}
	
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'infracoes',
	'id_usuario' => $idUsuario,
	'id_operacao' => $idInfracao,
	'tipo' => 2,
	'texto' => ($dadosAlterados),
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
	$dadosObs = array(		'id_infra'=>$idInfracao,		'data'=>date("Y-m-d"),		'hora'=>date("h:i:s"),		'id_usuario'=>$session_data['id'],		'observacao'=>$obs,		);		$this->infracao_model->addObs($dadosObs);
	if($this->infracao_model->atualiza($dadosUpdt,$idInfracao)) {
		$data['mensagem'] = 'Cadastro Atualizado com Sucesso';
	}else{	
		$data['mensagem'] = 'Algum Erro Aconteceu';
	}
	redirect('/infracoes/listar', 'refresh');
 }
 
 function editar_responsavel(){	
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$idInfracao = $this->input->get('id');
	
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);
	
	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	//$data['lojas'] = $this->loja_model->listarLojaByTipo($idContratante,1);
	$data['lojas'] = $this->infracao_model->listarTodasLojas($idContratante);
	$data['tiposAuto'] = $this->infracao_model->listarTipoAuto();
	$data['classInfra'] = $this->infracao_model->listarClassifInfra();
	$data['motivoInfra'] = $this->infracao_model->listarMotivoInfra();
	$data['posicionamento'] = $this->infracao_model->listarPosicionamento();
	$data['probabilidade'] = $this->infracao_model->listarProbabilidade();
	$data['infracao'] = $this->infracao_model->listarInfracaoById($idInfracao);
	
	$data['dadosResp'] = $this->infracao_model->listarRespById($idInfracao);
	

	$data['emitentes'] = $this->emitente_model->listarTodosEmitentes($idContratante);
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_responsavel_infracao_view', $data);
	$this->load->view('footer_pages_view');
	
}

 function inserir_responsavel(){	
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$idInfracao = $this->input->get('id');
	
		
	$data['infracao'] = $this->infracao_model->listarInfracaoById($idInfracao);
	$_SESSION["cidadeInfra"] = $data['infracao'][0]->cidade;
	$_SESSION["estadoInfra"] = $data['infracao'][0]->estado;
	$_SESSION["idInfraL"] = $data['infracao'][0]->id_loja;
	
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);
	
	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	//$data['lojas'] = $this->loja_model->listarLojaByTipo($idContratante,1);
	$data['lojas'] = $this->infracao_model->listarTodasLojas($idContratante);
	$data['tiposAuto'] = $this->infracao_model->listarTipoAuto();
	$data['classInfra'] = $this->infracao_model->listarClassifInfra();
	$data['motivoInfra'] = $this->infracao_model->listarMotivoInfra();
	$data['posicionamento'] = $this->infracao_model->listarPosicionamento();
	$data['probabilidade'] = $this->infracao_model->listarProbabilidade();
	$data['infracao'] = $this->infracao_model->listarInfracaoById($idInfracao);
	
	$data['dadosResp'] = $this->infracao_model->listarRespByIdInfra($idInfracao);
	
	$data['emitentes'] = $this->emitente_model->listarTodosEmitentes($idContratante);
	
	if(empty($_SESSION["mensagemInfra"])){
		$data['mensagemInfra'] = '';
	}else{
		$data['mensagemInfra'] = $_SESSION['mensagemInfra'];
	}	
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('outro_responsavel_infracao_view', $data);
	$this->load->view('footer_pages_view');
	
}

function export_mun(){
 
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id_mun_export = $this->input->post('id_mun_export');
	$result = $this->infracao_model->exportInfracaoByCidade($id_mun_export);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	$file="infracoes.xls";

	$test="<table border=1>
	<tr>
	<td>Id</td>
	<td>Loja</td>
	<td>CNPJ</td>
	<td>Código Infra&ccedil;&atilde;o</td>
	<td>Data Recebimento</td>
	<td>Tipo do Auto</td>
	<td>Classificação</td>
	<td>Motivo</td>
	<td>Relato</td>
	<td>Data Inicial Competência</td>
	<td>Data Final Competência</td>
	<td>Valor Principal</td>
	<td>Atualização Monetária</td>
	<td>Multa</td>
	<td>Juros</td>
	<td>Total</td>
	<td>Total Revisado</td>
	<td>Total Efetivamente Pago</td>
	<td>Data Planejada Fim Processo</td>
	<td>Data Encerramento Real</td>
	<td>Observações</td>
	<td>Responsável</td>
	<td>Data Envio ao Responsável</td>
	<td>Posicionamento Responsável</td>
	<td>Probabilidade Êxito</td>
	<td>Status Infração</td>
	<td>Alterado Por </td>
	<td>Data Altera&ccedil;&atilde;o </td>
	<td>Dados Alterados </td>	
	</tr>
	";
	if($isArray == 0){
		$test .="<tr>";
		$test .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$test .="</tr>";
	}else{
		foreach($result as $imovel){ 
			if($imovel->ativo == 0){
				$status = 'Inativo';
			}else{
				$status = 'Ativo';
			}
			$idInfracao = $imovel->id_infracao;
			$dadosLog = $this->log_model->listarLog($idInfracao,'infracoes');	
		    $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
			
			$test .="<tr>";
			$test .="<td >".($idInfracao)."</td>";
			$test .="<td >".utf8_decode($imovel->nome_fantasia)."</td>";
			$test .="<td > ".$imovel->cpf_cnpj."</td>";
			$test .="<td > ".$imovel->cod_infracao."</td>";
			$test .="<td > ".$imovel->data_recebimento_br."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_infracao)."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_classif)."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_motivo)."</td>";
			$test .="<td > ".utf8_decode($imovel->relato_infracao)."</td>";
			$test .="<td > ".$imovel->dt_ini_competencia."</td>";
			$test .="<td > ".$imovel->dt_fim_competencia."</td>";
			$test .="<td > ".$imovel->valor_principal."</td>";
			$test .="<td > ".$imovel->atualizacao_monetaria."</td>";
			$test .="<td > ".$imovel->multa."</td>";
			$test .="<td > ".$imovel->juros."</td>";
			$test .="<td > ".$imovel->total."</td>";
			$test .="<td > ".$imovel->valor_total_revisao."</td>";
			$test .="<td > ".$imovel->valor_real_pago."</td>";
			$test .="<td > ".$imovel->data_plan_fim_processo_br."</td>";
			$test .="<td > ".$imovel->data_encerramento_real_br."</td>";
			$test .="<td > ".utf8_decode($imovel->observacoes)."</td>";
			$test .="<td > ".utf8_decode($imovel->resp)."</td>";
			$test .="<td > ".$imovel->data_envio_br."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_posic)."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_prob)."</td>";
			$test .="<td > ".$status."</td>";
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
			
			
			
			$test .="</tr>";
		 
		}
	
	}
	$test .='</table>';
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $test;	
	
 
 }
 
function export_est(){
 
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id_estado_export = $this->input->post('id_estado_export');
	$result = $this->infracao_model->exportInfracaoByEstado($id_estado_export);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	$file="infracoes.xls";

	$test="<table border=1>
	<tr>
	<td>Id</td>
	<td>Loja</td>
	<td>CNPJ</td>
	<td>Código Infra&ccedil;&atilde;o</td>
	<td>Data Recebimento</td>
	<td>Tipo do Auto</td>
	<td>Classificação</td>
	<td>Motivo</td>
	<td>Relato</td>
	<td>Data Inicial Competência</td>
	<td>Data Final Competência</td>
	<td>Valor Principal</td>
	<td>Atualização Monetária</td>
	<td>Multa</td>
	<td>Juros</td>
	<td>Total</td>
	<td>Total Revisado</td>
	<td>Total Efetivamente Pago</td>
	<td>Data Planejada Fim Processo</td>
	<td>Data Encerramento Real</td>
	<td>Observações</td>
	<td>Responsável</td>
	<td>Data Envio ao Responsável</td>
	<td>Posicionamento Responsável</td>
	<td>Probabilidade Êxito</td>
	<td>Status Infração</td>
	<td>Alterado Por </td>
	<td>Data Altera&ccedil;&atilde;o </td>
	<td>Dados Alterados </td>	
	</tr>
	";
	if($isArray == 0){
		$test .="<tr>";
		$test .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$test .="</tr>";
	}else{
		foreach($result as $imovel){ 
			if($imovel->ativo == 0){
				$status = 'Inativo';
			}else{
				$status = 'Ativo';
			}
			$idInfracao = $imovel->id_infracao;
			$dadosLog = $this->log_model->listarLog($idInfracao,'infracoes');	
		    $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
			$test .="<tr>";
			$test .="<td >".($idInfracao)."</td>";
			$test .="<td >".utf8_decode($imovel->nome_fantasia)."</td>";
			$test .="<td > ".$imovel->cpf_cnpj."</td>";
			$test .="<td > ".$imovel->cod_infracao."</td>";
			$test .="<td > ".$imovel->data_recebimento_br."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_infracao)."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_classif)."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_motivo)."</td>";
			$test .="<td > ".utf8_decode($imovel->relato_infracao)."</td>";
			$test .="<td > ".$imovel->dt_ini_competencia."</td>";
			$test .="<td > ".$imovel->dt_fim_competencia."</td>";
			$test .="<td > ".$imovel->valor_principal."</td>";
			$test .="<td > ".$imovel->atualizacao_monetaria."</td>";
			$test .="<td > ".$imovel->multa."</td>";
			$test .="<td > ".$imovel->juros."</td>";
			$test .="<td > ".$imovel->total."</td>";
			$test .="<td > ".$imovel->valor_total_revisao."</td>";
			$test .="<td > ".$imovel->valor_real_pago."</td>";
			$test .="<td > ".$imovel->data_plan_fim_processo_br."</td>";
			$test .="<td > ".$imovel->data_encerramento_real_br."</td>";
			$test .="<td > ".utf8_decode($imovel->observacoes)."</td>";
			$test .="<td > ".utf8_decode($imovel->resp)."</td>";
			$test .="<td > ".$imovel->data_envio_br."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_posic)."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_prob)."</td>";
			$test .="<td > ".$status."</td>";
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
			
			
			$test .="</tr>";
		 
		}
	
	}
	$test .='</table>';
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $test;	
	
 
 }

 
function export(){
 
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id_imovel_export = $this->input->post('id_imovel_export');
	$result = $this->infracao_model->exportInfracaoByIdLoja($id_imovel_export);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	$file="infracoes.xls";

	$test="<table border=1>
	<tr>
	<td>Id</td>
	<td>Loja</td>
	<td>CNPJ</td>
	<td>Código Infra&ccedil;&atilde;o</td>
	<td>Data Recebimento</td>
	<td>Tipo do Auto</td>
	<td>Classificação</td>
	<td>Motivo</td>
	<td>Relato</td>
	<td>Data Inicial Competência</td>
	<td>Data Final Competência</td>
	<td>Valor Principal</td>
	<td>Atualização Monetária</td>
	<td>Multa</td>
	<td>Juros</td>
	<td>Total</td>
	<td>Total Revisado</td>
	<td>Total Efetivamente Pago</td>
	<td>Data Planejada Fim Processo</td>
	<td>Data Encerramento Real</td>
	<td>Observações</td>
	<td>Responsável</td>
	<td>Data Envio ao Responsável</td>
	<td>Posicionamento Responsável</td>
	<td>Probabilidade Êxito</td>
	<td>Status Infração</td>
	<td>Alterado Por </td>
	<td>Data Altera&ccedil;&atilde;o </td>
	<td>Dados Alterados </td>	
	</tr>
	";
	if($isArray == 0){
		$test .="<tr>";
		$test .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$test .="</tr>";
	}else{
		foreach($result as $imovel){ 
			if($imovel->ativo == 0){
				$status = 'Inativo';
			}else{
				$status = 'Ativo';
			}
			$idInfracao = $imovel->id_infracao;
			$dadosLog = $this->log_model->listarLog($idInfracao,'infracoes');	
		    $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
			$test .="<tr>";
			$test .="<td >".($idInfracao)."</td>";
			$test .="<td >".utf8_decode($imovel->nome_fantasia)."</td>";
			$test .="<td > ".$imovel->cpf_cnpj."</td>";
			$test .="<td > ".$imovel->cod_infracao."</td>";
			$test .="<td > ".$imovel->data_recebimento_br."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_infracao)."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_classif)."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_motivo)."</td>";
			$test .="<td > ".utf8_decode($imovel->relato_infracao)."</td>";
			$test .="<td > ".$imovel->dt_ini_competencia."</td>";
			$test .="<td > ".$imovel->dt_fim_competencia."</td>";
			$test .="<td > ".$imovel->valor_principal."</td>";
			$test .="<td > ".$imovel->atualizacao_monetaria."</td>";
			$test .="<td > ".$imovel->multa."</td>";
			$test .="<td > ".$imovel->juros."</td>";
			$test .="<td > ".$imovel->total."</td>";
			$test .="<td > ".$imovel->valor_total_revisao."</td>";
			$test .="<td > ".$imovel->valor_real_pago."</td>";
			$test .="<td > ".$imovel->data_plan_fim_processo_br."</td>";
			$test .="<td > ".$imovel->data_encerramento_real_br."</td>";
			$test .="<td > ".utf8_decode($imovel->observacoes)."</td>";
			$test .="<td > ".utf8_decode($imovel->resp)."</td>";
			$test .="<td > ".$imovel->data_envio_br."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_posic)."</td>";
			$test .="<td > ".utf8_decode($imovel->desc_prob)."</td>";
			$test .="<td > ".$status."</td>";
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
			
			$test .="</tr>";
		 
		}
	
	}
	$test .='</table>';
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $test;	
	
 
 }
 
function buscaInfraById(){
 
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->get('id');
	$result = $this->infracao_model->listarInfracaoByIdLoja($id);
	
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
		
			$idInfracao = $imovel->id_infracao;
			$retorno .="<tr>";
			$retorno .="<td width='20%' > <a href='#'>".$imovel->nome_fantasia."</a></td>";
			$retorno .="<td width='20%' > ".$imovel->cpf_cnpj."</td>";
			$retorno .="<td width='15%' > ".$imovel->cod_infracao."</td>";
			$retorno .="<td width='15%' > ".$imovel->desc_classif."</td>";
			$retorno .="<td width='15%' > ".$imovel->auto_desc."</td>";
			$retorno .="<td width='15%' >";			
			$retorno .="<a href='$base/infracoes/inserir_responsavel?id=$idInfracao' class='btn btn-primary btn-xs'><i class='fa fa-bars'></i></a>";
			$retorno .="<a href='$base/infracoes/ativar?id=$idInfracao' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/infracoes/excluir?id=$idInfracao' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";
			$retorno .="<a href='$base/infracoes/editar?id=$idInfracao' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
	
 
 }
 
 function buscaInfracaoByMunicipio(){
 
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$municipio = $this->input->get('municipio');
	$result = $this->infracao_model->listarInfracaoByCidade($idContratante,$municipio);
	
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
		
			$idInfracao = $imovel->id_infracao;
			$retorno .="<tr>";
			$retorno .="<td width='20%' > <a href='#'>".$imovel->nome_fantasia."</a></td>";
			$retorno .="<td width='20%' > ".$imovel->cpf_cnpj."</td>";
			$retorno .="<td width='15%' > ".$imovel->cod_infracao."</td>";
			$retorno .="<td width='15%' > ".$imovel->desc_classif."</td>";
			$retorno .="<td width='15%' > ".$imovel->auto_desc."</td>";
			$retorno .="<td width='15%' >";			
			$retorno .="<a href='$base/infracoes/inserir_responsavel?id=$idInfracao' class='btn btn-primary btn-xs'><i class='fa fa-bars'></i></a>";
			$retorno .="<a href='$base/infracoes/ativar?id=$idInfracao' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/infracoes/excluir?id=$idInfracao' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";
			$retorno .="<a href='$base/infracoes/editar?id=$idInfracao' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
	
 
 }
 
function buscaInfracaoByEstado(){
 
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$estado = $this->input->get('id');
	$result = $this->infracao_model->listarInfracaoByEstado($idContratante,$estado);
	
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
		
			$idInfracao = $imovel->id_infracao;
			$retorno .="<tr>";
			$retorno .="<td width='20%' > <a href='#'>".$imovel->nome_fantasia."</a></td>";
			$retorno .="<td width='20%' > ".$imovel->cpf_cnpj."</td>";
			$retorno .="<td width='15%' > ".$imovel->cod_infracao."</td>";
			$retorno .="<td width='15%' > ".$imovel->desc_classif."</td>";
			$retorno .="<td width='15%' > ".$imovel->auto_desc."</td>";
			$retorno .="<td width='15%' >";			
			$retorno .="<a href='$base/infracoes/inserir_responsavel?id=$idInfracao' class='btn btn-primary btn-xs'><i class='fa fa-bars'></i></a>";
			$retorno .="<a href='$base/infracoes/ativar?id=$idInfracao' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/infracoes/excluir?id=$idInfracao' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";
			$retorno .="<a href='$base/infracoes/editar?id=$idInfracao' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}
	//print($retorno);
	echo json_encode($retorno);
	
 
 }
 
function buscaCidadeByEstado(){	
	$id = $this->input->get('estado');
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->infracao_model->buscaCidadeById($idContratante,$id);
	
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
 
function listar(){
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$this->load->helper('Paginate_helper');        
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
	$data['estados'] = $this->infracao_model->buscaEstado($idContratante);
	$data['cidades'] = $this->infracao_model->buscaCidade($idContratante);
	$data['lojas'] = $this->infracao_model->listarLojasComInfra($idContratante);
	
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->infracao_model->listarInfracao($idContratante);
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result = $this->infracao_model->listarInfracaoByCidade($idContratante,$municipioListar);
			}else if($estadoListar <> '0'){
				$result = $this->infracao_model->listarInfracaoByEstado($idContratante,$estadoListar);				
			}else{
				$result = $this->infracao_model->listarInfracao($idContratante);
				
			}
		}else{	
			$result = $this->infracao_model->listarInfracaoByIdLoja($idImovelListar);
			
		}
	}
	
	
	
	//print_r($this->db->last_query());exit;
	$total =  $this->infracao_model->somarTodos($idContratante);
	//print_r($total);exit;
		
	if(empty($_SESSION["cidadeInfra"])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION["cidadeInfra"];
	}
	if(empty($_SESSION["estadoInfra"])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] =$_SESSION["estadoInfra"];
	}
	if(empty($_SESSION["idInfraL"])){
		$data['idInfraL'] = 0;
	}else{
		$data['idInfraL'] = $_SESSION["idInfraL"];
	}
	
	
	if(empty($_SESSION["mensagemInfra"])){
		$data['mensagemInfra'] = '';
	}else{
		$data['mensagemInfra'] = $_SESSION['mensagemInfra'];
	}	
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$data['paginacao'] = createPaginate('infracao', $total[0]->total) ;
	
	$data['infracoes'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_infracoes_view', $data);
	$this->load->view('footer_pages_view');
	
}

 function ativar(){
 
	$id = $this->input->get('id');	
	$data['infracao'] = $this->infracao_model->listarInfracaoById($id);
	$_SESSION["cidadeInfra"] = $data['infracao'][0]->cidade;
	$_SESSION["estadoInfra"] = $data['infracao'][0]->estado;
	$_SESSION["idInfraL"] = $data['infracao'][0]->id_loja;
	
	
	if($this->infracao_model->ativar($id)) {
		$_SESSION["mensagemInfra"] = 'Infração foi ativado';
	}else{	
		$_SESSION["mensagemInfra"] = 'Algum Erro Aconteceu';
	}
	
	redirect('/infracoes/listar', 'refresh');
	
 }

 function excluir_resp(){
 
	$id = $this->input->get('id');
	
	if($this->infracao_model->excluir_resp($id)) {
		
		$msg = 'Responsável foi excluído';
		echo "<script>alert('".$msg."');</script>";
	}
	
	redirect('/infracoes/listar', 'refresh');
	
 }
 
  function excluir(){
 
	$id = $this->input->get('id');
	$session_data = $_SESSION['login'];
	$data['infracao'] = $this->infracao_model->listarInfracaoById($id);
	$_SESSION["cidadeInfra"] = $data['infracao'][0]->cidade;
	$_SESSION["estadoInfra"] = $data['infracao'][0]->estado;
	$_SESSION["idInfraL"] = $data['infracao'][0]->id_loja;
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	
	if($podeExcluir[0]['total'] == 1){		
		$this->user->excluirFisicamente($id,'infracoes');
		$_SESSION['mensagemImovel'] =  CADASTRO_INATIVO;
	}else{
		if($this->infracao_model->excluir($id)) {
			$data['mensagem'] = 'Infração foi inativada';
		}else{	
			$data['mensagem'] = 'Algum Erro Aconteceu';
		}
	}	

	
	redirect('/infracoes/listar', 'refresh');
	
 }
 
 function limpar_filtro(){	
	$_SESSION["cidadeInfra"] = 0;
	$_SESSION["estadoInfra"] = 0;
	$_SESSION["idInfraL"] = 0;	
	redirect('/infracoes/listar');	

 }
 
function cadastrar(){	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);
	
	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	//$data['lojas'] = $this->loja_model->listarLojaByTipo($idContratante,1);
	$data['lojas'] = $this->infracao_model->listarTodasLojas($idContratante);
	$data['tiposAuto'] = $this->infracao_model->listarTipoAuto();
	$data['classInfra'] = $this->infracao_model->listarClassifInfra();
	$data['motivoInfra'] = $this->infracao_model->listarMotivoInfra();
	
	$data['emitentes'] = $this->emitente_model->listarEmitenteByTipo($idContratante,3);

	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_infracoes_view', $data);
	$this->load->view('footer_pages_view');
	
}

	function editar(){		 if($_SESSION['login']){		   redirect('login', 'refresh');	 }else{		 		$session_data = $_SESSION['login'];		$idContratante = $_SESSION['cliente'] ;		$idInfracao = $this->input->get('id');		$data['estados'] = $this->loja_model->buscaEstado($idContratante);		$data['cidades'] = $this->loja_model->buscaCidades($idContratante);		//$data['lojas'] = $this->loja_model->listarLojaByTipo($idContratante,1);		$data['lojas'] = $this->infracao_model->listarTodasLojas($idContratante);		$data['tiposAuto'] = $this->infracao_model->listarTipoAuto();		$data['classInfra'] = $this->infracao_model->listarClassifInfra();		$data['motivoInfra'] = $this->infracao_model->listarMotivoInfra();		$data['infracao'] = $this->infracao_model->listarInfracaoById($idInfracao);		$_SESSION["cidadeInfra"] = $data['infracao'][0]->cidade;		$_SESSION["estadoInfra"] = $data['infracao'][0]->estado;		$_SESSION["idInfraL"] = $data['infracao'][0]->id_loja;		$data['emitentes'] = $this->emitente_model->listarEmitenteByTipo($idContratante,3);				if(empty($session_data['visitante'])){			$data['visitante'] = 0;		}else{			$data['visitante'] = $session_data['visitante'];			}				$data['obs'] = $this->infracao_model->buscaTodasObservacoes($idInfracao);					$this->load->view('header_pages_view',$data);		$this->load->view('editar_infracoes_view', $data);		$this->load->view('footer_pages_view');	 }		 	 
	}

}
 
?>

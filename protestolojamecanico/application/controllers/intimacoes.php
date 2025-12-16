<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Intimacoes extends CI_Controller {

 

 function __construct(){
   parent::__construct();
   $this->load->model('email_model','',TRUE);
   $this->load->model('estado_model','',TRUE);
   $this->load->model('intimacao_model','',TRUE);		
   $this->load->model('cnpj_model','',TRUE);
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);  
   $this->load->model('parceiro_model','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');
   date_default_timezone_set('America/Sao_Paulo');
   session_start();
   header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, OPTIONS, POST');
	header('Access-Control-Allow-Headers: origin, x-requested-with,Content-Type, Content-Range, Content-Disposition, Content-Description');
	
}

 

 function index(){
   $this->logado();   
 }


function alterar_intimacao(){
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$id  = $this->input->post('id'); 
	$cnpj  = $this->input->post('cnpj'); 
	$ie  = $this->input->post('ie');
	$im  = $this->input->post('im');
	$numLanc  = $this->input->post('numLanc');  
	$numProcAdm  = $this->input->post('numProcAdm');  
	$natureza  = $this->input->post('natureza');  
	$valorPrincipal  = $this->input->post('valor_principal');
	
	$valorPrincipal = str_replace(".","",$valorPrincipal);
	$valorPrincipal = str_replace(",",".",$valorPrincipal);
	
	
	
	$total  = $this->input->post('total'); 
	$total = str_replace(".","",$total);
	$total = str_replace(",",".",$total);
	$breveRelato  = $this->input->post('breve_relato');
	$dataCiencia  = $this->input->post('data_ciencia');
	$prazo  = $this->input->post('prazo');
	$competencia_legis  = $this->input->post('competencia_legis');
	
	$nome_fiscal  = $this->input->post('nome_fiscal');
	$responsavel_fiscalizacao  = $this->input->post('responsavel_fiscalizacao');
	$numero_os  = $this->input->post('numero_os');
	$periodo_auditado_inicial  = $this->input->post('periodo_auditado_inicial');
	$periodo_auditado_final  = $this->input->post('periodo_auditado_final');
	
	if(!empty($periodo_auditado_inicial)){
		$periodo_auditado_inicial_arr = explode('/',$periodo_auditado_inicial);
		$periodo_auditado_inicial = $periodo_auditado_inicial_arr[2].'-'.$periodo_auditado_inicial_arr[1].'-'.$periodo_auditado_inicial_arr[0];
	}else{		
		$periodo_auditado_inicial = '1900-01-01';
	}
	
	if(!empty($periodo_auditado_final)){
		$periodo_auditado_final_arr = explode('/',$periodo_auditado_final);
		$periodo_auditado_final = $periodo_auditado_final_arr[2].'-'.$periodo_auditado_final_arr[1].'-'.$periodo_auditado_final_arr[0];
	}else{		
		$periodo_auditado_final = '1900-01-01';
	}
	
	if(!empty($dataCiencia)){
		$dataCienciaArr = explode('/',$dataCiencia);
		$dtCiencia = $dataCienciaArr[2].'-'.$dataCienciaArr[1].'-'.$dataCienciaArr[0];
	}else{		
		$dtCiencia = '1900-01-01';
	}	
	if(!empty($prazo)){
		$prazoArr = explode('/',$prazo);
		$dtPrazo = $prazoArr[2].'-'.$prazoArr[1].'-'.$prazoArr[0];
	}else{		
		$dtPrazo = '1900-01-01';
	}	
	
	if(empty($ie)){
		$ie = 0;	
	}
	
	if(empty($im)){
		$im = 0;	
	}

	$dados = array(
		'num_lancamento' => $numLanc,
		'num_processo' => $numProcAdm,
		'valor_principal' => $valorPrincipal,
		'total' => $total,
		'id_natureza' => $natureza,
		'id_competencia_legis' => $competencia_legis,
		'relato_infracao' => $breveRelato,
		'nome_fiscal' => $nome_fiscal,
		'responsavel_fiscalizacao' => $responsavel_fiscalizacao,
		'numero_os' => $numero_os,
		'periodo_auditado_inicial' =>  $periodo_auditado_inicial,
		'periodo_auditado_final' =>  $periodo_auditado_final
		);		
		
	$id = $this->intimacao_model->atualizar('intimacoes',$dados,$id);
			
	
	redirect('/intimacoes/listar/1', 'refresh');
 }

 
function salvar_area_fiscal(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$id_intimacao = $this->input->post('id_intimacao');
	$id_intimacao_af = $this->input->post('id_intimacao_af');
	$classificacao = $this->input->post('classificacao');
	$tipo_intimacao = $this->input->post('tipo_intimacao');
	$data_previa_atendimento = $this->input->post('data_previa_atendimento');
	$data_final = $this->input->post('data_final');
	$valores_defensaveis = $this->input->post('valores_defensaveis');
	$valores_indefensaveis = $this->input->post('valores_indefensaveis');
	$status_fiscal = $this->input->post('status_fiscal');
	$cp_compl_um_fiscal = $this->input->post('cp_compl_um_fiscal');
	$cp_compl_dois_fiscal = $this->input->post('cp_compl_dois_fiscal');
	$cp_compl_tres_fiscal = $this->input->post('cp_compl_tres_fiscal');
	$cp_compl_quatro_fiscal = $this->input->post('cp_compl_quatro_fiscal');
	$cp_compl_cinco_fiscal = $this->input->post('cp_compl_cinco_fiscal');

	
	$valores_defensaveis = str_replace(".","",$valores_defensaveis);
	$valores_defensaveis = str_replace(",",".",$valores_defensaveis);
	
	$valores_indefensaveis = str_replace(".","",$valores_indefensaveis);
	$valores_indefensaveis = str_replace(",",".",$valores_indefensaveis);
	
	
	if(!empty($data_previa_atendimento)){
		$data_previa_atendimento_arr = explode('/',$data_previa_atendimento);
		$data_previa_atendimento = $data_previa_atendimento_arr[2].'-'.$data_previa_atendimento_arr[1].'-'.$data_previa_atendimento_arr[0];
	}else{		
		$data_previa_atendimento = '0';
	}
	
	if(!empty($data_final)){
		$data_final_arr = explode('/',$data_final);
		$data_final = $data_final_arr[2].'-'.$data_final_arr[1].'-'.$data_final_arr[0];
	}else{		
		$data_final = '0';
	}
	
	$dados = array(
		'id_intimacao' => $id_intimacao,
		'id_classificacao' => $classificacao,
		'tipo_intimacao' => $tipo_intimacao,
		'data_previa_atendimento' => $data_previa_atendimento,
		'data_final' => $data_final,
		'valores_defensaveis' => $valores_defensaveis,
		'valores_indefensaveis' => $valores_indefensaveis,
		'status_fiscal' => $status_fiscal,
		'campo_complementar_um' => $cp_compl_um_fiscal,
		'campo_complementar_dois' =>  $cp_compl_dois_fiscal,
		'campo_complementar_tres' => $cp_compl_tres_fiscal,
		'campo_complementar_quatro' => $cp_compl_quatro_fiscal,
		'campo_complementar_cinco' => $cp_compl_cinco_fiscal,
		);		
	if(!empty($id_intimacao_af)){	
		$id = $this->intimacao_model->atualizar('intimacoes_area_fiscal',$dados,$id_intimacao_af);
	}else{
		$id = $this->intimacao_model->add_area_fiscal($dados);
	}
	
			
	
	redirect('/intimacoes/editar?id='.$id_intimacao, 'refresh');
 }
 

function salvar_area_juridica(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$id_intimacao = $this->input->post('id_intimacao');
	$id_intimacao_aj = $this->input->post('id_intimacao_aj');
	
	$data_previa_analise = $this->input->post('data_previa_analise');
	$escritorio_parceiro = $this->input->post('escritorio_parceiro');
	$data_previa_atendimento = $this->input->post('data_previa_analise');
	$status_juridico = $this->input->post('status_juridico');
	$cp_compl_um_juridico = $this->input->post('cp_compl_um_juridico');
	$cp_compl_dois_juridico = $this->input->post('cp_compl_dois_juridico');
	$cp_compl_tres_juridico = $this->input->post('cp_compl_tres_juridico');
	$cp_compl_quatro_juridico = $this->input->post('cp_compl_quatro_juridico');
	$cp_compl_cinco_juridico = $this->input->post('cp_compl_cinco_juridico');
	
	if(!empty($data_previa_atendimento)){
		$data_previa_atendimento_arr = explode('/',$data_previa_atendimento);
		$data_previa_atendimento = $data_previa_atendimento_arr[2].'-'.$data_previa_atendimento_arr[1].'-'.$data_previa_atendimento_arr[0];
	}else{		
		$data_previa_atendimento = '1111-11-11';
	}

	$dados = array(
		'id_intimacao' => $id_intimacao,
		'data_previa_analise' => $data_previa_atendimento,
		'escritorio_parceiro' => $escritorio_parceiro,
		'status_juridico' => $status_juridico,
		'campo_complementar_um' => $cp_compl_um_juridico,
		'campo_complementar_dois' =>  $cp_compl_dois_juridico,
		'campo_complementar_tres' => $cp_compl_tres_juridico,
		'campo_complementar_quatro' => $cp_compl_quatro_juridico,
		'campo_complementar_cinco' => $cp_compl_cinco_juridico,
		);	
	
	if(!empty($id_intimacao_aj)){	
		$id = $this->intimacao_model->atualizar('intimacoes_area_juridica',$dados,$id_intimacao_aj);
	}else{
		$id = $this->intimacao_model->add_area_juridica($dados);
	}
	
	redirect('/intimacoes/editar?id='.$id_intimacao, 'refresh');
 }

	function editar(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$id = $this->input->get('id');
		if($id){
			if(empty($_SESSION['login_walmart']['modulo'])){
				$_SESSION['login_walmart']['modulo'] = 0;	
			}
			$data['dados'] = $this->intimacao_model->listarInfracaoById($id);
			
			
			$data['tratativas_fiscais'] =  $this->intimacao_model->listarTodasTratativas($idContratante,$id,1);
			$data['tratativas_juridicas'] =  $this->intimacao_model->listarTodasTratativas($idContratante,$id,2);
			$data['natureza_raiz'] = $this->intimacao_model->listarNaturezaRaiz();
			$data['esferas'] = $this->intimacao_model->listarEsfera();
			$data['etapas'] = $this->intimacao_model->listarEtapa();
			$data['area_focal'] = $this->intimacao_model->listarAreaFocal();
			$data['statusInterno'] = $this->intimacao_model->listarStatusInterno();
			
			
			$this->load->view('header_pages_fiscal_view',$data);
			$this->load->view('intimacoes/editar_intimacoes_view', $data);
			$this->load->view('footer_pages_view');
		}else{
			 redirect('login', 'refresh');
		}
	}

 function listarCompetenciaJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	echo json_encode($this->infracao_model->listarCompetencia());
  
 }
 
 function listarNaturezaJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	echo json_encode($this->infracao_model->listarNatureza());
  
 }
 
 function listarParceiroJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	echo json_encode( $this->parceiro_model->listarParceiro(0));
  
 }
 
	
	function atualizar_cnd_mob_tratativa_unica(){
	 
	 $this->logado();
	 
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'];	
	$idUsu = $session_data['id'];


	$acao 	= $this->input->post('acao');
		
	$data_entrada_cadin 	= $this->input->post('data_entrada_cadin');
	$modulo 	= $this->input->post('modulo');
	
	
	if(empty($data_entrada_cadin)){
		$dtCadin = '1111-11-11';	
	}else{
		$dtCadinArr = explode("/",$data_entrada_cadin);	
		$dtCadin = $dtCadinArr[2].'-'.$dtCadinArr[1].'-'.$dtCadinArr[0];
	}
	$id_cnd 	= $this->input->post('id_intimacao');
	$tipo_tratativa_escolhido 	= $this->input->post('tipo_tratativa');
	if(empty($tipo_tratativa_escolhido)){
		$tipo_tratativa_bd = $this->input->post('tipo_tratativa_bd');
		if(empty($tipo_tratativa_bd)){
			$tipo_tratativa = 0;
		}else{
			$tipo_tratativa =$tipo_tratativa_escolhido;
		}
	}else{
		$tipo_tratativa =$tipo_tratativa_escolhido;
	}
	$id_tratativa 	= $this->input->post('id_tratativa');
	$id_pendencia 	= $this->input->post('id_pendencia');
	$id_esfera 	= $this->input->post('id_esfera');
	$id_etapa 	= $this->input->post('id_etapa');
	$data_informe_pendencia 	= $this->input->post('data_informe_pendencia');
	$id_sis_ext 	= $this->input->post('id_sis_ext');
	$data_inclusao_sis_ext 	= $this->input->post('data_inclusao_sis_ext');
	$prazo_solucao_sis_ext 	= $this->input->post('prazo_solucao_sis_ext');
	$data_encerramento_sis_ext 	= $this->input->post('data_encerramento_sis_ext');
	$status_chamado_sis_ext 	= $this->input->post('status_chamado_sis_ext');
	$id_sla = $this->input->post('id_sla');
	$id_natureza_raiz = $this->input->post('id_natureza_raiz');
	$id_area_focal = $this->input->post('id_area_focal');
	
	if(empty($id_sla)){
		$id_sla = 0;
	}
	$usu_inc 	= $this->input->post('usu_inc');
	$area_focal 	= $this->input->post('area_focal');
	$sub_area_focal 	= $this->input->post('sub_area_focal');
	$contato 	= $this->input->post('contato');
	$data_envio 	= $this->input->post('data_envio');
	$prazo_solucao 	= $this->input->post('prazo_solucao');
	$data_retorno 	= $this->input->post('data_retorno');
	$sla 	= $this->input->post('sla');
	$status_demanda 	= $this->input->post('status_demanda');
	$esc_data_prazo_um 	= $this->input->post('esc_data_prazo_um');
	$esc_data_retorno_um 	= $this->input->post('esc_data_retorno_um');
	$esc_status_um 	= $this->input->post('esc_status_um');
	$esc_data_prazo_dois 	= $this->input->post('esc_data_prazo_dois');
	$esc_data_retorno_dois 	= $this->input->post('esc_data_retorno_dois');
	$esc_status_dois 	= $this->input->post('esc_status_dois');
	$esc_data_prazo_tres 	= $this->input->post('esc_data_prazo_tres');
	$esc_data_retorno_tres 	= $this->input->post('esc_data_retorno_tres');
	$esc_status_tres 	= $this->input->post('esc_status_tres');
	$nova_tratativa 	= $this->input->post('nova_tratativa');
	$valorPendencia 	= $this->input->post('valorPendencia');
	//$valorPendencia = str_replace(".","",$valorPendencia);
	//$valorPendencia = str_replace(",",".",$valorPendencia);
	
	if(empty($valorPendencia)){
		$valorPendencia 	='0,0';
	}
	

	
	if(empty($data_informe_pendencia)){
		$dtInforme = '1111-11-11';	
	}else{
		
		if($data_informe_pendencia == '00/00/0000'){
			$dtInforme = '1111-11-11';	
		}else{
			$dataInformeArr = explode("/",$data_informe_pendencia);	
			$dtInforme = $dataInformeArr[2].'-'.$dataInformeArr[1].'-'.$dataInformeArr[0];
		}
		
		
	}
	
	if(empty($data_inclusao_sis_ext)){
		$dtInclusaoSisExt = '1111-11-11';	
	}else{
		
		if($data_inclusao_sis_ext == '00/00/0000'){
			$dtInclusaoSisExt = '1111-11-11';	
		}else{
			$dataInformeArr = explode("/",$data_inclusao_sis_ext);	
			$dtInclusaoSisExt = $dataInformeArr[2].'-'.$dataInformeArr[1].'-'.$dataInformeArr[0];
		}
		
		
		
	}
	
	if(empty($prazo_solucao_sis_ext)){
		$dtSolSisExt = '1111-11-11';	
	}else{
		
		if($prazo_solucao_sis_ext == '00/00/0000'){
			$dtSolSisExt = '1111-11-11';	
		}else{
			$dataSolArr = explode("/",$prazo_solucao_sis_ext);	
			$dtSolSisExt = $dataSolArr[2].'-'.$dataSolArr[1].'-'.$dataSolArr[0];
		}
		
		
	}
	
	if(empty($data_encerramento_sis_ext)){
		$dtEncerSisExt = '1111-11-11';	
	}else{
		if($data_encerramento_sis_ext == '00/00/0000'){
			$dtEncerSisExt = '1111-11-11';	
		}else{
			$dataEncerramentoSisExtArr = explode("/",$data_encerramento_sis_ext);
			$dtEncerSisExt = $dataEncerramentoSisExtArr[2].'-'.$dataEncerramentoSisExtArr[1].'-'.$dataEncerramentoSisExtArr[0];
		}
		
	}
	
	if(empty($prazo_solucao)){
		$dtPrazoSolucao = '1111-11-11';	
	}else{
		
		if($prazo_solucao == '00/00/0000'){
			$dtPrazoSolucao = '1111-11-11';	
		}else{
			$dtPrazoSolucaoArr = explode("/",$prazo_solucao);
			$dtPrazoSolucao = $dtPrazoSolucaoArr[2].'-'.$dtPrazoSolucaoArr[1].'-'.$dtPrazoSolucaoArr[0];
		}
		
		
	}
	
	if(empty($data_envio)){
		$dtEnvio = '1111-11-11';	
	}else{
		
		if($data_envio == '00/00/0000'){
			$dtEnvio = '1111-11-11';	
		}else{
			$dataEnvioArr = explode("/",$data_envio);
			$dtEnvio = $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0];
		}
		
		
		
	}
	
	if(empty($data_retorno)){
		$dtRetorno = '1111-11-11';	
	}else{
		
		if($data_retorno == '00/00/0000'){
			$dtRetorno = '1111-11-11';	
		}else{
			$dataRetornoArr = explode("/",$data_retorno);
			$dtRetorno = $dataRetornoArr[2].'-'.$dataRetornoArr[1].'-'.$dataRetornoArr[0];
		}
		
		
		
	}
	
	if(empty($esc_data_prazo_um)){
		$escDtPrazoUm = '1111-11-11';	
	}else{
		
		if($esc_data_prazo_um == '00/00/0000'){
			$escDtPrazoUm = '1111-11-11';	
		}else{
			$escDataPrazoUmArr = explode("/",$esc_data_prazo_um);
			$escDtPrazoUm = $escDataPrazoUmArr[2].'-'.$escDataPrazoUmArr[1].'-'.$escDataPrazoUmArr[0];
		}
		
		
	}
	
	if(empty($esc_data_retorno_um)){
		$escDtRetUm = '1111-11-11';	
	}else{
		
		if($esc_data_retorno_um == '00/00/0000'){
			$escDtRetUm = '1111-11-11';	
		}else{
			$escDataPrazoUmArr = explode("/",$esc_data_retorno_um);
			$escDtRetUm = $escDataPrazoUmArr[2].'-'.$escDataPrazoUmArr[1].'-'.$escDataPrazoUmArr[0];
		}
		
		
	}
	
	if(empty($esc_data_prazo_dois)){
		$escDtPrazoDois = '1111-11-11';	
	}else{
		
		if($esc_data_prazo_dois == '00/00/0000'){
			$escDtPrazoDois = '1111-11-11';	
		}else{
			$escDataPrazoDoisArr = explode("/",$esc_data_prazo_dois);
			$escDtPrazoDois = $escDataPrazoDoisArr[2].'-'.$escDataPrazoDoisArr[1].'-'.$escDataPrazoDoisArr[0];
		}
		
		
	}
	
	if(empty($esc_data_retorno_dois)){
		$escDtRetDois = '1111-11-11';	
	}else{
		
		if($esc_data_retorno_dois == '00/00/0000'){
			$escDtPrazoDois = '1111-11-11';	
		}else{
			$escDataRetornoDoisArr = explode("/",$esc_data_retorno_dois);
			$escDtPrazoDois = $escDataRetornoDoisArr[2].'-'.$escDataRetornoDoisArr[1].'-'.$escDataRetornoDoisArr[0];
		}
		
		
	}
	

	if(empty($esc_data_prazo_tres)){
		$escDtPrazoTres = '1111-11-11';	
	}else{
		
		if($esc_data_prazo_tres == '00/00/0000'){
			$escDtPrazoTres = '1111-11-11';	
		}else{
			$escDataPrazoTresArr = explode("/",$esc_data_prazo_tres);
			$escDtPrazoTres = $escDataPrazoTresArr[2].'-'.$escDataPrazoTresArr[1].'-'.$escDataPrazoTresArr[0];
		}
		
		
	}
	
	if(empty($esc_data_retorno_tres)){
		$escDtRetTres = '1111-11-11';	
	}else{
		
		if($esc_data_retorno_tres == '00/00/0000'){
			$escDtRetTres = '1111-11-11';	
		}else{
			$escDataRetornoDoisArr = explode("/",$esc_data_retorno_tres);
			$escDtRetTres = $escDataRetornoDoisArr[2].'-'.$escDataRetornoDoisArr[1].'-'.$escDataRetornoDoisArr[0];
		}
		
		
	}

	
	$dados = array(

		'id_contratante' => $idContratante,
		'tipo_tratativa' => $tipo_tratativa,
		'id_sis_ext' => $id_sis_ext,
		'id_cnd_mob' => $id_cnd,
		'pendencia' => $id_pendencia,
		'esfera' => $id_esfera,
		'etapa' => $id_etapa,
		'data_informe_pendencia' => $dtInforme ,
		'data_inclusao_sis_ext' => $dtInclusaoSisExt,
		'prazo_solucao_sis_ext' => $dtSolSisExt ,
		'data_encerramento_sis_ext' => $dtEncerSisExt,
		'sla_sis_ext' => $id_sla,
		'status_chamado_sis_ext' => $status_chamado_sis_ext , 
		'usu_inc' => $usu_inc,
		'area_focal' => $area_focal,
		'sub_area_focal' => $sub_area_focal,
		'contato' => $contato ,
		'data_envio' =>$dtEnvio,
		'prazo_solucao' => $dtPrazoSolucao,
		'data_retorno' =>$dtRetorno,
		'sla' => $sla,
		'status_demanda' => $status_demanda,
		'esc_data_prazo_um' =>$escDtPrazoUm,
		'esc_data_retorno_um' =>$escDtRetUm,
		'esc_status_um' => $esc_status_um,
		'esc_data_prazo_dois' =>$escDtPrazoDois,
		'esc_data_retorno_dois' =>$escDtRetDois,
		'esc_status_dois' => $esc_status_dois ,
		'esc_data_prazo_tres' =>$escDtPrazoTres,
		'esc_data_retorno_tres' =>$escDtRetTres ,
		'esc_status_tres' => $esc_status_tres,
		'modulo'=>$modulo,
		'id_natureza_raiz'=>$id_natureza_raiz,
		'id_area_focal'=>$id_area_focal,
		'valor_pendencia'=>$valorPendencia,
		'data_atualizacao' => date("Y-m-d H:i:s") 

		);

		if($acao == 1){
			$id_tratativa = $this->intimacao_model->add_tratativa($dados);			
		}else{
			$this->intimacao_model->atualizar_tratativa($dados,$id_tratativa);
					
		}
		//print_r($this->db->last_query());exit;
		
		//guardando id para abrir novamente apos salvar
		$_SESSION['idTratativa'] = $id_tratativa;
		

		
		if(($status_chamado_sis_ext <> 1) && ($status_chamado_sis_ext <> 0)){
			
			if(!empty($nova_tratativa)){
				$dadosNovaTratativa = array(	
				'id_contratante' => $idContratante,
				'id_cnd_trat' => $id_tratativa,
				'observacao' =>$nova_tratativa,
				'id_usuario' => $idUsu,
				'data' => date("Y-m-d"),
				'hora'=> date("H:i:s"),
				'modulo'=>$modulo,
				'data_hora' => date("Y-m-d H:i:s") 
			
				);
				$this->intimacao_model->addObsTrat($dadosNovaTratativa);
			}
		
			$email = $this->user->buscaEmailById($idUsu);
			
			$dadosNovaTratativa = array(	
			'id_contratante' => $idContratante,
			'id_cnd_trat' => $id_tratativa,
			'observacao' =>'Tratativa Cancelada/Encerrada',
			'id_usuario' => $idUsu,
			'data' => date("Y-m-d"),
			'hora'=> date("H:i:s"),
			'modulo'=>$modulo,
			'data_hora' => date("Y-m-d H:i:s") 
		
			);
			$this->intimacao_model->addObsTrat($dadosNovaTratativa);
			
		}else{
			
			$dados =  $this->intimacao_model->listarObsTratById($id_tratativa);
			$isArray =  is_array($dados) ? '1' : '0';

			if($isArray == 0){
			
				$email = $this->user->buscaEmailById($idUsu);
				
				$dadosNovaTratativa = array(	
				'id_contratante' => $idContratante,
				'id_cnd_trat' => $id_tratativa,
				'observacao' =>'Tratativa Aberta',
				'id_usuario' => $idUsu,
				'data' => date("Y-m-d"),
				'hora'=> date("H:i:s"),
				'modulo'=>$modulo,
				'data_hora' => date("Y-m-d H:i:s") 		
				);
				$this->intimacao_model->addObsTrat($dadosNovaTratativa);
			}
			
			if(!empty($nova_tratativa)){
				$dadosNovaTratativa = array(	
				'id_contratante' => $idContratante,
				'id_cnd_trat' => $id_tratativa,
				'observacao' =>$nova_tratativa,
				'id_usuario' => $idUsu,
				'data' => date("Y-m-d"),
				'hora'=> date("H:i:s"),
				'modulo'=>$modulo,
				'data_hora' => date("Y-m-d H:i:s") 
			
				);
				$this->intimacao_model->addObsTrat($dadosNovaTratativa);
			}

		}
		
	redirect('/intimacoes/editar?id='.$id_cnd);

		
}

	
	
 function listarIntimacaoJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	echo json_encode($this->intimacao_model->listarTipoIntimacao());
  
 }
 
  function listarTributoJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	echo json_encode($this->intimacao_model->listarTributo());
  
 }
 
   function listarClassificacaoTributoJson($tributo){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	echo json_encode($this->intimacao_model->listarClassificacaoTributo($tributo));
  
 }
 
 function listarEstadoIntimacaoJson($ano){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	echo json_encode($this->intimacao_model->listarEstadoIntimacaoJson($ano));
  
 }
 
  function listarClassificacaoIntimacaoJson($estado,$ano){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	echo json_encode($this->intimacao_model->listarClassificacaoJson($estado,$ano));
  
 }
 
 
  function resumo_ano(){	
  
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	if($session_data['primeiro_acesso'] == 0){
		redirect('home/perfil', 'refresh');	
	}	 
	if($_POST){
		$ano = 	 $this->input->post('ano');
		$_SESSION['estadoFiltroNot'] = $estado = $this->input->post('estado');
		$data['grafico'] = 1;
		if($ano == 0){
			$data['grafico'] = 0;
		}	
		$idClassificacao = $this->input->post('id_classificacao');
	}else{
		$ano = 	 '0';
		$_SESSION['estadoFiltroNot'] = $estado = 0;
		$data['grafico'] = 0;
		$idClassificacao = 0;
	}
	$data['ano'] = $ano;
	$data['idClassificacao'] = $idClassificacao;
	$data['classificacao'] = $this->intimacao_model->listarClassificacao(0);
	$data['anos'] = $this->intimacao_model->listarAnos();
	$data['dados'] = $this->intimacao_model->listarResumoAno($ano,$estado,$idClassificacao);
	//print_r($this->db->last_query());exit;
	$this->load->view('header_pages_fiscal_view',$data);
	$this->load->view('intimacoes/listar_resumo_ano_view', $data);
	$this->load->view('footer_pages_view');

 }
 
 function classificacao_ano(){	
	
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	if($session_data['primeiro_acesso'] == 0){
		redirect('home/perfil', 'refresh');	
	}	 
	if($_POST){
		$ano = 	 $this->input->post('ano');
		$data['grafico'] = 1;
		if($ano == 0){
			$data['grafico'] = 0;
		}	
		$idClassificacao = $this->input->post('id_classificacao');
	}else{
		$ano = 	 '0';
		$data['grafico'] = 0;
		$idClassificacao = 0;
	}
	$data['ano'] = $ano;
	$data['idClassificacao'] = $idClassificacao;
	$data['classificacao'] = $this->intimacao_model->listarClassificacaoTributo(0);
	$data['anos'] = $this->intimacao_model->listarAnos();
	$data['dados'] = $this->intimacao_model->listarClassificacaoAno($ano,$idClassificacao);
	//print_r($this->db->last_query());exit;
	$this->load->view('header_pages_fiscal_view',$data);
	$this->load->view('intimacoes/listar_classificacao_ano_view', $data);
	$this->load->view('footer_pages_view');

 }
 
 function plano_acao(){	
	
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	

	$data['grafico'] =$i=0;
	
	$arrayDados = array();
	$data['classificacao']  = $this->intimacao_model->listarClassificacao(0);	
	$data['empresas']  = $this->intimacao_model->listarEmpresa();	
	$empresas  = $this->intimacao_model->listarEmpresa();	
	
	$classificacoes  = $this->intimacao_model->listarClassificacao(0);	
	// $arrayDados[$i]['classificacao'] = '-';
	// foreach($empresas as $emp){
		// $arrayDados[$i]['vd-'.$emp->descricao_empresa] = $i;
		// $arrayDados[$i]['vp-'.$emp->descricao_empresa] = $i;
	// }
	// $i = 1;
	foreach($classificacoes as $class){
		
		$arrayDados[$i]['classificacao'] = $class->desc_classificacao;
		foreach($empresas as $emp){
			$dados = $this->intimacao_model->totalizarValor('vd',$emp->id,$class->id_classificacao);
			$arrayDados[$i]['vd-'.$emp->descricao_empresa] = $dados[0]->total_valor;
			$dados = $this->intimacao_model->totalizarValor('vp',$emp->id,$class->id_classificacao);
			$arrayDados[$i]['vp-'.$emp->descricao_empresa] = $dados[0]->total_valor;
		}
		
		
		// $arrayDados[$i]['valor_defensavel'] = $dados[0]->total_valor;
		// $dados = $this->intimacao_model->totalizarValor('vp',1,$class->id_classificacao);
		// $arrayDados[$i]['valor_principal'] = $dados[0]->total_valor;
		// $dados = $this->intimacao_model->totalizarValor('vd',2,$class->id_classificacao);
		// $arrayDados[$i]['valor_defensavel'] = $dados[0]->total_valor;
		// $dados = $this->intimacao_model->totalizarValor('vp',2,$class->id_classificacao);
		// $arrayDados[$i]['valor_principal'] = $dados[0]->total_valor;
		// $dados = $this->intimacao_model->totalizarValor('vd',3,$class->id_classificacao);
		// $arrayDados[$i]['valor_defensavel'] = $dados[0]->total_valor;
		// $dados = $this->intimacao_model->totalizarValor('vp',3,$class->id_classificacao);
		// $arrayDados[$i]['valor_principal'] = $dados[0]->total_valor;
		// $dados = $this->intimacao_model->totalizarValor('vd',4,$class->id_classificacao);
		// $arrayDados[$i]['valor_defensavel'] = $dados[0]->total_valor;
		// $dados = $this->intimacao_model->totalizarValor('vp',5,$class->id_classificacao);
		// $arrayDados[$i]['valor_principal'] = $dados[0]->total_valor;
		// $dados = $this->intimacao_model->totalizarValor('vd',5,$class->id_classificacao);
		// $arrayDados[$i]['valor_defensavel'] = $dados[0]->total_valor;
		// $dados = $this->intimacao_model->totalizarValor('vp',5,$class->id_classificacao);
		// $arrayDados[$i]['valor_principal'] = $dados[0]->total_valor;
		$i++;
	}	

	$data['valores'] = $arrayDados;

	//print_r($arrayDados);exit;
	$this->load->view('header_pages_fiscal_view',$data);
	$this->load->view('intimacoes/listar_plano_acao_view', $data);
	$this->load->view('footer_pages_view');

 }
 
 function grafico_intimacao_estado(){	
	
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	if(empty($_POST)){
		$ano = date("Y");
	}else{
		$ano = $this->input->post('ano');
	}
	$data['ano'] = $ano;
	$data['intimacao_classificacao']  = $this->intimacao_model->listarIntimacaoClassificacao($ano);	
	$data['anos'] = $this->intimacao_model->listarAnos();

	$this->load->view('header_pages_fiscal_view',$data);
	$this->load->view('intimacoes/grafico_intimacao_estado_view', $data);
	$this->load->view('footer_pages_view');

 }
 
  function grafico_responsavel_fiscalizacao(){	
	
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	if(empty($_POST)){
		$ano = date("Y");
	}else{
		$ano = $this->input->post('ano');
	}
	$data['ano'] = $ano;
	$data['intimacao_classificacao']  = $this->intimacao_model->listarFiscalizacao($ano);	
	$data['anos'] = $this->intimacao_model->listarAnos();

	$this->load->view('header_pages_fiscal_view',$data);
	$this->load->view('intimacoes/grafico_responsavel_fiscalizacao_view', $data);
	$this->load->view('footer_pages_view');

 }
 
   function grafico_tributo(){	
	
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	if(empty($_POST)){
		$tributo = 0;
	}else{
		$tributo = $this->input->post('tributo');
	}
	$data['tributo'] = $tributo;
	$data['tributos'] = $this->intimacao_model->listarTributo();
	$classificacoes =  $this->intimacao_model->listarClassificacaoTributo($tributo);
	
	$anos = $this->intimacao_model->listarAnos();
	$classificacao = $descClassificacao =  array();
	$i=0;
	
	foreach($classificacoes as $class){		
		$descClassificacao[] = $class->descricao_tributo_classificacao; 
	}
	
	foreach($anos as $ano){
		//$descClassificacao[] = $ano->ano; 
		foreach($classificacoes as $class){
			$dadosClassificacao = $this->intimacao_model->listarTributoClassificacaoPorAno($class->id,$ano->ano);			
			if($dadosClassificacao[0]->total){
				$classificacao[$ano->ano][] = $dadosClassificacao[0]->total; 
			}else{
				$classificacao[$ano->ano][] = 0; 
			}
		}
	
	}
	
	$data['letras'] =  $letras = array(1=>'a',2=>'b',3=>'c',4=>'d',5=>'e',6=>'f',7=>'g',8=>'h',9=>'i',10=>'j',11=>'k',12=>'l',13=>'m',14=>'n',15=>'o',16=>'p',17=>'q',18=>'s',19=>'t',20=>'u');
	$data['cores'] =  $cores = array(1=>'#555',2=>'#888',3=>'#B0C4DE',4=>'#7FFFD4',5=>'#006400',6=>'#DAA520',7=>'#A0522D',8=>'#BA55D3',9=>'#FF1493',10=>'#B22222',11=>'#FF8C00',12=>'#F0E68C',13=>'#B0E0E6',14=>'#FF0000',15=>'#FFFF00',16=>'#FF1493',17=>'#4B0082',18=>'6B8E23',19=>'#9ACD32',20=>'#708090');
	
	$data['valoresGrafico'] = $classificacao;
	$data['descClassificacao'] = $descClassificacao;
	$this->load->view('header_pages_fiscal_view',$data);
	$this->load->view('intimacoes/grafico_tributo_view', $data);
	$this->load->view('footer_pages_view');

 }
 
  function grafico_escritorio_parceiro(){	
	
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	if(empty($_POST)){
		$ano = date("Y");
	}else{
		$ano = $this->input->post('ano');
	}
	$data['ano'] = $ano;
	$data['intimacao_classificacao']  = $this->intimacao_model->listarEscritorioParceiro($ano);	
	$data['anos'] = $this->intimacao_model->listarAnos();

	$this->load->view('header_pages_fiscal_view',$data);
	$this->load->view('intimacoes/grafico_escritorio_parceiro_view', $data);
	$this->load->view('footer_pages_view');

 }
 
 function pegarValor(){	
	
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$idDecode = $this->input->get('id');
	$id =  base64_decode($idDecode);
	
	$idArr = explode("|",$id);
	
	$tipo = $idArr[0];
	$idEmpresa = $idArr[1];
	$idClassificacao = $idArr[2];
	
	
	$dados = $this->intimacao_model->totalizarValor($tipo,$idEmpresa,$idClassificacao);
	if(!$dados[0]->total_valor){
		$dados[0]->total_valor = '0';
	}
	$dados[0]->total_valor = number_format($dados[0]->total_valor, 2, ',', '.');
	echo json_encode($dados[0]->total_valor);
	exit;

 }
 
  function status($id,$status){	
	
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	if($session_data['primeiro_acesso'] == 0){
		redirect('home/perfil', 'refresh');	
	}	 
	$dados = array(
		'status' => $status,		
		);		
		
	$id = $this->intimacao_model->atualizar('intimacoes',$dados,$id);
	$mensagem = '';
	if($status == 0){
		$mensagem = 'Intimação Inativada';	
		$statusRedirect = 1;
	}else{
		$mensagem = 'Intimação Ativada';		
		$statusRedirect = 0;
	}
		
	$this->session->set_flashdata('mensagem',$mensagem);
	redirect('intimacoes/listar/'.$statusRedirect);
	

 }
	function listar($status){
		
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['perfil'] = $session_data['perfil'];		
		$data['mensagem'] = $this->session->flashdata('mensagem');
		$data['status'] = $status;
		if(empty($_POST)){
			$_SESSION['estadoFiltroInfra'] = $_SESSION['cidadeFiltroInfra'] = $_SESSION['cnpjFiltroInfra'] = 0;
			$data['dados'] = $this->intimacao_model->listarInfracoes(0,0,0,0,0,0,0,0,$status);
		}else{
			
			$_SESSION['estadoFiltroInfra'] = $estado = $this->input->post('estado');
			$_SESSION['cidadeFiltroInfra'] = $cidade = $this->input->post('cidade');
			$cnpjRaiz = $this->input->post('cnpjRaiz');
			$_SESSION['cnpjFiltroInfra'] = $cnpj = $this->input->post('cnpj');
			$campo = $this->input->post('campo');
			$textoProcura = $this->input->post('textoProcura');
			$data1 = $this->input->post('data1');
			$data2 = $this->input->post('data2');
			
			$data['dados'] = $this->intimacao_model->listarInfracoes($estado,$cidade,$cnpjRaiz,$cnpj,$campo,$textoProcura,$data1,$data2,$status);
		}
		
		$data['emails'] = $this->email_model->listarEmail(0);
		
		$this->load->view('header_pages_fiscal_view',$data);
		$this->load->view('intimacoes/listar_intimacoes_view', $data);
		$this->load->view('footer_pages_view');
	}
	


	function logado(){	
		if(! $_SESSION['login_walmart']) {	
		 redirect('acesso', 'refresh');
		}			
	}  
	
	
	function listarTratativaMobById(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'];	
	$id = $this->input->get('id');
	$modulo = $this->input->get('modulo');
	
	$data = array();
	$dados =  $this->intimacao_model->listarTratativaById($idContratante,$id,$modulo);
	
	
	
	$data['id'] = $dados[0]->id;
	$data['tipo_tratativa'] = $dados[0]->tipo_tratativa;
	$data['pendencia'] = $dados[0]->pendencia;
	$data['esfera'] = $dados[0]->esfera;
	$data['etapa'] = $dados[0]->etapa;
	$data['data_informe_pendencia'] = $dados[0]->data_informe_pendencia;
	$data['id_sis_ext'] = $dados[0]->id_sis_ext;
	$data['data_inclusao_sis_ext'] = $dados[0]->data_inclusao_sis_ext;
	$data['prazo_solucao_sis_ext'] = $dados[0]->prazo_solucao_sis_ext;
	$data['data_encerramento_sis_ext'] = $dados[0]->data_encerramento_sis_ext;
	$data['status_chamado_sis_ext'] = $dados[0]->status_chamado_sis_ext;
	$data['id_sla_sis_ext'] = $dados[0]->sla_sis_ext;
	$data['usu_inc'] = $dados[0]->usu_inc;
	$data['area_focal'] = $dados[0]->area_focal;
	$data['sub_area_focal'] = $dados[0]->sub_area_focal;
	$data['contato'] = $dados[0]->contato;
	$data['data_envio'] = $dados[0]->data_envio;
	$data['prazo_solucao'] = $dados[0]->prazo_solucao;
	$data['data_retorno'] = $dados[0]->data_retorno;
	$data['sla'] = $dados[0]->sla;
	$data['status_demanda'] = $dados[0]->status_demanda;
	$data['esc_data_prazo_um'] = $dados[0]->esc_data_prazo_um;
	$data['esc_data_retorno_um'] = $dados[0]->esc_data_retorno_um;
	$data['esc_status_um'] = $dados[0]->esc_status_um;
	$data['esc_data_prazo_dois'] = $dados[0]->esc_data_prazo_dois;
	$data['esc_data_retorno_dois'] = $dados[0]->esc_data_retorno_dois;
	$data['esc_status_dois'] = $dados[0]->esc_status_dois;
	$data['esc_data_prazo_tres'] = $dados[0]->esc_data_prazo_tres;
	$data['esc_data_retorno_tres'] = $dados[0]->esc_data_retorno_tres;
	$data['esc_status_tres'] = $dados[0]->esc_status_tres;
	$data['codigo_natureza_raiz'] = $dados[0]->codigo_natureza_raiz;
	$data['codigo_area_focal'] = $dados[0]->codigo_area_focal;
	$data['valor_pendencia'] = $dados[0]->valor_pendencia;
	$data['modulo'] = $modulo;
	$_SESSION['login_walmart']['modulo'] = $id.'-'.$modulo;
	echo json_encode($data);
	
}

function upload_arquivo(){		
	
	$id_tratativa = $this->input->post('id_tratativa');

	$session_data = $_SESSION['login_walmart'];
      
	
	$dataAtual = strtotime("now");

	$nome = rand($id_tratativa,$dataAtual);	
	
	$file = $_FILES["userfile"]["name"];				

	$extensao = str_replace('.','',strrchr($file, '.'));						

	$base = base_url();		        

	$config['upload_path'] = './assets/observacoes/';		

	$config['allowed_types'] = '*';		

	$config['overwrite'] = 'true';				

	$config['file_name'] = $nome.'.'.$extensao;				

	$this->load->library('upload', $config);	

	$this->upload->initialize($config);		

	$field_name = "userfile";				

	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
	}else{			
		$dados = array(
			'id_tratativas' => $id_tratativa,
			'arquivo' => $nome.'.'.$extensao,	
		);							
		$this->intimacao_model->inserirNovoArquivo($dados);	
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;

	}
	

	$url = $_SERVER['HTTP_REFERER'];
	redirect($url);
}

function listaObsTratEst(){
	$base = $this->config->base_url().'index.php';
	$session_data = $_SESSION['login_walmart'];
	//$idContratante = $_SESSION['id_contratante'] ;
	$id = $this->input->get('id');
	$modulo = $this->input->get('modulo');
	$controller = 'cnd_estadual';
	$data ='';
	$dados =  $this->intimacao_model->listarObsTratById($id);
	

	
	$isArrayLog =  is_array($dados) ? '1' : '0';
	if($isArrayLog == 1) {
		foreach($dados as $dado){
			
			
			if($session_data['perfil'] == 3){
				
				$excluir = " - <i style='color: rgb(0, 176, 240);' title='Excluir Tratativa' class='fa fa-trash excluirTratativa' id=".$dado->id." aria-hidden='true'></i>";				
				$upload = " - <i style='color: rgb(0, 176, 240);' title='Upload Arquivo' class='fa fa-upload uploadArquivo' id=".$dado->id." aria-hidden='true' data-toggle='modal' data-dismiss='modal' data-target='#arquivoUpload' ></i>";	

				// $upload = " - <span id='fileuploadArquivoSpan' class='fileinput-button uploadArquivoClass' title='Upload do Arquivo' >
							// <i style='color: rgb(0, 176, 240);' title='Upload Arquivo' class='fa fa-upload' aria-hidden='true'></i>
							// <input id='fileuploadArquivo'  type='file' name='userfileUpload' data-url='$base/intimacoes/upload_arquivo?id=$dado->id'>  
							// </span>";
											
			}else{
				$upload = $excluir ="";
			}
			
			$arquivo = "<i style='color: rgb(0, 176, 240);' class='fa fa-eye ver_arquivo' id=".$dado->id." aria-hidden='true' data-toggle='modal' data-dismiss='modal' data-target='#mostrarArquivos'></i>";				
			$data .= "<span>".$dado->data.' - '.$dado->hora.' - '.$dado->email.' - '.$dado->observacao.' - '.$arquivo." ".$excluir." ".$upload."	</span> <BR>";
			
			
			
		}
	}else{
		$data .= "0";
	}
	
	
	
	echo json_encode($data);
	
 }

  function excluirTratativa(){
	$id = $this->input->get('id');	
	$this->intimacao_model->excluirTratativa($id);	
	$obj['tem'] = 0; 	
	echo(json_encode($obj));
	
 } 
 
 function listaArquivosMob(){
	$base = $this->config->base_url().'index.php';
	$session_data = $_SESSION['login_walmart'];
	//$idContratante = $_SESSION['id_contratante'] ;
	$id = $this->input->get('id');
	$controller = 'cnd_estadual';
	$data ='';
	$dados =  $this->intimacao_model->listarArquivosMobiliaria($id);
	
	$base = $this->config->base_url();
	
	$isArrayLog =  is_array($dados) ? '1' : '0';
	if($isArrayLog == 1) {
		foreach($dados as $dado){
			
			if(!empty($dado->arquivo)){
				$arquivo = "<a href=".$base."assets/observacoes/".$dado->arquivo." target='_blank'>  <i class='fa fa-download' aria-hidden='true'></i></a>";				
				$data .= "<span>".$dado->arquivo." ".$arquivo."</span> <BR>";
			}else{
				$data .= "<span>Sem Arquivo</span> <BR>";	
			}
			
		}
	}else{
		$data .= "<span>Sem Arquivo</span>";
	}
	
	
	
	echo json_encode($data);
	
 }	
 

}

 

?>
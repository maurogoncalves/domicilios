<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infracoes_Vencidas extends CI_Controller {
 
 function __construct(){
   parent::__construct();
   $this->load->model('infracao_vencida_model','',TRUE);		
   $this->load->model('infracao_model','',TRUE);		
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

 function buscaDadosLoja(){	
	$session_data = $this->session->userdata('logged_in');
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
 
 
 function buscaInfraByCidade(){	
	$cidade = $this->input->get('municipio');
	
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->infracao_vencida_model->buscaInfraByCidade($idContratante,$cidade);
	
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
	
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->infracao_vencida_model->buscaInfra($idContratante,$id);
	
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
 


function export_mun(){
 
	$session_data = $this->session->userdata('logged_in');
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
 
	$session_data = $this->session->userdata('logged_in');
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
 
	$session_data = $this->session->userdata('logged_in');
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
 
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->get('id');
	$result = $this->infracao_vencida_model->listarInfracaoByIdLoja($id);
	
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
 
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	$municipio = $this->input->get('municipio');
	$result = $this->infracao_vencida_model->listarInfracaoByCidade($idContratante,$municipio);
	
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
 
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	$estado = $this->input->get('id');
	$result = $this->infracao_vencida_model->listarInfracaoByEstado($idContratante,$estado);
	
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
	
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->infracao_vencida_model->buscaCidadeById($idContratante,$id);
	
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
	
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	$this->load->helper('Paginate_helper');        
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
	$data['estados'] = $this->infracao_vencida_model->buscaEstado($idContratante);
	$data['cidades'] = $this->infracao_vencida_model->buscaCidade($idContratante);
	$data['lojas'] = $this->infracao_vencida_model->listarLojasComInfra($idContratante);
	
	$result = $this->infracao_vencida_model->listarInfracao($idContratante,numRegister4PagePaginate(), $page);
	//print_r($this->db->last_query());exit;
	$total =  $this->infracao_vencida_model->somarTodos($idContratante);
	//print_r($total);exit;
	
	
	$data['paginacao'] = createPaginate('infracao', $total[0]->total) ;
	
	$data['infracoes'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_view',$data);
    $this->load->view('listar_infracoes_vencidas_view', $data);
	$this->load->view('footer_view');
	
}

 function ativar(){
 
	$id = $this->input->get('id');
	
	if($this->infracao_model->ativar($id)) {
		$data['mensagem'] = 'Infração foi ativado';
	}else{	
		$data['mensagem'] = 'Algum Erro Aconteceu';
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
	
	if($this->infracao_model->excluir($id)) {
		$data['mensagem'] = 'Infração foi inativada';
	}else{	
		$data['mensagem'] = 'Algum Erro Aconteceu';
	}
	
	redirect('/infracoes/listar', 'refresh');
	
 }
 
 
function cadastrar(){	
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);
	
	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	//$data['lojas'] = $this->loja_model->listarLojaByTipo($idContratante,1);
	$data['lojas'] = $this->infracao_model->listarTodasLojas($idContratante);
	$data['tiposAuto'] = $this->infracao_model->listarTipoAuto();
	$data['classInfra'] = $this->infracao_model->listarClassifInfra();
	$data['motivoInfra'] = $this->infracao_model->listarMotivoInfra();
	
	$data['emitentes'] = $this->emitente_model->listarEmitenteByTipo($idContratante,3);

	$this->load->view('header_view',$data);
    $this->load->view('cadastrar_infracoes_view', $data);
	$this->load->view('footer_view');
	
}

function editar(){	
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	$idInfracao = $this->input->get('id');
	
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);
	
	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	//$data['lojas'] = $this->loja_model->listarLojaByTipo($idContratante,1);
	$data['lojas'] = $this->infracao_model->listarTodasLojas($idContratante);
	$data['tiposAuto'] = $this->infracao_model->listarTipoAuto();
	$data['classInfra'] = $this->infracao_model->listarClassifInfra();
	$data['motivoInfra'] = $this->infracao_model->listarMotivoInfra();
	$data['infracao'] = $this->infracao_model->listarInfracaoById($idInfracao);
	
	
	$data['emitentes'] = $this->emitente_model->listarEmitenteByTipo($idContratante,3);

	$this->load->view('header_view',$data);
    $this->load->view('editar_infracoes_view', $data);
	$this->load->view('footer_view');
	
}

}
 
?>

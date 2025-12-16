<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Cnd_est extends CI_Controller {


 


 function __construct(){
	parent::__construct();
	$this->load->model('log_model','',TRUE);
	$this->load->model('cnd_estadual_model','',TRUE);	
	$this->load->model('cnd_estadual_model','',TRUE);	
	$this->load->model('cnd_estadual_model','',TRUE);
    $this->load->model('emitente_imovel_model','',TRUE);
    $this->load->model('tipo_emitente_model','',TRUE);
    $this->load->model('situacao_imovel_model','',TRUE);
    $this->load->model('informacoes_inclusas_iptu_model','',TRUE);
    $this->load->model('user','',TRUE);
    $this->load->model('contratante','',TRUE);
    $this->load->model('emitente_model','',TRUE);
    $this->load->model('imovel_model','',TRUE);
    $this->load->model('iptu_model','',TRUE);
    $this->load->library('Cep');
    $this->load->library('session');   
    $this->load->library('form_validation');
    $this->load->helper('url');
	
	session_start();

 }


 


 function index(){

   if( $_SESSION['login_walmart']){
     $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
     $this->load->view('home_view', $data);
   }else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }


 }

  function export_todos_estados(){	
	
	$id = 0;
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->cnd_estadual_model->listarCNDEstCsvById($idContratante,$id);
	$this->csvGrafico($result);
  }
  
  
  function export_est(){	
	$id = $this->input->post('id_estado_export');
	$tipo = $this->input->post('tipo');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->cnd_estadual_model->listarCNDEstCsvByEstado($idContratante,$id,$tipo);
	$this->csv($result);
  }
  
  function export_mun(){	
	$id = $this->input->post('id_mun_export');
	$tipo = $this->input->post('tipo');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->cnd_estadual_model->listarCNDEstCsvByMun($idContratante,$id,$tipo);
	$this->csv($result);
  }
  
  function export(){	
	$id = $this->input->post('id_imovel_export');
	$tipo = $this->input->post('tipo');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->cnd_estadual_model->listarCNDEstCsvById($idContratante,$id);
	
	$this->csv($result);
  }
  
  function export_total(){	
	$id = 0;
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->cnd_estadual_model->listarCNDEstCsvById($idContratante,$id);
	$this->csvGrafico($result);
  }
  
   
 function csvGrafico($result){
	 
	 
 $file="cnd_est.xls";

	if($result == 0){	
		$test="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$test .='</table>';

    }else{	
			$test="<table border=1>
			<tr>
			<td>Nome Fantasia</td>
			<td>CPF/CNPJ</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Regional</td>
			<td>Bandeira</td>
			<td>Cidade</td>
			<td>Estado</td>	
			<td>Possui CND</td>
			<td>Data </td>
			
			</tr>
			";
			
			//print_r($result);exit;
	 
			foreach($result as $key => $iptu){ 
				$dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_est');				
				$isArrayLog =  is_array($dadosLog) ? '1' : '0';	
				
			  
				if($iptu->status_cnd == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->possui_cnd == 1){
					$possui_cnd ='Sim';
					$data = 'Vencimento';
				}else{
					$possui_cnd ='Não';
					$data = 'Pend&ecirc;ncia';
				}
				
				if($iptu->possui_cnd == 1){
					$cnd ='Emitida';
					$corCnd = '#000099';	
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 2){
					$cnd ='N&atilde;o Emitida';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 3){
					$cnd ='Pendente';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_pendencias);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}
				
				$arrDataVencto = explode("-",$iptu->data_vencto);
				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";
				$test .= "<td>"."'".($iptu->ins_cnd_mob)."'"."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
				
				$test .= "<td>".utf8_decode($cnd)."</td>";
				$test .= "<td>".$dataV."</td>";
				$test .="<td>";	
				$test .="</td>";	
				
				

				
				$test .= "</tr>";
			
				
			}
			$test .='</table>';
		}

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	

 } 
 
 function csv_estado($result){
	 
	 
 $file="cnd_estados.xls";

	if($result == 0){	
		$test="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$test .='</table>';

    }else{	
			$test="<table border=1>
			<tr>
			<td>Total</td>
			<td>Estado</td>	
			</tr>
			";
			
			//print_r($result);exit;
	 
			foreach($result as $key => $iptu){ 
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->total)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
				
				$test .= "</tr>";
			
				
			}
			$test .='</table>';
		}

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	

 } 
 function csv($result){
	 
	 
 $file="cnd_est.xls";

	if($result == 0){	
		$test="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$test .='</table>';

    }else{	
			$test="<table border=1>
			<tr>
			<td>Id</td>
			<td>Raz&atilde;o Social</td>
			<td>CPF/CNPJ</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Cod. 2</td>
			<td>Regional</td>
			<td>Bandeira</td>
			<td>Cidade</td>
			<td>Estado</td>	
			<td>Observa&ccedil;&otilde;es</td>				
			<td>Plano de A&ccedil;&atilde;o</td>	
			<td>Status CND</td>
			<td>Possui CND</td>
			<td>Data </td>
			<td>Data de Emiss&atilde;o </td>	
			
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>				
			
			</tr>
			";
			
			//print_r($result);exit;
	 
			foreach($result as $key => $iptu){ 
				$dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_est');				
				$isArrayLog =  is_array($dadosLog) ? '1' : '0';	
				
			  
				if($iptu->status_cnd == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->possui_cnd == 1){
					$possui_cnd ='Sim';
					$data = 'Vencimento';
				}else{
					$possui_cnd ='Não';
					$data = 'Pend&ecirc;ncia';
				}
				
				if($iptu->possui_cnd == 1){
					$cnd ='Sim';
					$corCnd = '#000099';	
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 2){
					$cnd ='N&atilde;o';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 3){
					$cnd ='Pend&ecirc;ncia';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_pendencias);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}
				
				$arrDataVencto = explode("-",$iptu->data_vencto);
				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->id_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";
				$test .= "<td>"."'".($iptu->ins_cnd_mob)."'"."</td>";
				$test .= "<td>".utf8_decode($iptu->cod2)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
				$test .= "<td>".utf8_decode($iptu->observacoes)."</td>";
				$test .= "<td>".utf8_decode($iptu->plano)."</td>";
				$test .= "<td>".utf8_encode($ativo)."</td>";
				
				$test .= "<td>".utf8_decode($cnd)."</td>";
				$test .= "<td>".$dataV."</td>";
				$test .="<td>";	
				$test .="</td>";	
				
				
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
		}

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	

 } 
 function buscaMunicipio(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_estadual_model->listarImovelByMunicipio($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	 if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
	 

								
      $base = $this->config->base_url().'index.php';
	  $retorno .="<tr style='color:$cor'>";
	  $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  $retorno .="<td width='14%'>".$iptu->cpf_cnpj."</td>";
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
 function busca(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_estadual_model->listarLojaByImovel($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }


	 if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
	 
	 
								
	 $base = $this->config->base_url().'index.php';
	  $retorno .="<tr style='color:$cor'>";
      $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  $retorno .="<td width='14%'>".$iptu->cpf_cnpj."</td>";
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
function buscaLoja(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_estadual_model->listarImovelByCidade($id,$tipo);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha um Imóvel</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 
 function atualizar_cnd(){
	if(! $_SESSION['login_walmart']){
			redirect('login', 'refresh');
	  }

	 
	$_SESSION['msgCNDEst'] = ''; 
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	$id = $this->input->post('id');
	$id_emitente = $this->input->post('id_emitente');
	$inscricao = $this->input->post('inscricao');
	$possui_cnd = $this->input->post('possui_cnd');
	$data_vencto = $this->input->post('data_vencto');	
	$arrDataVencto = explode("/",$data_vencto);	
	$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');	
	$modulo = $_SESSION["CNDEst"];	
	
	$data_emissao = $this->input->post('data_emissao');		
	$arrDataEmissao = explode("/",$data_emissao);	
	$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		
	if(empty($data_emissao)){
			$this->session->set_flashdata('mensagem','Data de Emiss&atilde;o n&atilde;o pode ser vazia');
			redirect('/cnd_est/'.$modulo);	
			exit;
	}
		
	
	if($possui_cnd == 1){
		$dados = array(
			'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 1,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
			'data_emissao' => $dataEmissao
		);
		
		$data_emissao = $this->input->post('data_emissao');	
		if(empty($data_emissao)){
			$this->session->set_flashdata('mensagem','Data de Emiss&atilde;o n&atilde;o pode ser vazia');
			redirect('/cnd_est/'.$modulo);	
			exit;
		}
		$arrDataEmissao = explode("/",$data_emissao);	
		$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'est',
			'data_emissao' =>$dataEmissao,
			);
		$this->cnd_estadual_model->addDataEmissao($dadosDataEmissao,$id,'est');
					
		$_SESSION["CNDMob"] = 'listarPorTipoSim';	
		$_SESSION['msgCNDMob'] =  'CND Atualizada para Sim ';
		
	}elseif($possui_cnd == 2){
		$dados = array(
			'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 2,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		$_SESSION["CNDEst"] = 'listarPorTipoNao';
		$_SESSION['msgCNDEst'] =  'CND Atualizada para N&atilde;o ';
	}else{
		$dados = array(
			'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 3,
			'ativo' => 0,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		$_SESSION["CNDEst"] = 'listarPorTipoPendencia';
		$_SESSION['msgCNDEst'] =  'CND Atualizada para Pend&ecirc;ncia ';
	
	}
	$dadosImovel = $this->cnd_estadual_model->listarCidadeEstadoById($id);
	
	
	$_SESSION["idCNDEstBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDEstBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDEstBD"] = $dadosImovel[0]->estado;
	
	
	
	//print_r($this->session->userdata);exit;
	$dadosAtuais = $this->cnd_estadual_model->listarCNDById($id);
	
	$dadosAlterados ='';
	$arrDataAtual = explode("-",$dadosAtuais[0]->data_vencto);	
	$dataAtual = $arrDataAtual[2].'/'.$arrDataAtual[1].'/'.$arrDataAtual[0];
	$arrDataPAtual = explode("-",$dadosAtuais[0]->data_pendencias);	
	$dataPAtual = $arrDataPAtual[2].'/'.$arrDataPAtual[1].'/'.$arrDataPAtual[0];
	
	if($dadosAtuais[0]->possui_cnd <> $possui_cnd){
		if($dadosAtuais[0]->possui_cnd == 1){
			
			$dadosAlterados .= ' - Possui CND: Sim';
			if($dadosAtuais[0]->data_vencto <> $dataVencto){
				$dadosAlterados .= ' - Data Vencimento: '.$dataAtual;			
			}
		}else if($dadosAtuais[0]->possui_cnd == 2){
			
			$dadosAlterados .= ' - Possui CND: Não';
			if($dadosAtuais[0]->data_vencto <> $dataVencto){
				$dadosAlterados .= ' - Data Vencimento: '.$dataAtual;			
			}			
		}
		else{
			
			$dadosAlterados .= ' - Possui CND: Pendência';		
			if($dadosAtuais[0]->data_pendencias <> $dataVencto){
				$dadosAlterados .= ' - Data Pendência: '.$dataPAtual;			
			}

		}
	}
	
	if($dadosAtuais[0]->observacoes <> $observacoes){

		$dadosAlterados .= ' - Observações: '.$dadosAtuais[0]->observacoes;	
	}
	

	if(!empty($dadosAlterados)){
		$dadosLog = array(
		'id_contratante' => $idContratante,
		'tabela' => 'cnd_est',
		'id_usuario' => $idUsuario,
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => $dadosAlterados,
		'data' => date("Y-m-d"),
		);
		$this->log_model->log($dadosLog);
	}
	
	$this->cnd_estadual_model->atualizar($dados,$id);
	
	redirect('/cnd_est/editar?id='.$id);

 }
 
 function enviar(){		
	
	 $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/cnd_est/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = $id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";		
	$dadosArquivo = $this->cnd_estadual_model->listarInscricaoById($id);
	if($dadosArquivo[0]->arquivo_cnd){
		$b = getcwd();
		//unlink("teste.txt");
		//$this->config->base_url().'assets/cnd_imob_pend/'.$dadosArquivo[0]->arquivo_pendencias;exit;
		$a = @unlink($b.'/assets/cnd_est/'.$dadosArquivo[0]->arquivo);
	}
		
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{	
		$session_data = $_SESSION['login_walmart'];
		$dadosLog = array(
		'id_contratante' => $session_data['id_contratante'],
		'tabela' => 'cnd_est',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo CND Estadual',
		'data' => date("Y-m-d"),
		);
		$this->log_model->log($dadosLog);
	
		$dados = array(
			'arquivo_cnd' => $id.'.'.$extensao,
			'possui_cnd' => 1
			);
				
		$this->cnd_estadual_model->atualizar($dados,$id);
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}

//redirect('/iptu/listar', 'refresh');		 
}

 function enviar_pend(){
		
		$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/cnd_est/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = $id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";		
	$dadosArquivo = $this->cnd_estadual_model->listarInscricaoById($id);
	if($dadosArquivo[0]->arquivo_pendencias){
		$b = getcwd();
		//unlink("teste.txt");
		//$this->config->base_url().'assets/cnd_imob_pend/'.$dadosArquivo[0]->arquivo_pendencias;exit;
		$a = @unlink($b.'/assets/cnd_est/'.$dadosArquivo[0]->arquivo);
	}
		
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{	
		$session_data = $_SESSION['login_walmart'];
		$dadosLog = array(
		'id_contratante' => $session_data['id_contratante'],
		'tabela' => 'cnd_est',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo CND Estadual - Pendência',
		'data' => date("Y-m-d"),
		);
		$this->log_model->log($dadosLog);
		
		$dados = array(
			'arquivo_pendencias' => $id.'.'.$extensao,
			'possui_cnd' => 3
			);
				
		$this->cnd_estadual_model->atualizar($dados,$id);
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}
	
		
 }
 
 function ver(){
  $session_data = $_SESSION['login_walmart'];	
  if(! $_SESSION['login_walmart']){
	redirect('login', 'refresh');
  }
  $id = $this->input->get('id');
  $data['imovel'] = $this->cnd_estadual_model->listarInscricaoById($id);
  $data['perfil'] = $session_data['perfil'];
  $this->load->view('header_pages_view',$data);
  $this->load->view('ver-cnd-est', $data);
  $this->load->view('footer_pages_view');
 }
 
 function upload_cnd(){
	
	
  $session_data = $_SESSION['login_walmart'];	
 
  if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

  $id = $this->input->get('id');
  
  $dadosImovel = $this->cnd_estadual_model->listarInscricaoById($id);
  
  $data['imovel'] = $dadosImovel;
  
  
  if($dadosImovel[0]->possui_cnd ==1){
		$_SESSION["CNDMob"]= 'listarPorTipoSim';	
  }elseif($dadosImovel[0]->possui_cnd ==2){
		$_SESSION["CNDMob"]='listarPorTipoNao';	
  }else{
	  $_SESSION["CNDMob"]='listarPorTipoPendencia';
  }	  
	  
	  
  $data['dataEmissao'] = $this->cnd_estadual_model->listarDataEmissao($id,'est');
  $data['perfil'] = $session_data['perfil'];

  if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
  $this->load->view('header_pages_view',$data);

  $this->load->view('upload_cnd_est', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
 
 function upload_pend(){
	
	
  $session_data = $_SESSION['login_walmart'];	
 
  if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $dadosImovel = $this->cnd_estadual_model->listarInscricaoById($id);
  
  $data['imovel'] = $dadosImovel;
  
  
  if($dadosImovel[0]->possui_cnd ==1){
		$_SESSION["CNDEst"]= 'listarPorTipoSim';	
  }elseif($dadosImovel[0]->possui_cnd ==2){
		$_SESSION["CNDEst"]='listarPorTipoNao';	
  }else{
	  $_SESSION["CNDEst"]='listarPorTipoPendencia';
  }	  
	  
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
  
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('upload_pendencia_cnd_est', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
 function buscaEstado(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_estadual_model->listarImovelByUf($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='6'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	 if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
								 
	//$arrDataVencto = explode("-",$iptu->data_vencto);
	//$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];

								
	  $base = $this->config->base_url().'index.php';	
	  $retorno .="<tr style='color:$cor'>";
	  $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  $retorno .="<td width='14%'>".$iptu->cpf_cnpj."</td>";
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
  function editar(){	
	  if(! $_SESSION['login_walmart']){
			redirect('login', 'refresh');
	  }
	
	$id = $this->input->get('id');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$data['imovel'] = $this->cnd_estadual_model->listarInscricaoByLoja($id);
	$dadosImovel = $this->cnd_estadual_model->listarCidadeEstadoById($id);
	
	$dadosDataDb = $this->cnd_estadual_model->listarDataEmissao($id,'est');
	
	$data['data_emissao'] = $dadosDataDb;
	
	$_SESSION["idCNDEstBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDEstBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDEstBD"] = $dadosImovel[0]->estado;
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_cnd_est_view', $data);
	$this->load->view('footer_pages_view');

 }
 
 function cadastrar_est_cnd(){
 
   if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }


	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$inscricao = $this->input->post('inscricao');	
	
	$id_loja = $this->input->post('id_loja');	
	if(empty($id_loja)){
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
		redirect('/loja/listar', 'refresh');
		exit;
	}
	
	$possui_cnd = $this->input->post('possui_cnd');
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');	
	
	$data_vencto = $this->input->post('data_vencto');
	if(!empty($data_vencto )){
		$arrDataVencto = explode("/",$data_vencto);
		$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
	}else{
		$dataVencto ='0000-00-00';
	}
	if($possui_cnd == 1){
		$data_emissao = $this->input->post('data_emissao');
		if(!empty($data_emissao )){
			$arrDataEmissao = explode("/",$data_emissao);
			$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		}else{
			$dataEmissao ='0000-00-00';
		}
		
		$_SESSION["CNDEst"] = 'listarPorTipoSim';
		$dados = array(
			'id_loja' => $id_loja,
			'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 1,
			'ativo' => 1,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
			'data_emissao' => $dataEmissao
		);
		
		
	
		
		
		
	}elseif($possui_cnd == 2){
		$_SESSION["CNDEst"] = 'listarPorTipoNao';
		$dados = array(
			'id_loja' => $id_loja,
			'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 2,
			'ativo' => 1,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano			
		);
		
	}else{
		$_SESSION["CNDEst"] = 'listarPorTipoPendencia';
		$dados = array(
			'id_loja' => $id_loja,
			'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 3,
			'ativo' => 1,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		
	}

	$id = $this->cnd_estadual_model->add($dados);
	

	$_SESSION['msgCNDEst'] =  CADASTRO_FEITO;
	//$this->session->set_flashdata('mensagem','Cadastro Realizado com sucesso');
	$url = 'cnd_est/editar?id='.$id;

	redirect($url, 'refresh');
				


 }
 
 function cadastrar(){
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }



	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
	
	$id_loja = $this->input->get('id');
	$data['id_loja'] = $id_loja;

	$data['emitente'] = $this->cnd_estadual_model->listarEmitenteById($id_loja);
	
	//$data['info_inc'] = $this->informacoes_inclusas_iptu_model->listar();
		
 	$data['perfil'] = $session_data['perfil'];

	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	

	$this->load->view('header_pages_view',$data);


    $this->load->view('cadastrar_cnd_est_view', $data);


	$this->load->view('footer_pages_view');


 }
 function listarLoja(){	
	redirect('loja/listarLojaSemCNDEst', '');
 
 }
 function listarPorRegional(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$tipo  = $this->input->get('tipo');
	$regional  = $this->input->get('reg');
	
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);
	
	$result =  $this->cnd_estadual_model->listarCndTipoReg($idContratante,$regional,$tipo);

	$_SESSION["CNDEst"] = 'listarPorTipoSim';
	$data["CNDEst"] = 'listarPorTipoSim';
	$data['tipo'] = $tipo;
	$data['iptus'] = $result;
	$data['nome_modulo'] = 'CND Estadual';
	$data['perfil'] = $session_data['perfil'];

	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_estadual_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 function listarTodos(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$cidade = '0';
	$estado = '0';
	$data['cidadeBD'] = $cidade;
	$data['estadoBD'] = $estado;
	$data['idSubL'] = 0;
	$tipo = 'X';
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);
	
	
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->cnd_estadual_model->listarCnd($idContratante,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_estadual_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_estadual_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_estadual_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}	   
	}
	

	
	

	$_SESSION["CNDEst"] = 'listarTodos';
	$data["CNDEst"] = 'listarTodos';
	$data['tipo'] = $tipo;
	$data['iptus'] = $result;
	$data['nome_modulo'] = 'CND Estadual';
	$data['perfil'] = $session_data['perfil'];

	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_estadual_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 function listarPorTipoSim(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$cidade = '0';
	$estado = '0';
	$data['cidadeBD'] = $cidade;
	$data['estadoBD'] = $estado;
	$data['idSubL'] = 0;
	$tipo = 1;
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);
	
	
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->cnd_estadual_model->listarCnd($idContratante,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_estadual_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_estadual_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_estadual_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}	   
	}
	

	
	

	$_SESSION["CNDEst"] = 'listarPorTipoSim';
	$data["CNDEst"] = 'listarPorTipoSim';
	$data['tipo'] = $tipo;
	$data['iptus'] = $result;
	$data['nome_modulo'] = 'CND Estadual';
	$data['perfil'] = $session_data['perfil'];

	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_estadual_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 
  function listarPorTipoNao(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$cidade = '0';
	$estado = '0';
	$data['cidadeBD'] = $cidade;
	$data['estadoBD'] = $estado;
	$data['idSubL'] = 0;
	$tipo = 2;
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);
	
	
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->cnd_estadual_model->listarCnd($idContratante,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_estadual_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_estadual_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_estadual_model->listarCndTipoId($idContratante,$idImovelListar);
		}	   
	}
	

	//print_r($this->db->last_query());exit;
	

	$_SESSION["CNDEst"] = 'listarPorTipoNao';
	$data["CNDEst"] = 'listarPorTipoNao';
	$data['tipo'] = $tipo;
	$data['iptus'] = $result;
	$data['nome_modulo'] = 'CND Estadual';
	$data['perfil'] = $session_data['perfil'];

	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_estadual_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 
 function listar(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,'X');
	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante,'X');
	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,'X');
	
	
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';
		$tipo = 0;
		$result = $this->cnd_estadual_model->listarCnd($idContratante);		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_estadual_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_estadual_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_estadual_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}	   
	}
	

	//print_r($this->db->last_query());exit;
	

	$_SESSION["CNDEst"] = 'listar';
	$data["CNDEst"] = 'listar';

	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->session->set_userdata('CNDEst', 'listar');
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_estadual_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function listarPorTipoPendencia(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$cidade = '0';
	$estado = '0';
	$data['cidadeBD'] = $cidade;
	$data['estadoBD'] = $estado;
	$data['idSubL'] = 0;
	$tipo = 3;
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);
	
	
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->cnd_estadual_model->listarCnd($idContratante,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_estadual_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_estadual_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_estadual_model->listarCndTipoId($idContratante,$idImovelListar);
		}	   
	}
	

	//print_r($this->db->last_query());exit;
	

	$_SESSION["CNDEst"] = 'listarPorTipoPendencia';
	$data["CNDEst"] = 'listarPorTipoPendencia';
	$data['tipo'] = $tipo;
	$data['iptus'] = $result;
	$data['nome_modulo'] = 'CND Estadual';
	$data['perfil'] = $session_data['perfil'];

	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_estadual_view', $data);

	$this->load->view('footer_pages_view');
	

 }
 
 function dados_agrupados(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
  
	$cidade = '0';
	$estado = '0';
	
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$ano = date('Y');      

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	$regionais = $this->cnd_estadual_model->regionais();
	$regionalSim = array();
	$regionalNao = array();
	$regionalPend = array();
	$regionalNC = array();
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_estadual_model->contaCndRegional($idContratante,$ano,1,$reg->id);
		$regionalSim[$i]['regional'] = $reg->descricao;
		$regionalSim[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_estadual_model->contaCndRegional($idContratante,$ano,2,$reg->id);
		$regionalNao[$i]['regional'] = $reg->descricao;
		$regionalNao[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_estadual_model->contaCndRegional($idContratante,$ano,3,$reg->id);
		$regionalPend[$i]['regional'] = $reg->descricao;
		$regionalPend[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_estadual_model->contaCndRegional($idContratante,$ano,4,$reg->id);
		$regionalNC[$i]['regional'] = $reg->descricao;
		$regionalNC[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	//seleciona todos
	foreach($regionais as $reg){
		$result = $this->cnd_estadual_model->contaCndRegional($idContratante,$ano,0,$reg->id);
		$regionalTodos[$i]['regional'] = $reg->descricao;
		$regionalTodos[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	//print_r($this->db->last_query());exit;
	$data['regionalSim'] = $regionalSim ;
	$data['regionalNao'] = $regionalNao;
	  //print_r($this->db->last_query());exit;
	$data['regionalPend'] = $regionalPend;
	$data['regionalNC'] = $regionalNC;
	$data['regionalTodos'] = $regionalTodos;
	
	

	
	$data['nome_modulo'] = 'CND Estadual';
	$data['modulo'] = 'cnd_est';
	$data['iptus'] =$this->cnd_estadual_model->contaCnd($idContratante,$ano);
	

	$data['perfil'] = $session_data['perfil'];
	
	$_SESSION["idCNDMBD"]='0';
  	$_SESSION["cidadeCNDMBD"] = 0;
	$_SESSION["estadoCNDMBD"] = 0;
	$_SESSION["modulo"] ='';
	
	
	
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('dados_agrupados_cnd_est_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function buscaCidade(){	
 
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->get('estado');
	$tipo = $this->input->get('tipo');
	
	
	$retorno ='';
	$result = $this->cnd_estadual_model->listarCidadeByEstado($idContratante,$id,$tipo);
	
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }

 function buscaInscricaoByEstado(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_estado_model->listarImovelByEstado($id,$tipo);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha um Imóvel</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaTodasCidades(){	
	$cidadeFiltro = $this->input->get('cidadeFiltro');
	$tipo = $this->input->get('tipo');
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
	
	$retorno ='';
	$result = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);
	
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $iptu){ 	
			if($iptu->cidade == $cidadeFiltro){
				$retorno .="<option value='".$iptu->cidade."' selected>".$iptu->cidade."</option>";
			}else{
				$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";
			}
		 
		}
		
	
	}
	echo json_encode($retorno);
	
 }

}
?>
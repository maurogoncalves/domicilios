<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class Cnd_estadual extends CI_Controller { function __construct(){	parent::__construct();	$this->load->model('loja_model','',TRUE);	
	$this->load->model('log_model','',TRUE);	$this->load->model('notificacao_model','',TRUE);		$this->load->model('cnd_estadual_model','',TRUE);	$this->load->model('cnd_mobiliaria_model','',TRUE);    $this->load->model('emitente_imovel_model','',TRUE);    $this->load->model('tipo_emitente_model','',TRUE);    $this->load->model('situacao_imovel_model','',TRUE);    $this->load->model('informacoes_inclusas_iptu_model','',TRUE);    $this->load->model('user','',TRUE);    $this->load->model('contratante','',TRUE);    $this->load->model('emitente_model','',TRUE);    $this->load->model('imovel_model','',TRUE);    $this->load->model('iptu_model','',TRUE);    $this->load->library('Cep');    $this->load->library('session');       $this->load->library('form_validation');    $this->load->helper('url');	$this->load->helper('pdf_helper');	$this->load->helper('general_helper');	session_start();				 }
function index(){
   if( $_SESSION['login_walmart']){
		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;			$data['cnpjs'] = $this->emitente_model->listarCnpj($idContratante);	 	$data['perfil'] = $session_data['perfil'];		if(empty($session_data['visitante'])){		$data['visitante'] = 0;	}else{		$data['visitante'] = $session_data['visitante'];		}		$this->load->view('header_pages_view',$data);    $this->load->view('cadastrar_cnd_view', $data);	$this->load->view('footer_pages_view');	    }else{     //If no session, redirect to login page     redirect('login', 'refresh');   } }
function cnd_estadual_dados_estado_emitidas(){		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$estadosCnds = array();		if($_SESSION['cliente'] == 2){		$data['empresa'] = 'Sandoz';	}else{		$data['empresa'] = 'Novartis';	}		$estado = $this->input->get('estado');			$cndsEmitidasDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_debito_fiscal',$estado);			$cndsNaoEmitidasDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_debito_fiscal',$estado);			$cndsSemStatusDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUfSemStatus($idContratante,3,'cnd_estadual_debito_fiscal',$estado);			$cndsEmitidasDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_divida_ativa',$estado);			$cndsNaoEmitidasDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_divida_ativa',$estado);			$cndsSemStatusDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUfSemStatus($idContratante,3,'cnd_estadual_divida_ativa',$estado);			$cndsEmitidasAmbas = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_ambas',$estado);			$cndsNaoEmitidasAmbas = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_ambas',$estado);			$cndsSemStatusAmbas = $this->cnd_estadual_model->contaCndEstadualByUfSemStatus($idContratante,3,'cnd_estadual_ambas',$estado);					$estadosCnds['cndsEmitidasDebFiscal'] = $cndsEmitidasDebFiscal[0]->total;	$estadosCnds['cndsNaoEmitidasDebFiscal'] = $cndsNaoEmitidasDebFiscal[0]->total;	$estadosCnds['cndsSemStatusDebFiscal'] = $cndsSemStatusDebFiscal[0]->total;	$estadosCnds['cndsEmitidasDivAtiv'] = $cndsEmitidasDivAtiv[0]->total;	$estadosCnds['cndsNaoEmitidasDivAtiv'] = $cndsNaoEmitidasDivAtiv[0]->total;	$estadosCnds['cndsSemStatusDivAtiv'] = $cndsSemStatusDivAtiv[0]->total;	$estadosCnds['cndsEmitidasAmbas'] = $cndsEmitidasAmbas[0]->total;	$estadosCnds['cndsNaoEmitidasAmbas'] = $cndsNaoEmitidasAmbas[0]->total;	$estadosCnds['cndsSemStatusAmbas'] = $cndsSemStatusAmbas[0]->total;		$estadosCnds['totalCnds'] = $cndsEmitidasDebFiscal[0]->total + $cndsNaoEmitidasDebFiscal[0]->total + $cndsEmitidasDivAtiv[0]->total + $cndsNaoEmitidasDivAtiv[0]->total+  $cndsEmitidasAmbas[0]->total + $cndsNaoEmitidasAmbas[0]->total;	$estadosCnds['totalCndsDebFiscal'] = $cndsEmitidasDebFiscal[0]->total +$cndsNaoEmitidasDebFiscal[0]->total;	$estadosCnds['totalCndsDivAtiv'] = $cndsEmitidasDivAtiv[0]->total + $cndsNaoEmitidasDivAtiv[0]->total;	$estadosCnds['totalCndsAmbas'] = $cndsEmitidasAmbas[0]->total+ $cndsNaoEmitidasAmbas[0]->total; 					 			if($estadosCnds['totalCndsDebFiscal'] == 0){		$estadosCnds['cndsEmitidasDebFiscalPorc'] = 0;		$estadosCnds['cndsNaoEmitidasDebFiscalPorc'] = 0;	}else{		$estadosCnds['cndsEmitidasDebFiscalPorc'] = round((($estadosCnds['cndsEmitidasDebFiscal'] / $estadosCnds['totalCndsDebFiscal']) * 100),2);		$estadosCnds['cndsNaoEmitidasDebFiscalPorc'] = round((($estadosCnds['cndsNaoEmitidasDebFiscal'] / $estadosCnds['totalCndsDebFiscal']) * 100),2);	}		if($estadosCnds['totalCndsDivAtiv'] == 0){		$estadosCnds['cndsEmitidasDivAtivPorc'] = 0;		$estadosCnds['cndsNaoEmitidasDivAtivPorc'] =0;	}else{		$estadosCnds['cndsEmitidasDivAtivPorc'] = round((($estadosCnds['cndsEmitidasDivAtiv'] / $estadosCnds['totalCndsDivAtiv']) * 100),2);		$estadosCnds['cndsNaoEmitidasDivAtivPorc'] = round((($estadosCnds['cndsNaoEmitidasDivAtiv'] / $estadosCnds['totalCndsDivAtiv']) * 100),2);	}		if($estadosCnds['totalCndsAmbas'] == 0){		$estadosCnds['cndsEmitidasAmbasPorc'] = 0;		$estadosCnds['cndsNaoEmitidasAmbasPorc'] =0;	}else{		$estadosCnds['cndsEmitidasAmbasPorc'] = round((($estadosCnds['cndsEmitidasAmbas'] / $estadosCnds['totalCndsAmbas']) * 100),2);		$estadosCnds['cndsNaoEmitidasAmbasPorc'] = round((($estadosCnds['cndsNaoEmitidasAmbas']/ $estadosCnds['totalCndsAmbas']) * 100),2);	}		echo json_encode($estadosCnds);}function cnd_estadual_dados_estado(){	    $session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$estadosCnds = array();		$estado = $this->input->get('estado');			$cndsEmitidasDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_debito_fiscal',$estado);			$cndsNaoEmitidasDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_debito_fiscal',$estado);			$cndsSemStatusDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUfSemStatus($idContratante,3,'cnd_estadual_debito_fiscal',$estado);			$cndsEmitidasDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_divida_ativa',$estado);			$cndsNaoEmitidasDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_divida_ativa',$estado);			$cndsSemStatusDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUfSemStatus($idContratante,3,'cnd_estadual_divida_ativa',$estado);			$cndsEmitidasAmbas = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_ambas',$estado);			$cndsNaoEmitidasAmbas = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_ambas',$estado);			$cndsSemStatusAmbas = $this->cnd_estadual_model->contaCndEstadualByUfSemStatus($idContratante,3,'cnd_estadual_ambas',$estado);					$estadosCnds['cndsEmitidasDebFiscal'] = $cndsEmitidasDebFiscal[0]->total;	$estadosCnds['cndsNaoEmitidasDebFiscal'] = $cndsNaoEmitidasDebFiscal[0]->total;	$estadosCnds['cndsSemStatusDebFiscal'] = $cndsSemStatusDebFiscal[0]->total;	$estadosCnds['cndsEmitidasDivAtiv'] = $cndsEmitidasDivAtiv[0]->total;	$estadosCnds['cndsNaoEmitidasDivAtiv'] = $cndsNaoEmitidasDivAtiv[0]->total;	$estadosCnds['cndsSemStatusDivAtiv'] = $cndsSemStatusDivAtiv[0]->total;	$estadosCnds['cndsEmitidasAmbas'] = $cndsEmitidasAmbas[0]->total;	$estadosCnds['cndsNaoEmitidasAmbas'] = $cndsNaoEmitidasAmbas[0]->total;	$estadosCnds['cndsSemStatusAmbas'] = $cndsSemStatusAmbas[0]->total;		$estadosCnds['totalDebFiscal'] = $cndsEmitidasDebFiscal[0]->total + $cndsNaoEmitidasDebFiscal[0]->total + $cndsSemStatusDebFiscal[0]->total;	$estadosCnds['totalDivAtiv'] = $cndsEmitidasDivAtiv[0]->total + $cndsNaoEmitidasDivAtiv[0]->total + $cndsSemStatusDivAtiv[0]->total;	$estadosCnds['totalAmbas'] = $cndsEmitidasAmbas[0]->total+ $cndsNaoEmitidasAmbas[0]->total + $cndsSemStatusAmbas[0]->total; 						if($estadosCnds['totalDebFiscal'] == 0){			$estadosCnds['cndsEmitidasDebFiscalPorc'] =0;		}else{			$estadosCnds['cndsEmitidasDebFiscalPorc'] = round((($estadosCnds['cndsEmitidasDebFiscal'] / $estadosCnds['totalDebFiscal']) * 100),2);		}				if($estadosCnds['totalDebFiscal'] == 0){			$estadosCnds['cndsNaoEmitidasDebFiscalPorc'] = 0;		}else{			$estadosCnds['cndsNaoEmitidasDebFiscalPorc'] = round((($estadosCnds['cndsNaoEmitidasDebFiscal'] / $estadosCnds['totalDebFiscal']) * 100),2);		}				if($estadosCnds['totalDebFiscal'] == 0){			$estadosCnds['cndsSemStatusDebFiscalPorc'] = 0;		}else{			$estadosCnds['cndsSemStatusDebFiscalPorc'] = round((($estadosCnds['cndsSemStatusDebFiscal'] / $estadosCnds['totalDebFiscal']) * 100),2);		}						if($estadosCnds['totalDivAtiv'] == 0){			$estadosCnds['cndsEmitidasDivAtivPorc'] = 0;		}else{			$estadosCnds['cndsEmitidasDivAtivPorc'] = round((($estadosCnds['cndsEmitidasDivAtiv'] / $estadosCnds['totalDivAtiv']) * 100),2);		}				if($estadosCnds['totalDivAtiv'] == 0){			$estadosCnds['cndsNaoEmitidasDivAtivPorc'] = 0;		}else{			$estadosCnds['cndsNaoEmitidasDivAtivPorc'] = round((($estadosCnds['cndsNaoEmitidasDivAtiv'] / $estadosCnds['totalDivAtiv']) * 100),2);		}				if($estadosCnds['totalDivAtiv'] == 0){			$estadosCnds['cndsSemStatusDivAtivPorc'] = 0;		}else{			$estadosCnds['cndsSemStatusDivAtivPorc'] = round((($estadosCnds['cndsSemStatusDivAtiv'] / $estadosCnds['totalDivAtiv']) * 100),2);		}						if($estadosCnds['totalAmbas'] == 0){			$estadosCnds['cndsEmitidasAmbasPorc'] = 0;		}else{			$estadosCnds['cndsEmitidasAmbasPorc'] = round((($estadosCnds['cndsEmitidasAmbas'] / $estadosCnds['totalAmbas']) * 100),2);		}						if($estadosCnds['totalAmbas'] == 0){			$estadosCnds['cndsNaoEmitidasAmbasPorc'] = 0;		}else{			$estadosCnds['cndsNaoEmitidasAmbasPorc'] = round((($estadosCnds['cndsNaoEmitidasAmbas'] /$estadosCnds['totalAmbas']) * 100),2);		}				if($estadosCnds['totalAmbas'] == 0){			$estadosCnds['cndsSemStatusAmbasPorc'] = 0;		}else{			$estadosCnds['cndsSemStatusAmbasPorc'] = round((($estadosCnds['cndsSemStatusAmbas'] /$estadosCnds['totalAmbas']) * 100),2);		}				echo json_encode($estadosCnds);		}
function exportPdf(){		if($_SESSION['cliente'] == 2){		$empresa = 'SANDOZ';	}else{		$empresa = 'NOVARTIS';	}		$this->load->helper('pdf_helper');	date_default_timezone_set('America/Sao_Paulo');		$dataAtual = date("d/m/Y H:i");	$estado = $this->input->post('uf');		tcpdf();	$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);	$obj_pdf->SetCreator(PDF_CREATOR);	$title = $dataAtual.' - '.$empresa." - Status das CNDs Estaduais por IE - ".$estado;	//$obj_pdf->SetTitle('Status CNDs por IE');	$obj_pdf->SetHeaderData('','' , $title,'' );	$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));	$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));	$obj_pdf->SetDefaultMonospacedFont('helvetica');	$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);	$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);	$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);	$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);	$obj_pdf->SetFont('helvetica', '', 9);	$obj_pdf->setFontSubsetting(false);	$obj_pdf->AddPage();	    $session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$estadosCnds = array();				$cndsEmitidasDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_debito_fiscal',$estado);			$cndsNaoEmitidasDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_debito_fiscal',$estado);			$cndsSemStatusDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUfSemStatus($idContratante,3,'cnd_estadual_debito_fiscal',$estado);			$cndsEmitidasDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_divida_ativa',$estado);			$cndsNaoEmitidasDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_divida_ativa',$estado);			$cndsSemStatusDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUfSemStatus($idContratante,3,'cnd_estadual_divida_ativa',$estado);			$cndsEmitidasAmbas = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_ambas',$estado);			$cndsNaoEmitidasAmbas = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_ambas',$estado);			$cndsSemStatusAmbas = $this->cnd_estadual_model->contaCndEstadualByUfSemStatus($idContratante,3,'cnd_estadual_ambas',$estado);					$cndsEmitidasDebFiscal = $cndsEmitidasDebFiscal[0]->total;	$cndsNaoEmitidasDebFiscal = $cndsNaoEmitidasDebFiscal[0]->total;	$cndsSemStatusDebFiscal = $cndsSemStatusDebFiscal[0]->total;	$cndsEmitidasDivAtiv = $cndsEmitidasDivAtiv[0]->total;	$cndsNaoEmitidasDivAtiv = $cndsNaoEmitidasDivAtiv[0]->total;	$cndsSemStatusDivAtiv = $cndsSemStatusDivAtiv[0]->total;	$cndsEmitidasAmbas = $cndsEmitidasAmbas[0]->total;	$cndsNaoEmitidasAmbas = $cndsNaoEmitidasAmbas[0]->total;	$cndsSemStatusAmbas = $cndsSemStatusAmbas[0]->total;		$totalDebFiscal = $cndsEmitidasDebFiscal + $cndsNaoEmitidasDebFiscal + $cndsSemStatusDebFiscal;	$totalDivAtiv = $cndsEmitidasDivAtiv + $cndsNaoEmitidasDivAtiv + $cndsSemStatusDivAtiv;	$totalAmbas = $cndsEmitidasAmbas+ $cndsNaoEmitidasAmbas + $cndsSemStatusAmbas; 				if($totalDebFiscal == 0){		$cndsEmitidasDebFiscalPorc =0;	}else{		$cndsEmitidasDebFiscalPorc = round((($cndsEmitidasDebFiscal / $totalDebFiscal) * 100),2);	}	if($totalDebFiscal == 0){		$cndsNaoEmitidasDebFiscalPorc = 0;	}else{		$cndsNaoEmitidasDebFiscalPorc = round((($cndsNaoEmitidasDebFiscal / $totalDebFiscal) * 100),2);	}	if($totalDebFiscal == 0){		$cndsSemStatusDebFiscalPorc = 0;	}else{		$cndsSemStatusDebFiscalPorc = round((($cndsSemStatusDebFiscal / $totalDebFiscal) * 100),2);	}	if($totalDivAtiv == 0){		$cndsEmitidasDivAtivPorc = 0;	}else{		$cndsEmitidasDivAtivPorc = round((($cndsEmitidasDivAtiv / $totalDivAtiv) * 100),2);	}	if($totalDivAtiv == 0){		$cndsNaoEmitidasDivAtivPorc = 0;	}else{		$cndsNaoEmitidasDivAtivPorc = round((($cndsNaoEmitidasDivAtiv / $totalDivAtiv) * 100),2);	}	if($totalDivAtiv == 0){		$cndsSemStatusDivAtivPorc = 0;	}else{		$cndsSemStatusDivAtivPorc = round((($cndsSemStatusDivAtiv / $totalDivAtiv) * 100),2);	}	if($totalAmbas == 0){		$cndsEmitidasAmbasPorc = 0;	}else{		$cndsEmitidasAmbasPorc = round((($cndsEmitidasAmbas / $totalAmbas) * 100),2);	}	if($totalAmbas == 0){		$cndsNaoEmitidasAmbasPorc = 0;	}else{		$cndsNaoEmitidasAmbasPorc = round((($cndsNaoEmitidasAmbas /$totalAmbas) * 100),2);	}	if($totalAmbas == 0){		$cndsSemStatusAmbasPorc = 0;	}else{		$cndsSemStatusAmbasPorc = round((($cndsSemStatusAmbas /$totalAmbas) * 100),2);	}	$data = date("d/m/Y");	$html = "	<table class='table' cellspacing='1' width='100%'  style='font-size:11px'>	<tbody>		<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold;color:#002060;bgcolor:#dedede'></th>	<th  style='text-align:LEFT;font-weight:bold;color:#002060;bgcolor:#dedede'>DÉBITO FISCAL</th>	<th  style='text-align:LEFT;font-weight:bold;color:#002060;bgcolor:#dedede'></th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Emitidas</th>	<th  style='text-align:LEFT' id='emitQtd'>$cndsEmitidasDebFiscal</th>	<th  style='text-align:LEFT' id='emitPorc'>$cndsEmitidasDebFiscalPorc %</th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Não Emitidas</th>	<th  style='text-align:LEFT' id='naoEmitQtd'>$cndsNaoEmitidasDebFiscal</th>	<th  style='text-align:LEFT' id='naoEmitPorc'>$cndsNaoEmitidasDebFiscalPorc %</th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Sem Status</th>	<th  style='text-align:LEFT' id='semStatusQtd'>$cndsSemStatusDebFiscal</th>	<th  style='text-align:LEFT' id='semStatusPorc'>$cndsSemStatusDebFiscalPorc %</th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Total</th>	<th  style='text-align:LEFT' id='totalDebFiscal'>$totalDebFiscal</th>	<th  style='text-align:LEFT' >100 %</th>	</tr><tr style='text-align:center'>	<th  bgcolor='#dedede'></th>	<th  bgcolor='#dedede'><BR></th>	<th  bgcolor='#dedede' ></th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold;color:#002060;bgcolor:#dedede'></th>	<th  style='text-align:LEFT;font-weight:bold;color:#002060;bgcolor:#dedede'>DÍVIDA ATIVA</th>	<th  style='text-align:LEFT;font-weight:bold;color:#002060;bgcolor:#dedede'></th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Emitidas</th>	<th  style='text-align:LEFT' id='divAtiEmitQtd'>$cndsEmitidasDivAtiv</th>	<th  style='text-align:LEFT' id='divAtiEmitPorc'>$cndsEmitidasDivAtivPorc %</th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Não Emitidas</th>	<th  style='text-align:LEFT' id='divAtiEmiNaoEmitQtd'>$cndsNaoEmitidasDivAtiv</th>	<th  style='text-align:LEFT' id='divAtiEmiNaoEmitPorc'>$cndsNaoEmitidasDivAtivPorc %</th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Sem Status</th>	<th  style='text-align:LEFT' id='divAtiEmiSemStatusQtd'>$cndsSemStatusDivAtiv</th>	<th  style='text-align:LEFT' id='divAtiEmiSemStatusPorc'>$cndsSemStatusDivAtivPorc %</th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Total</th>	<th  style='text-align:LEFT' id='totalDivAtiv'>$totalDivAtiv</th>	<th  style='text-align:LEFT' >100 %</th>	</tr>		<tr style='text-align:center'>	<th  bgcolor='#dedede'></th>	<th  bgcolor='#dedede'><BR></th>	<th  bgcolor='#dedede' ></th>	</tr>	<tr style='text-align:center'>	<th  bgcolor='#dedede'></th>	<th  bgcolor='#dedede'>AMBAS</th>	<th  bgcolor='#dedede' ></th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Emitidas</th>	<th  style='text-align:LEFT' id='ambasEmitQtd'>$cndsEmitidasAmbas</th>	<th  style='text-align:LEFT' id='ambasEmitQtdEmitPorc'>$cndsEmitidasAmbasPorc %</th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Não Emitidas</th>	<th  style='text-align:LEFT' id='ambasEmitQtdEmiNaoEmitQtd'>$cndsNaoEmitidasAmbas</th>	<th  style='text-align:LEFT' id='ambasEmitQtdEmiNaoEmitPorc'>$cndsNaoEmitidasAmbasPorc %</th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Sem Status</th>	<th  style='text-align:LEFT' id='ambasEmitQtdEmiSemStatusQtd'>$cndsSemStatusAmbas</th>	<th  style='text-align:LEFT' id='ambasEmitQtdEmiSemStatusPorc'>$cndsSemStatusAmbasPorc %</th>	</tr>	<tr style='text-align:center'>	<th  style='text-align:LEFT;font-weight:bold'>Total</th>	<th  style='text-align:LEFT' id='totalAmbas'>$totalAmbas</th>	<th  style='text-align:LEFT' >100 %</th>	</tr>	</tbody>  	</table>";	$tbl = <<<EOD<table border="0" cellpadding="2" cellspacing="2"><thead> <tr style="background-color:#dedede;color:#002060;">  	<th  align="center" colspan='3' ><strong>DÉBITO FISCAL</strong></th> </tr></thead></table><table border="0" cellpadding="2" cellspacing="2"><thead> <tr style="color:#000;">	<td align="left" ><strong>Emitidas</strong></td>	<td align="left" id='emitQtd'>$cndsEmitidasDebFiscal</td>	<td align="left"  id='emitPorc'>$cndsEmitidasDebFiscalPorc %</td> </tr><tr style="color:#000;">	<td align="left" ><strong>Não Emitidas</strong></td>	<td align="left" id='emitQtd'>$cndsNaoEmitidasDebFiscal</td>	<td align="left"  id='emitPorc'>$cndsNaoEmitidasDebFiscalPorc %</td></tr><tr style="color:#000;">	<td align="left" ><strong>Sem Status</strong></td>	<td align="left" id='emitQtd'>$cndsSemStatusDebFiscal</td>	<td align="left"  id='emitPorc'>$cndsSemStatusDebFiscalPorc %</td> </tr><tr style="color:#000;">	<td align="left" ><strong>Total</strong></td>	<td align="left" id='emitQtd'>$totalDebFiscal</td>	<td align="left"  id='emitPorc'>100 %</td> </tr></thead> </table><table border="0" cellpadding="2" cellspacing="2"><thead> <tr style="background-color:#dedede;color:#002060;">  	<th  align="center" colspan='3' ><strong>DÍVIDA ATIVA</strong></th> </tr></thead></table><table border="0" cellpadding="2" cellspacing="2"><thead> <tr style="color:#000;">	<td align="left" ><strong>Emitidas</strong></td>	<td align="left" id='emitQtd'>$cndsEmitidasDivAtiv</td>	<td align="left"  id='emitPorc'>$cndsEmitidasDivAtivPorc %</td> </tr><tr style="color:#000;">	<td align="left" ><strong>Não Emitidas</strong></td>	<td align="left" id='emitQtd'>$cndsNaoEmitidasDivAtiv</td>	<td align="left"  id='emitPorc'>$cndsNaoEmitidasDivAtivPorc %</td></tr><tr style="color:#000;">	<td align="left" ><strong>Sem Status</strong></td>	<td align="left" id='emitQtd'>$cndsSemStatusDivAtiv</td>	<td align="left"  id='emitPorc'>$cndsSemStatusDivAtivPorc %</td> </tr><tr style="color:#000;">	<td align="left" ><strong>Total</strong></td>	<td align="left" id='emitQtd'>$totalDivAtiv</td>	<td align="left"  id='emitPorc'>100 %</td> </tr></thead> </table><table border="0" cellpadding="2" cellspacing="2"><thead> <tr style="background-color:#dedede;color:#002060;">  	<th  align="center" colspan='3' ><strong>CONJUNTA</strong></th> </tr></thead></table><table border="0" cellpadding="2" cellspacing="2"><thead> <tr style="color:#000;">	<td align="left" ><strong>Emitidas</strong></td>	<td align="left" id='emitQtd'>$cndsEmitidasAmbas</td>	<td align="left"  id='emitPorc'>$cndsEmitidasAmbasPorc %</td> </tr><tr style="color:#000;">	<td align="left" ><strong>Não Emitidas</strong></td>	<td align="left" id='emitQtd'>$cndsNaoEmitidasAmbas</td>	<td align="left"  id='emitPorc'>$cndsNaoEmitidasAmbasPorc %</td></tr><tr style="color:#000;">	<td align="left" ><strong>Sem Status</strong></td>	<td align="left" id='emitQtd'>$cndsSemStatusAmbas</td>	<td align="left"  id='emitPorc'>$cndsSemStatusAmbasPorc %</td> </tr><tr style="color:#000;">	<td align="left" ><strong>Total</strong></td>	<td align="left" id='emitQtd'>$totalAmbas</td>	<td align="left"  id='emitPorc'>100 %</td> </tr></thead> </table>EOD;	$obj_pdf->writeHTML($tbl, true, false, true, false, '');	$obj_pdf->Output('output.pdf', 'I');		}
 function dados_agrupados(){		if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	}	$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$data['perfil'] = $session_data['perfil'];		if($_SESSION['cliente'] == 2){		$data['empresa'] = 'SANDOZ';	}else{		$data['empresa'] = 'NOVARTIS';	}		$estados = $this->cnd_estadual_model->listarEstados();	$estadosCnds = array();	$i=1;	$naoEmitidas = 0;	$emitidas = 0;			$data['cndsEmitidasDebFiscal'] =  $this->cnd_estadual_model->contaCndEstadual($idContratante,1,'cnd_estadual_debito_fiscal');			$data['cndsNaoEmitidasDebFiscal'] = $this->cnd_estadual_model->contaCndEstadual($idContratante,2,'cnd_estadual_debito_fiscal');				$data['cndsEmitidasDivAtiv'] =  $this->cnd_estadual_model->contaCndEstadual($idContratante,1,'cnd_estadual_divida_ativa');			$data['cndsNaoEmitidasDivAtiv'] = $this->cnd_estadual_model->contaCndEstadual($idContratante,2,'cnd_estadual_divida_ativa');				$data['cndsEmitidasAmbas'] =  $this->cnd_estadual_model->contaCndEstadual($idContratante,1,'cnd_estadual_ambas');			$data['cndsNaoEmitidasAmbas'] = $this->cnd_estadual_model->contaCndEstadual($idContratante,2,'cnd_estadual_ambas');				$data['totalCnds'] = $data['cndsEmitidasDebFiscal'][0]->total + $data['cndsNaoEmitidasDebFiscal'][0]->total +					 $data['cndsEmitidasDivAtiv'][0]->total + $data['cndsNaoEmitidasDivAtiv'][0]->total +					 $data['cndsEmitidasAmbas'][0]->total + $data['cndsNaoEmitidasAmbas'][0]->total;						 		if($data['totalCnds'] == 0){		$data['cndsEmitidasDebFiscalPorc'] = 0;		$data['cndsNaoEmitidasDebFiscalPorc'] = 0;		$data['cndsEmitidasDivAtivPorc'] = 0;		$data['cndsNaoEmitidasDivAtivPorc'] = 0;		$data['cndsEmitidasAmbasPorc'] = 0;		$data['cndsNaoEmitidasAmbasPorc'] = 0;	}else{		$data['cndsEmitidasDebFiscalPorc'] = round((($data['cndsEmitidasDebFiscal'][0]->total / $data['totalCnds']) * 100),2);		$data['cndsNaoEmitidasDebFiscalPorc'] = round((($data['cndsNaoEmitidasDebFiscal'][0]->total / $data['totalCnds']) * 100),2);		$data['cndsEmitidasDivAtivPorc'] = round((($data['cndsEmitidasDivAtiv'][0]->total / $data['totalCnds']) * 100),2);		$data['cndsNaoEmitidasDivAtivPorc'] = round((($data['cndsNaoEmitidasDivAtiv'][0]->total / $data['totalCnds']) * 100),2);		$data['cndsEmitidasAmbasPorc'] = round((($data['cndsEmitidasAmbas'][0]->total / $data['totalCnds']) * 100),2);		$data['cndsNaoEmitidasAmbasPorc'] = round((($data['cndsNaoEmitidasAmbas'][0]->total / $data['totalCnds']) * 100),2);	}								$data['totalCndsPorc'] =$data['cndsEmitidasDebFiscalPorc']+$data['cndsNaoEmitidasDebFiscalPorc']+$data['cndsEmitidasDivAtivPorc'] +$data['cndsNaoEmitidasDivAtivPorc']+$data['cndsEmitidasAmbasPorc']+$data['cndsNaoEmitidasAmbasPorc'];			foreach($estados as $est){			$estadosCnds[$i]['uf'] = $est->uf;				$cndsEmitidasDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_debito_fiscal',$est->uf);				$cndsNaoEmitidasDebFiscal = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_debito_fiscal',$est->uf);				$cndsEmitidasDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_divida_ativa',$est->uf);				$cndsNaoEmitidasDivAtiv = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_divida_ativa',$est->uf);				$cndsEmitidasAmbas = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,1,'cnd_estadual_ambas',$est->uf);				$cndsNaoEmitidasAmbas = $this->cnd_estadual_model->contaCndEstadualByUf($idContratante,2,'cnd_estadual_ambas',$est->uf);				$estadosCnds[$i]['cndsEmitidasDebFiscal'] = $cndsEmitidasDebFiscal[0]->total;		$estadosCnds[$i]['cndsNaoEmitidasDebFiscal'] = $cndsNaoEmitidasDebFiscal[0]->total;		$estadosCnds[$i]['cndsEmitidasDivAtiv'] = $cndsEmitidasDivAtiv[0]->total;		$estadosCnds[$i]['cndsNaoEmitidasDivAtiv'] = $cndsNaoEmitidasDivAtiv[0]->total;		$estadosCnds[$i]['cndsEmitidasAmbas'] = $cndsEmitidasAmbas[0]->total;		$estadosCnds[$i]['cndsNaoEmitidasAmbas'] = $cndsNaoEmitidasAmbas[0]->total;				$estadosCnds[$i]['totalCndsPorc'] = $cndsEmitidasDebFiscal[0]->total +$cndsNaoEmitidasDebFiscal[0]->total+ $cndsEmitidasDivAtiv[0]->total + $cndsNaoEmitidasDivAtiv[0]->total+ $cndsEmitidasAmbas[0]->total+ $cndsNaoEmitidasAmbas[0]->total; 					$estadosCnds[$i]['totalCndsDebFiscal'] = $cndsEmitidasDebFiscal[0]->total +$cndsNaoEmitidasDebFiscal[0]->total;		$estadosCnds[$i]['totalCndsDivAtiv'] = $cndsEmitidasDivAtiv[0]->total + $cndsNaoEmitidasDivAtiv[0]->total;		$estadosCnds[$i]['totalCndsAmbas'] = $cndsEmitidasAmbas[0]->total+ $cndsNaoEmitidasAmbas[0]->total; 					if($estadosCnds[$i]['totalCndsDebFiscal'] == 0){			$estadosCnds[$i]['cndsEmitidasDebFiscalPorc'] =100;		}else{			$estadosCnds[$i]['cndsEmitidasDebFiscalPorc'] = round((($estadosCnds[$i]['cndsEmitidasDebFiscal'] / $estadosCnds[$i]['totalCndsDebFiscal']) * 100),2);		}				if($estadosCnds[$i]['totalCndsDebFiscal'] == 0){			$estadosCnds[$i]['cndsNaoEmitidasDebFiscalPorc'] = 100;		}else{			$estadosCnds[$i]['cndsNaoEmitidasDebFiscalPorc'] = round((($estadosCnds[$i]['cndsNaoEmitidasDebFiscal'] / $estadosCnds[$i]['totalCndsDebFiscal']) * 100),2);		}						if($estadosCnds[$i]['totalCndsDivAtiv'] == 0){			$estadosCnds[$i]['cndsEmitidasDivAtivPorc'] = 100;		}else{			$estadosCnds[$i]['cndsEmitidasDivAtivPorc'] = round((($estadosCnds[$i]['cndsEmitidasDivAtiv'] / $estadosCnds[$i]['totalCndsDivAtiv']) * 100),2);		}				if($estadosCnds[$i]['totalCndsDivAtiv'] == 0){			$estadosCnds[$i]['cndsNaoEmitidasDivAtivPorc'] = 100;		}else{			$estadosCnds[$i]['cndsNaoEmitidasDivAtivPorc'] = round((($estadosCnds[$i]['cndsNaoEmitidasDivAtiv'] / $estadosCnds[$i]['totalCndsDivAtiv']) * 100),2);		}				if($estadosCnds[$i]['totalCndsAmbas'] == 0){			$estadosCnds[$i]['cndsEmitidasAmbasPorc'] = 100;		}else{			$estadosCnds[$i]['cndsEmitidasAmbasPorc'] = round((($estadosCnds[$i]['cndsEmitidasAmbas'] / $estadosCnds[$i]['totalCndsAmbas']) * 100),2);		}						if($estadosCnds[$i]['totalCndsAmbas'] == 0){			$estadosCnds[$i]['cndsNaoEmitidasAmbasPorc'] = 100;		}else{			$estadosCnds[$i]['cndsNaoEmitidasAmbasPorc'] = round((($estadosCnds[$i]['cndsNaoEmitidasAmbas'] /$estadosCnds[$i]['totalCndsAmbas']) * 100),2);		}				$estadosCnds[$i]['totalCndsPorcentagem'] = 		$estadosCnds[$i]['cndsNaoEmitidasAmbasPorc'] +  		$estadosCnds[$i]['cndsEmitidasAmbasPorc'] +  		$estadosCnds[$i]['cndsNaoEmitidasDivAtivPorc']  +  		$estadosCnds[$i]['cndsEmitidasDivAtivPorc'] +  		$estadosCnds[$i]['cndsNaoEmitidasDebFiscalPorc']  +  		$estadosCnds[$i]['cndsEmitidasDebFiscalPorc'];  		$estadosCnds[$i]['totalCndsPorcentagem'] = '100';						if(($estadosCnds[$i]['cndsEmitidasDebFiscalPorc'] == '100') && 			($estadosCnds[$i]['cndsEmitidasDivAtivPorc'] == '100') &&			($estadosCnds[$i]['cndsEmitidasAmbasPorc'] == '100') &&			($estadosCnds[$i]['cndsEmitidasAmbas'] == '0') &&			($estadosCnds[$i]['cndsEmitidasDivAtiv'] == '0') &&			($estadosCnds[$i]['cndsEmitidasDebFiscal'] == '0') 			){								$estadosCnds[$i]['cor'] ='#bdd7ee';							}else{					if(($estadosCnds[$i]['cndsEmitidasDebFiscalPorc'] <= 69) || 				($estadosCnds[$i]['cndsEmitidasDivAtivPorc'] <= 69) ||				($estadosCnds[$i]['cndsEmitidasAmbasPorc'] <= 69)){					$estadosCnds[$i]['cor'] ='#FF0000';			}else{						if(($estadosCnds[$i]['cndsEmitidasDebFiscalPorc'] >= 83) || 					($estadosCnds[$i]['cndsEmitidasDivAtivPorc'] >= 83) ||					($estadosCnds[$i]['cndsEmitidasAmbasPorc'] >= 83)){						$estadosCnds[$i]['cor'] ='#00B050';				}else{					$estadosCnds[$i]['cor'] ='#FFFF00';				}			}		}		$i++;			}		$data['cndEstado'] = $estadosCnds;	$this->load->view('header_pages_view',$data);	$this->load->view('dados_agrupados_mapa', $data);	$this->load->view('footer_pages_view');
 }function salvarSerpac(){			$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;		$serpacEmitidaPharma = $_GET['serpacEmitidaPharma'];	$serpacNaoEmitidaPharma = $_GET['serpacNaoEmitidaPharma'];	$serpacEmitidaSandoz = $_GET['serpacEmitidaSandoz'];	$serpacNaoEmitidaSandoz = $_GET['serpacNaoEmitidaSandoz'];	$serpacNaoEmitidaPharma = $_GET['serpacNaoEmitidaPharma'];	$serpacEmitidaAlcon = $_GET['serpacEmitidaAlcon'];	$serpacNaoEmitidaAlcon = $_GET['serpacNaoEmitidaAlcon'];	$data = $_GET['data'];			$verificaSerpac = $this->cnd_estadual_model->contarSerpac($data,'EMPRESA UM','EMPRESA UM',1);		if($verificaSerpac[0]->total <> 0){		//atualiza		$dadosSerpacPharmaEmitida = array(		'emitidas' => $serpacEmitidaPharma,		);					$this->cnd_estadual_model->atualizar_serpac($dadosSerpacPharmaEmitida,$data,'EMPRESA UM','EMPRESA UM');			}else{		//insere		$dadosSerpacPharmaEmitida = array(			'cnpj' => 'EMPRESA UM',			'mes_competencia' => $data,			'emitidas' => $serpacEmitidaPharma,			'nome_empresa' => 'EMPRESA UM',			'id_contratante' => 1		);						$this->cnd_estadual_model->insere_serpac($dadosSerpacPharmaEmitida);			}			$verificaSerpac = $this->cnd_estadual_model->contarSerpac($data,'EMPRESA UM','EMPRESA UM',2);		if($verificaSerpac[0]->total <>0){		//atualiza			$dadosSerpacPharmaNaoEmitida = array(		'n_emitidas' => $serpacNaoEmitidaPharma,	);		$this->cnd_estadual_model->atualizar_serpac($dadosSerpacPharmaNaoEmitida,$data,'EMPRESA UM','EMPRESA UM');			}else{		//insere			$dadosSerpacPharmaNaoEmitida = array(			'cnpj' => 'EMPRESA UM',			'mes_competencia' => $data,			'n_emitidas' => $serpacNaoEmitidaPharma,			'nome_empresa' => 'EMPRESA UM',			'id_contratante' => 1		);			$this->cnd_estadual_model->insere_serpac($dadosSerpacPharmaNaoEmitida);			}						$verificaSerpac = $this->cnd_estadual_model->contarSerpac($data,'EMPRESA DOIS','EMPRESA DOIS',1);		if($verificaSerpac[0]->total <>0){		//atualiza			$dadosSerpacSandozEmitida = array(			'emitidas' => $serpacEmitidaSandoz,		);			$this->cnd_estadual_model->atualizar_serpac($dadosSerpacSandozEmitida,$data,'EMPRESA DOIS','EMPRESA DOIS');			}else{		//insere		$dadosSerpacSandozEmitida = array(			'cnpj' => 'EMPRESA DOIS',			'mes_competencia' => $data,			'emitidas' => $serpacEmitidaSandoz,			'nome_empresa' => 'EMPRESA DOIS',			'id_contratante' => 2		);					$this->cnd_estadual_model->insere_serpac($dadosSerpacSandozEmitida);			}						$verificaSerpac = $this->cnd_estadual_model->contarSerpac($data,'EMPRESA DOIS','EMPRESA DOIS',2);		if($verificaSerpac[0]->total <>0){		//atualiza			$dadosSerpacSandozNaoEmitida = array(		'n_emitidas' => $serpacNaoEmitidaSandoz,	);			$this->cnd_estadual_model->atualizar_serpac($dadosSerpacSandozNaoEmitida,$data,'EMPRESA DOIS','EMPRESA DOIS');			}else{		//insere		$dadosSerpacSandozNaoEmitida = array(			'cnpj' => 'EMPRESA DOIS',			'mes_competencia' => $data,			'n_emitidas' => $serpacNaoEmitidaSandoz,			'nome_empresa' => 'EMPRESA DOIS',			'id_contratante' => 2		);					$this->cnd_estadual_model->insere_serpac($dadosSerpacSandozNaoEmitida);			}			$verificaSerpac = $this->cnd_estadual_model->contarSerpac($data,'EMPRESA TRES','EMPRESA TRES',1);		if($verificaSerpac[0]->total <>0){		$dadosSerpacAlconEmitida = array(			'emitidas' => $serpacEmitidaAlcon,		);			$this->cnd_estadual_model->atualizar_serpac($dadosSerpacAlconEmitida,$data,'EMPRESA TRES','EMPRESA TRES');			}else{		//insere		$dadosSerpacAlconEmitida = array(			'cnpj' => 'EMPRESA TRES',			'mes_competencia' => $data,			'n_emitidas' => $serpacEmitidaAlcon,			'nome_empresa' => 'EMPRESA TRES',			'id_contratante' => 1		);							$this->cnd_estadual_model->insere_serpac($dadosSerpacAlconEmitida);			}				$verificaSerpac = $this->cnd_estadual_model->contarSerpac($data,'EMPRESA TRES','EMPRESA TRES',2);		if($verificaSerpac[0]->total <>0){		//atualiza			$dadosSerpacAlconNaoEmitida = array(		'n_emitidas' => $serpacNaoEmitidaAlcon,	);			$this->cnd_estadual_model->atualizar_serpac($dadosSerpacAlconNaoEmitida,$data,'EMPRESA TRES','EMPRESA TRES');			}else{		//insere			$dadosSerpacAlconNaoEmitida = array(			'cnpj' => 'EMPRESA TRES',			'mes_competencia' => $data,			'n_emitidas' => $serpacNaoEmitidaAlcon,			'nome_empresa' => 'EMPRESA TRES',			'id_contratante' => 1		);					$this->cnd_estadual_model->insere_serpac($dadosSerpacAlconNaoEmitida,$data,'EMPRESA TRES','EMPRESA TRES');			}		echo 1;}
function exportKpi(){	
	if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$primeiroDia = $_POST['data'];
	$tipo = $_POST['tipo'];
	
	$dataArr = explode("-",$primeiroDia);
	$dataExibicao = meses($dataArr[1]).'/'.$dataArr[0];
	
	if($tipo == 'todos'){		$pharma = $this->kpi_dinamica('EMPRESA UM',$primeiroDia);		$sandoz = $this->kpi_dinamica('EMPRESA DOIS',$primeiroDia);		$alcon = $this->kpi_dinamica('EMPRESA TRES',$primeiroDia);		
		$html = $this->montaHtmlVarios($pharma,$sandoz,$alcon,$dataExibicao);
	}else{
		$cliente = $this->cnd_estadual_model->listarResumoClientes($tipo,$primeiroDia);							$isArrayDados =  is_array($cliente) ? '1' : '0';			if($isArrayDados == 0){ 			$cliente =  $this->kpi_dinamica($tipo,$primeiroDia);		}else{			$cliente = $cliente;		}				$cliente = $this->kpi_dinamica($tipo,$primeiroDia);		
		$html = $this->montaHtml($cliente,$dataExibicao);
	}
	
	$dataAtual = date("d/m/Y - H:i");
	tcpdf();
	$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$obj_pdf->SetCreator(PDF_CREATOR);
	
	$obj_pdf->SetHeaderData('','' , $dataAtual,'' );
	$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$obj_pdf->SetDefaultMonospacedFont('helvetica');
	$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$obj_pdf->SetFont('helvetica', '', 9);
	$obj_pdf->setFontSubsetting(false);
	$obj_pdf->AddPage();
	
	$obj_pdf->writeHTML($html, true, false, true, false, '');
	$obj_pdf->Output('output.pdf', 'I');
	
	
	
	
}

function montaHtml($cliente,$dataExibicao){	
	$empresa = $cliente[0]['nome_empresa'];
	$title = "RESUMO - CERTIDÕES NEGATIVAS DE DÉBITOS ESTADUAIS - ".$dataExibicao;
	$html='';
	$html.='<p style="font-size:14px;text-align:center">'.$title.'</p>';
	$html.='<table cellspacing="0" width="100%" style="font-size:12px">';
	$html.='
		 <tr style="background-color:#002060;border:1px solid #002060!important;">
		<td colspan="7" style="width:100%;color:#fff;text-align:center;font-weight:bold;border:1px solid #002060!important;">'.$empresa.' </td>
		</tr>   
		<tr style="background-color:#01A8FE;color:#000!important;border:1px solid #002060!important;text-align:center;font-size:11px;">
		<td style="border:1px solid #002060!important;width:20%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CNPJ </td>
		<td style="border:1px solid #002060!important;width:25%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REFER&Ecirc;NCIA</td>
		<td style="border:1px solid #002060!important;width:10%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp; EMITIDAS </td>
		<td style="border:1px solid #002060!important;width:15%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">N&Atilde;O <BR>  EMITIDAS</td>
		<td style="border:1px solid #002060!important;width:10%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL </td>
		<td style="width:10%;background-color:#DEDEDE;font-size:9px!important;" > </td>
		<td style="width:10%;border-right:1px solid #dedede!important;background-color:#DEDEDE;font-size:9px!important;" > </td>
		 </tr>
		 ';
		$totalPH = 0;
		$totalPHEmit = 0;
		$totalPHNEmit = 0;
		foreach($cliente as $ph){ 
			$totalPHEmit += $ph['emitidas'];
			$totalPHNEmit += $ph['n_emitidas'];
			$emitidas = $ph['emitidas']; 
			$naoEmitidas = $ph['n_emitidas'];
			$total = $emitidas + $naoEmitidas;
			$cnpj = $ph['cnpj'];
			$referencia = $ph['referencia'];		
			if($ph['cnpj'] <>"SERPAC"){
				$html.='	  
				 <tr style="background-color:#dedede;">					
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">'.$cnpj.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">'.$referencia.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$emitidas.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$naoEmitidas.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$total.' </td>
					<td style="width:10%;background-color:#DEDEDE;font-size:9px!important;" > </td>
					<td style="width:10%;border-right:1px solid #dedede!important;background-color:#DEDEDE;font-size:9px!important;" > </td>
				  </tr>';		  
			}else{				
				$totalSerpac = $ph['emitidas']+$ph['n_emitidas'];
				$html.='  
				   <tr style="background-color:#DEDEDE;">
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">EMPRESA EXTERNA  </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;"> - </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$emitidas.'  </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$naoEmitidas.' </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalSerpac.'</td>
					<td style="border:0px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> Atual </td>
					<td style="border:0px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> Target </td>
				  </tr>
				'; 
			   }//fim if serpac
			}//fim foreach
		$totalPH = $totalPHEmit+$totalPHNEmit;
		if($totalPHNEmit == 0){
			$porcPH =  100;
		}else{	
			$porcPH = round((100 - (($totalPHNEmit / $totalPH)*100)),2)."%";
		}	
		$html.='
		  <tr style="background-color:#DEDEDE;">
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#000;text-align:left;">-</td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#ff0000;text-align:left;">Total : </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalPHEmit.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalPHNEmit.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalPH.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#01A8FE;font-weight:bold"> '.$porcPH.'   </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> 89,0% </td>
		  </tr>
		  </thead>

			</table>';
		  
			return$html;

}

function montaHtmlVarios($pharma,$sandoz,$alcon,$dataExibicao){	
	
	$title = "RESUMO - CERTIDÕES NEGATIVAS DE DÉBITOS ESTADUAIS - ".$dataExibicao;
	$html='';
	$html.='<p style="font-size:14px;text-align:center">'.$title.'</p>';
	$html.='<table cellspacing="0" width="100%" style="font-size:12px">';
	$html.='
		 <tr style="background-color:#002060;border:1px solid #002060!important;">
		<td colspan="7" style="width:100%;color:#fff;text-align:center;font-weight:bold;border:1px solid #002060!important;">EMPRESA UM </td>
		</tr>   
		<tr style="background-color:#01A8FE;color:#000!important;border:1px solid #002060!important;text-align:center;font-size:11px;">
		<td style="border:1px solid #002060!important;width:20%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CNPJ </td>
		<td style="border:1px solid #002060!important;width:25%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REFER&Ecirc;NCIA</td>
		<td style="border:1px solid #002060!important;width:10%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp; EMITIDAS </td>
		<td style="border:1px solid #002060!important;width:15%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">N&Atilde;O <BR>  EMITIDAS</td>
		<td style="border:1px solid #002060!important;width:10%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL </td>
		<td style="width:10%;background-color:#DEDEDE;font-size:9px!important;" > </td>
		<td style="width:10%;border-right:1px solid #dedede!important;background-color:#DEDEDE;font-size:9px!important;" > </td>
		 </tr>
		 ';
		$totalPH = 0;
		$totalPHEmit = 0;
		$totalPHNEmit = 0;
		foreach($pharma as $ph){ 
			$totalPHEmit += $ph['emitidas'];
			$totalPHNEmit += $ph['n_emitidas'];
			$emitidas = $ph['emitidas'];
			$naoEmitidas = $ph['n_emitidas'];
			$total = $emitidas + $naoEmitidas;
			$cnpj = $ph['cnpj'];
			$referencia = $ph['referencia'];			
			if($ph['cnpj'] <>"SERPAC"){
				$html.='	  
				 <tr style="background-color:#dedede;">					
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">'.$cnpj.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">'.$referencia.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$emitidas.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$naoEmitidas.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$total.' </td>
					<td style="width:10%;background-color:#DEDEDE;font-size:9px!important;" > </td>
					<td style="width:10%;border-right:1px solid #dedede!important;background-color:#DEDEDE;font-size:9px!important;" > </td>
				  </tr>';		  
			}else{				
				$totalSerpac = $ph['emitidas']+$ph['n_emitidas'];
				$html.='  
				   <tr style="background-color:#DEDEDE;">
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">EMPRESA EXTERNA  </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;"> - </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$emitidas.'  </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$naoEmitidas.' </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalSerpac.'</td>
					<td style="border:0px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> Atual </td>
					<td style="border:0px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> Target </td>
				  </tr>
				'; 
			   }//fim if serpac
			}//fim foreach
		$totalPH = $totalPHEmit+$totalPHNEmit;		if($totalPHNEmit == 0){			$porcPH =  100;			$porcPHSoma =  100;		}else{				$porcPH = round((100 - (($totalPHNEmit / $totalPH)*100)),2);			$porcPHSoma = round((100 - (($totalPHNEmit / $totalPH)*100)),2);		}	
		$html.='
		  <tr style="background-color:#DEDEDE;">
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#000;text-align:left;">-</td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#ff0000;text-align:left;">Total : </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalPHEmit.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalPHNEmit.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalPH.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#01A8FE;font-weight:bold"> '.$porcPH.'%   </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> 89,0% </td>
		  </tr>
		  <tr style="background-color:#fff;color:#fff!important;">
			<td colspan="7" style="width:100%;color:#fff;text-align:center;font-weight:bold"><BR> </td>
		  </tr>
		   <tr style="background-color:#002060;color:#fff!important;">
			<td colspan="7" style="width:100%;color:#fff;text-align:center;font-weight:bold;border:1px solid #002060!important;">EMPRESA DOIS </td>
		  </tr>	
			<tr style="background-color:#01A8FE;color:#000!important;border:1px solid #002060!important;text-align:center;font-size:11px;">
		<td style="border:1px solid #002060!important;width:20%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CNPJ </td>
		<td style="border:1px solid #002060!important;width:25%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REFER&Ecirc;NCIA</td>
		<td style="border:1px solid #002060!important;width:10%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp; EMITIDAS </td>
		<td style="border:1px solid #002060!important;width:15%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">N&Atilde;O <BR>  EMITIDAS</td>
		<td style="border:1px solid #002060!important;width:10%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL </td>
		<td style="width:10%;background-color:#DEDEDE;font-size:9px!important;" > </td>
		<td style="width:10%;border-right:1px solid #dedede!important;background-color:#DEDEDE;font-size:9px!important;" > </td>
		 </tr>';
		  //Sandos
		  $totalSand = 0;
		  $totalSandEmit = 0;
		  $totalSandNEmit = 0;
		  foreach($sandoz as $sd){ 
			$totalSandEmit += $sd['emitidas'];
			$totalSandNEmit += $sd['n_emitidas'];
			$emitidas = $sd['emitidas'];
			$naoEmitidas = $sd['n_emitidas'];
			$total = $emitidas + $naoEmitidas;
			$cnpj = $sd['cnpj'];
			$referencia = $sd['referencia'];
			$total = $sd['emitidas']+$sd['n_emitidas'];
			if($sd['cnpj'] <>"SERPAC"){
			$html.='
				 <tr style="background-color:#DEDEDE;">					
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">'.$cnpj.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">'.$referencia.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$emitidas.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$naoEmitidas.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$total.' </td>
					<td style="width:10%;background-color:#DEDEDE;font-size:9px!important;" > </td>
					<td style="width:10%;border-right:1px solid #dedede!important;background-color:#DEDEDE;font-size:9px!important;" > </td>
				  </tr>';		
		   }else{
			$totalSerpac = $sd['emitidas']+$sd['n_emitidas'];
				$html.='  
				   <tr style="background-color:#DEDEDE;">
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">EMPRESA EXTERNA  </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;"> - </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$emitidas.'  </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$naoEmitidas.' </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalSerpac.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> Atual </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> Target </td>
				  </tr>
				'; 
				}//fim if serpac
		  }//fim foreach
		$totalSand = $totalSandEmit+$totalSandNEmit;		  		if($totalSandNEmit == 0){			$porcSD =  100;			$porcSDSoma =  100;		}else{				$porcSD = round((100 - (($totalSandNEmit / $totalSand)*100)),2);			$porcSDSoma = round((100 - (($totalSandNEmit / $totalSand)*100)),2);		}
		   
		  
		  $html.='
		  <tr style="background-color:#DEDEDE;">
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#000;text-align:left;">-</td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#ff0000;text-align:left;">Total : </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalSandEmit.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalSandNEmit.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalSand.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#01A8FE;font-weight:bold"> '.$porcSD.'%   </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> 76,0% </td>
		  </tr>
		  <tr style="background-color:#fff;color:#fff!important;">
			<td colspan="7" style="width:100%;color:#fff;text-align:center;font-weight:bold"><BR> </td>
		  </tr>
		   <tr style="background-color:#002060;color:#fff!important;">
			<td colspan="7" style="border:1px solid #002060!important;width:100%;color:#fff;text-align:center;font-weight:bold">EMPRESA TRÊS </td>
		  </tr>	
			<tr style="background-color:#01A8FE;color:#000!important;border:1px solid #002060!important;text-align:center;font-size:11px;">
		<td style="border:1px solid #002060!important;width:20%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CNPJ </td>
		<td style="border:1px solid #002060!important;width:25%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REFER&Ecirc;NCIA</td>
		<td style="border:1px solid #002060!important;width:10%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp; EMITIDAS </td>
		<td style="border:1px solid #002060!important;width:15%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">N&Atilde;O <BR>  EMITIDAS</td>
		<td style="border:1px solid #002060!important;width:10%;font-size:9px!important;color:#fff;text-align:center;font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL </td>
		<td style="width:10%;background-color:#DEDEDE;font-size:9px!important;" > </td>
		<td style="width:10%;border-right:1px solid #dedede!important;background-color:#DEDEDE;font-size:9px!important;" > </td>
		 </tr>';
		  
		  	
		  //alcon
		  $totalAlcon = 0;
		  $totalAlconEmit = 0;
		  $totalAlconNEmit = 0;
		  foreach($alcon as $sd){ 
			$totalAlconEmit += $sd['emitidas'];
			$totalAlconNEmit += $sd['n_emitidas'];
			$emitidas = $sd['emitidas']; 
			$naoEmitidas = $sd['n_emitidas'];
			$total = $emitidas + $naoEmitidas;
			$cnpj = $sd['cnpj'];
			$referencia = $sd['referencia'];
			//$total = $sd['emitidas']+$sd['n_emitidas'];
			 if($sd['cnpj'] <>"SERPAC"){
			$html.='
				 <tr style="background-color:#DEDEDE;">					
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">'.$cnpj.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">'.$referencia.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$emitidas.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$naoEmitidas.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$total.' </td>
					<td style="width:10%;font-size:9px!important;" > </td>
					<td style="width:10%;border-right:1px solid #dedede!important;font-size:9px!important;" > </td>
				  </tr>';		
		   }else{
			$totalSerpac = $sd['emitidas']+$sd['n_emitidas'];
				$html.='  
				   <tr style="background-color:#DEDEDE;">
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;">EMPRESA EXTERNA  </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:left;"> - </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$emitidas.'  </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$naoEmitidas.' </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalSerpac.'</td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> Atual </td>
					<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> Target </td>
				  </tr>
				'; 
				}//fim if serpac
		 }//fim foreach
		 $totalAlcon = $totalAlconEmit+$totalAlconNEmit;
		if($totalAlconEmit == 0){			$porcAlconSoma =  100;			$porcAlcon =  100;		}else{				$porcAlcon = round((100 - (($totalAlconNEmit / $totalAlcon)*100)),2);			$porcAlconSoma = round((100 - (($totalAlconNEmit / $totalAlcon)*100)),2);		}		
			$totalPorc = round((($porcAlconSoma	+ $porcPHSoma + $porcSDSoma) / 3),2);
		
		 
		  $html.='
		  <tr style="background-color:#DEDEDE;">
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#000;text-align:left;">-</td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#ff0000;text-align:left;">Total : </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalAlconEmit.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalAlconNEmit.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#002060;text-align:center;">'.$totalAlcon.' </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#01A8FE;font-weight:bold"> '.$porcAlcon.'%   </td>
			<td style="border:1px solid #002060!important;font-size:8px!important;color:#fff;text-align:center;background-color:#002060;font-weight:bold"> 83,0% </td>
		  </tr>
		   <tr style="background-color:#F5F5F5;color:#fff!important;">
			<th colspan="7" style="text-align:center;font-size:12px;border:1px solid #F5F5F5!important;font-weight:bold"></th>
		  </tr>	
		  <tr style="background-color:#F5F5F5;">
			<td colspan=5 style="width:60%;font-size:11px;text-align:center;font-weight:bold;border:1px solid #fff!important;background-color:#002060;color:#fff">Target Geral - Atual </td>
			<td colspan=2 style="width:40%;font-size:11px;text-align:center;font-weight:bold;border:1px solid #01A8FE!important;background-color:#01A8FE;color:#fff;border-bottom:1px solid #fff!important;"> '.$totalPorc.' % </td>
		  </tr>
		  <tr style="background-color:#F5F5F5;">
			<td colspan=5 style="width:60%;font-size:11px;text-align:center;font-weight:bold;border:1px solid #fff!important;background-color:#002060;color:#fff">Target Geral </td>
			<td colspan=2 style="width:40%;font-size:11px;text-align:center;font-weight:bold;border:1px solid #01A8FE!important;background-color:#002060;color:#fff;border-bottom:1px solid #fff!important;"> 83,0%  </td>

		  </tr>
		</thead>

			</table>';
						
			return$html;

}
function grafico(){		if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	}	$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$data['perfil'] = $session_data['perfil'];		$data['meses'] = $this->cnd_estadual_model->listarMesesKPI();		if(empty($_POST)){		$primeiroDia = date("Y-m".'-01');		$dataArr = explode("-",$primeiroDia);			$data['dataExibicao'] = meses(date("m")).'/'.date("Y");				$primeiraData  = date('Y-m-d', strtotime('-365 days', strtotime($primeiroDia)));		$ultimoDia = cal_days_in_month(CAL_GREGORIAN, $dataArr[1], $dataArr[0]);		$ultimaData  = date($dataArr[0].'-'.$dataArr[1].'-'.$ultimoDia);			}else{		$primeiroDia = $_POST['data'];		$dataArr = explode("-",$primeiroDia);				$data['dataExibicao'] = meses($dataArr[1]).'/'.$dataArr[0];				$primeiraData  = date($dataArr[0].'-'.$dataArr[1].'-01');		$ultimoDia = cal_days_in_month(CAL_GREGORIAN, $dataArr[1], $dataArr[0]);				$ultimaData  = date($dataArr[0].'-'.$dataArr[1].'-'.$ultimoDia);	}		$data['primeiroDia'] = $primeiroDia;	$dadosPharma = array();			$dadosDinamicosPharma = $this->kpi_dinamica_grafico('EMPRESA UM',$primeiraData,$ultimaData);	$dadosConsolidadosPharma = $this->cnd_estadual_model->listarResumoClientesEntrePeriodo('EMPRESA UM',$primeiraData,$ultimaData);		$i=1;			foreach($dadosDinamicosPharma as $pha){					foreach($dadosConsolidadosPharma as $phac){				if($pha['mes_competencia'] == $phac['mes_competencia']){					$dataArr = explode("-",$phac['mes_competencia']);						$ultimoDia = cal_days_in_month(CAL_GREGORIAN, $dataArr[1], $dataArr[0]);							$ultimaData  = date($dataArr[0].'-'.$dataArr[1].'-'.$ultimoDia);										$dadosPharma[$i]['mes_competencia'] = $phac['mes_competencia'];					$temSerpac = $this->cnd_estadual_model->verificarSerpac('EMPRESA UM',$phac['mes_competencia'],$ultimaData);									if($temSerpac[0]['total'] == 0){						$dadosPharma[$i]['emitidas']= $phac['emitidas'] + $pha['emitidas'] ;						$dadosPharma[$i]['nao_emitidas']= $phac['nao_emitidas'] + $pha['nao_emitidas'];									if($dadosPharma[$i]['emitidas'] == 0){							$dadosPharma[$i]['porc'] = 0;						}else{							$dadosPharma[$i]['porc'] = round((($dadosPharma[$i]['emitidas'] / ($dadosPharma[$i]['nao_emitidas'] + $dadosPharma[$i]['emitidas'])) * 100),2);						}										}else{						$dadosPharma[$i]['emitidas']= $phac['emitidas'];						$dadosPharma[$i]['nao_emitidas']= $phac['nao_emitidas'];						$dadosPharma[$i]['porc']= $phac['porc'];					}												}			$i++;					}	}		$dadosSandoz = array();		$dadosDinamicosSandoz = $this->kpi_dinamica_grafico('EMPRESA DOIS',$primeiraData,$ultimaData);	$dadosConsolidadosSandoz = $this->cnd_estadual_model->listarResumoClientesEntrePeriodo('EMPRESA DOIS',$primeiraData,$ultimaData);		$i=1;	foreach($dadosDinamicosSandoz as $pha){					foreach($dadosConsolidadosSandoz as $phac){				if($pha['mes_competencia'] == $phac['mes_competencia']){					$dataArr = explode("-",$phac['mes_competencia']);						$ultimoDia = cal_days_in_month(CAL_GREGORIAN, $dataArr[1], $dataArr[0]);							$ultimaData  = date($dataArr[0].'-'.$dataArr[1].'-'.$ultimoDia);										$dadosSandoz[$i]['mes_competencia'] = $phac['mes_competencia'];					$temSerpac = $this->cnd_estadual_model->verificarSerpac('EMPRESA DOIS',$phac['mes_competencia'],$ultimaData);									if($temSerpac[0]['total'] == 0){						$dadosSandoz[$i]['emitidas']= $phac['emitidas'] + $pha['emitidas'] ;						$dadosSandoz[$i]['nao_emitidas']= $phac['nao_emitidas'] + $pha['nao_emitidas'];									if($dadosSandoz[$i]['emitidas'] == 0){							$dadosSandoz[$i]['porc'] = 0;						}else{							$dadosSandoz[$i]['porc'] = round((($dadosSandoz[$i]['emitidas'] / ($dadosSandoz[$i]['nao_emitidas'] + $dadosSandoz[$i]['emitidas'])) * 100),2);						}										}else{						$dadosSandoz[$i]['emitidas']= $phac['emitidas'];						$dadosSandoz[$i]['nao_emitidas']= $phac['nao_emitidas'];						$dadosSandoz[$i]['porc']= $phac['porc'];					}												}			$i++;					}	}		$dadosAlcon = array();		$dadosDinamicosAlcon = $this->kpi_dinamica_grafico('EMPRESA TRES',$primeiraData,$ultimaData);	$dadosConsolidadosAlcon = $this->cnd_estadual_model->listarResumoClientesEntrePeriodo('EMPRESA TRES',$primeiraData,$ultimaData);		$i=1;	foreach($dadosDinamicosAlcon as $pha){					foreach($dadosConsolidadosAlcon as $phac){				if($pha['mes_competencia'] == $phac['mes_competencia']){					$dataArr = explode("-",$phac['mes_competencia']);						$ultimoDia = cal_days_in_month(CAL_GREGORIAN, $dataArr[1], $dataArr[0]);							$ultimaData  = date($dataArr[0].'-'.$dataArr[1].'-'.$ultimoDia);										$dadosAlcon[$i]['mes_competencia'] = $phac['mes_competencia'];					$temSerpac = $this->cnd_estadual_model->verificarSerpac('EMPRESA TRES',$phac['mes_competencia'],$ultimaData);									if($temSerpac[0]['total'] == 0){						$dadosAlcon[$i]['emitidas']= $phac['emitidas'] + $pha['emitidas'] ;						$dadosAlcon[$i]['nao_emitidas']= $phac['nao_emitidas'] + $pha['nao_emitidas'];									if($dadosAlcon[$i]['emitidas'] == 0){							$dadosAlcon[$i]['porc'] = 0;						}else{							$dadosAlcon[$i]['porc'] = round((($dadosAlcon[$i]['emitidas'] / ($dadosAlcon[$i]['nao_emitidas'] + $dadosAlcon[$i]['emitidas'])) * 100),2);						}										}else{						$dadosAlcon[$i]['emitidas']= $phac['emitidas'];						$dadosAlcon[$i]['nao_emitidas']= $phac['nao_emitidas'];						$dadosAlcon[$i]['porc']= $phac['porc'];					}												}			$i++;					}	}					$data['pharma'] =$dadosPharma;	$data['sandoz'] =$dadosSandoz;	$data['alcon'] =$dadosAlcon;	$this->load->view('header_pages_view',$data);	$this->load->view('grafico', $data);	$this->load->view('footer_pages_view'); }  function kpi_dinamica_grafico($cliente,$primeiraData,$ultimaData){		if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	}	$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;		$startDate = strtotime($primeiraData);	$endDate   = strtotime($ultimaData);	$currentDate = $endDate;	$datas = array();	$dados = array();	$i=0;	while ($currentDate >= $startDate) {		$datas[$i]['inicial'] = date('Y-m-01',$currentDate);		$datas[$i]['final'] = date('Y-m-t',$currentDate);		$currentDate = strtotime( date('Y/m/01/',$currentDate).' -1 month');		$i++;	}		sort($datas);				$j=0;	//$data['pharma'] = $this->cnd_estadual_model->listarResumoClientesEntrePeriodoDinamicoEmitido('PHARMA',$primeiraData,$ultimaData);		foreach($datas as $dat){		$dados[$j]['mes_competencia'] = $dat['inicial'];		$totalEmitidasDebFiscal = $this->cnd_estadual_model->listarResumoClientesEntrePeriodoDinamicoEmitido('cnd_estadual_debito_fiscal',$cliente,$dat['inicial'],$dat['final']);				$totalEmitidasDivAtiv = $this->cnd_estadual_model->listarResumoClientesEntrePeriodoDinamicoEmitido('cnd_estadual_divida_ativa',$cliente,$dat['inicial'],$dat['final']);				$totalEmitidasAmbas = $this->cnd_estadual_model->listarResumoClientesEntrePeriodoDinamicoEmitido('cnd_estadual_ambas',$cliente,$dat['inicial'],$dat['final']);						$dados[$j]['emitidas'] = $totalEmitidasDebFiscal[0]['total'] + $totalEmitidasDivAtiv[0]['total'] + $totalEmitidasAmbas[0]['total'];								$totalNaoEmitidasDebFiscal = $this->cnd_estadual_model->listarResumoClientesEntrePeriodoDinamicoNaoEmitido('cnd_estadual_debito_fiscal',$cliente,$dat['inicial'],$dat['final']);			$totalNaoEmitidasDivAtiv = $this->cnd_estadual_model->listarResumoClientesEntrePeriodoDinamicoNaoEmitido('cnd_estadual_divida_ativa',$cliente,$dat['inicial'],$dat['final']);			$totalNaoEmitidasAmbas = $this->cnd_estadual_model->listarResumoClientesEntrePeriodoDinamicoNaoEmitido('cnd_estadual_ambas',$cliente,$dat['inicial'],$dat['final']);							$dados[$j]['nao_emitidas'] = $totalNaoEmitidasDebFiscal[0]['total'] + $totalNaoEmitidasDivAtiv[0]['total'] + $totalNaoEmitidasAmbas[0]['total'];		if($dados[$j]['emitidas'] == 0){			$dados[$j]['porc'] = 0;		}else{			$dados[$j]['porc'] = round((($dados[$j]['emitidas'] / ($dados[$j]['nao_emitidas'] + $dados[$j]['emitidas'])) * 100),2);		}		$j++;	}		return($dados); 	 }   function kpi(){		if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	}	$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$data['perfil'] = $session_data['perfil'];		$data['meses'] = $this->cnd_estadual_model->listarMesesKPI();		if(empty($_POST)){		$primeiroDia = date("Y-m".'-01');		$data['dataExibicao'] = meses(date("m")).'/'.date("Y");			}else{		$primeiroDia = $_POST['data'];		$dataArr = explode("-",$primeiroDia);				$data['dataExibicao'] = meses($dataArr[1]).'/'.$dataArr[0];	}	$data['primeiroDia'] = $primeiroDia;				$data['empresa_um'] = $this->kpi_dinamica('EMPRESA UM',$primeiroDia);	$data['empresa_dois'] = $this->kpi_dinamica('EMPRESA DOIS',$primeiroDia);	$data['empresa_tres'] = $this->kpi_dinamica('EMPRESA TRES',$primeiroDia);		$this->load->view('header_pages_view',$data);	$this->load->view('kpi', $data);	$this->load->view('footer_pages_view'); } function fechamento(){				//ultimo dia do mes			$primeiroDia  = $_GET['data'];		$primeiroDiaArr = explode("-",$primeiroDia);				$ultimoDiaEncontrado = date("t", mktime(0,0,0,$primeiroDiaArr[1] ,'01',$primeiroDiaArr[0])); 		$ultimoDia = $primeiroDiaArr[0].'-'.$primeiroDiaArr[1].'-'.$ultimoDiaEncontrado; 				$cnpjs = $this->cnd_estadual_model->listarCnpjs();			$i=0;		foreach($cnpjs as $cnpj){			$cnpjCliente = $cnpj['cnpj'];			$referencia = utf8_decode($cnpj['referencia']);			$nome = utf8_decode($cnpj['nome']);			$contratante = $cnpj['id_contratate'];									$totalEmitidaAmbas =  $this->cnd_estadual_model->listarTotalCndsFechamento('ambas',$cnpjCliente,$primeiroDia,$ultimoDia,1);			$totalEmitidaDebFiscal =  $this->cnd_estadual_model->listarTotalCndsFechamento('cnd_estadual_debito_fiscal',$cnpjCliente,$primeiroDia,$ultimoDia,1);			$totalEmitidaDivAtiv =  $this->cnd_estadual_model->listarTotalCndsFechamento('cnd_estadual_divida_ativa',$cnpjCliente,$primeiroDia,$ultimoDia,1);									$totalEmitidas =  $totalEmitidaAmbas[0]['total']  + $totalEmitidaDebFiscal[0]['total'] + $totalEmitidaDivAtiv[0]['total'];						$totalNEmitidaAmbas =  $this->cnd_estadual_model->listarTotalCndsFechamento('ambas',$cnpjCliente,$primeiroDia,$ultimoDia,2);						$totalNEmitidaDebFiscal =  $this->cnd_estadual_model->listarTotalCndsFechamento('cnd_estadual_debito_fiscal',$cnpjCliente,$primeiroDia,$ultimoDia,2);						$totalNEmitidaDivAtiv =  $this->cnd_estadual_model->listarTotalCndsFechamento('cnd_estadual_divida_ativa',$cnpjCliente,$primeiroDia,$ultimoDia,2);						$totalNEmitidas =  $totalNEmitidaAmbas[0]['total']  + $totalNEmitidaDebFiscal[0]['total'] + $totalNEmitidaDivAtiv[0]['total'];									$verifica = $this->cnd_estadual_model->verificaFechamentoMensal($nome,$cnpjCliente,$primeiroDia);						if($verifica[0]->total == 0){				$dados = array(				'cnpj' => $cnpjCliente,				'mes_competencia' => $primeiroDia,				'n_emitidas' => $totalNEmitidas,				'emitidas' => $totalEmitidas,				'nome_empresa' => $nome,				'referencia' => $referencia,				'id_contratante' => $contratante				);							$this->cnd_estadual_model->insere_serpac($dados);				$dados = array(				'data' => $primeiroDia,				);							$this->cnd_estadual_model->kpi_controle_meses($dados);									}			}	echo json_encode($primeiroDia);	exit;	}
	function kpi_dinamica($nomeCliente,$primeiroDia){		//ultimo dia do mes		$primeiroDiaArr = explode("-",$primeiroDia);			$ultimoDiaEncontrado = date("t", mktime(0,0,0,$primeiroDiaArr[1] ,'01',$primeiroDiaArr[0])); 	$ultimoDia = $primeiroDiaArr[0].'-'.$primeiroDiaArr[1].'-'.$ultimoDiaEncontrado; 		$i=0;			$cnpjs = $this->cnd_estadual_model->listarCnpjs();		foreach($cnpjs as $cnpj){		if($nomeCliente == $cnpj['nome']){						$totalEmitidas =  0;			$totalNaoEmitidas =  0;			$cnpjCliente = $cnpj['cnpj'];						$referencia = utf8_decode($cnpj['referencia']);						$nome = utf8_decode($cnpj['nome']);						$contratante = $cnpj['id_contratate'];						$dadosEmitidasConsolidadas =  $this->cnd_estadual_model->listarTotalEmitidasCliente($cnpjCliente,$primeiroDia,$nome,$contratante,1);			$eArray =  is_array($dadosEmitidasConsolidadas) ? '1' : '0';								if($dadosEmitidasConsolidadas[0]->total == 0 ){							$dadosEmitidasAmbas =  $this->cnd_estadual_model->buscarDadosKpiClientes('cnd_estadual_ambas',$cnpjCliente,$primeiroDia,$ultimoDia,1,$contratante);									$dadosEmitidasDebFiscal =  $this->cnd_estadual_model->buscarDadosKpiClientes('cnd_estadual_debito_fiscal',$cnpjCliente,$primeiroDia,$ultimoDia,1);				$dadosEmitidasDivAtiv =  $this->cnd_estadual_model->buscarDadosKpiClientes('cnd_estadual_divida_ativa',$cnpjCliente,$primeiroDia,$ultimoDia,1);					$totalEmitidas =  $dadosEmitidasAmbas[0]->total  + $dadosEmitidasDebFiscal[0]->total + $dadosEmitidasDivAtiv[0]->total;			}else{				$totalEmitidas = $dadosEmitidasConsolidadas[0]->total;			}						$dadosNaoEmitidasConsolidadas =  $this->cnd_estadual_model->listarTotalEmitidasCliente($cnpjCliente,$primeiroDia,$nome,$contratante,2);				$eArray =  is_array($dadosNaoEmitidasConsolidadas) ? '1' : '0';				if($dadosNaoEmitidasConsolidadas[0]->total == 0 ){				$dadosNaoEmitidasAmbas =  $this->cnd_estadual_model->buscarDadosKpiClientes('cnd_estadual_ambas',$cnpjCliente,$primeiroDia,$ultimoDia,2);						$dadosNaoEmitidasDebFiscal =  $this->cnd_estadual_model->buscarDadosKpiClientes('cnd_estadual_debito_fiscal',$cnpjCliente,$primeiroDia,$ultimoDia,2);				$dadosNaoEmitidasDivAtiv =  $this->cnd_estadual_model->buscarDadosKpiClientes('cnd_estadual_divida_ativa',$cnpjCliente,$primeiroDia,$ultimoDia,2);				$totalNaoEmitidas =  $dadosNaoEmitidasAmbas[0]->total  +  $dadosNaoEmitidasDebFiscal[0]->total + $dadosNaoEmitidasDivAtiv[0]->total;			}else{				$totalNaoEmitidas = $dadosNaoEmitidasConsolidadas[0]->total;			}																			$dados[$i]['cnpj']=$cnpjCliente;			$dados[$i]['mes_competencia'] =$primeiroDia;			$dados[$i]['referencia'] =$referencia;			$dados[$i]['emitidas'] =$totalEmitidas;			$dados[$i]['n_emitidas']=$totalNaoEmitidas;			$dados[$i]['nome_empresa']=$nome;			$dados[$i]['id_contratante']=$contratante;			$i++;						/*				$verificarKpiMes =  $this->cnd_estadual_model->verificarKpiMesCliente($nome,$primeiroDia);						if($verificarKpiMes[0]->total == 0){							$dados = array(					'cnpj' => $cnpjCliente,					'mes_competencia' => $primeiroDia,					'referencia' => $referencia,					'emitidas' => $totalEmitidas,					'n_emitidas' => $totalNaoEmitidas,					'nome_empresa' => $nome,					'id_contratante' => $contratante,				);								$this->cnd_estadual_model->inserirKpiMes($dados);					}			*/					}	}		return($dados);	}function cadastrar_cnd(){	if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	}	$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$id_loja = $this->input->post('id_loja');	$insc = $this->input->post('insc');	$uf_origem = $this->input->post('uf_origem');	$uf_ie = $this->input->post('uf_ie');	$municipio_ie = $this->input->post('municipio_ie');		$dados = array(		'id_loja' => $id_loja,		'id_contratante' => $idContratante,		'possui_cnd' => 3,		'inscricao' => $insc,		'uf_origem' => $uf_origem,		'uf_ie' => $uf_ie,		'municipio_origem' => $municipio_ie	);		$id_cnd = $this->cnd_estadual_model->add($dados);		$dadosCnd = array(		'id_cnd_est' => $id_cnd,		'status' => 3			);		$this->cnd_estadual_model->add_cnd_debito_fiscal($dadosCnd);	$this->cnd_estadual_model->add_cnd_divida_ativa($dadosCnd);	$this->cnd_estadual_model->add_cnd_ambas($dadosCnd);		redirect('cnd_estadual/dados_agrupados', 'refresh');	}	

function cadastrar(){ if(! $_SESSION['login_walmart']){	redirect('login', 'refresh');}	$session_data = $_SESSION['login_walmart'];	if(empty($session_data['visitante'])){		$data['visitante'] = 0;	}else{		$data['visitante'] = $session_data['visitante'];		}	$idContratante = $_SESSION['cliente'] ;	$id_loja = $this->input->get('id');	$data['emitente'] = $this->cnd_estadual_model->listarEmitenteById($id_loja);	//$data['info_inc'] = $this->informacoes_inclusas_iptu_model->listar(); 	$data['perfil'] = $session_data['perfil'];	$this->load->view('header_pages_view',$data);    $this->load->view('cadastrar_cnd_mob_view', $data);	$this->load->view('footer_pages_view'); }
 function upload_obs(){			$session_data = $_SESSION['login_walmart'];		$data['controller'] = 'cnd_estadual';	$controller = 'cnd_estadual';		$id = $this->input->post('obsId');			$id_cnd_mob = $this->input->post('id_cnd_mob');				$dados =  $this->cnd_estadual_model->listarUltimaObsTratById($id);		$file = $_FILES["userfile"]["name"];					$extensao = str_replace('.','',strrchr($file, '.'));							$base = base_url();		        	$config['upload_path'] = './assets/observacoes/';			$config['allowed_types'] = '*';			$config['overwrite'] = 'true';					$config['file_name'] = 'cnd_estadual-'.$id.'.'.$extensao;					$this->load->library('upload', $config);		$this->upload->initialize($config);			$field_name = "userfile";					if (!$this->upload->do_upload($field_name)){					$error = array('error' => $this->upload->display_errors());								$_SESSION['mensagemIptu'] =  $this->upload->display_errors();	}else{						$dados = array('arquivo' => 'cnd_estadual-'.$id.'.'.$extensao);									$this->cnd_estadual_model->atualizar_tratativa_obs($dados,$id);				$data = array('upload_data' => $this->upload->data($field_name));				$_SESSION['mensagemIptu'] =  UPLOAD;		}redirect('/'.$controller.'/visao_interna?id='.$id_cnd_mob, 'refresh');		 } 
 function enviar(){		
	$session_data = $_SESSION['login_walmart'];
		$data['controller'] = 'cnd_estadual';	
	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/cnds_mob/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = 'cnd_estadual-'.$id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";				
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{			
	
		$dadosLog = array(
		'id_contratante' => $session_data['id_contratante'],
		'tabela' => 'cnd_mob',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo CND Mobiliária',
		'data' => date("Y-m-d"),
		'upload' => 1
		);
		$this->log_model->log($dadosLog);
		
		$dados = array('arquivo_cnd' => 'cnd_estadual-'.$id.'.'.$extensao);							
		$this->cnd_estadual_model->atualizar($dados,$id);		
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}

//redirect('/iptu/listar', 'refresh');		 
} 

 
 function enviarOld(){
		
		$id = $this->input->post('id');
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnds_mob/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		$config['overwrite'] = 'true';	
		$this->load->library('upload', $config);
		
		// Alternativamente você pode configurar as preferências chamando a função initialize. É útil se você auto-carregar a classe:
		$this->upload->initialize($config);
		$field_name = "userfile";
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			
			$mensagem = $this->upload->display_errors();
			$this->session->set_flashdata('mensagem',$mensagem);

		}else{
			$dados = array('arquivo_cnd' => $id.'.'.$extensao);
				
			$this->cnd_estadual_model->atualizar($dados,$id);
			$data = array('upload_data' => $this->upload->data($field_name));
			$this->session->set_flashdata('mensagem','Upload Feito com Sucesso');	
		}		
		
			
		$dadosImovel = $this->cnd_estadual_model->listarCidadeEstadoById($id);
		$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
		$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
		$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;

		$modulo = $_SESSION["CNDMob"];
	
		redirect('/cnd_estadual/'.$modulo, 'refresh');		
 } function enviar_extrato_ambas(){			$session_data = $_SESSION['login_walmart'];		$id = $this->input->get('id');				$tipo = 3;			$file = $_FILES["userfile"]["name"];		$extensao = str_replace('.','',strrchr($file, '.'));							$base = base_url();		        	$config['upload_path'] = './assets/cnd_estadual/';					$config['allowed_types'] = '*';			$config['overwrite'] = 'true';					$config['file_name'] = 'extrato_ambas-'.$id.'.'.$extensao;					$this->load->library('upload', $config);		$this->upload->initialize($config);			$field_name = "userfile";					if (!$this->upload->do_upload($field_name)){					$error = array('error' => $this->upload->display_errors());								$_SESSION['mensagemIptu'] =  $this->upload->display_errors();		echo '0'; 	}else{				$dados = array(			'extrato_ambas' => 'extrato_ambas-'.$id.'.'.$extensao		);				$dadosLog = array(					'id_contratante' => $session_data['id_contratante'],					'tabela' => 'cnd_mob',					'id_usuario' => $session_data['id'],					'id_operacao' => $id,					'tipo' => 3,					'texto' => 'Upload de Arquivo Extrato - Dívida Ativa - PDF',					'data' => date("Y-m-d"),					'upload' => 1					);		$this->log_model->log($dadosLog);		$this->cnd_estadual_model->atualizar_tipo_cnd($dados,$id,$tipo);				$data = array('upload_data' => $this->upload->data($field_name));				$_SESSION['mensagemIptu'] =  UPLOAD;		echo'1';	}//redirect('/iptu/listar', 'refresh');		 } 
function enviar_extrato_divida_ativa(){			$session_data = $_SESSION['login_walmart'];		$id = $this->input->get('id');				$tipo = 2;			$file = $_FILES["userfile"]["name"];		$extensao = str_replace('.','',strrchr($file, '.'));							$base = base_url();		        	$config['upload_path'] = './assets/cnd_estadual/';					$config['allowed_types'] = '*';			$config['overwrite'] = 'true';					$config['file_name'] = 'extrato_divida_ativa-'.$id.'.'.$extensao;					$this->load->library('upload', $config);		$this->upload->initialize($config);			$field_name = "userfile";					if (!$this->upload->do_upload($field_name)){					$error = array('error' => $this->upload->display_errors());								$_SESSION['mensagemIptu'] =  $this->upload->display_errors();		echo '0'; 	}else{				$dados = array(			'extrado_divida_ativa' => 'extrato_divida_ativa-'.$id.'.'.$extensao		);				$dadosLog = array(					'id_contratante' => $session_data['id_contratante'],					'tabela' => 'cnd_mob',					'id_usuario' => $session_data['id'],					'id_operacao' => $id,					'tipo' => 2,					'texto' => 'Upload de Arquivo Extrato - Dívida Ativa - PDF',					'data' => date("Y-m-d"),					'upload' => 1					);		$this->log_model->log($dadosLog);		$this->cnd_estadual_model->atualizar_tipo_cnd($dados,$id,$tipo);				$data = array('upload_data' => $this->upload->data($field_name));				$_SESSION['mensagemIptu'] =  UPLOAD;		echo'1';	}//redirect('/iptu/listar', 'refresh');		 } function enviar_ambas(){			$session_data = $_SESSION['login_walmart'];		$id = $this->input->get('id');				$tipo = 3;			$file = $_FILES["userfile"]["name"];		$extensao = str_replace('.','',strrchr($file, '.'));							$base = base_url();		        	$config['upload_path'] = './assets/cnd_estadual/';					$config['allowed_types'] = '*';			$config['overwrite'] = 'true';					$config['file_name'] = 'cnd_estadual_ambas-'.$id.'.'.$extensao;					$this->load->library('upload', $config);		$this->upload->initialize($config);			$field_name = "userfile";					if (!$this->upload->do_upload($field_name)){					$error = array('error' => $this->upload->display_errors());								$_SESSION['mensagemIptu'] =  $this->upload->display_errors();		echo '0'; 	}else{				$dados = array(			'arq_cnd_ambas' => 'cnd_estadual_ambas-'.$id.'.'.$extensao		);				$dadosLog = array(					'id_contratante' => $session_data['id_contratante'],					'tabela' => 'cnd_mob',					'id_usuario' => $session_data['id'],					'id_operacao' => $id,					'tipo' => 3,					'texto' => 'Upload de Arquivo CND Estadual - Ambas - PDF',					'data' => date("Y-m-d"),					'upload' => 1					);		$this->log_model->log($dadosLog);		$this->cnd_estadual_model->atualizar_tipo_cnd($dados,$id,$tipo);				$data = array('upload_data' => $this->upload->data($field_name));				$_SESSION['mensagemIptu'] =  UPLOAD;		echo'1';	}//redirect('/iptu/listar', 'refresh');		 } function enviar_divida_ativa(){			$session_data = $_SESSION['login_walmart'];		$id = $this->input->get('id');				$tipo = 2;			$file = $_FILES["userfile"]["name"];		$extensao = str_replace('.','',strrchr($file, '.'));							$base = base_url();		        	$config['upload_path'] = './assets/cnd_estadual/';					$config['allowed_types'] = '*';			$config['overwrite'] = 'true';					$config['file_name'] = 'cnd_estadual_divida_ativa-'.$id.'.'.$extensao;					$this->load->library('upload', $config);		$this->upload->initialize($config);			$field_name = "userfile";					if (!$this->upload->do_upload($field_name)){					$error = array('error' => $this->upload->display_errors());								$_SESSION['mensagemIptu'] =  $this->upload->display_errors();		echo '0'; 	}else{				$dados = array(			'arq_cnd_divida_ativa' => 'cnd_estadual_divida_ativa-'.$id.'.'.$extensao		);				$dadosLog = array(					'id_contratante' => $session_data['id_contratante'],					'tabela' => 'cnd_mob',					'id_usuario' => $session_data['id'],					'id_operacao' => $id,					'tipo' => 2,					'texto' => 'Upload de Arquivo CND Estadual - Dívida Ativa - PDF',					'data' => date("Y-m-d"),					'upload' => 1					);		$this->log_model->log($dadosLog);		$this->cnd_estadual_model->atualizar_tipo_cnd($dados,$id,$tipo);				$data = array('upload_data' => $this->upload->data($field_name));				$_SESSION['mensagemIptu'] =  UPLOAD;		echo'1';	}//redirect('/iptu/listar', 'refresh');		 } function enviar_debito_fiscal(){			$session_data = $_SESSION['login_walmart'];		$id = $this->input->get('id');				$tipo = 1;			$file = $_FILES["userfile"]["name"];		$extensao = str_replace('.','',strrchr($file, '.'));							$base = base_url();		        	$config['upload_path'] = './assets/cnd_estadual/';					$config['allowed_types'] = '*';			$config['overwrite'] = 'true';					$config['file_name'] = 'cnd_estadual_debito_fiscal-'.$id.'.'.$extensao;					$this->load->library('upload', $config);		$this->upload->initialize($config);			$field_name = "userfile";					if (!$this->upload->do_upload($field_name)){					$error = array('error' => $this->upload->display_errors());								$_SESSION['mensagemIptu'] =  $this->upload->display_errors();		echo '0'; 	}else{				$dados = array(			'arq_cnd_debito_fiscal' => 'cnd_estadual_debito_fiscal-'.$id.'.'.$extensao		);				$dadosLog = array(					'id_contratante' => $session_data['id_contratante'],					'tabela' => 'cnd_mob',					'id_usuario' => $session_data['id'],					'id_operacao' => $id,					'tipo' => 2,					'texto' => 'Upload de Arquivo CND Estadual - Débito Fiscal - Pendência PDF',					'data' => date("Y-m-d"),					'upload' => 1					);		$this->log_model->log($dadosLog);		$this->cnd_estadual_model->atualizar_tipo_cnd($dados,$id,$tipo);				$data = array('upload_data' => $this->upload->data($field_name));				$_SESSION['mensagemIptu'] =  UPLOAD;		echo'1';	}//redirect('/iptu/listar', 'refresh');		 } function enviar_extrato_debito_fiscal(){			$session_data = $_SESSION['login_walmart'];		$id = $this->input->get('id');				$tipo = 1;			$file = $_FILES["userfile"]["name"];		$extensao = str_replace('.','',strrchr($file, '.'));							$base = base_url();		        	$config['upload_path'] = './assets/cnd_estadual/';					$config['allowed_types'] = '*';			$config['overwrite'] = 'true';					$config['file_name'] = 'extrato_debito_fiscal-'.$id.'.'.$extensao;					$this->load->library('upload', $config);		$this->upload->initialize($config);			$field_name = "userfile";					if (!$this->upload->do_upload($field_name)){					$error = array('error' => $this->upload->display_errors());								$_SESSION['mensagemIptu'] =  $this->upload->display_errors();		echo '0'; 	}else{				$dados = array(			'extrato_debito_fiscal' => 'extrato_debito_fiscal-'.$id.'.'.$extensao		);				$dadosLog = array(					'id_contratante' => $session_data['id_contratante'],					'tabela' => 'cnd_mob',					'id_usuario' => $session_data['id'],					'id_operacao' => $id,					'tipo' => 2,					'texto' => 'Upload de Arquivo Extrato - Débito Fiscal - Pendência PDF',					'data' => date("Y-m-d"),					'upload' => 1					);		$this->log_model->log($dadosLog);		$this->cnd_estadual_model->atualizar_tipo_cnd($dados,$id,$tipo);				$data = array('upload_data' => $this->upload->data($field_name));				$_SESSION['mensagemIptu'] =  UPLOAD;		echo'1';	}//redirect('/iptu/listar', 'refresh');		 } 
 function enviar_pend(){		
	$session_data = $_SESSION['login_walmart'];
	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/cnd_pend/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = 'cnd_estadual-'.$id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";				
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{		
	
		$dadosLog = array(
		'id_contratante' => $session_data['id_contratante'],
		'tabela' => 'cnd_mob',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo CND Mobiliária - Pendência',
		'data' => date("Y-m-d"),
		'upload' => 1
		);
		$this->log_model->log($dadosLog);
	
		
		$dados = array(
			'arquivo_pendencias' => 'cnd_estadual-'.$id.'.'.$extensao
			);	
			
		$this->cnd_estadual_model->atualizar($dados,$id);		
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}

//redirect('/iptu/listar', 'refresh');		 
} 

 function enviar_pend_old(){
		
		$id = $this->input->post('id');
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnd_pend/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		$config['overwrite'] = 'true';	
		$this->load->library('upload', $config);

		// Alternativamente você pode configurar as preferências chamando a função initialize. É útil se você auto-carregar a classe:
		$this->upload->initialize($config);
		$field_name = "userfile";
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			$mensagem = $this->upload->display_errors();
			$this->session->set_flashdata('mensagem',$mensagem);
			
		}else{
			$data = date('Y-m-d');
			$dados = array(
			'arquivo_pendencias' => $id.'.'.$extensao
			);
			
				
			$this->cnd_estadual_model->atualizar($dados,$id);
			//print_r($this->db->last_query());exit;
			$data = array('upload_data' => $this->upload->data($field_name));
			$mensagem = 'Upload Feito com Sucesso';
			
			
			
		}
		
		$dadosImovel = $this->cnd_estadual_model->listarCidadeEstadoById($id);
		$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
		$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
		$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;

		$modulo = $_SESSION["CNDMob"];
		
		//print_r($this->db->last_query());exit;
		$_SESSION['msgCNDMob'] =  $mensagem;
		
		redirect('/cnd_mob/editar?id='.$id);
		

		
 }
 function upload_cnd(){
	
	
  $session_data = $_SESSION['login_walmart'];	
 
  if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $data['dataEmissao'] = $this->cnd_estadual_model->listarTodasDataEmissao($id,'mob');		

  $dados = $this->cnd_estadual_model->listarInscricaoById($id);
	$data['imovel'] = $dados;
	if($dados[0]->possui_cnd == 1){
		$data['modulo'] = 'listarPorTipoSim';
	}else if($dados[0]->possui_cnd == 2){
		$data['modulo'] = 'listarPorTipoNao';
	}else{
		$data['modulo'] = 'listarPorTipoPendencia';
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('upload_cnd_mob', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
  function upload_pend(){
	
	
  $session_data = $_SESSION['login_walmart'];	
 
  if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  
  $dados = $this->cnd_estadual_model->listarInscricaoById($id);
  $data['imovel'] = $dados;
	if($dados[0]->possui_cnd == 1){
		$data['modulo'] = 'listarPorTipoSim';
	}else if($dados[0]->possui_cnd == 2){
		$data['modulo'] = 'listarPorTipoNao';
	}else{
		$data['modulo'] = 'listarPorTipoPendencia';
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('upload_pendencia', $data);

  $this->load->view('footer_pages_view');
				
 
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

  $this->load->view('ver-cnd-mob', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
 

 function cadastrar_cnd_mob(){
 
   if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }


	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	//$inscricao = $this->input->post('inscricao');	
	
	$id_loja = $this->input->post('id_loja');	
	if(empty($id_loja )){
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

		$_SESSION["CNDMob"] = 'listarPorTipoSim';
		$dados = array(
			'id_loja' => $id_loja,
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 1,
			'ativo' => 1,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		
		$data_emissao = $this->input->post('data_emissao');
	
		if(!empty($data_emissao )){
			$arrDataEmissao = explode("/",$data_emissao);
			$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		}else{
			$dataEmissao ='0000-00-00';
		}
		
		
	}elseif($possui_cnd == 2){
		$_SESSION["CNDMob"] = 'listarPorTipoNao';
		$dados = array(
			'id_loja' => $id_loja,
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 2,
			'ativo' => 1,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
			
		);
		
	}else{
		$_SESSION["CNDMob"] = 'listarPorTipoPendencia';
		$dados = array(
			'id_loja' => $id_loja,
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 3,
			'ativo' => 1,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		
	}

	
	$id = $this->cnd_estadual_model->add($dados);
	
	if($id) {
		$this->db->cache_off();
		$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'mob',
			'data_emissao' =>$dataEmissao,
			);
			
		$this->cnd_estadual_model->addDataEmissao($dadosDataEmissao,$id,'mob');
		$_SESSION['msgCNDMob'] =  CADASTRO_FEITO;
		$this->session->set_flashdata('mensagem','Cadastro Realizado com sucesso');
		$url = 'cnd_mob/editar?id='.$id;
	}else{
		$_SESSION['msgCNDMob'] =  ERRO;	
	}


	redirect($url, 'refresh');
				


 }

  function excluir(){
	if(! $_SESSION['login_walmart']){
			redirect('login', 'refresh');
	  }

  
	$id = $this->input->get('id');

	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;


	$dados = array('ativo' => 0);

	if($this->iptu_model->atualizar($dados,$id)) {
		$_SESSION['mensagemCNDMOB'] =  CADASTRO_INATIVO;	
	}else{	
		$_SESSION['mensagemCNDMOB'] =  ERRO;
	}
	redirect('/cnd_mob/listar', 'refresh');
				

 }
 

 function inativar(){	if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	} 	$id = $this->input->get('id');	$session_data = $_SESSION['login_walmart'];	$podeExcluir = $this->user->perfil_excluir($session_data['id']);	$dadosImovel = $this->cnd_estadual_model->listarCidadeEstadoById($id);	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;	if($podeExcluir[0]['total'] == 1){				$this->cnd_estadual_model->excluirFisicamente($id);		$_SESSION['mensagemImovel'] =  CADASTRO_APAGADO;			}else{			$dados = array('ativo' => 1);		if($this->cnd_estadual_model->atualizar($dados,$id)) {			$_SESSION['mensagemCNDMOB'] =  CADASTRO_INATIVO;			}else{				$_SESSION['mensagemCNDMOB'] =  ERRO;			}	}	$modulo = $_SESSION["CNDMob"];	redirect('/cnd_estadual/'.$modulo, 'refresh'); }
 function apagar_todos_status(){	$idCnd = $this->input->get('id');			$dados = array(				'observacoes_cnd' =>'',			'observacoes_extrato' =>'',			'data_emissao_debito_fiscal' => '0000-00-00',			'data_vencto_debito_fiscal' => 	'0000-00-00',				'status' => 	3,			);		$this->cnd_estadual_model->atualizar_tipo_cnd($dados,$idCnd,1);		$dados = array(				'observacoes_cnd' =>'',			'observacoes_extrato' =>'',			'data_emissao_divida_ativa' => '0000-00-00',			'data_vencto_divida_ativa' => 	'0000-00-00',				'status' =>3,			);	$this->cnd_estadual_model->atualizar_tipo_cnd($dados,$idCnd,2);		$dados = array(				'observacoes_cnd' =>'',			'observacoes_extrato' =>'',			'data_emissao_ambas' => '0000-00-00',			'data_vencto_ambas' => 	'0000-00-00',				'status' => 	3,			);	$this->cnd_estadual_model->atualizar_tipo_cnd($dados,$idCnd,3);				redirect('/cnd_estadual/listarTodos', 'refresh'); } 
 function ativar(){
	if(! $_SESSION['login_walmart']){
			redirect('login', 'refresh');
	  }  
	$id = $this->input->get('id');

	$dados = array('ativo' => 0);

	if($this->cnd_estadual_model->atualizar($dados,$id)) {
		$_SESSION['mensagemCNDMOB'] =  CADASTRO_ATIVO;	
	}else{	
		$_SESSION['mensagemCNDMOB'] = ERRO;
	}
	
	$dadosImovel = $this->cnd_estadual_model->listarCidadeEstadoById($id);
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
	
	$modulo = $_SESSION["CNDMob"];
	
	redirect('/cnd_estadual/'.$modulo, 'refresh');

 }
 
 function enviar_email(){	 $session_data = $_SESSION['login_walmart'];	 $empresa = $session_data['empresa'];	 $this->load->library('email');	 $this->email->from('domicilios@bdwebgestora.com.br', 'BD WEB Gestora');	 	 $id_cnd = $this->input->post('id-cnd-mob');	$cnpj_email = $this->input->post('cnpj_email');	$inscricao_email = $this->input->post('inscricao_email');	$uf_ie_email = $this->input->post('uf_ie_email');		$emails = $this->input->post('email');	$contaEmails = count($emails);		$i=1;	$stringEmails = '';	foreach($emails as $email){						$dados = $this->user->buscaEmailById($email);		if($i==$contaEmails){			$stringEmails .= $dados[0]->email;		}else{			$stringEmails .= $dados[0]->email.',';			}		$i++;	}		$list = array($stringEmails);	$this->email->to($list);	$this->email->subject('Pendência de CND – '.$cnpj_email.' – '.$inscricao_email.' – '.$uf_ie_email);		$texto = '	Prezado,	<BR><BR> 	Existem pendências na CND correspondente aos dados informados no assunto deste e-mail.	<BR> <BR> 	Peço a gentileza de acessar o sistema BD WEB Gestora para a devida verificação e tratativas necessárias.	 <BR> <BR> 	Atenciosamente,	 <BR>	Sistema BD WEB Gestora	';	$html = "    <html>    <body>        ".$texto."    </body>    </html>	";		$this->email->set_mailtype("html");	$this->email->set_alt_message($texto);	$this->email->message($html);	$this->email->send();				redirect('/cnd_estadual/visao_interna?id='.$id_cnd);		    }
 function atualizar_cnd(){
	if(! $_SESSION['login_walmart']){
			redirect('login', 'refresh');
	  }
	  
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	$perfilUsuarioLocal = $session_data['local'];
	$idUsuario = $session_data['id'];
	$id = $this->input->post('id');
	$id_emitente = $this->input->post('id_emitente');
	$inscricao = $this->input->post('inscricao');
	$possui_cnd = $this->input->post('possui_cnd');
	$data_vencto = $this->input->post('data_vencto');	
	$arrDataVencto = explode("/",$data_vencto);	
	$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');			$respInt = $this->input->post('resp_int');			$respExt = $this->input->post('resp_ext');			$observacao_tratativa = $this->input->post('observacao_tratativa');		
	$modulo = $_SESSION["CNDMob"];		
	if($possui_cnd == 1){
		$dados = array(
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 1,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt
		);
		$_SESSION["CNDMob"] = 'listarPorTipoSim';
		
		$data_emissao = $this->input->post('data_emissao');	
		if(empty($data_emissao)){
			$this->session->set_flashdata('mensagem','Data de Emiss&atilde;o n&atilde;o pode ser vazia');
			redirect('/cnd_estadual/'.$modulo);	
			exit;
		}
		$arrDataEmissao = explode("/",$data_emissao);	
		$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		
		$dadosDataDb = $this->cnd_estadual_model->listarDataEmissao($id,'mob');
		
		$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'mob',
			'data_emissao' =>$dataEmissao,
			);
        $isArray =  is_array($dadosDataDb) ? '1' : '0';
		if($isArray == 1){
		
			if($dadosDataDb[0]->data_emissao <> $dataEmissao ){
				$this->cnd_estadual_model->addDataEmissao($dadosDataEmissao);
			}
			
			
		}else{
			$this->cnd_estadual_model->addDataEmissao($dadosDataEmissao);
		}
		
		
	}elseif($possui_cnd == 2){
		$dados = array(
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 2,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt
		);
		$_SESSION["CNDMob"] = 'listarPorTipoNao';
	}else{
		$dados = array(
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 3,
			'ativo' => 0,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt
		);
		$_SESSION["CNDMob"] = 'listarPorTipoPendencia';
	
	}		if(!empty($observacao_tratativa)){		$dadosObs = array(			'id_cnd_mob'=>$id,			'data'=>date("Y-m-d"),			'hora'=>date("h:i:s"),			'id_usuario'=>$session_data['id'],			'observacao'=>$observacao_tratativa,			'modulo'=>1			);				$this->cnd_estadual_model->addObs($dadosObs);		}		
	$dadosImovel = $this->cnd_estadual_model->listarCidadeEstadoById($id);
	
	
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
	
	
	
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
		'tabela' => 'cnd_mob',
		'id_usuario' => $idUsuario,
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => $dadosAlterados,
		'data' => date("Y-m-d"),
		);
		$this->log_model->log($dadosLog);
	}
	
	
	
	
		if($perfilUsuarioLocal == 1){		if($this->cnd_estadual_model->atualizar($dados,$id)){					$this->cnd_estadual_model->atualizar_loja($inscricao,$id_emitente);		}	}
		
	//print_r($this->db->last_query());exit;
	$_SESSION['msgCNDMob'] =  CADASTRO_ATUALIZADO;
	
	redirect('/cnd_estadual/visao_interna?id='.$id);

 } function listaObsTrat(){	$base = $this->config->base_url().'index.php';	$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$id = $this->input->get('id');	$controller = 'cnd_estadual';	$data ='';	$dados =  $this->cnd_estadual_model->listarObsTratById($id);		$base = $this->config->base_url();		$isArrayLog =  is_array($dados) ? '1' : '0';	if($isArrayLog == 1) {		foreach($dados as $dado){						if(!empty($dado->arquivo)){				$arquivo = "<a href=".$base."assets/observacoes/".$dado->arquivo." target='_blank'>  <i class='fa fa-eye' aria-hidden='true'></i></a>";								$data .= "<span>".$dado->data.' - '.$dado->hora.' - '.$dado->email.' - '.$dado->observacao.' - '.$arquivo."	</span> <BR>";			}else{				$data .= "<span>".$dado->data.' - '.$dado->hora.' - '.$dado->email.' - '.$dado->observacao."	</span> <BR>";				}					}	}else{		$data .= "0";	}				echo json_encode($data);	 }	   function listaObsTratCheck(){	 $base = $this->config->base_url().'index.php';	$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$id = $this->input->get('id');	$controller = 'cnd_estadual';	$data ='';	$dados =  $this->cnd_estadual_model->listarObsTratById($id);		$isArrayLog =  is_array($dados) ? '1' : '0';	if($isArrayLog == 1) {		foreach($dados as $dado){			$data .= "<span> <input type='radio' name='obsId' value='$dado->id'>".$dado->data.' - '.$dado->hora.' - '.$dado->email.' - '.$dado->observacao."	</span> <BR>";		}	}else{		$data .= "<span></span>";	}				echo json_encode($data);	 }	   function calcularDias(){	$dtAtendi = $this->input->get('dtAtendi');	$dataEnvio = $this->input->get('dataEnvio');		$dtAtendiArr = explode("/",$dtAtendi);			$dataEncerrArr = explode("/",$dataEnvio);				$dtAtend = $dtAtendiArr[2].'-'.$dtAtendiArr[1].'-'.$dtAtendiArr[0];	$dtEnvio = $dataEncerrArr[2].'-'.$dataEncerrArr[1].'-'.$dataEncerrArr[0];		$obj = array();	if($dtEnvio > $dtAtend){		$obj['status']=1;		$obj['dias']=0;	}else{		$obj['status']=0;		$result = $this->notificacao_model->calcularDias($dtAtend,$dtEnvio);		$obj['dias']=$result[0]->dias;			}		echo json_encode($obj);		}  function calcularEscalonamento(){	$dtEnvio = $this->input->get('dtEnvio');		$dataEnvioArr = explode("/",$dtEnvio);				$dtEnvio = $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0];			$data['data1'] =  date('d/m/Y', strtotime("+5 days",strtotime($dtEnvio))); 	$data['data2'] =  date('d/m/Y', strtotime("+10 days",strtotime($dtEnvio))); 	$data['data3'] =  date('d/m/Y', strtotime("+15 days",strtotime($dtEnvio))); 	echo json_encode($data);		}
function listarTratativaById(){	$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$id = $this->input->get('id');		$data = array();	$dados =  $this->cnd_estadual_model->listarTratativaById($idContratante,$id);		$data['id'] = $dados[0]->id;	$data['tipo_tratativa'] = $dados[0]->tipo_tratativa;	$data['pendencia'] = $dados[0]->pendencia;	$data['esfera'] = $dados[0]->esfera;	$data['etapa'] = $dados[0]->etapa;	$data['data_informe_pendencia'] = $dados[0]->data_informe_pendencia;	$data['id_sis_ext'] = $dados[0]->id_sis_ext;	$data['data_inclusao_sis_ext'] = $dados[0]->data_inclusao_sis_ext;	$data['prazo_solucao_sis_ext'] = $dados[0]->prazo_solucao_sis_ext;	$data['data_encerramento_sis_ext'] = $dados[0]->data_encerramento_sis_ext;	$data['status_chamado_sis_ext'] = $dados[0]->status_chamado_sis_ext;	$data['id_sla_sis_ext'] = $dados[0]->sla_sis_ext;	$data['usu_inc'] = $dados[0]->usu_inc;	$data['area_focal'] = $dados[0]->area_focal;	$data['sub_area_focal'] = $dados[0]->sub_area_focal;	$data['contato'] = $dados[0]->contato;	$data['data_envio'] = $dados[0]->data_envio;	$data['prazo_solucao'] = $dados[0]->prazo_solucao;	$data['data_retorno'] = $dados[0]->data_retorno;	$data['sla'] = $dados[0]->sla;	$data['status_demanda'] = $dados[0]->status_demanda;	$data['esc_data_prazo_um'] = $dados[0]->esc_data_prazo_um;	$data['esc_data_retorno_um'] = $dados[0]->esc_data_retorno_um;	$data['esc_status_um'] = $dados[0]->esc_status_um;	$data['esc_data_prazo_dois'] = $dados[0]->esc_data_prazo_dois;	$data['esc_data_retorno_dois'] = $dados[0]->esc_data_retorno_dois;	$data['esc_status_dois'] = $dados[0]->esc_status_dois;	$data['esc_data_prazo_tres'] = $dados[0]->esc_data_prazo_tres;	$data['esc_data_retorno_tres'] = $dados[0]->esc_data_retorno_tres;	$data['esc_status_tres'] = $dados[0]->esc_status_tres;	echo json_encode($data);	}	function visao_externa(){	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');  }   $session_data = $_SESSION['login_walmart'];	$id = $this->input->get('id');	$idContratante = $_SESSION['cliente'] ;	if(empty($_SESSION['idTratativa'])){		$idTratativa = 0;	}else{		$idTratativa = $_SESSION['idTratativa'];	}		$data['idTratativa'] = $idTratativa;	  $data['respInterno']  = $this->cnd_estadual_model->listaResponsaveis($idContratante,1);// 1 para internos  $data['respExterno']  = $this->cnd_estadual_model->listaResponsaveis($idContratante,2);// 2 para externos    $data['obs'] = $this->cnd_estadual_model->buscaTodasObservacoes($id,1);		  $dados = $this->cnd_estadual_model->listarInscricaoByLoja($id);  $data['imovel'] = $dados;    $data['tratativas'] =  $this->cnd_estadual_model->listarTodasTratativas($idContratante,$id,1);	if($dados[0]->possui_cnd == 1){		$data['modulo'] = 'listarPorTipoSim';	}else if($dados[0]->possui_cnd == 2){		$data['modulo'] = 'listarPorTipoNao';	}else{		$data['modulo'] = 'listarPorTipoPendencia';	}		if(empty($session_data['visitante'])){		$data['visitante'] = 0;	}else{		$data['visitante'] = $session_data['visitante'];		}	$data['local'] = $session_data['local'];		$data['id_cnd'] = $id;	$data['esferas'] = $this->cnd_estadual_model->listarEsfera();	$data['etapas'] = $this->cnd_estadual_model->listarEtapa();	$data['statusInterno'] = $this->cnd_estadual_model->listarStatusInterno();	$data['statusDemanda'] = $this->cnd_estadual_model->listarStatusDemanda();	$data['perfil'] = $session_data['perfil'];		$data['nome_modulo'] = 'Cnd Estadual';		$data['controller'] = 'cnd_estadual';	$this->load->view('header_pages_view',$data);    $this->load->view('cnd_mob_visao_externa_view', $data);	$this->load->view('footer_pages_view');	}function atualizar_cnd_mob_tratativa(){		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$idUsu = $session_data['id'];	$acao 	= $this->input->post('acao');			$data_entrada_cadin 	= $this->input->post('data_entrada_cadin');		if(empty($data_entrada_cadin)){		$dtCadin = '0000-00-00';		}else{		$dtCadinArr = explode("/",$data_entrada_cadin);			$dtCadin = $dtCadinArr[2].'-'.$dtCadinArr[1].'-'.$dtCadinArr[0];	}	$id_cnd 	= $this->input->post('id');	$tipo_tratativa 	= $this->input->post('tipo_tratativa');	if(empty($tipo_tratativa)){		$tipo_tratativa = $this->input->post('tipo_tratativa_bd');	}			$id_tratativa 	= $this->input->post('id_tratativa');	$id_pendencia 	= $this->input->post('id_pendencia');	$id_esfera 	= $this->input->post('id_esfera');	$id_etapa 	= $this->input->post('id_etapa');	$data_informe_pendencia 	= $this->input->post('data_informe_pendencia');	$id_sis_ext 	= $this->input->post('id_sis_ext');	$data_inclusao_sis_ext 	= $this->input->post('data_inclusao_sis_ext');	$prazo_solucao_sis_ext 	= $this->input->post('prazo_solucao_sis_ext');	$data_encerramento_sis_ext 	= $this->input->post('data_encerramento_sis_ext');	$status_chamado_sis_ext 	= $this->input->post('status_chamado_sis_ext');	$id_sla = $this->input->post('id_sla');	$usu_inc 	= $this->input->post('usu_inc');	$area_focal 	= $this->input->post('area_focal');	$sub_area_focal 	= $this->input->post('sub_area_focal');	$contato 	= $this->input->post('contato');	$data_envio 	= $this->input->post('data_envio');	$prazo_solucao 	= $this->input->post('prazo_solucao');	$data_retorno 	= $this->input->post('data_retorno');	$sla 	= $this->input->post('sla');	$status_demanda 	= $this->input->post('status_demanda');	$esc_data_prazo_um 	= $this->input->post('esc_data_prazo_um');	$esc_data_retorno_um 	= $this->input->post('esc_data_retorno_um');	$esc_status_um 	= $this->input->post('esc_status_um');	$esc_data_prazo_dois 	= $this->input->post('esc_data_prazo_dois');	$esc_data_retorno_dois 	= $this->input->post('esc_data_retorno_dois');	$esc_status_dois 	= $this->input->post('esc_status_dois');	$esc_data_prazo_tres 	= $this->input->post('esc_data_prazo_tres');	$esc_data_retorno_tres 	= $this->input->post('esc_data_retorno_tres');	$esc_status_tres 	= $this->input->post('esc_status_tres');	$nova_tratativa 	= $this->input->post('nova_tratativa');		if(empty($data_informe_pendencia)){		$dtInforme = '0000-00-00';		}else{		$dataInformeArr = explode("/",$data_informe_pendencia);			$dtInforme = $dataInformeArr[2].'-'.$dataInformeArr[1].'-'.$dataInformeArr[0];	}		if(empty($data_inclusao_sis_ext)){		$dtInclusaoSisExt = '0000-00-00';		}else{		$dataInformeArr = explode("/",$data_inclusao_sis_ext);			$dtInclusaoSisExt = $dataInformeArr[2].'-'.$dataInformeArr[1].'-'.$dataInformeArr[0];	}		if(empty($prazo_solucao_sis_ext)){		$dtSolSisExt = '0000-00-00';		}else{		$dataSolArr = explode("/",$prazo_solucao_sis_ext);			$dtSolSisExt = $dataSolArr[2].'-'.$dataSolArr[1].'-'.$dataSolArr[0];	}		if(empty($data_encerramento_sis_ext)){		$dtEncerSisExt = '0000-00-00';		}else{		$dataEncerramentoSisExtArr = explode("/",$data_encerramento_sis_ext);		$dtEncerSisExt = $dataEncerramentoSisExtArr[2].'-'.$dataEncerramentoSisExtArr[1].'-'.$dataEncerramentoSisExtArr[0];	}		if(empty($prazo_solucao)){		$dtPrazoSolucao = '0000-00-00';		}else{		$dtPrazoSolucaoArr = explode("/",$prazo_solucao);		$dtPrazoSolucao = $dtPrazoSolucaoArr[2].'-'.$dtPrazoSolucaoArr[1].'-'.$dtPrazoSolucaoArr[0];	}		if(empty($data_envio)){		$dtEnvio = '0000-00-00';		}else{		$dataEnvioArr = explode("/",$data_envio);		$dtEnvio = $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0];	}		if(empty($data_retorno)){		$dtRetorno = '0000-00-00';		}else{		$dataRetornoArr = explode("/",$data_retorno);		$dtRetorno = $dataRetornoArr[2].'-'.$dataRetornoArr[1].'-'.$dataRetornoArr[0];	}		if(empty($esc_data_prazo_um)){		$escDtPrazoUm = '0000-00-00';		}else{		$escDataPrazoUmArr = explode("/",$esc_data_prazo_um);		$escDtPrazoUm = $escDataPrazoUmArr[2].'-'.$escDataPrazoUmArr[1].'-'.$escDataPrazoUmArr[0];	}		if(empty($esc_data_retorno_um)){		$escDtRetUm = '0000-00-00';		}else{		$escDataPrazoUmArr = explode("/",$esc_data_retorno_um);		$escDtRetUm = $escDataPrazoUmArr[2].'-'.$escDataPrazoUmArr[1].'-'.$escDataPrazoUmArr[0];	}		if(empty($esc_data_prazo_dois)){		$escDtPrazoDois = '0000-00-00';		}else{		$escDataPrazoDoisArr = explode("/",$esc_data_prazo_dois);		$escDtPrazoDois = $escDataPrazoDoisArr[2].'-'.$escDataPrazoDoisArr[1].'-'.$escDataPrazoDoisArr[0];	}		if(empty($esc_data_retorno_dois)){		$escDtRetDois = '0000-00-00';		}else{		$escDataRetornoDoisArr = explode("/",$esc_data_retorno_dois);		$escDtRetDois = $escDataRetornoDoisArr[2].'-'.$escDataRetornoDoisArr[1].'-'.$escDataRetornoDoisArr[0];	}		if(empty($esc_data_prazo_tres)){		$escDtPrazoTres = '0000-00-00';		}else{		$escDataPrazoTresArr = explode("/",$esc_data_prazo_tres);		$escDtPrazoTres = $escDataPrazoTresArr[2].'-'.$escDataPrazoTresArr[1].'-'.$escDataPrazoTresArr[0];	}		if(empty($esc_data_retorno_tres)){		$escDtRetTres = '0000-00-00';		}else{		$escDataRetornoDoisArr = explode("/",$esc_data_retorno_tres);		$escDtRetTres = $escDataRetornoDoisArr[2].'-'.$escDataRetornoDoisArr[1].'-'.$escDataRetornoDoisArr[0];	}		$dados = array(		'id_contratante' => $idContratante,		'tipo_tratativa' => $tipo_tratativa,		'id_sis_ext' => $id_sis_ext,		'id_cnd_mob' => $id_cnd,		'pendencia' => $id_pendencia,		'esfera' => $id_esfera,		'etapa' => $id_etapa,		'data_informe_pendencia' => $dtInforme ,		'data_inclusao_sis_ext' => $dtInclusaoSisExt,		'prazo_solucao_sis_ext' => $dtSolSisExt ,		'data_encerramento_sis_ext' => $dtEncerSisExt,		'sla_sis_ext' => $id_sla,		'status_chamado_sis_ext' => $status_chamado_sis_ext , 		'usu_inc' => $usu_inc,		'area_focal' => $area_focal,		'sub_area_focal' => $sub_area_focal,		'contato' => $contato ,		'data_envio' =>$dtEnvio,		'prazo_solucao' => $dtPrazoSolucao,		'data_retorno' =>$dtRetorno,		'sla' => $sla,		'status_demanda' => $status_demanda,		'esc_data_prazo_um' =>$escDtPrazoUm,		'esc_data_retorno_um' =>$escDtRetUm,		'esc_status_um' => $esc_status_um,		'esc_data_prazo_dois' =>$escDtPrazoDois,		'esc_data_retorno_dois' =>$escDtRetDois,		'esc_status_dois' => $esc_status_dois ,		'esc_data_prazo_tres' =>$escDtPrazoTres,		'esc_data_retorno_tres' =>$escDtRetTres ,		'esc_status_tres' => $esc_status_tres,		'modulo'=>1		);				if($acao == 1){			$id_tratativa = $this->cnd_estadual_model->add_tratativa($dados);					}else{			$this->cnd_estadual_model->atualizar_tratativa($dados,$id_tratativa);							}		$_SESSION['idTratativa'] = $id_tratativa;				if(!empty($nova_tratativa)){			$dadosNovaTratativa = array(				'id_contratante' => $idContratante,			'id_cnd_trat' => $id_tratativa,			'observacao' =>$nova_tratativa,			'id_usuario' => $idUsu,			'data' => date("Y-m-d"),			'hora'=> date("h:i:s"),					);			$this->cnd_estadual_model->addObsTrat($dadosNovaTratativa);		}				$dadosEntradaCadin = array('data_entrada_cadin' =>$dtCadin);				$this->cnd_estadual_model->atualizar($dadosEntradaCadin,$id_cnd);				redirect('/cnd_estadual/visao_externa?id='.$id_cnd);		}function atualizar_tipo_cnd(){		$idCnd = $this->input->get('idCnd');		$dataEmissao = $this->input->get('dataEmissao');		$dataVecto = $this->input->get('dataVecto');		$observacaoCnd = $this->input->get('observacaoCnd');	$observacaoExtrato = $this->input->get('observacaoExtrato');	$tipo = $this->input->get('tipo');	$status = $this->input->get('status');		if(empty($dataEmissao)){		$dataEmissao = '0000-00-00';		}else{		$dataEmissaoArr = explode("/",$dataEmissao);			$dataEmissao = $dataEmissaoArr[2].'-'.$dataEmissaoArr[1].'-'.$dataEmissaoArr[0];	}		if(empty($dataVecto)){		$dataVecto = '0000-00-00';		}else{		$dataVectoArr = explode("/",$dataVecto);			$dataVecto = $dataVectoArr[2].'-'.$dataVectoArr[1].'-'.$dataVectoArr[0];	}	$dataAtual = '0000-00-00';	if($status == 2){		$dataAtual = date("Y-m-d");	}		if($tipo == 1){				$dados = array(				'observacoes_cnd' =>$observacaoCnd,			'observacoes_extrato' =>$observacaoExtrato,			'data_emissao_debito_fiscal' => $dataEmissao,			'data_vencto_debito_fiscal' => 	$dataVecto,				'status' => 	$status,			'data_pendencia' => $dataAtual,			 		);		}elseif($tipo == 2){		$dados = array(				'observacoes_cnd' =>$observacaoCnd,			'observacoes_extrato' =>$observacaoExtrato,			'data_emissao_divida_ativa' => $dataEmissao,			'data_vencto_divida_ativa' => 	$dataVecto,				'status' => 	$status,				'data_pendencia' => $dataAtual,		);	}else{		$dados = array(				'observacoes_cnd' =>$observacaoCnd,			'observacoes_extrato' =>$observacaoExtrato,			'data_emissao_ambas' => $dataEmissao,			'data_vencto_ambas' => 	$dataVecto,				'status' => 	$status,			'data_pendencia' => $dataAtual,					);	}		$this->cnd_estadual_model->atualizar_tipo_cnd($dados,$idCnd,$tipo);		echo json_encode(1);		}	function atualizar_cnd_mob_tratativa_unica(){		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$idUsu = $session_data['id'];	$acao 	= $this->input->post('acao');			$data_entrada_cadin 	= $this->input->post('data_entrada_cadin');			if(empty($data_entrada_cadin)){		$dtCadin = '0000-00-00';		}else{		$dtCadinArr = explode("/",$data_entrada_cadin);			$dtCadin = $dtCadinArr[2].'-'.$dtCadinArr[1].'-'.$dtCadinArr[0];	}	$id_cnd 	= $this->input->post('id');	$tipo_tratativa 	= $this->input->post('tipo_tratativa');	if(empty($tipo_tratativa)){		$tipo_tratativa = $this->input->post('tipo_tratativa_bd');	}	$id_tratativa 	= $this->input->post('id_tratativa');	$id_pendencia 	= $this->input->post('id_pendencia');	$id_esfera 	= $this->input->post('id_esfera');	$id_etapa 	= $this->input->post('id_etapa');	$data_informe_pendencia 	= $this->input->post('data_informe_pendencia');	$id_sis_ext 	= $this->input->post('id_sis_ext');	$data_inclusao_sis_ext 	= $this->input->post('data_inclusao_sis_ext');	$prazo_solucao_sis_ext 	= $this->input->post('prazo_solucao_sis_ext');	$data_encerramento_sis_ext 	= $this->input->post('data_encerramento_sis_ext');	$status_chamado_sis_ext 	= $this->input->post('status_chamado_sis_ext');	$id_sla = $this->input->post('id_sla');	$usu_inc 	= $this->input->post('usu_inc');	$area_focal 	= $this->input->post('area_focal');	$sub_area_focal 	= $this->input->post('sub_area_focal');	$contato 	= $this->input->post('contato');	$data_envio 	= $this->input->post('data_envio');	$prazo_solucao 	= $this->input->post('prazo_solucao');	$data_retorno 	= $this->input->post('data_retorno');	$sla 	= $this->input->post('sla');	$status_demanda 	= $this->input->post('status_demanda');	$esc_data_prazo_um 	= $this->input->post('esc_data_prazo_um');	$esc_data_retorno_um 	= $this->input->post('esc_data_retorno_um');	$esc_status_um 	= $this->input->post('esc_status_um');	$esc_data_prazo_dois 	= $this->input->post('esc_data_prazo_dois');	$esc_data_retorno_dois 	= $this->input->post('esc_data_retorno_dois');	$esc_status_dois 	= $this->input->post('esc_status_dois');	$esc_data_prazo_tres 	= $this->input->post('esc_data_prazo_tres');	$esc_data_retorno_tres 	= $this->input->post('esc_data_retorno_tres');	$esc_status_tres 	= $this->input->post('esc_status_tres');	$nova_tratativa 	= $this->input->post('nova_tratativa');		if(empty($data_informe_pendencia)){		$dtInforme = '0000-00-00';		}else{		$dataInformeArr = explode("/",$data_informe_pendencia);			$dtInforme = $dataInformeArr[2].'-'.$dataInformeArr[1].'-'.$dataInformeArr[0];	}		if(empty($data_inclusao_sis_ext)){		$dtInclusaoSisExt = '0000-00-00';		}else{		$dataInformeArr = explode("/",$data_inclusao_sis_ext);			$dtInclusaoSisExt = $dataInformeArr[2].'-'.$dataInformeArr[1].'-'.$dataInformeArr[0];	}		if(empty($prazo_solucao_sis_ext)){		$dtSolSisExt = '0000-00-00';		}else{		$dataSolArr = explode("/",$prazo_solucao_sis_ext);			$dtSolSisExt = $dataSolArr[2].'-'.$dataSolArr[1].'-'.$dataSolArr[0];	}		if(empty($data_encerramento_sis_ext)){		$dtEncerSisExt = '0000-00-00';		}else{		$dataEncerramentoSisExtArr = explode("/",$data_encerramento_sis_ext);		$dtEncerSisExt = $dataEncerramentoSisExtArr[2].'-'.$dataEncerramentoSisExtArr[1].'-'.$dataEncerramentoSisExtArr[0];	}		if(empty($prazo_solucao)){		$dtPrazoSolucao = '0000-00-00';		}else{		$dtPrazoSolucaoArr = explode("/",$prazo_solucao);		$dtPrazoSolucao = $dtPrazoSolucaoArr[2].'-'.$dtPrazoSolucaoArr[1].'-'.$dtPrazoSolucaoArr[0];	}		if(empty($data_envio)){		$dtEnvio = '0000-00-00';		}else{		$dataEnvioArr = explode("/",$data_envio);		$dtEnvio = $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0];	}		if(empty($data_retorno)){		$dtRetorno = '0000-00-00';		}else{		$dataRetornoArr = explode("/",$data_retorno);		$dtRetorno = $dataRetornoArr[2].'-'.$dataRetornoArr[1].'-'.$dataRetornoArr[0];	}		if(empty($esc_data_prazo_um)){		$escDtPrazoUm = '0000-00-00';		}else{		$escDataPrazoUmArr = explode("/",$esc_data_prazo_um);		$escDtPrazoUm = $escDataPrazoUmArr[2].'-'.$escDataPrazoUmArr[1].'-'.$escDataPrazoUmArr[0];	}		if(empty($esc_data_retorno_um)){		$escDtRetUm = '0000-00-00';		}else{		$escDataPrazoUmArr = explode("/",$esc_data_retorno_um);		$escDtRetUm = $escDataPrazoUmArr[2].'-'.$escDataPrazoUmArr[1].'-'.$escDataPrazoUmArr[0];	}		if(empty($esc_data_prazo_dois)){		$escDtPrazoDois = '0000-00-00';		}else{		$escDataPrazoDoisArr = explode("/",$esc_data_prazo_dois);		$escDtPrazoDois = $escDataPrazoDoisArr[2].'-'.$escDataPrazoDoisArr[1].'-'.$escDataPrazoDoisArr[0];	}		if(empty($esc_data_retorno_dois)){		$escDtRetDois = '0000-00-00';		}else{		$escDataRetornoDoisArr = explode("/",$esc_data_retorno_dois);		$escDtRetDois = $escDataRetornoDoisArr[2].'-'.$escDataRetornoDoisArr[1].'-'.$escDataRetornoDoisArr[0];	}		if(empty($esc_data_prazo_tres)){		$escDtPrazoTres = '0000-00-00';		}else{		$escDataPrazoTresArr = explode("/",$esc_data_prazo_tres);		$escDtPrazoTres = $escDataPrazoTresArr[2].'-'.$escDataPrazoTresArr[1].'-'.$escDataPrazoTresArr[0];	}		if(empty($esc_data_retorno_tres)){		$escDtRetTres = '0000-00-00';		}else{		$escDataRetornoDoisArr = explode("/",$esc_data_retorno_tres);		$escDtRetTres = $escDataRetornoDoisArr[2].'-'.$escDataRetornoDoisArr[1].'-'.$escDataRetornoDoisArr[0];	}		$dados = array(		'id_contratante' => $idContratante,		'tipo_tratativa' => $tipo_tratativa,		'id_sis_ext' => $id_sis_ext,		'id_cnd_mob' => $id_cnd,		'pendencia' => $id_pendencia,		'esfera' => $id_esfera,		'etapa' => $id_etapa,		'data_informe_pendencia' => $dtInforme ,		'data_inclusao_sis_ext' => $dtInclusaoSisExt,		'prazo_solucao_sis_ext' => $dtSolSisExt ,		'data_encerramento_sis_ext' => $dtEncerSisExt,		'sla_sis_ext' => $id_sla,		'status_chamado_sis_ext' => $status_chamado_sis_ext , 		'usu_inc' => $usu_inc,		'area_focal' => $area_focal,		'sub_area_focal' => $sub_area_focal,		'contato' => $contato ,		'data_envio' =>$dtEnvio,		'prazo_solucao' => $dtPrazoSolucao,		'data_retorno' =>$dtRetorno,		'sla' => $sla,		'status_demanda' => $status_demanda,		'esc_data_prazo_um' =>$escDtPrazoUm,		'esc_data_retorno_um' =>$escDtRetUm,		'esc_status_um' => $esc_status_um,		'esc_data_prazo_dois' =>$escDtPrazoDois,		'esc_data_retorno_dois' =>$escDtRetDois,		'esc_status_dois' => $esc_status_dois ,		'esc_data_prazo_tres' =>$escDtPrazoTres,		'esc_data_retorno_tres' =>$escDtRetTres ,		'esc_status_tres' => $esc_status_tres,		'modulo'=>1,		'data_atualizacao' => date("Y-m-d H:i:s") 		);		if($acao == 1){			$id_tratativa = $this->cnd_estadual_model->add_tratativa($dados);					}else{			$this->cnd_estadual_model->atualizar_tratativa($dados,$id_tratativa);							}				//guardando id para abrir novamente apos salvar		$_SESSION['idTratativa'] = $id_tratativa;						if($status_chamado_sis_ext > 1){						if(!empty($nova_tratativa)){				$dadosNovaTratativa = array(					'id_contratante' => $idContratante,				'id_cnd_trat' => $id_tratativa,				'observacao' =>$nova_tratativa,				'id_usuario' => $idUsu,				'data' => date("Y-m-d"),				'hora'=> date("H:i:s"),				'data_hora' => date("Y-m-d H:i:s") 							);				$this->cnd_estadual_model->addObsTrat($dadosNovaTratativa);			}					$email = $this->user->buscaEmailById($idUsu);						$dadosNovaTratativa = array(				'id_contratante' => $idContratante,			'id_cnd_trat' => $id_tratativa,			'observacao' =>'Tratativa Cancelada/Encerrada',			'id_usuario' => $idUsu,			'data' => date("Y-m-d"),			'hora'=> date("H:i:s"),			'data_hora' => date("Y-m-d H:i:s") 					);			$this->cnd_estadual_model->addObsTrat($dadosNovaTratativa);					}else{						$dados =  $this->cnd_estadual_model->listarObsTratById($id_tratativa);			$isArray =  is_array($dados) ? '1' : '0';			if($isArray == 0){							$email = $this->user->buscaEmailById($idUsu);								$dadosNovaTratativa = array(					'id_contratante' => $idContratante,				'id_cnd_trat' => $id_tratativa,				'observacao' =>'Tratativa Aberta',				'id_usuario' => $idUsu,				'data' => date("Y-m-d"),				'hora'=> date("H:i:s"),				'data_hora' => date("Y-m-d H:i:s") 						);				$this->cnd_estadual_model->addObsTrat($dadosNovaTratativa);			}						if(!empty($nova_tratativa)){				$dadosNovaTratativa = array(					'id_contratante' => $idContratante,				'id_cnd_trat' => $id_tratativa,				'observacao' =>$nova_tratativa,				'id_usuario' => $idUsu,				'data' => date("Y-m-d"),				'hora'=> date("H:i:s"),				'data_hora' => date("Y-m-d H:i:s") 							);				$this->cnd_estadual_model->addObsTrat($dadosNovaTratativa);			}		}						//$dadosEntradaCadin = array('data_entrada_cadin' =>$dtCadin);				//$this->cnd_estadual_model->atualizar($dadosEntradaCadin,$id_cnd);								$perfilUsuarioLocal = $session_data['local'];	$idUsuario = $session_data['id'];			$modulo = $_SESSION["CNDMob"];					redirect('/cnd_estadual/visao_interna?id='.$id_cnd);		}
function atualizar_cnd_mob_tratativa_unica_cnd(){			$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;	$idUsu = $session_data['id'];	print$tipo_cnd = $this->input->post('tipo_cnd');exit;			$perfilUsuarioLocal = $session_data['local'];	$idUsuario = $session_data['id'];	$id = $this->input->post('id');	$id_emitente = $this->input->post('id_emitente');	$inscricao = $this->input->post('inscricao');	$possui_cnd = $this->input->post('possui_cnd');	$data_vencto = $this->input->post('data_vencto');		$arrDataVencto = explode("/",$data_vencto);		$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];	$observacoes = $this->input->post('observacoes');		$plano = $this->input->post('plano');			$respInt = $this->input->post('resp_int');			$respExt = $this->input->post('resp_ext');			$observacao_tratativa = $this->input->post('observacao_tratativa');		$data_emissao = $this->input->post('data_emissao');		$arrDataEmissao = explode("/",$data_emissao);		$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];			$modulo = $_SESSION["CNDMob"];			if($possui_cnd == 1){		$dados1 = array(			//'inscricao' => $inscricao,			'id_contratante' => $idContratante,			'possui_cnd' => 1,			'ativo' => 0,			'data_vencto' => $dataVencto,						'data_emissao' => $dataEmissao,			'observacoes' => $observacoes,			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt		);		$_SESSION["CNDMob"] = 'listarPorTipoSim';						}elseif($possui_cnd == 2){		$dados1 = array(			//'inscricao' => $inscricao,			'id_contratante' => $idContratante,			'possui_cnd' => 2,			'ativo' => 0,			'data_vencto' => $dataVencto,			'data_emissao' => $dataEmissao,			'observacoes' => $observacoes,			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt		);		$_SESSION["CNDMob"] = 'listarPorTipoNao';	}else{		$dados1 = array(			//'inscricao' => $inscricao,			'id_contratante' => $idContratante,			'possui_cnd' => 3,			'ativo' => 0,			'data_pendencias' => $dataVencto,						'data_emissao' => $dataEmissao,			'observacoes' => $observacoes,			'plano' => $plano,						'id_resp_interno' => $respInt,						'id_resp_externo' => $respExt		);		$_SESSION["CNDMob"] = 'listarPorTipoPendencia';		}	$this->cnd_estadual_model->atualizar($dados1,$id);		redirect('/cnd_estadual/visao_interna?id='.$id);}function visao_interna(){   $session_data = $_SESSION['login_walmart'];         if(empty($_SESSION['idTratativa'])){		$idTratativa = 0;	}else{		$idTratativa = $_SESSION['idTratativa'];	}			$data['idTratativa'] = $idTratativa;	$id = $this->input->get('id');	$idContratante = $_SESSION['cliente'] ;	$data['obs'] = $this->cnd_estadual_model->buscaTodasObservacoes($id,1);			$data['imovel'] = $this->cnd_estadual_model->listarInscricaoByLoja($id);		$data['debito_fiscal'] = $this->cnd_estadual_model->listarDebitoFiscalById($data['imovel'][0]->id_cnd);	$data['divida_ativa'] = $this->cnd_estadual_model->listarDividaAtivaById($data['imovel'][0]->id_cnd);	$data['ambas'] = $this->cnd_estadual_model->listarAmbasById($data['imovel'][0]->id_cnd);	$data['local'] = $session_data['local'];		/*	$dadosImovel = $this->cnd_estadual_model->listarCidadeEstadoById($id);	$dadosDataDb = $this->cnd_estadual_model->listarDataEmissao($id,'falencia');	$data['data_emissao'] = $dadosDataDb;	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;	*/	$data['perfil'] = $session_data['perfil'];	$data['id_cnd'] = $id;	$data['tratativas'] =  $this->cnd_estadual_model->listarTodasTratativas($idContratante,$id,1);	$data['esferas'] = $this->cnd_estadual_model->listarEsfera();	$data['etapas'] = $this->cnd_estadual_model->listarEtapa();	$data['statusInterno'] = $this->cnd_estadual_model->listarStatusInterno();	$data['statusDemanda'] = $this->cnd_estadual_model->listarStatusDemanda();		$data['empresa'] = $session_data['empresa'];	$data['nome_modulo'] = 'Cnd Estadual';		$data['controller'] = 'cnd_estadual';		$data['usuarios']  = $this->user->dadosUsuarios();		$this->load->view('header_pages_view',$data);    $this->load->view('cnd_est_visao_unica_view', $data);	$this->load->view('footer_pages_view');}
 

  function editar(){	
    
  if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
   $session_data = $_SESSION['login_walmart'];
	$id = $this->input->get('id');
	$idContratante = $_SESSION['cliente'] ;
	
  $dados = $this->cnd_estadual_model->listarInscricaoByLoja($id);
	$data['imovel'] = $dados;
	if($dados[0]->possui_cnd == 1){
		$data['modulo'] = 'listarPorTipoSim';
	}else if($dados[0]->possui_cnd == 2){
		$data['modulo'] = 'listarPorTipoNao';
	}else{
		$data['modulo'] = 'listarPorTipoPendencia';
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$dadosImovel = $this->cnd_estadual_model->listarCidadeEstadoById($id);
	$dadosDataDb = $this->cnd_estadual_model->listarDataEmissao($id,'mob');
	$data['data_emissao'] = $dadosDataDb;
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_cnd_mob_view', $data);
	$this->load->view('footer_pages_view');
 } function csvTratativaExt($result){	$file="cnd_estadual.xls";	if($result == 0){			$test="<table border=1>		<tr>		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>		</tr>		";		$test .='</table>';    }else{				$test="<table border=1>			<tr>			<td>Estado</td>			<td>Cidade</td>			<td>Bairro</td>			<td>Endere&ccedil;o</td>			<td>N&uacute;mero</td>			<td>CEP</td>			<td>Unidade</td>			<td>Emitente</td>			<td>CPF/CNPJ</td>			</tr>			";			foreach($result as $key => $iptu){ 				 $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_mob');							 $isArrayLog =  is_array($dadosLog) ? '1' : '0';			 			 $dataEmissao = $this->cnd_estadual_model->listarDataEmissao($iptu->id_cnd,'falencia');														$cor='#fff';				$test .= "<tr >";				$test .= "<td>".utf8_decode($iptu->estado)."</td>";				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";				$test .= "<td>".utf8_decode($iptu->bairro)."</td>";				$test .= "<td>".utf8_decode($iptu->endereco)."</td>";				$test .= "<td>".utf8_decode($iptu->numero)."</td>";				$test .= "<td>".utf8_decode($iptu->cep)."</td>";				$test .= "<td>".utf8_decode($iptu->nome)."</td>";				$test .= "<td>".utf8_decode($iptu->nome_fantasia)."</td>";								$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				//$test .= "<td>".utf8_decode($cnd)."</td>";				//$test .= "<td>".utf8_decode($iptu->data_emissao_br)."</td>";								//$test .= "<td>".utf8_decode($dataV)."</td>";				//$test .= "<td>".utf8_decode($iptu->descricao)."</td>";				//$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";				//$test .= "<td>".utf8_decode($iptu->cc)."</td>";				//$test .= "<td>".utf8_decode($iptu->cod1)."</td>";				//$test .= "<td>".utf8_decode($iptu->cod1)."</td>";				$test .= "</tr>";			}				$session_data = $_SESSION['login_walmart'];				$idContratante = $_SESSION['cliente'] ;				$dadosPendencia = $this->cnd_estadual_model->listarTratativasIdCnd($iptu->id_cnd);												$test .= "<tr >";				$test .= "<td >".utf8_decode('Tratativa')."</td>";				$test .= "<td >".utf8_decode('Tipo Pendência')."</td>";				$test .= "<td >".utf8_decode('Esfera')."</td>";				$test .= "<td >".utf8_decode('Etapa')."</td>";				$test .= "<td >".utf8_decode('Data da Pendência')."</td>";				$test .= "<td >".utf8_decode('Tratativa da Pendência')."</td>";				$test .= "<td >".utf8_decode('Área Focal')."</td>";				$test .= "<td >".utf8_decode('Sub Área Focal')."</td>";				$test .= "<td >".utf8_decode('Contato')."</td>";				$test .= "<td >".utf8_decode('Data Envio')."</td>";				$test .= "<td >".utf8_decode('Prazo Solução')."</td>";				$test .= "<td >".utf8_decode('Status Chamado')."</td>";				$test .= "<td >".utf8_decode('Data Encerramento')."</td>";				$test .= "<td >".utf8_decode('SLA')."</td>";				$test .= "<td >".utf8_decode('Histórico')."</td>";							$test .= "</tr>";				foreach($dadosPendencia as $key => $pend){ 										$observacoes='';										$observacoes ='';					$dados =  $this->cnd_estadual_model->listarObsTratById($pend->id);					 $isArrayHist =  is_array($dados) ? '1' : '0';					 if($isArrayHist == 1){						foreach($dados as $dado){							$observacoes .= $dado->data.' - '.$dado->hora.' - '.$dado->email.' - '.$dado->observacao."<BR>";						} 					 }else{						$observacoes .= 'Sem históricos';					  }					  					  					if($pend->tipo_tratativa == 1){						$tipoTratavia ='Áreas Externas';					}else{						$tipoTratavia ='Áreas Internas';					}					if($pend->status_chamado_sis_ext ==1){						$statusChamado ='Em Atendimento';					}elseif($pend->status_chamado_sis_ext ==2){						$statusChamado ='Cancelado';					}elseif($pend->status_chamado_sis_ext ==3){						$statusChamado ='Encerrado';					}else{						$statusChamado ='Sem Status Definido';					}					$test .= "<tr >";					$test .= "<td >".utf8_decode($pend->id)."</td>";					$test .= "<td >".utf8_decode($pend->pendencia)."</td>";					$test .= "<td >".utf8_decode($pend->descricao_esfera)."</td>";					$test .= "<td >".utf8_decode($pend->descricao_etapa)."</td>";					$test .= "<td >".utf8_decode($pend->data_informe_pendencia)."</td>";					$test .= "<td >".utf8_decode($tipoTratavia)."</td>";					$test .= "<td >".utf8_decode($pend->area_focal)."</td>";					$test .= "<td >".utf8_decode($pend->sub_area_focal)."</td>";					$test .= "<td >".utf8_decode($pend->contato)."</td>";					$test .= "<td >".utf8_decode($pend->data_envio)."</td>";					$test .= "<td >".utf8_decode($pend->prazo_solucao)."</td>";					$test .= "<td >".utf8_decode($statusChamado)."</td>";					$test .= "<td >".utf8_decode($pend->data_encerramento_sis_ext)."</td>";					$test .= "<td >".utf8_decode($pend->sla_sis_ext)."</td>";					$test .= "<td >".utf8_decode($observacoes)."</td>";															$test .= "</tr>";				}							$test .='</table>';		}		header("Content-type: application/vnd.ms-excel");		header("Content-Disposition: attachment; filename=$file");		echo $test;	 } 
 function csvTratativa($result){	$file="cnd_mob.xls";	if($result == 0){			$test="<table border=1>		<tr>		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>		</tr>		";		$test .='</table>';    }else{				$test="<table border=1>			<tr>			<td>Estado</td>			<td>Cidade</td>			<td>Bairro</td>			<td>Endere&ccedil;o</td>			<td>N&uacute;mero</td>			<td>CEP</td>			<td>Loja</td>			<td>Emitente</td>			<td>CPF/CNPJ</td>			<td>N&uacute;mero Inscri&ccedil;&atilde;o</td>			<td>Inscri&ccedil;&atilde;o</td>			<td>Data &Uacute;ltima CND </td>			<td>Data Vencto. &Uacute;ltima CND </td>			<td>Regional</td>			<td>Bandeira</td>			<td>Centro de Custo</td>			<td>C&oacute;digo 1</td>			<td>C&oacute;digo 2</td>			<td>Históric&oacute;</td>			</tr>			";			foreach($result as $key => $iptu){ 				 $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_mob');							 $isArrayLog =  is_array($dadosLog) ? '1' : '0';			 			 $dataEmissao = $this->cnd_estadual_model->listarDataEmissao($iptu->id_cnd,'mob');			//$datasEmissao = $this->cnd_estadual_model->listarTodasDataEmissao($iptu->id_cnd,'mob');						//$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';				 			  			$observacoes='';			$obsArray = $this->cnd_estadual_model->buscaTodasObservacoes($iptu->id_cnd,1);							foreach($obsArray as $key => $ob){ 				$observacoes .= $ob->data.' - '.$ob->hora.' - '.$ob->email.' - '.$ob->observacao;				$observacoes .= '<BR>';				}							if($iptu->possui_cnd == 1){					$possui_cnd ='Sim';					$data = 'Vencimento';				}else{					$possui_cnd ='Não';					$data = 'Pend&ecirc;ncia';				}								if($iptu->possui_cnd == 1){					$cnd ='Emitido';					$corCnd = '#000099';						$dataVArr = explode("-",$iptu->data_vencto);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}elseif($iptu->possui_cnd == 2){					$cnd ='N&atilde;o Emitido';					$corCnd = '#000099';					$dataVArr = explode("-",$iptu->data_vencto);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}elseif($iptu->possui_cnd == 3){					$cnd ='Pendente';					$corCnd = '#000099';					$dataVArr = explode("-",$iptu->data_pendencias);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}								$arrDataVencto = explode("-",$iptu->data_vencto);				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];				$cor='#fff';				$test .= "<tr >";				$test .= "<td>".utf8_decode($iptu->estado)."</td>";				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";				$test .= "<td>".utf8_decode($iptu->bairro)."</td>";				$test .= "<td>".utf8_decode($iptu->endereco)."</td>";				$test .= "<td>".utf8_decode($iptu->numero)."</td>";				$test .= "<td>".utf8_decode($iptu->cep)."</td>";				$test .= "<td>".utf8_decode($iptu->nome)."</td>";				$test .= "<td>".utf8_decode($iptu->nome_fantasia)."</td>";								$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				$test .= "<td>"."'".utf8_decode($iptu->ins_cnd_mob)."'"."</td>";				$test .= "<td>".utf8_decode($cnd)."</td>";				$test .= "<td>".utf8_decode($dataEmissao[0]->data_emissao_br)."</td>";								$test .= "<td>".utf8_decode($dataV)."</td>";				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";				$test .= "<td>".utf8_decode($iptu->cc)."</td>";				$test .= "<td>".utf8_decode($iptu->cod1)."</td>";				$test .= "<td>".utf8_decode($iptu->cod1)."</td>";				$test .= "<td>".utf8_decode($observacoes )."</td>";				$test .= "</tr>";			}			$test .='</table>';		}		header("Content-type: application/vnd.ms-excel");		header("Content-Disposition: attachment; filename=$file");		echo $test;	 }
 function csvGrafico($result){
	 
	 $file="cnd_mob.xls";

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
			<td>Data Vencto/Pend </td>
			</tr>
			";
			
			
	 
			foreach($result as $key => $iptu){ 	
			 $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_mob');				
			 $isArrayLog =  is_array($dadosLog) ? '1' : '0';

			$datasEmissao = $this->cnd_estadual_model->listarTodasDataEmissao($iptu->id_cnd,'mob');
			$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';				 
			  
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
					$cnd ='Emitido';
					$corCnd = '#000099';	
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 2){
					$cnd ='N&atilde;o Emitido';
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
				$test .= "<td>"."'".utf8_decode($iptu->ins_cnd_mob)."'"."</td>";
				
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
				
				$test .= "<td>".utf8_decode($cnd)."</td>";
				$test .= "<td>".$dataV."</td>";					
				$test .= "</tr>";
			
				
			}
			$test .='</table>';
		}

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
 }
 function csv($result){	 	 $file="cnd_mob.xls";	if($result == 0){			$test="<table border=1>		<tr>		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>				</tr>		";		$test .='</table>';    }else{							$test="<table border=1>			<tr>			<td>Id</td>			<td>Raz&atilde;o Social</td>			<td>CPF/CNPJ</td>			<td>Inscri&ccedil;&atilde;o</td>			<td>Cod. 1</td>			<td>Cod. 2</td>			<td>Regional</td>			<td>Bandeira</td>			<td>Cidade</td>			<td>Estado</td>						<td>Observa&ccedil;&otilde;es</td>				<td>Plano de A&ccedil;&atilde;o</td>				<td>Status CND</td>			<td>Possui CND</td>			<td>Data Vencto/Pend </td>			<td>Data de Emiss&atilde;o </td>				<td>Alterado Por </td>			<td>Data Altera&ccedil;&atilde;o </td>			<td>Dados Alterados </td>										</tr>			";							 			foreach($result as $key => $iptu){ 				 $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_mob');							 $isArrayLog =  is_array($dadosLog) ? '1' : '0';			$datasEmissao = $this->cnd_estadual_model->listarTodasDataEmissao($iptu->id_cnd,'mob');			$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';				 			  				if($iptu->status_cnd == 0){					$ativo='Ativo';				}else{					$ativo='Inativo';				}				if($iptu->possui_cnd == 1){					$possui_cnd ='Sim';					$data = 'Vencimento';				}else{					$possui_cnd ='Não';					$data = 'Pend&ecirc;ncia';				}								if($iptu->possui_cnd == 1){					$cnd ='Sim';					$corCnd = '#000099';						$dataVArr = explode("-",$iptu->data_vencto);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}elseif($iptu->possui_cnd == 2){					$cnd ='N&atilde;o';					$corCnd = '#000099';					$dataVArr = explode("-",$iptu->data_vencto);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}elseif($iptu->possui_cnd == 3){					$cnd ='Pend&ecirc;ncia';					$corCnd = '#000099';					$dataVArr = explode("-",$iptu->data_pendencias);									 					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									}								$arrDataVencto = explode("-",$iptu->data_vencto);				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];				$cor='#fff';				$test .= "<tr >";				$test .= "<td>".utf8_decode($iptu->id_cnd)."</td>";				$test .= "<td>".utf8_decode($iptu->nome)."</td>";				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				$test .= "<td>"."'".utf8_decode($iptu->ins_cnd_mob)."'"."</td>";								$test .= "<td>".utf8_decode($iptu->cod1)."</td>";				$test .= "<td>".utf8_decode($iptu->cod2)."</td>";				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";				$test .= "<td>".utf8_decode($iptu->estado)."</td>";				$test .= "<td>".utf8_decode($iptu->observacoes)."</td>";				$test .= "<td>".utf8_decode($iptu->plano)."</td>";				$test .= "<td>".utf8_encode($ativo)."</td>";								$test .= "<td>".utf8_decode($cnd)."</td>";				$test .= "<td>".$dataV."</td>";				if($isdatasEmissao <> 0){					$test .="<td>";										foreach($datasEmissao as $dataE){ 											$test .= $dataE->data_emissao.' ';										}						$test .="</td>";								}else{					$test .="<td>";					$test .="</td>";										}				if($isArrayLog <> 0){					 $dataFormatadaArr = explode('-',$dadosLog[0]->data);					 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];					 $test .="<td>".$dadosLog[0]->email."</td>";					 $test .="<td>".$dataFormatada."</td>";					 $test .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";				}else{					$test .="<td></td>";					$test .="<td></td>";					$test .="<td></td>";				}						$test .= "</tr>";										}			$test .='</table>';		}		header("Content-type: application/vnd.ms-excel");		header("Content-Disposition: attachment; filename=$file");		echo $test;	 } 
 function csv_cnd_estadual($result){	$file="cnd_estadual.xls";	if($result == 0){			$test="<table border=1>		<tr>		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		</tr>
		";
		$test .='</table>';
    }else{				$test="<table border=1>			<tr>						<td>D&eacute;bito Fiscal</td>			<td>D&iacute;vida Ativa</td>			<td>Conjunta</td>			<td>UF Origem</td>			<td>CNPJ</td>			<td>Inscri&ccedil;&atilde;o</td>			<td>UF Inscri&ccedil;&atilde;o</td>				<td>Data Em. D&eacute;bito  Fiscal</td>							<td>Data Vecto D&eacute;bito  Fiscal</td>						<td>Data Em. D&iacute;vida  Ativa</td>							<td>Data Vecto D&iacute;vida  Ativa</td>			<td>Data Em. Conjunta</td>				<td>Data Vecto  Conjunta</td>											</tr>
			";			foreach($result as $key => $iptu){ 		  
								$dataEmiDivAtiArr = explode("-",$iptu->data_emissao_divida_ativa);					$dataEmiDivAtiv = $dataEmiDivAtiArr[2].'-'.$dataEmiDivAtiArr[1].'-'.$dataEmiDivAtiArr[0];								$dataEmiDebFiscArr = explode("-",$iptu->data_emissao_debito_fiscal);					$dataEmiDebFiscal = $dataEmiDebFiscArr[2].'-'.$dataEmiDebFiscArr[1].'-'.$dataEmiDebFiscArr[0];								$dataEmiAmbasArr = explode("-",$iptu->data_emissao_ambas);					$dataEmiAmbas = $dataEmiAmbasArr[2].'-'.$dataEmiAmbasArr[1].'-'.$dataEmiAmbasArr[0];								$dataDivArr = explode("-",$iptu->data_vencto_divida_ativa);					$dataDiv = $dataDivArr[2].'-'.$dataDivArr[1].'-'.$dataDivArr[0];																$dataDebArr = explode("-",$iptu->data_vencto_debito_fiscal);					$dataDeb = $dataDebArr[2].'-'.$dataDebArr[1].'-'.$dataDebArr[0];								$dataAmbArr = explode("-",$iptu->data_vencto_ambas);					$dataAmb = $dataAmbArr[2].'-'.$dataAmbArr[1].'-'.$dataAmbArr[0];				if($iptu->status_debito_fiscal == 3){					$statusDebitoFiscal = "-";				}elseif($iptu->status_debito_fiscal == 2){						$statusDebitoFiscal="Não Emitida";				}else{					$statusDebitoFiscal="Emitida";				}								if($iptu->status_divida_ativa == 3){					$statusDividaAtiva="-";				}elseif($iptu->status_divida_ativa == 2){						$statusDividaAtiva="Não Emitida";				}else{					$statusDividaAtiva="Emitida";				}									if($iptu->status_ambas == 3){					$statusAmbas="-";				}elseif($iptu->status_ambas == 2){						$statusAmbas="Não Emitida";				}else{					$statusAmbas="Emitida";				}				
				$test .= "<tr >";				$test .= "<td>".utf8_decode($statusDebitoFiscal)."</td>";				$test .= "<td>".utf8_decode($statusDividaAtiva)."</td>";				$test .= "<td>".utf8_decode($statusAmbas)."</td>";				$test .= "<td>".utf8_decode($iptu->uf_origem)."</td>";				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'"."</td>";							$test .= "<td>".utf8_decode($iptu->uf_ie)."</td>";								$test .= "<td>".$dataEmiDebFiscal."</td>";				$test .= "<td>".$dataDeb."</td>";								$test .= "<td>".$dataEmiDivAtiv."</td>";				$test .= "<td>".$dataDiv."</td>";				$test .= "<td>".$dataEmiAmbas."</td>";				$test .= "<td>".$dataAmb."</td>";				
				
				$test .= "</tr>";
			
				
			}
			$test .='</table>';
		}
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
 }
 function csv_cnd_estadual_div_ativ($result){	$file="cnd_estadual_divida_ativa.xls";	if($result == 0){			$test="<table border=1>		<tr>		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>		</tr>		";		$test .='</table>';    }else{				$test="<table border=1>			<tr>			<td>D&iacute;vida Ativa</td>			<td>UF Origem</td>			<td>CNPJ</td>			<td>Inscri&ccedil;&atilde;o</td>			<td>UF Inscri&ccedil;&atilde;o</td>			<td>Data Emi. D&iacute;vida Ativa</td>			<td>Data Vecto D&iacute;vida Ativa</td>										</tr>			";			foreach($result as $key => $iptu){ 		  																				$dataDebArr = explode("-",$iptu->data_vencto_divida_ativa);					$dataDeb = $dataDebArr[2].'-'.$dataDebArr[1].'-'.$dataDebArr[0];								$dataEmiDebFiscArr = explode("-",$iptu->data_emissao_divida_ativa);					$dataEmiDebFiscal = $dataEmiDebFiscArr[2].'-'.$dataEmiDebFiscArr[1].'-'.$dataEmiDebFiscArr[0];				if($iptu->status_debito_fiscal == 3){					$statusDebitoFiscal = "-";				}elseif($iptu->status_debito_fiscal == 2){						$statusDebitoFiscal="Não Emitida";				}else{					$statusDebitoFiscal="Emitida";				}												$test .= "<tr >";				$test .= "<td>".utf8_decode($statusDebitoFiscal)."</td>";				$test .= "<td>".utf8_decode($iptu->uf_origem)."</td>";				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'"."</td>";							$test .= "<td>".utf8_decode($iptu->uf_ie)."</td>";				$test .= "<td>".$dataEmiDebFiscal."</td>";				$test .= "<td>".$dataDeb."</td>";												$test .= "</tr>";										}			$test .='</table>';		}				header("Content-type: application/vnd.ms-excel");		header("Content-Disposition: attachment; filename=$file");		echo $test;	 } function csv_cnd_estadual_deb_fiscal($result){	$file="cnd_estadual_debito_fiscal.xls";	if($result == 0){			$test="<table border=1>		<tr>		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>		</tr>		";		$test .='</table>';    }else{				$test="<table border=1>			<tr>			<td>D&eacute;bito Fiscal</td>			<td>UF Origem</td>			<td>CNPJ</td>			<td>Inscri&ccedil;&atilde;o</td>			<td>UF Inscri&ccedil;&atilde;o</td>			<td>Data Emi. D&eacute;bito  Fiscal</td>			<td>Data Vecto D&eacute;bito  Fiscal</td>										</tr>			";			foreach($result as $key => $iptu){ 		  																				$dataDebArr = explode("-",$iptu->data_vencto_debito_fiscal);					$dataDeb = $dataDebArr[2].'-'.$dataDebArr[1].'-'.$dataDebArr[0];								$dataEmiDebFiscArr = explode("-",$iptu->data_emissao_debito_fiscal);					$dataEmiDebFiscal = $dataEmiDebFiscArr[2].'-'.$dataEmiDebFiscArr[1].'-'.$dataEmiDebFiscArr[0];				if($iptu->status_debito_fiscal == 3){					$statusDebitoFiscal = "-";				}elseif($iptu->status_debito_fiscal == 2){						$statusDebitoFiscal="Não Emitida";				}else{					$statusDebitoFiscal="Emitida";				}												$test .= "<tr >";				$test .= "<td>".utf8_decode($statusDebitoFiscal)."</td>";				$test .= "<td>".utf8_decode($iptu->uf_origem)."</td>";				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'"."</td>";							$test .= "<td>".utf8_decode($iptu->uf_ie)."</td>";				$test .= "<td>".$dataEmiDebFiscal."</td>";				$test .= "<td>".$dataDeb."</td>";												$test .= "</tr>";										}			$test .='</table>';		}				header("Content-type: application/vnd.ms-excel");		header("Content-Disposition: attachment; filename=$file");		echo $test;	 } 
 function csv_cnd_estadual_conj($result){	$file="cnd_estadual_conjuta.xls";	if($result == 0){			$test="<table border=1>		<tr>		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>		</tr>		";		$test .='</table>';    }else{				$test="<table border=1>			<tr>			<td>Conjunta</td>			<td>UF Origem</td>			<td>CNPJ</td>			<td>Inscri&ccedil;&atilde;o</td>			<td>UF Inscri&ccedil;&atilde;o</td>			<td>Data Emi. Conjunta</td>			<td>Data Vecto Conjunta</td>										</tr>			";			foreach($result as $key => $iptu){ 		  																				$dataDebArr = explode("-",$iptu->data_vencto_ambas);					$dataDeb = $dataDebArr[2].'-'.$dataDebArr[1].'-'.$dataDebArr[0];								$dataEmiDebFiscArr = explode("-",$iptu->data_emissao_ambas);					$dataEmiDebFiscal = $dataEmiDebFiscArr[2].'-'.$dataEmiDebFiscArr[1].'-'.$dataEmiDebFiscArr[0];				if($iptu->status_debito_fiscal == 3){					$statusDebitoFiscal = "-";				}elseif($iptu->status_debito_fiscal == 2){						$statusDebitoFiscal="Não Emitida";				}else{					$statusDebitoFiscal="Emitida";				}												$test .= "<tr >";				$test .= "<td>".utf8_decode($statusDebitoFiscal)."</td>";				$test .= "<td>".utf8_decode($iptu->uf_origem)."</td>";				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'"."</td>";							$test .= "<td>".utf8_decode($iptu->uf_ie)."</td>";				$test .= "<td>".$dataEmiDebFiscal."</td>";				$test .= "<td>".$dataDeb."</td>";												$test .= "</tr>";										}			$test .='</table>';		}				header("Content-type: application/vnd.ms-excel");		header("Content-Disposition: attachment; filename=$file");		echo $test;	 }
function export_mun(){	  
  if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
	$id = $this->input->post('id_mun_export');
	$tipo = $this->input->post('possuiCnd');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	$result = $this->cnd_estadual_model->listarIptuCsvByCidade($id,$tipo);
	$this->csv($result);		
 }
 
 function export_est(){	  
  if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
	$id = $this->input->post('id_estado_export');
	$tipo = $this->input->post('possuiCnd');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->cnd_estadual_model->listarIptuCsvByEstado($id,$tipo);
	$this->csv($result);
 }
  function exportDivAtivTrintaDiasVencer(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarDivAtivTrintaDiasVencer($idContratante);						$this->csv_cnd_estadual_div_ativ($result); }function exportDebFiscalTrintaDiasVencer(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarDebFiscalTrintaDiasVencer($idContratante);						$this->csv_cnd_estadual_deb_fiscal($result); }
  function exportDebFiscalQuinzeDiasVencer(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarDebFiscalQuinzeDiasVencer($idContratante);						$this->csv_cnd_estadual_deb_fiscal($result); }   function exportConjQuinzeDiasVencer(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarConjQuinzeDiasVencer($idContratante);						$this->csv_cnd_estadual_conj($result); }  function exportConjTrintaDiasVencer(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarConjTrintaDiasVencer($idContratante);						$this->csv_cnd_estadual_conj($result); }  function exportDivAtivQuinzeDiasVencer(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarDivAtivQuinzeDiasVencer($idContratante);						$this->csv_cnd_estadual_div_ativ($result); }   function exportConQuinzeDiasVencida(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarDebFiscalQuinzeDiasVencida($idContratante);						$this->csv_cnd_estadual_conj($result); }  function exportDebFiscalQuinzeDiasVencida(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarDebFiscalQuinzeDiasVencida($idContratante);						$this->csv_cnd_estadual_deb_fiscal($result); }   function exportDivAtivQuinzeDiasVencida(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarDivAtivQuinzeDiasVencida($idContratante);						$this->csv_cnd_estadual_div_ativ($result); }   function exportConjQuinzeDiasVencida(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarConjQuinzeDiasVencida($idContratante);						$this->csv_cnd_estadual_conj($result); }  function exportConjDezesseisDiasVencida(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarConjDezesseisDiasVencida($idContratante);						$this->csv_cnd_estadual_conj($result); }  function exportDebFiscalDezesseisDiasVencida(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarDebFiscalDezesseisDiasVencida($idContratante);						$this->csv_cnd_estadual_deb_fiscal($result); } function exportDivAtivDezesseisDiasVencida(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }		$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;				$result =$this->cnd_estadual_model->listarDivAtivDezesseisDiasVencida($idContratante);						$this->csv_cnd_estadual_div_ativ($result); }
  function export(){	 	  if(! $_SESSION['login_walmart']){		redirect('login', 'refresh');	  }	
	$session_data = $_SESSION['login_walmart'];	$idContratante = $_SESSION['cliente'] ;			if(empty($_POST)){		$result = $this->cnd_estadual_model->listarCndTipo($idContratante,$tipo);	}else{		$status = $_POST['statusExp'];			$estadoOrigen = $_POST['estadoOrigenExp'];		$cnpj = $_POST['cnpjExp'];		$inscricao = $_POST['inscricaoExp'];		$ufsIe = $_POST['ufIeExp'];		$dataVenctoIni = $_POST['data_vencto_ini_exp'];		$dataVenctoFinal = $_POST['data_vencto_final_exp'];		$result =$this->cnd_estadual_model->listarCndTodos($idContratante,$estadoOrigen,$cnpj,$inscricao,$ufsIe,$dataVenctoIni,$dataVenctoFinal,$status);				}		
	$this->csv_cnd_estadual($result);
 }
 function export_tratativas(){		$id = $this->input->get('id');	$dados = $this->cnd_estadual_model->listarInscricaoByLoja($id);	$this->csvTratativa($dados);	  }  function export_tratativas_ext(){		$id = $this->input->get('id');	$dados = $this->cnd_estadual_model->listarInscricaoByLoja($id);		$this->csvTratativaExt($dados);	  }  
 function export_total_mob(){	
  
  if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$id = $this->input->post('id_imovel_export');
	$tipo = 'X';
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	

	$result = $this->cnd_estadual_model->listarIptuCsv($idContratante,$tipo);
	$this->csvGrafico($result);
	
		
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
 function buscaInscricaoByEstado(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_estadual_model->listarImovelByEstado($id,$tipo);
	
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
 
 function buscaPendentes(){	
	//$id = $this->input->get('id');
	
	$retorno ='';
	$result = $this->cnd_estadual_model->listarImovelPendente();
	
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
	  if($iptu->loja_acomp){
		$retorno .="<td width='14%'><a href='$base/acomp_cnd/painel?id=$iptu->loja_acomp'>".$iptu->cpf_cnpj."</a></td>";
	  }else{
		$retorno .="<td width='14%'><a style='color:#000' href='$base/loja/acomp?id=$iptu->id_loja'>".$iptu->cpf_cnpj."</a></td>";
	  }
	  
	  
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
 
 function listarTodos(){	 if(! $_SESSION['login_walmart']){	redirect('login', 'refresh');  }	$tipo = 'X';	$cidade = '0';	$estado = '0';	$session_data = $_SESSION['login_walmart'];	$_SESSION['idTratativa'] = '';	$idContratante = $_SESSION['cliente'] ;					$data['perfil'] = $session_data['perfil'];	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,$tipo);		$data['estados'] = $this->cnd_estadual_model->listarEstadoOrigem($idContratante,$tipo);		$data['cnpjs'] = $this->emitente_model->listarCnpj($idContratante);	$data['inscricoes'] = $this->cnd_estadual_model->listarInscricaoCnd($idContratante);	$data['ufs_ie'] = $this->cnd_estadual_model->listarUfInscricaoCnd($idContratante);	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);	$session_data = $_SESSION['login_walmart'];	if(empty($session_data['visitante'])){		$data['visitante'] = 0;	}else{		$data['visitante'] = $session_data['visitante'];		}	if(empty($_POST)){		$data['statusExp'] = 0;		$data['estadoOrigenExp'] = 0;			$data['cnpjExp'] = 0;		$data['inscricaoExp'] = 0;		$data['ufIeExp'] = 0;		$data['data_vencto_ini_exp'] = 0;		$data['data_vencto_final_exp'] = 0;		$result = $this->cnd_estadual_model->listarCndTipo($idContratante,$tipo);
	}else{		$data['statusExp'] = $status = $_POST['status'];			$data['estadoOrigenExp'] = $estadoOrigen = $_POST['estadoOrigen'];		$data['cnpjExp'] = $cnpj = $_POST['cnpj'];		$data['inscricaoExp'] = $inscricao = $_POST['inscricao'];		$data['ufIeExp'] = $ufsIe = $_POST['ufsIe'];		$data['data_vencto_ini_exp'] = $dataVenctoIni = $_POST['dataVenctoIni'];		$data['data_vencto_final_exp'] =  $dataVenctoFinal = $_POST['dataVenctoFinal'];
		$result =$this->cnd_estadual_model->listarCndTodos($idContratante,$estadoOrigen,$cnpj,$inscricao,$ufsIe,$dataVenctoIni,$dataVenctoFinal,$status);			
	}		$data['iptus'] = $result;	$data['tipo'] = $tipo;	$data['perfil'] = $session_data['perfil'];	$_SESSION["CNDMob"] = 'listarTodos';	$data['CNDMob'] = 'listarTodos';	$data['nome_modulo'] = 'Cnd Estadual';	$data['modulo'] = 'cnd_estadual';
	$this->load->view('header_pages_view',$data);    $this->load->view('listar_cnd_estadual_tipo_view', $data);	$this->load->view('footer_pages_view');
 }
 
 function listarPorTipoSim(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
  
	$tipo = '1';
	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;				
	$data['perfil'] = $session_data['perfil'];
	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,$tipo);	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante,$tipo);	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);
	$session_data = $_SESSION['login_walmart'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	if(empty($_POST)){
		$result = $this->cnd_estadual_model->listarCndTipo($idContratante,$tipo);
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_estadual_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_estadual_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_estadual_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
			//print_r($this->db->last_query());exit;
		}
	}

	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

		
	$_SESSION["CNDMob"] = 'listarPorTipoSim';
	$data['CNDMob'] = 'listarPorTipoSim';
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
			$_SESSION['idTratativa'] = '';
		$data['nome_modulo'] = 'Cnd Estadual';
	$data['modulo'] = 'cnd_estadual';
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 
 function listarPorRegional(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
  
	$tipo  = $this->input->get('tipo');
	$regional  = $this->input->get('reg');
	
	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;				
	$data['perfil'] = $session_data['perfil'];
	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,$tipo);	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante,$tipo);	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);
	$session_data = $_SESSION['login_walmart'];
	
	
	$result =  $this->cnd_estadual_model->listarCndTipoReg($idContratante,$regional,$tipo);

	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

	if(empty($_SESSION["cidadeCNDMBD"])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION["cidadeCNDMBD"];
	}
	if(empty($_SESSION["estadoCNDMBD"])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $_SESSION["estadoCNDMBD"];
	}
	if(empty($_SESSION["idCNDMBD"])){
		$data['idCNDMBD'] = 0;
	}else{
		$data['idCNDMBD'] = $_SESSION["idCNDMBD"];
	}
	
	$_SESSION["CNDMob"] = 'listarPorTipoSim';
	$data['CNDMob'] = 'listarPorTipoSim';
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
		
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function listarPorTipoPendencia(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
	$tipo = '3';
	
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}

	$session_data = $_SESSION['login_walmart'];
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		
		$result = $this->cnd_estadual_model->listarCndTipo($idContratante,$tipo);		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
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
	//print'<BR>';
	//print_r($this->db->last_query());exit;
	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];
		
	
	$_SESSION["CNDMob"] = 'listarPorTipoPendencia';
	
	$data['CNDMob'] = 'listarPorTipoPendencia';
	
	
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
	$_SESSION['idTratativa'] = '';		$data['modulo'] = 'cnd_estadual';	$data['nome_modulo'] = 'Cnd Estadual';	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
function listarPorTipoNao(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
	$tipo = '2';
	$cidade = '0';
	$estado = '0';
	
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante,$tipo);
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		$result = $this->cnd_estadual_model->listarCndTipo($idContratante,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
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


	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

		
	$_SESSION["CNDMob"] = 'listarPorTipoNao';
	
	$data['CNDMob'] = 'listarPorTipoNao';
	
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}		$_SESSION['idTratativa'] = '';
	$data['modulo'] = 'cnd_estadual';	$data['nome_modulo'] = 'Cnd Estadual';
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
  function limpar_filtro(){	
 
	$_SESSION["idCNDMBD"]=0;
  	$_SESSION["cidadeCNDMBD"] = 0;
	$_SESSION["estadoCNDMBD"] = 0;

	$modulo = $_SESSION["CNDMob"];
	redirect('/cnd_estadual/'.$modulo, '');

 }
 
 function listarLoja(){	
 
	redirect('loja/listar_status?status=4', '');

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
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	$result = $this->cnd_estadual_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	
	$total = $this->cnd_estadual_model->somarTodos($idContratante,$cidade,$estado);
	$data['paginacao'] = createPaginate('cnd_mob', $total[0]->total) ;

	$_SESSION["CNDMob"] = 'listar';

	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->session->set_userdata('CNDMob', 'listar');
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 function listar_old(){	
 
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
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	$result = $this->cnd_estadual_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	
	$total = $this->cnd_estadual_model->somarTodos($idContratante,$cidade,$estado);
	$data['paginacao'] = createPaginate('cnd_mob', $total[0]->total) ;

	$_SESSION["CNDMob"] = 'listar';

	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->session->set_userdata('CNDMob', 'listar');
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_view', $data);

	$this->load->view('footer_pages_view');
	


 }

 function listarComParametro(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$cidade  = $this->input->get('cidade');
	$estado  = $this->input->get('uf');
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_estadual_model->listarLoja($idContratante);
	
	$data['estados'] = $this->cnd_estadual_model->listarEstado($idContratante);
	
	$data['cidades'] = $this->cnd_estadual_model->listarCidade($idContratante);
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	$result = $this->cnd_estadual_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	//print_r($this->db->last_query());exit;
	$total = $this->cnd_estadual_model->somarTodos($idContratante,$cidade,$estado);
	$data['paginacao'] = createPaginate('cnd_mob', $total[0]->total) ;

	
	$data['iptus'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_cnd_mobiliaria_view', $data);
	$this->load->view('footer_pages_view');
	

 }
 

}
?>
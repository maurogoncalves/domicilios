<?php


Class cnd_estadual_model extends CI_Model{

	function excluirFisicamente($id){
		$this->db->where('id', $id);
		$this->db->delete('cnd_estadual'); 
		return true;
	 } 
	 
 
  function listarEstado($idContratante,$tipo){
	$this->db->distinct();
	$this -> db -> select('loja.estado as uf');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.estado');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
   function listarEstadoOrigem($idContratante){
	$this->db->distinct();
	$this -> db -> select('uf_origem as uf','distinct');
	$this -> db -> from('cnd_estadual'); 
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> order_by('uf_origem');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
    function listarEstados(){
	$this->db->distinct();
	$this -> db -> select('uf as uf','distinct');
	$this -> db -> from('uf_link_sefaz'); 
	$this -> db -> order_by('uf');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
  function listarInscricaoCnd($idContratante){
	$this->db->distinct();
	$this -> db -> select('inscricao as inscricao','distinct');
	$this -> db -> from('cnd_estadual'); 
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> order_by('inscricao');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
  function listarUfInscricaoCnd($idContratante){
	$this->db->distinct();
	$this -> db -> select('uf_ie as uf','distinct');
	$this -> db -> from('cnd_estadual'); 
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> order_by('uf_ie');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
   function listarCnpj($idContratante){
	$this->db->distinct();
	$this -> db -> select('uf_origem as uf','distinct');
	$this -> db -> from('cnd_estadual'); 
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> order_by('uf_origem');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
  function listarTodasDataEmissao($id,$modulo){
	 
	$sql = "select DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao  from cnd_data_emissao where id_cnd = ? and modulo =? order by data_emissao desc ";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 
   function listarCnpjs(){
	 
	$sql = "select cnpj,referencia,nome,id_contratate  from cnpjs order by cnpj ";

	$query = $this->db->query($sql, array());

   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }

 }
 
 
 function listarMesesKPI(){	 
	$sql = "select distinct  EXTRACT( YEAR_MONTH FROM data_emissao_ambas )  as data 
from cnd_estadual_ambas where data_emissao_ambas <> '0000-00-00'
			union select distinct 
			EXTRACT( YEAR_MONTH FROM data_emissao_debito_fiscal ) 
			 as data from cnd_estadual_debito_fiscal where data_emissao_debito_fiscal <> '0000-00-00'
			union  select distinct 
			EXTRACT( YEAR_MONTH FROM data_emissao_divida_ativa ) 
			 as data from cnd_estadual_divida_ativa where data_emissao_divida_ativa <> '0000-00-00'
			union  
			select  distinct EXTRACT( YEAR_MONTH FROM k.data ) as data from kpi_controle_meses k where k.data <> '0000-00-00'  order by data asc ";
	$query = $this->db->query($sql, array());
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarTotalClientes($empresa,$mes){	 
	$sql = "select 	(sum(emitidas)  + sum(n_emitidas)) as total from kpi where nome_empresa = ? and mes_competencia = ? order by mes_competencia ";
	$query = $this->db->query($sql, array($empresa,$mes));
	
   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }

   
 }
 
 function listarResumoClientes($empresa,$mes){	 
	$sql = "select 	* from kpi where nome_empresa = ? and mes_competencia = ? order by mes_competencia ";
	$query = $this->db->query($sql, array($empresa,$mes));
	
   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }

   
 }
 
 function listarTotalEmitidasCliente($cnpj,$mes,$cliente,$contratante,$status){	 
	if($status == 1){
		$sql = "select sum(emitidas) as total from kpi where  mes_competencia = ? and nome_empresa = ?  and id_contratante = ? and cnpj=? order by mes_competencia ";
	}else{
		$sql = "select sum(n_emitidas) as total from kpi where  mes_competencia = ? and nome_empresa = ?  and id_contratante = ? and cnpj=? order by mes_competencia ";
	}
	
	$query = $this->db->query($sql, array($mes,$cliente,$contratante,$cnpj));
	
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

   
 }
 
 
 function listarResumoCliente($cnpjCliente,$mes,$cliente,$contratante,$status){	 
	if($status == 1){
		$sql = "select 	emitidas as total from kpi where cnpj = ? and mes_competencia = ? and nome_empresa = ?  and id_contratante = ? order by mes_competencia ";
	}else{
		$sql = "select 	n_emitidas as total from kpi where cnpj = ? and mes_competencia = ? and nome_empresa = ?  and id_contratante = ? order by mes_competencia ";
	}
	$query = $this->db->query($sql, array($cnpjCliente,$mes,$cliente,$contratante));
	
   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }

   
 }
 
 function verificarKpiMesCliente($nome,$primeiroDia){	 
	$sql = "select 	count(*) as total from kpi_controle_meses where nome_empresa = ? and data = ? ";
	$query = $this->db->query($sql, array($nome,$primeiroDia));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function buscarDadosKpiClientes($tabela,$cnpjCliente,$primeiroDia,$ultimoDia,$status){	 
	
	if($tabela == 'cnd_estadual_ambas'){
		if($status == 2){

			$sql = "SELECT count(*) as total FROM (`cnd_estadual`)  
			LEFT JOIN cnd_estadual_ambas ON `cnd_estadual`.`id` = cnd_estadual_ambas.`id_cnd_est`  
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on loja.id_emitente = emitente.id
			WHERE  cnd_estadual_ambas.`status` = ? 	and emitente.cpf_cnpj = ? 	and  cnd_estadual_ambas.data_pendencia between ? and ?";
			$query = $this->db->query($sql, array($status,$cnpjCliente,$primeiroDia,$ultimoDia,));
		}else{
			$sql = "SELECT count(*) as total FROM (`cnd_estadual`)  
			LEFT JOIN cnd_estadual_ambas ON `cnd_estadual`.`id` = cnd_estadual_ambas.`id_cnd_est`  
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on loja.id_emitente = emitente.id
			WHERE  cnd_estadual_ambas.`status` = ? 	and emitente.cpf_cnpj = ? 	and cnd_estadual_ambas.data_emissao_ambas between ? and ?";
			$query = $this->db->query($sql, array($status,$cnpjCliente,$primeiroDia,$ultimoDia));
		}
	}elseif($tabela == 'cnd_estadual_debito_fiscal'){
		if($status == 2){
			$sql = "SELECT count(*) as total FROM (`cnd_estadual`)  
			LEFT JOIN cnd_estadual_debito_fiscal ON `cnd_estadual`.`id` = cnd_estadual_debito_fiscal.`id_cnd_est`  
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on loja.id_emitente = emitente.id
			WHERE  cnd_estadual_debito_fiscal.`status` = ? 	and emitente.cpf_cnpj = ? and  cnd_estadual_debito_fiscal.data_pendencia between ? and ?";
			$query = $this->db->query($sql, array($status,$cnpjCliente,$primeiroDia,$ultimoDia,));
			
		}else{
			$sql = "SELECT count(*) as total FROM (`cnd_estadual`)  
			LEFT JOIN cnd_estadual_debito_fiscal ON `cnd_estadual`.`id` = cnd_estadual_debito_fiscal.`id_cnd_est`  
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on loja.id_emitente = emitente.id
			WHERE  cnd_estadual_debito_fiscal.`status` = ? 	and emitente.cpf_cnpj = ? 	and cnd_estadual_debito_fiscal.data_emissao_debito_fiscal between ? and ?";
			$query = $this->db->query($sql, array($status,$cnpjCliente,$primeiroDia,$ultimoDia));
		}	
		
	}else{
		if($status == 2){
			$sql = "SELECT count(*) as total FROM (`cnd_estadual`)  
			LEFT JOIN cnd_estadual_divida_ativa ON `cnd_estadual`.`id` = cnd_estadual_divida_ativa.`id_cnd_est`  
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on loja.id_emitente = emitente.id
			WHERE  cnd_estadual_divida_ativa.`status` = ? 	and emitente.cpf_cnpj = ?  and  cnd_estadual_divida_ativa.data_pendencia between ? and ?	";
			$query = $this->db->query($sql, array($status,$cnpjCliente,$primeiroDia,$ultimoDia,));
		}else{
			$sql = "SELECT count(*) as total FROM (`cnd_estadual`)  
			LEFT JOIN cnd_estadual_divida_ativa ON `cnd_estadual`.`id` = cnd_estadual_divida_ativa.`id_cnd_est`  
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on loja.id_emitente = emitente.id
			WHERE  cnd_estadual_divida_ativa.`status` = ? 	and emitente.cpf_cnpj = ? 	and cnd_estadual_divida_ativa.data_emissao_divida_ativa between ? and ?";
			$query = $this->db->query($sql, array($status,$cnpjCliente,$primeiroDia,$ultimoDia));
		}	
	}
		
	
	
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 function listarResumoClientesEntrePeriodoDinamicoEmitido($tabela,$empresa,$primeiraData,$ultimaData){	
	if($empresa =='EMPRESA UM'){
		
		if($tabela == 'cnd_estadual_debito_fiscal'){
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_debito_fiscal ON `cnd_estadual`.`id` = cnd_estadual_debito_fiscal.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE   cnd_estadual_debito_fiscal.data_emissao_debito_fiscal between ? and ?
			and emitente.cpf_cnpj in
			 ('56.993.502/0001-30','56.993.502/0098-62','56.993.502/0002-10','56.993.502/0026-98','56.993.502/0006-44','56.993.502/0027-79')
			 and status = 1	";
		}elseif($tabela == 'cnd_estadual_divida_ativa'){ 
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_divida_ativa ON `cnd_estadual`.`id` = cnd_estadual_divida_ativa.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE   cnd_estadual_divida_ativa.data_emissao_divida_ativa between ? and ?
			and emitente.cpf_cnpj in ('56.993.502/0001-30','56.993.502/0098-62','56.993.502/0002-10','56.993.502/0026-98','56.993.502/0006-44','56.993.502/0027-79')
			 and status = 1	";
			 

		}else{
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_ambas ON `cnd_estadual`.`id` = cnd_estadual_ambas.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE   cnd_estadual_ambas.data_emissao_ambas between ? and ?
			and emitente.cpf_cnpj in  ('56.993.502/0001-30','56.993.502/0098-62','56.993.502/0002-10','56.993.502/0026-98','56.993.502/0006-44','56.993.502/0027-79')
			 and status = 1	";
		}
		
	}elseif($empresa =='EMPRESA DOIS'){
		
		if($tabela == 'cnd_estadual_debito_fiscal'){
			$sql = "SELECT count(*) as total	 FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_debito_fiscal ON `cnd_estadual`.`id` = cnd_estadual_debito_fiscal.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE   cnd_estadual_debito_fiscal.data_emissao_debito_fiscal between ? and ?
			and emitente.cpf_cnpj in  ('61.287.647/0001-16','61.287.647/0010-07')  and status = 1 ";
		}elseif($tabela == 'cnd_estadual_divida_ativa'){ 
			$sql = "SELECT count(*) as total	 FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_divida_ativa ON `cnd_estadual`.`id` = cnd_estadual_divida_ativa.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE   cnd_estadual_divida_ativa.data_emissao_divida_ativa between ? and ?
			and emitente.cpf_cnpj in  ('61.287.647/0001-16','61.287.647/0010-07')  and status = 1 ";			
		}else{
			$sql = "SELECT count(*) as total	 FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_ambas ON `cnd_estadual`.`id` = cnd_estadual_ambas.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE   cnd_estadual_ambas.data_emissao_ambas between ? and ?
			and emitente.cpf_cnpj in  ('61.287.647/0001-16','61.287.647/0010-07')  and status = 1 ";			
		}
		
				

	}else{
		
		if($tabela == 'cnd_estadual_debito_fiscal'){
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_debito_fiscal ON `cnd_estadual`.`id` = cnd_estadual_debito_fiscal.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE   cnd_estadual_debito_fiscal.data_emissao_debito_fiscal between ? and ?
			and emitente.cpf_cnpj in  ('56.993.502/0025-07','56.993.502/0015-35')  and status = 1 ";
		}elseif($tabela == 'cnd_estadual_divida_ativa'){ 
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_divida_ativa ON `cnd_estadual`.`id` = cnd_estadual_divida_ativa.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE   cnd_estadual_divida_ativa.data_emissao_divida_ativa between ? and ?
			and emitente.cpf_cnpj in  ('56.993.502/0025-07','56.993.502/0015-35')  and status = 1 ";								
		}else{
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_ambas ON `cnd_estadual`.`id` = cnd_estadual_ambas.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE   cnd_estadual_ambas.data_emissao_ambas between ? and ?
			and emitente.cpf_cnpj in  ('56.993.502/0025-07','56.993.502/0015-35')  and status = 1 ";
			
		}
		
		

	}
	$query = $this->db->query($sql, array($primeiraData,$ultimaData));
	
   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }
 }
 
 function verificaFechamentoMensal($nome,$cnpjCliente,$primeiroDia){	
	$sql = "SELECT count(*) as total FROM (`kpi`)  WHERE  nome_empresa= ? and  cnpj= ?  and kpi.mes_competencia = ?  ;";
		
	$query = $this->db->query($sql, array($nome,$cnpjCliente,$primeiroDia));
	
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }
 }
 function listarTotalCndsFechamento($tabela,$cnpj,$primeiraData,$ultimaData,$status){	

	if($tabela == 'cnd_estadual_debito_fiscal'){
		if($status == 1){
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			left join cnd_estadual_debito_fiscal ON `cnd_estadual`.`id` = cnd_estadual_debito_fiscal.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE cnd_estadual_debito_fiscal.status = ? and emitente.cpf_cnpj = ? and cnd_estadual_debito_fiscal.data_emissao_debito_fiscal between ? and ?  ";
		}else{
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			left join cnd_estadual_debito_fiscal ON `cnd_estadual`.`id` = cnd_estadual_debito_fiscal.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE  cnd_estadual_debito_fiscal.status = ? and emitente.cpf_cnpj = ? and cnd_estadual_debito_fiscal.data_pendencia between ? and ?  ";

		}
		
	}elseif($tabela == 'cnd_estadual_divida_ativa'){ 
		if($status == 1){
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			left join cnd_estadual_divida_ativa ON `cnd_estadual`.`id` = cnd_estadual_divida_ativa.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE  cnd_estadual_divida_ativa.status = ? and emitente.cpf_cnpj = ? and cnd_estadual_divida_ativa.data_emissao_divida_ativa between ? and ? ";
		}else{
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			left join cnd_estadual_divida_ativa ON `cnd_estadual`.`id` = cnd_estadual_divida_ativa.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE  cnd_estadual_divida_ativa.status = ? and  emitente.cpf_cnpj = ? and cnd_estadual_divida_ativa.data_pendencia between ? and ? 	 ";
			
		}
		
	}else{
		if($status == 1){
			$sql = "SELECT count(*) as total FROM (`cnd_estadual`)  
			left join cnd_estadual_ambas ON `cnd_estadual`.`id` = cnd_estadual_ambas.`id_cnd_est`  
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on loja.id_emitente = emitente.id
			WHERE  cnd_estadual_ambas.`status` = ? and emitente.cpf_cnpj = ? and cnd_estadual_ambas.data_emissao_ambas between ? and ? ";
		}else{
			$sql = "SELECT count(*) as total FROM (`cnd_estadual`)  
			left join cnd_estadual_ambas ON `cnd_estadual`.`id` = cnd_estadual_ambas.`id_cnd_est`  
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on loja.id_emitente = emitente.id
			WHERE  cnd_estadual_ambas.`status` = ? and emitente.cpf_cnpj = ? and cnd_estadual_ambas.data_pendencia between ? and ? ";
		}	
	}

   $query = $this->db->query($sql, array($status,$cnpj,$primeiraData,$ultimaData));
   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }
   
 }
 
 function listarResumoClientesEntrePeriodoDinamicoNaoEmitido($tabela,$empresa,$primeiraData,$ultimaData){	

	if($empresa =='EMPRESA UM'){
		if($tabela == 'cnd_estadual_debito_fiscal'){
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_debito_fiscal ON `cnd_estadual`.`id` = cnd_estadual_debito_fiscal.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE cnd_estadual_debito_fiscal.data_pendencia between ? and ? and  emitente.cpf_cnpj in
			 ('56.993.502/0001-30','56.993.502/0098-62','56.993.502/0002-10','56.993.502/0026-98','56.993.502/0006-44','56.993.502/0027-79')
			 and cnd_estadual_debito_fiscal.status = 2";
		}elseif($tabela == 'cnd_estadual_divida_ativa'){ 
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_divida_ativa ON `cnd_estadual`.`id` = cnd_estadual_divida_ativa.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE  cnd_estadual_divida_ativa.data_pendencia between ? and ? and emitente.cpf_cnpj in
			 ('56.993.502/0001-30','56.993.502/0098-62','56.993.502/0002-10','56.993.502/0026-98','56.993.502/0006-44','56.993.502/0027-79')
			 and cnd_estadual_divida_ativa.status = 2";
		}else{
			$sql = "SELECT count(*) as total FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_ambas ON `cnd_estadual`.`id` = cnd_estadual_ambas.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE  cnd_estadual_ambas.data_pendencia between ? and ? and emitente.cpf_cnpj in
			 ('56.993.502/0001-30','56.993.502/0098-62','56.993.502/0002-10','56.993.502/0026-98','56.993.502/0006-44','56.993.502/0027-79')
			 and cnd_estadual_ambas.status = 2";
		}
			 
			 
	}elseif($empresa =='EMPRESA DOIS'){		
		if($tabela == 'cnd_estadual_debito_fiscal'){
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_debito_fiscal ON `cnd_estadual`.`id` = cnd_estadual_debito_fiscal.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE cnd_estadual_debito_fiscal.data_pendencia between ? and ? and  emitente.cpf_cnpj in  ('61.287.647/0001-16','61.287.647/0010-07')  and cnd_estadual_debito_fiscal.status = 2";
		}elseif($tabela == 'cnd_estadual_divida_ativa'){ 
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_divida_ativa ON `cnd_estadual`.`id` = cnd_estadual_divida_ativa.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE  cnd_estadual_divida_ativa.data_pendencia between ? and ? and emitente.cpf_cnpj in ('61.287.647/0001-16','61.287.647/0010-07')  and cnd_estadual_divida_ativa.status = 2";
		}else{
			$sql = "SELECT count(*) as total FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_ambas ON `cnd_estadual`.`id` = cnd_estadual_ambas.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE  cnd_estadual_ambas.data_pendencia between ? and ? and emitente.cpf_cnpj in ('61.287.647/0001-16','61.287.647/0010-07')  and cnd_estadual_ambas.status = 2";
		}				
	}else{
		
		if($tabela == 'cnd_estadual_debito_fiscal'){
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_debito_fiscal ON `cnd_estadual`.`id` = cnd_estadual_debito_fiscal.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE cnd_estadual_debito_fiscal.data_pendencia between ? and ? and  emitente.cpf_cnpj in ('56.993.502/0025-07','56.993.502/0015-35')
			 and cnd_estadual_debito_fiscal.status = 2";
		}elseif($tabela == 'cnd_estadual_divida_ativa'){ 
			$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_divida_ativa ON `cnd_estadual`.`id` = cnd_estadual_divida_ativa.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE  cnd_estadual_divida_ativa.data_pendencia between ? and ? and emitente.cpf_cnpj in ('56.993.502/0025-07','56.993.502/0015-35')
			 and cnd_estadual_divida_ativa.status = 2";
		}else{
			$sql = "SELECT count(*) as total FROM (`cnd_estadual`) 
			LEFT JOIN cnd_estadual_ambas ON `cnd_estadual`.`id` = cnd_estadual_ambas.`id_cnd_est` 
			left join loja on loja.id = cnd_estadual.id_loja
			left join emitente on emitente.id = loja.id_emitente
			WHERE  cnd_estadual_ambas.data_pendencia between ? and ? and  emitente.cpf_cnpj in ('56.993.502/0025-07','56.993.502/0015-35')  and cnd_estadual_ambas.status = 2";
		}
		
		
	}
	$query = $this->db->query($sql, array($primeiraData,$ultimaData));
   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }
 }
 
 function listarResumoClientesEntrePeriodo($empresa,$primeiraData,$ultimaData){	 
	$sql = "select sum(emitidas) as emitidas ,sum(n_emitidas) as nao_emitidas, COALESCE((CEILING( sum(emitidas)/(sum(emitidas) + sum(n_emitidas) ) * 100)),0) as porc,mes_competencia,cnpj  from kpi where nome_empresa =  ? and mes_competencia between ? and ? group by mes_competencia order by  mes_competencia";
	$query = $this->db->query($sql, array($empresa,$primeiraData,$ultimaData));
   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }
 }
 
  function verificarSerpac($empresa,$primeiraData,$ultimaData){	 
	$sql = "select count(*) as total from kpi where nome_empresa = ? and mes_competencia between ? and ?  and cnpj <> 'SERPAC'";
	$query = $this->db->query($sql, array($empresa,$primeiraData,$ultimaData));
   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }
 }
 
 function listarUltimaObsTratById($id){
	 
	$sql = "select 	max(c.id) as id from cnd_mob_tratativa_obs c where c.id_cnd_trat = ?";

	$query = $this->db->query($sql, array($id));
	

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarObsTratById($id){	 
	$sql = "select DATE_FORMAT(c.data,'%d/%m/%Y') as data,c.hora,c.data_hora,u.email,u.nome_usuario,c.observacao,c.id,c.arquivo	from cnd_mob_tratativa_obs c left join usuarios u on u.id = c.id_usuario where c.id_cnd_trat = ? order by c.id desc";
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function contarSerpac($data,$cnpj,$cliente,$status){
	 
	if($status == 1){ 
		$sql = "select count(emitidas) as total from kpi where mes_competencia = ? and cnpj = ? and nome_empresa =? ";
	}else{
		$sql = "select count(n_emitidas) as total from kpi where mes_competencia = ? and cnpj = ? and nome_empresa =? ";
	}

	$query = $this->db->query($sql, array($data,$cnpj,$cliente));
	

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 
   public function insere_serpac($detalhes = array()){
	if($this->db->insert('kpi', $detalhes)) {				
		$id = $this->db->insert_id();
		
		return $id;
	}
	return false;
}

 public function kpi_controle_meses($detalhes = array()){
	if($this->db->insert('kpi_controle_meses', $detalhes)) {				
		$id = $this->db->insert_id();
		
		return $id;
	}
	return false;
}


 function atualizar_serpac($dados,$data,$cnpj,$cliente){
	$this->db->where('mes_competencia', $data);
	$this->db->where('cnpj', $cnpj);
	$this->db->where('nome_empresa', $cliente);
	$this->db->update('kpi', $dados); 
	return true;
 }
 
  function atualizar_tratativa($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_mob_tratativa', $dados); 
	return true;
 }
 
 function atualizar_tipo_cnd($dados,$id,$tipo){	 
	$this->db->where('id_cnd_est', $id);

	if($tipo == 1){		
		$this->db->update('cnd_estadual_debito_fiscal', $dados); 
	}elseif($tipo == 2){
		$this->db->update('cnd_estadual_divida_ativa', $dados); 
	}else{
		$this->db->update('cnd_estadual_ambas', $dados); 
	}
	//print_r($this->db->last_query());exit;
	return true;
 }
 
 function atualizar_tratativa_obs($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_mob_tratativa_obs', $dados); 
	return true;
 }
 
 function addObsTrat($detalhes = array()){ 
	if($this->db->insert('cnd_mob_tratativa_obs', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
 }
 function inserirKpiMes($dados = array()){ 
	if($this->db->insert('kpi', $dados)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
 }
	
	function listarTratativasIdCnd($idCnd){
	 
	$sql = "select cnd_mob_tratativa.id,cnd_mob_tratativa.pendencia,
			cnd_mob_tratativa.esfera,cnd_mob_tratativa.etapa,
			esfera.descricao_esfera,etapa.descricao_etapa,
			DATE_FORMAT(cnd_mob_tratativa.data_informe_pendencia,'%d/%m/%Y') as data_informe_pendencia,
			cnd_mob_tratativa.id_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_inclusao_sis_ext,'%d/%m/%Y') as data_inclusao_sis_ext,
			cnd_mob_tratativa.prazo_solucao_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_encerramento_sis_ext,'%d/%m/%Y') as data_encerramento_sis_ext,
			status_chamado_interno.descricao as desc_chamado_int,
			cnd_mob_tratativa.status_chamado_sis_ext,
			cnd_mob_tratativa.sla_sis_ext,
			cnd_mob_tratativa.usu_inc,
			cnd_mob_tratativa.area_focal,
			cnd_mob_tratativa.sub_area_focal,
			cnd_mob_tratativa.contato,
			DATE_FORMAT(cnd_mob_tratativa.data_envio,'%d/%m/%Y') as data_envio,
			DATE_FORMAT(cnd_mob_tratativa.prazo_solucao,'%d/%m/%Y') as prazo_solucao,
			DATE_FORMAT(cnd_mob_tratativa.data_retorno,'%d/%m/%Y') as data_retorno,
			cnd_mob_tratativa.sla,
			cnd_mob_tratativa.status_demanda,
			status_demanda.descricao_etapa as desc_demanda,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_um,'%d/%m/%Y') as esc_data_prazo_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_um,'%d/%m/%Y') as esc_data_retorno_um,
			cnd_mob_tratativa.esc_status_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_dois,
			cnd_mob_tratativa.esc_status_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_tres,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_tres,
			cnd_mob_tratativa.esc_status_tres,tipo_tratativa
			from cnd_mob_tratativa 
			left join esfera on esfera.id = cnd_mob_tratativa.esfera
			left join etapa on etapa.id = cnd_mob_tratativa.etapa
			left join status_chamado_interno on status_chamado_interno.id = cnd_mob_tratativa.status_chamado_sis_ext
			left join status_demanda on status_demanda.id = cnd_mob_tratativa.id
		where cnd_mob_tratativa.id_cnd_mob = ? and modulo = 1 order by cnd_mob_tratativa.id desc";

	$query = $this->db->query($sql, array($idCnd));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function listarTratativaById($idContratante,$id){
	 
	$sql = "select cnd_mob_tratativa.id,
			cnd_mob_tratativa.tipo_tratativa,
			cnd_mob_tratativa.pendencia,
			cnd_mob_tratativa.esfera,cnd_mob_tratativa.etapa,
			esfera.descricao_esfera,etapa.descricao_etapa,
			DATE_FORMAT(cnd_mob_tratativa.data_informe_pendencia,'%d/%m/%Y') as data_informe_pendencia,
			cnd_mob_tratativa.id_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_inclusao_sis_ext,'%d/%m/%Y') as data_inclusao_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.prazo_solucao_sis_ext,'%d/%m/%Y') as prazo_solucao_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_encerramento_sis_ext,'%d/%m/%Y') as data_encerramento_sis_ext,
			status_chamado_interno.descricao as desc_chamado_int,
			cnd_mob_tratativa.status_chamado_sis_ext,
			cnd_mob_tratativa.sla_sis_ext,
			cnd_mob_tratativa.usu_inc,
			cnd_mob_tratativa.area_focal,
			cnd_mob_tratativa.sub_area_focal,
			cnd_mob_tratativa.contato,
			DATE_FORMAT(cnd_mob_tratativa.data_envio,'%d/%m/%Y') as data_envio,
			DATE_FORMAT(cnd_mob_tratativa.prazo_solucao,'%d/%m/%Y') as prazo_solucao,
			DATE_FORMAT(cnd_mob_tratativa.data_retorno,'%d/%m/%Y') as data_retorno,
			cnd_mob_tratativa.sla,
			cnd_mob_tratativa.status_demanda,
			status_demanda.descricao_etapa,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_um,'%d/%m/%Y') as esc_data_prazo_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_um,'%d/%m/%Y') as esc_data_retorno_um,
			cnd_mob_tratativa.esc_status_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_dois,
			cnd_mob_tratativa.esc_status_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_tres,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_tres,
			cnd_mob_tratativa.esc_status_tres
			from cnd_mob_tratativa 
			left join esfera on esfera.id = cnd_mob_tratativa.esfera
			left join etapa on etapa.id = cnd_mob_tratativa.etapa
			left join status_chamado_interno on status_chamado_interno.id = cnd_mob_tratativa.status_chamado_sis_ext
			left join status_demanda on status_demanda.id = cnd_mob_tratativa.id
		where cnd_mob_tratativa.id_contratante = ? and cnd_mob_tratativa.id = ?";

	$query = $this->db->query($sql, array($idContratante,$id));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  
 function listarEsfera(){
   $this -> db -> select('*');
   $this -> db -> from('esfera');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
  function listarEtapa(){
   $this -> db -> select('*');
   $this -> db -> from('etapa');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
  function listarStatusInterno(){
   $this -> db -> select('*');
   $this -> db -> from('status_chamado_interno');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
   function listarStatusDemanda(){
   $this -> db -> select('*');
   $this -> db -> from('status_demanda');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
   function listarTodasTratativas($idContratante,$id,$modulo){
	 
	$sql = "select cnd_mob_tratativa.id,cnd_mob_tratativa.pendencia,
	DATE_FORMAT(data_inclusao_sis_ext,'%d/%m/%Y') as data_envio_voiza ,
	DATE_FORMAT(prazo_solucao_sis_ext,'%d/%m/%Y') as prazo_solucao_voiza ,
	DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_bd ,
	DATE_FORMAT(prazo_solucao,'%d/%m/%Y') as prazo_solucao_bd ,
	status_chamado_sis_ext,
	status_demanda,
	status_demanda.descricao_etapa,
	status_chamado_interno.descricao,
	DATE_FORMAT(data_atualizacao,'%d/%m/%Y') as ultima_tratativa
	from cnd_mob_tratativa
	left join status_demanda on status_demanda.id = cnd_mob_tratativa.status_demanda
	left join status_chamado_interno on status_chamado_interno.id = cnd_mob_tratativa.status_chamado_sis_ext  
	where id_contratante = ? and id_cnd_mob = ? and cnd_mob_tratativa.modulo = ?
	order by cnd_mob_tratativa.data_atualizacao desc
	";

	$query = $this->db->query($sql, array($idContratante,$id,$modulo));
	//print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  public function addDataEmissao($detalhes = array()){

 

	if($this->db->insert('cnd_data_emissao', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
  function listarDataEmissao($id,$modulo){
	 
	$sql = "select data_emissao,DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao_br from cnd_data_emissao where id_cnd = ? and modulo =? order by id desc limit 1";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
  
    function listarCidade($idContratante,$tipo){
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
   function listarDivAtivTrintaDiasVencer($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data2 = date('Y-m-d', strtotime("+30 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_divida_ativa`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_divida_ativa`.`data_vencto_divida_ativa`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_divida_ativa` ON `cnd_estadual`.`id` = `cnd_estadual_divida_ativa`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and cnd_estadual_divida_ativa.data_vencto_divida_ativa between ? and ? ";	     
   

  $query = $this->db->query($sql, array($data1,$data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
   function listarDebFiscalTrintaDiasVencer($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data2 = date('Y-m-d', strtotime("+30 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_debito_fiscal`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_debito_fiscal`.`data_vencto_debito_fiscal`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_debito_fiscal` ON `cnd_estadual`.`id` = `cnd_estadual_debito_fiscal`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and cnd_estadual_debito_fiscal.data_vencto_debito_fiscal between ? and ? ";	     
   

  $query = $this->db->query($sql, array($data1,$data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 
  function listarConjTrintaDiasVencer($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data2 = date('Y-m-d', strtotime("+30 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_ambas`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_ambas`.`data_vencto_ambas`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_ambas` ON `cnd_estadual`.`id` = `cnd_estadual_ambas`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and cnd_estadual_ambas.data_vencto_ambas between ? and ? ";	     
   
  $query = $this->db->query($sql, array($data1,$data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function listarConjQuinzeDiasVencer($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data1 = $dataHoje; 
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_ambas`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_ambas`.`data_vencto_ambas`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_ambas` ON `cnd_estadual`.`id` = `cnd_estadual_ambas`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and cnd_estadual_ambas.data_vencto_ambas between ? and ? ";	     
   

  $query = $this->db->query($sql, array($data1,$data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function listarDebFiscalQuinzeDiasVencer($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data1 = $dataHoje; 
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_debito_fiscal`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_debito_fiscal`.`data_vencto_debito_fiscal`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_debito_fiscal` ON `cnd_estadual`.`id` = `cnd_estadual_debito_fiscal`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and cnd_estadual_debito_fiscal.data_vencto_debito_fiscal between ? and ? ";	     
   

  $query = $this->db->query($sql, array($data1,$data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 
 
   function listarDivAtivQuinzeDiasVencer($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data1 = $dataHoje; 
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_divida_ativa`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_divida_ativa`.`data_vencto_divida_ativa`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_divida_ativa` ON `cnd_estadual`.`id` = `cnd_estadual_divida_ativa`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and cnd_estadual_divida_ativa.data_vencto_divida_ativa between ? and ? ";	     
   

  $query = $this->db->query($sql, array($data1,$data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarDivAtivDezesseisDiasVencida($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("-16 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_divida_ativa`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_divida_ativa`.`data_vencto_divida_ativa`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_divida_ativa` ON `cnd_estadual`.`id` = `cnd_estadual_divida_ativa`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and (cnd_estadual_divida_ativa.data_vencto_divida_ativa <=?  and  cnd_estadual_divida_ativa.data_vencto_divida_ativa <> '0000-00-00')";	     
   

  $query = $this->db->query($sql, array($data1));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarDebFiscalDezesseisDiasVencida($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("-16 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_debito_fiscal`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_debito_fiscal`.`data_vencto_debito_fiscal`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_debito_fiscal` ON `cnd_estadual`.`id` = `cnd_estadual_debito_fiscal`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and (cnd_estadual_debito_fiscal.data_vencto_debito_fiscal <=?  and  cnd_estadual_debito_fiscal.data_vencto_debito_fiscal <> '0000-00-00')";	     
   

  $query = $this->db->query($sql, array($data1));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function listarConjDezesseisDiasVencida($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("-16 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_ambas`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_ambas`.`data_vencto_ambas`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_ambas` ON `cnd_estadual`.`id` = `cnd_estadual_ambas`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and (cnd_estadual_ambas.data_vencto_ambas <=?  and  cnd_estadual_ambas.data_vencto_ambas <> '0000-00-00')";	     
   

  $query = $this->db->query($sql, array($data1));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarConjQuinzeDiasVencida($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	$data1 = date('Y-m-d', strtotime("-1 days",strtotime($dataHoje))); 
   
   $sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_ambas`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_ambas`.`data_vencto_ambas`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_ambas` ON `cnd_estadual`.`id` = `cnd_estadual_ambas`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and cnd_estadual_ambas.data_vencto_ambas between ? and ? ";	
	


  $query = $this->db->query($sql, array($data2,$data1));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 function listarDivAtivQuinzeDiasVencida($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	$data1 = date('Y-m-d', strtotime("-1 days",strtotime($dataHoje))); 
	
	
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_divida_ativa`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_divida_ativa`.`data_vencto_divida_ativa`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_divida_ativa` ON `cnd_estadual`.`id` = `cnd_estadual_divida_ativa`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and cnd_estadual_divida_ativa.data_vencto_divida_ativa between ? and ? ";	     
   

  $query = $this->db->query($sql, array($data2,$data1));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 
 function listarDebFiscalQuinzeDiasVencida($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	$data1 = date('Y-m-d', strtotime("-1 days",strtotime($dataHoje))); 
	
	
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
	`cnd_estadual_debito_fiscal`.`status` as status_debito_fiscal,  `link`, 
	`cnd_estadual_debito_fiscal`.`data_vencto_debito_fiscal`  FROM (`cnd_estadual`)
	LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
	LEFT JOIN `cnd_estadual_debito_fiscal` ON `cnd_estadual`.`id` = `cnd_estadual_debito_fiscal`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = $idContratante 
	and cnd_estadual_debito_fiscal.data_vencto_debito_fiscal between ? and ? ";	     
   

  $query = $this->db->query($sql, array($data2,$data1));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function listarCndTodos($idContratante,$estadoOrigen,$cnpj,$inscricao,$ufsIe,$dataVenctoIni,$dataVenctoFinal,$status){
  $sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
`cnd_estadual_debito_fiscal`.`status` as status_debito_fiscal, 
`cnd_estadual_divida_ativa`.`status` as status_divida_ativa, 
`cnd_estadual_ambas`.`status` as status_ambas, 
`link`, 
`cnd_estadual_divida_ativa`.`data_vencto_divida_ativa`, 
`cnd_estadual_debito_fiscal`.`data_vencto_debito_fiscal`,
`cnd_estadual_ambas`.`data_vencto_ambas`
 FROM (`cnd_estadual`)
  LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id`
   LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	LEFT JOIN `cnd_estadual_divida_ativa` ON `cnd_estadual`.`id` = `cnd_estadual_divida_ativa`.`id_cnd_est` 
	LEFT JOIN `cnd_estadual_debito_fiscal` ON `cnd_estadual`.`id` = `cnd_estadual_debito_fiscal`.`id_cnd_est` 
	LEFT JOIN `cnd_estadual_ambas` ON `cnd_estadual`.`id` = `cnd_estadual_ambas`.`id_cnd_est` 
LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` WHERE `cnd_estadual`.`id_contratante` = $idContratante ";	     
   if($status <> '0'){
	    $sql .= " and (cnd_estadual_divida_ativa.status = $status or cnd_estadual_debito_fiscal.status ='$status' or cnd_estadual_ambas.status ='$status' )" ;		
   }   
   if($estadoOrigen <> '0'){
		$sql .=  " and cnd_estadual.uf_origem ='$estadoOrigen'";
   }   
   if($cnpj <> '0'){
		$sql .=  " and emitente.cpf_cnpj ='$cnpj'";
   }   
   if($inscricao <> '0'){
		$sql .=  " and cnd_estadual.inscricao ='$inscricao'";
   }   
    if($ufsIe <> '0'){
		$sql .=  " and cnd_estadual.uf_ie ='$ufsIe'";
   }  
   
   if(!empty($dataVenctoIni)){
	   $dataVenctoIniArr = explode("/",$dataVenctoIni);
	   $dataVenctoIni = $dataVenctoIniArr[2].'-'.$dataVenctoIniArr[1].'-'.$dataVenctoIniArr[0];
	   $dataVenctoFinalArr = explode("/",$dataVenctoFinal);
	   $dataVenctoFinal = $dataVenctoFinalArr[2].'-'.$dataVenctoFinalArr[1].'-'.$dataVenctoFinalArr[0];
	   
	   $sql .=  "and (cnd_estadual_divida_ativa.data_vencto_divida_ativa between '$dataVenctoIni' and  '$dataVenctoFinal' 
						or cnd_estadual_debito_fiscal.data_vencto_debito_fiscal between '$dataVenctoIni' and '$dataVenctoFinal'
						or cnd_estadual_ambas.data_vencto_ambas between '$dataVenctoIni' and '$dataVenctoFinal')";
   }
  $query = $this->db->query($sql, array());
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function listarCndTipoId($id_contratante,$id,$tipo){

   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_estadual'); 
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   $this -> db -> where('cnd_estadual.id', $id);
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarCndTipoEst($id_contratante,$estado,$tipo ){

   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.razao_social as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_estadual'); 
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
   $this -> db -> where('loja.estado', $estado);
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarCndTipoReg($id_contratante,$regional,$tipo ){
	 
	if($tipo == 5){	
	   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
	   $this -> db -> from('cnd_estadual'); 
	   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
	   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
	   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
	   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
	   $this -> db -> where('loja.regional', $regional);
	   $this -> db -> order_by('emitente.nome_fantasia');
		
	}else{
	   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
	   $this -> db -> from('cnd_estadual'); 
	   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
	   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
	   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
	   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
	   $this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	   $this -> db -> where('loja.regional', $regional);
	   $this -> db -> order_by('emitente.nome_fantasia');
	}


   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
  function listarCndTipo($idContratante,$tipo ){

   $sql = "
   SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, 
`cnd_estadual_debito_fiscal`.`status` as status_debito_fiscal, 
`cnd_estadual_divida_ativa`.`status` as status_divida_ativa, 
`cnd_estadual_ambas`.`status` as status_ambas, 
`link`, 
`cnd_estadual_divida_ativa`.`data_vencto_divida_ativa`, 
`cnd_estadual_debito_fiscal`.`data_vencto_debito_fiscal`,
`cnd_estadual_ambas`.`data_vencto_ambas`
 FROM (`cnd_estadual`)
  LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id`
   LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	LEFT JOIN `cnd_estadual_divida_ativa` ON `cnd_estadual`.`id` = `cnd_estadual_divida_ativa`.`id_cnd_est` 
	LEFT JOIN `cnd_estadual_debito_fiscal` ON `cnd_estadual`.`id` = `cnd_estadual_debito_fiscal`.`id_cnd_est` 
	LEFT JOIN `cnd_estadual_ambas` ON `cnd_estadual`.`id` = `cnd_estadual_ambas`.`id_cnd_est` 
LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` WHERE `cnd_estadual`.`id_contratante` = $idContratante ";	     
   
  $query = $this->db->query($sql, array());
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }


 }

  function listarCnd($id_contratante,$_limit = 30, $_start = 0,$cidade,$estado ){


   $this -> db ->limit( $_limit, $_start ); 	


   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');


   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');


   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   
   if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
   }
   
   $this -> db -> order_by('emitente.nome_fantasia');


   $query = $this -> db -> get();


   //print_r($this->db->last_query());exit;


   if($query -> num_rows() <> 0) {
     return $query->result();

   } else{

     return false;

   }


 }
 function listaResponsaveis($id_contratante,$tipo){
	 
	 $sql = "SELECT  u.id,nome_usuario,email from usuarios u where u.id_contratante = ? and u.local = ? ";
	 $query = $this->db->query($sql, array($id_contratante,$tipo));
	 
	  if($query -> num_rows() <> 0){
		 return $query->result();
	 }else{
		 return false;
	 }
	 
 }	
 
 	public function addObs($detalhes = array()){ 
	if($this->db->insert('cnd_mob_observacao', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}	
	
   function buscaTodasObservacoes($id,$modulo){	
	$sql = "SELECT DATE_FORMAT(data,'%d/%m/%Y') as data,hora,observacao,usuarios.email
			FROM (`cnd_mob_observacao`) 	
			left join usuarios on usuarios.id = cnd_mob_observacao.id_usuario
			WHERE `cnd_mob_observacao`.`id_cnd_mob` = ? and cnd_mob_observacao.modulo = ?
			ORDER BY `cnd_mob_observacao`.`data` ";
			
	$query = $this->db->query($sql, array($id,$modulo));
	$array = $query->result(); 
    return($array);

 }
 
 
 function contaCndRegional($id_contratante,$ano,$tipo,$reg){
	 if($tipo == 0){
		 $sql = "SELECT count(`cnd_estadual`.`possui_cnd`) as total FROM (`cnd_estadual`) 
		left JOIN  `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id`  JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `regional` ON `regional`.`id` = `loja`.`regional`  JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
		 WHERE `cnd_estadual`.`id_contratante` = ? and regional.id = ?
	  ";
	 $query = $this->db->query($sql, array($id_contratante,$reg));
	 }elseif($tipo <> 4){
		 $sql = "SELECT count(`cnd_estadual`.`possui_cnd`) as total FROM (`cnd_estadual`) 
		left JOIN  `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id`  JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `regional` ON `regional`.`id` = `loja`.`regional`  JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
		 WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.possui_cnd = ? and regional.id = ?
	  ";
	 $query = $this->db->query($sql, array($id_contratante,$tipo,$reg));	
	 }else{
		 
		  $sql = "SELECT count(*) as total FROM (`loja`) 
		JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `regional` ON `regional`.`id` = `loja`.`regional`  
		JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
		 WHERE `loja`.`id_contratante` = ? and regional.id = ?
		 and loja.id not in (select id_loja from cnd_estadual where id_contratante = ?)
	  ";
	 $query = $this->db->query($sql, array($id_contratante,$reg,$id_contratante));	
		 
	 }
	 
	 if($query -> num_rows() <> 0){
		 return $query->result();
	 }else{
		 return false;
	 }
 }
 
 function regionais(){
   $this -> db -> select('id,descricao');
   $this -> db -> from('regional');  
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 function contaCnd($id_contratante,$ano){
	$sql = "SELECT count(`cnd_estadual`.`possui_cnd`) as total, `possui_cnd` FROM (`cnd_estadual`)  	left JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id`  JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`  JOIN `regional` ON `regional`.`id` = `loja`.`regional`  JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`  WHERE `cnd_estadual`.`id_contratante` = ? GROUP BY `cnd_estadual`.`possui_cnd`  ";
	$query = $this->db->query($sql, array($id_contratante));
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }
 }
 
 function contaCndSemStatus($id_contratante,$uf,$status){
	$sql = "SELECT 
count(*) as total
 FROM (`cnd_estadual`)
  LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
  LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
  LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
   LEFT JOIN `cnd_estadual_divida_ativa` ON `cnd_estadual`.`id` = `cnd_estadual_divida_ativa`.`id_cnd_est`
	 LEFT JOIN `cnd_estadual_debito_fiscal` ON `cnd_estadual`.`id` = `cnd_estadual_debito_fiscal`.`id_cnd_est`
	  LEFT JOIN `cnd_estadual_ambas` ON `cnd_estadual`.`id` = `cnd_estadual_ambas`.`id_cnd_est` 
	  LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	  WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.uf_ie=?
	  and  cnd_estadual_ambas.`status` = ?   and cnd_estadual_debito_fiscal.`status` = ? and cnd_estadual_divida_ativa.`status` = ?";
	$query = $this->db->query($sql, array($id_contratante,$uf,$status,$status,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function contaCndNaoEmitidaAmbas($id_contratante,$uf,$status){
	$sql = "SELECT count(*) as total FROM (`cnd_estadual`)
    LEFT JOIN `cnd_estadual_ambas` ON `cnd_estadual`.`id` = `cnd_estadual_ambas`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.uf_ie=?
	and  cnd_estadual_ambas.`status` = ?  ";
	$query = $this->db->query($sql, array($id_contratante,$uf,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function contaCndEmitidaAmbas($id_contratante,$uf,$status){
	$sql = "SELECT  count(*) as total  FROM (`cnd_estadual`)
	LEFT JOIN `cnd_estadual_ambas` ON `cnd_estadual`.`id` = `cnd_estadual_ambas`.`id_cnd_est` 
	LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.uf_ie=?
	and  cnd_estadual_ambas.`status` = ?  ";
	$query = $this->db->query($sql, array($id_contratante,$uf,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function contaCndNaoEmitidaOutras($id_contratante,$uf,$status){
	$sql = "SELECT  count(*) as total  FROM (`cnd_estadual`)
     LEFT JOIN `cnd_estadual_divida_ativa` ON `cnd_estadual`.`id` = `cnd_estadual_divida_ativa`.`id_cnd_est`
	 LEFT JOIN `cnd_estadual_debito_fiscal` ON `cnd_estadual`.`id` = `cnd_estadual_debito_fiscal`.`id_cnd_est`
	  LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	  WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.uf_ie=?
	  and (cnd_estadual_debito_fiscal.`status` = ? or cnd_estadual_divida_ativa.`status` = ?  )";
	$query = $this->db->query($sql, array($id_contratante,$uf,$status,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function contaCndEmitidaOutras($id_contratante,$uf,$status){
	$sql = "SELECT 
count(*) as total
 FROM (`cnd_estadual`)
     LEFT JOIN `cnd_estadual_divida_ativa` ON `cnd_estadual`.`id` = `cnd_estadual_divida_ativa`.`id_cnd_est`
	 LEFT JOIN `cnd_estadual_debito_fiscal` ON `cnd_estadual`.`id` = `cnd_estadual_debito_fiscal`.`id_cnd_est`
	  LEFT JOIN `uf_link_sefaz` ON `cnd_estadual`.`uf_ie` = `uf_link_sefaz`.`uf` 
	  WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.uf_ie=?
	  and (cnd_estadual_debito_fiscal.`status` = ? or cnd_estadual_divida_ativa.`status` = ?  )";
	$query = $this->db->query($sql, array($id_contratante,$uf,$status,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function contaCndEstadual($id_contratante,$status,$tabela){
	$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? ";
	$query = $this->db->query($sql, array($id_contratante,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function contaCndEstadualByUf($id_contratante,$status,$tabela,$uf){
	$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ?";
	$query = $this->db->query($sql, array($id_contratante,$status,$uf));
	//print_r($this->db->last_query());
	//print'<BR>';
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function contaCndEstadualByUfSemStatus($id_contratante,$status,$tabela,$uf){
	 
	if($tabela =='cnd_estadual_debito_fiscal'){ 
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est`  
				WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ?
				and cnd_estadual.id not in (select id_cnd_est from cnd_estadual_ambas where status <> 3)";
		$query = $this->db->query($sql, array($id_contratante,$status,$uf));
	}elseif($tabela =='cnd_estadual_divida_ativa'){ 
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
				WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ?
				and cnd_estadual.id not in (select id_cnd_est from cnd_estadual_ambas where status <> 3)";
		$query = $this->db->query($sql, array($id_contratante,$status,$uf));
	}else{
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est`  
				WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ?
				and cnd_estadual.id not in (select id_cnd_est from cnd_estadual_debito_fiscal where status <> 3)
				and cnd_estadual.id not in (select id_cnd_est from cnd_estadual_divida_ativa where status <> 3)";
		$query = $this->db->query($sql, array($id_contratante,$status,$uf));
	}
	
	
	//print_r($this->db->last_query());
	//print'<BR>';
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function contaCndEstadualByUfTrintaDiasVencer($id_contratante,$status,$tabela,$uf){
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data2 = date('Y-m-d', strtotime("+30 days",strtotime($dataHoje))); 
	
	if($tabela == 'cnd_estadual_debito_fiscal'){
	$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and $tabela.data_vencto_debito_fiscal between ? and ? ";
	}elseif($tabela == 'cnd_estadual_divida_ativa'){
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and $tabela.data_vencto_divida_ativa between ? and ? ";
	}else{
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and $tabela.data_vencto_ambas between ? and ? ";
	}
	$query = $this->db->query($sql, array($id_contratante,$status,$uf,$data1,$data2));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function contaCndEstadualByUfQuinzeDiasVencer($id_contratante,$status,$tabela,$uf){
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data1 = $dataHoje; 
	
	if($tabela == 'cnd_estadual_debito_fiscal'){
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and $tabela.data_vencto_debito_fiscal between ? and ? ";
	}elseif($tabela == 'cnd_estadual_divida_ativa'){
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and $tabela.data_vencto_divida_ativa between ? and ? ";
	}else{
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and $tabela.data_vencto_ambas between ? and ? ";
	}	
	$query = $this->db->query($sql, array($id_contratante,$status,$uf,$data1,$data2));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function contaCndEstadualByUfQuinzeDiasVencida($id_contratante,$status,$tabela,$uf){
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	$data1 = date('Y-m-d', strtotime("-1 days",strtotime($dataHoje))); 
	
	
	
	if($tabela == 'cnd_estadual_debito_fiscal'){
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and $tabela.data_vencto_debito_fiscal between ? and ? ;";
	}elseif($tabela == 'cnd_estadual_divida_ativa'){
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and $tabela.data_vencto_divida_ativa between ? and ? ;";
	}else{
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and $tabela.data_vencto_ambas between ? and ? ;";
	}
	
	
	$query = $this->db->query($sql, array($id_contratante,$status,$uf,$data2,$data1));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function contaCndEstadualByUfTrintaDiasVencida($id_contratante,$status,$tabela,$uf){
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("-16 days",strtotime($dataHoje))); 
	
	
	if($tabela == 'cnd_estadual_debito_fiscal'){
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and ($tabela.data_vencto_debito_fiscal <=?  and  cnd_estadual_debito_fiscal.data_vencto_debito_fiscal <> '0000-00-00')";
	}elseif($tabela == 'cnd_estadual_divida_ativa'){
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and ($tabela.data_vencto_divida_ativa <=?  and  cnd_estadual_divida_ativa.data_vencto_divida_ativa <> '0000-00-00')";
	}else{
		$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? and cnd_estadual.uf_ie = ? 
		and ($tabela.data_vencto_ambas <=?  and  cnd_estadual_ambas.data_vencto_ambas <> '0000-00-00')";
	}
	

		
		
	$query = $this->db->query($sql, array($id_contratante,$status,$uf,$data1));
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function listarIptuCsv($id_contratante,$tipo){


 
 $this -> db -> select('*,loja.ins_cnd_mob,cnd_estadual.ativo as status_cnd,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');

   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');
   
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);  
	$this -> db -> order_by('loja.id'); 	
	
   }else{
	$this -> db -> order_by('cnd_estadual.possui_cnd');  
   }
   
   

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
  function listarIptuCsvByCidade($id,$tipo){

	$this -> db -> select('*,loja.ins_cnd_mob,cnd_estadual.ativo as status_cnd,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');
   
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');

   $this -> db -> where('loja.cidade', $id);
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
   }
   
   	$this -> db -> order_by('loja.id');

   $query = $this -> db -> get();

  

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function getStatusInscricaoLojaByEstado($id){


   $this -> db -> select('ins_cnd_mob');

   $this -> db -> from('loja');
   
   $this -> db -> where('loja.estado', $id);
      	

   $query = $this -> db -> get();

  print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarIptuCsvByEstado($id,$tipo){


   $this -> db -> select('*,loja.ins_cnd_mob,cnd_estadual.ativo as status_cnd,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');
   
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');

   $this -> db -> where('loja.estado', $id);
   
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
   }
   
   	$this -> db -> order_by('loja.id');

   $query = $this -> db -> get();

  //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarTodasCidades(){

   $this->db->distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('imovel');   
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel'); 
   $this -> db -> join('cnd_estadual','cnd_estadual.id_iptu = iptu.id');   
   $this -> db -> order_by('imovel.cidade');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return 0;

   }

 }
 
 function listarEmitenteById($id){

   $this -> db -> select('emitente.id,emitente.nome_fantasia as razao_social,emitente.cpf_cnpj,loja.id as id_loja,loja.ins_cnd_mob as inc_cnd_mob');

   $this -> db -> from('emitente');
   
   $this -> db -> join('loja','emitente.id = loja.id_emitente'); 

   $this -> db -> where('loja.id', $id);

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarEmitentes($id_contratante){

   $this -> db -> select('emitente.id,emitente.nome_fantasia as razao_social');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');

   $this -> db -> where('id_contratante', $id_contratante);

   $this -> db -> where('tipo_emitente', 4);
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarCidadeByEstado($idContratante,$id,$tipo){
	
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> where('loja.estado', $id);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();



   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return 0;

   }

 }
 
 function listarIptuCsvById($id,$tipo){
 
   $this -> db -> select('*,loja.ins_cnd_mob,cnd_estadual.ativo as status_cnd,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');
   
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');

   $this -> db -> where('loja.id', $id);
   
    if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
   }
   
   $this -> db -> order_by('loja.id');
   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 

 }

 function somarTodos($idContratante,$cidade,$estado){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
     if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
   }
   $this -> db -> where('cnd_estadual.id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }

   function somarTodosTipo($idContratante,$cidade,$estado,$tipo){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
   $this -> db -> where('cnd_estadual.possui_cnd', $tipo);
   if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
   }
   $this -> db -> where('cnd_estadual.id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }
  
  function status_iptu(){
   $this -> db -> select('status_iptu.id,status_iptu.descricao');
   $this -> db -> from('status_iptu');
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarInscricaoByIptu($id){
   $this->db->distinct();
   $this -> db -> select('iptu.id,iptu.inscricao');
   $this -> db -> from('iptu');
   $this -> db -> join('imovel','iptu.id_imovel = imovel.id','left');
   $this -> db -> where('iptu.id', $id);

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 

function listarTodasInscricoes($id_contratante){
   $this->db->distinct();
   $this -> db -> select('iptu.id,iptu.inscricao');
   $this -> db -> from('iptu');
   $this -> db -> join('imovel','iptu.id_imovel = imovel.id','left');
   $this -> db -> where('imovel.id_contratante', $id_contratante);
   $this -> db -> order_by('iptu.inscricao');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
  function listarLoja($id_contratante,$tipo){
   $this->db->distinct();
   $this -> db -> select('cnd_estadual.id,emitente.nome_fantasia as  nome');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
   }
   
   $this -> db -> order_by('loja.id');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarImovelByEstado($id,$tipo){
   $this -> db ->distinct();
	
   $this -> db -> select('emitente.id,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.estado', $id);
   if($tipo<>'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
   }
   $this -> db -> order_by('emitente.id');
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
     return $query->result();
	}else{
     return false;
   }

 }
 
function listarImovelByCidade($id,$tipo){


	$this -> db ->distinct();
	$this -> db -> select('cnd_estadual.id,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.cidade', $id);
   if($tipo <> 'X'){
	 $this -> db -> where('cnd_estadual.possui_cnd', $tipo);  
   }	
	$query = $this -> db -> get();

  //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
   public function add_tratativa($detalhes = array()){

 

	if($this->db->insert('cnd_mob_tratativa', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
	public function add_cnd_debito_fiscal($detalhes = array()){
		if($this->db->insert('cnd_estadual_debito_fiscal', $detalhes)) {				
			$id = $this->db->insert_id();
			
			return $id;
		}
		return false;
	}

	public function add_cnd_divida_ativa($detalhes = array()){
		if($this->db->insert('cnd_estadual_divida_ativa', $detalhes)) {				
			$id = $this->db->insert_id();
			return $id;
		}
		return false;
	}
	
	public function add_cnd_ambas($detalhes = array()){
		if($this->db->insert('cnd_estadual_ambas', $detalhes)) {				
			$id = $this->db->insert_id();
			return $id;
		}
		return false;
	}

  public function add($detalhes = array()){
	if($this->db->insert('cnd_estadual', $detalhes)) {				
		$id = $this->db->insert_id();
		
		return $id;
	}
	return false;
}
	
	 function listarCNDById($id){
   $this -> db -> select('*');
   $this -> db -> from('cnd_estadual');
   $this -> db -> where('cnd_estadual.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
	function atualizar($dados,$id){

 

	$this->db->where('id', $id);

	$this->db->update('cnd_estadual', $dados); 

	//print_r($this->db->last_query());exit;

	return true;

  

 } 
 
 	function atualizar_loja($inscricao,$id){

		$dados = array(
			'ins_cnd_mob' => $inscricao
		);

	$this->db->where('id', $id);

	$this->db->update('loja', $dados); 

	//print_r($this->db->last_query());exit;

	return true;

  

 } 
 
 function listarCidadeEstadoById($id){
	
  $this -> db -> select('loja.id,loja.cidade,loja.estado ');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   

   $this -> db -> where('cnd_estadual.id', $id);   


   $query = $this -> db -> get();

//print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarInscricaoByLoja($id){
	
$sql = "SELECT *,link, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `loja`.`ins_cnd_mob` as ins_cnd_mob, `loja`.`id` as id_loja, DATE_FORMAT(data_emissao, '%d/%m/%Y') as data_emissao_br FROM (`cnd_estadual`) LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id`  LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`  LEFT JOIN uf_link_sefaz on cnd_estadual.uf_ie = uf_link_sefaz.uf WHERE `cnd_estadual`.`id`  = ?";
$query = $this->db->query($sql, array($id));


   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }
 }
 
 function listarDebitoFiscalById($id){
	
$sql = "SELECT DATE_FORMAT(data_emissao_debito_fiscal, '%d/%m/%Y') as data_emissao_debito_fiscal,
				DATE_FORMAT(data_vencto_debito_fiscal, '%d/%m/%Y') as data_vencto_debito_fiscal,arq_cnd_debito_fiscal,extrato_debito_fiscal,
				status,observacoes_cnd ,observacoes_extrato  from  cnd_estadual_debito_fiscal WHERE `cnd_estadual_debito_fiscal`.`id_cnd_est`  = ?";
$query = $this->db->query($sql, array($id));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }
 }
 
  function listarDividaAtivaById($id){
	
$sql = "SELECT  DATE_FORMAT(data_emissao_divida_ativa, '%d/%m/%Y') as data_emissao_divida_ativa,
				DATE_FORMAT(data_vencto_divida_ativa, '%d/%m/%Y') as data_vencto_divida_ativa,arq_cnd_divida_ativa,extrado_divida_ativa,
				status,observacoes_cnd ,observacoes_extrato from  cnd_estadual_divida_ativa WHERE `cnd_estadual_divida_ativa`.`id_cnd_est`  = ?";
$query = $this->db->query($sql, array($id));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }
 }
 
 function listarAmbasById($id){
	
$sql = "SELECT  DATE_FORMAT(data_emissao_ambas, '%d/%m/%Y') as data_emissao_ambas,
				DATE_FORMAT(data_vencto_ambas, '%d/%m/%Y') as data_vencto_ambas,arq_cnd_ambas,extrato_ambas,
				status,observacoes_cnd ,observacoes_extrato from  cnd_estadual_ambas WHERE `cnd_estadual_ambas`.`id_cnd_est`  = ?";
$query = $this->db->query($sql, array($id));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }
 }
	function listarInscricaoById($id){
	
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   

   $this -> db -> where('cnd_estadual.id', $id);   


   $query = $this -> db -> get();

	//print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarLojaByImovel($id_loja,$tipo){
	 
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_estadual'); 
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
     
   if($id_loja <> 0){
	$this -> db -> where('loja.id', $id_loja);   
   }	
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
   }	
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }

   
  function listarImovelByUf($estado,$tipo){
	 
	
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('loja.estado', $estado);  
  
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
   }	
 
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarImovelPendente(){
	 
	
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('cnd_estadual.possui_cnd', '3');  
  
 
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarImovelByMunicipio($municipio,$tipo){
	 
	$this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   
   $this -> db -> where('loja.cidade', $municipio);  

   if($tipo <> 'X'){
	 $this -> db -> where('cnd_estadual.possui_cnd', $tipo);    
   }

   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 

}


?>
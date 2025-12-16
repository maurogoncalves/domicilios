<?php
Class Sublocacao_model extends CI_Model{

  function listarSubLocacao($id_contratante){
      $sql = "select 
			sublocacoes.id as idsub,
			em.nome_fantasia as locador,
			emitente.nome_fantasia as locatario,
			sublocacoes.prazo,
			receitas.descricao_receita
			from sublocacoes
			left join loja
			on sublocacoes.id_loja = loja.id
			left join emitente on sublocacoes.id_emitente = emitente.id
			left join emitente em on em.id = loja.id_emitente
			left join receitas on sublocacoes.receita = receitas.id
			where sublocacoes.id_contratante = ?
		    ORDER BY `em`.`nome_fantasia`";

   $query = $this->db->query($sql, array($id_contratante));
   
   $array = $query->result();
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarSubLocacaoByEstado($id_contratante,$estado){
      $sql = "select 
			sublocacoes.id as idsub,
			em.nome_fantasia as locador,em.cpf_cnpj as locador_cpf_cnpj,loja.cidade,loja.estado,
			emitente.nome_fantasia as locatario,emitente.cpf_cnpj,
			sublocacoes.prazo,
			receitas.descricao_receita,
			DATE_FORMAT(sublocacoes.data_vencimento,'%d/%m/%Y') as data_vencimento,
			DATE_FORMAT(sublocacoes.data_ini_vigencia,'%d/%m/%Y') as data_ini_vigencia_br,
			DATE_FORMAT(sublocacoes.data_fim_vigencia,'%d/%m/%Y') as data_fim_vigencia_br,metragem,sublocacoes.valor_base,
			sublocacoes.status status_sub
			from sublocacoes
			left join loja
			on sublocacoes.id_loja = loja.id
			left join emitente on sublocacoes.id_emitente = emitente.id
			left join emitente em on em.id = loja.id_emitente
			left join receitas on sublocacoes.receita = receitas.id
			where sublocacoes.id_contratante = ?
			and loja.estado  = ?
		    ORDER BY `em`.`nome_fantasia` ";

   $query = $this->db->query($sql, array($id_contratante,$estado));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarSubLocacaoId($id_contratante,$id){
 
 
 if($id == 0){
 
 $sql = "select 
			sublocacoes.id as idsub,
			em.nome_fantasia as locador,em.cpf_cnpj as locador_cpf_cnpj,loja.cidade,loja.estado,
			emitente.nome_fantasia as locatario,emitente.cpf_cnpj,
			sublocacoes.prazo,
			receitas.descricao_receita,
			DATE_FORMAT(sublocacoes.data_vencimento,'%d/%m/%Y') as data_vencimento,
			DATE_FORMAT(sublocacoes.data_ini_vigencia,'%d/%m/%Y') as data_ini_vigencia_br,
			DATE_FORMAT(sublocacoes.data_fim_vigencia,'%d/%m/%Y') as data_fim_vigencia_br,metragem,sublocacoes.valor_base,
			sublocacoes.status status_sub
			from sublocacoes
			left join loja
			on sublocacoes.id_loja = loja.id
			left join emitente on sublocacoes.id_emitente = emitente.id
			left join emitente em on em.id = loja.id_emitente
			left join receitas on sublocacoes.receita = receitas.id
			where sublocacoes.id_contratante = ?
		    ";
			
 }else{
      $sql = "select 
			sublocacoes.id as idsub,
			em.nome_fantasia as locador,em.cpf_cnpj as locador_cpf_cnpj,loja.cidade,loja.estado,
			emitente.nome_fantasia as locatario,emitente.cpf_cnpj,
			sublocacoes.prazo,
			receitas.descricao_receita,
			DATE_FORMAT(sublocacoes.data_vencimento,'%d/%m/%Y') as data_vencimento,
			DATE_FORMAT(sublocacoes.data_ini_vigencia,'%d/%m/%Y') as data_ini_vigencia_br,
			DATE_FORMAT(sublocacoes.data_fim_vigencia,'%d/%m/%Y') as data_fim_vigencia_br,metragem,sublocacoes.valor_base,
			sublocacoes.status status_sub
			from sublocacoes
			left join loja
			on sublocacoes.id_loja = loja.id
			left join emitente on sublocacoes.id_emitente = emitente.id
			left join emitente em on em.id = loja.id_emitente
			left join receitas on sublocacoes.receita = receitas.id
			where sublocacoes.id_contratante = ?
			and loja.id  = ?
		    ";
	}
   $query = $this->db->query($sql, array($id_contratante,$id));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function listarSubLocacaoByMunicipio($id_contratante,$municipio){
      $sql = "select 
			sublocacoes.id as idsub,
			em.nome_fantasia as locador,em.cpf_cnpj as locador_cpf_cnpj,loja.cidade,loja.estado,
			emitente.nome_fantasia as locatario,emitente.cpf_cnpj,
			sublocacoes.prazo,
			receitas.descricao_receita,
			DATE_FORMAT(sublocacoes.data_vencimento,'%d/%m/%Y') as data_vencimento,
			DATE_FORMAT(sublocacoes.data_ini_vigencia,'%d/%m/%Y') as data_ini_vigencia_br,
			DATE_FORMAT(sublocacoes.data_fim_vigencia,'%d/%m/%Y') as data_fim_vigencia_br,metragem,sublocacoes.valor_base,
			sublocacoes.status status_sub
			from sublocacoes
			left join loja
			on sublocacoes.id_loja = loja.id
			left join emitente on sublocacoes.id_emitente = emitente.id
			left join emitente em on em.id = loja.id_emitente
			left join receitas on sublocacoes.receita = receitas.id
			where sublocacoes.id_contratante = ?
			and loja.cidade  = ?
		    ORDER BY `em`.`nome_fantasia` ";

   $query = $this->db->query($sql, array($id_contratante,$municipio));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarSubLocacaoByReceita($id_contratante,$id,$receita ){
      $sql = "select 
				sublocacoes.id as idsub,
				em.nome_fantasia as locador,
				emitente.nome_fantasia as locatario,
				receitas_sublocacoes.numero_parcela,
				DATE_FORMAT(receitas_sublocacoes.data_vencimento,'%d/%m/%Y') as data_vencimento,
				DATE_FORMAT(receitas_sublocacoes.data_pagamento,'%d/%m/%Y') as data_pagamento,
				receitas_sublocacoes.status,
				receitas_sublocacoes.id as id_parcela,receitas_sublocacoes.valor_pago,sublocacoes.valor_base,sublocacoes.prazo
				from sublocacoes
				left join loja
				on sublocacoes.id_loja = loja.id
				left join emitente on sublocacoes.id_emitente = emitente.id
				left join emitente em on em.id = loja.id_emitente
				left join receitas on sublocacoes.receita = receitas.id
				left join receitas_sublocacoes on sublocacoes.id = receitas_sublocacoes.id_sublocacao
				where sublocacoes.id_contratante = ?
				and sublocacoes.id = ?
				and receitas_sublocacoes.id_receita = ?
				order by receitas_sublocacoes.numero_parcela
		     ";

   $query = $this->db->query($sql, array($id_contratante,$id,$receita));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarReceitas($id_contratante,$id){
      $sql = "select distinct receitas.id,receitas.descricao_receita
				 from sublocacoes left join receitas_sublocacoes on sublocacoes.id = receitas_sublocacoes.id_sublocacao
				left join receitas on receitas_sublocacoes.id_receita = receitas.id
				where sublocacoes.id_contratante = ?
				and sublocacoes.id = ?
				order by receitas.id,receitas_sublocacoes.numero_parcela
		     ";

   $query = $this->db->query($sql, array($id_contratante,$id));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function getTotalSublocacao($id,$primeiroDia,$ultimoDia){
      $sql = "select valor_pago,DATE_FORMAT(data,'%m-%Y') as data,id
			 from  receitas_sublocacoes_total where id_sublocacao = ? 
			 and data between ? and ?
		     ";

   $query = $this->db->query($sql, array($id,$primeiroDia,$ultimoDia));
	
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function listarReceitaTotaisAsc($id,$primeiroDia,$ultimoDia){
      $sql = "select  valor_pago  from receitas_sublocacoes_total
	  		where id_sublocacao = ? and data between ? and ?
			order by receitas_sublocacoes_total.data asc
		     ";

   $query = $this->db->query($sql, array($id,$primeiroDia,$ultimoDia));
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarReceitaTotais($id,$primeiroDia,$ultimoDia){
      $sql = "select  valor_pago  from receitas_sublocacoes_total
	  		where id_sublocacao = ? and data between ? and ?
			order by receitas_sublocacoes_total.data desc
		     ";

   $query = $this->db->query($sql, array($id,$primeiroDia,$ultimoDia));
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function listarReceitaSomaComposicaoAsc($id_contratante,$id,$primeiroDia,$ultimoDia){
      $sql = "select  COALESCE(round(sum(replace(REPLACE(receitas_sublocacoes.valor_pago, '.', ''),',','.')),2), 0) as soma
	  		from sublocacoes 
			left join receitas_sublocacoes on sublocacoes.id = receitas_sublocacoes.id_sublocacao
			left join receitas on receitas_sublocacoes.id_receita = receitas.id 
			where sublocacoes.id_contratante = ?
			and sublocacoes.id = ?
			and receitas_sublocacoes.data_vencimento between ? and ?
			group by receitas_sublocacoes.data_vencimento
			order by receitas_sublocacoes.data_vencimento asc

		     ";

   $query = $this->db->query($sql, array($id_contratante,$id,$primeiroDia,$ultimoDia));
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarReceitaSomaComposicao($id_contratante,$id,$primeiroDia,$ultimoDia){
      $sql = "select  COALESCE(round(sum(replace(REPLACE(receitas_sublocacoes.valor_pago, '.', ''),',','.')),2), 0) as soma
	  		from sublocacoes 
			left join receitas_sublocacoes on sublocacoes.id = receitas_sublocacoes.id_sublocacao
			left join receitas on receitas_sublocacoes.id_receita = receitas.id 
			where sublocacoes.id_contratante = ?
			and sublocacoes.id = ?
			and receitas_sublocacoes.data_vencimento between ? and ?
			group by receitas_sublocacoes.data_vencimento
			order by receitas_sublocacoes.data_vencimento desc

		     ";

   $query = $this->db->query($sql, array($id_contratante,$id,$primeiroDia,$ultimoDia));
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function listarReceitaAsc($id_contratante,$id,$receita,$primeiroDia,$ultimoDia){
      $sql = "select  DATE_FORMAT(receitas_sublocacoes.data_vencimento,'%m_%Y') as data_id,receitas.descricao_receita,receitas_sublocacoes.numero_parcela,
			DATE_FORMAT(receitas_sublocacoes.data_vencimento,'%d/%m/%Y') as data_vencimento, DATE_FORMAT(receitas_sublocacoes.data_pagamento,'%d/%m/%Y') as data_pagamento,
			receitas_sublocacoes.status,
			COALESCE(receitas_sublocacoes.valor_pago, 0) as valor_pago,
			receitas_sublocacoes.id_receita,receitas_sublocacoes.id as id_parcela
	  		from sublocacoes 
			left join receitas_sublocacoes on sublocacoes.id = receitas_sublocacoes.id_sublocacao
			left join receitas on receitas_sublocacoes.id_receita = receitas.id 
			where sublocacoes.id_contratante = ?
			and sublocacoes.id = ?
			and receitas_sublocacoes.id_receita = ?
			and receitas_sublocacoes.data_vencimento between ? and ?
			order by receitas_sublocacoes.numero_parcela asc
		     ";

   $query = $this->db->query($sql, array($id_contratante,$id,$receita,$primeiroDia,$ultimoDia));
	
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function listarReceita($id_contratante,$id,$receita,$primeiroDia,$ultimoDia){
      $sql = "select  DATE_FORMAT(receitas_sublocacoes.data_vencimento,'%m_%Y') as data_id,receitas.descricao_receita,receitas_sublocacoes.numero_parcela,
			DATE_FORMAT(receitas_sublocacoes.data_vencimento,'%d/%m/%Y') as data_vencimento, DATE_FORMAT(receitas_sublocacoes.data_pagamento,'%d/%m/%Y') as data_pagamento,
			receitas_sublocacoes.status,receitas_sublocacoes.valor_pago,receitas_sublocacoes.id_receita,receitas_sublocacoes.id as id_parcela
	  		from sublocacoes 
			left join receitas_sublocacoes on sublocacoes.id = receitas_sublocacoes.id_sublocacao
			left join receitas on receitas_sublocacoes.id_receita = receitas.id 
			where sublocacoes.id_contratante = ?
			and sublocacoes.id = ?
			and receitas_sublocacoes.id_receita = ?
			and receitas_sublocacoes.data_vencimento between ? and ?
			order by receitas_sublocacoes.data_vencimento desc

		     ";

   $query = $this->db->query($sql, array($id_contratante,$id,$receita,$primeiroDia,$ultimoDia));
	
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarDatas($id_contratante,$id,$receita){
      $sql = "select DATE_FORMAT(receitas_sublocacoes.data_vencimento,'%d/%m/%Y') as data_vencimento  from sublocacoes left join 
			receitas on sublocacoes.receita = receitas.id
			left join receitas_sublocacoes on sublocacoes.id = receitas_sublocacoes.id_sublocacao
			where sublocacoes.id_contratante = ?
			and sublocacoes.id = ?
			and sublocacoes.receita = ?
			order by receitas_sublocacoes.numero_parcela
		     ";

   $query = $this->db->query($sql, array($id_contratante,$id,$receita));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function buscaReceitasCadastradas($id ){
      $sql = "select max(id_receita) as maior_receita from receitas_sublocacoes r where r.id_sublocacao = ?   ";

   $query = $this->db->query($sql, array($id));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function listarMeses($id,$ultimoDia,$primeiroDia ){
      $sql = "select distinct DATE_FORMAT(receitas_sublocacoes.data_vencimento,'%m/%Y') as data_vencimento 
			  from receitas_sublocacoes where receitas_sublocacoes.id_sublocacao = ? 
			  and data_vencimento between ? and ? order by data_vencimento desc
		     ";

   $query = $this->db->query($sql, array($id,$ultimoDia,$primeiroDia));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
   function listarMesesAsc($id,$ultimoDia,$primeiroDia ){
      $sql = "select distinct DATE_FORMAT(receitas_sublocacoes.data_vencimento,'%m/%Y') as data_vencimento 
			  from receitas_sublocacoes where receitas_sublocacoes.id_sublocacao = ? 
			  and data_vencimento between ? and ? order by numero_parcela asc
		     ";

   $query = $this->db->query($sql, array($id,$ultimoDia,$primeiroDia));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function buscaEstado($idContratante){
      $sql = "SELECT distinct loja.estado from loja left join sublocacoes on loja.id = sublocacoes.id_loja
			 where sublocacoes.id_contratante = ? order by loja.estado";

   $query = $this->db->query($sql, array($idContratante));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function buscaCidades($idContratante){
      $sql = "SELECT distinct loja.cidade from loja left join sublocacoes on loja.id = sublocacoes.id_loja
			 where sublocacoes.id_contratante = ? order by loja.cidade";

   $query = $this->db->query($sql, array($idContratante));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarLojasComLocacao($idContratante){
      $sql = "SELECT distinct loja.id,emitente.nome_fantasia
 from loja left join sublocacoes on loja.id = sublocacoes.id_loja
 left join emitente on emitente.id = loja.id_emitente
  where sublocacoes.id_contratante = ? order by emitente.nome_fantasia";

   $query = $this->db->query($sql, array($idContratante));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function listarLojasComLocacaoById($id){
   $sql = "SELECT distinct loja.id,loja.cidade,loja.estado from loja left join sublocacoes on loja.id = sublocacoes.id_loja  where sublocacoes.id = ?";
   $query = $this->db->query($sql, array($id));
   $array = $query->result(); 
   return($array);
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 
function listarLojasById($id){
   $sql = "SELECT loja.cidade,loja.estado from loja  where loja.id = ?";
   $query = $this->db->query($sql, array($id));
   $array = $query->result(); 
   return($array);
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }

 
 function buscaCidade($idContratante,$id){
      $sql = "SELECT distinct loja.cidade from loja left join sublocacoes on loja.id = sublocacoes.id_loja
			 where loja.estado = ? and  sublocacoes.id_contratante = ? order by loja.cidade";

   $query = $this->db->query($sql, array($id,$idContratante));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function buscaSub($idContratante,$id){
      $sql = "SELECT distinct loja.id,emitente.nome_fantasia
				from loja left join sublocacoes on loja.id = sublocacoes.id_loja
				left join emitente on emitente.id = loja.id_emitente
				where sublocacoes.id_contratante = ?  and loja.estado = ? order by emitente.nome_fantasia";

   $query = $this->db->query($sql, array($idContratante,$id));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function buscaSubByMun($idContratante,$id){
      $sql = "SELECT distinct loja.id,emitente.nome_fantasia
				from loja left join sublocacoes on loja.id = sublocacoes.id_loja
				left join emitente on emitente.id = loja.id_emitente
				where sublocacoes.id_contratante = ?  and loja.cidade = ? order by emitente.nome_fantasia";

   $query = $this->db->query($sql, array($idContratante,$id));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarMesesSubLocacaoById($id,$ultimoDiaCorrente){
      $sql = "select distinct data_vencimento,DATE_FORMAT(receitas_sublocacoes.data_vencimento,'%d/%m/%Y') as mes_vencimento 
			  from receitas_sublocacoes where receitas_sublocacoes.id_sublocacao = ? 
			  and receitas_sublocacoes.data_vencimento <= ?
		     ";

   $query = $this->db->query($sql, array($id,$ultimoDiaCorrente));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function buscarTotal($mes,$idSubLoc){
      $sql = "select  COALESCE(valor_pago, 0) as valor_pago  from receitas_sublocacoes_total
				where data = ? and id_sublocacao = ? ";

   $query = $this->db->query($sql, array($mes,$idSubLoc));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function buscarValores($mes,$idSubLoc){
      $sql = "select  COALESCE(valor_pago, 0) as valor_pago,receitas_sublocacoes.id_receita as receita  from receitas_sublocacoes
				where data_vencimento = ?
				and id_sublocacao = ? order by id_receita
		     ";

   $query = $this->db->query($sql, array($mes,$idSubLoc));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }

 function guardarReceitasExistentesById($id){
      $sql = "select id,id_receita,id_sublocacao,data_vencimento from receitas_sublocacoes where receitas_sublocacoes.id_sublocacao = ? ";

   $query = $this->db->query($sql, array($id));

   $array = $query->result(); 
   return($array);


   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function atualizaTotais($dados,$id_sublocacao,$data){
	$this->db->where('id_sublocacao', $id_sublocacao);
	$this->db->where('data', $data);
  	$this->db->update('receitas_sublocacoes_total', $dados);
	return true;
 } 
 
  function listarTotaisAntigos($id){
   $sql = "select id_sublocacao,data,valor_pago from receitas_sublocacoes_total_backup 
			where receitas_sublocacoes_total_backup.id_antigo = ? 
			";
   $query = $this->db->query($sql, array($id));
   $array = $query->result(); 
   return($array);


   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function guardarTotaisExistentesById($id){
      $sql = "select id,data,id_sublocacao from receitas_sublocacoes_total where receitas_sublocacoes_total.id_sublocacao = ? ";

   $query = $this->db->query($sql, array($id));

   $array = $query->result(); 
   return($array);


   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
  function listarReceitasExistentesById($id){
      $sql = "select distinct id_receita from receitas_sublocacoes where receitas_sublocacoes.id_sublocacao = ? ";

   $query = $this->db->query($sql, array($id));

   $array = $query->result(); 
   return($array);


   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
   function listarReceitasAntigasExistentesById($id){
   $sql = "select id_receita,id_sublocacao,data_vencimento,data_pagamento,valor_pago,status from receitas_sublocacoes_backup 
			where receitas_sublocacoes_backup.id_antigo = ? 
			";
   $query = $this->db->query($sql, array($id));
   $array = $query->result(); 
   return($array);


   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 
  function copiarReceitasExistentesById($id){
   $sql = "insert into receitas_sublocacoes_backup (id_receita,id_sublocacao,id_antigo,numero_parcela,data_vencimento,data_pagamento,valor_pago,status)
			  select id_receita,id_sublocacao,id,numero_parcela,data_vencimento,data_pagamento,valor_pago,status
			  from receitas_sublocacoes where id_sublocacao = ? ";
	
   $query = $this->db->query($sql, array($id));
   $sql1 = "insert into receitas_sublocacoes_total_backup (id_sublocacao,id_antigo,data,valor_pago) select id_sublocacao,id,data,valor_pago from receitas_sublocacoes_total where id_sublocacao = ? 	";
   $query1 = $this->db->query($sql1, array($id));
   
   $sql2 = "delete from receitas_sublocacoes where id_sublocacao = ? ";
   $query = $this->db->query($sql2, array($id));
   
   $sql3 = "delete from receitas_sublocacoes_total where id_sublocacao = ? ";
   $query = $this->db->query($sql3, array($id));
   
 }
 
 
 function listarReceitasExistentes($id ){
      $sql = "select *,(select count(*) as tem
             from receitas_sublocacoes where receitas_sublocacoes.id_sublocacao = ? and receitas_sublocacoes.id_receita = receitas.id ) as tem from receitas
		     ";

   $query = $this->db->query($sql, array($id));

   $array = $query->result(); 
   return($array);


   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarTipoAluguelByLocacao($id ){
      $sql = "select distinct id_receita,receitas.descricao_receita
			  from receitas_sublocacoes left join receitas
			  on receitas_sublocacoes.id_receita = receitas.id
			  where id_sublocacao = ?
		     ";

   $query = $this->db->query($sql, array($id));

   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }

 function atualiza($dados,$id){
  	$this->db->where('id', $id);
  	$this->db->update('sublocacoes', $dados);
	return true;
 }
 
 function atualizaDados($dados,$id_receita,$id_sublocacao,$data_vencimento){
  	$this->db->where('id_receita', $id_receita);
	$this->db->where('id_sublocacao', $id_sublocacao);
	$this->db->where('data_vencimento', $data_vencimento);
  	$this->db->update('receitas_sublocacoes', $dados);
	return true;
 } 
 function listarSubLocacaoById($id_contratante,$id ){
      $sql = "select sublocacoes.id as idsub, em.nome_fantasia as locador, 
				emitente.nome_fantasia as locatario,
				sublocacoes.valor_base,sublocacoes.prazo,
				data_ini_vigencia,
				data_fim_vigencia,
				DATE_FORMAT(sublocacoes.data_ini_vigencia,'%d/%m/%Y') as data_ini_vigencia_br,
				DATE_FORMAT(sublocacoes.data_fim_vigencia,'%d/%m/%Y') as data_fim_vigencia_br,
				DATE_FORMAT(sublocacoes.data_vencimento,'%d/%m/%Y') as data_vencimento_br,
				metragem,atividade_sublocada,loja.estado,loja.cidade,
				loja.id as id_loja,emitente.id as id_emitente,	emitente.cpf_cnpj as cnpj
				 from sublocacoes
				left join loja on sublocacoes.id_loja = loja.id
				left join emitente on sublocacoes.id_emitente = emitente.id 
				left join emitente em on em.id = loja.id_emitente 
				where sublocacoes.id_contratante = ?
				and sublocacoes.id = ?
		     ";

   $query = $this->db->query($sql, array($id_contratante,$id));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function somarTodos($idContratante){
  $this -> db -> select('count(*) as total');
  $this -> db -> from('sublocacoes');
  $this -> db -> where('sublocacoes.id_contratante', $idContratante);   
 
  $query = $this -> db -> get();

   
  if($query -> num_rows() <> 0) {
     return $query->result();
  } else {
     return false;
  }
  }
  
 public function getProximaData($date,$dias) 	
	{		

	$q = $this->db->query("select date_add('{$date}', interval '{$dias}' month)  as ultima_data  ");		
	
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data = $row;
			}
				
			return $data;
		}
		  
	}	
 
   public function getNumeroSubLocacao($id) 	
	{		

	$q = $this->db->query("select id_sublocacao from receitas_sublocacoes where id='{$id}' ");		
	
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data = $row;
			}
				
			return $data;
		}
		  
	}	
	
  public function buscaEmitenteLoja($idContratante ,$emitente,$loja) 	
	{		

	$q = $this->db->query("select count(*) as total from sublocacoes where id_contratante='{$idContratante}' and id_loja='{$loja}' and id_emitente='{$emitente}' ");		
	
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data = $row;
			}
				
			return $data;
		}
		  
	}	
	
 function listarTipoAluguel(){
 
   $this -> db -> select('*');
   $this -> db -> from('receitas');
  
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 
 }
  function listarPrazo(){

   $this -> db -> select('*');
   $this -> db -> from('prazo');

   $query = $this -> db -> get();

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 function gravarTotalMes($dados,$id){

 

	$this->db->where('id', $id);

	$this->db->update('receitas_sublocacoes_total', $dados); 

	

	return true;

  

 } 
 
 function baixar($dados,$id){

 

	$this->db->where('id', $id);

	$this->db->update('receitas_sublocacoes', $dados); 

	

	return true;

  

 } 
  
 function baixar_parcela($dadosParcela,$id,$receita,$mes){

	$this->db->where('id_sublocacao', $id);
	$this->db->where('id_receita', $receita);
	$this->db->where('data_vencimento', $mes);

	$this->db->update('receitas_sublocacoes', $dadosParcela); 

	

	return true;

  

 }   
 
 function gravar_total($dadosParcela,$id,$mes){

	$this->db->where('id_sublocacao', $id);
	$this->db->where('data', $mes);

	$this->db->update('receitas_sublocacoes_total', $dadosParcela); 

	

	return true;

  

 }  
 
 public function add($detalhes = array()){

 	$this->db->insert('sublocacoes', $detalhes);
	$id = $this->db->insert_id();
	return $id;


 }

  public function addParcela($detalhes = array()){

 	$this->db->insert('receitas_sublocacoes', $detalhes);
	$id = $this->db->insert_id();
	return $id;


 }

 public function addTotalParcela($detalhes = array()){

 	$this->db->insert('receitas_sublocacoes_total', $detalhes);
	$id = $this->db->insert_id();
	return $id;


 }
	
}
?>

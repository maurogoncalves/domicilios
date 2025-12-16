<?php
Class Infracao_Vencida_model extends CI_Model{

  function listarInfracao($id_contratante,$_limit = 30, $_start = 0 ){
  	$data1 = date('Y-m-d');
	//$data1 = date('Y-m-d', strtotime("-45 days"));
	$data2 = date('Y-m-d', strtotime("-90 days"));
      $sql = "select 
				*,l.id as id_loja,e.cpf_cnpj,
				DATE_FORMAT(i.data_recebimento,'%d/%m/%Y') as data_recebimento_br,
				DATE_FORMAT(i.data_plan_fim_processo,'%d/%m/%Y') as data_plan_fim_processo_br,
				DATE_FORMAT(i.data_encerramento_real,'%d/%m/%Y') as data_encerramento_real_br,
				i.observacoes as obs_infracao,i.id as id_infracao,
				classif_infracao.descricao as desc_classif, auto_infracao.descricao as auto_desc
				from infracoes i
				left join loja l on i.id_loja = l.id
				left join emitente e on l.id_emitente = e.id
				left join classif_infracao on classif_infracao.id = i.id_classificacao
				left join auto_infracao on auto_infracao.id = i.id_auto
				where i.id_contratante = ?
				and data_recebimento < ?
				ORDER BY `e`.`nome_fantasia` 
				limit $_start,$_limit";

   $query = $this->db->query($sql, array($id_contratante,$data2));
   //print_r($this->db->last_query());exit;
   $array = $query->result();
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 
 
 function ativar($id){
 
	$data = array('ativo' => 1);

	$this->db->where('id', $id);
	$this->db->update('infracoes', $data); 
	
	return true;
  
 } 
 
 function buscaEstado($idContratante){
 $data1 = date('Y-m-d');
//$data1 = date('Y-m-d', strtotime("-45 days"));
 $data2 = date('Y-m-d', strtotime("-90 days"));
	
      $sql = "SELECT distinct loja.estado from loja  left join infracoes on loja.id = infracoes.id_loja 
			  where infracoes.id_contratante = ? and data_recebimento < ? order by loja.estado";

   $query = $this->db->query($sql, array($idContratante,$data2));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarLojasComInfra($idContratante){
 
  $data1 = date('Y-m-d');
//$data1 = date('Y-m-d', strtotime("-45 days"));
 $data2 = date('Y-m-d', strtotime("-90 days"));

 
      $sql = "SELECT distinct loja.id,emitente.nome_fantasia  from loja left join infracoes on loja.id = infracoes.id_loja
 left join emitente on emitente.id = loja.id_emitente  where infracoes.id_contratante = ? and data_recebimento < ? order by emitente.nome_fantasia";

   $query = $this->db->query($sql, array($idContratante,$data2));
   
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function buscaCidade($idContratante){
 
  $data1 = date('Y-m-d');
//$data1 = date('Y-m-d', strtotime("-45 days"));
 $data2 = date('Y-m-d', strtotime("-90 days"));

 
      $sql = "SELECT distinct loja.cidade from loja  left join infracoes on loja.id = infracoes.id_loja 
			  where infracoes.id_contratante = ? and data_recebimento <? order by loja.cidade";

   $query = $this->db->query($sql, array($idContratante,$data2));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function buscaCidadeById($idContratante,$id){
  
    $data1 = date('Y-m-d');
//$data1 = date('Y-m-d', strtotime("-45 days"));
 $data2 = date('Y-m-d', strtotime("-90 days"));
 
      $sql = "SELECT distinct loja.cidade from loja  left join infracoes on loja.id = infracoes.id_loja 
			  where infracoes.id_contratante = ? and loja.estado = ? and data_recebimento < ? order by loja.cidade";

   $query = $this->db->query($sql, array($idContratante,$id,$data2));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function excluir($id){
 
	$data = array('ativo' => 0);

	$this->db->where('id', $id);
	$this->db->update('infracoes', $data); 
	
	return true;
  
 }
  function listarTodasLojas($idContratante){
   $this -> db -> select('loja.id,emitente.nome_fantasia,emitente.cpf_cnpj');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.id_contratante', $idContratante);
   $this -> db -> order_by('emitente.nome_fantasia');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }
 }
 

 
 function listarRespByIdInfra($id){
      $sql = "select *,DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_br,posicionamento_resp.descricao as posicao,
				probabilidade_exito.descricao as probal,emitente.id as id_emitente,responsavel_infracao.id as id_resp
				from 
				responsavel_infracao 
				left join infracoes on responsavel_infracao.id_infracao = infracoes.id
				left join emitente on emitente.id = responsavel_infracao.id_emitente
				left join posicionamento_resp on posicionamento_resp.id = responsavel_infracao.posicao_resp
				left join probabilidade_exito on probabilidade_exito.id = responsavel_infracao.probabilidade_exito
				where id_infracao = ?";

   $query = $this->db->query($sql, array($id));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
  function listarRespById($id){
      $sql = "select *,DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_br,posicionamento_resp.descricao as posicao,
				probabilidade_exito.descricao as probal,emitente.id as id_emitente,responsavel_infracao.id as id_resp,
				bandeira.descricao_bandeira as bandeira,regional.descricao as regional
				from 
				responsavel_infracao 
				left join infracoes on responsavel_infracao.id_infracao = infracoes.id
				left join emitente on emitente.id = responsavel_infracao.id_emitente
				left join posicionamento_resp on posicionamento_resp.id = responsavel_infracao.posicao_resp
				left join probabilidade_exito on probabilidade_exito.id = responsavel_infracao.probabilidade_exito
				 left join loja on loja.id = infracoes.id_loja
				 left join emitente em on em.id = loja.id_emitente
				 left join bandeira on bandeira.id = loja.bandeira
				 left join regional on regional.id = loja.regional
				where responsavel_infracao.id = ?";

   $query = $this->db->query($sql, array($id));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarInfracaoByCidade($idContratante,$municipio){
 $data1 = date('Y-m-d');
 $data2 = date('Y-m-d', strtotime("-90 days"));
 
      $sql = "select 
				*,l.id as id_loja,e.cpf_cnpj,
				DATE_FORMAT(i.data_recebimento,'%d/%m/%Y') as data_recebimento_br,
				DATE_FORMAT(i.data_plan_fim_processo,'%d/%m/%Y') as data_plan_fim_processo_br,
				DATE_FORMAT(i.data_encerramento_real,'%d/%m/%Y') as data_encerramento_real_br,
				i.observacoes as obs_infracao,i.id as id_infracao,
				classif_infracao.descricao as desc_classif, auto_infracao.descricao as auto_desc 
				from infracoes i
				left join loja l on i.id_loja = l.id
				left join emitente e on l.id_emitente = e.id
				left join classif_infracao on classif_infracao.id = i.id_classificacao 
				left join auto_infracao on auto_infracao.id = i.id_auto 
				where l.cidade = ? and i.id_contratante = ? and data_recebimento < ?
		     ";

   $query = $this->db->query($sql, array($municipio,$idContratante,$data2));
   print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 
  function buscaInfraByCidade($idContratante,$cidade){
	 $data1 = date('Y-m-d');
	 $data2 = date('Y-m-d', strtotime("-90 days"));
	 
      $sql = "SELECT distinct loja.id,emitente.nome_fantasia  from loja left join infracoes on loja.id = infracoes.id_loja
 left join emitente on emitente.id = loja.id_emitente  where infracoes.id_contratante = ? and data_recebimento < ?  and loja.cidade = ? order by emitente.nome_fantasia";

   $query = $this->db->query($sql, array($idContratante,$data2,$cidade));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function buscaInfra($idContratante,$estado){
  $data1 = date('Y-m-d');
  //$data1 = date('Y-m-d', strtotime("-45 days"));
  $data2 = date('Y-m-d', strtotime("-90 days"));
 
  $sql = "SELECT distinct loja.id,emitente.nome_fantasia  from loja left join infracoes on loja.id = infracoes.id_loja
 left join emitente on emitente.id = loja.id_emitente  where infracoes.id_contratante = ? and loja.estado = ? and data_recebimento < ?  order by emitente.nome_fantasia";

   $query = $this->db->query($sql, array($idContratante,$estado,$data2));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarInfracaoByEstado($idContratante,$estado){
 $data1 = date('Y-m-d');
 $data2 = date('Y-m-d', strtotime("-90 days"));
      $sql = "select 
				*,l.id as id_loja,e.cpf_cnpj,
				DATE_FORMAT(i.data_recebimento,'%d/%m/%Y') as data_recebimento_br,
				DATE_FORMAT(i.data_plan_fim_processo,'%d/%m/%Y') as data_plan_fim_processo_br,
				DATE_FORMAT(i.data_encerramento_real,'%d/%m/%Y') as data_encerramento_real_br,
				i.observacoes as obs_infracao,i.id as id_infracao,
				classif_infracao.descricao as desc_classif, auto_infracao.descricao as auto_desc
				from infracoes i
				left join loja l on i.id_loja = l.id
				left join emitente e on l.id_emitente = e.id
				left join classif_infracao on classif_infracao.id = i.id_classificacao 
				left join auto_infracao on auto_infracao.id = i.id_auto 
				where l.estado = ? and i.id_contratante = ? and data_recebimento < ?
		     ";

   $query = $this->db->query($sql, array($estado,$idContratante,$data2));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function exportInfracaoByCidade($id ){
	
     $sql = "select
i.id as id_infracao,
e.nome_fantasia,e.cpf_cnpj,
i.cod_infracao,
DATE_FORMAT(i.data_recebimento,'%d/%m/%Y') as data_recebimento_br,
auto_infracao.descricao as desc_infracao,
classif_infracao.descricao as desc_classif,
motivo_infracao.descricao as desc_motivo,
i.relato_infracao,
dt_ini_competencia,
dt_fim_competencia,
valor_principal,
atualizacao_monetaria,
multa,
juros,
total,
valor_total_revisao,
valor_real_pago,
DATE_FORMAT(i.data_plan_fim_processo,'%d/%m/%Y') as data_plan_fim_processo_br,
DATE_FORMAT(i.data_encerramento_real,'%d/%m/%Y') as data_encerramento_real_br,
observacoes,
em.nome_fantasia as resp,
DATE_FORMAT(responsavel_infracao.data_envio,'%d/%m/%Y') as data_envio_br,
posicionamento_resp.descricao as desc_posic,
probabilidade_exito.descricao as desc_prob,
i.ativo
from infracoes i 
left join loja l on i.id_loja = l.id 
left join emitente e on l.id_emitente = e.id
left join responsavel_infracao on i.id = responsavel_infracao.id_infracao
left join probabilidade_exito on probabilidade_exito.id = responsavel_infracao.probabilidade_exito
left join posicionamento_resp on posicionamento_resp.id = responsavel_infracao.posicao_resp
left join auto_infracao on auto_infracao.id = i.id_auto
left join classif_infracao on classif_infracao.id = i.id_classificacao
left join motivo_infracao on motivo_infracao.id = i.motivo_infracao
left join emitente em on em.id = responsavel_infracao.id_emitente
				where l.cidade = ?
		     ";
   
   $query = $this->db->query($sql, array($id));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
   function excluir_resp($id){

	$this->db->where('id', $id);
	$this->db->delete('responsavel_infracao'); 

	return true;

 } 
 

 
 function exportInfracaoByEstado($id ){
	
     $sql = "select
i.id as id_infracao,
e.nome_fantasia,e.cpf_cnpj,
i.cod_infracao,
DATE_FORMAT(i.data_recebimento,'%d/%m/%Y') as data_recebimento_br,
auto_infracao.descricao as desc_infracao,
classif_infracao.descricao as desc_classif,
motivo_infracao.descricao as desc_motivo,
i.relato_infracao,
dt_ini_competencia,
dt_fim_competencia,
valor_principal,
atualizacao_monetaria,
multa,
juros,
total,
valor_total_revisao,
valor_real_pago,
DATE_FORMAT(i.data_plan_fim_processo,'%d/%m/%Y') as data_plan_fim_processo_br,
DATE_FORMAT(i.data_encerramento_real,'%d/%m/%Y') as data_encerramento_real_br,
observacoes,
em.nome_fantasia as resp,
DATE_FORMAT(responsavel_infracao.data_envio,'%d/%m/%Y') as data_envio_br,
posicionamento_resp.descricao as desc_posic,
probabilidade_exito.descricao as desc_prob,
i.ativo
from infracoes i 
left join loja l on i.id_loja = l.id 
left join emitente e on l.id_emitente = e.id
left join responsavel_infracao on i.id = responsavel_infracao.id_infracao
left join probabilidade_exito on probabilidade_exito.id = responsavel_infracao.probabilidade_exito
left join posicionamento_resp on posicionamento_resp.id = responsavel_infracao.posicao_resp
left join auto_infracao on auto_infracao.id = i.id_auto
left join classif_infracao on classif_infracao.id = i.id_classificacao
left join motivo_infracao on motivo_infracao.id = i.motivo_infracao
left join emitente em on em.id = responsavel_infracao.id_emitente
				where l.estado = ?
		     ";
   
   $query = $this->db->query($sql, array($id));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function exportInfracaoByIdLoja($id ){
	if($id == 0){
     $sql = "select
i.id as id_infracao,
e.nome_fantasia,e.cpf_cnpj,
i.cod_infracao,
DATE_FORMAT(i.data_recebimento,'%d/%m/%Y') as data_recebimento_br,
auto_infracao.descricao as desc_infracao,
classif_infracao.descricao as desc_classif,
motivo_infracao.descricao as desc_motivo,
i.relato_infracao,
dt_ini_competencia,
dt_fim_competencia,
valor_principal,
atualizacao_monetaria,
multa,
juros,
total,
valor_total_revisao,
valor_real_pago,
DATE_FORMAT(i.data_plan_fim_processo,'%d/%m/%Y') as data_plan_fim_processo_br,
DATE_FORMAT(i.data_encerramento_real,'%d/%m/%Y') as data_encerramento_real_br,
observacoes,
em.nome_fantasia as resp,
DATE_FORMAT(responsavel_infracao.data_envio,'%d/%m/%Y') as data_envio_br,
posicionamento_resp.descricao as desc_posic,
probabilidade_exito.descricao as desc_prob,
i.ativo
from infracoes i 
left join loja l on i.id_loja = l.id 
left join emitente e on l.id_emitente = e.id
left join responsavel_infracao on i.id = responsavel_infracao.id_infracao
left join probabilidade_exito on probabilidade_exito.id = responsavel_infracao.probabilidade_exito
left join posicionamento_resp on posicionamento_resp.id = responsavel_infracao.posicao_resp
left join auto_infracao on auto_infracao.id = i.id_auto
left join classif_infracao on classif_infracao.id = i.id_classificacao
left join motivo_infracao on motivo_infracao.id = i.motivo_infracao
left join emitente em on em.id = responsavel_infracao.id_emitente

		     ";
	}else{
     $sql = "select
i.id as id_infracao,
e.nome_fantasia,e.cpf_cnpj,
i.cod_infracao,
DATE_FORMAT(i.data_recebimento,'%d/%m/%Y') as data_recebimento_br,
auto_infracao.descricao as desc_infracao,
classif_infracao.descricao as desc_classif,
motivo_infracao.descricao as desc_motivo,
i.relato_infracao,
dt_ini_competencia,
dt_fim_competencia,
valor_principal,
atualizacao_monetaria,
multa,
juros,
total,
valor_total_revisao,
valor_real_pago,
DATE_FORMAT(i.data_plan_fim_processo,'%d/%m/%Y') as data_plan_fim_processo_br,
DATE_FORMAT(i.data_encerramento_real,'%d/%m/%Y') as data_encerramento_real_br,
observacoes,
em.nome_fantasia as resp,
DATE_FORMAT(responsavel_infracao.data_envio,'%d/%m/%Y') as data_envio_br,
posicionamento_resp.descricao as desc_posic,
probabilidade_exito.descricao as desc_prob,
i.ativo
from infracoes i 
left join loja l on i.id_loja = l.id 
left join emitente e on l.id_emitente = e.id
left join responsavel_infracao on i.id = responsavel_infracao.id_infracao
left join probabilidade_exito on probabilidade_exito.id = responsavel_infracao.probabilidade_exito
left join posicionamento_resp on posicionamento_resp.id = responsavel_infracao.posicao_resp
left join auto_infracao on auto_infracao.id = i.id_auto
left join classif_infracao on classif_infracao.id = i.id_classificacao
left join motivo_infracao on motivo_infracao.id = i.motivo_infracao
left join emitente em on em.id = responsavel_infracao.id_emitente
				where l.id = ?
		     ";
   }	

   $query = $this->db->query($sql, array($id));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarInfracaoByIdLoja($id ){

      $sql = "select 
				*,l.id as id_loja,e.cpf_cnpj,
				DATE_FORMAT(i.data_recebimento,'%d/%m/%Y') as data_recebimento_br,
				DATE_FORMAT(i.data_plan_fim_processo,'%d/%m/%Y') as data_plan_fim_processo_br,
				DATE_FORMAT(i.data_encerramento_real,'%d/%m/%Y') as data_encerramento_real_br,
				i.observacoes as obs_infracao,i.id as id_infracao,
				classif_infracao.descricao as desc_classif, auto_infracao.descricao as auto_desc 
				from infracoes i
				left join loja l on i.id_loja = l.id
				left join emitente e on l.id_emitente = e.id
				left join classif_infracao on classif_infracao.id = i.id_classificacao 
				left join auto_infracao on auto_infracao.id = i.id_auto 
				where l.id = ?
		     ";

   $query = $this->db->query($sql, array($id));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
 function listarInfracaoById($id ){
      $sql = "select 
				*,l.id as id_loja,e.cpf_cnpj,
				DATE_FORMAT(i.data_recebimento,'%d/%m/%Y') as data_recebimento_br,
				DATE_FORMAT(i.data_plan_fim_processo,'%d/%m/%Y') as data_plan_fim_processo_br,
				DATE_FORMAT(i.data_encerramento_real,'%d/%m/%Y') as data_encerramento_real_br,
				i.observacoes as obs_infracao,i.id as id_infracao,
				b.descricao_bandeira as bandeira,r.descricao as regional,
				classif_infracao.descricao as desc_classif, auto_infracao.descricao as auto_desc,
				motivo_infracao.descricao as desc_motivo
				from infracoes i
				left join loja l on i.id_loja = l.id
				left join emitente e on l.id_emitente = e.id
				left join bandeira b on b.id = l.bandeira
				left join regional r on r.id = l.regional
				left join classif_infracao on classif_infracao.id = i.id_classificacao 
				left join auto_infracao on auto_infracao.id = i.id_auto 
				left join motivo_infracao on motivo_infracao.id = i.motivo_infracao
				where i.id = ?
		     ";

   $query = $this->db->query($sql, array($id));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
   

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
 }
 
  function somarTodos($idContratante){
  $data2 = date('Y-m-d', strtotime("-90 days"));
  
  $this -> db -> select('count(*) as total');
  $this -> db -> from('infracoes');
  $this -> db -> where('infracoes.id_contratante', $idContratante);   
  $this -> db -> where('infracoes.data_recebimento <', $data2);  
 
  $query = $this -> db -> get();

   
  if($query -> num_rows() <> 0) {
     return $query->result();
  } else {
     return false;
  }
  }
  



	

  
 
 function listarTipoAuto(){

   $this -> db -> select('*');
   $this -> db -> from('auto_infracao');

   $query = $this -> db -> get();

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
  function buscaDadosLoja($id_contratante,$loja){
	$sql = "
	select e.cpf_cnpj,l.cod1,r.descricao as regional, b.descricao_bandeira as bandeira from loja l 
left join emitente e on l.id_emitente = e.id
left join bandeira b on b.id = l.bandeira
left join regional r on r.id = l.regional
	where l.id = ? and l.id_contratante = ?";
	$query = $this->db->query($sql, array($loja,$id_contratante));
	//print_r($this->db->last_query());exit;
	$array = $query->result(); 
	return($array);
   

 }
 
  function listarClassifInfra(){

   $this -> db -> select('*');
   $this -> db -> from('classif_infracao');

   $query = $this -> db -> get();

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }

  function listarPosicionamento(){

   $this -> db -> select('*');
   $this -> db -> from('posicionamento_resp');

   $query = $this -> db -> get();

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarProbabilidade(){

   $this -> db -> select('*');
   $this -> db -> from('probabilidade_exito');

   $query = $this -> db -> get();

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
  function listarMotivoInfra(){

   $this -> db -> select('*');
   $this -> db -> from('motivo_infracao');

   $query = $this -> db -> get();

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }


 function infracaoParada($idContratante){
	//$data = date ('Y-m-d');
	//$data2 = date ('Y-m-d');
	$data1 = date('Y-m-d');
	//$data1 = date('Y-m-d', strtotime("-45 days"));
	$data2 = date('Y-m-d', strtotime("-90 days"));
 
    $sql = " select count(*) as total from infracoes where id_contratante = ?  and data_recebimento between ? and ?";

   $query = $this->db->query($sql, array($idContratante,$data2,$data1));
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);
   
 }	
}
?>

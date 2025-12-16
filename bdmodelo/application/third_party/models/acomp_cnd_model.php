<?php
Class Acomp_Cnd_model extends CI_Model{

  function listar($id_contratante,$tipoAcomp ){
  if($tipoAcomp == 0){
  
  $sql = "select acomp_cnd.id as id_acomp, emitente.nome_fantasia,loja.cidade,loja.ins_cnd_mob, 
	areas_acomp_cnd.nome_area,
	etapa_sub_area.sigla as sigla_sub_area ,
	etapa_sub_area.nome as nome_etapa, acomp_cnd.tipo_debito,acomp_cnd.data_envio,acomp_cnd.sla,loja.id as id_loja  from acomp_cnd
left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
left join loja on loja.id = acomp_cnd.id_loja
left join emitente on loja.id_emitente = emitente.id 
			where acomp_cnd.id_contratante = ? ";
			$query = $this->db->query($sql, array($id_contratante));
			
  }else{
  
  $sql = "select acomp_cnd.id as id_acomp, emitente.nome_fantasia,loja.cidade,loja.ins_cnd_mob, 
	areas_acomp_cnd.nome_area,
	etapa_sub_area.sigla as sigla_sub_area ,
	etapa_sub_area.nome as nome_etapa, acomp_cnd.tipo_debito,acomp_cnd.data_envio,acomp_cnd.sla,loja.id as id_loja  from acomp_cnd
left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
left join loja on loja.id = acomp_cnd.id_loja
left join emitente on loja.id_emitente = emitente.id 
			where acomp_cnd.tipo_acomp = ? and acomp_cnd.id_contratante = ? limit $_start,$_limit";
			
			$query = $this->db->query($sql, array($tipoAcomp,$id_contratante));
			
  }
		  

   
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
 function listarProjetos($id_contratante,$_limit = 30, $_start = 0,$tipoAcomp ){
   $sql = "select * from projetos_acomp_cnd where projetos_acomp_cnd.id_contratante = ? limit $_start,$_limit";
   $query = $this->db->query($sql, array($id_contratante));  

   
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
  function buscaTodosEstados($id_contratante,$esfera){
  
   $sql = " select distinct estado from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id where loja.id_contratante = ? and acomp_cnd.tipo_acomp = ? order by loja.estado";
   $query = $this->db->query($sql, array($id_contratante,$esfera));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
   function listarCidadeByEstadoEsfera($id_contratante,$estado,$esfera){
   if($esfera == 0){
		$sql = " select distinct cidade from loja join acomp_cnd on acomp_cnd.id_loja = loja.id where loja.id_contratante = ? and loja.estado = ? order by loja.cidade";
		$query = $this->db->query($sql, array($id_contratante,$estado));	
   }else{
		$sql = " select distinct cidade from loja join acomp_cnd on acomp_cnd.id_loja = loja.id where loja.id_contratante = ? and loja.estado = ? and acomp_cnd.tipo_acomp = ? order by loja.cidade";
		$query = $this->db->query($sql, array($id_contratante,$estado,$esfera));
   }
   
   $array = $query->result(); //array of arrays
   return($array);

 }
 
 
  function buscaTodasCidades($id_contratante,$esfera){
  
   $sql = " select distinct cidade from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id where loja.id_contratante = ? and acomp_cnd.tipo_acomp = ? order by loja.cidade";
   $query = $this->db->query($sql, array($id_contratante,$esfera));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
   function buscarAreas(){
  
   $sql = " select nome_area from areas_acomp_cnd ";
   $query = $this->db->query($sql, array());
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
  function buscarSubArea($id){
  
   $sql = " select nome,sigla from etapa_sub_area where id_area = ? order by id_area,id_etapa ";
   $query = $this->db->query($sql, array($id));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
  function buscarSubAreas(){
  
   $sql = " select id_subarea,id_area,nome from subarea order by id_area,id_subarea ";
   $query = $this->db->query($sql, array());
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
 function buscarTipoDebitos(){
  
   $sql = " select id_subarea,nome from subarea order by id_area,id_subarea ";
   $query = $this->db->query($sql, array());
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 function buscaDados($id_contratante,$esfera){

  if($esfera == 0){
    $sql = "select loja.estado,loja.cidade,emitente.cpf_cnpj,loja.ins_cnd_mob,DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin,tipo_debito.descricao as tipo_deb_desc,acomp_cnd.sla,acomp_cnd.id_area,acomp_cnd.id_subarea,
		acomp_cnd.id_etapa,DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj	
		from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on emitente.id = loja.id_emitente  
		left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
		left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
		where loja.id_contratante = ?
		order by loja.estado ";
    $query = $this->db->query($sql, array($id_contratante));
  }else{
    $sql = "select loja.estado,loja.cidade,emitente.cpf_cnpj,loja.ins_cnd_mob,DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin,tipo_debito.descricao as tipo_deb_desc,acomp_cnd.sla,acomp_cnd.id_area,acomp_cnd.id_subarea,
		acomp_cnd.id_etapa,DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj	
		from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on emitente.id = loja.id_emitente  
		left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
		left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
		where acomp_cnd.tipo_acomp = ? and loja.id_contratante = ?
		order by loja.estado ";
    $query = $this->db->query($sql, array($esfera,$id_contratante));
   }
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
 function buscaDadosTipoDeb($id_contratante,$tipo,$esfera,$sub_area){
  if($esfera == 0){
     $sql = "select loja.estado,loja.cidade,emitente.cpf_cnpj,loja.ins_cnd_mob,DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin,tipo_debito.descricao as tipo_deb_desc,acomp_cnd.sla,acomp_cnd.id_area,acomp_cnd.id_subarea,
		acomp_cnd.id_etapa,DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj	
		from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on emitente.id = loja.id_emitente  
		left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
		left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
		where loja.id_contratante = ? and acomp_cnd.id_subarea = ? and acomp_cnd.tipo_debito = ?
		order by loja.estado ";
   $query = $this->db->query($sql, array($id_contratante,$sub_area,$tipo));
  }else{
     $sql = "select loja.estado,loja.cidade,emitente.cpf_cnpj,loja.ins_cnd_mob,DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin,tipo_debito.descricao as tipo_deb_desc,acomp_cnd.sla,acomp_cnd.id_area,acomp_cnd.id_subarea,
		acomp_cnd.id_etapa,DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj	
		from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on emitente.id = loja.id_emitente  
		left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
		left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
		where acomp_cnd.tipo_acomp = ? and loja.id_contratante = ? and acomp_cnd.id_subarea= ? and acomp_cnd.tipo_debito = ?
		order by loja.estado ";
   $query = $this->db->query($sql, array($esfera,$id_contratante,$sub_area,$tipo));
  }

   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
 function buscaDadosArea($id_contratante,$area,$esfera){
  if($esfera == 0){
     $sql = "select loja.estado,loja.cidade,emitente.cpf_cnpj,loja.ins_cnd_mob,DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin,tipo_debito.descricao as tipo_deb_desc,acomp_cnd.sla,acomp_cnd.id_area,acomp_cnd.id_subarea,
		acomp_cnd.id_etapa,DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj	
		from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on emitente.id = loja.id_emitente  
		left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
		left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
		where loja.id_contratante = ? and acomp_cnd.id_subarea = ?
		order by loja.estado ";
   $query = $this->db->query($sql, array($id_contratante,$area));
  }else{
     $sql = "select loja.estado,loja.cidade,emitente.cpf_cnpj,loja.ins_cnd_mob,DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin,tipo_debito.descricao as tipo_deb_desc,acomp_cnd.sla,acomp_cnd.id_area,acomp_cnd.id_subarea,
		acomp_cnd.id_etapa,DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj	
		from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on emitente.id = loja.id_emitente  
		left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
		left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
		where acomp_cnd.tipo_acomp = ? and loja.id_contratante = ? and acomp_cnd.id_subarea= ?
		order by loja.estado ";
   $query = $this->db->query($sql, array($esfera,$id_contratante,$area));
  }

   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
 function buscaDadosMunicipio($id_contratante,$esfera,$municipio){
  if($esfera == 0){
     $sql = "select loja.estado,loja.cidade,emitente.cpf_cnpj,loja.ins_cnd_mob,DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin,tipo_debito.descricao as tipo_deb_desc,acomp_cnd.sla,acomp_cnd.id_area,acomp_cnd.id_subarea,
		acomp_cnd.id_etapa,DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj	
		from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on emitente.id = loja.id_emitente  
		left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
		left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
		where loja.id_contratante = ? and loja.cidade = ?
		order by loja.estado ";
   $query = $this->db->query($sql, array($id_contratante,$municipio));
  }else{
     $sql = "select loja.estado,loja.cidade,emitente.cpf_cnpj,loja.ins_cnd_mob,DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin,tipo_debito.descricao as tipo_deb_desc,acomp_cnd.sla,acomp_cnd.id_area,acomp_cnd.id_subarea,
		acomp_cnd.id_etapa,DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj	
		from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on emitente.id = loja.id_emitente  
		left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
		left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
		where acomp_cnd.tipo_acomp = ? and loja.id_contratante = ? and loja.cidade = ?
		order by loja.estado ";
   $query = $this->db->query($sql, array($esfera,$id_contratante,$municipio));
  }

   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
  function buscaDadosEstado($id_contratante,$esfera,$estado){
  if($esfera == 0){
     $sql = "select loja.estado,loja.cidade,emitente.cpf_cnpj,loja.ins_cnd_mob,DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin,tipo_debito.descricao as tipo_deb_desc,acomp_cnd.sla,acomp_cnd.id_area,acomp_cnd.id_subarea,
		acomp_cnd.id_etapa,DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj	
		from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on emitente.id = loja.id_emitente  
		left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
		left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
		where loja.id_contratante = ? and loja.estado = ?
		order by loja.estado ";
   $query = $this->db->query($sql, array($id_contratante,$estado));
  }else{
     $sql = "select loja.estado,loja.cidade,emitente.cpf_cnpj,loja.ins_cnd_mob,DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin,tipo_debito.descricao as tipo_deb_desc,acomp_cnd.sla,acomp_cnd.id_area,acomp_cnd.id_subarea,
		acomp_cnd.id_etapa,DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj	
		from loja  join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on emitente.id = loja.id_emitente  
		left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
		left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
		where acomp_cnd.tipo_acomp = ? and loja.id_contratante = ? and loja.estado = ?
		order by loja.estado ";
   $query = $this->db->query($sql, array($esfera,$id_contratante,$estado));
  }

   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
 function listarExpIdCidadeEstado($idContratante,$algo,$id){
   if($algo == '0'){
   $sql = "select acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,
loja.cidade,loja.estado,loja.ins_cnd_mob,emitente.cpf_cnpj, areas_acomp_cnd.nome_area	, etapa_sub_area.sigla as sigla_sub_area,
etapa_sub_area.nome as nome_etapa, tipo_debito.descricao as tipo_debito,
DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	, 
DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,
tipo_acomp.descricao,acomp_cnd.sla,acomp_cnd.obs,subarea.nome as subarea
from acomp_cnd 
left join subarea on subarea.id_subarea = acomp_cnd.id_subarea 
left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area 
left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
left join loja on loja.id = acomp_cnd.id_loja 
left join emitente on loja.id_emitente = emitente.id 
left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id  
left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito  
where acomp_cnd.id_contratante = ?  ";

   $query = $this->db->query($sql, array($idContratante,$id));
   }else if($algo == '1'){
   $sql = "select acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,
loja.cidade,loja.estado,loja.ins_cnd_mob,emitente.cpf_cnpj, areas_acomp_cnd.nome_area	, etapa_sub_area.sigla as sigla_sub_area,
etapa_sub_area.nome as nome_etapa, tipo_debito.descricao as tipo_debito,
DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	, 
DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,
tipo_acomp.descricao,acomp_cnd.sla,acomp_cnd.obs,subarea.nome as subarea
from acomp_cnd 
left join subarea on subarea.id_subarea = acomp_cnd.id_subarea 
left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area 
left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
left join loja on loja.id = acomp_cnd.id_loja 
left join emitente on loja.id_emitente = emitente.id 
left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito  
left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id  where 
				acomp_cnd.id_contratante = ? and acomp_cnd.id = ? ";

   $query = $this->db->query($sql, array($idContratante,$id));
   }else if($algo == '2'){
      $sql = "select acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,
loja.cidade,loja.estado,loja.ins_cnd_mob,emitente.cpf_cnpj, areas_acomp_cnd.nome_area	, etapa_sub_area.sigla as sigla_sub_area,
etapa_sub_area.nome as nome_etapa, tipo_debito.descricao as tipo_debito,
DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	, 
DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,
tipo_acomp.descricao,acomp_cnd.sla,acomp_cnd.obs,subarea.nome as subarea
from acomp_cnd 
left join subarea on subarea.id_subarea = acomp_cnd.id_subarea 
left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area 
left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
left join loja on loja.id = acomp_cnd.id_loja 
left join emitente on loja.id_emitente = emitente.id 
left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito  
left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id  where 
				acomp_cnd.id_contratante = ? and loja.estado = ? ";

   $query = $this->db->query($sql, array($idContratante,$id));
   }else if($algo == '3'){
      $sql = "select acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,
loja.cidade,loja.estado,loja.ins_cnd_mob,emitente.cpf_cnpj, areas_acomp_cnd.nome_area	, etapa_sub_area.sigla as sigla_sub_area,
etapa_sub_area.nome as nome_etapa, tipo_debito.descricao as tipo_debito,
DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	, 
DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,
tipo_acomp.descricao,acomp_cnd.sla,acomp_cnd.obs,subarea.nome as subarea
from acomp_cnd 
left join subarea on subarea.id_subarea = acomp_cnd.id_subarea 
left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area 
left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
left join loja on loja.id = acomp_cnd.id_loja 
left join emitente on loja.id_emitente = emitente.id 
left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito 
left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id where 
				acomp_cnd.id_contratante = ? and loja.cidade = ? ";

   $query = $this->db->query($sql, array($idContratante,$id));
   }
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
   function listarIdCidadeEstado($idContratante,$algo,$id){
   if($algo == '1'){
   $sql = "select acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,loja.cidade,loja.estado,loja.id as id_loja,loja.ins_cnd_mob, 
				areas_acomp_cnd.id as id_area,etapa_sub_area.sigla as sigla_sub_area,etapa_sub_area.nome as nome_etapa, acomp_cnd.tipo_debito,acomp_cnd.data_envio,acomp_cnd.sla,emitente.cpf_cnpj,
				DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	,
				DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,acomp_cnd.tipo_acomp,acomp_cnd.obs,acomp_cnd.id_subarea,acomp_cnd.id_etapa,areas_acomp_cnd.nome_area,acomp_cnd.id_subarea,acomp_cnd.id_etapa,tipo_acomp.descricao				
				from acomp_cnd left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
				left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
				left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
				left join loja on loja.id = acomp_cnd.id_loja
				left join emitente on loja.id_emitente = emitente.id  
				left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id
				where acomp_cnd.id_contratante = ? and acomp_cnd.id = ? ";

   $query = $this->db->query($sql, array($idContratante,$id));
   }else if($algo == '2'){
      $sql = "select acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,loja.cidade,loja.estado,loja.id as id_loja,loja.ins_cnd_mob, 
				areas_acomp_cnd.id as id_area,etapa_sub_area.sigla as sigla_sub_area,etapa_sub_area.nome as nome_etapa, acomp_cnd.tipo_debito,acomp_cnd.data_envio,acomp_cnd.sla,emitente.cpf_cnpj,
				DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	,
				DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,acomp_cnd.tipo_acomp,acomp_cnd.obs,acomp_cnd.id_subarea,acomp_cnd.id_etapa,areas_acomp_cnd.nome_area,acomp_cnd.id_subarea,acomp_cnd.id_etapa,tipo_acomp.descricao					
				from acomp_cnd left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
				left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
				left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
				left join loja on loja.id = acomp_cnd.id_loja
				left join emitente on loja.id_emitente = emitente.id  
				left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id
				where acomp_cnd.id_contratante = ? and loja.estado = ? ";

   $query = $this->db->query($sql, array($idContratante,$id));
   }else if($algo == '3'){
      $sql = "select acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,loja.cidade,loja.estado,loja.id as id_loja,loja.ins_cnd_mob, 
				areas_acomp_cnd.id as id_area,etapa_sub_area.sigla as sigla_sub_area,etapa_sub_area.nome as nome_etapa, acomp_cnd.tipo_debito,acomp_cnd.data_envio,acomp_cnd.sla,emitente.cpf_cnpj,
				DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	,
				DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,acomp_cnd.tipo_acomp,acomp_cnd.obs,acomp_cnd.id_subarea,acomp_cnd.id_etapa,areas_acomp_cnd.nome_area,acomp_cnd.id_subarea,acomp_cnd.id_etapa,tipo_acomp.descricao						
				from acomp_cnd left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
				left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
				left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
				left join loja on loja.id = acomp_cnd.id_loja
				left join emitente on loja.id_emitente = emitente.id  
				left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id
				where acomp_cnd.id_contratante = ? and loja.cidade = ? ";

   $query = $this->db->query($sql, array($idContratante,$id));
   }else{
      $sql = "select acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,loja.cidade,loja.estado,loja.id as id_loja,loja.ins_cnd_mob, 
				areas_acomp_cnd.id as id_area,etapa_sub_area.sigla as sigla_sub_area,etapa_sub_area.nome as nome_etapa, acomp_cnd.tipo_debito,acomp_cnd.data_envio,acomp_cnd.sla,emitente.cpf_cnpj,
				DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	,
				DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,acomp_cnd.tipo_acomp,acomp_cnd.obs,acomp_cnd.id_subarea,acomp_cnd.id_etapa,areas_acomp_cnd.nome_area,acomp_cnd.id_subarea,acomp_cnd.id_etapa,tipo_acomp.descricao					
				from acomp_cnd left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
				left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
				left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
				left join loja on loja.id = acomp_cnd.id_loja
				left join emitente on loja.id_emitente = emitente.id  
				left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id
				where acomp_cnd.id_contratante = ? and acomp_cnd.id = ? ";

   $query = $this->db->query($sql, array($idContratante,$id));
   }
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
  function listarCidade($idContratante,$estado){
  
  if($estado <> 'X'){
	  $sql = "select distinct loja.cidade as cidade
			from acomp_cnd left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
			left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
			left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
			left join loja on loja.id = acomp_cnd.id_loja
			left join emitente on loja.id_emitente = emitente.id  
			where loja.id_contratante = ?  and loja.estado = ?";	   
	   $query = $this->db->query($sql, array($idContratante,$estado));
   }else{
	
    $sql = "select distinct loja.cidade as cidade
		from acomp_cnd left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
		left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
		left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
		left join loja on loja.id = acomp_cnd.id_loja
		left join emitente on loja.id_emitente = emitente.id  
		where loja.id_contratante = ?";
	$query = $this->db->query($sql, array($idContratante));
   }
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
 
 function listarEstado($idContratante){
  $sql = "select distinct loja.estado as estado
		from acomp_cnd left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
		left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
		left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
		left join loja on loja.id = acomp_cnd.id_loja
		left join emitente on loja.id_emitente = emitente.id  
		where loja.id_contratante = ?";
   
   $query = $this->db->query($sql, array($idContratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
  function calcularSLA($dtini){
  $sql = "SELECT DATEDIFF(now(),?) as dias";
   
   $query = $this->db->query($sql, array($dtini));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 function listarTodasLojas($idContratante,$cidade){
 if($cidade == 'X'){
  $sql = "select distinct acomp_cnd.id,nome_fantasia from loja 
			left join acomp_cnd on acomp_cnd.id_loja = loja.id 
			left join emitente on loja.id_emitente = emitente.id
			where loja.id_contratante = ?  order by loja.cidade
		";
   
   $query = $this->db->query($sql, array($idContratante));
 }else{
  $sql = "select distinct acomp_cnd.id,nome_fantasia from loja 
		left join acomp_cnd on acomp_cnd.id_loja = loja.id 
		left join emitente on loja.id_emitente = emitente.id
		where loja.id_contratante = ? and loja.cidade = ? order by loja.cidade
		";
   
   $query = $this->db->query($sql, array($idContratante,$cidade));
 } 
   
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 function listarAreas(){
   $this -> db -> select('*');
   $this -> db -> from('areas_acomp_cnd');
 
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
 
  function listarNomeProjetos($idContratante){
  $sql = "select id,descricao from projetos_acomp_cnd where id_contratante = ?";
   
   $query = $this->db->query($sql, array($idContratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
 }
 function verificarNomeProjeto($nome,$idContratante){
   $sql = "select count(*) as total from projetos_acomp_cnd where descricao = ? and id_contratante = ?";
   
   $query = $this->db->query($sql, array($nome,$idContratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
 }
 
 
  function buscarProjeto($id){
   $sql = "select * from projetos_acomp_cnd where id = ? ";
   
   $query = $this->db->query($sql, array($id));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
 }
 
 function listarTipoAcomp(){
   $this -> db -> select('*');
   $this -> db -> from('tipo_acomp');
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
  public function add($detalhes = array()){
 
	if($this->db->insert('acomp_cnd', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}
 
   public function add_proj($detalhes = array()){
 
	if($this->db->insert('projetos_acomp_cnd', $detalhes)) {
		//print_r($this->db->last_query());exit;
		return $id = $this->db->insert_id();
	}
	
	return false;
	}
  function listarSubArea($area){
   $this -> db -> select('*');
   $this -> db -> from('subarea');
   if($area <> 0){
	$this -> db -> where('subarea.id_area', $area);   
   }	
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
   function listarEtapa($area){
   $this -> db -> select('*');
   $this -> db -> from('etapa_sub_area');
   if($area <> 0){
	$this -> db -> where('etapa_sub_area.id_area', $area);   
   }	
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 function tipoDebito($area){
   $this -> db -> select('*');
   $this -> db -> from('tipo_debito');
   if($area <> 0){
	$this -> db -> where('tipo_debito.id_area', $area);   
   }	
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }

   function buscaCPFCNPJ($emitente,$idContratante){

   $sql = "select emitente.cpf_cnpj,loja.ins_cnd_mob  from loja left join emitente on loja.id_emitente = emitente.id 
			where emitente.id = ? and loja.id_contratante = ?";

   $query = $this->db->query($sql, array($emitente,$idContratante));
   $array = $query->result(); //array of arrays
   return($array);
   
   
 }
 
  function somarTodos($idContratante){
 
   $this -> db -> select('count(*) as total');
   $this -> db -> from('acomp_cnd');
   $this -> db -> where('id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
   
 }
  function somarTodosProjetos($idContratante){
 
   $this -> db -> select('count(*) as total');
   $this -> db -> from('projetos_acomp_cnd');
   $this -> db -> where('id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
   
 }
  
 function atualizar($dados,$id){ 
	$this->db->where('id', $id);
	$this->db->update('acomp_cnd', $dados); 
	//print_r($this->db->last_query());exit;	
	return true;  
 } 
 
  function atualiza_proj($dados,$id){ 
	$this->db->where('id', $id);
	$this->db->update('projetos_acomp_cnd', $dados); 
	//print_r($this->db->last_query());exit;	
	return true;  
 } 
}
?>
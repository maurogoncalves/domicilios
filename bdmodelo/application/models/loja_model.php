<?php
Class Loja_model extends CI_Model{
	
  function excluirFisicamente($id){

	$this->db->where('id', $id);
	$this->db->delete('loja'); 
	return true;

 } 
 
  function listarLoja($id_contratante,$_limit = 30, $_start = 0,$cidade,$estado ){
   if($cidade){
   $sql = "SELECT `loja`.*, `emitente`.`nome_fantasia` as razao_social, `emitente`.`cpf_cnpj`, `tipo_emitente`.`descricao`, `emitente`.`nome_resp`, `possui_cnd` as cnd, `cnd_mobiliaria`.`id` as id_cnd, `bandeira`.`descricao_bandeira` as bandeira, `cnd_mobiliaria`.`data_vencto`, `cnd_mobiliaria`.`data_pendencias` FROM (`loja`) JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente`
 JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
  LEFT JOIN `cnd_mobiliaria` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`
  WHERE `loja`.`id_contratante` = ?
  AND (`emitente`.`tipo_emitente` = 2  OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) 
  and `loja`.`cidade` = ? and `loja`.`estado` = ?
 ORDER BY `emitente`.`nome_fantasia` limit $_start,$_limit ";
 $query = $this->db->query($sql, array($id_contratante,$cidade,$estado));

   }else{
   $sql = "SELECT `loja`.*, `emitente`.`nome_fantasia` as razao_social, `emitente`.`cpf_cnpj`, `tipo_emitente`.`descricao`, `emitente`.`nome_resp`, `possui_cnd` as cnd, `cnd_mobiliaria`.`id` as id_cnd, `bandeira`.`descricao_bandeira` as bandeira, `cnd_mobiliaria`.`data_vencto`, `cnd_mobiliaria`.`data_pendencias` FROM (`loja`) JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente`
 JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
  LEFT JOIN `cnd_mobiliaria` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`
  WHERE `loja`.`id_contratante` = ?
  AND (`emitente`.`tipo_emitente` = 2  OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) 
 ORDER BY `emitente`.`nome_fantasia` limit $_start,$_limit";
 $query = $this->db->query($sql, array($id_contratante));

   }
      
   
   
   $array = $query->result(); 
   
   return($array);
   

 }
 
 function buscaCNDEstById($id_loja){
    $sql = "SELECT  id,possui_cnd from cnd_estadual where id_loja = ? ";

   $query = $this->db->query($sql, array($id_loja));
   
   $array = $query->result_array(); 
   return($array);
   
   $query = $this -> db -> get();
	
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
  function buscaCNDEstByIdCSV($id_loja){
    $sql = "SELECT  id,possui_cnd,inscricao from cnd_estadual where id_loja = ? ";

   $query = $this->db->query($sql, array($id_loja));
   
   $array = $query->result_array(); 
   return($array);
   


 }
 
  function buscaCNDMobById($id_loja){
    $sql = "SELECT  count(*)as total,id,possui_cnd,data_vencto,data_pendencias from cnd_mobiliaria where id_loja = ? ";

   $query = $this->db->query($sql, array($id_loja));
   
   $array = $query->result_array(); 
   return($array);
   


 }
  function listarTodasLoja($id_contratante,$cidade,$estado ){
   $sql = "SELECT 
   `loja`.*, `emitente`.`nome_fantasia` as razao_social, `emitente`.`cpf_cnpj`, 
   `tipo_emitente`.`descricao`, `emitente`.`nome_resp`, 
   `bandeira`.`descricao_bandeira` as bandeira
   FROM (`loja`) 
   LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
   LEFT JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente`
  LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
  WHERE `loja`.`id_contratante` = ?  
 ORDER BY `emitente`.`nome_fantasia` ";
 $query = $this->db->query($sql, array($id_contratante));
      
   
   $array = $query->result(); 
   
   return($array);
   

 }
 
 function listarTipo(){
   $sql = "SELECT nome,pagina from modulos where pai=6   ";
   $query = $this->db->query($sql, array());         
   $array = $query->result();    
   return($array);
   
 }
 
 function listarCND($id_contratante,$tabela,$status,$loja){
	 $sql="SELECT *, $tabela.`ativo` as status_insc, $tabela.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`,'$tabela' as modulo
			FROM ($tabela) 
			left JOIN `loja` ON $tabela.`id_loja` = `loja`.`id` 
			left JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			WHERE 
			$tabela.`id_contratante` = '$id_contratante' ";
			
	 if($loja <> 0){
		 $sql .= "AND `loja`.`id` in ($loja)  ";
	 }
	 if($status <> 0){
		 $sql .= "AND $tabela.`possui_cnd` in ($status) ";
	 }
	 $sql .= " ORDER BY `emitente`.`nome_fantasia` ;";			
	
	 $query = $this->db->query($sql, array());	
	  
	 $array = $query->result();    
	  return($array);
 }
 
  function listarContarCND($id_contratante,$tabela,$id_loja){
	 $sql="SELECT count(*) as total
			FROM ($tabela) 
			WHERE 
			$tabela.`id_contratante` = '$id_contratante'  ";
			
		
	
	 $query = $this->db->query($sql, array());	
	 $array = $query->result();    
	  return($array);
 }
 
  function listarContarCNDDias($id_contratante,$tabela,$id_loja,$dias){
	  if($dias == 30){
		  $data1 = date('Y-m-d') ;  
		  $data1 = date('Y-m-d', strtotime("+11 days",strtotime($data1))); 
	  }else{
		$data1 = date('Y-m-d') ;  
	  }
	  
	  $data2 = date('Y-m-d', strtotime("+".$dias." days",strtotime($data1))); 
	  
	   $sql="SELECT count(*) as total
			FROM ($tabela) 
			WHERE 
			$tabela.`id_contratante` = '$id_contratante' 
			and data_vencto between '$data1' and '$data2'
			and $tabela.possui_cnd <> 3";
		
	
	 $query = $this->db->query($sql, array());	
	 $array = $query->result();    
	  return($array);
 }
 
  function listarContarCNDDiasByLojga($id_contratante,$tabela,$id_loja,$dias){
	  if($dias == 30){
		  $data1 = date('Y-m-d') ;  
		  $data1 = date('Y-m-d', strtotime("+11 days",strtotime($data1))); 
	  }else{
		$data1 = date('Y-m-d') ;  
	  }
	  
	  $data2 = date('Y-m-d', strtotime("+".$dias." days",strtotime($data1))); 
	  
	   $sql="SELECT count(*) as total
			FROM ($tabela) 
			WHERE 
			$tabela.`id_contratante` = '$id_contratante' 
			and data_vencto between '$data1' and '$data2'
			and $tabela.possui_cnd <> 3 and $tabela.id_loja = $id_loja";
		
	
	 $query = $this->db->query($sql, array());	
	 $array = $query->result();    
	  return($array);
 }
 
  function listarContarCNDVencidas($id_contratante,$tabela,$id_loja,$dias){
	  
	  $data1 = date('Y-m-d') ;
	  $data2 = date('Y-m-d', strtotime("+".$dias." days",strtotime($data1))); 
	  
	   $sql="SELECT count(*) as total
			FROM ($tabela) 
			WHERE 
			$tabela.`id_contratante` = '$id_contratante' and data_vencto <= '$data1' and possui_cnd <> 3";
	  	  
			
			
		
	
	 $query = $this->db->query($sql, array());	
	
	 $array = $query->result();    
	  return($array);
 }
 
  function listarContarCNDVencidasByLoja($id_contratante,$tabela,$id_loja,$dias){
	  
	  $data1 = date('Y-m-d') ;
	  $data2 = date('Y-m-d', strtotime("+".$dias." days",strtotime($data1))); 
	  
	   $sql="SELECT count(*) as total
			FROM ($tabela) 
			WHERE 
			$tabela.`id_contratante` = '$id_contratante' and data_vencto <= '$data1' and possui_cnd <> 3 and $tabela.id_loja =$id_loja";
	  	  
			
			
		
	
	 $query = $this->db->query($sql, array());	
	
	 $array = $query->result();    
	  return($array);
 }
 function listarEstadoByStatus($id_contratante,$status){
	 
   	 
   $sql = "SELECT distinct estado as uf FROM (`loja`)  WHERE `loja`.`id_contratante` = ?
          AND loja.id not in (select id_loja from cnd_mobiliaria where cnd_mobiliaria.id_contratante = ?) ";
   $query = $this->db->query($sql, array($id_contratante,$id_contratante));
      
   
   $array = $query->result(); 
   
   return($array);
   

 }
 
  function listarCidadeByStatus($id_contratante,$status){
	 
   	 
   $sql = "SELECT distinct cidade as cidade FROM (`loja`)  WHERE `loja`.`id_contratante` = ?
          AND loja.id not in (select id_loja from cnd_mobiliaria where cnd_mobiliaria.id_contratante = ?) ";
   $query = $this->db->query($sql, array($id_contratante,$id_contratante));
      
   
   $array = $query->result(); 
   
   return($array);
   

 }
 
 
  function listarTodasLojasByStatus($id_contratante ){
   $sql = "SELECT `loja`.*, `emitente`.`nome_fantasia` as razao_social, `emitente`.`cpf_cnpj`, `tipo_emitente`.`descricao`, `emitente`.`nome_resp`, 0 as cnd, 0 as id_cnd, `bandeira`.`descricao_bandeira` as bandeira, '0000-00-00' as data_vencto, '0000-00-00' as data_pendencias  
   FROM (`loja`) 
   LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
   LEFT JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente`
  LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
  WHERE `loja`.`id_contratante` = ?
  AND (`emitente`.`tipo_emitente` = 2  OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) 
  and loja.id not in (select id_loja from cnd_mobiliaria where cnd_mobiliaria.id_contratante = ?) 
 ORDER BY `emitente`.`nome_fantasia` ";
 $query = $this->db->query($sql, array($id_contratante,$id_contratante));
      
   
   $array = $query->result(); 
   
   return($array);
   

 }
 
 function listarAcomp($idContratante,$id){
$sql = "select loja.id as id_loja,emitente.nome_fantasia,emitente.cpf_cnpj,acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,loja.cidade,loja.ins_cnd_mob, 
				areas_acomp_cnd.id as id_area,etapa_sub_area.sigla as sigla_sub_area,etapa_sub_area.nome as nome_etapa, acomp_cnd.tipo_debito,acomp_cnd.data_envio,acomp_cnd.sla,emitente.cpf_cnpj,
				DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	,
				DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,acomp_cnd.tipo_acomp,acomp_cnd.obs,acomp_cnd.id_subarea,acomp_cnd.id_etapa,areas_acomp_cnd.nome_area,acomp_cnd.id_subarea,acomp_cnd.id_etapa,tipo_acomp.descricao,acomp_cnd.arquivo,projetos_acomp_cnd.descricao as proj_desc,
				tipo_debito.descricao as desc_tipo_deb 
				from loja left join acomp_cnd on loja.id = acomp_cnd.id_loja
				left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
				left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
				left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
				left join emitente on loja.id_emitente = emitente.id  
				left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id
				left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
				left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
				where loja.id_contratante = ? and loja.id = ? ";

   $query = $this->db->query($sql, array($idContratante,$id));
//	   print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
 }
 
 function listarAcompById($id_acomp,$id_loja){
$sql = "select loja.id as id_loja,emitente.nome_fantasia,emitente.cpf_cnpj,acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,loja.cidade,loja.ins_cnd_mob, 
				areas_acomp_cnd.id as id_area,etapa_sub_area.sigla as sigla_sub_area,etapa_sub_area.nome as nome_etapa, acomp_cnd.tipo_debito,acomp_cnd.data_envio,acomp_cnd.sla,emitente.cpf_cnpj,
				DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	,
				DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,acomp_cnd.tipo_acomp,acomp_cnd.obs,acomp_cnd.id_subarea,acomp_cnd.id_etapa,areas_acomp_cnd.nome_area,acomp_cnd.id_subarea,acomp_cnd.id_etapa,tipo_acomp.descricao,subarea.id_subarea,tipo_acomp.id as id_tipo_acomp,acomp_cnd.arquivo,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj					
				from loja left join acomp_cnd on loja.id = acomp_cnd.id_loja
				left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
				left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
				left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
				left join emitente on loja.id_emitente = emitente.id  
				left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id
				left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
				where acomp_cnd.id = ? and loja.id = ? ";

   $query = $this->db->query($sql, array($id_acomp,$id_loja));
	   
   $array = $query->result(); 
   return($array);
 }
 

 function listarEstado($id_contratante){
	$this->db->distinct();
	$this -> db -> select('estado as uf');
	$this -> db -> from('loja'); 
	$this -> db -> where('loja.id_contratante', $id_contratante);
	$this -> db -> order_by('loja.estado');
	$query = $this -> db -> get();

   

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
  function listarCidade($id_contratante){
	$this->db->distinct();
	$this -> db -> select('cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> where('loja.id_contratante', $id_contratante);
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();

   

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
    function listarTodasLojas($id_contratante){
		$sql = "SELECT `loja`.*, `emitente`.`nome_fantasia` as razao_social, `emitente`.`cpf_cnpj`, `tipo_emitente`.`descricao`, `emitente`.`nome_resp`, `possui_cnd` as cnd, `cnd_mobiliaria`.`id` as id_cnd, `bandeira`.`descricao_bandeira` as bandeira, `cnd_mobiliaria`.`data_vencto`, `cnd_mobiliaria`.`data_pendencias` FROM (`loja`) JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` LEFT JOIN `cnd_mobiliaria` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id` 
				WHERE `loja`.`id_contratante` = ? AND (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 15) ORDER BY `emitente`.`nome_fantasia`;";
   $query = $this->db->query($sql, array($id_contratante));
	   //print_r($this->db->last_query());exit;
   $array = $query->result(); 
   return($array);
 }
 
 
  function buscaInscricao($inscricao,$emitente){
	 $this -> db -> select('count(*) as total');
	 $this -> db -> from('loja');
	 $this -> db -> where('loja.ins_cnd_mob', $inscricao);
	 $this -> db -> where('loja.id_emitente', $emitente);
	 $query = $this -> db -> get(); 
	 
	if($query -> num_rows() <> 0){
		return $query->result();
	}else{
		return false;
	}
  }
  
  function listarLojaById($id_loja){
   $this -> db -> select('loja.*,emitente.nome_fantasia as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,imovel.nome as nome_imovel,imovel.estado as est,imovel.cidade as cid,imovel.bairro  as bai');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('loja.id', $id_loja);
 
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
 
   function listarCidadeEstadoLojaById($id_loja){
   $this -> db -> select('loja.id,loja.cidade,loja.estado');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('loja.id', $id_loja);
 
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
 
  
   function listarCidadeEstadoLojaByIdLic($id){
   $this -> db -> select('loja.id,loja.cidade,loja.estado');
   $this -> db -> from('loja');
   $this -> db -> join('lojas_licencas','lojas_licencas.id_loja = loja.id');
   $this -> db -> where('lojas_licencas.id_licenca', $id);
 
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
 function listarLicencaLoja($id_loja,$id_licenca){
	/*
   $this -> db -> select('emitente.nome_fantasia,emitente.cpf_cnpj,loja.ins_cnd_mob,tipo_licenca_taxa.descricao as desc_licenca,lojas_licencas.*,DATE_FORMAT(lojas_licencas.entrada_cadin,"%d/%m/%Y") as entrada_cadin_br');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('lojas_licencas','lojas_licencas.id_loja = loja.id');
   $this -> db -> join('tipo_licenca_taxa','tipo_licenca_taxa.id = lojas_licencas.tipo_licenca_taxa');
   $this -> db -> where('loja.id', $id_loja);
 */
   if($id_licenca == 0){
   $sql = "SELECT emitente.nome_fantasia,emitente.cpf_cnpj,loja.ins_cnd_mob,tipo_licenca_taxa.descricao as desc_licenca,lojas_licencas.*,
	DATE_FORMAT(lojas_licencas.data_vencimento,'%d/%m/%Y') as data_vencimento_br,loja.id as id_loja FROM (`loja`) 
	left join emitente on emitente.id = loja.id_emitente
	left JOIN `lojas_licencas` ON `lojas_licencas`.`id_loja` = `loja`.`id`
	left join tipo_licenca_taxa on tipo_licenca_taxa.id = lojas_licencas.tipo_licenca_taxa
	 WHERE `loja`.`id` = ?
	";
	$query = $this->db->query($sql, array($id_loja));
   }else{
   $sql = "SELECT emitente.nome_fantasia,emitente.cpf_cnpj,loja.ins_cnd_mob,tipo_licenca_taxa.descricao as desc_licenca,lojas_licencas.*,
	DATE_FORMAT(lojas_licencas.data_vencimento,'%d/%m/%Y') as data_vencimento_br,loja.id as id_loja FROM (`loja`) 
	left join emitente on emitente.id = loja.id_emitente
	left JOIN `lojas_licencas` ON `lojas_licencas`.`id_loja` = `loja`.`id`
	left join tipo_licenca_taxa on tipo_licenca_taxa.id = lojas_licencas.tipo_licenca_taxa
	 WHERE `loja`.`id` = ? and lojas_licencas.id_licenca = ?
	";
	$query = $this->db->query($sql, array($id_loja,$id_licenca));
   }
   
   
   if($query -> num_rows() <> 0){
     return $query->result();
   } else {
     return false;
   }
   
 }
 
 function listarLojaByTipo($idContratante,$tipo){
   $this -> db -> select('loja.id,emitente.nome_fantasia');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('emitente.tipo_emitente', $tipo);
   $this -> db -> where('loja.id_contratante', $idContratante);
   $this -> db -> order_by('emitente.nome_fantasia');

   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }
 }
 
  function listarTodosEmitentes($id_contratante){
   $this -> db -> select('emitente.id,emitente.nome_fantasia');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente'); 
   $this -> db -> where('id_contratante', $id_contratante);
   $this -> db -> or_where('emitente.tipo_emitente', 2);
   $this -> db -> or_where('emitente.tipo_emitente', 1);   
   $this -> db -> or_where('emitente.tipo_emitente', 15);   
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){

     return $query->result();

   } else {

     return false;

   }

 }
 
 function listarEmitentes($id_contratante){
$sql = "SELECT `emitente`.`id`, `emitente`.`nome_fantasia`  FROM (`emitente`) JOIN `tipo_emitente`  ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		WHERE `id_contratante` = ?  and (`emitente`.`tipo_emitente` = 2  OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 15)
		and emitente.id not in (select id_emitente from loja) order by `emitente`.`nome_fantasia` ";

	$query = $this->db->query($sql, array($id_contratante));
	
   /*
   $this -> db -> select('emitente.id,emitente.nome_fantasia');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente'); 
   $this -> db -> where('id_contratante', $id_contratante);
   $this -> db -> or_where('emitente.tipo_emitente', 2);
   $this -> db -> or_where('emitente.tipo_emitente', 1);   
   $this -> db -> or_where('emitente.tipo_emitente', 15);   
   $query = $this -> db -> get();
   */
   
   if($query -> num_rows() <> 0){

     return $query->result();

   } else {

     return false;

   }

 }
 
  function buscaEmitenteByCidade($idContratante,$id){

   $this -> db -> distinct();
   $this -> db -> select('emitente.id,emitente.nome_fantasia,matriz_filial');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   
   $this -> db -> join('emitente_imovel','emitente.id = emitente_imovel.id_emitente');
   
   $this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');

   $this -> db -> where('emitente.id_contratante', $idContratante);
   
   $this -> db -> where('imovel.cidade', $id);

   
   $this -> db -> order_by('imovel.cidade');
   
   $query = $this -> db -> get();
   

   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaEmitente($idContratante,$id){

   $this -> db -> distinct();
   $this -> db -> select('emitente.id,emitente.nome_fantasia');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   
   $this -> db -> join('emitente_imovel','emitente.id = emitente_imovel.id_emitente');
   
   $this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');

   $this -> db -> where('emitente.id_contratante', $idContratante);
   
   $this -> db -> where('imovel.estado', $id);

   
   $this -> db -> order_by('imovel.cidade');
   
   $query = $this -> db -> get();
   

   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaCidade($idContratante,$id){

   $this -> db -> distinct();
   $this -> db -> select('loja.cidade');
   $this -> db -> from('loja');
   $this -> db -> where('loja.estado', $id);
   $this -> db -> where('loja.id_contratante', $idContratante);
   $this -> db -> order_by('loja.cidade');
  
   $query = $this -> db -> get();
	
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaCidadeImByEstado($idContratante,$id){

   $this -> db -> distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('imovel');
   $this -> db -> where('imovel.estado', $id);
   $this -> db -> where('imovel.id_contratante', $idContratante);
   $this -> db -> order_by('imovel.cidade');
  
   $query = $this -> db -> get();
	
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaCidadeByEstadoTipo($idContratante,$id,$tipo){
    $sql = "
	SELECT  distinct loja.cidade as cidade
	from loja
	left join emitente on emitente.id = loja.id_emitente
	WHERE `loja`.`id_contratante` = ? 
	AND `loja`.`estado` = ? 
	and `emitente`.`tipo_emitente` = ? 
	ORDER BY `loja`.`cidade`
	 ";

   $query = $this->db->query($sql, array($idContratante, $id,$tipo));
   
   $array = $query->result_array(); 
   return($array);
   
   

 }
 
 function buscaLojaByEstadoTipo($idContratante,$id,$tipo){
    $sql = "
	SELECT  loja.id,emitente.nome_fantasia
	from loja
	left join emitente on emitente.id = loja.id_emitente
	WHERE `loja`.`id_contratante` = ? 
	AND `loja`.`estado` = ? 
	and `emitente`.`tipo_emitente` = ? 
	ORDER BY `loja`.`cidade`
	 ";

   $query = $this->db->query($sql, array($idContratante, $id,$tipo));
   
   $array = $query->result_array(); 
   return($array);
   
   

 }
 
 function buscaLojaByCidadeTipo($idContratante,$id,$tipo){
    $sql = "
	SELECT  loja.id,emitente.nome_fantasia
	from loja
	left join emitente on emitente.id = loja.id_emitente
	WHERE `loja`.`id_contratante` = ? 
	AND `loja`.`cidade` = ? 
	and `emitente`.`tipo_emitente` = ? 
	ORDER BY `loja`.`cidade`
	 ";

   $query = $this->db->query($sql, array($idContratante, $id,$tipo));
   
   $array = $query->result_array(); 
   return($array);
   
   

 }
 
 function buscaLojaByEstado($idContratante,$id,$status,$tabela){
	 
	if($status == 4) {
		
		 $sql = "
	SELECT `loja`.*, loja.id as id_loja,99 as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,'Nada Consta' cnd FROM (`loja`) 
	JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
	JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
	WHERE `loja`.`id_contratante` = ? 
	AND `loja`.`estado` = ? 
	and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
	ORDER BY `emitente`.`nome_fantasia`
	 ";

   $query = $this->db->query($sql, array($idContratante, $id));
		
	}elseif($status == 4){
		
		$sql = "
	SELECT `loja`.*, loja.id as id_loja,$tabela.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
	JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
	JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
	LEFT JOIN $tabela ON $tabela.id_loja = loja.id
	WHERE `loja`.`id_contratante` = ? 
	AND `loja`.`estado` = ? 
	and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
	ORDER BY `emitente`.`nome_fantasia`
	 ";
	  $query = $this->db->query($sql, array($idContratante, $id));
	}elseif($status == 0){
		
		$sql = "
	SELECT `loja`.*, loja.id as id_loja,$tabela.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
	JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
	JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
	LEFT JOIN $tabela ON $tabela.id_loja = loja.id
	WHERE `loja`.`id_contratante` = ? 
	AND `loja`.`estado` = ? 
	and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
	ORDER BY `emitente`.`nome_fantasia`
	 ";
	  $query = $this->db->query($sql, array($idContratante, $id));
	}else{
		$sql = "
	SELECT `loja`.*, loja.id as id_loja,$tabela.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
	JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
	JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
	LEFT JOIN $tabela ON $tabela.id_loja = loja.id
	WHERE `loja`.`id_contratante` = ? 
	AND `loja`.`estado` = ? 
	and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
	and $tabela.possui_cnd = ?
	ORDER BY `emitente`.`nome_fantasia`
	 ";
	  $query = $this->db->query($sql, array($idContratante, $id,$status));
	}
   
   
   $array = $query->result(); 
   return($array);
   
   

 }
 
 function buscaLojaByBandeira($idContratante,$id,$estado,$municipio,$imovel){
	
    $sql = "
	SELECT `loja`.*, loja.id as id_loja,cnd_mobiliaria.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
	JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
	JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
	LEFT JOIN cnd_mobiliaria ON cnd_mobiliaria.id_loja = loja.id
	WHERE `loja`.`id_contratante` = ? 	
	 ";
	
	if($imovel <> '0'){
		$sql .= 'AND `loja`.`bandeira` = ? AND `loja`.`id` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) ORDER BY `emitente`.`nome_fantasia`';
		$query = $this->db->query($sql, array($idContratante, $id,$imovel));	
	}else{
		if($municipio <> '0'){
			$sql .= 'AND `loja`.`bandeira` = ? AND `loja`.`cidade` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) ORDER BY `emitente`.`nome_fantasia`';
			$query = $this->db->query($sql, array($idContratante, $id,$municipio));		
		}elseif($estado <> '0'){
			$sql .= 'AND `loja`.`bandeira` = ?  AND `loja`.`estado` = ? 
			and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
			ORDER BY `emitente`.`nome_fantasia`';
			$query = $this->db->query($sql, array($idContratante, $id,$estado));
		}else{
			$sql .= 'AND `loja`.`bandeira` = ? 
			and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
			ORDER BY `emitente`.`nome_fantasia`';
			$query = $this->db->query($sql, array($idContratante, $id));
 
		}
	}
	
   
  
   $array = $query->result_array(); 
   return($array);
   


 }
 
 function buscaLojaStatus($idContratante,$status){
	 
	 if($status == 4){
		
		$sql = "SELECT distinct `loja`.*, loja.id as id_loja,99 as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,'Nada Consta' as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		WHERE `loja`.`id_contratante` = ? 
		and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 )
		and loja.id not in (select id_loja from cnd_mobiliaria where id_contratante = ?)
		ORDER BY `emitente`.`nome_fantasia`
		 ";
		$query = $this->db->query($sql, array($idContratante, $idContratante));
	}else if($status == 0){
		 
		 $sql = "SELECT distinct `loja`.*, loja.id as id_loja,cnd_mobiliaria.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN cnd_mobiliaria ON cnd_mobiliaria.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? 
		and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) 
		ORDER BY `emitente`.`nome_fantasia`
		 ";
		$query = $this->db->query($sql, array($idContratante, $status));
			
	}else{
		
		$sql = "SELECT distinct `loja`.*, loja.id as id_loja,cnd_mobiliaria.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN cnd_mobiliaria ON cnd_mobiliaria.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? 
		and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) 
		and cnd_mobiliaria.possui_cnd = ?
		ORDER BY `emitente`.`nome_fantasia`
		 ";
			$query = $this->db->query($sql, array($idContratante, $status));
	}
    

   
   
  $array = $query->result(); 
   return($array);
	 
 }	 
 function buscaLojaByStatus($idContratante,$id,$estado,$municipio,$imovel){
	
	if($id == 4){	
		$sql = "
		SELECT `loja`.*, loja.id as id_loja,loja.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,4 as cnd FROM (`loja`) 
		JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		WHERE `loja`.`id_contratante` = ? 	and loja.id not in (select id_loja from cnd_mobiliaria)
		 ";
	
		if($imovel <> '0'){
			$sql .= 'AND `loja`.`id` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) ORDER BY `emitente`.`nome_fantasia`';
			$query = $this->db->query($sql, array($idContratante, $imovel));	
		}else{
			if($municipio <> '0'){
				$sql .= 'AND `loja`.`cidade` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante, $municipio));		
			}elseif($estado <> '0'){
				$sql .= 'AND `loja`.`estado` = ? and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante, $estado));
			}else{
				$sql .= ' and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante));
	 
			}
		}
	
	}else{
		
		$sql = "
		SELECT `loja`.*, loja.id as id_loja,cnd_mobiliaria.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN cnd_mobiliaria ON cnd_mobiliaria.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? 	
		 ";
	
		if($imovel <> '0'){
			$sql .= 'AND `cnd_mobiliaria`.`possui_cnd` = ? AND `loja`.`id` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) ORDER BY `emitente`.`nome_fantasia`';
			$query = $this->db->query($sql, array($idContratante, $id,$imovel));	
		}else{
			if($municipio <> '0'){
				$sql .= 'AND `cnd_mobiliaria`.`possui_cnd` = ? AND `loja`.`cidade` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante, $id,$municipio));		
			}elseif($estado <> '0'){
				$sql .= 'AND `cnd_mobiliaria`.`possui_cnd`= ?  AND `loja`.`estado` = ? 
				and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
				ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante, $id,$estado));
			}else{
				$sql .= ' AND `cnd_mobiliaria`.`possui_cnd`= ? 
				and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
				ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante, $id));
	 
			}
		}
	
	}
    

  
   $array = $query->result_array(); 
   return($array);
   


 }
 function buscaLojaSemCndEst($idContratante){
	$sql = "SELECT distinct `loja`.*, loja.id as id_loja,cnd_mobiliaria.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
	left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
	left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
	LEFT JOIN cnd_mobiliaria ON cnd_mobiliaria.id_loja = loja.id
	WHERE `loja`.`id_contratante` = ? 	
	and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) 
	AND `loja`.`id` not in (select id_loja from cnd_estadual where id_contratante = ?) 
	ORDER BY `emitente`.`nome_fantasia`
	 ";
	$query = $this->db->query($sql, array($idContratante,$idContratante));
	$array = $query->result(); 
   return($array);
		
 }	 
 function buscaLojaById($idContratante,$id,$status,$tabela){
	 
	if($id <> 0){ 
		$sql = "SELECT `loja`.*, loja.id as id_loja,$tabela.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		LEFT JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN $tabela ON $tabela.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? 
		AND `loja`.`id` = ? 
		and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
		ORDER BY `emitente`.`nome_fantasia`
		 ";
	   
	   $query = $this->db->query($sql, array($idContratante, $id));
	}else{
		if($status == 4){
			$sql = "SELECT `loja`.*, loja.id as id_loja,99 as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,'Nada Consta' as cnd FROM (`loja`) 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		LEFT JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		WHERE `loja`.`id_contratante` = ? 
		and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
		and loja.id not in (select id_loja from $tabela where $tabela.id_contratante = ?)
		ORDER BY `emitente`.`nome_fantasia`
		 ";
   
	   $query = $this->db->query($sql, array($idContratante,$idContratante));
		}elseif($status == 0){
			$sql = "SELECT `loja`.*, loja.id as id_loja,$tabela.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		LEFT JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN $tabela ON $tabela.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? 
		and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
		ORDER BY `emitente`.`nome_fantasia`
		 ";
   
	   $query = $this->db->query($sql, array($idContratante));
		}else{
			$sql = "SELECT `loja`.*, loja.id as id_loja,$tabela.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		LEFT JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN $tabela ON $tabela.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? 
		and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
		and $tabela.possui_cnd = ?
		ORDER BY `emitente`.`nome_fantasia`
		 ";
   
	   $query = $this->db->query($sql, array($idContratante,$status));
		}
		

		
	}
   $array = $query->result(); 
   return($array);
   


 }
 
 function buscaLojaByCidade($idContratante,$id,$status,$tabela){
	
	if($status == 4){
		
		$sql = "SELECT distinct `loja`.*, loja.id as id_loja,99 as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,'Nada Consta' as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		WHERE `loja`.`id_contratante` = ? AND `loja`.`cidade` = ? and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 )
		ORDER BY `emitente`.`nome_fantasia` ";
	 $query = $this->db->query($sql, array($idContratante, $id));
	}else if($status == 0){
		 
		 $sql = "SELECT distinct `loja`.*, loja.id as id_loja,$tabela.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN $tabela ON $tabela.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? AND `loja`.`cidade` = ? and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) 
		ORDER BY `emitente`.`nome_fantasia` ";
		$query = $this->db->query($sql, array($idContratante, $id));
			
	}else{
		
		$sql = "SELECT distinct `loja`.*, loja.id as id_loja,$tabela.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN $tabela ON $tabela.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? AND `loja`.`cidade` = ? and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) 
		and $tabela.possui_cnd = ? 	ORDER BY `emitente`.`nome_fantasia` ";
			$query = $this->db->query($sql, array($idContratante, $id,$status));
	}
    

   
   
  $array = $query->result(); 
   return($array);


 }
 
 function buscaLojaByCidadeFiltro($idContratante,$id){
	
	$sql = "SELECT distinct `loja`.*, loja.id as id_loja,99 as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,'Nada Consta' as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		WHERE `loja`.`id_contratante` = ? AND `loja`.`cidade` = ? and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 )
		ORDER BY `emitente`.`nome_fantasia` ";
	 $query = $this->db->query($sql, array($idContratante, $id));
    

   
   
  $array = $query->result(); 
   return($array);


 }
 
 function buscaCidades($idContratante){

   $this -> db -> distinct();
   $this -> db -> select('imovel.cidade');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   
   $this -> db -> join('emitente_imovel','emitente.id = emitente_imovel.id_emitente');
   
   $this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');

   $this -> db -> where('emitente.id_contratante', $idContratante);

   $this -> db -> or_where('emitente.tipo_emitente', 2);
   $this -> db -> or_where('emitente.tipo_emitente', 1);
   $this -> db -> or_where('emitente.tipo_emitente', 15);
   
   $this -> db -> order_by('imovel.estado');
   
   $query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaEstado($idContratante){

   $this -> db -> distinct();
   $this -> db -> select('imovel.estado');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   
   $this -> db -> join('emitente_imovel','emitente.id = emitente_imovel.id_emitente');
   
   $this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');

   $this -> db -> where('emitente.id_contratante', $idContratante);

   $this -> db -> or_where('emitente.tipo_emitente', 2);
   $this -> db -> or_where('emitente.tipo_emitente', 1);
   $this -> db -> or_where('emitente.tipo_emitente', 15);
   
   $this -> db -> order_by('imovel.estado');
   
   $query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
  function buscaCPFCNPJ($emitente){

   $this -> db -> select('*');

   $this -> db -> from('emitente');

   $this -> db -> where('emitente.id', $emitente);
   
   $query = $this -> db -> get();

  

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaImovel($emitente){

   $this -> db -> select('imovel.id,imovel.nome');

   $this -> db -> from('imovel');

   $this -> db -> join('emitente_imovel','imovel.id = emitente_imovel.id_imovel');

   $this -> db -> where('emitente_imovel.id_emitente', $emitente);

  
   $query = $this -> db -> get();

   

   if($query -> num_rows() <> 0) {
		
     return $query->result();

   }else{

     return false;

   }

 }
 
  function listarEmitentesNaoInclusos($id_contratante,$idImovel){

  $this -> db -> select('group_concat(id_emitente) as ids');  
  $this -> db -> from('emitente_imovel');
  $this -> db -> where('id_imovel', $idImovel);
  
  $query = $this -> db -> get();
  
  
  if($query -> num_rows() <> 0){
     $array =  $query->result();
  }else{
    $array = 0;
   }
  
   $sql = "SELECT `emitente`.`id`, `emitente`.`razao_social` FROM (`emitente`) JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
			WHERE `id_contratante` = ?
			AND `emitente`.`id`  NOT IN 
			(select id_emitente from emitente_imovel where id_imovel = ?)";

   $query = $this->db->query($sql, array($id_contratante, $idImovel));
   $array = $query->result_array(); 
   return($array);
  
   

 }
 
 function somarTodos($idContratante,$cidade,$estado){
 
   $this -> db -> select('count(*) as total');
   $this -> db -> from('loja');
   $this -> db -> where('id_contratante', $idContratante);   
	  if($cidade){
			$this -> db -> where('loja.cidade', $cidade);
			$this -> db -> where('loja.estado', $estado);   
	   }
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
   
 }
 
 function listarBandeiraById($id){
   $this -> db -> select('*');
   $this -> db -> from('bandeira');
   $this -> db -> where('id', $id);   
 
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
function listarBandeira(){
   $this -> db -> select('*');
   $this -> db -> from('bandeira');
 
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
 
function listarRegional(){
   $this -> db -> select('*');
   $this -> db -> from('regional');
 
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
 
  function listarImovelById($id){
   $this -> db -> select('*');
   $this -> db -> from('imovel');
   $this -> db -> where('imovel.id', $id);   

   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 function listarEmitenteById($id_contratante,$id){
   $this -> db -> select('emitente.*');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('id_contratante', $id_contratante);
   $this -> db -> where('emitente.id', $id);   

 
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
 
 function listarLojaCsv($id_contratante,$id_status){
 if($id_status == 0){
	$this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante); 
   $this -> db -> order_by('loja.id');
   $query = $this -> db -> get();
 }else if($id_status == 4){
   $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.id not in (select id_loja from cnd_mobiliaria)');  
    $this -> db -> order_by('loja.id');
   $query = $this -> db -> get(); 
 }else{
	$this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,cnd_mobiliaria.possui_cnd,bandeira.descricao_bandeira,cnd_mobiliaria.data_vencto,cnd_mobiliaria.data_pendencias');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> join('regional','regional.id = loja.regional');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('cnd_mobiliaria.possui_cnd', $id_status);
   $query = $this -> db -> get(); 
 }
   
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 
 
  function listarLojaCsvEst($id_contratante,$est,$id_status){
  if($id_status == 0){
  $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.estado', $est);
   $this -> db -> order_by('loja.id');
   $query = $this -> db -> get();
  }else if($id_status == 4){
	  
	   $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.estado', $est);
   $this -> db -> where('loja.id not in (select id_loja from cnd_mobiliaria)'); 
	$this -> db -> order_by('loja.id');   
   $query = $this -> db -> get();
	  
  }else{
	  
  $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,cnd_mobiliaria.possui_cnd,bandeira.descricao_bandeira,cnd_mobiliaria.data_vencto,cnd_mobiliaria.data_pendencias');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.estado', $est);
   $this -> db -> where('cnd_mobiliaria.possui_cnd', $id_status);
   $query = $this -> db -> get();
  }
	  
 
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 
 function listarLojaCsvById($id_contratante,$id){
  $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,cnd_mobiliaria.possui_cnd,bandeira.descricao_bandeira,cnd_mobiliaria.data_vencto,cnd_mobiliaria.data_pendencias');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.id', $id);
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 
 function listarLojaCsvByEmitente($id_contratante,$id){
  $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,cnd_mobiliaria.possui_cnd,bandeira.descricao_bandeira,cnd_mobiliaria.data_vencto,cnd_mobiliaria.data_pendencias');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> join('regional','regional.id = loja.regional');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.id_emitente', $id);
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 function listarLojaCsvMun($id_contratante,$cid,$id_status){
	 
   if($id_status == 0){
	$this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.cidade', $cid);
   $this -> db -> order_by('loja.id');   
   }else if($id_status == 4){
	$this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira,');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.cidade', $cid);         
   $this -> db -> where('loja.id not in (select id_loja from cnd_mobiliaria)');  
   $this -> db -> order_by('loja.id');   
   }else{
	$this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,cnd_mobiliaria.possui_cnd,bandeira.descricao_bandeira,cnd_mobiliaria.data_vencto,cnd_mobiliaria.data_pendencias');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
    $this -> db -> where('cnd_mobiliaria.possui_cnd', $id_status);
   $this -> db -> where('loja.cidade', $cid);
   }
   
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 function excluir($id){
 
	$data = array('ativo' => 2);

	$this->db->where('id', $id);
	$this->db->update('loja', $data); 
	
	return true;
  
 } 
 
 function excluir_loja_licenca($id){
 
	$this->db->delete('lojas_licencas', array('id_licenca' => $id));
	
	return true;
  
 } 
 
  function ativar($id){
 
	$data = array('ativo' => 1);

	$this->db->where('id', $id);
	$this->db->update('loja', $data); 
	
	return true;
  
 }
 
 function atualizar($dados,$id){ 
	$this->db->where('id', $id);
	$this->db->update('loja', $dados); 
		
	return true;  
 } 
 
 function atualizar_arquivo_acomp($dados,$id,$loja){ 
	$this->db->where('id', $id);
	$this->db->where('id_loja', $loja);
	$this->db->update('acomp_cnd', $dados); 
		
	return true;  
 } 

 function atualiza_licenca($dados,$id){
	$this->db->where('id_licenca', $id);
	$this->db->update('lojas_licencas', $dados); 
		
	return true;
 } 
 
 function verificaCPF($cpf,$tipo_pessoa){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('emitente');
   $this -> db -> where('cpf_cnpj', $cpf);
   $this -> db -> where('tipo_pessoa', $tipo_pessoa);

 
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
 
 function verificaEmail($email){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('emitente');
   $this -> db -> where('email_resp', $email);
   

 
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
 
 public function add($detalhes = array()){
 
	if($this->db->insert('loja', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}
 public function add_licenca($detalhes = array()){
 
	if($this->db->insert('lojas_licencas', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}	
}
?>
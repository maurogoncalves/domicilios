<?php


Class Cnd_Obras_model extends CI_Model{

  function listarEstado($idContratante,$tipo){
	$this->db->distinct();
	$this -> db -> select('imovel.estado');
	$this -> db -> from('matricula_cei'); 
	$this -> db -> join('cnd_obras','matricula_cei.id = cnd_obras.id_cei');
	$this -> db -> join('imovel','imovel.id = matricula_cei.id_imovel');
	$this -> db -> where('cnd_obras.id_contratante', $idContratante);   
	if($tipo <> 'X') {
		$this -> db -> where('cnd_obras.possui_cnd', $tipo);   			
	}
	$this -> db -> order_by('imovel.estado');
	$query = $this -> db -> get();

   

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
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
   
   function buscarCidade($estado,$tipo){

	$this->db->distinct();
	$this -> db -> select('imovel.cidade as cidade');
	$this -> db -> from('matricula_cei'); 
	$this -> db -> join('imovel','imovel.id = matricula_cei.id_imovel');
	$this -> db -> join('cnd_obras','matricula_cei.id = cnd_obras.id_cei');
	if($tipo <> 'X') {
		$this -> db -> where('cnd_obras.possui_cnd', $tipo);   			
	}
	if($estado <> '0'){
		$this -> db -> where('imovel.estado', $estado);   
	}
	$this -> db -> order_by('imovel.cidade');
	$query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
	   if($query -> num_rows() <> 0) {
		 return $query->result();
	   } else{
		 return false;
	   }   
  }
  
  function listarCeiByCidade($id_contratante,$cidade,$tipo){
	if($tipo <> 'X')  {
		
		 $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		where imovel.cidade = ?  and cnd_obras.id_contratante = ? and cnd_obras.possui_cnd = ?";
		$query = $this->db->query($sql, array($cidade,$id_contratante,$tipo));
		
	}else{
		 $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		where imovel.cidade = ?  and cnd_obras.id_contratante = ?";
		$query = $this->db->query($sql, array($cidade,$id_contratante));
   
	}
	
	  //print_r($this->db->last_query());exit;
		
		$array = $query->result(); 
		return($array);
  }

  
  function contaCnd($id_contratante,$ultimoDiaAno){
	$sql = "SELECT count(*) as total,cnd_obras.possui_cnd from cnd_obras where cnd_obras.id_contratante = ? 	and (cnd_obras.data_vencto < ?	or 	cnd_obras.data_pendencias < ?)	group by cnd_obras.possui_cnd";
	$query = $this->db->query($sql, array($id_contratante,$ultimoDiaAno,$ultimoDiaAno));
	  //print_r($this->db->last_query());exit;
   	
	$array = $query->result(); 
	return($array);
  }
  
    function contaCndReg($id_contratante,$ultimoDiaAno,$tipo,$reg){
		
	if($tipo == 0){
		$sql = "SELECT count(*) as total,cnd_obras.possui_cnd 
		from cnd_obras
		left join matricula_cei on cnd_obras.id_cei = matricula_cei.id
		 where cnd_obras.id_contratante = ?  and 
		(cnd_obras.data_vencto <  ?	or 	cnd_obras.data_pendencias < ?)	
		and matricula_cei.regional = ?
		";
		$query = $this->db->query($sql, array($id_contratante,$ultimoDiaAno,$ultimoDiaAno,$reg));
		//print_r($this->db->last_query());exit;
   		$array = $query->result(); 

	}elseif($tipo <> 4){
		$sql = "SELECT count(*) as total,cnd_obras.possui_cnd 
		from cnd_obras
		left join matricula_cei on cnd_obras.id_cei = matricula_cei.id
		 where cnd_obras.id_contratante = ?  and 
		(cnd_obras.data_vencto <  ?	or 	cnd_obras.data_pendencias < ?)	
		and matricula_cei.regional = ?
		and cnd_obras.possui_cnd = ?
		";
		$query = $this->db->query($sql, array($id_contratante,$ultimoDiaAno,$ultimoDiaAno,$reg,$tipo));
		//print_r($this->db->last_query());exit;
   		$array = $query->result(); 

	}else{
		$sql = "SELECT count(*) as total,99
		from matricula_cei
		 where matricula_cei.id_contratante = ? and matricula_cei.regional = ?
		and id not in (select id_cei from cnd_obras where cnd_obras.id_contratante = ? and 
		(cnd_obras.data_vencto <  ?	or 	cnd_obras.data_pendencias < ?))	";
		$query = $this->db->query($sql, array($id_contratante,$reg,$id_contratante,$ultimoDiaAno,$ultimoDiaAno));
		//print_r($this->db->last_query());exit;
   		$array = $query->result(); 

	}
	
	return($array);
	
  }
    
  function listarCeiByEstado($id_contratante,$estado,$tipo){
	
	if($tipo <> 'X'){
	   $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		where imovel.estado = ?  and cnd_obras.id_contratante = ? and cnd_obras.possui_cnd = ?";
		$query = $this->db->query($sql, array($estado,$id_contratante,$tipo));
		
	}else{
	   $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		where imovel.estado = ?  and cnd_obras.id_contratante = ?";
		$query = $this->db->query($sql, array($estado,$id_contratante));
	
	}
	//print_r($this->db->last_query());exit;
		
		$array = $query->result(); 
		return($array);
  }
  
   function listarCidade($idContratante,$tipo){
	$this->db->distinct();
	$this -> db -> select('imovel.cidade');
	$this -> db -> from('matricula_cei'); 
	$this -> db -> join('imovel','imovel.id = matricula_cei.id_imovel');
	$this -> db -> join('cnd_obras','matricula_cei.id = cnd_obras.id_cei');
	$this -> db -> where('cnd_obras.id_contratante', $idContratante);   
	if($tipo <> 'X') {
		$this -> db -> where('cnd_obras.possui_cnd', $tipo);   			
	}
	$this -> db -> order_by('imovel.cidade');
	$query = $this -> db -> get();

   

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
   function listarCeis($idContratante,$tipo){

	$this->db->distinct();
	$this -> db -> select('cnd_obras.id,cei');
	$this -> db -> from('matricula_cei'); 
	$this -> db -> join('cnd_obras','matricula_cei.id = cnd_obras.id_cei');
	if($tipo <> 'X') {
		$this -> db -> where('cnd_obras.possui_cnd', $tipo);   			
	}
	$this -> db -> where('cnd_obras.id_contratante', $idContratante);   			
	$this -> db -> order_by('matricula_cei.cei');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  function listarCnd($id_contratante,$_limit = 30, $_start = 0,$cidade,$estado ){
	  
	  
   if($cidade){
	$sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
			cnd_obras.*,cnd_obras.id as id_cnd
			from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id
			left join regional on regional.id = matricula_cei.regional
			left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
			 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
			where matricula_cei.id_contratante = ? and matricula_cei.cidade = ? and matricula_cei.estado = ?
			ORDER BY imovel.nome limit $_start,$_limit ";
	$query = $this->db->query($sql, array($id_contratante,$cidade,$estado));

   }else{
	   $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		where matricula_cei.id_contratante = ?  ORDER BY imovel.nome limit $_start,$_limit";
		$query = $this->db->query($sql, array($id_contratante));

   }
   
	
 $array = $query->result(); 
   return($array);


 }

 function listarCndTipoReg($id_contratante,$regional,$tipo ){
	  
	  
   if($tipo == '5'){
		$sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
			cnd_obras.*,cnd_obras.id as id_cnd
			from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id
			left join regional on regional.id = matricula_cei.regional
			left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
			 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
			where matricula_cei.id_contratante = ?  and matricula_cei.regional = ?
			ORDER BY imovel.nome ";	
			$query = $this->db->query($sql, array($id_contratante,$regional));

	}else{
			$sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
			cnd_obras.*,cnd_obras.id as id_cnd
			from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id
			left join regional on regional.id = matricula_cei.regional
			left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
			 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
			where matricula_cei.id_contratante = ? and  possui_cnd = ? and matricula_cei.regional = ? ORDER BY imovel.nome  ";
			$query = $this->db->query($sql, array($id_contratante,$tipo,$regional));
		
	}	
   //print_r($this->db->last_query());exit;
	
	$array = $query->result(); 
   return($array);


 }
 
   function listarCndTipo($id_contratante,$tipo ){
	  
	  
   if($tipo <> '0'){
		$sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
			cnd_obras.*,cnd_obras.id as id_cnd
			from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id
			left join regional on regional.id = matricula_cei.regional
			left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
			 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
			where matricula_cei.id_contratante = ? and possui_cnd = ?
			ORDER BY imovel.nome ";	
			$query = $this->db->query($sql, array($id_contratante,$tipo));

	}else{
			$sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
			cnd_obras.*,cnd_obras.id as id_cnd
			from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id
			left join regional on regional.id = matricula_cei.regional
			left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
			 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
			where matricula_cei.id_contratante = ? ORDER BY imovel.nome  ";
			$query = $this->db->query($sql, array($id_contratante));
		
	}	
   
	
 $array = $query->result(); 
   return($array);


 }
  function listarCndById($id){
	  
	  
	   $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		where cnd_obras.id = ?  ";
		$query = $this->db->query($sql, array($id));
	
	
		$array = $query->result(); 
		return($array);


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
 
   function listarCndByIdCei($id){
	  
	  
	   $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd,imovel.cidade,imovel.estado
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		where cnd_obras.id  = ?  ";
		$query = $this->db->query($sql, array($id));
   

 $array = $query->result(); 
   return($array);


 }
 
  function listarTodasCnds($idContratante,$tipo){
	  
	if($tipo <> 'X'){
		 $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd,tipo_obra.descricao as tipo_obra_desc,descricao_bandeira,matricula_cei.cidade,matricula_cei.estado
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join bandeira on bandeira.id = matricula_cei.bandeira
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		where cnd_obras.id_contratante  = ?  ";
		$query = $this->db->query($sql, array($idContratante));
	}else{
	   $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd,tipo_obra.descricao as tipo_obra_desc,descricao_bandeira,matricula_cei.cidade,matricula_cei.estado
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join bandeira on bandeira.id = matricula_cei.bandeira
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		where cnd_obras.id_contratante  = ? and cnd_obras.possui_cnd = ?  ";
		$query = $this->db->query($sql, array($idContratante,$tipo));
   
  }
   $array = $query->result(); 
   return($array);


 }
    function listarCndByIdCnd($id){
	  
	  
	   $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd,tipo_obra.descricao as tipo_obra_desc,descricao_bandeira,matricula_cei.cidade,matricula_cei.estado
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join bandeira on bandeira.id = matricula_cei.bandeira
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		where cnd_obras.id  = ?  ";
		$query = $this->db->query($sql, array($id));
   

	$array = $query->result(); 
   return($array);


 }
 
 function listarCndByCidade($idContratante,$id,$tipo){

if($tipo == 'X'){	  
	$sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd,tipo_obra.descricao as tipo_obra_desc,descricao_bandeira,matricula_cei.cidade,matricula_cei.estado
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join bandeira on bandeira.id = matricula_cei.bandeira
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		where matricula_cei.cidade  = ? and cnd_obras.id_contratante = ?  ";
		$query = $this->db->query($sql, array($id,$idContratante));
}else{
	  $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd,tipo_obra.descricao as tipo_obra_desc,descricao_bandeira,matricula_cei.cidade,matricula_cei.estado
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join bandeira on bandeira.id = matricula_cei.bandeira
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		where cnd_obras.id_contratante = ? and matricula_cei.cidade  = ? and cnd_obras.possui_cnd = ? ";
	$query = $this->db->query($sql, array($idContratante,$id,$tipo));
}  

//print_r($this->db->last_query());exit;
$array = $query->result(); 
return($array);


 }
 
 
  public function addDataEmissao($detalhes = array()){

 

	if($this->db->insert('cnd_data_emissao', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
 
   function listarDataEmissao($id,$modulo){
	 
	$sql = "select data_emissao,DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao_br from cnd_data_emissao where id_cnd = ? and modulo =? order by data_emissao desc limit 1";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarCndByEstado($idContratante,$id,$tipo){

if($tipo == 'X'){	  
	$sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd,tipo_obra.descricao as tipo_obra_desc,descricao_bandeira,matricula_cei.cidade,matricula_cei.estado
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join bandeira on bandeira.id = matricula_cei.bandeira
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		where matricula_cei.estado  = ? and cnd_obras.id_contratante = ?  ";
		$query = $this->db->query($sql, array($id,$idContratante));
}else{
	  $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		cnd_obras.*,cnd_obras.id as id_cnd,tipo_obra.descricao as tipo_obra_desc,descricao_bandeira,matricula_cei.cidade,matricula_cei.estado
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join bandeira on bandeira.id = matricula_cei.bandeira
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		where cnd_obras.id_contratante = ? and matricula_cei.estado  = ? and cnd_obras.possui_cnd = ? ";
	$query = $this->db->query($sql, array($idContratante,$id,$tipo));
}  

//print_r($this->db->last_query());exit;
$array = $query->result(); 
return($array);


 }
 
  function listarCidadeEstadoById($id){
	   $sql = "SELECT matricula_cei.id,matricula_cei.cidade,matricula_cei.estado
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		 join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		where cnd_obras.id  = ?  ";
		$query = $this->db->query($sql, array($id));
   

  $array = $query->result(); 
   return($array);


 }
 
function somarTodos($idContratante,$tipo){
	 
	$this -> db -> select('count(*) as total');
	$this -> db -> from('cnd_obras');
	   $this -> db -> where('id_contratante', $idContratante);   
	if($tipo <> 'X') {
		$this -> db -> where('cnd_obras.possui_cnd', $tipo);   			
	}
	   $query = $this -> db -> get();

	   
	   if($query -> num_rows() <> 0) {
		 return $query->result();
	   } else {
		 return false;
	   }
	   
	 }
 
 
  public function add($detalhes = array()){

 

	if($this->db->insert('cnd_obras', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
	 function atualizar($dados,$id){

 

	$this->db->where('id', $id);

	$this->db->update('cnd_obras', $dados); 

	

	return true;

  

 } 
 


 

   

 

}


?>
<?php
Class Iptu_model extends CI_Model{ 

 function listarEstado($idContratante){	
	$this->db->distinct();	
	$this -> db -> select('estado as uf');	
	$this -> db -> from('imovel'); 	
	$this -> db -> join('iptu','iptu.id_imovel = imovel.id');	
	$this -> db -> where('imovel.id_contratante', $idContratante);     
	$this -> db -> order_by('estado');	
	$query = $this -> db -> get();   
	if($query -> num_rows() <> 0) {     
	  return $query->result();   
	} else{     
	  return false;  
	}     
 }

  function listarCidade($idContratante){	
	$this->db->distinct();	
	$this -> db -> select('cidade');	
	$this -> db -> from('imovel'); 	
	$this -> db -> join('iptu','iptu.id_imovel = imovel.id');	
	$this -> db -> where('imovel.id_contratante', $idContratante);     
	$this -> db -> order_by('cidade');	
	$query = $this -> db -> get();   
	if($query -> num_rows() <> 0) {     
	  return $query->result();   
	  } else{     
	  return false;  
	}     
 }

 
  function listarIptu($id_contratante,$_limit = 30, $_start = 0,$ano ){   
  $this->db->limit( $_limit, $_start ); 	  
  $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd,iptu.ano_ref');
   $this -> db -> from('iptu');   
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');    
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');   
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas');   
   $this -> db -> where('imovel.id_contratante', $id_contratante);     
   $this -> db -> where('iptu.ano_ref', $ano);     
   $this -> db -> order_by('imovel.nome');   
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0) {     return $query->result();
   } else{
     return false;
   }
 }  
 
 function listarTodosIptu($id_contratante,$ano ){   
  $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd,iptu.ano_ref');
   $this -> db -> from('iptu');   
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');    
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');   
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas');   
   $this -> db -> where('imovel.id_contratante', $id_contratante);     
   $this -> db -> where('iptu.ano_ref', $ano);     
   $this -> db -> order_by('imovel.nome');   
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0) {     return $query->result();
   } else{
     return false;
   }
 }  
 
 function buscaInscricao($inscricao,$id_imovel,$ano_ref){	 $this -> db -> select('count(*) as total');	 $this -> db -> from('iptu');	 $this -> db -> where('iptu.inscricao', $inscricao);	 $this -> db -> where('iptu.id_imovel', $id_imovel);	 $this -> db -> where('iptu.ano_ref', $ano_ref);	 $query = $this -> db -> get(); 	

 if($query -> num_rows() <> 0){		return $query->result();	}else{		return false;	}  } 
 
 function listarIptuCsv($id_contratante,$anoEscolhido){   
 $this -> db -> select('imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,emitente.cpf_cnpj,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.data_vencto,imovel.cidade,imovel.estado');   
 $this -> db -> from('iptu');   
 $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');    
 $this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left');   
 $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');   
 $this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');      
 $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');   
 $this -> db -> where('imovel.id_contratante', $id_contratante);  
 if($anoEscolhido  <> 0){
	$this -> db -> where('iptu.ano_ref', $anoEscolhido);  	            	
 }
   
 $this -> db -> order_by('iptu.id');   
 $query = $this -> db -> get();   
 
	if($query -> num_rows() <> 0){    
		return $query->result();   
	}else{     
		return false;   
	} 
 }  

 function listarIptuCsvByCidade($idContratante,$id,$anoEscolhido){   
	$this -> db -> select('imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,emitente.cpf_cnpj,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.data_vencto,imovel.cidade,imovel.estado');   
	$this -> db -> from('iptu');   
	$this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');      
	$this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left');      
	$this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');      
	$this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');      
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');   
	$this -> db -> where('imovel.cidade', $id);   
	$this -> db -> where('imovel.id_contratante', $idContratante);  
	
	
	$this -> db -> order_by('iptu.id');   
	$query = $this -> db -> get();    
	//print_r($this->db->last_query());exit;	
		if($query -> num_rows() <> 0){     
			return $query->result();   
		}else{     
			return false;   
		} 
	}  
	function listarIptuCsvByEstado($idContratante,$id,$anoEscolhido){   
		$this -> db -> select('imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,emitente.cpf_cnpj,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.data_vencto,imovel.cidade,imovel.estado');   
		$this -> db -> from('iptu');   
		$this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');      
		$this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left');      
		$this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');      
		$this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');      
		$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');   
		$this -> db -> where('imovel.id_contratante', $idContratante);
		
		if($anoEscolhido  <> 0){
			$this -> db -> where('iptu.ano_ref', $anoEscolhido);  
		}


		if($id <> 'X'){		
			$this -> db -> where('imovel.estado', $id);   
		}	      	
		$this -> db -> order_by('iptu.id');   
		$query = $this -> db -> get();     
		
		if($query -> num_rows() <> 0)   {     return $query->result();   }   else   {     return false;   } }  function listarTodasCidades(){   $this->db->distinct();   $this -> db -> select('imovel.cidade');   $this -> db -> from('imovel');      $this -> db -> join('iptu','imovel.id = iptu.id_imovel');      $this -> db -> order_by('imovel.cidade');   $query = $this -> db -> get();     if($query -> num_rows() <> 0){     return $query->result();   }else{     return 0;   } } function listarStatusIptu($id){   $this -> db -> select('id,descricao');   $this -> db -> from('status_iptu');   $this -> db -> where('id', $id);   $query = $this -> db -> get();     if($query -> num_rows() <> 0){     return $query->result();   }else{     return false;   } } 
		
		function listarEmitenteById($emitente,$idContratante){   
		
		$sql = "select emitente.id,emitente.razao_social
			from emitente where emitente.id_contratante = ? and
			(emitente.tipo_emitente = 1 or emitente.tipo_emitente = 4)
			and emitente.id = ? order by emitente.razao_social 
			";
			$query = $this->db->query($sql, array($idContratante,$emitente));
			//print_r($this->db->last_query());exit;
			if($query -> num_rows() <> 0){     
				return $query->result();   
			}else{     
				return false;   
			} 
		} 
		function listarEmitentes($id_contratante){   
		$this -> db -> select('emitente.id,emitente.razao_social,emitente.cpf_cnpj');   
		$this -> db -> from('emitente');   
		$this -> db -> where('id_contratante', $id_contratante);   
		$this -> db -> or_where('emitente.tipo_emitente', 4);   
		$this -> db -> or_where('emitente.tipo_emitente', 1);       
		$this -> db -> order_by('emitente.razao_social');   
		$query = $this -> db -> get();     
			if($query -> num_rows() <> 0){    
				return $query->result();  
			}else{     
		return false;   } }  
		
		function listarCidadeByEstado($id){   $this->db->distinct();   $this -> db -> select('imovel.cidade');   $this -> db -> from('imovel');      $this -> db -> join('iptu','imovel.id = iptu.id_imovel');      $this -> db -> where('imovel.estado', $id);   $this -> db -> order_by('imovel.cidade');   $query = $this -> db -> get();     if($query -> num_rows() <> 0){     return $query->result();   }else{     return 0;   } }  
 
 function listarIptuCsvById($idContratante,$id_imovel,$anoEscolhido){   
	$this -> db -> select('imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,emitente.cpf_cnpj,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.data_vencto,imovel.cidade,imovel.estado');   
	$this -> db -> from('imovel');   
	$this -> db -> join('iptu','imovel.id = iptu.id_imovel','left');      
	$this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left');      
	$this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');      
	$this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');      
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');      
	$this -> db -> where('iptu.id_imovel', $id_imovel);      
	$this -> db -> where('imovel.id_contratante', $idContratante);  
	if($anoEscolhido  <> 0){
	$this -> db -> where('iptu.ano_ref', $anoEscolhido);  	            	
	}
 
	
	
	$query = $this -> db -> get();  

		if($query -> num_rows() <> 0){     
			return $query->result();   
		}else{     
			return 0;   
		}  
	}
 
 
 function somarTodos($idContratante){  $this -> db -> select('count(*) as total');  $this -> db -> from('iptu');  $this -> db -> join('imovel','iptu.id_imovel = imovel.id','left');  $this -> db -> where('imovel.id_contratante', $idContratante);      $query = $this -> db -> get();    if($query -> num_rows() <> 0) {     return $query->result();  } else {     return false;  }  }  function status_iptu(){   $this -> db -> select('status_iptu.id,status_iptu.descricao');   $this -> db -> from('status_iptu');   $query = $this -> db -> get();     if($query -> num_rows() <> 0)   {     return $query->result();   }   else   {     return false;   } } 
function listarTodosImoveis($id_contratante){   $this->db->distinct();   $this -> db -> select('imovel.id,imovel.nome');   $this -> db -> from('imovel');   $this -> db -> where('id_contratante', $id_contratante);   $this -> db -> order_by('imovel.id');   $query = $this -> db -> get();     if($query -> num_rows() <> 0)   {     return $query->result();   }   else   {     return false;   } }   

function listarImovel($id_contratante){   
	$this->db->distinct();   
	$this -> db -> select('imovel.id,imovel.nome');   
	$this -> db -> from('imovel');   
	$this -> db -> join('iptu','imovel.id = iptu.id_imovel');   
	$this -> db -> where('id_contratante', $id_contratante);   
	$this -> db -> order_by('imovel.id');   
	$query = $this -> db -> get();     
	if($query -> num_rows() <> 0)   {     
	return $query->result();   
	}   else   {     
	return false;   
	} 
}  

function listarImovelByEstado($id){	
	$this->db->distinct();	$this -> db -> select('imovel.id,imovel.nome');	$this -> db -> from('imovel');   
	$this -> db -> join('iptu','imovel.id = iptu.id_imovel');	
	$this -> db -> where('estado', $id);   
	$this -> db -> order_by('imovel.id');	
	$query = $this -> db -> get();	
	if($query -> num_rows() <> 0) {     
		return $query->result();	}else{     
	return false;   
	} 
}  
function listarImovelByCidade($id){	$this->db->distinct();	$this -> db -> select('imovel.id,imovel.nome');	$this -> db -> from('imovel');    $this -> db -> join('iptu','imovel.id = iptu.id_imovel');	$this -> db -> where('cidade', $id);   	$this -> db -> order_by('imovel.id');	$query = $this -> db -> get();	if($query -> num_rows() <> 0){     return $query->result();	}else{     return false;	} }    public function add($detalhes = array()){ 	if($this->db->insert('iptu', $detalhes)) {										$id = $this->db->insert_id();				return $id;	}		return false;	}		 function atualizar($dados,$id){ 	$this->db->where('id', $id);	$this->db->update('iptu', $dados); 	return true;   }
function listarImovelByIdIptu($id_iptu){
 $this -> db -> select('iptu.id,imovel.id as id_im,imovel.nome,iptu.info_inclusas,iptu.area_total,iptu.area_construida,iptu.inscricao,iptu.valor,iptu.observacoes,iptu.nome_proprietario,iptu.status_prefeitura,iptu.capa,iptu.ativo,iptu.ano_ref,imovel.cidade,imovel.estado,imovel.id as id_imovel,imovel.cidade,imovel.estado');   
 $this -> db -> from('iptu');   
 $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');   
 $this -> db -> where('iptu.id', $id_iptu);      
 $query = $this -> db -> get();   
 //print_r($this->db->last_query());exit;
	 if($query -> num_rows() <> 0)   {     
		return $query->result();   
	 }    else   {     
		return false;   
	 } 
 }  
 function listarImovelByAno($ano,$estado,$municipio,$imovel){    
 $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd');   
 $this -> db -> from('imovel');   
 $this -> db -> join('iptu','imovel.id = iptu.id_imovel');   
$this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');      
 $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');     
 
 if($imovel <> 'X'){		
 $this -> db -> where('imovel.id', $imovel);
 $this -> db -> where('iptu.ano_ref', $ano);  	}else{		if($municipio <> 'X'){		
			
 $this -> db -> where('imovel.cidade', $municipio);  			$this -> db -> where('iptu.ano_ref', $ano);  		}elseif($estado <> 'X'){		
 		
 $this -> db -> where('imovel.estado', $estado);  			$this -> db -> where('iptu.ano_ref', $ano);  		}else{		
		
 $this -> db -> where('iptu.ano_ref', $ano);  		}	}      $query = $this -> db -> get();    if($query -> num_rows() <> 0){     return $query->result();   }else{     return 0;   } }   
 
 function listarImovelByStatus($status,$estado,$municipio,$imovel,$ano,$idContratante){   
 
 if($status == 4){
	 $sql ="
	 SELECT *, `iptu`.`id` as id_iptu, `iptu`.`ativo`, 4 as cnd, `iptu`.`id` as id_cnd 
	 FROM (`imovel`) JOIN `iptu` ON `imovel`.`id` = `iptu`.`id_imovel`
	 LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas`
	 WHERE iptu.`id` not in (select id_iptu from cnd_imobiliaria ) and ano_ref = ?
	 ";
	 if($imovel <> 'X'){		
		$sql .= 'AND `imovel`.`id_contratante` = ? and `imovel`.`id` = ?   order by iptu.id';
		$query = $this->db->query($sql, array($ano,$idContratante, $imovel));			 
	 }else{		
		if($municipio <> 'X'){			
			$sql .= 'AND `imovel`.`id_contratante` = ? and `imovel`.`cidade` = ?    order by iptu.id';
			$query = $this->db->query($sql, array($ano,$idContratante, $municipio));			 
		}elseif($estado <> 'X'){		
			$sql .= 'AND `imovel`.`id_contratante` = ? and `imovel`.`estado` = ?    order by iptu.id';
			$query = $this->db->query($sql, array($ano,$idContratante, $estado));			 
		}else{	
			$sql .= 'AND `imovel`.`id_contratante` = ? order by iptu.id';
			$query = $this->db->query($sql, array($ano,$idContratante));		
		}	
	  } 
	 //print_r($this->db->last_query());exit;
	 $array = $query->result_array(); 
     return($array);
   
 }else{
	 $sql ="
	 SELECT *, `iptu`.`id` as id_iptu, `iptu`.`ativo`, `cnd_imobiliaria`.`possui_cnd` as cnd, `cnd_imobiliaria`.`id` as id_cnd FROM (`imovel`) 
	 JOIN `iptu` ON `imovel`.`id` = `iptu`.`id_imovel` 
	 LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas` 
	 LEFT JOIN `cnd_imobiliaria` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id`
	 WHERE `iptu`.`ano_ref` = ? AND `cnd_imobiliaria`.`possui_cnd` = ?
	 ";
	 if($imovel <> 'X'){		
		$sql .= 'AND `imovel`.`id_contratante` = ? and `imovel`.`id` = ? order by iptu.id';
		$query = $this->db->query($sql, array($ano,$status,$idContratante, $imovel));			 
	 }else{		
		if($municipio <> 'X'){			
			$sql .= 'AND `imovel`.`id_contratante` = ? and `imovel`.`cidade` = ?  order by iptu.id';
			$query = $this->db->query($sql, array($ano,$status,$idContratante, $municipio));			 
		}elseif($estado <> 'X'){		
			$sql .= 'AND `imovel`.`id_contratante` = ? and `imovel`.`estado` = ?   order by iptu.id';
			$query = $this->db->query($sql, array($ano,$status,$idContratante, $estado));			 
		}else{	
			$sql .= 'AND `imovel`.`id_contratante` = ? order by iptu.id';
			$query = $this->db->query($sql, array($ano,$status,$idContratante));		
		}	
	  } 
	 // print_r($this->db->last_query());exit;
	 $array = $query->result_array(); 
     return($array);
 }
   

  } 
 
 function listarImovelByImovel($id_imovel,$ano){	   
 $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd');   
 $this -> db -> from('imovel');   
 $this -> db -> join('iptu','imovel.id = iptu.id_imovel');      
 $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas');       
 $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left'); 
 $this -> db -> where('iptu.ano_ref', $ano);   
 if($id_imovel <> 0){	
	$this -> db -> where('iptu.id_imovel', $id_imovel);      
 }	   
 
 $query = $this -> db -> get();   
	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{     
		return 0;   
	} 
}  

function listarImovelByImovelSemAno($id_imovel){	   
 $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd');   
 $this -> db -> from('imovel');   
 $this -> db -> join('iptu','imovel.id = iptu.id_imovel');      
 $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas');       
 $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left'); 
 if($id_imovel <> 0){	
	$this -> db -> where('iptu.id', $id_imovel);      
 }	   
 
 $query = $this -> db -> get();   
	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{     
		return 0;   
	} 
} 
   
function listarImovelByUf($idContratante,$estadoListar,$ano,$status){  
 if($status == 4){ 
	$this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd');   
	$this -> db -> from('imovel');   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');  
	$this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas');   
	$this -> db -> where('imovel.estado', $estadoListar);  
	$this -> db -> where('imovel.id_contratante', $idContratante);     
	$this -> db -> where('iptu.ano_ref', $ano);
  }elseif($status == 0){		
	$this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd');   
	$this -> db -> from('imovel');   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');  
	$this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas');   
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');   
	$this -> db -> where('imovel.estado', $estadoListar);  
	$this -> db -> where('imovel.id_contratante', $idContratante);     
	$this -> db -> where('iptu.ano_ref', $ano);
 }else{
	 $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd');   
	$this -> db -> from('imovel');   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');  
	$this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas');   
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');   
	$this -> db -> where('imovel.estado', $estadoListar);  
	$this -> db -> where('imovel.id_contratante', $idContratante);     
	$this -> db -> where('iptu.ano_ref', $ano);
	$this -> db -> where('cnd_imobiliaria.possui_cnd', $status);     	
 }

	$query = $this -> db -> get();   
	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{     
		return 0;   
	}  
	
}   

 function listarImovelByMunicipio($idContratante,$municipioListar,$ano,$status){
	 if($status == 4){
		$this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd');   
		$this -> db -> from('imovel');   
		$this -> db -> join('iptu','imovel.id = iptu.id_imovel');      
		$this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas');       
		$this -> db -> where('imovel.cidade', $municipioListar);  
		$this -> db -> where('imovel.id_contratante', $idContratante);     
		$this -> db -> where('iptu.ano_ref', $ano);     	
		
	 }elseif($status == 0){			
		$this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd');   
		$this -> db -> from('imovel');   
		$this -> db -> join('iptu','imovel.id = iptu.id_imovel');      
		$this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas');       
		$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');      
		$this -> db -> where('imovel.cidade', $municipioListar);  
		$this -> db -> where('imovel.id_contratante', $idContratante);     
		$this -> db -> where('iptu.ano_ref', $ano);     	
		 

	 }else{

		$this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.id as id_cnd');   
		$this -> db -> from('imovel');   
		$this -> db -> join('iptu','imovel.id = iptu.id_imovel');      
		$this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas');       
		$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id','left');      
		$this -> db -> where('imovel.cidade', $municipioListar);  
		$this -> db -> where('imovel.id_contratante', $idContratante);     
		$this -> db -> where('iptu.ano_ref', $ano);     	
		$this -> db -> where('cnd_imobiliaria.possui_cnd', $status);     	

		 
	 }	
	 $query = $this -> db -> get();    	
	 if($query -> num_rows() <> 0){     
			return $query->result();   
		}else{     
			return 0;   
		}
 
 } 
}
?>

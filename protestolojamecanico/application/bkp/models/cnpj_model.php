<?php
Class Cnpj_model extends CI_Model{

  function listarCnpjRaiz($id_contratante){
	
	$sql = "select c.* from cnpj_raiz c where c.id_contratante = ?  ";
	$query = $this->db->query($sql, array($id_contratante));
   
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   

}

function listarBandeira(){	  
	$sql = "select id, descricao_bandeira from bandeira";
	$query = $this->db->query($sql, array());  
	$array = $query->result(); 
    return($array);
 }
 
 function listarCnpj($id_contratante,$estado,$cidade,$cnpj){
   $sql1 = $sql2 = $sql3='';
	if($estado <> 0){
		$sql1 = " and e.id = ? ";
    }
	
	if($cidade <> 0){
		$sql2 =" and cid.id = ?";
    }
	
	if($cnpj <> 0){
		$sql3 =" and cc.id = ?";
    }
	
	$sql = "select c.cnpj_raiz,e.nome as uf ,cid.nome as cidade,cc.id,cc.cnpj,cc.nome,band.descricao_bandeira
			from 
			cnpj cc join
			cnpj_raiz c on cc.id_cnpj_raiz = c.id
			join estados e on cc.id_uf = e.id 
			join cidades cid on cid.estado = e.id 
			left join bandeira band on band.id = cc.id_bandeira
			where c.id_contratante = ? and cc.id_municipio = cid.id  $sql1 $sql2 $sql3";
	$query = $this->db->query($sql, array($id_contratante,$estado,$cidade,$cnpj));
   
   
   $array = $query->result(); //array of arrays
   return($array);
   

}

 function listarCnpjInscricao($id_contratante,$estado,$cidade,$cnpj){
   $sql1 = $sql2 = $sql3='';
	if($estado <> 0){
		$sql1 = " and e.id = ? ";
    }
	
	if($cidade <> 0){
		$sql2 =" and cid.id = ?";
    }
	
	if($cnpj <> 0){
		$sql3 =" and c.id = ?";
    }
	
	$sql = "SELECT i.numero,i.tipo,c.cnpj,cr.cnpj_raiz,e.uf,cid.nome AS cidade,b.descricao_bandeira,c.nome,c.id
FROM  inscricao i 
JOIN cnpj c ON c.id = i.id_cpnj
JOIN cnpj_raiz cr ON cr.id = c.id_cnpj_raiz
JOIN estados e ON e.id = c.id_uf
JOIN cidades cid ON cid.id = c.id_municipio
left JOIN bandeira b ON b.id = c.id_bandeira
WHERE c.id_contratante = ?   $sql1 $sql2 $sql3";
	$query = $this->db->query($sql, array($id_contratante,$estado,$cidade,$cnpj));
   
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   

}


function listarInscricao($idCnpj,$tipo){ 
	$sql = "select i.id,i.numero,cc.cnpj,c.cnpj_raiz from inscricao i  join cnpj cc on i.id_cpnj = cc.id join cnpj_raiz c on cc.id_cnpj_raiz = c.id  where i.id_cpnj = ? and i.tipo = ?";
	$query = $this->db->query($sql, array($idCnpj,$tipo));
	//print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
 }

function listarCnpjById($id){
   
	$sql = "select cc.*,c.id as id_cnpj_raiz from  cnpj cc  join cnpj_raiz c on cc.id_cnpj_raiz = c.id where cc.id = ? ";
	$query = $this->db->query($sql, array($id));
   
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   

}

function listarCnpjByCnpj($cnpj){
   
	$sql = "select count(*) as total from  cnpj_raiz c where c.cnpj_raiz = ? ";
	$query = $this->db->query($sql, array($cnpj));
   
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   

}

function listarCnpjByIdEstCid($id,$estado,$cidade){
	if($id == 0){
		$sql = "select cc.*,c.id as id_cnpj_raiz,e.uf  from  cnpj cc  join cnpj_raiz c on cc.id_cnpj_raiz = c.id JOIN estados e ON e.id = cc.id_estado where cc.id_uf = ? and cc.id_municipio = ? ";
		$query = $this->db->query($sql, array($estado,$cidade));
	}else{
		$sql = "select cc.*,c.id as id_cnpj_raiz,e.uf  from  cnpj cc  join cnpj_raiz c on cc.id_cnpj_raiz = c.id JOIN estados e ON e.id = cc.id_estado where c.id = ? and cc.id_uf = ? and cc.id_municipio = ? ";
		$query = $this->db->query($sql, array($id,$estado,$cidade));
	}
	
	
	//print_r($this->db->last_query());exit;
	$array = $query->result(); //array of arrays
	return($array);
}

function listarEstadoByCnpjRaiz($id){
	$sql = "select distinct est.id,est.uf from cnpj c  join estados est on c.id_uf = est.id  join cnpj_raiz cr on cr.id = c.id_cnpj_raiz where cr.id = ? order by est.uf";
	$query = $this->db->query($sql, array($id));
	///print_r($this->db->last_query());exit;
	$array = $query->result(); //array of arrays
	return($array);
}

function listarCnpjRaizById($id){
   
	$sql = "select c.* from cnpj_raiz c  where  c.id = ?";
	$query = $this->db->query($sql, array($id));
   
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   

}

 public function inserir($tabela,$detalhes = array()){ 
	if($this->db->insert($tabela, $detalhes)) {
		return $id = $this->db->insert_id();
	}	
	return false;
}	

public function atualizar($tabela,$dados,$id){  
	$this->db->where('id', $id);
	$this->db->update($tabela, $dados); 
	return true;  
 } 
 
}
?>
<?php
Class Estado_model extends CI_Model{
  function listarEstados($id){	  
	$sql = "select id, uf, nome from estados";
	$query = $this->db->query($sql, array());  
	$array = $query->result(); 
    return($array);
 }
 
 function contarCndByEstadoApp(){
	$sql ="select uf,notificacao,infracao,protesto from (
			select  ee.uf,
			(select count(*) as total from notificacoes i join cnpj c on i.id_cnpj = c.id where c.id_uf = ee.id  ) as notificacao,
			(select count(*) as total from infracoes i join cnpj c on i.id_cnpj = c.id where c.id_uf = ee.id  ) as infracao,
			(select count(*) as total from protesto i join cnpj c on i.id_cnpj = c.id where c.id_uf = ee.id  ) as protesto
			from estados ee) as aux ";
	$query = $this->db->query($sql, array());	
	$array = $query->result_array(); 
	//print_r($this->db->last_query());exit;
	return($array);
	 
} 
	
 function listarEstadosComCnpj(){	  
	$sql = "select distinct e.id, e.uf, e.nome from estados e  join cnpj c on c.id_uf = e.id order by e.uf";
	$query = $this->db->query($sql, array());  
	$array = $query->result(); 
    return($array);
 }
 
 function listarCidades($id){	  
	if($id == 0){
		$sql = "select id, uf, nome from cidades";
		$query = $this->db->query($sql, array());  
	}else{
		$sql = "select id, uf, nome from cidades where estado = ?";
		$query = $this->db->query($sql, array($id));  
	}
	//print_r($this->db->last_query());exit;
	$array = $query->result(); 
    return($array);
 }
 
 function listarCidadesComCnpj($id){	  
	if($id == 0){
		$sql = "select distinct e.id, e.uf, e.nome from cidades e  join cnpj c on c.id_uf = e.id_municipio order by e.nome";
		$query = $this->db->query($sql, array());  
	}else{
		$sql = "select distinct e.id, e.uf, e.nome from cidades e  join cnpj c on c.id_municipio = e.id where estado = ? order by e.nome";
		$query = $this->db->query($sql, array($id));  
	}
	
	$array = $query->result(); 
    return($array);
 }
 
 
  function listarCidadesComCnpjRaiz($id,$cnpjRaiz){	  
	if($cnpjRaiz == '0'){
		$sql = "select distinct e.id, e.uf, e.nome from cidades e  where estado = ? order by e.nome";
		$query = $this->db->query($sql, array($id,$cnpjRaiz));  
	}else{
		$sql = "select distinct e.id, e.uf, e.nome from cidades e  join cnpj c on c.id_municipio = e.id where estado = ? and  c.id_cnpj_raiz = ? order by e.nome";
		$query = $this->db->query($sql, array($id,$cnpjRaiz));  
	}
	//print_r($this->db->last_query());exit;
	$array = $query->result(); 
    return($array);
 }
 
}

?>
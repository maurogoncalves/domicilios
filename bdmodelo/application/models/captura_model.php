<?php
Class Captura_model extends CI_Model{
	

	

	
	public function listarCapturas($estado,$cnpj){


		$sql1 = $sql2 = $sql3 = $sql4='';
		if($estado <> '0'){
			$sql1 = " and c.uf= $estado ";
		}
		if($estado <> '0'){
			$sql1 = " and c.cnpj= $cnpj ";
		}
			

	
		$sql = "select cnpj,uf,imagem,DATE_FORMAT(c.data_captura,'%d/%m/%Y') as data_captura from captura_domicilio c
				where 1=1 $sql1 $sql2  "; 			
		$query = $this->db->query($sql, array());
		
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}


	public function listarUFs(){
		$sql = "select distinct(uf) as uf from captura_domicilio c "; 			
		$query = $this->db->query($sql, array());	
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);			
	}
	
	public function listarCnpj($estado){
		
		if($estado == '0'){
			$sql = "select distinct(cnpj) as cnpj from captura_domicilio c "; 			
			$query = $this->db->query($sql, array());	
		}else{
			$sql = "select distinct(cnpj) as cnpj from captura_domicilio c where uf = ?"; 			
			$query = $this->db->query($sql, array($estado));	
		}
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);			
	}
	
	public function add($detalhes = array()){
		$this->db->insert('captura_domicilio', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
	
	public function atualizar($tabela,$dados,$id){  
		$this->db->where('id', $id);
		$this->db->update($tabela, $dados); 
		//print_r($this->db->last_query());exit;
		return true;  
    } 

 
}
?>

<?php
Class Protesto_model extends CI_Model{
	public function add($detalhes = array()){
		$this->db->insert('protesto', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
 
	public function addArq($detalhes = array()){ 
		if($this->db->insert('protesto_arquivos', $detalhes)) {
		return $id = $this->db->insert_id();
		}
		return false;
	}	
	
	public function add_resp($detalhes = array()){
		$this->db->insert('responsavel_Protesto', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
	public function listarprotesto($estado,$cidade,$cnpjRaiz,$cnpj){

		 $sql1 = $sql2 = $sql3 = $sql4='';
			if($estado <> 0){
				$sql1 = " and c.id_uf = $estado ";
			}
			
			if($cidade <> 0){
				$sql2 =" and c.id_municipio= $cidade";
			}
			
			
			if($cnpj <> 0){
				$sql4 =" and c.id = $cnpj";
			}
	
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_protesto,'%d/%m/%Y') as data_protesto_br,DATE_FORMAT(i.vencimento,'%d/%m/%Y') as vencimento_br,ie.numero as num_ie,im.numero as num_im, n.descricao_natureza,cnpj_credor,DATE_FORMAT(i.data_admissao_titulo,'%d/%m/%Y') as data_admissao_titulo_br,nr_auto_infracao,dados_cartorio,cl.descricao as competencia_legis	
				from protesto i 
				left join cnpj c on i.id_cnpj = c.id 
				left join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				left join estados e on c.id_uf = e.id
				left join cidades cid on cid.id = c.id_uf 
				left join natureza n on n.id = i.id_natureza
				left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  left join inscricao im on im.id = i.id_im and im.tipo = 2
				left join competencia_legis cl on cl.id = i.id_competencia_legis
				where 1=1 $sql1 $sql2 $sql3 $sql4 "; 			
		$query = $this->db->query($sql, array());
		
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarprotestoapp($estado){

		$sql1 = '';
		if($estado <> '0'){
			$sql1 = " and e.uf = '$estado' ";
		}
			

		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_protesto,'%d/%m/%Y') as data_protesto_br,DATE_FORMAT(i.vencimento,'%d/%m/%Y') as vencimento_br,ie.numero as num_ie,im.numero as num_im, n.descricao_natureza,cnpj_credor,DATE_FORMAT(i.data_admissao_titulo,'%d/%m/%Y') as data_admissao_titulo_br,nr_auto_infracao,dados_cartorio	
		from protesto i 
		left join cnpj c on i.id_cnpj = c.id 
		left join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
		left join estados e on c.id_uf = e.id
		left join cidades cid on cid.id = c.id_uf 
		left join natureza n on n.id = i.id_natureza
		left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  left join inscricao im on im.id = i.id_im and im.tipo = 2
		where 1=1 $sql1 "; 			
		$query = $this->db->query($sql, array());
		
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}

public function listarprotestoByEstado($estado){

		 
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_protesto,'%d/%m/%Y') as data_protesto_br,DATE_FORMAT(i.vencimento,'%d/%m/%Y') as vencimento_br,ie.numero as num_ie,im.numero as num_im, n.descricao_natureza
				from protesto i 
				join cnpj c on i.id_cnpj = c.id 
				join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				join estados e on c.id_uf = e.id
				join cidades cid on cid.id = c.id_uf 
				left join natureza n on n.id = i.id_natureza
				left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  left join inscricao im on im.id = i.id_im and im.tipo = 2				
				where 1=1 and e.uf = ? "; 			
		$query = $this->db->query($sql, array($estado));
		
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function addEnc($detalhes = array()){
		$this->db->insert('protesto_encaminhamento', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
	
	public function addArqEnc($detalhes = array()){ 
		if($this->db->insert('protesto_enc_arquivos', $detalhes)) {
		return $id = $this->db->insert_id();
		}
		return false;
	}	
	
	public function listarProtestoTrackingById($id){
		$sql = "SELECT em.nome,em.email,em.cargo,enc.*,DATE_FORMAT(enc.data_envio,'%d/%m/%Y %H:%i:%s') as data_envio_br,ienc.arquivo 
		FROM protesto_encaminhamento enc  left join email em on enc.id_email = em.id left join protesto_enc_arquivos ienc on enc.id_protesto = ienc.id_protesto_enc where enc.id_protesto = ? order by enc.id desc";  
		$query = $this->db->query($sql, array($id));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
	}		
	
	public function listarProtestoById($id){
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_protesto,'%d/%m/%Y') as data_protesto_br,DATE_FORMAT(i.vencimento,'%d/%m/%Y') as vencimento_br,ie.numero as num_ie,im.numero as num_im,c.id_uf,c.id_municipio,cr.id as id_cnpj_raiz,c.ID as id_cnpj,
		cnpj_credor,DATE_FORMAT(i.data_admissao_titulo,'%d/%m/%Y') as data_admissao_titulo_br,nr_auto_infracao,arq.arquivo as arq   	
		from protesto i 
		left join cnpj c on i.id_cnpj = c.id 
		left join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
		left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  
		left join inscricao im on im.id = i.id_im and im.tipo = 2
		LEFT JOIN protesto_arquivos arq ON arq.id_protesto = i.id		
		where i.id = ? ORDER BY arq.id desc LIMIT 1"; 
		$query = $this->db->query($sql, array($id));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function contaProtestoByUf($uf){
		
		if($uf <> 0){
			$sql = "select  count(*) as total  from protesto i join cnpj c on i.id_cnpj = c.id  left join estados e on e.id = c.id_uf"; 
			$query = $this->db->query($sql, array());
		}else{
			$sql = "select  count(*) as total  from protesto i join cnpj c on i.id_cnpj = c.id  left join estados e on e.id = c.id_uf where e.uf = ?"; 
			$query = $this->db->query($sql, array($uf));
		}
		
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarNatureza(){
		$sql = "select id,descricao_natureza from natureza"; 
		$query = $this->db->query($sql, array());
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarArquivoProtestoById($id){
		$sql = "select id,id_Protesto,arquivo from protesto_arquivos a where a.id_Protesto =  ?"; 
		$query = $this->db->query($sql, array($id));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function atualizar($tabela,$dados,$id){  
	$this->db->where('id', $id);
	$this->db->update($tabela, $dados); 
	return true;  
 } 
 
}
?>

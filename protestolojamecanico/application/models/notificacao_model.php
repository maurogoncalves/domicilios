<?php
Class Notificacao_model extends CI_Model{
	public function add($detalhes = array()){
		$this->db->insert('notificacoes', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
 
	public function addArq($detalhes = array()){ 
		if($this->db->insert('notificacoes_arquivos', $detalhes)) {
		return $id = $this->db->insert_id();
		}
		return false;
	}	
	
	public function addEnc($detalhes = array()){
		$this->db->insert('notificacoes_encaminhamento', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
	
	public function addArqEnc($detalhes = array()){ 
		if($this->db->insert('notificacoes_enc_arquivos', $detalhes)) {
		return $id = $this->db->insert_id();
		}
		return false;
	}	
	
	public function add_resp($detalhes = array()){
		$this->db->insert('responsavel_infracao', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
	
	public function listarNotificacoesApp($estado){

		$sql1 = '';
		if($estado <> '0'){
			$sql1 = " and e.uf= '$estado' ";
		}
			
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,ie.numero as num_ie,im.numero as num_im, n.descricao_natureza
				from notificacoes i 
				join cnpj c on i.id_cnpj = c.id 
				join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				left join natureza n on n.id = i.id_natureza
				left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  left join inscricao im on im.id = i.id_im and im.tipo = 2	
				left join estados e on e.id = c.id_uf				
				where 1=1 $sql1  "; 			
		$query = $this->db->query($sql, array());
		
		// print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarArquivosEnc($id){

			
		$sql = "SELECT arquivo FROM notificacoes_enc_arquivos e WHERE e.id_notificacao_enc = ? "; 			
		$query = $this->db->query($sql, array($id));
		
		// print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarNotificacoes($estado,$cidade,$cnpjRaiz,$cnpj,$status){


		 $sql1 = $sql2 = $sql3 = $sql4='';
			if($estado <> 0){
				$sql1 = " and i.id_uf= $estado ";
			}
			
			if($cidade <> 0){
				$sql2 =" and i.id_municipio = $cidade";
			}
			
			if($cnpjRaiz <> 0){
				$sql3 =" and cr.id = $cnpjRaiz";
			}
			
			if($cnpj <> 0){
				$sql4 =" and c.id = $cnpj";
			}
			
			if($status == 'X'){
				$sql6 =" and i.status <> 2";
			}else{
				$sql6 =" and i.status = $status";
			}
			
	
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_postagem_orgao,'%d/%m/%Y') as data_postagem_orgao_br,DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,DATE_FORMAT(i.data_conclusao,'%d/%m/%Y') as data_conclusao_br,DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,ie.numero as num_ie,im.numero as num_im, n.descricao_natureza,cl.descricao as competencia_legis,cid.nome AS cidade	
				from notificacoes i 
				left join cnpj c on i.id_cnpj = c.id 
				left join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				left join natureza n on n.id = i.id_natureza
				left join inscricao st on st.id = i.id_st and st.tipo = 2 AND st.id_cpnj = i.id_cnpj
				left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  AND ie.id_cpnj = i.id_cnpj
				left join inscricao im on im.id = i.id_im and im.tipo = 3  AND im.id_cpnj = i.id_cnpj
				left join competencia_legis cl on cl.id = i.id_competencia_legis
				LEFT JOIN cidades cid on cid.id = i.id_municipio
				where 1=1 $sql1 $sql2 $sql3 $sql4 $sql6  ORDER BY i.id desc " ; 			
		$query = $this->db->query($sql, array());
		
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}


public function listarNotificacoesByEstado($estado){

		
	
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,st.numero as num_st,ie.numero as num_ie,im.numero as num_im, n.descricao_natureza,cl.descricao as competencia
				from notificacoes i 
				left join cnpj c on i.id_cnpj = c.id 
				left join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				left join estados e on e.id = i.id_uf
				left join cidades cid on cid.id = i.id_municipio
				left join natureza n on n.id = i.id_natureza
				LEFT join inscricao st on st.id = i.id_st and st.tipo = 2 AND st.id_cpnj = i.id_cnpj
				LEFT join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  AND ie.id_cpnj = i.id_cnpj
				left join inscricao im on im.id = i.id_im and im.tipo = 3  AND im.id_cpnj = i.id_cnpj	
				left join competencia_legis cl on cl.id = i.id_competencia_legis
				where 1=1 and e.uf= ? and i.status = 0 "; 			
		$query = $this->db->query($sql, array($estado));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
		public function listarNotificacaoTrackingById($id){
		$sql = "SELECT em.nome,em.email,em.cargo,enc.*,DATE_FORMAT(enc.data_envio,'%d/%m/%Y %H:%i:%s') as data_envio_br,enc.id AS id_enc
		FROM notificacoes_encaminhamento enc  
		left join email em on enc.id_email = em.id 		
		where enc.id_notificacao = ? order by enc.id desc";  
		$query = $this->db->query($sql, array($id));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	
	public function listarNotificacaoById($id){
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,
		DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,
		DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,
		DATE_FORMAT(i.data_postagem_orgao,'%d/%m/%Y') as data_postagem_orgao_br,
		DATE_FORMAT(i.data_captura_sistema,'%d/%m/%Y') as data_captura_sistema_br,
		DATE_FORMAT(i.data_ciencia_orgao,'%d/%m/%Y') as data_ciencia_orgao_br,
		st.numero as num_st,ie.numero as num_ie,im.numero as num_im,cr.id as id_cnpj_raiz,c.ID as id_cnpj,arq.arquivo as arq 
		from notificacoes i 
		left join cnpj c on i.id_cnpj = c.id 
		left join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
		left join inscricao st on st.id = i.id_st and st.tipo = 2 AND st.id_cpnj = i.id_cnpj
		left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  AND ie.id_cpnj = i.id_cnpj
		left join inscricao im on im.id = i.id_im and im.tipo = 3  AND im.id_cpnj = i.id_cnpj			
		LEFT JOIN notificacoes_encaminhamento ne ON ne.id_notificacao = i.id
		left JOIN notificacoes_enc_arquivos arq ON arq.id_notificacao_enc = ne.id
		where i.id = ? ORDER BY arq.id desc LIMIT 1"; 
		$query = $this->db->query($sql, array($id));
		$array = $query->result(); //array of arrays
		//print_r($this->db->last_query());exit;
		return($array);
			
	}
	
	public function contaNotificacaoByUf($uf){
		if($uf <> 0){
			$sql = "select count(*) as total from notificacoes i left join estados e on e.id = i.id_uf and status = 0"; 
			$query = $this->db->query($sql, array());
		}else{
			$sql = "select count(*) as total from notificacoes i left join estados e on e.id = i.id_uf where e.uf = ? and status = 0"; 
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
	
	public function listarArquivoNotificacaoById($id){
		$sql = "select id,id_notificacao,arquivo from notificacoes_arquivos a where a.id_notificacao =  ?"; 
		$query = $this->db->query($sql, array($id));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
		public function listarArquivo($id){
		$sql = "select count(*) as total,id,id_notificacao,arquivo from notificacoes_arquivos a where a.id =  ?"; 
		$query = $this->db->query($sql, array($id));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	
	public function atualizar($tabela,$dados,$id){  
	$this->db->where('id', $id);
	$this->db->update($tabela, $dados); 
	//print_r($this->db->last_query());exit;
	return true;  
 } 
 
 function apagaArquivo($id){

	$this->db->where('id', $id);
	$this->db->delete('notificacoes_arquivos'); 
	return true;

 }
 
}
?>

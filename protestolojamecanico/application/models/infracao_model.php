<?php
Class Infracao_model extends CI_Model{
	public function add($detalhes = array()){
		$this->db->insert('infracoes', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
 
	public function addEnc($detalhes = array()){
		$this->db->insert('infracoes_encaminhamento', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
	
	public function addIntimacao($detalhes = array()){
		$this->db->insert('intimacoes', $detalhes);
		$id = $this->db->insert_id();
		
		return $id;
	}
	
	public function addArq($detalhes = array()){ 
		if($this->db->insert('infracoes_arquivos', $detalhes)) {
		return $id = $this->db->insert_id();
		}
		return false;
	}	
	
	public function addArqEnc($detalhes = array()){ 
		if($this->db->insert('infracoes_enc_arquivos', $detalhes)) {
		return $id = $this->db->insert_id();
		}
		return false;
	}	
	
	public function add_resp($detalhes = array()){
		$this->db->insert('responsavel_infracao', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
	
	public function listarInfracoesApp($estado,$cidade,$cnpjRaiz,$cnpj,$campo,$textoProcura,$data1,$data2){
		

		 $sql1 = $sql2 = $sql3 = $sql4= $sql5='';
			if($estado <> '0'){
				$sql1 = " and e.uf = '$estado'";
			}
			
			if($cidade <> '0'){
				$sql2 =" and c.id_municipio= $cidade";
			}
			
			if($cnpjRaiz <> '0'){
				$sql3 =" and cr.id = $cnpjRaiz";
			}
			
			if($cnpj <> '0'){
				$sql4 =" and c.id = $cnpj";
			}
			
			if($campo){
				
				if($campo == 'descricao_natureza'){
					$sql5 =" and n.descricao_natureza like '%$textoProcura%' ";
				}elseif(($campo == 'data_ciencia') || ($campo == 'prazo') ){
					if($data2){
						$data1Arr = explode('/',$data1);
						$dt1 = $data1Arr[2].'-'.$data1Arr[1].'-'.$data1Arr[0];
						
						$data2Arr = explode('/',$data2);
						$dt2 = $data2Arr[2].'-'.$data2Arr[1].'-'.$data2Arr[0];
		
						$sql5 =" and i.$campo between '$dt1' and '$dt2' ";
					}else{
						$data1Arr = explode('/',$data1);
						$dt1 = $data1Arr[2].'-'.$data1Arr[1].'-'.$data1Arr[0];
						
						$sql5 =" and i.$campo = '$dt1' ";
					}
					
				}else{
					$sql5 =" and i.$campo like '%$textoProcura%' ";
				}		
				
			}

	
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,ie.numero as num_ie,im.numero as num_im, n.descricao_natureza
				from infracoes i 
				join cnpj c on i.id_cnpj = c.id 
				join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				join estados e on c.id_uf = e.id
				join cidades cid on cid.id = c.id_uf 
				left join natureza n on n.id = i.id_natureza
				left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  left join inscricao im on im.id = i.id_im and im.tipo = 2				
				where 1=1 $sql1 $sql2 $sql3 $sql4 $sql5 ORDER BY i.id desc  "; 			
		$query = $this->db->query($sql, array());
		
		print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarInfracoes($estado,$cidade,$cnpjRaiz,$cnpj,$campo,$textoProcura,$data1,$data2,$status){
		

		 $sql1 = $sql2 = $sql3 = $sql4= $sql5='';
			if($estado <> 0){
				$sql1 = " and i.id_uf = $estado ";
			}
			
			if($cidade <> 0){
				$sql2 =" and i.id_municipio= $cidade";
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
			
			
			
			
			
			if($campo){
				
				if($campo == 'descricao_natureza'){
					$sql5 =" and n.descricao_natureza like '%$textoProcura%' ";
				}elseif(($campo == 'data_ciencia') || ($campo == 'prazo') ){
					if($data2){
						$data1Arr = explode('/',$data1);
						$dt1 = $data1Arr[2].'-'.$data1Arr[1].'-'.$data1Arr[0];
						
						$data2Arr = explode('/',$data2);
						$dt2 = $data2Arr[2].'-'.$data2Arr[1].'-'.$data2Arr[0];
		
						$sql5 =" and i.$campo between '$dt1' and '$dt2' ";
					}else{
						$data1Arr = explode('/',$data1);
						$dt1 = $data1Arr[2].'-'.$data1Arr[1].'-'.$data1Arr[0];
						
						$sql5 =" and i.$campo = '$dt1' ";
					}
					
				}else{
					$sql5 =" and i.$campo like '%$textoProcura%' ";
				}		
				
			}

	
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,DATE_FORMAT(i.data_conclusao,'%d/%m/%Y') as data_conclusao_br,ie.numero as num_ie,im.numero as num_im, n.descricao_natureza,cl.descricao as competencia_legis
				from infracoes i 
				left join cnpj c on i.id_cnpj = c.id 
				left join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				left join estados e on c.id_uf = e.id
				left join cidades cid on cid.id = c.id_uf 
				left join natureza n on n.id = i.id_natureza
				left join competencia_legis cl on cl.id = i.id_competencia_legis
				left join inscricao st on st.id = i.id_st and st.tipo = 2 AND st.id_cpnj = i.id_cnpj
				left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  AND ie.id_cpnj = i.id_cnpj
				left join inscricao im on im.id = i.id_im and im.tipo = 3  AND im.id_cpnj = i.id_cnpj
				where 1=1 $sql1 $sql2 $sql3 $sql4 $sql5 $sql6  ORDER BY i.id desc "; 			
		$query = $this->db->query($sql, array());
		
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}


public function listarInfracoesByEstado($estado){



	
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,st.numero as num_st,ie.numero as num_ie,im.numero as num_im,cl.descricao as competencia
				from infracoes i 
				left join cnpj c on i.id_cnpj = c.id 
				left join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				left join estados e on e.id = i.id_uf
				left join cidades cid on cid.id = i.id_municipio
				left join natureza n on n.id = i.id_natureza
				LEFT join inscricao st on st.id = i.id_st and st.tipo = 2 AND st.id_cpnj = i.id_cnpj
				LEFT join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  AND ie.id_cpnj = i.id_cnpj
				left join inscricao im on im.id = i.id_im and im.tipo = 3  AND im.id_cpnj = i.id_cnpj	
				left join competencia_legis cl on cl.id = i.id_competencia_legis
				where 1=1 and e.uf=? and i.status = 0"; 			
		$query = $this->db->query($sql, array($estado));
		
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	
	public function listarInfracaoById($id){
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,ie.numero as num_ie,im.numero as num_im,cr.id as id_cnpj_raiz,c.ID as id_cnpj,arq.arquivo as arq,st.numero as num_st,ie.numero as num_ie,im.numero as num_im   
		from infracoes i 
		left join cnpj c on i.id_cnpj = c.id 
		left join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
		left join inscricao st on st.id = i.id_st and st.tipo = 2 AND st.id_cpnj = i.id_cnpj
		left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  AND ie.id_cpnj = i.id_cnpj
		left join inscricao im on im.id = i.id_im and im.tipo = 3  AND im.id_cpnj = i.id_cnpj	
		LEFT JOIN infracoes_encaminhamento ne ON ne.id_infracao = i.id
		LEFT JOIN infracoes_enc_arquivos arq ON arq.id_infracao_enc = ne.id		
		where i.id = ? ORDER BY arq.id desc LIMIT 1"; 
		$query = $this->db->query($sql, array($id));
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarArquivosEnc($id){

			
		$sql = "SELECT arquivo FROM infracoes_enc_arquivos e WHERE e.id_infracao_enc = ? "; 			
		$query = $this->db->query($sql, array($id));
		
		// print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function contaInfracoesByUf($uf){
		
		
		if($uf <> 0){
			$sql = "select  count(*) as total from infracoes i left join estados e on e.id = i.id_uf and status = 0"; 
			$query = $this->db->query($sql, array());
		}else{
			$sql = "select  count(*) as total from infracoes i   left join estados e on e.id = i.id_uf where e.uf = ? and status = 0"; 
			$query = $this->db->query($sql, array($uf));
		}
		
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarInfracaoTrackingById($id){
		$sql = "SELECT em.nome,em.email,em.cargo,enc.*,DATE_FORMAT(enc.data_envio,'%d/%m/%Y %H:%i:%s') as data_envio_br,enc.id AS id_enc
		FROM infracoes_encaminhamento enc  
		left join email em on enc.id_email = em.id 
		where enc.id_infracao = ? order by enc.id desc";  
		$query = $this->db->query($sql, array($id));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	

	
	public function listarCompetencia(){
		$sql = "select id,descricao from competencia_legis"; 
		$query = $this->db->query($sql, array());
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
	
	public function listarArquivoInfracaoById($id){
		$sql = "select id,id_infracao,arquivo from infracoes_arquivos a where a.id_infracao =  ?"; 
		$query = $this->db->query($sql, array($id));
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function atualizar($tabela,$dados,$id){  
	$this->db->where('id', $id);
	$this->db->update($tabela, $dados); 
	return true;  
 } 
 
 		public function listarArquivo($id){
		$sql = "select count(*) as total,id,id_infracao,arquivo from infracoes_arquivos a where a.id =  ?"; 
		$query = $this->db->query($sql, array($id));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
 
  function apagaArquivo($id){

	$this->db->where('id', $id);
	$this->db->delete('infracoes_arquivos'); 
	return true;

 }
 
}
?>

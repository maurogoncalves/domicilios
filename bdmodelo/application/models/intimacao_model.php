<?php
Class Intimacao_model extends CI_Model{
	public function add($detalhes = array()){
		$this->db->insert('intimacoes', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
 
	public function add_area_fiscal($detalhes = array()){
		$this->db->insert('intimacoes_area_fiscal', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
	
	
 
	public function add_area_juridica($detalhes = array()){
		$this->db->insert('intimacoes_area_juridica', $detalhes);
		$id = $this->db->insert_id();
		return $id;
	}
 
 
 
	public function addEnc($detalhes = array()){
		$this->db->insert('infracoes_encaminhamento', $detalhes);
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
	
	public function listarResumoAno($ano,$uf,$idClassificacao){
		$sqlAno = '';
		if($ano <> 0){
			$sqlAno = "and YEAR(i.data_ciencia) = $ano";
		}	
	
		$sqlUf = '';
		if($uf <> 0){
			$sqlUf = "and e.id = '$uf'";
		}	
		
		$sqlClass = '';
		if($idClassificacao){
			$sqlClass = "and af.id_classificacao = '$idClassificacao'";
		}	
		$sql = "SELECT 
				e.uf,
				YEAR(i.data_ciencia) AS ano,
				af.id_classificacao ,tc.descricao_tributo_classificacao,
				sum(af.valores_defensaveis) as total_valores_Defensaveis,
				sum(i.valor_principal) AS total_valor_principal
				from intimacoes i 
				join cnpj c on i.id_cnpj = c.id 
				join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				join estados e on c.id_uf = e.id 
				join cidades cid on cid.id = c.id_uf 
				LEFT JOIN intimacoes_area_fiscal af ON af.id_intimacao = i.id 
				LEFT JOIN tributo_classificacao tc ON tc.id = af.id_classificacao 
				where 1=1 $sqlAno $sqlUf $sqlClass and i.status = 1
				GROUP BY e.uf,YEAR(i.data_ciencia),af.id_classificacao
				ORDER BY YEAR(i.data_ciencia),e.uf,id_classificacao
				"; 			
		$query = $this->db->query($sql, array());
		//print_r($this->db->last_query());exit;
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarIntimacaoClassificacao($ano){
		$sqlAno = '';
		if($ano <> 0){
			$sqlAno = "and YEAR(i.data_ciencia) = $ano";
		}	
	
		
		$sql = "SELECT COUNT(i.data_ciencia) AS total,
				e.uf,c.id_uf
				from intimacoes i 
				join cnpj c on i.id_cnpj = c.id 
				join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				join estados e on c.id_uf = e.id 
				where 1=1  and i.status = 1
				$sqlAno
				AND i.id IN (SELECT af.id_intimacao FROM intimacoes_area_fiscal af WHERE af.id_intimacao = i.id) 
				GROUP BY e.uf
				order by COUNT(i.data_ciencia) desc
				"; 			
		$query = $this->db->query($sql, array());
		print_r($this->db->last_query());exit;
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarFiscalizacao($ano){
		$sqlAno = '';
		if($ano <> 0){
			$sqlAno = "and YEAR(i.data_ciencia) = $ano";
		}	
		
		$sql = "SELECT COUNT(*) AS total, i.responsavel_fiscalizacao
				from intimacoes i
				where 1=1 and i.status = 1 $sqlAno
				GROUP BY  i.responsavel_fiscalizacao order by COUNT(*) desc
				"; 			
		$query = $this->db->query($sql, array());

		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarEscritorioParceiro($ano){
		$sqlAno = '';
		if($ano <> 0){
			$sqlAno = "and YEAR(i.data_ciencia) = $ano";
		}	
		
		$sql = "SELECT COUNT(*) AS total, p.nome,p.id as id_parceiro
				from intimacoes i
				LEFT JOIN intimacoes_area_juridica aj ON i.id = aj.id_intimacao
				LEFT JOIN parceiros p ON p.id = aj.escritorio_parceiro
				WHERE 1=1 and i.status = 1 $sqlAno  GROUP BY  p.nome order by COUNT(*) desc
				"; 			
		$query = $this->db->query($sql, array());

		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarClassificacaoAno($ano,$idClassificacao){
		$sqlAno = '';
		if($ano <> 0){
			$sqlAno = "and YEAR(i.data_ciencia) = $ano";
		}	
	
		
		$sqlClass = '';
		if($idClassificacao){
			$sqlClass = "and af.id_classificacao = '$idClassificacao'";
		}	
		$sql = "SELECT 
				e.uf,
				YEAR(i.data_ciencia) AS ano,
				af.id_classificacao ,tc.descricao_tributo_classificacao,
				sum(af.valores_defensaveis) as total_valores_Defensaveis,
				sum(i.valor_principal) AS total_valor_principal
				from intimacoes i 
				join cnpj c on i.id_cnpj = c.id 
				join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				join estados e on c.id_uf = e.id 
				join cidades cid on cid.id = c.id_uf 
				LEFT JOIN intimacoes_area_fiscal af ON af.id_intimacao = i.id 
				LEFT JOIN tributo_classificacao tc ON tc.id = af.id_classificacao
				where 1=1 $sqlAno $sqlClass and i.status = 1
				GROUP BY YEAR(i.data_ciencia),af.id_classificacao
				ORDER BY YEAR(i.data_ciencia),id_classificacao
				"; 			
		$query = $this->db->query($sql, array());
		//print_r($this->db->last_query());exit;
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function totalizarValor($tipo,$idEmpresa,$idClassificacao){
		
		if($tipo == 'vd'){
			$sql = "SELECT 
				sum(af.valores_defensaveis) as total_valor
				from intimacoes i 
				join cnpj c on i.id_cnpj = c.id 
				join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				LEFT JOIN intimacoes_area_fiscal af ON af.id_intimacao = i.id 
				where 1=1 AND c.empresa = '$idEmpresa' AND af.id_classificacao = '$idClassificacao'
				"; 			
		}else{
			$sql = "SELECT 
				sum(i.valor_principal) AS total_valor
				from intimacoes i 
				join cnpj c on i.id_cnpj = c.id 
				join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				LEFT JOIN intimacoes_area_fiscal af ON af.id_intimacao = i.id 
				where 1=1 AND c.empresa = '$idEmpresa' AND af.id_classificacao = '$idClassificacao'
				"; 			
		}
		
		
		$query = $this->db->query($sql, array());
		//print_r($this->db->last_query());exit;
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarClassificacao(){
		
		
		$sql = "SELECT distinct(tc.descricao_tributo_classificacao) as desc_classificacao,af.id_classificacao			
						from intimacoes i  
						LEFT JOIN intimacoes_area_fiscal af ON af.id_intimacao = i.id  
						LEFT JOIN tributo_classificacao tc ON tc.id = af.id_classificacao 
						where  i.status = 1 order by id_classificacao"; 			
		$query = $this->db->query($sql, array());
		//print_r($this->db->last_query());exit;
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarEmpresa(){
		
		
		$sql = "SELECT id,descricao_empresa FROM empresa"; 			
		$query = $this->db->query($sql, array());
		//print_r($this->db->last_query());exit;
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
		
	public function listarAnos(){
		
		
		$sql = "SELECT  DISTINCT (YEAR(i.data_ciencia)) AS ano from intimacoes i ORDER BY YEAR(i.data_ciencia)"; 			
		$query = $this->db->query($sql, array());
		//print_r($this->db->last_query());exit;
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	
	public function listarClassificacaoJson($estado,$ano){
		
		$sqlEst = '';
		if($estado <> 0){
			$sqlEst = "AND e.id='$estado'";
		}
		
		$sql = "SELECT  distinct(tc.descricao_tributo_classificacao) as desc_classificacao,tc.id as id_classificacao
				from intimacoes i  
				LEFT JOIN intimacoes_area_fiscal af ON i.id = af.id_intimacao
				LEFT JOIN cnpj c ON i.id_cnpj = c.id
				LEFT JOIN estados e ON e.id = c.id_uf
				LEFT JOIN tributo_classificacao tc ON tc.id = af.id_classificacao
				where  i.status = 1 $sqlEst and YEAR(i.data_ciencia) = '$ano' ORDER BY af.id_classificacao"; 			
		$query = $this->db->query($sql, array());
		//print_r($this->db->last_query());exit;
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarEstadoIntimacaoJson($ano){
		$sqlAno = '';
		if($ano <> 0){
			$sqlAno = "and YEAR(i.data_ciencia) = '$ano'";
		}
		$sql = "SELECT distinct e.id, e.uf, e.nome from intimacoes i   LEFT JOIN cnpj c ON i.id_cnpj = c.id LEFT JOIN estados e ON e.id = c.id_uf where  i.status = 1 $sqlAno  ORDER BY e.uf"; 			
		$query = $this->db->query($sql, array());
		//print_r($this->db->last_query());exit;
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarTributoClassificacaoPorAno($idClass,$ano){
		$sql = "SELECT SUM(i.valor_principal) AS total
				from intimacoes i 
				LEFT JOIN intimacoes_area_fiscal af ON af.id_intimacao = i.id
				where i.status = 1  AND af.id_classificacao = $idClass  and  YEAR(i.data_ciencia) = $ano "; 			
		$query = $this->db->query($sql, array());
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarInfracoes($estado,$cidade,$cnpjRaiz,$cnpj,$campo,$textoProcura,$data1,$data2,$status){
		
		$sql1 = $sql2 = $sql3 = $sql4= $sql5 = $sql6 = $sql7='';
		if($estado <> 0){
			$sql1 = " and c.id_uf = $estado ";
		}
		
		if($cidade <> 0){
			$sql2 =" and c.id_municipio= $cidade";
		}
		
		if($cnpjRaiz <> 0){
			$sql3 =" and cr.id = $cnpjRaiz";
		}
		
		if($cnpj <> 0){
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
				
			}elseif($campo == 'responsavel_fiscalizacao'){
				$textoProcuraArr = explode("-",$textoProcura);
				$texto = $textoProcuraArr[0];
				$ano = $textoProcuraArr[1];
				if($ano == '0' ){			
					$sql5 =" and i.$campo like '%$texto%' ";				
				}else{
					$sql5 =" and i.$campo like '%$texto%' and  YEAR(i.data_ciencia) = '$ano'";
				}
			}elseif($campo == 'escritorio_parceiro'){
				$sql6 = "JOIN intimacoes_area_juridica aj ON i.id = aj.id_intimacao";
				$textoProcuraArr = explode("-",$textoProcura);
				$texto = $textoProcuraArr[0];
				$ano = $textoProcuraArr[1];
				if($ano == '0' ){			
					$sql7 = "and aj.escritorio_parceiro = '$texto'";					
				}else{
					$sql7 = "and aj.escritorio_parceiro = '$texto' and  YEAR(i.data_ciencia) = '$ano'  ";				
				}

			}else{
				$sql5 =" and i.$campo like '%$textoProcura%' ";
			}
			
			
		}

	
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,ie.numero as num_ie,im.numero as num_im, n.descricao_natureza,cl.descricao as competencia_legis
				from intimacoes i 
				join cnpj c on i.id_cnpj = c.id 
				join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				join estados e on c.id_uf = e.id
				join cidades cid on cid.id = c.id_uf 
				left join natureza n on n.id = i.id_natureza
				left join competencia_legis cl on cl.id = i.id_competencia_legis
				left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  left join inscricao im on im.id = i.id_im and im.tipo = 2	
				$sql6	
				where 1=1 $sql1 $sql2 $sql3 $sql4 $sql5 $sql7 and i.status = $status"; 			
		$query = $this->db->query($sql, array());
		
		
		$array = $query->result(); //array of arrays
		return($array);
			
	}


public function listarInfracoesByEstado($estado){



	
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,ie.numero as num_ie,im.numero as num_im, n.descricao_natureza,
		aj.id AS id_aj,aj.data_previa_analise,aj.escritorio_parceiro,aj.status_juridico,
			aj.campo_complementar_um AS um_aj,
			aj.campo_complementar_dois AS dois_aj,
			aj.campo_complementar_tres AS tres_aj,
			aj.campo_complementar_quatro AS quatro_aj,
			aj.campo_complementar_cinco AS cinco_aj,
			af.id id_af,af.tipo_intimacao,af.data_previa_atendimento,af.data_final,af.valores_defensaveis,af.valores_indefensaveis,af.status_fiscal,tc.descricao_tributo_classificacao as id_classificacao,
			af.campo_complementar_um AS um_af,
			af.campo_complementar_dois AS dois_af,
			af.campo_complementar_tres AS tres_af,
			af.campo_complementar_quatro AS quatro_af,
			af.campo_complementar_cinco AS cinco_af	,DATE_FORMAT(i.periodo_auditado_inicial,'%d/%m/%Y') as periodo_auditado_inicial_br,	DATE_FORMAT(i.periodo_auditado_final,'%d/%m/%Y') as periodo_auditado_final_br,
			DATE_FORMAT(af.data_previa_atendimento,'%d/%m/%Y') as data_previa_atendimento_br,	DATE_FORMAT(af.data_final,'%d/%m/%Y') as data_final_br,	DATE_FORMAT(aj.data_previa_analise,'%d/%m/%Y') as data_previa_analise_br,
			e.uf,descricao_bandeira,t.descricao_tributo ,tc.descricao_tributo_classificacao
				from intimacoes i 
				join cnpj c on i.id_cnpj = c.id 
				join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
				join estados e on c.id_uf = e.id
				join cidades cid on cid.id = c.id_uf 
				left join natureza n on n.id = i.id_natureza
				left join inscricao ie on ie.id = i.id_ie and ie.tipo = 1  
				left join inscricao im on im.id = i.id_im and im.tipo = 2	
				LEFT JOIN intimacoes_area_juridica aj ON aj.id_intimacao = i.id
				LEFT JOIN intimacoes_area_fiscal af ON af.id_intimacao = i.id 	
				LEFT JOIN tributo_classificacao tc on tc.id = af.id_classificacao 
				LEFT JOIN tributo t ON t.id = af.campo_complementar_um 
				left join bandeira b on c.id_bandeira = b.id				
				where 1=1 and e.uf=? and i.status = 1"; 			
		$query = $this->db->query($sql, array($estado));
		
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	
	public function listarInfracaoById($id){
		$sql = "select i.*,c.cnpj,cr.cnpj_raiz,DATE_FORMAT(i.data_ciencia,'%d/%m/%Y') as data_ciencia_br,DATE_FORMAT(i.prazo,'%d/%m/%Y') as prazo_br,ie.numero as num_ie,im.numero as num_im,c.id_uf,c.id_municipio,cr.id as id_cnpj_raiz,c.ID as id_cnpj,arq.arquivo as arq,
			aj.id AS id_aj,aj.data_previa_analise,aj.escritorio_parceiro,aj.status_juridico,
			aj.campo_complementar_um AS um_aj,
			aj.campo_complementar_dois AS dois_aj,
			aj.campo_complementar_tres AS tres_aj,
			aj.campo_complementar_quatro AS quatro_aj,
			aj.campo_complementar_cinco AS cinco_aj,
			af.id id_af,af.id_classificacao,af.tipo_intimacao,af.data_previa_atendimento,af.data_final,af.valores_defensaveis,af.valores_indefensaveis,af.status_fiscal,
			af.campo_complementar_um AS um_af,
			af.campo_complementar_dois AS dois_af,
			af.campo_complementar_tres AS tres_af,
			af.campo_complementar_quatro AS quatro_af,
			af.campo_complementar_cinco AS cinco_af	,DATE_FORMAT(i.periodo_auditado_inicial,'%d/%m/%Y') as periodo_auditado_inicial_br,	DATE_FORMAT(i.periodo_auditado_final,'%d/%m/%Y') as periodo_auditado_final_br,
			DATE_FORMAT(af.data_previa_atendimento,'%d/%m/%Y') as data_previa_atendimento_br,	DATE_FORMAT(af.data_final,'%d/%m/%Y') as data_final_br,	DATE_FORMAT(aj.data_previa_analise,'%d/%m/%Y') as data_previa_analise_br
		from intimacoes i 
		join cnpj c on i.id_cnpj = c.id 
		join cnpj_raiz cr on c.id_cnpj_raiz = cr.id 
		left join inscricao ie on ie.id = i.id_cnpj and ie.tipo = 1  
		left join inscricao im on im.id = i.id_cnpj and im.tipo = 2 
		LEFT JOIN infracoes_enc_arquivos arq ON arq.id_infracao_enc = i.id
		LEFT JOIN intimacoes_area_juridica aj ON aj.id_intimacao = i.id
		LEFT JOIN intimacoes_area_fiscal af ON af.id_intimacao = i.id 
		join estados e on c.id_uf = e.id
		where i.id = ? ORDER BY arq.id desc LIMIT 1"; 
		$query = $this->db->query($sql, array($id));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	 function listarTodasTratativas($idContratante,$id,$modulo){
	 
	$sql = "select cnd_mob_tratativa.id,cnd_mob_tratativa.pendencia,
	DATE_FORMAT(data_inclusao_sis_ext,'%d/%m/%Y') as data_envio_voiza ,
	DATE_FORMAT(prazo_solucao_sis_ext,'%d/%m/%Y') as prazo_solucao_voiza ,
	DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_bd ,
	DATE_FORMAT(prazo_solucao,'%d/%m/%Y') as prazo_solucao_bd ,
	status_chamado_sis_ext,
	status_demanda,
	status_demanda.descricao_etapa,
	status_chamado_interno_mobiliario.descricao,
	DATE_FORMAT(data_atualizacao,'%d/%m/%Y') as ultima_tratativa,area_focal,contato, natureza_raiz.descricao_natureza_raiz, area_focal.descricao_area_focal,valor_pendencia
	from cnd_mob_tratativa
	left join status_demanda on status_demanda.id = cnd_mob_tratativa.status_demanda
	left join status_chamado_interno_mobiliario on status_chamado_interno_mobiliario.id = cnd_mob_tratativa.status_chamado_sis_ext  
	left join natureza_raiz on natureza_raiz.codigo = cnd_mob_tratativa.id_natureza_raiz  
	left join area_focal on area_focal.codigo = cnd_mob_tratativa.id_area_focal
	where id_contratante = ? and id_cnd_mob = ? and cnd_mob_tratativa.modulo = ?
	order by cnd_mob_tratativa.data_atualizacao desc
	";

	$query = $this->db->query($sql, array($idContratante,$id,$modulo));
	//print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function listarNaturezaRaiz(){
   $this -> db -> select('*');
   $this -> db -> from('natureza_raiz');
   $this -> db -> order_by('codigo');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
  function listarStatusInterno(){
   $this -> db -> select('*');
   $this -> db -> from('status_chamado_interno_mobiliario');
 
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
 
  function listarTributo(){
   $this -> db -> select('*');
   $this -> db -> from('tributo');
 
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
 
 function listarClassificacaoTributo($tributo){
   $this -> db -> select('*');
   $this -> db -> from('tributo_classificacao');
   if($tributo <> 0){
	$this->db->where('id_tributo', $tributo);	   
   }
   
 
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
 
  function listarAreaFocal(){
   $this -> db -> select('*');
   $this -> db -> from('area_focal');
   $this -> db -> order_by('codigo');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
   function listarEtapa(){
   $this -> db -> select('*');
   $this -> db -> from('etapa');
 
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
 function listarEsfera(){
   $this -> db -> select('*');
   $this -> db -> from('esfera');
 
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
 
	public function contaIntimacaoesByUf($uf){
		
		
		if($uf <> 0){
			$sql = "select  count(*) as total from intimacoes i join cnpj c on i.id_cnpj = c.id left join estados e on e.id = c.id_uf where i.status = 1"; 
			$query = $this->db->query($sql, array());
		}else{
			$sql = "select  count(*) as total from intimacoes i join cnpj c on i.id_cnpj = c.id  left join estados e on e.id = c.id_uf where e.uf = ? and i.status = 1"; 
			$query = $this->db->query($sql, array($uf));
		}
		
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	
	public function listarInfracaoTrackingById($id){
		$sql = "SELECT em.nome,em.email,em.cargo,enc.*,DATE_FORMAT(enc.data_envio,'%d/%m/%Y %H:%i:%s') as data_envio_br,ienc.arquivo 
		FROM infracoes_encaminhamento enc  
		left join email em on enc.id_email = em.id 
		left join infracoes_enc_arquivos ienc on enc.id_infracao = ienc.id_infracao_enc 
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
	
	public function listarTipoIntimacao(){
		$sql = "select id,descricao_intimacao from tipo_intimacao"; 
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

 public function add_tratativa($detalhes = array()){
	if($this->db->insert('cnd_mob_tratativa', $detalhes)) {			
		$id = $this->db->insert_id();
		return $id;
	}
	return false;
}

  function atualizar_tratativa($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_mob_tratativa', $dados); 

	return true;
 }

 function addObsTrat($detalhes = array()){ 
	if($this->db->insert('cnd_mob_tratativa_obs', $detalhes)) {
		
		return $id = $this->db->insert_id();
	}
	return false;
 }
 
  function listarObsTratById($id){ 
	$sql = "select DATE_FORMAT(c.data,'%d/%m/%Y') as data,c.hora,c.data_hora,u.email,u.nome_usuario,c.observacao,c.id,c.arquivo
		from cnd_mob_tratativa_obs c left join usuarios u on u.id = c.id_usuario where c.id_cnd_trat = ? order by c.id desc";
	$query = $this->db->query($sql, array($id));
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarTratativaById($idContratante,$id,$modulo){
	$sql = "select cnd_mob_tratativa.id,
			cnd_mob_tratativa.tipo_tratativa,
			cnd_mob_tratativa.pendencia,
			cnd_mob_tratativa.esfera,cnd_mob_tratativa.etapa,
			esfera.descricao_esfera,etapa.descricao_etapa,
			DATE_FORMAT(cnd_mob_tratativa.data_informe_pendencia,'%d/%m/%Y') as data_informe_pendencia,
			cnd_mob_tratativa.id_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_inclusao_sis_ext,'%d/%m/%Y') as data_inclusao_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.prazo_solucao_sis_ext,'%d/%m/%Y') as prazo_solucao_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_encerramento_sis_ext,'%d/%m/%Y') as data_encerramento_sis_ext,
			status_chamado_interno.descricao as desc_chamado_int,
			cnd_mob_tratativa.status_chamado_sis_ext,
			cnd_mob_tratativa.sla_sis_ext,
			cnd_mob_tratativa.usu_inc,
			cnd_mob_tratativa.area_focal,
			cnd_mob_tratativa.sub_area_focal,
			cnd_mob_tratativa.contato,
			DATE_FORMAT(cnd_mob_tratativa.data_envio,'%d/%m/%Y') as data_envio,
			DATE_FORMAT(cnd_mob_tratativa.prazo_solucao,'%d/%m/%Y') as prazo_solucao,
			DATE_FORMAT(cnd_mob_tratativa.data_retorno,'%d/%m/%Y') as data_retorno,
			cnd_mob_tratativa.sla,
			cnd_mob_tratativa.status_demanda,
			status_demanda.descricao_etapa,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_um,'%d/%m/%Y') as esc_data_prazo_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_um,'%d/%m/%Y') as esc_data_retorno_um,
			cnd_mob_tratativa.esc_status_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_dois,
			cnd_mob_tratativa.esc_status_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_tres,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_tres,
			cnd_mob_tratativa.esc_status_tres,natureza_raiz.codigo as codigo_natureza_raiz,area_focal.codigo as codigo_area_focal,
			cnd_mob_tratativa.valor_pendencia,cnd_mob_tratativa.modulo
			from cnd_mob_tratativa 
			left join esfera on esfera.id = cnd_mob_tratativa.esfera
			left join etapa on etapa.id = cnd_mob_tratativa.etapa
			left join status_chamado_interno on status_chamado_interno.id = cnd_mob_tratativa.status_chamado_sis_ext
			left join status_demanda on status_demanda.id = cnd_mob_tratativa.id
			left join natureza_raiz on natureza_raiz.codigo = cnd_mob_tratativa.id_natureza_raiz  
			left join area_focal on area_focal.codigo = cnd_mob_tratativa.id_area_focal
		where cnd_mob_tratativa.id_contratante = ? and cnd_mob_tratativa.id = ? and cnd_mob_tratativa.modulo = ?";

	$query = $this->db->query($sql, array($idContratante,$id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 public function inserirNovoArquivo($detalhes = array()){
	if($this->db->insert('arquivo_tratativas', $detalhes)) {
		$id = $this->db->insert_id();
		return $id;
	}
	return false;

}

 function excluirTratativa($id){	
	$this->db->where('id', $id);	
	$this->db->delete('cnd_mob_tratativa_obs'); 
	return true; 
} 
 
 
  function listarArquivosMobiliaria($id){ 
	$sql = "select id_arquivo_tratativas,arquivo from arquivo_tratativas a where a.id_tratativas = ? ";
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
}
?>

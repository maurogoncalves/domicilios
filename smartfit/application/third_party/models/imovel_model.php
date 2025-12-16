<?php 
Class Imovel_model extends CI_Model{  


  function somarAreaIptu($idImovel){
   $ano = date('Y');
   $sql = "select round(sum(replace(REPLACE(area_total, '.', ''),',','.')),2) as area_total, round(sum(replace(REPLACE(area_construida, '.', ''),',','.')),2) as area_construida
			from iptu where id_imovel = ? and ano_ref = ?";

   $query = $this->db->query($sql, array( $idImovel,$ano));

   //print_r($this->db->last_query());exit;

   $array = $query->result_array(); //array of arrays

   return($array);


 }
 
   function listarCidade($idContratante){	
	$this->db->distinct();	
	$this -> db -> select('cidade');	
	$this -> db -> from('imovel'); 	
	$this -> db -> order_by('imovel.cidade');	
	$this -> db -> where('imovel.id_contratante', $idContratante);     
	$query = $this -> db -> get();   
	  if($query -> num_rows() <> 0) {     
		return $query->result();   
		} else{     
		return false;  
	 }     
 }
 
    function listarEstado($idContratante){	
	$this->db->distinct();	
	$this -> db -> select('estado as uf');	
	$this -> db -> from('imovel'); 	
	$this -> db -> order_by('imovel.estado');	
	$this -> db -> where('imovel.id_contratante', $idContratante);     
	$query = $this -> db -> get();   
	  if($query -> num_rows() <> 0) {     
		return $query->result();   
		} else{     
		return false;  
	 }     
 }
 
 function contaUploadCnd($idContratante,$usuario,$doze,$onde,$dez,$nove,$oito,$sete,$seis,$cinco,$quatro,$tres,$dois,$um){
   $ano = date('Y');
   $sql = "select count(*) as total,CONCAT(extract(month from data),'/', extract(year from data)) as mes
	from log_tabelas
	where upload = 1
	and log_tabelas.id_usuario = ?
	and log_tabelas.id_contratante = ?
	and extract(YEAR_MONTH from data) in (?,?,?,?,?,?,?,?,?,?,?,?)
	group by extract(YEAR_MONTH from data) ";

   $query = $this->db->query($sql, array( $usuario,$idContratante,$doze,$onde,$dez,$nove,$oito,$sete,$seis,$cinco,$quatro,$tres,$dois,$um));

   //print_r($this->db->last_query());exit;

   $array = $query->result_array(); //array of arrays

   return($array);


 }
 
 
 function contaUploadCndAtual($idContratante,$usuario,$atual){
   $ano = date('Y');
   $sql = "select count(*) as total,CONCAT(extract(month from data),'/', extract(year from data)) as mes
	from log_tabelas
	where upload = 1
	and log_tabelas.id_usuario = ?
	and log_tabelas.id_contratante = ?
	and extract(YEAR_MONTH from data) = (?)";

   $query = $this->db->query($sql, array( $usuario,$idContratante,$atual));

   //print_r($this->db->last_query());exit;

   $array = $query->result_array(); //array of arrays

   return($array);


 }
 
function buscaEstado($id_contratante){    
	$sql = "SELECT 	count(*) as total, `estado`,round((	(count(*)/(select count(*) from imovel where id_contratante=1))*100),1) as porcentagem,cor	FROM (`imovel`)  
	left join estado_cor on imovel.estado = estado_cor.uf				
	WHERE `id_contratante` = ?  GROUP BY `estado` ORDER BY `total` desc ";  
	$query = $this->db->query($sql, array($id_contratante,$id_contratante));     
	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{     
		return false;   
	}        
	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{     
	return false;   }  }       
	function listarImovelByCidade($id){	$this->db->distinct();	$this -> db -> select('imovel.id,imovel.nome');	$this -> db -> from('imovel');	$this -> db -> where('cidade', $id);   	$this -> db -> order_by('imovel.id');	$query = $this -> db -> get();		if($query -> num_rows() <> 0){     return $query->result();	}else{     return false;	} }
	
	function listarCidadeByEstado($idContratante,$id){   
		
		$this->db->distinct();   
		$this -> db -> select('imovel.cidade'); 
		$this -> db -> from('imovel');      
		$this -> db -> where('imovel.estado', $id);   
		$this -> db -> where('imovel.id_contratante', $idContratante);   
		$this -> db -> order_by('imovel.cidade');   
		$query = $this -> db -> get();     
		if($query -> num_rows() <> 0){    
		return $query->result();   
		}else{     return 0;   
		} 
	}      
	
	function listarCidades($idContratante){   
		
		$this->db->distinct();   
		$this -> db -> select('imovel.cidade'); 
		$this -> db -> from('imovel');      
		$this -> db -> where('imovel.id_contratante', $idContratante);   
		$this -> db -> order_by('imovel.cidade');   
		$query = $this -> db -> get();     
		if($query -> num_rows() <> 0){    
			return $query->result();   
		}else{     
			return 0;   
		} 
	} 
	
	function listarImovelByUf($id_contratante,$estado){   
		$this -> db -> select('*,imovel.id as id_imovel,(select count(*) as combo from emitente_imovel where id_imovel = imovel.id and id_emitente <> 0) as combo');   
		$this -> db -> from('imovel');   
		$this -> db -> join('tipo_situacao','imovel.situacao = tipo_situacao.id','left');   
		$this -> db -> where('imovel.estado', $estado);      
		$this -> db -> where('imovel.id_contratante', $id_contratante);      
		$query = $this -> db -> get();  
		
			if($query -> num_rows() <> 0){     
				return $query->result();   
			}else{     
		return 0;   
		} 
	}  

	function listarImovelByCidadeLista($id_contratante,$cidade){   
	$this -> db -> select('*,imovel.id as id_imovel,(select count(*) as combo from emitente_imovel where id_imovel = imovel.id and id_emitente <> 0) as combo');   
	$this -> db -> from('imovel');  
	$this -> db -> join('tipo_situacao','imovel.situacao = tipo_situacao.id','left');   
	$this -> db -> where('imovel.id_contratante', $id_contratante);      
	$this -> db -> where('imovel.cidade', $cidade);
	$query = $this -> db -> get();     
	if($query -> num_rows() <> 0){     
	return $query->result();   }else{     
	return 0;   } }  
	
	function listarImovelByEstado($id){	$this->db->distinct();	$this -> db -> select('imovel.id,imovel.nome');	$this -> db -> from('imovel');	$this -> db -> where('estado', $id);   	$this -> db -> order_by('imovel.id');	$query = $this -> db -> get();		if($query -> num_rows() <> 0) {     return $query->result();	}else{     return false;   } }  function listarImovelByNome($nome){	$this->db->distinct();	$this -> db -> select('count(*) as total');	$this -> db -> from('imovel');	$this -> db -> where('nome', $nome);	$query = $this -> db -> get();		if($query -> num_rows() <> 0) {     return $query->result();	}else{     return false;   } }     
	
	function listarTodasCidades(){   $this->db->distinct();   $this -> db -> select('imovel.cidade');   $this -> db -> from('imovel');      $this -> db -> order_by('imovel.cidade');   $query = $this -> db -> get();     if($query -> num_rows() <> 0){     return $query->result();   }else{     return 0;   } }  function listarImoveis($idContratante){   $this->db->distinct();   $this -> db -> select('imovel.nome');   $this -> db -> from('imovel');      $this -> db -> order_by('imovel.nome');   $this -> db -> where('id_contratante', $idContratante);   $query = $this -> db -> get();      if($query -> num_rows() <> 0){     return $query->result();   }else{     return 0;   } }    
	
	function buscaImSituacao($id_contratante){    
		$sql = "SELECT count(*) as total, `descricao`, `tipo_situacao`.`id` as id ,			
			round((count(*) / (select count(*) from imovel where id_contratante = ?) *100 ),1) as porc			
			FROM (`imovel`) LEFT JOIN `tipo_situacao` ON `imovel`.`situacao` = `tipo_situacao`.`id` 			
			WHERE `id_contratante` = ? GROUP BY `descricao`";   
		$query = $this->db->query($sql, array($id_contratante,$id_contratante));        
		if($query -> num_rows() <> 0){
			return $query->result();   
		}else{     
			return false;   
		}  
	}  

	function buscaTotalLoja($id_contratante){    
		$sql = "SELECT count(*) as total from loja WHERE `id_contratante` = ?";   
		$query = $this->db->query($sql, array($id_contratante));        
		if($query -> num_rows() <> 0){
			return $query->result();   
		}else{     
			return false;   
		}  
	}     
	function buscaCNDMobiliaria($id_contratante){     
		$sql = "SELECT count(*) as total, 
		case cnd_mobiliaria.possui_cnd when 1 then 'S' when 2 then 'N' when 3 then 'P' end as tipo			 
		from cnd_mobiliaria 			
		WHERE `id_contratante` = ? group by cnd_mobiliaria.possui_cnd
		union 
		select count(*) as total, 'Nada Consta' from loja l
		JOIN `emitente` ON `emitente`.`id` = l.`id_emitente` 
		JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		JOIN `regional` ON `regional`.`id` = l.`regional` 
		JOIN `bandeira` ON `bandeira`.`id` = l.`bandeira` 
		where l.id not in (select id_loja from cnd_mobiliaria) and l.id_contratante = ? 
		order by tipo desc
		";   
		$query = $this->db->query($sql, array($id_contratante,$id_contratante)); 

		if($query -> num_rows() <> 0){     
			return $query->result();   
			}else{     
			return false;   
			}  
		}
		
		function buscaCNDEstadual($id_contratante){     
			$sql = "SELECT count(*) as total, 
			case cnd_estadual.possui_cnd when 1 then 'Sim' when 2 then 'Nao' when 3 then 'Pendente' end as tipo			 
			from cnd_estadual 			
			WHERE `id_contratante` = ? group by cnd_estadual.possui_cnd
			union 
			select count(*) as total, 'Nada Consta' from loja l
			JOIN `emitente` ON `emitente`.`id` = l.`id_emitente` 
			JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
			JOIN `regional` ON `regional`.`id` = l.`regional` 
			JOIN `bandeira` ON `bandeira`.`id` = l.`bandeira` 
			where l.id not in (select id_loja from cnd_estadual) and l.id_contratante = ? 
			order by tipo desc
			";   
			$query = $this->db->query($sql, array($id_contratante,$id_contratante)); 

			if($query -> num_rows() <> 0){     
				return $query->result();   
				}else{     
				return false;   
				}  
		}
		function buscaCNDImobiliariaUFS($id_contratante,$ano_ref){ 
		$sql = "select total_possui,tipo,email,total,ufs from (
				SELECT count(*) as total_possui,			
				case c.possui_cnd 			
				when 1 then 'Sim'			
				when 2 then 'Nao'			
				when 3 then 'Pendente'			
				end as tipo	,usuarios.nome_usuario as email,GROUP_CONCAT(distinct uf ORDER BY uf ASC SEPARATOR ',') as ufs,
				(select count(*) from cnd_imobiliaria c2 where id_contratante = ? and c2.possui_cnd = c.possui_cnd) as total
				from cnd_imobiliaria c		
				left join iptu i on c.id_iptu = i.id 
				left join imovel on i.id_imovel = imovel.id
				left join cepbr_estado on cepbr_estado.uf = imovel.estado
				join usuario_uf on usuario_uf.id_uf = cepbr_estado.id_uf
				left join usuarios on usuarios.id = usuario_uf.id_usuario
				WHERE imovel.id_contratante = ?	and i.ano_ref = ?	
				group by c.possui_cnd,	usuarios.email	
				union 
				SELECT count(*) as total_possui,'Nada Consta' ,usuarios.nome_usuario as email,GROUP_CONCAT(distinct uf ORDER BY uf ASC SEPARATOR ',') as ufs,
				(select count(*) as total 
				from iptu ipt left join imovel imo on imo.id = ipt.id_imovel where ipt.ano_ref = ? and imo.id_contratante =?  	) as total_geral		 
				FROM (`imovel`) left JOIN `iptu` ON `imovel`.`id` = `iptu`.`id_imovel` 
				LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas` 
				left join cepbr_estado on cepbr_estado.uf = imovel.estado
				join usuario_uf on usuario_uf.id_uf = cepbr_estado.id_uf
				left join usuarios on usuarios.id = usuario_uf.id_usuario
				WHERE iptu.`id` not in (select id_iptu from cnd_imobiliaria where id_contratante = ? ) and iptu.ano_ref = ? AND `imovel`.`id_contratante` = ?	 
				group by usuarios.email	
				order by tipo desc ) as aux order by email,total_possui
		";   
		//$id_contratante,$id_contratante;$ano_ref,$ano_ref,$id_contratante,$id_contratante,$ano_ref,$id_contratante
		$query = $this->db->query($sql, array($id_contratante,$id_contratante,$ano_ref,$ano_ref,$id_contratante,$id_contratante,$ano_ref,$id_contratante)); 

		if($query -> num_rows() <> 0){     
			return $query->result();   
		}else{     
			return false;   
		} 
		}
		function buscaCNDMobiliariaUFS($id_contratante){     
		$sql = "select total_possui,tipo,email,total,ufs from (
		SELECT count(*) as total_possui,
		case cnd_mobiliaria.possui_cnd when 1 then 'Sim' when 2 then 'Nao' when 3 then 'Pendente' end as tipo,
		usuarios.nome_usuario as email,(select count(*) from cnd_mobiliaria c1 WHERE id_contratante = 1 and c1.possui_cnd = cnd_mobiliaria.possui_cnd) 	as total,
		uf as ufs	 
		from loja
		join cnd_mobiliaria on loja.id = cnd_mobiliaria.id_loja
		left join cepbr_estado on cepbr_estado.uf = loja.estado
		join usuario_uf on usuario_uf.id_uf = cepbr_estado.id_uf
		left join usuarios on usuarios.id = usuario_uf.id_usuario
		WHERE loja.id_contratante = ? 
		group by cnd_mobiliaria.possui_cnd,	usuarios.email	
		union 
		select count(*) as total_possui,'Nada Consta' as tipo,	usuarios.nome_usuario as email	,
		(select count(*) from 	loja WHERE id_contratante = 1 	and l.id not in (select id_loja from cnd_mobiliaria WHERE id_contratante = 1 ))  as total,
		uf as ufs		 
		from loja l
		left join cepbr_estado on l.estado = cepbr_estado.uf
		join usuario_uf on usuario_uf.id_uf = cepbr_estado.id_uf
		left join usuarios on usuarios.id = usuario_uf.id_usuario
		where  l.id_contratante = ?
		and l.id not in (select id_loja from cnd_mobiliaria WHERE id_contratante = 1  )
		group by usuarios.email	) as aux order by email,total_possui
		";   
		$query = $this->db->query($sql, array($id_contratante,$id_contratante)); 

		if($query -> num_rows() <> 0){     
			return $query->result();   
		}else{     
			return false;   
		}  
		}
		
	function buscaTotalCNDMobiliaria($id_contratante){     
			$sql = "select sum(total) as total from( 
			SELECT count(*) as total from cnd_mobiliaria WHERE `id_contratante` = ?
			union
			select count(*) as total from loja l
			JOIN `emitente` ON `emitente`.`id` = l.`id_emitente` 
			JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
			JOIN `regional` ON `regional`.`id` = l.`regional` 
			JOIN `bandeira` ON `bandeira`.`id` = l.`bandeira` 
			 where l.id not in (select id_loja from cnd_mobiliaria) and l.id_contratante = ?) as aux
		";    
		$query = $this->db->query($sql, array($id_contratante,$id_contratante)); 

		if($query -> num_rows() <> 0){     
			return $query->result();   
			}else{     
			return false;   
			}  
		}
		
			function buscaTotalCNDEstadual($id_contratante){     
			$sql = "select sum(total) as total from( 
			SELECT count(*) as total from cnd_estadual WHERE `id_contratante` = ?
			union
			select count(*) as total from loja l
			JOIN `emitente` ON `emitente`.`id` = l.`id_emitente` 
			JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
			JOIN `regional` ON `regional`.`id` = l.`regional` 
			JOIN `bandeira` ON `bandeira`.`id` = l.`bandeira` 
			 where l.id not in (select id_loja from cnd_estadual) and l.id_contratante = ?) as aux
		";    
		$query = $this->db->query($sql, array($id_contratante,$id_contratante)); 

		if($query -> num_rows() <> 0){     
			return $query->result();   
			}else{     
			return false;   
			}  
	}function buscaCNDObras($id_contratante){     	$sql = "SELECT count(*) as total,case c.possui_cnd 	when 1 then 'S'	when 2 then 'N'	when 3 then 'P'	end as tipo	from cnd_obras c WHERE `id_contratante` = ?	group by c.possui_cnd";  	$query = $this->db->query($sql, array($id_contratante));     	if($query -> num_rows() <> 0){     		return $query->result();   	}else{     		return false;   	}  }  
function buscaCNDImobiliaria($id_contratante,$ano){     
	$sql = "SELECT count(*) as total,			
	case c.possui_cnd 			
	when 1 then 'S'			
	when 2 then 'N'			
	when 3 then 'P'			
	end as tipo			
	from cnd_imobiliaria c		
	left join iptu i on c.id_iptu = i.id 
	WHERE `id_contratante` = ?	and i.ano_ref = ?	
	group by c.possui_cnd
	union 
	SELECT count(*) as total,'Nada Consta' 
	FROM (`imovel`) left JOIN `iptu` ON `imovel`.`id` = `iptu`.`id_imovel` 
	LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas` 
	WHERE iptu.`id` not in (select id_iptu from cnd_imobiliaria ) and ano_ref = ? AND `imovel`.`id_contratante` = ?	 
	order by tipo desc";  
	$query = $this->db->query($sql, array($id_contratante,$ano,$ano,$id_contratante));     
	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{     
		return false;   
	}  
}  

function buscaTotalMatrCei($id_contratante){     
	$sql = "select count(*) as total from matricula_cei where id_contratante = ?";  
	$query = $this->db->query($sql, array($id_contratante));     
	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{     
		return false;   
	}  
} 

function buscaTotalCNDImobiliaria($id_contratante,$ano){     
	$sql = "select sum(total) as total from( 
	SELECT count(`cnd_imobiliaria`.`possui_cnd`) as total FROM (`imovel`) 
	JOIN `iptu` ON `imovel`.`id` = `iptu`.`id_imovel`  
	JOIN `cnd_imobiliaria` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id`  
	where iptu.ano_ref = ? and imovel.id_contratante = ? GROUP BY `cnd_imobiliaria`.`possui_cnd`  
	union select count(*) as total from iptu where id not in 
	(select c.id_iptu from cnd_imobiliaria c where id_contratante = ?) and ano_ref = ?) as aux";  
	$query = $this->db->query($sql, array($ano,$id_contratante,$id_contratante,$ano));     
	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{     
		return false;   
	}  
} 
   
function buscaEstadoPorSituacao($id,$id_contratante){   $this -> db -> select('count(*) as total, imovel.estado' );   $this -> db -> from('imovel');   $this -> db -> join('tipo_situacao','imovel.situacao = tipo_situacao.id','left');   $this -> db -> where('id_contratante', $id_contratante);   $this -> db -> where('imovel.situacao', $id);   $this -> db -> group_by('estado');   $query = $this -> db -> get();     if($query -> num_rows() <> 0){     return $query->result();   }else{     return false;   }  }     

function buscaIptuTotal($anoAtual,$idContratante){        
	$sql = "select COALESCE(round(sum(replace(REPLACE(ip.valor, '.', ''),',','.')),1), 0) as total	
			FROM (`imovel`) left JOIN iptu as ip  ON ip.`id_imovel` = `imovel`.`id` 
			and ip.ano_ref = ?	 WHERE `id_contratante` = ? ";   
	$query = $this->db->query($sql, array($idContratante,$anoAtual));  
	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{     
		return false;  
	}  
 } 
 
 
function buscaIptuEstadoAnoUnico($anoAtual,$idContratante,$estados){        
	$sql = "select estado_cor.uf as estado,estado_cor.cor,(select COALESCE(round(sum(replace(REPLACE(ip.valor, '.', ''),',','.')),1), 0) as primeiro					
	FROM (`imovel`) left JOIN iptu as ip ON ip.`id_imovel` = `imovel`.`id` and ip.ano_ref = ?					
	WHERE `id_contratante` = ? and estado_cor.uf = imovel.estado ) as primeiro			
	from estado_cor where  estado_cor.uf in ($estados) 			";   
	$query = $this->db->query($sql, array($anoAtual,$idContratante,$estados));     
	if($query -> num_rows() <> 0){     
	return $query->result();   
	}else{     
	return false;  
 }  
 }       

function buscaIptuEstadoAno($anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro,$idContratante,$estados){      $sql = "SELECT estado,				COALESCE(round(sum(replace(REPLACE(ip.valor, '.', ''),',','.')),1), 0) as  primeiro,				COALESCE(round(sum(replace(REPLACE(ip1.valor, '.', ''),',','.')),1), 0) as segundo,				COALESCE(round(sum(replace(REPLACE(ip2.valor, '.', ''),',','.')),1), 0) as terceiro,				COALESCE(round(sum(replace(REPLACE(ip3.valor, '.', ''),',','.')),1), 0) as quarto,				COALESCE(round(sum(replace(REPLACE(ip4.valor, '.', ''),',','.')),1), 0) as quinto				FROM (`imovel`) left JOIN iptu  as ip ON ip.`id_imovel` = `imovel`.`id` 				and ip.ano_ref = ?				left JOIN iptu as ip1 ON ip1.`id_imovel` = `imovel`.`id` 				and ip1.ano_ref = ?				left JOIN iptu as ip2 ON ip2.`id_imovel` = `imovel`.`id` 				and ip2.ano_ref = ?				left JOIN iptu as ip3 ON ip3.`id_imovel` = `imovel`.`id` 				and ip3.ano_ref = ?				left JOIN iptu as ip4 ON ip4.`id_imovel` = `imovel`.`id` 				and ip4.ano_ref = ?				WHERE `id_contratante` = ? 				and imovel.estado in ($estados)				group by estado				order by primeiro desc			";   $query = $this->db->query($sql, array($anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro,$idContratante,$estados));     if($query -> num_rows() <> 0){     return $query->result();   }else{     return false;   }   }     

function buscaIptuEstado($id_contratante,$ano){      
	$sql = "SELECT cor,		
	COALESCE(round(sum(replace(REPLACE(valor, '.', ''),',','.')),1), 0) as total,		round((		COALESCE(round(sum(replace(REPLACE(valor, '.', ''),',','.')),1), 0) /		(		SELECT 		COALESCE(round(sum(replace(REPLACE(valor, '.', ''),',','.')),1), 0) 		FROM (`imovel`) left JOIN iptu ON iptu.`id_imovel` = `imovel`.`id` 		WHERE `id_contratante` = ? and iptu.ano_ref = ?) * 100),1) as porcentagem,		estado FROM (`imovel`) 		left JOIN iptu ON iptu.`id_imovel` = `imovel`.`id` 		
	left join estado_cor on imovel.estado = estado_cor.uf		
	WHERE `id_contratante` = ? and iptu.ano_ref = ?		
	group by imovel.estado		
	order by imovel.estado desc			";   
	
	$query = $this->db->query($sql, array($id_contratante,$ano,$id_contratante,$ano));  
  	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{    
		return false;   
	}   
}    
    

function listarTodosImoveis($id_contratante){  
	$this -> db -> select('imovel.id,imovel.nome,imovel.situacao,imovel.area_total,imovel.area_construida,imovel.combo,imovel.cep, imovel.numero, imovel.rua,imovel.bairro,imovel.cidade,imovel.estado,imovel.ativo,tipo_situacao.descricao,(select count(*) as combo from emitente_imovel where id_imovel = imovel.id and id_emitente <> 0) as combo');  
	$this -> db -> from('imovel');   
	$this -> db -> join('tipo_situacao','imovel.situacao = tipo_situacao.id','left');   
	$this -> db -> where('id_contratante', $id_contratante);    
	$this -> db -> order_by('imovel.id');   
	$query = $this -> db -> get();     
	if($query -> num_rows() <> 0){     
		return $query->result();   
	}else{     
		return false;   
	} 
}   

function listarImovel($id_contratante,$_limit = 30, $_start = 0 ){   
	$this->db->limit( $_limit, $_start ); 	   
	$this -> db -> select('imovel.id,imovel.nome,imovel.situacao,imovel.area_total,imovel.area_construida,imovel.combo,imovel.cep, imovel.numero, imovel.rua,imovel.bairro,imovel.cidade,imovel.estado,imovel.ativo,tipo_situacao.descricao,(select count(*) as combo from emitente_imovel where id_imovel = imovel.id and id_emitente <> 0) as combo');   
	$this -> db -> from('imovel');   
	$this -> db -> join('tipo_situacao','imovel.situacao = tipo_situacao.id','left');   
	$this -> db -> where('id_contratante', $id_contratante);     
	$this -> db -> order_by('imovel.id');   
	$query = $this -> db -> get();     
	if($query -> num_rows() <> 0){     
		return $query->result();
	}else{
		return false;   
	} 
} 

function listarTodosImovel($id_contratante){   
	//$this->db->limit( $_limit, $_start ); 	   
	$this -> db -> select('imovel.id,imovel.nome,imovel.situacao,imovel.area_total,imovel.area_construida,imovel.combo,imovel.cep, imovel.numero, imovel.rua,imovel.bairro,imovel.cidade,imovel.estado,imovel.ativo,tipo_situacao.descricao,(select count(*) as combo from emitente_imovel where id_imovel = imovel.id and id_emitente <> 0) as combo');   
	$this -> db -> from('imovel');   
	$this -> db -> join('tipo_situacao','imovel.situacao = tipo_situacao.id','left');   
	$this -> db -> where('id_contratante', $id_contratante);     
	$this -> db -> order_by('imovel.id');   
	$query = $this -> db -> get();  

	
	if($query -> num_rows() <> 0){     
		return $query->result();
	}else{
		return false;   
	} 
}

function somarTodos($idContratante){	$this -> db -> select('count(*) as total');   $this -> db -> from('imovel');   $this -> db -> where('id_contratante', $idContratante);       $query = $this -> db -> get();     if($query -> num_rows() <> 0) {     return $query->result();   } else {     return false;   }  }
		
		
function listarImovelCsv($id_contratante){  
	$ano = date('Y');
	$sql = "SELECT
		`imovel`.`id`, `imovel`.`nome`, `imovel`.`situacao`, `imovel`.`area_total`, `imovel`.`area_construida`, `imovel`.`combo`, `imovel`.`cep`, `imovel`.`numero`, `imovel`.`rua`, `imovel`.`bairro`, `imovel`.`cidade`, `imovel`.`estado`, `imovel`.`ativo`, `tipo_situacao`.`descricao`, `emitente`.`nome_fantasia` as razao_social, `emitente_imovel`.`area`, (select count(*) as combo from emitente_imovel where id_imovel = imovel.id and id_emitente <> 0) as combo,
		(select round(sum(replace(REPLACE(iptu.area_total, '.', ''),',','.')),2) from iptu  where iptu.id_imovel = imovel.id and iptu.ano_ref = ? )	as area_total_iptu,
		(select round(sum(replace(REPLACE(iptu.area_construida, '.', ''),',','.')),2) from iptu where iptu.id_imovel = imovel.id and iptu.ano_ref = ? )	as area_construida_iptu		
		FROM (`imovel`) 
		LEFT JOIN `tipo_situacao` ON `imovel`.`situacao` = `tipo_situacao`.`id` 
		LEFT JOIN `emitente_imovel` ON `emitente_imovel`.`id_imovel` = `imovel`.`id` 
		JOIN `emitente` ON `emitente`.`id` = `emitente_imovel`.`id_emitente` 
		WHERE `imovel`.`id_contratante` = ? ORDER BY `imovel`.`id`";
   $query = $this->db->query($sql, array($ano,$ano,$id_contratante));
   //print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){     
		return $query->result();  
	}else{    
	return false;   
	} 
} 

function listarEmitenteImovelById($id_imovel_emitente){	    $this -> db -> select('emitente_imovel.id,imovel.nome,emitente.nome_fantasia as razao_social ,emitente_imovel.area');   $this -> db -> from('imovel');    $this -> db -> join('emitente_imovel','emitente_imovel.id_imovel = imovel.id','left');      $this -> db -> join('emitente','emitente.id = emitente_imovel.id_emitente','left');     $this -> db -> where('emitente_imovel.id', $id_imovel_emitente);      $query = $this -> db -> get();   if($query -> num_rows() <> 0)   {     return $query->result();   }   else   {     return false;   } }  	 public function log($detalhes = array()){		if($this->db->insert('log_tabelas', $detalhes)) {			$id = $this->db->insert_id();			return $id;		}		return false;	}  function listarTipoSituacaoById($id){   $this -> db -> select('*');   $this -> db -> from('tipo_situacao');   $this -> db -> where('tipo_situacao.id', $id);      $query = $this -> db -> get();    if($query -> num_rows() <> 0){     return $query->result();   }else{     return false;   } } 

function listarImovelById($id_contratante,$id){  
 $this -> db -> select('imovel.id,imovel.nome,imovel.situacao,imovel.area_total,imovel.area_construida,imovel.combo,imovel.cep, imovel.numero, imovel.rua,imovel.bairro,imovel.cidade,imovel.estado,tipo_situacao.descricao,imovel.ativo,imovel.id as id_imovel,(select count(*) as combo from emitente_imovel where id_imovel = imovel.id and id_emitente <> 0) as combo');   
 $this -> db -> from('imovel');   
 $this -> db -> join('tipo_situacao','imovel.situacao = tipo_situacao.id','left');   
 $this -> db -> where('id_contratante', $id_contratante);   
 $this -> db -> where('imovel.id', $id);      
 $query = $this -> db -> get();   
 //print_r($this->db->last_query());exit; 
 if($query -> num_rows() <> 0){    
 return $query->result();   }else{     return false;   } }
 
 function listarImovelEmitente($id_contratante,$id){	    
	$this -> db -> select('*,emitente_imovel.id as id_emitente_imovel');   
	$this -> db -> from('emitente');   
	$this -> db -> join('emitente_imovel','emitente.id = emitente_imovel.id_emitente','left');      
	$this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel','left');      
	$this -> db -> join('tipo_situacao','tipo_situacao.id = imovel.situacao','left');      
	$this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');   
	$this -> db -> where('emitente.id_contratante', $id_contratante);      
	$this -> db -> where('imovel.id', $id);     
	$query = $this -> db -> get();     
	if($query -> num_rows() <> 0)   {     
		return $query->result();   
	}else{     
	return false;   
	} 
	print_r($this->db->last_query());exit; 
} 

function excluir($id){	$data = array('ativo' => 2);	$this->db->where('id', $id);	$this->db->update('imovel', $data); 	return true; }   
 
 function excluir_emitente_imovel($id){	$this->db->where('id', $id);	$this->db->delete('emitente_imovel'); 	return true; } 
function atualizar($dados,$id){ 	
	$this->db->where('id', $id);	
	$this->db->update('imovel', $dados); 	
	
	return true;  
}   
	
	function verificaCPF($cpf,$tipo_pessoa){   $this -> db -> select('count(*) as total');   $this -> db -> from('emitente');   $this -> db -> where('cpf_cnpj', $cpf);   $this -> db -> where('tipo_pessoa', $tipo_pessoa);    $query = $this -> db -> get();	      if($query -> num_rows() <> 0)   {     return $query->result();   }   else   {     return false;   } }  function verificaEmail($email){   $this -> db -> select('count(*) as total');   $this -> db -> from('emitente');   $this -> db -> where('email_resp', $email);       $query = $this -> db -> get();	      if($query -> num_rows() <> 0)   {     return $query->result();   }   else   {     return false;   } }  
	public function add($detalhes = array()){ 	
		if($this->db->insert('imovel', $detalhes)){
			$id = $this->db->insert_id();				
				return $id;	
			}		
		return false;	
		}	
	}?>
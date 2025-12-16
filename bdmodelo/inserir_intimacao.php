<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$dbh = new PDO('mysql:host=localhost;dbname=bd_protesto', 'root', '', array(PDO::ATTR_PERSISTENT => true));
$handle = fopen('carga.csv', "r");
$n_linha=0;
while (($data = fgetcsv($handle,2000, ";")) !== FALSE) {
    if($n_linha == 0){
    }else{
		$id_contratante = 1;
		
		$cnpj = $data[4];
		$ie = trim($data[5]);		
		$im = trim($data[6]);	
		
		$num_processo = $data[7];
		$num_lancamento = $data[8];
		$natureza = $data[9];
		$competencia = $data[10];
		$valor_principal = $data[11];
		$total = $data[12];
		$data_ciencia = $data[13];
		$prazo = $data[14];
		$nome_fiscal = utf8_encode(trim($data[15]));
		$responsavel_fiscalizacao = utf8_encode(trim($data[16]));
		$numero_os = $data[17];
		$periodo_auditado_inicial = $data[18];
		$periodo_auditado_final = $data[19];
		$loja = $data[20];

		$valor_principal = str_replace("R$","",$valor_principal);
		$valor_principal = str_replace(".","",$valor_principal);
		$valor_principal = str_replace(",",".",$valor_principal);
		
		$total = str_replace("R$","",$total);
		$total = str_replace(".","",$total);
		$total = str_replace(",",".",$total);

		if(!empty($data_ciencia)){
			$data_ciencia_arr = explode('/',$data_ciencia);
			
			$data_ciencia = $data_ciencia_arr[2].'-'.$data_ciencia_arr[1].'-'.$data_ciencia_arr[0];
		}else{		
			$data_ciencia = '0';
		}
	
		if(!empty($prazo)){
			$prazo_arr = explode('/',$prazo);
			$prazo = $prazo_arr[2].'-'.$prazo_arr[1].'-'.$prazo_arr[0];
		}else{		
			$prazo = '0';
		}
		
		

		if(!empty($periodo_auditado_inicial)){
			$periodo_auditado_inicial_rrr = explode('/',$periodo_auditado_inicial);
			$periodo_auditado_inicial = $periodo_auditado_inicial_rrr[2].'-'.$periodo_auditado_inicial_rrr[1].'-'.$periodo_auditado_inicial_rrr[0];
		}else{
			$periodo_auditado_inicial = '0';
		}
		

		if(!empty($periodo_auditado_final)){
			$periodo_auditado_final_rrr = explode('/',$periodo_auditado_final);
			$periodo_auditado_final = $periodo_auditado_final_rrr[2].'-'.$periodo_auditado_final_rrr[1].'-'.$periodo_auditado_final_rrr[0];
		}else{
			$periodo_auditado_final = '0';
		}
		
		
		$consulta = $dbh->prepare("SELECT id as id_competencia FROM competencia_legis e  WHERE e.descricao ='$competencia'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_competencia_legis = $dados['id_competencia'];
		

		$consulta = $dbh->prepare("SELECT id as id FROM natureza e  WHERE e.descricao_natureza ='$natureza'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_natureza = $dados['id'];
		
		
		$consulta = $dbh->prepare("SELECT id as id_cnpj FROM cnpj e  WHERE e.cnpj ='$cnpj'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_cnpj = $dados['id_cnpj'];
		
		$consulta = $dbh->prepare("SELECT id as id_im FROM inscricao e  WHERE e.id_cpnj ='$id_cnpj' and e.numero ='$im' and e.tipo = 1");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_im = $dados['id_im'];
		
		$consulta = $dbh->prepare("SELECT id as id_ie FROM inscricao e  WHERE e.id_cpnj ='$id_cnpj' and e.numero ='$ie' and e.tipo = 2");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_ie = $dados['id_ie'];
		
		print$sql = "insert into intimacoes  	
				(id_cnpj,id_ie,id_im,num_lancamento,num_processo,id_natureza,id_competencia_legis,valor_principal,total,data_ciencia,prazo,relato_infracao,ativo,status,nome_fiscal,responsavel_fiscalizacao,numero_os,periodo_auditado_inicial,periodo_auditado_final,loja) 		
				values  		
				('$id_cnpj','$id_ie','$id_im','$num_lancamento','$num_processo','$id_natureza','$id_competencia_legis','$valor_principal','$total','$data_ciencia','$prazo','','1','1','$nome_fiscal','$responsavel_fiscalizacao','$numero_os','$periodo_auditado_inicial','$periodo_auditado_final','$loja');";
			// $stmt = $dbh->prepare($sql);
			// $stmt->execute();
			// $idInserido = $dbh->lastInsertId();
			
		print'<BR>';
	}
	$n_linha++;	
}


fclose($handle);


?>
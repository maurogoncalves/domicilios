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
		
		$num_processo = utf8_encode(trim($data[7]));
		$num_lancamento = utf8_encode(trim($data[8]));
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
		
		$id_classificacao = utf8_encode(trim($data[23]));
		$tipo_intimacao = utf8_encode(trim($data[24]));
		$prazo_interno = $data[25];
		$tributo = $data[26];
		$prazo_final = $data[27];
		$valores_defensaveis = $data[28];
		$status_fiscal = utf8_encode(trim($data[29]));
		
		if(!empty($prazo_final)){
			$prazo_final_arr = explode('/',$prazo_final);
			$data_final = $prazo_final_arr[2].'-'.$prazo_final_arr[1].'-'.$prazo_final_arr[0];
		}else{
			$data_final = '0';
		}
		
		if(!empty($prazo_interno)){
			$prazo_interno_arr = explode('/',$prazo_interno);
			$data_previa_atendimento = $prazo_interno_arr[2].'-'.$prazo_interno_arr[1].'-'.$prazo_interno_arr[0];
		}else{
			$data_previa_atendimento = '0';
		}
		
		$valores_defensaveis = str_replace("R$","",$valores_defensaveis);
		$valores_defensaveis = str_replace(".","",$valores_defensaveis);
		$valores_defensaveis = str_replace(",",".",$valores_defensaveis);

		
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
		
		$consulta = $dbh->prepare("SELECT t.id AS tipo_intimacao FROM tipo_intimacao t WHERE t.descricao_intimacao = '$tipo_intimacao'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_tipo_intimacao = $dados['tipo_intimacao'];
		

		$consulta = $dbh->prepare("SELECT i.id FROM intimacoes i WHERE i.id_cnpj = '$id_cnpj' AND i.id_ie = '$id_ie' AND i.id_im = '$id_im' AND i.num_lancamento ='$num_lancamento' AND i.num_processo ='$num_processo'");
		$consulta->execute();
		$dadosIntimacao = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_intimacao = $dadosIntimacao['id'];
		
		print$sql = "insert into intimacoes_area_fiscal 	
				(id_intimacao,id_classificacao,tipo_intimacao,data_previa_atendimento,data_final,valores_defensaveis,valores_indefensaveis,status_fiscal,campo_complementar_um) 		
				values  		
				('$id_intimacao','$id_classificacao','$id_tipo_intimacao','$data_previa_atendimento','$data_final','$valores_defensaveis','','$status_fiscal','$tributo');";
			// $stmt = $dbh->prepare($sql);
			// $stmt->execute();
			// $idInserido = $dbh->lastInsertId();
			
		print'<BR>';
	}
	$n_linha++;	
}


fclose($handle);


?>
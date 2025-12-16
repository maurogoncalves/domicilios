<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$dbh = new PDO('mysql:host=localhost;dbname=bd_protesto_smart', 'root', '', array(PDO::ATTR_PERSISTENT => true));
$handle = fopen('carga.csv', "r");
$n_linha=0;
while (($data = fgetcsv($handle,2000, ";")) !== FALSE) {
    if($n_linha == 0){
    }else{
		$id_contratante = 1;
		
	
		$cnpjRaiz = $data[0];
		$cnpj = $data[1];		
		$bandeira = $data[2];		
		$cidade = utf8_encode($data[3]);
		$uf = $data[4];
		$nome = $data[5];
		
		
		
		$consulta = $dbh->prepare("SELECT id as id_cnpj FROM cnpj_raiz e  WHERE e.cnpj_raiz ='$cnpjRaiz'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_cnpj = $dados['id_cnpj'];
		
		$consulta = $dbh->prepare("SELECT id as id_bandeira FROM bandeira e  WHERE e.descricao_bandeira ='$bandeira'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_bandeira = $dados['id_bandeira'];
		
		$consulta = $dbh->prepare("SELECT id as id_municipio FROM cidades e  WHERE e.nome ='$cidade' and uf='$uf'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_municipio = $dados['id_municipio'];
		
		
		$consulta = $dbh->prepare("SELECT id as id_uf FROM estados e  WHERE e.uf ='$uf'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_uf = $dados['id_uf'];
		
		print$sql = "insert into cnpj  	
				(id_contratante,id_cnpj_raiz,cnpj,id_bandeira,id_municipio,id_uf,nome,ativo) 		
				values  		
				($id_contratante,'$id_cnpj','$cnpj','$id_bandeira','$id_municipio','$id_uf','$nome',1);";
			// $stmt = $dbh->prepare($sql);
			// $stmt->execute();
			// $idInserido = $dbh->lastInsertId();
			
		print'<BR>';
	}
	$n_linha++;	
}


fclose($handle);


?>
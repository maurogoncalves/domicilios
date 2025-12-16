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
		
		$empresa = $data[0];
		$cnpjRaiz = $data[1];
		$cnpj = $data[4];		
		$bandeira = $data[21];		
		$cidade = utf8_encode(trim($data[3]));
		$uf = $data[2];
		$loja = $data[20];
		
		
		//print"SELECT id as id_cnpj FROM cnpj_raiz e  WHERE e.cnpj_raiz ='$cnpjRaiz'";
		$consulta = $dbh->prepare("SELECT id as id_cnpj FROM cnpj_raiz e  WHERE e.cnpj_raiz ='$cnpjRaiz'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_cnpj = $dados['id_cnpj'];
		
		$consulta = $dbh->prepare("SELECT id as id_bandeira FROM bandeira e  WHERE e.descricao_bandeira ='$bandeira'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_bandeira = $dados['id_bandeira'];
		
		
		$consultaMun = $dbh->prepare("SELECT id as id_municipio FROM cidades e  WHERE e.nome ='$cidade' and uf='$uf'");
		$consultaMun->execute();
		$dadosMun = $consultaMun->fetch(PDO::FETCH_ASSOC);
		$id_municipio = $dadosMun['id_municipio'];
		
		
		$consulta = $dbh->prepare("SELECT id as id_uf FROM estados e  WHERE e.uf ='$uf'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_uf = $dados['id_uf'];
		
		print$sql = "insert into cnpj  	
				(id_contratante,id_cnpj_raiz,cnpj,empresa,id_bandeira,id_municipio,id_uf,ativo,nome) 		
				values  		
				($id_contratante,'$id_cnpj','$cnpj','$empresa','$id_bandeira','$id_municipio','$id_uf',1,'$loja');";
			// $stmt = $dbh->prepare($sql);
			// $stmt->execute();
			// $idInserido = $dbh->lastInsertId();
			
		print'<BR>';
	}
	$n_linha++;	
}


fclose($handle);


?>
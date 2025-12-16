<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$dbh = new PDO('mysql:host=localhost;dbname=bd_protesto', 'root', '', array(PDO::ATTR_PERSISTENT => true));

		
		
		$sth = $dbh->prepare("SELECT af.id,af.campo_complementar_um  from intimacoes i   LEFT JOIN intimacoes_area_fiscal af ON af.id_intimacao = i.id  ");
		$sth->execute();
		$result = $sth->fetchAll();
			foreach($result as $res){											
				$id = ($res['id']);
				$tributo = ($res['campo_complementar_um']);
											
				$consulta = $dbh->prepare("SELECT id FROM tributo_classificacao t WHERE t.id_tributo = $tributo ORDER BY RAND() LIMIT 1  ");
				$consulta->execute();
				$dados = $consulta->fetch(PDO::FETCH_ASSOC);
				$id_classificacao = $dados['id'];
		
				print$sql = "update intimacoes_area_fiscal set id_classificacao = $id_classificacao where  id = $id;";
				
				print'<BR>';
	}
	
		

?>
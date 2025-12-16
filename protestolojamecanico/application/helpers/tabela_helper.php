<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('imprime')){
	function imprime($valor) {
		$retorno ='';
		for($i=1;$i<=$valor;$i++){ 	
			$retorno .= "<td > - </td>";
		}
		return $retorno;
	}
}
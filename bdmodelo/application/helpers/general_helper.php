<?php
function anos(){

  $ano = array(
				"2019" => '2019',
				"2018" => '2018',
				"2017" => '2017',
                "2016" => '2016',
				"2015" => '2015',
				"2014" => '2014',
				"2013" => '2013'
                );
  return $ano;

}

function meses($m){

  
switch ($m) {
    case 1:
        $mes='Jan';
    break;
    case 2:
        $mes='Fev';
    break;
    case 3:
        $mes='Mar';
    break;	
	case 4:
        $mes='Abr';
    break;
	case 5:
        $mes='Mai';
    break;
	case 6:
        $mes='Jun';
    break;
	case 7:
        $mes='Jul';
    break;
	case 8:
        $mes='Ago';
    break;
	case 9:
        $mes='Set';
    break;
	case 10:
        $mes='Out';
    break;
	case 11:
        $mes='Nov';
    break;	
	case 12:
        $mes='Dez';
    break;
	case 13:
        $mes='Total';
    break;
}

  return $mes;

}
?>
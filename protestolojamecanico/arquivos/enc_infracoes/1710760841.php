<?php
/**
 * Class converteArquivosEnec
 *
 * Converte os arquivos NFS (arqid) para um arquivo ZIP com as discriminações das UF/Municipios e nomes dos arquivos.
 *
 * MEC - Ministerio da Educação e Cultura
 * Time - SEB / CGS / STIC
 *
 * @author Alexandre Llemes <alexandre.llemes@mec.gov.br>
 * @author Mauro Roberto <mauro.roberto@mec.gov.br>
 *
 * @date 2023/11/29
 *
 * @version $Id: tags.version.pkg,v 1.0.0 2023-11-29 08:08:27 alexandre.llemes;
 */

ini_set("memory_limit", "-1");
set_time_limit(-1);

session_start();

#Carrega parametros iniciais do simec
include_once "controleInicio.inc";

include_once APPRAIZ . "includes/classes/Modelo.class.inc";
include_once APPRAIZ . "includes/classes/Controle.class.inc";
include_once APPRAIZ . "includes/classes/Visao.class.inc";
include_once APPRAIZ . "includes/library/simec/Listagem.php";
include_once APPRAIZ . "includes/workflow.php";
include_once APPRAIZ . "includes/simec_funcoes.inc";

#carrega as funções específicas do módulo
include_once '_constantes.php';
include_once '_funcoes.php';
include_once '_componentes.php';
include_once 'autoload.php';

initAutoload();

class converteArquivosEnec
{
    private $link;
    private $fileLog = null;

    public function __construct()
    {
        $this->link = pg_connect("host=" . $GLOBALS["servidor_bd"] . " port=" . $GLOBALS["porta_bd"] . " dbname=" . $GLOBALS['nome_bd'] . "  user=" . $GLOBALS["usuario_db"] . " password=" . $GLOBALS["senha_bd"] . "");
    }

    public function __destruct()
    {
        pg_close($this->link);
    }

    public function buscarInfoArquivo($arqId)
    {
        #fazer a carga dos dados de acordo com a ação escolhida
        $sql = <<<EOF
select arqid,
       arqnome,
       arqdescricao,
       arqextensao
from public.arquivo
where arqid = $arqId
EOF;

        $result = pg_query($this->link, $sql);

        if (!$result) {
            ver('Ocorreu um erro.', $result);
            return null;
        }

        $retorno = [];
        while ($row = pg_fetch_assoc($result)) {
            $retorno[] = [
                'arqid' => $row['arqid'],
                'arqnome' => $row['arqnome'],
                'arqdescricao' => $row['arqdescricao'],
                'arqextensao' => $row['arqextensao'],
            ];
        }
        return $retorno;
    }

    public function buscarUFMunByArqId($arqId)
    {
        $sql = <<<EOF
select distinct
    b.epuf as estuf,
    e.estdescricao,
    b.epmuncod as muncod,
    m.estuf as estufmun,
    m.mundescricao,
    b.inep
from educacaoconectada.respostaplanoacao as a
inner join educacaoconectada.escolaperiodo AS b on b.inep = a.rpacodinep
left JOIN territorios.estado AS e ON e.estuf = b.epuf
left join territorios.municipio AS m ON m.muncod = b.epmuncod
where 1=1
  and a.rparespostadescritiva like '%{"arqid":"$arqId"}%'
EOF;

        $result = pg_query($this->link, $sql);

        if (!$result) {
            ver('Ocorreu um erro.', $result);
            return null;
        }

        $retorno = [];
        while ($row = pg_fetch_assoc($result)) {
            $retorno[] = [
                'estuf' => $row['estuf'],
                'muncod' => $row['muncod'],
                'estdescricao' => $row['estdescricao'],
                'estufmun' => $row['estufmun'],
                'mundescricao' => $row['mundescricao'],
                'inep' => $row['inep'],
            ];
        }
        return $retorno;
    }

    public function gravarLog($mensagem)
    {
        if ($this->fileLog == null) {
            $this->fileLog = fopen('/tmp/arquivosEnec.log', 'a');
        }
        fwrite($this->fileLog, $mensagem);
        echo $mensagem;
    }

    public function processar($qtdeRegistros = null)
    {

        $this->fileLog = fopen('/tmp/arquivosEducacaoConectada.log', 'w');

        // Get real path for our folder
        $rootPath = realpath(__DIR__ . '/educacaoconectada');

// Initialize archive object
        $zip = new ZipArchive();

//$zipname = getcwd();
//$zipname = substr($zipname,strrpos($zipname,'\\')+1);
//$zipname = $zipname.'.zip';
        $zipname = '/tmp/arquivosEnec.zip';

// Exclui o arquivo se existir.
        if (is_file($zipname)) {
            unlink($zipname);
        }

//$zip->open($zipname, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->open($zipname, ZipArchive::CREATE);

// Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        $contador = 0;
        $entrada = new DateTime();

        header('Content-type: text/html; charset=UTF-8');

        $this->gravarLog('Inicio: ' . $entrada->format('d/m/Y H:i') . '<br>' . PHP_EOL);
        foreach ($files as $name => $file) {

            /**
             * Retira o arquivo com problema
             */
//      if (in_array(['35174495'], $file->getFilename())) {
//        continue;
//      }

//  ver($file, $file->getFilename(), $name, !$file->isDir() ? 'true' : 'false');

            /**
             * Limita a quantidade de registros lidos.
             */
            if ($qtdeRegistros && $contador >= $qtdeRegistros) {
                break;
            }

            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {

                $contador++;

                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                $arrayArquivo = $this->buscarInfoArquivo($file->getFilename());
                $arrayArquivo = $arrayArquivo[0];

                $fileName = $arrayArquivo['arqnome'] . '.' . $arrayArquivo['arqextensao'];

                $arrayAnexo = $this->buscarUFMunByArqId($file->getFilename());
                $arrayAnexo = $arrayAnexo[0];

                // Verifica se é ente estadual
                if ($arrayAnexo) {
                    $estuf = $arrayAnexo['estufmun'];
                    if (is_null($estuf)) {
                        $estuf = $arrayAnexo['estuf'];
                    }
                    $relativePath = $estuf . DIRECTORY_SEPARATOR . $estuf . '_' . $arrayAnexo['mundescricao'] . "_" . $arrayAnexo['inep'] . "_" . $fileName;
                } else {
                    $relativePath = 'Nao-encontrado' . DIRECTORY_SEPARATOR . $file->getFilename() . ' - ' . $fileName;
                }

                $this->gravarLog('Convertendo arquivo: ' . $file->getFilename() . ' - ' . $relativePath . '<br>' . PHP_EOL);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

// Zip archive will be created only after closing object
        $zip->close();

        $saida = new DateTime();
        $intervalo = $saida->diff($entrada);

        $this->gravarLog('Termino: ' . $saida->format('d/m/Y H:i') . '<br>' . PHP_EOL);
        $this->gravarLog('Tempo gasto: ' . $intervalo->h . ':' . $intervalo->i . ':' . $intervalo->s . ' segundos. <br>' . PHP_EOL);
        $this->gravarLog('Quantidade de arquivos convertidos: ' . $contador . '<br>' . PHP_EOL);
        $this->gravarLog('FIM');

        fclose($this->fileLog);

//header( "Content-type: application/octet-stream" );
//header('Content-Disposition: attachment; filename="'.basename($zipname).'"');
//header('Content-Length: ' . filesize($zipname));
//header( "Pragma: no-cache" );
//header( "Expires: 0" );
//readfile( "{$zipname}" );

    }

}

$converteArquivosEnec = new converteArquivosEnec(10);
$converteArquivosEnec->processar();

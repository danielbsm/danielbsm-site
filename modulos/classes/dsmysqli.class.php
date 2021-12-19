<?php
$PageRequest = strtolower(basename($_SERVER['REQUEST_URI']));
$PageName = strtolower(basename(__FILE__));
if ($PageRequest == $PageName)	exit("<strong> Erro: N&atilde;o &eacute; permitido acessar o arquivo diretamente. </strong>");

include_once('../settings.php');

class dsMysqli
{
    public $CONNECT = NULL;
    
    public function __construct()
    {
        $this->mysqliConnect();
    }

    // REALIZA A CONEXÃO COM O BANCO DE DADOS
    private function mysqliConnect()
    {
        $this->CONNECT = @mysqli_connect(HOST, USER, PASSWORD, DATABASE);

        try{
            if($this->CONNECT == false)
            {
                if(LOGS_ACTIVE == TRUE)
                {
                    $error =   "ERROR: ".mysqli_error($this->CONNECT)." \r\n";
                    $error .=  "Erro ao conectar com o banco de dados \r\n";
                    $this->logs('ERROR_CONNECT', $error);
                }
            }
        }
        catch (Exception $e){

        }

    }

    // EXECUTA AS QUERYS DO SISTEMA
    public function querySite($sql)
    {
        mysqli_set_charset($this->CONNECT,"utf8");
        
        $query = @mysqli_query($this->CONNECT, $sql);
        if($query == false)
        {
            if(LOGS_ACTIVE == TRUE)
            {
                $error =   "ERROR: ".mysqli_error($this->CONNECT)." \r\n";
                $error .=  "SCRIPT:{$sql} \r\n";
                $this->logs('ERROR_QUERY', $error);
            }
        }
        else
        {
            if(LOGS_ACTIVE == TRUE)
            {
                $script = "SCRIPT:{$sql} \r\n";
                $this->logs('QUERY_EXECUTE', $script);
            }

            return $query;
        }
        $query->close();
        $this->CONNECT->close();
    }

    // GERA ARQUIVO LOGS
    private function logs($fileName, $logs)
    {
        include_once("dslogs.class.php");
        $dsLogs = new dsLogs();
        $dsLogs->createLog($fileName, $logs);
    }
}

$dsMysqli = new dsMysqli();

?>
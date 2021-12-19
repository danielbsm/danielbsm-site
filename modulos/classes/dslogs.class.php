<?php
$PageRequest = strtolower(basename($_SERVER['REQUEST_URI']));
$PageName = strtolower(basename(__FILE__));
if ($PageRequest == $PageName)	exit("<strong> Erro: N&atilde;o &eacute; permitido acessar o arquivo diretamente. </strong>");

class dsLogs
{
    public function createLog($logName, $logData)
    {
        if(!file_exists(LOGS_DIR."/{$logName}.log"))
        {
            $createLog = fopen(LOGS_DIR."/{$logName}.log", "w+");

            $logs = $logData;
            $logs .= "URL: $_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI] \r\n";
            $logs .= "Data de execução: ".date("d/m/Y G:i:s")."\r\n";
            $logs .= "------------------------------------------------------\r\n";

            fwrite($createLog, $logs);
            fclose($createLog);
        }
        else
        {
            $getLog = fopen(LOGS_DIR."/{$logName}.log", "a");

            $logs = $logData;
            $logs .= "URL: $_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI] \r\n";
            $logs .= "Data de execução: ".date("d/m/Y G:i:s")."\r\n";
            $logs .= "------------------------------------------------------\r\n";

            fwrite($getLog, $logs);
            fclose($getLog);
        }
    }
}

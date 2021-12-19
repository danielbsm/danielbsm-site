<?php

include_once('dsmysqli.class.php');

class dsNewslatter extends dsMysqli
{
    public function __construct()
    {
        $this->cadastrarEmail();
    }

    private function cadastrarEmail()
    {
        global $dsMysqli;

        $nome = addslashes($_POST['input_cadastro_newsletter_nome']);
        $email = $_POST['input_cadastro_newsletter_email'];

        if(empty($nome))
        {
            $mensagemRetorno = array('valid' => false, 'message' => 'O campo "Nome" deve ser preenchido!');
        }
        elseif(empty($email))
        {
            $mensagemRetorno = array('valid' => false, 'message' => 'O campo "Endereço de e-mail" deve ser preenchido!');
        }
        elseif(filter_var($email,FILTER_VALIDATE_EMAIL) == false)
        {
            $mensagemRetorno = array('valid' => false, 'message' => 'Endereço de e-mail inválido');
        }
        else
        {
            $valida_email_cadastrado = $dsMysqli->querySite("SELECT * FROM newslatter WHERE newslatter_email = '{$email}'");

            if(mysqli_num_rows($valida_email_cadastrado) >= 1)
            {
                $mensagemRetorno = array('valid' => false, 'message' => 'Endereço de e-mail já cadastrado!');
            }
            else
            {
                $registrar = $dsMysqli->querySite("INSERT INTO newslatter (newslatter_nome, newslatter_email, newslatter_data_cadastro) VALUES ('$nome', '$email', CURRENT_TIMESTAMP)");

                if($registrar)
                {
                    $mensagemRetorno = array('valid' => true, 'message' => 'E-mail cadastrado com sucesso!');
                }
                else
                {
                    $mensagemRetorno = array('valid' => false, 'message' => 'Erro ao cadastrar seu e-mail, tente novamente mais tarde!');
                }
            }
        }

        echo json_encode($mensagemRetorno);
    }
}

$dsNewslatter = new dsNewslatter();

?>
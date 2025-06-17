<?php

//chama a classe externa
//require 'system/helpers/phpmailer.class.php';
require '../../system/helpers/phpmailer.class.php';

/**
 * RESPONSAVEL POR ENVIAR OS EMAIL DO SISTEMA.
 *
 * @author pj
 */
class mail {

    private $Mail;
    private $Data;
    private $Assunto;
    private $Mensagem;
    private $NomeRemetente;
    private $EmailRemetente;
    private $NomeDestino;
    private $EmailDestino;
    
    private $Conominio;
    private $Bloco;
    private $DataVencimento;

    private $Error;
    private $Result;

    // constroi o objeto da classe externa
    function __construct() {
        // passa os valores das constantes do arquivo de configuração
        $this->Mail = new PHPMailer;
        $this->Mail->Host = MAILHOST;
        $this->Mail->Port = MAILPORT;
        $this->Mail->Username = MAILUSER;
        $this->Mail->Password = MAILPASS;
        $this->Mail->CharSet = 'UTF-8';
    }

    public function Enviar(array $data) {
        $this->Data = Check::cleanString($data);
        
        // se existir algum dos atributos do array vazio
        if (in_array('', $this->Data)):
            $this->Error = MSGErro("Preencha todos os <b>Campos</b>!", MSG_ALERT);
            $this->Result = FALSE;
        elseif (!Check::Email($this->Data['duplicate_email'])):
            $this->Error = MSGErro("Preencha campo <b>E-mail</b>corretamente<br> ex.: nome@provedor.com!", MSG_ALERT);
            $this->Result = FALSE;
        else:
            //chama o metodo com os atributos do formulario
            $this->setMail();
            $this->Config();
            $this->sendMail();
        endif;
    }

    //retorna os erros se houver
    public function getError() {
        return $this->Error;
    }

    //retorma valor boleano para validação erros
    public function getResult() {
        return $this->Result;
    }

    // atribui os valores para as variaveis locais
    private function setMail() {
        $this->Assunto = 'Segunda Via Website';
        $this->Mensagem = $this->Data['duplicate_message'];
        $this->NomeRemetente = $this->Data['duplicate_name']." - ".$this->Data['duplicate_email'];
        $this->EmailRemetente = $this->Data['duplicate_email'];
        $this->NomeDestino = 'Darcon ADM';
        $this->EmailDestino = 'darconadm@darconadm.com.br';
        //$this->EmailDestino = 'paulo@ceugreen.com.br';

        $this->Conominio = $this->Data['duplicate_condominium'];
        $this->Bloco = $this->Data['duplicate_block'];
        $this->DataVencimento = $this->Data['duplicate_date'];
        
        //finaliza os atributos do array
        $this->Data = NULL;
        $this->setMsg();
    }

    // metodo para formatar a mensagem
    private function setMsg() {
         $this->Mensagem = "Condomíno: ".$this->NomeRemetente." <br> Condomínio: ".$this->Conominio."<br> Bloco: ".$this->Bloco."<br> Data do Vencimento: ".$this->DataVencimento."<br><hr>".$this->Mensagem." <hr> <small>Enviado em " . date('d/m/Y H:i') . " </small>";
    }

    private function Config() {
        //SMTP AUTH
        $this->Mail->isSMTP();
        $this->Mail->SMTPAuth = TRUE;
        $this->Mail->isHTML();

        //REMETENTE E RETORNO
        // email a ser usado para enviar 
        $this->Mail->From = MAILUSER;
        // nome de quem enviou  
        $this->Mail->FromName = $this->NomeRemetente;
        // email e nome de copia da mensagem       
       // $this->Mail->addReplyTo($this->EmailRemetente, $this->NomeRemetente);

        //ASSUNTO, MENSAGEM E DESTINO
        //assunto
        $this->Mail->Subject = $this->Assunto;
        // mensagem
        $this->Mail->Body = $this->Mensagem;
        // endereço de destino e nome
        $this->Mail->addAddress($this->EmailDestino, $this->NomeDestino);
    }

    private function sendMail() {

        if ($this->Mail->send()):
            $this->Error = MSGErro("Sua mensagem foi <b>enviada</b>! <br> Em Breve tera um retorno. :)", MSG_ACCEPT);
            $this->Result = TRUE;
        else:
            $this->Error = MSGErro("Sua mensagem <b>não</b> foi enviada! <br> Tente novamente. :(", MSG_ALERT);
            $this->Result = FALSE;

        endif;
    }
}

<?php

/** MODEL
 * Responsavel por checar, autenticar,validar o usuario no sistema
 *
 * @author pj
 */
class login {

    private $Level;
    private $Email;
    private $Senha;
    private $Error;
    private $Result;

    function __construct($Level) {
        $this->Level = (int) $Level;
    }

    public function exeLogin(array $UserData) {

        $this->Email = (string) strip_tags(trim($UserData['user']));
        $this->Senha = (string) strip_tags(trim($UserData['pass']));
        $this->setLogin();
    }

    public function getResult() {
        return $this->Result;
    }


    public function getError() {
        return $this->Error;
    }

    public function checkLogin() {

        if (empty($_SESSION['userlogin']) /* || ($_SESSION['userlogin']['user_level'] != $this->Level) */):
            unset($_SESSION['userlogin']);
        else:
            return TRUE;
        endif;
    }

    //PRIVATE
    // valida os dados passados e aramzena os erros caso exista..
    // senao executa o login 
    private function setLogin() {

        if (!$this->Email || !$this->Senha || !Check::Email($this->Email)):
            $this->Erro = MSGErro('Informe seu <b>Email e Senha</b> para entrar.', MSG_ALERT);
            $this->Result = FALSE;
        elseif (!$this->getUser()):
            $this->Erro = MSGErro('Seu <b>Email ou Senha</b> esta errado!', MSG_ALERT);
            $this->Result = FALSE;
        // elseif ($this->Result['user_level'] != $this->Level):
        //   $this->Erro = MSGErro("Desculpe: {$this->Result['user_name']} Você não tem permissão para acessar esta área ", MSG_ERROR);
        // $this->Result = FALSE;
        else:
            $this->executeLogin();
        endif;
    }

//verifica a existencia do usuario e senha no banco e dados
    private function getUser() {
        //$this->Senha = md5($this->Senha);

        $read = new Read;
        $read->exeRead("users", "WHERE user_email = :email AND user_password = :pass", "email={$this->Email}&pass={$this->Senha}");

        if ($read->getResult()):
            // a variavel result recebe o valor de todos os campos no indice zero 
            // ou o mesmo que o primeiro valor encontrado
            $this->Result = $read->getResult()[0];
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    private function executeLogin() {
        if (!session_id()):
            session_start();
        endif;

        $_SESSION['userlogin'] = $this->Result;
        $this->Error = MSGErro("Seja Bem Vindo {$this->Result['user_name']}.", MSG_ACCEPT);
        $this->Result = TRUE;
    }

}

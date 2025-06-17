<?php

#################################################################
#### Classe: Responsavel por manipular os usuarios do sistema
#### Autor: PJ Cordeiro 
#### Data: 18/08/2015

class user {

    private $id;
    private $Result;
    private $Error;
    private $Data;
    private $Nome;
    private $Sobrenome;
    private $Email;
    private $Pass;
    private $Pass2;

    //pega os valores da view por array
    public function exeUser(array $dataUser) {
        // atribui todos os valores para variavel da classe
        $this->Data = $dataUser;
      
        // seta os valores individuais
        $this->Data['user_name'] = Check::pegaString($dataUser['user_email'], '@'); 
        $this->Nome = $this->Data['user_name'];
        $this->Email = $dataUser['user_email'];
        $this->Pass = $dataUser['user_password'];
        $this->Pass2 = $dataUser['user_password_2'];
      

        echo "<pre>";
        var_dump($this->Data) ;
        echo "</pre>";


        // executa o metodo de verificaçao dos dados
        $this->setCreateUser();
        //executa o metodo de cadastro no banco
        $this->exeCreateUser();
    }

    //pega os valores da view por array e o id para editar
    public function exeUserUpdate($id, array $dataUser) {

        $this->id = $id;
        // atribui todos os valores para variavel da classe
        $this->Data = $dataUser;
        // seta os valores individuais 
        $this->Nome = $dataUser['user_name'];
        $this->Sobrenome = $dataUser['user_lastname'];
        $this->Email = $dataUser['user_email'];
        $this->Pass = $dataUser['user_password'];
        $this->Pass2 = $dataUser['user_password_2'];
        
        // executa o metodo de verificaçao dos dados
        $this->setCreateUser();
        //executa o metodo de cadastro no banco
        $this->exeUpdateUser();
    }

    public function exeUserDelete($idDelete) {
        $this->id = $idDelete;
        //$read = new Read();
        //$read->exeRead("users", "WHERE user_id = :id", "id={$this->id}");
        //if (!$read->getResult()):
        // $this->Error = MSGErro("Este <b>Usuário</b> não existe!", MSG_INFOR);
        //$this->Result = FALSE;
        //  header("Location: home.php");
        //else:
        $delete = new Delete();
        $delete->exeDelete("users", "WHERE user_id = :id", "id={$this->id}");

        if ($delete->getResult()):
            $this->Error = MSGErro(" <b>Usuário</b> Removido com Sucesso!", MSG_ACCEPT);
            $this->Result = FALSE;
        else:
            $this->Error = MSGErro(" <b>Usuário</b> Não foi removido!", MSG_ERROR);
            $this->Result = FALSE;

        endif;
        //endif;
    }

    //retorna os erros se houver
    public function getError() {
        return $this->Error;
    }

    //retorma valor boleano para validação erros
    public function getResult() {
        return $this->Result;
    }

#########################
####   Privates   #######
    // metodo para fazer as validaçoes de usuario 
    // com verificação boleana

    private function setCreateUser() {

        if (!$this->Nome or !$this->Email or !$this->Pass or !$this->Pass2):
            $this->Error = MSGErro("Preencha <b>Todos</b> os campos! ", MSG_ALERT);
            $this->Result = FALSE;

        elseif (!Check::Email($this->Email)):
            $this->Error = MSGErro("Preencha campo <b>E-mail</b> ex.: nome@provedor.com!", MSG_ALERT);
            $this->Result = FALSE;

       // elseif ($this->Pass != $this->Pass2):
        elseif (!Check::passVerify($this->Pass, $this->Pass2)):
            $this->Error = MSGErro("Preencha campo <b>Senha</b>  Igual <b>Repete senha</b>!", MSG_ALERT);
            $this->Result = FALSE;

        else:
            // se nao tiver erros retorna verdadeiro
            $this->Result = TRUE;
        endif;
    }

    // metodo para cadastrar usuario no banco de dados
    private function exeCreateUser() {
        //elimina os campos de verificação de senha
        unset($this->Data['user_password_2']);
        
        //cria o objeto da classe de inserir dados
        $createUser = new Create();
        // se nao tiver nenhum erro
        if ($this->getResult() == TRUE):
            //faz cadastro no banco
            $createUser->exeCreate('users', $this->Data);
        endif;
        // se tiver tido cadastrado retorna mensagem de sucesso
        if ($createUser->getResult()):
            $this->Error = MSGErro("<b>Usuário cadastrado com Sucesso!</b>", MSG_ACCEPT);

        endif;
    }

    // metodo para ATUALIZAR usuario no banco de dados
    private function exeUpdateUser() {

                //elimina os campos de verificação de senha
        unset($this->Data['user_password_2']);

        //cria o objeto da classe de ATUALIZAR dados
        $updateUser = new Update;
        // se nao tiver nenhum erro
        if ($this->getResult() == TRUE):
            //monta query e atualiza
            $updateUser->exeUpdate("users", $this->Data, "WHERE user_id = :id", "id={$this->id}");
        endif;
        // se tiver tido cadastrado retorna mensagem de sucesso
        if ($updateUser->getResult()):
            $this->Error = MSGErro("<b>Usuário Atualizado com Sucesso!</b>", MSG_ACCEPT);

        endif;
    }

}

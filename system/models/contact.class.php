<?php

#################################################################
#### Classe: Responsavel por manipular os gastos do sistema
#### Autor: PJ Cordeiro 
#### Data: 18/09/2015

class contact
{

    private $id;
    private $Result;
    private $Error;
    private $Data;
    private $contact_email;
    private $contact_ipt;



    //pega os valores da view por array
    public function exeContact(array $execontact)
    {
        // atribui todos os valores para variavel da classe
        $this->Data = $execontact;
        /*
        echo "<pre>";
        var_dump($this->Data);
        echo "</pre>";
        */
        $this->contact_email = $this->Data['contact_email'];
        $this->contact_ipt = $this->Data['contact_ip'];


        // executa o metodo de verificaçao dos dados
        $this->setCreatefood();
        //executa o metodo de cadastro no banco
        $this->exeCreatefood();
    }

    //pega os valores da view por array e o id para editar
    public function exeContactUpdate($id, array $execontact)
    {

        $this->id = $id;
        // atribui todos os valores para variavel da classe
        $this->Data = $execontact;
        // seta os valores individuais 



        // executa o metodo de verificaçao dos dados
        $this->setCreatefood();
        //executa o metodo de cadastro no banco
        $this->exeUpdatefood();
    }

    public function exeContactDelete($idDelete)
    {
        $this->id = $idDelete;
        //$read = new Read();
        //$read->exeRead("foods", "WHERE food_id = :id", "id={$this->id}");
        //if (!$read->getResult()):
        // $this->Error = MSGErro("Este <b>Usuário</b> não existe!", MSG_INFOR);
        //$this->Result = FALSE;
        //  header("Location: home.php");
        //else:
        $delete = new Delete();
        $delete->exeDelete("foods", "WHERE food_id = :id", "id={$this->id}");

        if ($delete->getResult()) :
            $this->Error = MSGErro(" <b>Gasto</b> Removida com Sucesso!", MSG_ACCEPT);
            $this->Result = FALSE;
        else :
            $this->Error = MSGErro(" <b>Gasto</b> Não foi removida!", MSG_ERROR);
            $this->Result = FALSE;

        endif;
        //endif;
    }

    //retorna os erros se houver
    public function getError()
    {
        return $this->Error;
    }

    //retorma valor boleano para validação erros
    public function getResult()
    {
        return $this->Result;
    }

    #########################
    ####   Privates   #######
    // metodo para fazer as validaçoes 
    // com verificação boleana

    private function setCreatefood()
    {
        $read_email = Check::searchIdData('contact', 'contact_email', $this->contact_email);

        if (!$this->contact_email or !$this->contact_ipt) :
            $this->Error = MSGErro("Digite seu <b> E-mail</b> para começar ! ", MSG_ALERT);
            $this->Result = FALSE;
        elseif (!Check::Email($this->contact_email)) :
            $this->Error = MSGErro("Preencha o campo <b>E-mail</b> ex.: nome@provedor.com!", MSG_ALERT);
            $this->Result = FALSE;
        elseif ($read_email) :
            header('Location: ' . HOST_SITE . '/view/user/register.php?contact_email=' . $this->contact_email);
        else :
            // se nao tiver erros retorna verdadeiro
            $this->Result = TRUE;
        endif;
    }

    // metodo para cadastrar usuario no banco de dados
    private function exeCreatefood()
    {
        //$this->Data['date'] = Check::date_format;
        //print_r($this->Data);

        //cria o objeto da classe de inserir dados
        $createfood = new Create();
        // se nao tiver nenhum erro
        if ($this->getResult() == TRUE) :
            //faz cadastro no banco
            $createfood->exeCreate('contact', $this->Data);
        endif;
        // se tiver cadastrado retorna mensagem de sucesso
        if ($createfood->getResult()) :
            $this->Error = MSGErro("<b> E-mail cadastrado com Sucesso!</b>", MSG_ACCEPT);
        endif;
    }

    // metodo para ATUALIZAR usuario no banco de dados
    private function exeUpdatefood()
    {
        // modifica os valores de moeda para float antes de cadastrar no banco
        $this->Data['food_value'] = Check::changeToFloat($this->Data['food_value']);
        $this->Data['date'] = Check::formatUsaDate($this->Data['date']);

        //cria o objeto da classe de ATUALIZAR dados
        $updatefood = new Update;
        // se nao tiver nenhum erro
        if ($this->getResult() == TRUE) :
            //monta query e atualiza
            $updatefood->exeUpdate("foods", $this->Data, "WHERE food_id = :id", "id={$this->id}");
        endif;
        // se tiver tido cadastrado retorna mensagem de sucesso
        if ($updatefood->getResult()) :
            $this->Error = MSGErro("<b>Gasto Atualizada com Sucesso!</b>", MSG_ACCEPT);

        endif;
    }
}

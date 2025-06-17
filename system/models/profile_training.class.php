<?php

#################################################################
#### Classe: Responsavel por manipular os usuarios do sistema
#### Autor: PJ Cordeiro 
#### Data: 18/08/2015

class profile_training
{

    private $id;
    private $Result;
    private $Error;
    private $Data;
    private $Profile_training_age;
    private $Profile_training_weight;
    private $Profile_training_height;
    private $Profile_training_biotype;
    private $Profile_training_trainingGoal;
    private $Profile_training_dailyActivity;

    //pega os valores da view por array
    public function exeProfile_training(array $dataProfile_training)
    {
        // atribui todos os valores para variavel da classe
        $this->Data = $dataProfile_training;
        // seta os valores individuais 
        $this->Profile_training_age = $dataProfile_training['profile_training_age'];
        $this->Profile_training_weight = $dataProfile_training['profile_training_weight'];
        $this->Profile_training_height = $dataProfile_training['profile_training_height'];
        $this->Profile_training_biotype = $dataProfile_training['profile_training_biotype'];
        $this->Profile_training_trainingGoal = $dataProfile_training['profile_training_trainingGoal'];
        $this->Profile_training_dailyActivity = $dataProfile_training['profile_training_dailyActivity'];

        // executa o metodo de verificaçao dos dados
        $this->setCreateProfile_training();
        //executa o metodo de cadastro no banco
        $this->exeCreateProfile_training();
    }

    //pega os valores da view por array e o id para editar
    public function exeProfile_trainingUpdate($id, array $dataProfile_training)
    {
        $this->id = $id;
        // atribui todos os valores para variavel da classe
        $this->Data = $dataProfile_training;
        // seta os valores individuais 
        $this->Profile_training_age = $dataProfile_training['profile_training_age'];
        $this->Profile_training_weight = $dataProfile_training['profile_training_weight'];
        $this->Profile_training_height = $dataProfile_training['profile_training_height'];
        $this->Profile_training_biotype = $dataProfile_training['profile_training_biotype'];
        $this->Profile_training_trainingGoal = $dataProfile_training['profile_training_trainingGoal'];
        $this->Profile_training_dailyActivity = $dataProfile_training['profile_training_dailyActivity'];


        // executa o metodo de verificaçao dos dados
        $this->setCreateProfile_training();
        //executa o metodo de cadastro no banco
        $this->exeUpdateProfile_training();
    }

    public function exeProfile_trainingDelete($idDelete)
    {
        $this->id = $idDelete;
        //$read = new Read();
        //$read->exeRead("profile_trainings", "WHERE profile_training_id = :id", "id={$this->id}");
        //if (!$read->getResult()):
        // $this->Error = MSGErro("Este <b>Usuário</b> não existe!", MSG_INFOR);
        //$this->Result = FALSE;
        //  header("Location: home.php");
        //else:
        $delete = new Delete();
        $delete->exeDelete("profile_trainings", "WHERE profile_training_id = :id", "id={$this->id}");

        if ($delete->getResult()) :
            $this->Error = MSGErro(" <b>Usuário</b> Removido com Sucesso!", MSG_ACCEPT);
            $this->Result = FALSE;
        else :
            $this->Error = MSGErro(" <b>Usuário</b> Não foi removido!", MSG_ERROR);
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
    // metodo para fazer as validaçoes de usuario 
    // com verificação boleana

    private function setCreateProfile_training()
    {

        if (!$this->Profile_training_age or !$this->Profile_training_height or !$this->Profile_training_weight or !$this->Profile_training_biotype or !$this->Profile_training_trainingGoal or !$this->Profile_training_dailyActivity) :

            $this->Error = MSGErro("Preencha <b>Todos</b> os campos! ", MSG_ALERT);
            $this->Result = FALSE;
        else :
            // se nao tiver erros retorna verdadeiro
            $this->Result = TRUE;
        endif;
    }

    // metodo para cadastrar usuario no banco de dados
    private function exeCreateProfile_training()
    {
        //elimina os campos de verificação de senha
        //unset($this->Data['profile_training_password_2']);
        $this->Data['profile_training_height'] = Check::changeToFloat($this->Data['profile_training_height']);
        echo "<pre>";
        //var_dump($this->Data);
        echo "</pre>";
        //cria o objeto da classe de inserir dados
        $createProfile_training = new Create();
        // se nao tiver nenhum erro
        if ($this->getResult() == TRUE) :
            //faz cadastro no banco
            $createProfile_training->exeCreate('profile_trainings', $this->Data);
        endif;
        // se tiver tido cadastrado retorna mensagem de sucesso
        if ($createProfile_training->getResult()) :
            $this->Error = MSGErro("<b>Perfil cadastrado com Sucesso!</b>", MSG_ACCEPT);

        endif;
    }

    // metodo para ATUALIZAR usuario no banco de dados
    private function exeUpdateProfile_training()
    {

        //elimina os campos de verificação de senha
        unset($this->Data['user_id']);

        echo "<pre>";
        //var_dump($this->Data);
        echo "</pre>";

        //cria o objeto da classe de ATUALIZAR dados
        $updateProfile_training = new Update;
        // se nao tiver nenhum erro
        if ($this->getResult() == TRUE) :
            //monta query e atualiza
            $updateProfile_training->exeUpdate("profile_trainings", $this->Data, "WHERE profile_training_id = :id", "id={$this->id}");
        endif;
        // se tiver tido cadastrado retorna mensagem de sucesso
        if ($updateProfile_training->getResult()) :
            $this->Error = MSGErro("<b>Perfil Atualizado com Sucesso!</b>", MSG_ACCEPT);

        endif;
    }
}

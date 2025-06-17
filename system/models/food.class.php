<?php

#################################################################
#### Classe: Responsavel por manipular os gastos do sistema
#### Autor: PJ Cordeiro 
#### Data: 18/09/2015

class food {

    private $id;
    private $Result;
    private $Error;
    private $Data;
    private $food_name;
    private $food_measure_unit;
    private $food_amount;
    private $food_calorie;
    private $food_protein;
    private $food_fat;
    

    //pega os valores da view por array
    public function exefood(array $datafood) {
        // atribui todos os valores para variavel da classe
        $this->Data = $datafood;


        $this->food_name = $datafood['food_name'];
        $this->food_measure_unit = $datafood['food_measure_unit'];
        $this->food_amount = $datafood['food_amount'];
        $this->food_calorie = $datafood['food_calorie'];
        $this->food_protein = $datafood['food_protein'];
        $this->food_fat = $datafood['food_fat'];

        // executa o metodo de verificaçao dos dados
        $this->setCreatefood();
        //executa o metodo de cadastro no banco
        $this->exeCreatefood();
    }

    //pega os valores da view por array e o id para editar
    public function exefoodUpdate($id, array $datafood) {

        $this->id = $id;
        // atribui todos os valores para variavel da classe
        $this->Data = $datafood;

        // seta os valores individuais      
        $this->food_name = $datafood['food_name'];
        $this->food_measure_unit = $datafood['food_measure_unit'];
        $this->food_amount = $datafood['food_amount'];
        $this->food_calorie = $datafood['food_calorie'];
        $this->food_protein = $datafood['food_protein'];
        $this->food_fat = $datafood['food_fat'];


        // executa o metodo de verificaçao dos dados
        $this->setCreatefood();
        //executa o metodo de cadastro no banco
        $this->exeUpdatefood();
    }

    public function exefoodDelete($idDelete) {
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

        if ($delete->getResult()):
            $this->Error = MSGErro(" <b>Alimento</b> Removido com Sucesso!", MSG_ACCEPT);
            $this->Result = FALSE;
        else:
            $this->Error = MSGErro(" <b>Alimento</b> Não foi removido!", MSG_ERROR);
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
    // metodo para fazer as validaçoes 
    // com verificação boleana

    private function setCreatefood() {

        if (!$this->food_name or !$this->food_measure_unit or !$this->food_amount or !$this->food_calorie or !$this->food_protein or !$this->food_fat ):
            $this->Error = MSGErro("Preencha os campos Necessários ! ", MSG_ALERT);
            $this->Result = FALSE;

        else:
            // se nao tiver erros retorna verdadeiro
            $this->Result = TRUE;
        endif;
    }

    // metodo para cadastrar usuario no banco de dados
    private function exeCreatefood() {

        $this->Data['food_amount'] = Check::changeToFloat($this->Data['food_amount']);
        $this->Data['food_calorie'] = Check::changeToFloat($this->Data['food_calorie']);
        $this->Data['food_protein'] = Check::changeToFloat($this->Data['food_protein']);
        $this->Data['food_fat'] = Check::changeToFloat($this->Data['food_fat']);
        //print_r($this->Data);

        //cria o objeto da classe de inserir dados
        $createfood = new Create();
        // se nao tiver nenhum erro
        if ($this->getResult() == TRUE):
            //faz cadastro no banco
            $createfood->exeCreate('foods', $this->Data);
        endif;
        // se tiver cadastrado retorna mensagem de sucesso
        if ($createfood->getResult()):
            $this->Error = MSGErro("<b> Alimento cadastrado com Sucesso!</b>", MSG_ACCEPT);

        endif;
    }

    // metodo para ATUALIZAR usuario no banco de dados
    private function exeUpdatefood() {
        // modifica os valores de moeda para float antes de cadastrar no banco
        $this->Data['food_amount'] = Check::changeToFloat($this->Data['food_amount']);
        $this->Data['food_calorie'] = Check::changeToFloat($this->Data['food_calorie']);
        $this->Data['food_protein'] = Check::changeToFloat($this->Data['food_protein']);
        $this->Data['food_fat'] = Check::changeToFloat($this->Data['food_fat']);
        
        //cria o objeto da classe de ATUALIZAR dados
        $updatefood = new Update;
        // se nao tiver nenhum erro
        if ($this->getResult() == TRUE):
            //monta query e atualiza
            $updatefood->exeUpdate("foods", $this->Data, "WHERE food_id = :id", "id={$this->id}");
        endif;
        // se tiver tido cadastrado retorna mensagem de sucesso
        if ($updatefood->getResult()):
            $this->Error = MSGErro("<b>Alimento Atualizado com Sucesso!</b>", MSG_ACCEPT);

        endif;
    }

}

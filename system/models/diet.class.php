<?php

#################################################################
#### Classe: Responsavel por manipular os gastos do sistema
#### Autor: PJ Cordeiro 
#### Data: 18/09/2015

class diet
{

    private $id;
    private $Result;
    private $Error;
    private $Data;

    private $user_id;
    private $diet_number_meal;
    private $food_id;
    private $diet_food_amount;


    //pega os valores da view por array
    public function exediet(array $datadiet)
    {
        // atribui todos os valores para variavel da classe
        $this->Data = $datadiet;


        $this->user_id = $datadiet['user_id'];
        $this->diet_number_meal = $datadiet['diet_number_meal'];
        $this->food_id = $datadiet['food_id'];
        $this->diet_food_amount = $datadiet['diet_food_amount'];

        // executa o metodo de verificaçao dos dados
        $this->setCreatediet();
        //executa o metodo de cadastro no banco
        $this->exeCreatediet();
    }

    //pega os valores da view por array e o id para editar
    public function exedietUpdate($id, array $datadiet)
    {
        $this->id = $id;
        // atribui todos os valores para variavel da classe
        $this->Data = $datadiet;

        // seta os valores individuais       
        $this->user_id = $id;
        $this->diet_number_meal = $datadiet['diet_number_meal'];
        $this->food_id = $datadiet['food_id'];
        $this->diet_food_amount = $datadiet['diet_food_amount'];


        // executa o metodo de verificaçao dos dados
        $this->setCreatediet();
        //executa o metodo de cadastro no banco
        $this->exeUpdatediet();
    }

    public function exedietDelete($idDelete)
    {
        $this->id = $idDelete;
        //$read = new Read();
        //$read->exeRead("diets", "WHERE diet_id = :id", "id={$this->id}");
        //if (!$read->getResult()):
        // $this->Error = MSGErro("Este <b>Usuário</b> não existe!", MSG_INFOR);
        //$this->Result = FALSE;
        //  header("Location: home.php");
        //else:
        $delete = new Delete();
        $delete->exeDelete("diets", "WHERE diet_id = :id", "id={$this->id}");

        if ($delete->getResult()) :
            $this->Error = MSGErro(" <b>Alimento</b> Removida com Sucesso!", MSG_ACCEPT);
            $this->Result = FALSE;
        else :
            $this->Error = MSGErro(" <b>Alimento</b> Não foi removida!", MSG_ERROR);
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

    private function setCreatediet()
    {

        if (!$this->user_id or !$this->diet_number_meal or !$this->food_id or !$this->diet_food_amount) :
            $this->Error = MSGErro("Preencha <b>Os</b> campos Necessários ! ", MSG_ALERT);
            $this->Result = FALSE;

        else :
            // se nao tiver erros retorna verdadeiro
            $this->Result = TRUE;
        endif;
    }

    // metodo para cadastrar usuario no banco de dados
    private function exeCreatediet()
    {

        $this->Data['diet_food_amount'] = Check::changeToFloat($this->Data['diet_food_amount']);
        //print_r($this->Data);

        //cria o objeto da classe de inserir dados
        $creatediet = new Create();
        // se nao tiver nenhum erro
        if ($this->getResult() == TRUE) :
            //faz cadastro no banco
            $creatediet->exeCreate('diets', $this->Data);
        endif;
        // se tiver cadastrado retorna mensagem de sucesso
        if ($creatediet->getResult()) :
            $this->Error = MSGErro("<b> Alimento da Dieta cadastrado com Sucesso!</b>", MSG_ACCEPT);

        endif;
    }

    // metodo para ATUALIZAR usuario no banco de dados
    private function exeUpdatediet()
    {
        // modifica os valores de moeda para float antes de cadastrar no banco
        $this->Data['diet_food_amount'] = Check::changeToFloat($this->Data['diet_food_amount']);

        //cria o objeto da classe de ATUALIZAR dados
        $updatediet = new Update;
        // se nao tiver nenhum erro
        if ($this->getResult() == TRUE) :
            //monta query e atualiza
            $updatediet->exeUpdate("diets", $this->Data, "WHERE diet_id = :id", "id={$this->id}");
        endif;
        // se tiver tido cadastrado retorna mensagem de sucesso
        if ($updatediet->getResult()) :
            $this->Error = MSGErro("<b>Alimento da Dieta Atualizada com Sucesso!</b>", MSG_ACCEPT);

        endif;
    }

    // le e demonstra as refeiçoes
    public function meals($diet_number_meal, $user_id)
    {
        $read = new Read();
        //$read->exeRead('diets', 'WHERE diet_number_meal = '.$$diet_number_meal.'');
        $read->exeRead('diets', 'WHERE diet_number_meal = ' . $diet_number_meal . ' and user_id = ' . $user_id . '');

        //if (!$read->getRowCount()) :
        //  MSGErro("Nenhum Resultado encontrado", MSG_ALERT);
        //else :
        //                $total = 0;
        echo "<fieldset class='padrao' style='margin-bottom: 30px;'>"
            . " <legend class='padrao'>Refeição Nº " . $diet_number_meal . "</legend>"
            . "<div class='linha_resultado' style='font-weight:bold; color: #1E90FF; '>"
           // . "<div class='resultado_item' style='width: 5%; background-color: #F5F5F5;'>ID </div>"
            . "<div class='resultado_item' style='width: 30%; background-color: #FFF;'> ALIMENTO </div>"
            . "<div class='resultado_item' style='width: 10%; background-color: #F5F5F5;'>QUANTI </div>"
            . "<div class='resultado_item' style='width: 10%; background-color: ##FFF;'>CALORIAS </div>"
            . "<div class='resultado_item' style='width: 10%; background-color:#F5F5F5;'> PROTEINAS </div>"
            . "<div class='resultado_item' style='width: 10%; background-color:#FFF;'> GORDURAS </div>"

            . "</div>";
        foreach ($read->getResult() as $line) :
            $foods = Check::searchIdData('foods', 'food_id', $line['food_id']);
            $food_measure = Check::searchMeasureUnit($foods['food_measure_unit']);
            $calorie = $foods['food_calorie'] * $line['diet_food_amount'];
            $protein = $foods['food_protein'] * $line['diet_food_amount'];
            $fat = $foods['food_fat'] * $line['diet_food_amount'];
            //echo $total = $total + $calorie;
            //echo '<br>';
            //echo $foods['food_calorie'] ;
            echo "<div class='linha_resultado'> "
                //. "<div class=\"resultado_item\" style=\"width: 5%; background-color: #F5F5F5; \">{$line['diet_id']}</div> "
                . "<div class=\"resultado_item\" style=\"width: 30%; background-color: ##FFF; \">{$foods['food_name']}</div> "
                . "<div class=\"resultado_item\" style=\"width: 10%; background-color: #F5F5F5; \">{$line['diet_food_amount']}<br>{$food_measure}</div> "

                . "<div class=\"resultado_item\" style=\"width: 10%; background-color: ##FFF; \">" . $calorie . " kcal</div> "
                . "<div class=\"resultado_item\" style=\"width: 10%; background-color: #F5F5F5; \">" . $protein . " g</div> "
                . "<div class=\"resultado_item\" style=\"width: 10%; background-color: ##FFF; \">" . $fat . " g</div> "
                //. "<div class=\"resultado_item\" style=\"width: 10%; background-color: #F5F5F5; \">{$line['diet_fat']}</div> "
                . " <div class= \"botao_excluir\"> <a href='diet_create.php?delete= {$line['diet_id']}'><img src=\"../../image/excluir.png\" width=\"\" height=\"\"></a></div>"
                . " <div class= \"botao_excluir\"> <a href='diet_update.php?id= {$line['diet_id']}'><img src=\"../../image/editar.png\" width=\"\" height=\"\"></a></div>"

                //. " <div class= \"botao_editar\">  <a href='operational_update.php?id= {$line['diet_id']}'><img src=\"../../image/editar.png\" width=\"\" height=\"\"></a></div>"

                . "</div>";

        endforeach;
        echo "</fieldset>";
        // endif;
    }

      // le e demonstra as refeiçoes
      public function mealsPrint($diet_number_meal, $user_id)
      {
          $read = new Read();
          //$read->exeRead('diets', 'WHERE diet_number_meal = '.$$diet_number_meal.'');
          $read->exeRead('diets', 'WHERE diet_number_meal = ' . $diet_number_meal . ' and user_id = ' . $user_id . '');
  
          //if (!$read->getRowCount()) :
          //  MSGErro("Nenhum Resultado encontrado", MSG_ALERT);
          //else :
          //                $total = 0;
          echo "<fieldset class='diet_number' style='margin-bottom: 30px;'>"
              . " <legend class='padrao'>" . $diet_number_meal . "</legend>"
              . "<div class='linha_resultado' style='font-weight:bold; color: #1E90FF; '>"
             // . "<div class='resultado_item' style='width: 5%; background-color: #F5F5F5;'>ID </div>"
              . "<div class='resultado_item' style='width: 30%; background-color: #FFF;'> ALIMENTO </div>"
              . "<div class='resultado_item' style='width: 15%; background-color: #F5F5F5;'>QUANT </div>"
              . "<div class='resultado_item' style='width: 15%; background-color: ##FFF;'>CALORIAS </div>"
              . "<div class='resultado_item' style='width: 17%; background-color:#F5F5F5;'> PROTEINAS </div>"
              . "<div class='resultado_item' style='width: 17%; background-color:#FFF;'> GORDURAS </div>"
  
              . "</div>";
          foreach ($read->getResult() as $line) :
              $foods = Check::searchIdData('foods', 'food_id', $line['food_id']);
              $food_measure = Check::searchMeasureUnit($foods['food_measure_unit']);
              $calorie = $foods['food_calorie'] * $line['diet_food_amount'];
              $protein = $foods['food_protein'] * $line['diet_food_amount'];
              $fat = $foods['food_fat'] * $line['diet_food_amount'];
              //echo $total = $total + $calorie;
              //echo '<br>';
              //echo $foods['food_calorie'] ;
              echo "<div class='linha_resultado'> "
                  //. "<div class=\"resultado_item\" style=\"width: 5%; background-color: #F5F5F5; \">{$line['diet_id']}</div> "
                  . "<div class='resultado_item' style='width: 30%; background-color: ##FFF; '>{$foods['food_name']}</div> "
                  . "<div class=\"resultado_item\" style=\"width: 15%; background-color: #F5F5F5; \">{$line['diet_food_amount']}<br>{$food_measure}</div> "
  
                  . "<div class=\"resultado_item\" style=\"width: 15%; background-color: ##FFF; \">" . $calorie . " kcal</div> "
                  . "<div class=\"resultado_item\" style=\"width: 17%; background-color: #F5F5F5; \">" . $protein . " g</div> "
                  . "<div class=\"resultado_item\" style=\"width: 17%; background-color: ##FFF; \">" . $fat . " g</div> "
                  
                  . "</div>";
  
          endforeach;
          echo "</fieldset>";
          // endif;
      }
  
    // le e demonstra as refeiçoes
    public function totalMeals($diet_number_meal, $user_id)
    {
        $read = new Read();
        //$read->exeRead('diets', 'WHERE diet_number_meal = '.$$diet_number_meal.'');
        $read->exeRead('diets', 'WHERE diet_number_meal = ' . $diet_number_meal . ' and user_id = ' . $user_id . '');
        $total_calorie = 0;
        //$total_protein = 0;
        //$total_fat = 0;
        foreach ($read->getResult() as $line) :

            $foods = Check::searchIdData('foods', 'food_id', $line['food_id']);
            $calorie = $foods['food_calorie'] * $line['diet_food_amount'];
            //$protein = $foods['food_protein'] * $line['diet_food_amount'];
            //$fat = $foods['food_fat'] * $line['diet_food_amount'];

            $total_calorie =  $total_calorie + $calorie;
        //$total_protein =  $total_protein + $calorie; 
        //$total_fat =  $total_fat + $calorie; 

        endforeach;
        echo $total_calorie;
    }
}

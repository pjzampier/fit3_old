<?php

/**
 * classe responsavel por validar e manipular dados no sistema
 *
 *
 * @author pj
 */
class Check
{

    private static $Data;
    private static $Format;
    // array com as opçoes de selecao
    protected static $state = array(
        1 => 'Acre',
        2 => 'Alagoas',
        3 => 'Amapá',
        4 => 'Amazonas',
        5 => 'Bahia',
        6 => 'Ceará',
        7 => 'Distrito Federal',
        8 => 'Espírito Santo',
        9 => 'Goiás',
        10 => 'Maranhão',
        11 => 'Mato Grosso',
        12 => 'Mato Grosso do Sul',
        13 => 'Minas Gerais',
        14 => 'Paraná',
        15 => 'Paraíba',
        16 => 'Pará',
        17 => 'Pernambuco',
        18 => 'Piauí',
        19 => 'Rio de Janeiro',
        20 => 'Rio Grande do Norte',
        21 => 'Rio Grande do Sul',
        22 => 'Rondonia',
        23 => 'Roraima',
        24 => 'Santa Catarina',
        25 => 'Sergipe',
        26 => 'São Paulo',
        27 => 'Tocantins',
    );
    protected static $measure = array(
        17 => "U",
        18 => "PP",
        1 => "P",
        2 => "M",
        3 => "G",
        4 => "GG",
        5 => "EG",
        11 => "34",
        12 => "36",
        13 => "38",
        14 => "40",
        15 => "42",
        16 => "44",
        6 => "46",
        7 => "48",
        8 => "50",
        9 => "52",
        10 => "54",
    );

    ############# inicio busca unidade de medida #########

    // define os valores de array 
    protected static $measureUnit = array(
        1 => "Colher",
        2 => "unidade",
        3 => "Gramas",
        4 => "ML",

    );

    // seleciona a unidade de medida no select / option
    public static function  selectMeasureUnit($selectId)
    {
        // faz um loop pelo o array
        $measure = array(
            1 => "Colher",
            2 => "unidade",
            3 => "Gramas",
            4 => "ML",
        );

        echo "<option value='null'> Medida: </option>";
        foreach ($measure as $id => $name) :
            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    // busca o nome do serviço
    public static function searchMeasureUnit($selectId)
    {
        foreach (self::$measureUnit as $id => $name) :
            if ($id == $selectId) :
                return $name;
            endif;
        endforeach;
    }

    //------------------ FIM UNIDADE DE MEDIDA ---------------------------------------


    ############### inicio busca NUMERO DE REFEIÇAO #########

    // define os valores de array 
    protected static $numberMeal = array(
        1 => "REFEIÇÃO-(1)",
        2 => "REFEIÇÃO-(2)",
        3 => "REFEIÇÃO-(3)",
        4 => "REFEIÇÃO-(4)",
        5 => "REFEIÇÃO-(5)",
        6 => "REFEIÇÃO-(6)",
    );

    // seleciona a unidade de medida no select / option
    public static function  selectNumberMeal($selectId)
    {
        // faz um loop pelo o array
        $measure = array(
            1 => "REFEIÇÃO-(1)",
            2 => "REFEIÇÃO-(2)",
            3 => "REFEIÇÃO-(3)",
            4 => "REFEIÇÃO-(4)",
            5 => "REFEIÇÃO-(5)",
            6 => "REFEIÇÃO-(6)",
        );

        echo "<option value='null'> Refeição N°: </option>";
        foreach ($measure as $id => $name) :
            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }



    // busca o nome do serviço
    public static function searchNumberMeal($selectId)
    {
        foreach (self::$measureUnit as $id => $name) :
            if ($id == $selectId) :
                return $name;
            endif;
        endforeach;
    }
    // FIM NUMERO DA DIETA 
    //---------------------------------------

    #### começo formula da dieta de treino
    protected static $trainingGoal = array(
        1 => "Perder peso | Cutting",
        2 => "Ganhar peso | Bulking",
        3 => "Manter o peso",
    );

    public static function selectTrainingGoal($selectId)
    {

        echo "<option value='null'> Escolha seu objetivo: </option>";
        foreach (self::$trainingGoal as $id => $name) :
            //foreach ($biotype as $id => $name) :

            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    public static function searchTrainingGoal($selectId)
    {
        foreach (self::$trainingGoal as $id => $name) :
            if ($id == $selectId) :
                return $name;
            endif;
        endforeach;
    }

    protected static $dailyActivity = array(
        1 => "Sedentario",
        2 => "Passo o dia em pé",
        3 => "Pratico atividade fisíca leve",
    );
    public static function selectDailyActivity($selectId)
    {

        echo "<option value='null'> Como me movimento: </option>";
        foreach (self::$dailyActivity as $id => $name) :
            //foreach ($biotype as $id => $name) :

            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    public static function searchDailyActivity($selectId)
    {
        foreach (self::$dailyActivity as $id => $name) :
            if ($id == $selectId) :
                return $name;
            endif;
        endforeach;
    }

    protected static $biotype = array(
        1 => "Abaixo do peso (Ectomorfo)",
        2 => "Dentro do peso (Mesomorfo)",
        3 => "Acima do peso (Endomorfo)",
    );

    public static function selectBiotype($selectId)
    {

        echo "<option value='null'> Escolha seu Biotipo: </option>";
        foreach (self::$biotype as $id => $name) :
            //foreach ($biotype as $id => $name) :

            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    public static function searchBiotype($selectId)
    {
        foreach (self::$biotype as $id => $name) :
            if ($id == $selectId) :
                return $name;
            endif;
        endforeach;
    }


    ### FORMULA CALCULO DE CALORIAS, PROTEINAS ETC, PARA CADA PERFIL

    //  peso     altura   objetivo       atividade
    public static function calcCalorieMan($age, $weight, $height, $trainingGoal, $dailyActivity)
    {
        if ($dailyActivity == 1) :
            $total = 1.8 * (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age));
        elseif ($dailyActivity == 2) :
            $total = 2.2 * (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age));
        //$total = $total
        elseif ($dailyActivity == 3) :
            $total = 2.5 * (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age));
        endif;

        if ($trainingGoal == 1) :
            $totalFinal = $total - 300;
        elseif ($trainingGoal == 2) :
            $totalFinal = $total + 600;
        elseif ($trainingGoal == 3) :
            $totalFinal = $total + 300;
        endif;

        //$totalFinal = $total;
        return $totalFinal;
    }

    ### faz calculo de caloria feminino
    //public static function calcCalorieWoman($gender, $age, $weight, $height, $biotype, $trainingGoal, $dailyActivity)
    public static function calcCalorieWoman($age, $weight, $height, $trainingGoal, $dailyActivity)

    {

        if ($dailyActivity == 1) :
            $total = 1.2 * (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age));
        elseif ($dailyActivity == 2) :
            $total = 1.6 * (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age));
        //$total = $total
        elseif ($dailyActivity == 3) :
            $total = 2.0 * (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age));
        endif;

        if ($trainingGoal == 1) :
            $totalFinal = $total - 300;
        elseif ($trainingGoal == 2) :
            $totalFinal = $total + 600;
        elseif ($trainingGoal == 3) :
            $totalFinal = $total + 300;
        endif;

        //$totalFinal = $total;
        return $totalFinal;
    }

    ### formata data de aniverario
    public static function formatAge($dateAge)
    {    // pega data atual
        $dataNow = date('Y');
        // pega o ano da data de aniversario  
        $age = substr($dateAge, '6', '4');
        //faz o calculo para pegar a idade
        $ageNow = $dataNow - $age;
        ####
        //pega o mes de aniversario
        $MonthUser = substr($dateAge, '3', '2');
        //pega o mes atual
        $mountNow = (int) date('m');
        ####
        $dayNow = date('d');
        $dayUser =  substr($dateAge, '0', '2');
        //verifica se ja teve aniversario esse ano
        //if ($MonthUser <= $mountNow and $dayUser <= $dayNow) :
        if ($MonthUser <= $mountNow) :
            //if($dayUser <= $dayNow) :
                return $ageNow;
            //endif;
        else :
            return $ageNow - 1;
        endif;
    }

    protected static $pay = array(
        1 => "Dinheiro",
        2 => "Cartão Credito",
        3 => "Cartão Debito",
        4 => "Crediario",
        5 => "Cheque",
    );
    protected static $archive_group = array(
        1 => "Prestação de Contas",
        2 => "Ata",
        3 => "Diversos",
    );

    // quantidade de agua
    public static function water($peso)
    {
        $result = ($peso * 40);
        return $result;
    }
    // quantidade de proteina
    public static function protein($peso)
    {
        $result = ($peso * 2.0);
        return $result;
    }
    //calcula quantidade de pela caloria sujerida 
    public static function fat($caloria)
    {
        $porcetagem = self::percent(25, $caloria);
        $result = ($porcetagem / 9);
        return $result;
    }

    // IMC
    public static function imc1($altura, $peso)
    {
        $result = $peso / ($altura * $altura);
        $imc = Check::pegaString($result, '.');
        return $imc;
    }

    // taxa de gordura
    public static function taxa_gordura($imc, $idade)
    {

        //$result = (1.2 * $imc) - (10.8 * 1) + (0.23 * $idade) - 5.4;
        $result = (1.2 * $imc) + (0.23 * $idade) - (10.8 * 1) - 5.4;
        return $result;
    }

    //public static function imc($String, $Limite, $Pointer = NULL) {

    // return $Result;
    // }

    // MULTIPLICA DOIS VALORES
    public static function multiplica($num1, $num2)
    {

        $result = $num1 * $num2;
        return $result;
    }
    // TOTAL VALOR TABELA
    //public static function totalMeals($number_meal, $category, $category2, $user_id)
    public static function totalMeals($number_meal, $category, $category2, $user_id)

    {
        //echo $user_id . '--';
        //faz busca com os metodos de leitura de dados
        $read = new Read();
        // adciona a atbela para leituta
        //$read->exeRead('diets', "WHERE 'diet_number_meal' = '$number_meal'");
        $read->exeRead('diets', "WHERE user_id = '$user_id'");

        //print_r($read);
        // faz a leitura dos dados na base
        if (!$read->getResult()) {
            echo 'sem resultado';
        } else {
            $totalMeal = 0;
            foreach ($read->getResult() as $line) :
                $foods = Check::searchIdData('foods', 'food_id', $line['food_id']);

                $subTotalMeal = $foods[$category] * $line[$category2];
                $totalMeal = $totalMeal + $subTotalMeal;
            //return 'aqui';

            endforeach;
            return $totalMeal;
        }
    }

    ##### calcula os totais dos macros de cada refeição
    public static function totalMealsUnit($number_meal, $category, $user_id)
    {

        $read = new Read();
        //$read->exeRead('diets', 'WHERE diet_number_meal = '.$$diet_number_meal.'');
        $read->exeRead('diets', 'WHERE diet_number_meal = ' . $number_meal . ' and user_id = ' . $user_id . '');
        $total_macros = 0;

        foreach ($read->getResult() as $line) :

            $foods = Check::searchIdData('foods', 'food_id', $line['food_id']);
            $macros = $foods[$category] * $line['diet_food_amount'];

            $total_macros =  $total_macros + $macros;

        endforeach;
        return $total_macros;
    }

    //modifica o padrao da data americano
    public static function formatUsaDate($date)
    {

        if (!empty($date)) :
            $date = date("Y-m-d", strtotime($date));
        else :
            $date = '';
        endif;
        return $date;
    }

    //modifica o padrao da data brasileiro
    public static function formatBrDate($date)
    {

        $date = date("d-m-Y", strtotime($date));
        //$date = date("d-m-Y");
        return $date;
    }

    // modifica string em float e muda as virgula por ponto
    public static function changeToFloat($value)
    {

        $retorno = false;
        if (!empty($value)) {
            if (strstr($value, '.') && strstr($value, ',')) {
                $value = str_replace('.', '', $value);
            }

            $value = str_replace(',', '.', $value);
            $float = (float) $value;

            if (is_float($float) && $float > 0) {
                $retorno = $float;
            }
        }

        return $retorno;
    }

    public static function changeToReal($value)
    {

        return number_format($value, 2, ',', '.');
    }

    public static function changeToInt($value)
    {

        return intval($value);
    }

    // calculo de porcentagem
    public static function percent($percent, $value)
    {

        return ($percent / 100) * $value;
    }
    // pega valor ate um caracter
    public static function pegaString($value, $string)
    {

        return strstr($value, $string, true);
    }

    //metodo para validaçao de email
    public static function Email($Email)
    {
        //  atribui os valores com verificaçao de string
        self::$Data = (string) $Email;
        // atribui os valores de comparação
        self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';
        // faz a verificaçao do atributo com o modelo e da um retorno
        if (preg_match(self::$Format, self::$Data)) :
            return TRUE;
        else :
            return FALSE;
        endif;
    }

    //busca o ultimo id cadastrado
    public static function searchMaxId($id_colunm, $table)
    {

        $read = new Read();
        // passa os parametros para busca
        // $read->exeReadMaxId($id_colunm, $table);

        //busca o valor do array
        foreach ($read->getResult()[0] as $line => $id) :
            return $id;
        endforeach;
    }

    // metodo de busca na base de dados para ultizar no select
    public static function select($table, $lineId, $selectId, $selectName, $orderBy)
    {
        //faz busca com os metodos de leitura de dados
        $read = new Read();

        // adciona a tabela para leituta
        if (!empty($orderBy)) :
            $read->exeRead($table, "{$orderBy}");
        else :
            $read->exeRead($table);
        endif;

        //se nao tiver resultados
        if (!$read->getResult()) :
            echo '<option disabled="disabled" value="null"> Cadastre uma Seção: </option>';
        else :
            // faz a leitura dos dados na base
            foreach ($read->getResult() as $line) :
                // imprime dentro select 
                echo "<option value=\"{$line[$lineId]}\"";
                //se id igual ao nome mantem o nome selecionado
                if ($line[$lineId] == $selectId) :
                    echo 'selected="selected"';
                endif;
                echo "> {$line[$selectName]}</option>";
            endforeach;
        endif;
    }

    // metodo de busca na base de dados para ultizar no select
    public static function selectNotCheck($table, $lineId, $selectId, $selectName, $selectName2)
    {
        //faz busca com os metodos de leitura de dados
        $read = new Read();
        // adciona a atbela para leituta
        $read->exeRead($table);
        //se nao tiver resultados
        if (!$read->getResult()) :
            echo '<option disabled="disabled" value="null"> Cadastre uma Seção: </option>';
        else :
            // faz a leitura dos dados na base
            foreach ($read->getResult() as $line) :
                // imprime dentro select 
                echo "<option value=\"{$line[$lineId]}\"";

                echo "> {$line[$selectName]} {$line[$selectName2]}</option>";
            endforeach;
        endif;
    }

    // metodo de busca na base de dados para ultizar no select
    public static function select2Column($table, $lineId, $selectId, $selectName, $selectName2)
    {
        //faz busca com os metodos de leitura de dados
        $read = new Read();
        // adciona a atbela para leituta
        $read->exeRead($table);
        //se nao tiver resultados
        if (!$read->getResult()) :
            echo '<option disabled="disabled" value="null"> Cadastre uma Seção: </option>';
        else :
            // faz a leitura dos dados na base
            foreach ($read->getResult() as $line) :
                // imprime dentro select 
                echo "<option value=\"{$line[$lineId]}\"";
                //se id igual ao nome mantem o nome selecionado
                if ($line[$lineId] == $selectId) :
                    echo 'selected="selected"';
                endif;
                $idName2 = Check::searchId($table, $lineId, $line['food_id'], $selectName2);
                $name2 = check::searchMeasureUnit($idName2);
                echo ">" . $line[$selectName] . "- (" . $name2 . ")" . "</option>";
            endforeach;
        endif;
    }

    public static function searchId($table, $colunmId, $selectId, $columnName)
    {
        //faz busca com os metodos de leitura de dados
        $read = new Read();
        // adciona a atbela para leituta
        $read->exeRead($table, "WHERE {$colunmId} = '{$selectId}'");
        //se nao tiver resultados
        if (!$read->getResult()) :
            echo '';
        else :
            // faz a leitura dos dados na base
            foreach ($read->getResult() as $line) :

                return $line[$columnName];
            endforeach;
        endif;
    }

    public static function searchIdData($table, $colunmId, $selectId)
    {
        //faz busca com os metodos de leitura de dados
        $read = new Read();
        // adciona a atbela para leituta
        $read->exeRead($table, "WHERE {$colunmId} = '{$selectId}'");
        //se nao tiver resultados
        if (!$read->getResult()) :
            echo '';
        else :
            // faz a leitura dos dados na base
            foreach ($read->getResult() as $line) :
                return $line;
            endforeach;
        endif;
    }

    ### soma varios valores da tabela pelo id
    public static function searchIdCalc($table, $colunmId, $selectId, $colunmSum, $userId)
    {
        //faz busca com os metodos de leitura de dados
        $read = new Read();
        // adciona a atbela para leituta
        $read->exeRead($table, "WHERE {$colunmId} = '{$selectId}' AND user_id = {$userId}");
        //se nao tiver resultados
        if (!$read->getResult()) :
            echo '';
        else :
            $sum = 0;
            // faz a leitura dos dados na base
            foreach ($read->getResult() as $line) :
                // coma as colunas
                $sum = $sum + $line[$colunmSum];
            endforeach;
            return $sum;
        endif;
    }

    public static function searchId2Column($table, $colunmId, $selectId, $columnName, $columnName2)
    {
        //faz busca com os metodos de leitura de dados
        $read = new Read();
        // adciona a atbela para leituta
        $read->exeRead($table, "WHERE {$colunmId} LIKE '%{$selectId}%'");
        //se nao tiver resultados
        if (!$read->getResult()) :
            echo '';
        else :
            // faz a leitura dos dados na base
            foreach ($read->getResult() as $line) :

                return $line[$columnName] . " - " . Check::searchId('brands', 'brand_id', $line[$columnName2], 'brand_name');
            endforeach;
        endif;
    }

    // selecionar Estado
    public static function selectState($selectId)
    {

        // colocar o valor nulo no primeiro
        echo "<option value='null'>  Escolha Estado: </option>";
        // faz um loop pelo o array
        foreach (self::$state as $id => $name) :
            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    // seleciona o medidas
    public static function selectMeasure($selectId)
    {
        // faz um loop pelo o array
        echo "<option value='null'>   </option>";
        foreach (self::$measure as $id => $name) :
            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    // busca o nome do serviço
    public static function searchMeasure($selectId)
    {
        foreach (self::$measure as $id => $name) :
            if ($id == $selectId) :
                return $name;
            endif;
        endforeach;
    }

    // seleciona o medidas
    public static function selectPay($selectId)
    {
        // faz um loop pelo o array
        echo "<option value=''> Forma de Pagamento</option>";
        foreach (self::$pay as $id => $name) :
            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    // busca o nome do serviço
    public static function searchPay($selectId)
    {
        foreach (self::$pay as $id => $name) :
            if ($id == $selectId) :
                return $name;
            endif;
        endforeach;
    }

    // seleciona o medidas
    public static function selectGroupArchive($selectId)
    {
        // faz um loop pelo o array
        //echo "<option value=''> Tipo do Documento</option>";
        foreach (self::$archive_group as $id => $name) :
            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    public static function searchGroupArchive($selectId)
    {
        foreach (self::$archive_group as $id => $name) :
            if ($id == $selectId) :
                return $name;
            endif;
        endforeach;
    }

    // selecionar sexo 
    public static function selectSex($selectId)
    {
        // array com as opçoes de selecao
        $sex = array(
            1 => "Masculino",
            2 => "Feminino",
        );
        // colocar o valor nulo no primeiro
        echo "<option value='null'>  Escolha Sexo: </option>";
        // faz um loop pelo o array
        foreach ($sex as $id => $name) :
            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    // seleciona a forma de desconto
    public static function selectTypeDiscount($selectId)
    {
        // faz um loop pelo o array
        $type = array(
            1 => "R$",
            2 => "%",
        );

        //echo "<option value='null'>  Estado Civil: </option>";
        foreach ($type as $id => $name) :
            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    // seleciona o estado civil
    public static function selectStateMaried($selectId)
    {
        // faz um loop pelo o array
        $maried = array(
            1 => "Solteiro",
            2 => "Casado",
            3 => "Viúvo",
            4 => "Separado",
        );

        echo "<option value='null'>  Estado Civil: </option>";
        foreach ($maried as $id => $name) :
            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    // seleciona o Carteira motorista
    public static function selectCnh($selectId)
    {
        // faz um loop pelo o array
        $cnh = array(
            1 => "A",
            2 => "B",
            3 => "AB",
            4 => "C",
            5 => "D",
            6 => "E",
        );

        echo "<option value='null'>  Escolha CNH: </option>";
        foreach ($cnh as $id => $name) :
            echo "<option value = '" . $id . "'";
            // se o id tiver valor igual a busca colococa como selecionado   
            if ($id == $selectId) :
                echo "selected=selected";
            endif;
            echo ">" . $name . "</option>";
        endforeach;
    }

    //Verifica se um valor foi passado ou nao 
    //esta sendo usado para verificar se um input esta vazio
    public static function stringNotNull($value)
    {

        print_r($value);
        if (empty($value)) :
            $value = TRUE;
        else :
            $value = FALSE;
        endif;
    }

    // verifica se os valores sao iguais (senha)
    public static function passVerify($pass, $pass2)
    {
        // se valor for igual retorna verdaeiro
        if ($pass == $pass2) :
            return TRUE;
        // senao volta falso
        else :
            return FALSE;
        endif;
    }

    // pega extensão do arquivo
    public static function takeExtension($archive)
    {
        $extension = explode('.', $archive);
        $extension_ = array_reverse($extension);
        return  $extension_[0];
    }

    //metodo para limpar e validar as urls amigaveis
    public static function name($Name)
    {
        // transforma a variavel em um array
        self::$Format = array();
        // passa os dois valores de substituicao em uma posicao array
        self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
        self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
        // verifica e faz as substituicao de um valor para o outro e transforma os valores par utf8
        self::$Data = strtr(utf8_decode($Name), utf8_decode(self::$Format['a']), self::$Format['b']);
        // limpa e tira acentos tags html's e atribiu os novos valores
        self::$Data = strip_tags(trim(self::$Data));
        self::$Data = str_replace(' ', '-', self::$Data);
        self::$Data = str_replace(array('-----', '----', '---', '--'), '-', self::$Data);

        //retorna os valores com caixa baixa(minusculo) e converte tudo para utf8
        return strtolower(utf8_decode(self::$Data));
    }

    // metodo para formatar hora e data
    public static function Data($Data)
    {
        //separa as informaçoes
        self::$Format = explode(' ', $Data);
        // 
        self::$Data = explode('/', self::$Format[0]);
        // se hora estiver vazia prenche com a hora atual
        if (empty(self::$Format[1])) :
            self::$Format[1] = date('H:i:s');
        endif;

        // preencje a variavel com os valores organizados
        self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0] . ' ' . self::$Format[1];
        return self::$Data;
    }

    // metoto para contar a string por um certo valor e adiciona um valor "cotinue lendo..." por exemplo
    public static function Word($String, $Limite, $Pointer = NULL)
    {
        // retiva espaços e tags html
        self::$Data = strip_tags(trim($String));
        self::$Format = (int) $Limite;

        $arrWord = explode(' ', self::$Data);
        $numCount = count($arrWord);
        $newWords = implode(' ', array_slice($arrWord, 0, self::$Format));
        $Pointer = (empty($Pointer) ? '...' : ' ' . $Pointer);
        $Result = (self::$Format < $numCount ? $newWords . $Pointer : self::$Data);

        return $Result;
    }

    //substitui o nome da categoria pelo o id
    public static function CatByName($CategoryName)
    {
        $read = new Read;
        // faz a busca no banco pela categoria
        $read->ExeRead('ws_categories', "WHERE category_name = :name ", "name={$CategoryName}");
        //se tiver o valor traz o valor do id pela posicao do array
        if ($read->getRowCount()) :

            return $read->getResult()[0]['category_id'];
        else :
            MSGErro("A Categoria {$CategoryName} não foi encontrada!", MSG_ERROR);
            die;
        endif;
    }

    //verifica os usuarios online
    public static function UserOnline()
    {

        // atribui o data atual
        $now = date('Y-m-d H:i:s');
        $DelUserOnline = new Delete;
        //deleta as data difetentes de agora
        $DelUserOnline->exeDelete('ws_siteviews_online', "WHERE  online_endview < :now", "now={$now}");

        // le os registros ainda na tabela
        $ReadUserOnline = new Read;
        $ReadUserOnline->exeRead('ws_siteviews_online');
        //conta os usuario logados (registro na tabela)
        return $ReadUserOnline->getRowCount();
    }

    // verifica e redimenciona imagem
    public static function Image($ImageUrl, $ImageDesc, $ImageW = null, $ImageH = NULL)
    {

        //echo $ImageUrl;
        //die;
        //atribui local da imagem
        self::$Data = 'uploads/' . $ImageUrl;


        //se imagem existir
        if (file_exists(self::$Data) && !is_dir(self::$Data)) :
            //$patch = HOME;
            $imagem = self::$Data;
        //return "<img src=\"{$patch}/tim.php?src={$patch}/{$imagem}&w={$ImageW}&h={$ImageH}\" alt=\"{$ImageDesc}\" title=\"{$ImageDesc}\"/>";
        //return "<img src=\"{$patch}/tim.php?src={$patch}/{$imagem}&w={$ImageW}&h={$ImageH}\" alt=\"{$ImageDesc}\" title=\"{$ImageDesc}\"/>";
        else :
            return FALSE;
        endif;
    }
}

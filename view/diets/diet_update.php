<?php
//starta sessao
session_start();
//incluio arquivo de autoload das classe e gerador de mensagens
require('../../Config.inc.php');

// passa o parametro de restrição de usuario
$login = new login(1);
// se o atributo de verificação nao achar o usuario --- se nao estiver logado
if (!$login->checkLogin()) :
    // termina a sessao e reencaminha para fora do sistema
    unset($_SESSION['userlogin']);
    //envia para fora do sistema  
    header('Location: ../../index.php?validate=limited');
else :
    // se checklogin tiver valor atribui os dados do usuario para variavel local 
    $userLogin = $_SESSION['userlogin'];

endif;
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset= utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="../../image/icon.png" />
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link rel="stylesheet" type="text/css" href="../../css/style_message.css">
    <!--###### IDENTA JQUERY ####### -->
    <script type="text/javascript" src="../../jquery/jquery-1.5.2.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('body').fadeIn(1800);
        })
    </script>
    <title> <?php echo NAME_SITE; ?></title>
</head>

<body>
    <div id="full">
        <?php include("../../layout/header.php"); ?>
        <?php
        // pega todos dados enviado por post em forma de array
        $dataDiet = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //pega o id para busca e atualização
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!empty($dataDiet['dataDiet'])) :

            //elimina o array que vem do input 
            unset($dataDiet['dataDiet']);
            $cadDiet = new diet();
            $cadDiet->exeDietUpdate($id, $dataDiet);

            //se tiver cadastrado
            if ($cadDiet->getResult()) :
                //retorna as mensagens de erro da validação 
                MSGErro(isset($cadDiet->getError()[0]), isset($cadDiet->getError()[1]));

            //se tiver sido cadastrado limpa variavel post  
            elseif ($cadDiet->getResult() == TRUE) :
                //finaliza objeto
                unset($dataDiet);
            endif;

        // se nao for passado informação do formulario
        else :
            //faz a leitura dos dados com o id passado via get
            $read = new Read();
            $read->exeRead("diets", "WHERE diet_id = :id", "id={$id}");

            //se nao tiver resultado na leitura da tabela banco
            if (!$read->getResult()) :

            else :
                // atribui os valores da leitura do banco para a variavel popular os inputs do formulario
                $dataDiet = $read->getResult()[0];
            endif;
        endif;
        ?>
        <!--###### INICIO DO CADASTRAR ###### -->

        <fieldset class="padrao">
            <legend class="padrao">Editar Dieta</legend>

            <form name="AdminLoginForm" action="" method="post">
                <div class="org_input">
                    <span class="inicial"> Numero da refeição: </span>
                    <select name="diet_number_meal" class="padrao">
                        <?php Check::selectNumberMeal($dataDiet['diet_number_meal']); ?>
                    </select>
                </div>

                <div class="org_input">
                    <span class="inicial"> Alimentos : </span>
                    <select name="food_id" class="padrao">
                        <option value="null">Escolha o Alimento</option>
                        <?php
                        // envia os atributos e recebe os valores do select
                        //Check::select('foods', 'food_id', $dataDiet['food_id'], 'food_name', 'ORDER BY food_name');
                        Check::select2Column('foods', 'food_id', $dataDiet['food_id'], 'food_name', 'food_measure_unit');
                        //Check::selectState($dataService['service_country']);
                        ?>
                    </select>
                </div>

                <div class="org_input">
                    <span class="inicial"> Quantidade: </span>
                    <input type="text" id="inputMoney4" name="diet_food_amount" placeholder=" Quantidade" value="<?php if (isset($dataDiet)) echo $dataDiet['diet_food_amount']; ?>" class="padrao" />
                </div>

                <div class="org_botao">
                    <input type="submit" name="dataDiet" value="Editar" id="botao" />
                </div>
            </form>
        </fieldset>

        <?php include("../../layout/footer.php"); ?>

    </div>
</body>

</html>
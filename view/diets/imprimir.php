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

// pega todos dados enviado por post em forma de array
//$user_id = filter_input_array(INPUT_GET, FILTER_DEFAULT);

// atribui user id
$user_id = ($_SESSION['userlogin']['user_id']);
//var_dump($user_id);


?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset= utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo HOST_SITE; ?>image/icon.png" />
    <link rel="stylesheet" type="text/css" href="../../css/style_imprimir.css">
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
    <?php
    // chamo dados usuario
    $user_data = Check::searchIdData('users', 'user_id', $user_id);

    // chama dados perfil do atleta
    $profile_trainings = Check::searchIdData('profile_trainings', 'user_id', $user_id);
    $idade = Check::formatAge($profile_trainings['profile_training_age']);
    $peso = $profile_trainings['profile_training_weight'];
    $altura = $profile_trainings['profile_training_height'];
    $biotipo = $profile_trainings['profile_training_biotype'];
    $objtivoTreino = $profile_trainings['profile_training_trainingGoal'];
    $atividadeDiaria = $profile_trainings['profile_training_dailyActivity'];
    $imc = Check::imc1($profile_trainings['profile_training_height'], $profile_trainings['profile_training_weight']);
    $bf = Check::taxa_gordura($imc, $idade);

    #### Valores calculados das refeições
    $totalCalorie = Check::totalMeals(1, 'food_calorie', 'diet_food_amount', $user_id);
    $totalProtein = Check::totalMeals(1, 'food_protein', 'diet_food_amount', $user_id);
    $totalFat = Check::totalMeals(1, 'food_fat', 'diet_food_amount', $user_id);
    $totalWater =  Check::searchIdCalc('diets', 'food_id', '13', 'diet_food_amount', $user_id);

    #### os calculos da quantidade necessaria do perfil.
    $ageNow = Check::formatAge($profile_trainings['profile_training_age']);
    $calorie = check::calcCalorieMan($ageNow, $profile_trainings['profile_training_weight'], $profile_trainings['profile_training_height'], $profile_trainings['profile_training_trainingGoal'], $profile_trainings['profile_training_dailyActivity']);
    //$calorie = check::calcCalorieWoman($ageNow, $profile_trainings['profile_training_weight'], $profile_trainings['profile_training_height'], $profile_trainings['profile_training_trainingGoal'], $profile_trainings['profile_training_dailyActivity']);
    $protein = check::protein($profile_trainings['profile_training_weight']);
    $fat = check::fat($calorie);
    $water = check::water($profile_trainings['profile_training_weight']);
    ?>

    <!--input type="button" onclick="cont();" value="Imprimir Div separadamente"-->

    <div id="full">
        <script>
            function cont() {
                var conteudo = document.getElementById('print').innerHTML;
                tela_impressao = window.open('about:blank');
                tela_impressao.document.write(conteudo);
                tela_impressao.window.print();
                tela_impressao.window.close();
            }
        </script>

        <div id="print" class="conteudo">

            <div class="perfil">
                <img src="<?php echo HOST_SITE . "image/perfil_g.png"; ?>" width="160" height="160">
            </div>
            <div class="dados_atleta">
                <?php
                echo 'Atleta<br> <b>' . $user_data['user_name'] . '</b><br><br>';
                echo '<b>' . $idade . '</b> anos | ';
                echo '<b> ' . $peso . ' </b> kg   |  ';
                echo '<b>' . $altura . '</b> cm <br>';
                echo  '<b>' . check::searchBiotype($biotipo) . '</b><br>';
                echo 'Objetivo: <b>' . check::searchTrainingGoal($objtivoTreino) . '</b><br>';
                echo '<b>' . check::searchDailyActivity($atividadeDiaria) . '</b><br><br>';

                echo    '<b>' . Check::changeToInt($bf) . '% </b> Taxa gordura (BF)';
                ?>
            </div>
            <div class="logo"><img src="<?php echo HOST_SITE . "image/logo_ok.png"; ?>" width="150" height="45"></div>
            <div id="hr"></div>


            <div class="org">
                <div class="org_int_up">Calorias</div>
                <div class="org_int_down"><?php echo Check::changeToInt($calorie); ?> |
                    <b style="font-size: 16px;"> <?php echo Check::changeToInt($totalCalorie); ?></b> kcal
                </div>
            </div>

            <div class="org">
                <div class="org_int_up">Proteínas</div>
                <div class="org_int_down"><?php echo Check::changeToInt($protein); ?> |
                    <b style="font-size: 16px;"> <?php echo Check::changeToInt($totalProtein); ?></b> g
                </div>
            </div>

            <div class="org">
                <div class="org_int_up">Gordura</div>
                <div class="org_int_down"><?php echo Check::changeToInt($fat); ?> |
                    <b style="font-size: 16px;"> <?php echo Check::changeToInt($totalFat); ?></b> g
                </div>
            </div>

            <div class="org">
                <div class="org_int_up" style="color: blue;">Água</div>
                <div class="org_int_down"><?php echo Check::changeToInt($water); ?> |
                    <b style="font-size: 16px;"> <?php echo Check::changeToInt($totalWater); ?></b> ML
                </div>
            </div>
            <div id="hr"></div>

            <!--###### INICIO DOS CADASTRADOS ###### -->
            <?php

            $mealsNumber1 = Check::searchIdData('diets', 'diet_number_meal', '1');
            if ($mealsNumber1) {
                $cadDiet = new diet();
                $cadDiet->mealsPrint('1', $user_id);
            };

            $mealsNumber2 = Check::searchIdData('diets', 'diet_number_meal', '2');
            if ($mealsNumber1) {
                $cadDiet = new diet();
                $cadDiet->mealsPrint('2', $user_id);
            };

            $mealsNumber3 = Check::searchIdData('diets', 'diet_number_meal', '3');
            if ($mealsNumber1) {
                $cadDiet = new diet();
                $cadDiet->mealsPrint('3', $user_id);
            };
            $mealsNumber4 = Check::searchIdData('diets', 'diet_number_meal', '4');
            if ($mealsNumber1) {
                $cadDiet = new diet();
                $cadDiet->mealsPrint('4', $user_id);
            };
            /*
            $mealsNumber5 = Check::searchIdData('diets', 'diet_number_meal', '5');
            if ($mealsNumber1) {
                $cadDiet = new diet();
                $cadDiet->mealsPrint('5', $user_id);
            };
            $mealsNumber6 = Check::searchIdData('diets', 'diet_number_meal', '6');
            if ($mealsNumber1) {
                $cadDiet = new diet();
                $cadDiet->mealsPrint('6', $user_id);
            };
            */
            ?>


        </div>
</body>

</html>
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
<!DOCTYPE html>
<html lang="pt-br">

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
        });
    </script>
    <title> Pavil Sistema Empresarial</title>
</head>

<body>
    <div id="full">
        <?php include("../../layout/header.php"); ?>
        <?php
        /*
        $category2 = 'food_calorie';
        $category = 1;
        
        //faz busca com os metodos de leitura de dados
        $read = new Read();
        // adciona a atbela para leituta
        //$read->exeRead('diets', "WHERE 'diet_number_meal' = '$number_meal'");
        $read->exeRead('diets');

        //print_r($read);
        // faz a leitura dos dados na base
        if (!$read->getResult()) {
            echo 'nennhum';
        } else {
            $totalMeal = 0;
            foreach ($read->getResult() as $line) :
                $foods = Check::searchIdData('foods', 'food_id', $line['food_id']);

             $subTotalMeal = $foods['food_calorie'] * $line['diet_food_amount'];
                echo'<br>';
                echo $totalMeal = $totalMeal + $subTotalMeal;
                echo'<br>';
                //return $totalMeal;
            //return 'aqui';

            endforeach;
        }

             $totalCalorie = Check::totalMeals(1,'food_calorie','diet_food_amount');
             $totalProtein = Check::totalMeals(1,'food_protein','diet_food_amount');
             $totalFat = Check::totalMeals(1,'food_fat','diet_food_amount');


          */

        /*

          $arquivo = 'central_anabol';

          if (file_exists($arquivo)) {
              // Lê o conteúdo do arquivo
              $conteudo = file_get_contents($arquivo);
              
              // Divide os números pelo ponto e vírgula
              $telefones = explode(',', $conteudo);
              $contador = 1;
              echo "<h3>Telefones encontrados:</h3>";
              foreach ($telefones as $numero) {
                  $numero = trim($numero); // remove espaços e quebras de linha
                  if (!empty($numero)) {
                    $nome = "Usuário " . $contador;

                      echo $nome ." = ".$numero . "<br>";
                  }
                  $contador++;

              }
          } else {
              echo "Arquivo não encontrado.";
          }

          require_once 'SimpleXLSXGen.php'; // caminho do arquivo da lib

use Shuchkin\SimpleXLSXGen;

$data = [
    ['Nome', 'Email'],
    ['João da Silva', 'joao@example.com'],
    ['Maria Oliveira', 'maria@example.com']
];

$xlsx = SimpleXLSXGen::fromArray($data);
$xlsx->downloadAs('usuarios.xlsx'); // ou 
//$xlsx->saveAs('usuarios.xlsx');  
*/
        require_once 'SimpleXLSXGen.php';

        use Shuchkin\SimpleXLSXGen;

        $arquivo = 'central_anabol';

        if (file_exists($arquivo)) {
            // Lê o conteúdo do arquivo (esperado: 11999999999,21988888888,...)
            $conteudo = file_get_contents($arquivo);

            // Separa os telefones por vírgula
            $telefones = explode(',', $conteudo);

            // Cabeçalho do Excel
            $dados = [['Nome', 'Telefone']];

            // cria obejto cadastro na base
            $cadTel = new Create();

            // Geração de nomes sequenciais
            $contador = 1;
            $contador_telefone = 1;
            foreach ($telefones as $numero) {
                $numero = trim($numero);
                if (!empty($numero)) {
                    $nome = "PAC" . $contador;
                    $dados = [$nome, $numero];

                    $dadosParaInsert = [
                        'phone_clients_name' => $nome,
                        'phone_clients_number'  => $numero
                    ];


                echo "<pre>";
                var_dump($dadosParaInsert);
                echo "</pre>";
                    //executa cadastro na base
                    $cadTel->exeCreate('phone_clients', $dadosParaInsert);

                    // se tiver cadastrado retorna mensagem de sucesso
                    if ($cadTel->getResult()) :
                        $this->Error = MSGErro("<b>Telefone cadastrado com Sucesso!</b>", MSG_ACCEPT);
                    endif;
                    //$dados[] = [$nome, $numero];
                    $contador++;
                }
    
                echo "<pre>";
                var_dump($dadosParaInsert);
                echo "</pre>";
            }

            // Gera e baixa o Excel
            //SimpleXLSXGen::fromArray($dados)->downloadAs('usuarios_telefones.xlsx');
        } else {
            echo "Arquivo não encontrado.";
        }
        ?>
        <!--###### INICIO DO FORMULARIO CADASTRAR ###### -->
        <fieldset class="padrao">
            <legend>Geral</legend>
            <?php
            //echo 'Total de Calorias: '.$totalCalorie.'<br>';
            //echo 'Total de Proteina: '.$totalProtein.'<br>';
            //echo 'Total de Gordura: '.$totalFat.'<br>';

            ?>
        </fieldset>

        <?php include("../../layout/footer.php"); ?>

    </div>
</body>

</html>
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
        $arquivo = 'raiz_marromba_03';

        if (file_exists($arquivo)) {
            $conteudo = file_get_contents($arquivo); // Lê o conteúdo
            $telefones = explode(',', $conteudo);   // Separa por vírgula

            $cadTel = new Create(); // sua classe de insert
            $contador = 1;

            // Obtem o último nome PAC cadastrado
            $getLastPAC = new Read();
            $getLastPAC->ExeRead('phone_clients', "WHERE phone_clients_name LIKE 'PAC%' ORDER BY phone_clients_id DESC LIMIT 1");

            if ($getLastPAC->getResult()) {
                $ultimoNome = $getLastPAC->getResult()[0]['phone_clients_name']; // Ex: PAC27
                preg_match('/PAC(\d+)/', $ultimoNome, $matches);
                $contador = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
            } else {
                $contador = 1; // nenhum PAC ainda
            }

            foreach ($telefones as $numero) {
                $numero = trim($numero); // remove espaços extras
                if (!empty($numero)) {
                    $numeroLimpo = preg_replace('/\D/', '', $numero); // mantém só números
                    $nome = "PAC" . $contador;

                    $dadosParaInsert = [
                        'phone_clients_name' => $nome,
                        'phone_clients_number' => $numeroLimpo,
                        'phone_clients_state'  => 1
                    ];

                    $cadTel->exeCreate('phone_clients', $dadosParaInsert);

                    if ($cadTel->getResult()) {
                        echo "[$contador] Telefone {$numeroLimpo} cadastrado com sucesso!<br>";
                    } else {
                        echo "[$contador] Erro ao cadastrar: {$numeroLimpo}<br>";
                    }

                    $contador++;
                }
            }
        } else {
            echo "Arquivo não encontrado!";
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
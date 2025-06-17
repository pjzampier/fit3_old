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
    <title> <?php echo NAME_SITE; ?></title>
</head>

<body>
    <div id="full">
        <?php include("../../layout/header.php"); ?>
        <?php
        MSGErro("Seja Bem Vindo <b>{$userLogin['user_name']}! </b>", MSG_ACCEPT);
        ?>
        <!--###### INICIO DO FORMULARIO CADASTRAR ###### -->
        <fieldset class="padrao">
            <legend>Geral</legend>
        </fieldset>

        <?php include("../../layout/footer.php"); ?>

    </div>
</body>

</html>
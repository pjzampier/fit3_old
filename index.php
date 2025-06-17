<?php
//starta sessao
ob_start();
session_start();
//incluio arquivo de autoload das classe e gerador de mensagens
require('./Config.inc.php');
?>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset= utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="image/icon.png" />
    <meta http-equiv="Content-Language" content="pt-br">
    <link rel="stylesheet" type="text/css" href="css/style_home.css">
    <link rel="stylesheet" type="text/css" href="css/style_site.css">
    <link rel="stylesheet" type="text/css" href="css/style_message.css">

    <!--###### IDENTA JQUERY ####### -->
    <script type="text/javascript" src="jquery/jquery-1.5.2.min.js"></script>
    <script type="text/javascript" src="jquery/jquery.maskedinput-1.3.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('body').fadeIn(1800);
        });
    </script>
    <title> <?php //require('nome_site.php');
            ?></title>
</head>

<body>
    <?php include("./analyticstracking.php") ?>

    <div id="full">
        <?php include_once './layout/header_menu.php'; ?>

        <!--div id="banner_2">
                Entrar no Pavil Sistemas
            </div-->

        <div id="center_primeiro" style="margin-top: 50px;">
            <br><br>
            <h1>Encontre o seu melhor</h1>
            <!--div class="letreiro">
                <p>G1 - O Portal de notícias.</p>
            </div-->
            <!--viewBox="30 -50 600 500"-->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
                <path id="path">
                    <animate attributeName="d" from="m30,40 h0" to="m30,40 h1100" dur="6.0s" begin="0s" repeatCount="indefinite" />
                </path>
                <text width="50%" font-size="46" font-family="ubuntu" fill='#4169E1'>
                    <textPath xlink:href="#path">Dieta feita para seu perfil!
                    </textPath>
                </text>
            </svg>

            <p style="font-style: italic; font-size:20px; margin-top:30px; color:#B0C4DE;">Monte e controle sua dieta de forma Fácil.</p>
            <p style="font-style: italic; font-size:20px; color:#B0C4DE; ">Tenha certeza que esta no caminho Certo, para melhorar o seu corpo... </p>

            <?php
            // pega todos dados enviado por post em forma de array
            $dataContact = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            /*
            echo "<pre>";
            var_dump($dataContact);
            echo "</pre>";
            */

            ###### começo do cadastro
            // se tiver passado algum valor pelo formulario
            if (!empty($dataContact['dataContact'])) :
                unset($dataContact['dataContact']);

                // pega o ip e atribui a variavel
                $dataContact['contact_ip'] = $_SERVER["REMOTE_ADDR"];

                $cadContact = new contact();
                $cadContact->exeContact($dataContact);

                if ($cadContact->getResult()) :
                    //retorna as mensagens de erro da validação 
                    MSGErro(isset($cadContact->getError()[0]), isset($cadContact->getError()[1]));
                    //se tiver sido cadastrado limpa variavel post  
                    if ($cadContact->getResult() == TRUE) :
                        //unset($dataContact);
                        //redireciona para pagina
                        $local = header('Location: '.HOST_SITE.'/view/user/register.php?contact_email='.$dataContact['contact_email']);
                    endif;

                endif;
            endif;

            ?>

            <div id="form_email">
                <form name="AdminLoginForm" action="" method="post">
                    <input type="text" name="contact_email" placeholder=" Seu e-mail" value="<?php if (isset($dataContact)) echo $dataContact['contact_email']; ?>" class="email" style="font-weight:bold; " />
                    <input type="submit" name="dataContact" value="Comece grátis " id="botao_email" />
                </form>
            </div>
        </div>

    </div>
    <!--div id="center_segundo" style="margin-top: 1px;"-->

    </div>
    <?php include_once './layout/footer.php'; ?>

</body>

</html>
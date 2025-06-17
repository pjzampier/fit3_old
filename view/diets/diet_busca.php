<?php
//starta sessao
session_start();
//incluio arquivo de autoload das classe e gerador de mensagens
require('../../Config.inc.php');

// passa o parametro de restrição de usuario
$login = new login(1);
// se o atributo de verificação nao achar o usuario --- se nao estiver logado
if (!$login->checkLogin()):
    // termina a sessao e reencaminha para fora do sistema
    unset($_SESSION['userlogin']);
    //envia para fora do sistema  
    header('Location: ../../index.php?validate=limited');
else:
    // se checklogin tiver valor atribui os dados do usuario para variavel local 
    $userLogin = $_SESSION['userlogin'];

endif;
?>
<html>
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
    <title> Pavil Sistema Empresarial</title>
</head>	


<body>
    <div id="full">
        <?php include ("../../layout/header.php"); ?>
        <?php
        //$search = filter_input(INPUT_POST,'search', FILTER_DEFAULT);
        $search = filter_input(INPUT_GET, 'search', FILTER_DEFAULT);
        //pega o parametro para definir a paginaçao
        $pager = filter_input(INPUT_GET, 'pager', FILTER_VALIDATE_INT);
        ?>

        <!--###### INICIO DA  BUSCA ###### -->

        <fieldset class="padrao">
            <legend class="padrao">Buscar Clientes</legend>

            <form name="buscarForm" action="client_busca.php" method="get">   
                <div class="org_input">    
                    <span class="inicial">Busca:</span>
                    <input type="text" name="search" placeholder=" Sua busca" class="padrao"/>
                </div>

                <div class="org_botao">
                    <input  type="submit" name = "clientBuscar" value="Buscar" id="botao" />
                </div>
            </form>
        </fieldset>

        <!--###### INICIO DOS CADASTRADOS ###### -->

        <fieldset class="padrao" style="margin-bottom: 30px;">
            <legend class="padrao">Clientes Cadastrados</legend>
            <div class="linha_resultado" style="font-weight:bold; color: #32CD32; ">
                <div class="resultado_item" style="width: 5%; background-color: #F5F5F5;">ID </div>
                <div class="resultado_item" style="width: 30%; background-color: #FFF;">NOME </div>
                <div class="resultado_item" style="width: 25%; background-color:#F5F5F5;">SOBRENOME </div>
                <div class="resultado_item" style="width: 26%; background-color:#FFF;">EMAIL </div>
            </div>
            <?php
##### PAGINACAO
            $paginator = new Pager("client_busca.php?search={$search}&pager=", "Primeira", "Última", 3);
            $paginator->ExePager($pager, 15);
            $read = new Read();

            $read->exeRead('clients', "WHERE client_lastname LIKE '%{$search}%' OR client_name LIKE '%{$search}%' OR client_cnpj LIKE '%{$search}%'  LIMIT :limit OFFSET :offset", "limit={$paginator->getLimit()}&offset={$paginator->getOffset()}");
//$read->exeRead("clients","WHERE client_name LIKE '%{$search}%'");

            if (!$read->getRowCount()):
                $paginator->ReturnPage();
                MSGErro("Nenhum Resultado encontrado", MSG_ALERT);
            else:
                foreach ($read->getResult() as $line):
                    echo "<div class='linha_resultado'> "
                    . "<div class=\"resultado_item\" style=\"width: 5%; background-color: #F5F5F5; \">{$line['client_id']}</div> "
                        . "<div class=\"resultado_item\" style=\"width: 30%; background-color: #FFF;\">{$line['client_name']}"." "."{$line['client_description']}</div> "
                    . "<div class=\"resultado_item\" style=\"width: 25%; background-color: #F5F5F5;\">{$line['client_lastname']}</div> "
                    . "<div class=\"resultado_item\" style=\"width: 26%; background-color: #FFF;\">{$line['client_email']}</div> "
                    . " <div class= \"botao_excluir\"> <a href='client_create.php?delete= {$line['client_id']}'><img src=\"../../image/excluir.png\" width=\"\" height=\"\"></div>"
                    . " <div class= \"botao_editar\">  <a href='client_update.php?id= {$line['client_id']}'>  <img src=\"../../image/editar.png\" width=\"\" height=\"\"></a></div>"
                    . "</div>";

                endforeach;
            endif;

            $paginator->ExePaginator('clients', "WHERE client_name LIKE '%{$search}%'");
            echo $paginator->getPaginator();
            ?>
        </fieldset>

        <?php include ("../../layout/footer.php"); ?>

    </div>
</body>
</html>

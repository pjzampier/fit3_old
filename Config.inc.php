<?php

// CONFIGURAÇAO DO SITE ##########
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '311');
define('BASE', 'fit3');

//endereço url padrao
//define('HOST_SITE', 'http://digner.com.br/');
define('HOST_SITE', 'http://127.1.1.1/fit3/');
//define('HOST_SITE_', 'digner.com.br/');
define('HOST_SITE_', 'http://127.1.1.1/fit3/');
define('NAME_SITE', 'FIT3.CLUB');



// AUTO LOAD DE CLASSES ##########
function __autoload($Class) {

    $cDir = ['system/base_data', 'system/helpers', 'system/models'];
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . "//{$dirName}//{$Class}.class.php") && !is_dir(__DIR__ . "//{$dirName}//{$Class}.class.php")):

            include (__DIR__ ."//{$dirName}//{$Class}.class.php");
           
            $iDir = TRUE;
        endif;
    endforeach;
    
    if(!$iDir):
        
        trigger_error("Não foi possivel incluir {$Class}.class.php", E_USER_ERROR);
        die;
        
    endif;
        
}

// TRATAMENTO DE ERROS  ##########
//CSS Constantes:: Mensagens de erros
//Definindo os inteiros com os apelidos
define('MSG_ACCEPT', 'accept');
define('MSG_INFOR', 'infor');
define('MSG_ALERT', 'alert');
define('MSG_ERROR', 'error');

//MSG_Error :: Exibe erros lançados :: Front
//funcao que define os erros 
function MSGErro($ErrMsg, $ErrNo, $ErrDie = NULL) {

    //atribui os valores e verificaçoes de qual erro gerou na variavel Cssclass 
    //Conforme o numero erro=($ErrNo) se define a constante do php nos ifs
    $CssClass = ($ErrNo == E_USER_NOTICE ? MSG_INFOR : ($ErrNo == E_USER_WARNING ? MSG_ALERT : ($ErrNo == E_USER_ERROR ? MSG_ERROR : $ErrNo)));
    //conforme o erro e monstrado a tag css na classe
    echo "<p class = \"trigger {$CssClass} \">{$ErrMsg}<span class = \"ajax_close\"></span></p>";

    // finaliza em caso de  
    if ($ErrDie):
        die();
    endif;
}

//PHPError :: Personaliza o gatinho do php
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {

    $CssClass = ($ErrNo == E_USER_NOTICE ? MSG_INFOR : ($ErrNo == E_USER_WARNING ? MSG_ALERT : ($ErrNo == E_USER_ERROR ? MSG_ERROR : $ErrNo)));
    echo"<p class = \"trigger {$CssClass} \">";
    echo"<b>Erro na Linha: {$ErrLine} :: </b> {$ErrMsg} <br>";
    echo "<small>{$ErrFile}</small>";
    echo"<span class = \"ajax_close\"></span></p>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

//modifca o padrao de tratamento de erro do php para funcao
set_error_handler('PHPErro');

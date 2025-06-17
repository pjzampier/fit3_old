<?php

/**
 * Conn.class [conexao]
 * Classe abstrata de conexao. Padrao singleton
 * Retorna um objeto PDO pelo metodo estatico getConn();
 * @author pj
 */
class Conn {

    //variaveis inteira que vem do arquivo config.ing.php
    private static $Host = HOST;
    private static $User = USER;
    private static $Pass = PASS;
    private static $Base = BASE;
    
    private static $connect = null;



    // contecta com o banco e com pattern singleton 
    // retorna um objeto PDO 
    public static function conectar() {
        
        
        // usa o try catch para separar a aceitacao do erro 
        try{
            // verifica se a conexao nao esta conectada para evitar executar o codigo novamente
            if(self::$connect == NULL): 
            // atributos exigidos do objeto PDO para conexão
            $dsn = 'mysql:host='.self::$Host .';dbname='.self::$Base;
            // informa os formato de acentuação em array 
            $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
            
                // se estiver nulo a conexao se conecta
                self::$connect = new PDO($dsn, self::$User, self::$Pass, $options);
            endif;
            
            
        } catch (PDOException $e) {
            // caso tenha  axesao no caso o erro PHP retorta o erro no padrao de Mensagens 
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            die;
        }
        
        // executa o metodo de configuração padrao do php para erros do mysql
        self::$connect->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION );
        //retorna o erro
        return self::$connect;
        
    }
    //retorna um objeto sinpleton pattern
    public static function getConn() {
        
        return self:: conectar();
    }
}

<?php

/**
 * Classe responsavel pelos cadastros no banco de dados
 *
 * @author pj
 */
class Create extends Conn {

    private $Tabela;
    private $Dados;
    private $result;
    private $Create;
    private $Conn;

    /**
     * Executa um cadastro simplificado na tabela do banco de dados
     * ultilzando um prepared statements.
     * 
     * @param STRING $Tabela = INFORME O NOME DA TABELA NO BANCO
     * @param array $Dados = INFORME UM VALOR EM ARRAY ATRIBUITIVO. (NOME DA COLUNA => VALOR)
     */
    
    
    // metodo para pegar os atributos passados 
    public function exeCreate($Tabela, Array $Dados) {
        
        // pega os valores e atribui as variaveis da classe
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;

        //executa o metodo da sintaxe
        $this->getSyntax();
        // execua o metodo de cadastro
        $this->Execute();
    }

    /**
     * 
     * @return 
     * retorna Falso ou o ultimo cadastro na tabela.
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * ************************************
     * ********* METHODS PRIVATE  *********
     * ************************************
     */
    //metho de conexao com o banco de dados
    private function connect() {

        // atribui o valor do metodo da classe pai a classe filho
        $this->Conn = parent::getConn();
        
        //prepara os atributos para ser cadastrados, 
        //usando a conexao com banco junto com a query criada na classe getSystax
        $this->Create = $this->Conn->prepare($this->Create);
    }

    private function getSyntax() {

        // forma a sinyaxe da query com atributos de verificação em array, 
        // da variave dados
        $fileds = implode(', ', array_keys($this->Dados));
        
        $places = ':' . implode(', :', array_keys($this->Dados));

        $this->Create = "INSERT INTO {$this->Tabela} ({$fileds}) VALUES ({$places})";
    }

    private function Execute() {
        // faz a conexao com o banco  
        $this->connect();

        try {
            
            // executa a query com o metodo dos atributos
            $this->Create->execute($this->Dados);

            // atrivui o valor do numero do id castrado, 
            // desta forma pode fazer um verificaçao de cadastro ok
            $this->result = $this->Conn->lastInsertId();
        } catch (PDOException $e) {
            // caso nao tenha sido casdastrado atribui valor nulo, 
            // Para negação  
            $this->result = NULL;
            
            MSGErro("<b>Erro ao cadastrar no banco de dados!</b> {$e->getMessage()} - {$e->getCode()}", MSG_ERROR);
        }
    }

}

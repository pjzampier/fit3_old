<?php

/**
 * Classe responsavel pela leitura no banco de dados
 *
 * @author pj
 */
class Read extends Conn {

    private $Select;
    private $Places;
    private $result;
    private $Read;
    private $Conn;

    /**
     * Executa um cadastro simplificado na tabela do banco de dados
     * ultilzando um prepared statements.
     * 
     * @param STRING $Tabela = INFORME O NOME DA TABELA NO BANCO
     * @param array $Dados = INFORME UM VALOR EM ARRAY ATRIBUITIVO. (NOME DA COLUNA => VALOR)
     */
    // metodo para pegar os atributos passados  
    public function exeRead($Tabela, $Termos = NULL, $ParseString = NULL) {

        if (!empty($ParseString)):
            //parse transforma o atributo em um array
            parse_str($ParseString, $this->Places);
        endif;

        $this->Select = "SELECT * FROM {$Tabela} {$Termos}";
        $this->Execute();
    }

    //metodo para passar a informaçoes do resultado da query 
    public function getResult() {

        //retorna o resultado
        return $this->result;
    }
// metodo para contar a quantidade de query encontradas
    public function getRowCount() {
        //retorna quantidadde de resultados
        return $this->Read->rowCount();
    }
// rescreve totalmente uma query
    public function fullRead($Query, $ParseString = null) {
        //passa a query e exige que seja uma string
        $this->Select = (string) $Query;
        //se tiver valor
        if (!empty($ParseString)):
            //transforma em array 
            parse_str($ParseString, $this->Places);
        endif;
        // executa a query
        $this->Execute();
    }

    public function setPlaces($ParseString) {

        parse_str($ParseString, $this->Places);
        $this->Execute();
    }

    /**
     * ************************************
     * ********* METHODS PRIVATE  *********
     * ************************************
     */
    //metho de conexao com o banco de dados 
    //e prepara a query para ser executada 
    private function connect() {
        //chama o metodo da classe pai responsavel pela conexao  
        $this->Conn = parent::getConn();
        //cria o objeto PDO e recebe o valor de preparo da query
        $this->Read = $this->Conn->prepare($this->Select);
        // transforma o valor em um array
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
    }
// cria sistaxe da query para prepared statement 
    private function getSyntax() {
       //se a variavel de modificaçao da query tiver valor 
        if ($this->Places):
            // faz um laco com um array de cada atributo
            foreach ($this->Places as $vinculo => $valor):
            // se o termo vinculo e offset for passado modifica para inteiro
                if ($vinculo == 'limit' || $vinculo == 'offset'):

                    $valor = (int)$valor;
                endif;
                // monta o bind com os valores do laço       #se for passado int monta o bind com int senao com string
                $this->Read->bindValue(":{$vinculo}", $valor, (is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        endif;
    }

    //executando os metodo ou gera um erro
    private function Execute() {
// pega o metodo de conexao
        $this->connect();

        try {
            //pega o metodo de sintaxe
            $this->getSyntax();
            //Executa a variavel read que esta preparado a conexao com a sintaxe
            $this->Read->execute();
            //a result recebe o valor em array
            $this->result = $this->Read->fetchAll();
        } catch (Exception $e) {

            //passa valor nulo caso nao consiga salvar no banco
            $this->result = NULL;
            // exibe a mensagem de erro
            MSGErro("<b>Erro ao Ler!</b><br> {$e->getMessage()} - {$e->getCode()}", MSG_ERROR);
        }
        //MSGErro("<b>Erro ao cadastrar no banco de dados!</b> {$e->getMessage()} - {$e->getCode()}", MSG_ERROR);
    }

}

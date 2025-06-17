<?php

/**
 * Classe responsavel por deletar no banco de dados
 *
 * @author pj
 */
class Delete extends Conn {

    private $Tabela;
    private $Termos;
    private $Places;
    private $result;

    /** @var PDO STATEMENT */
    private $Delete;

    /** @var PDO */
    private $Conn;

    // metodo para pegar os atributos passados  
    // metodo principal que executa todos os outros 
    public function exeDelete($Tabela, $Termos, $ParseString) {
        $this->Tabela = $Tabela;
        $this->Termos = $Termos;
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
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
        return $this->Delete->rowCount();
    }

    public function setPlaces($ParseString) {

        parse_str($ParseString, $this->Places);
        $this->getSyntax();
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
        $this->Conn = parent::getConn();
        $this->Delete = $this->Conn->prepare($this->Delete);
    }

// cria sistaxe da query para prepared statement 
    private function getSyntax() {
         // adiciona os atributos na query
        $this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
    }

    //executando os metodo ou gera um erro
    private function Execute() {
        //faz a conexao com banco de dados via PDO
        $this->connect();

        try {
            // executa a query
            $this->Delete->execute($this->Places);
            // caso tenha sucesso retorna valor verdadeiro
            $this->result = TRUE;
        } catch (PDOException $e) {
            //passa valor nulo caso nao consiga salvar no banco
            $this->result = NULL;
            // exibe a mensagem de erro
            MSGErro("<b>Erro ao Deletar!</b><br> {$e->getMessage()} - {$e->getCode()}", MSG_ERROR);
        }
    }

}

<?php

/**
 * Classe responsavel pelas atualizaçoes no banco de dados
 *
 * @author pj
 */
class Update extends Conn {

    private $Tabela;
    private $Dados;
    private $Termos;
    private $Places;
    private $result;

    /** @var PDO STATEMENT */
    private $Update;

    /** @var PDO */
    private $Conn;

    // metodo para pegar os atributos passados  
    public function exeUpdate($Tabela, array $Dados, $Termos, $ParseString) {
       
        
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;
        $this->Termos = (string) $Termos;

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
        return $this->Update->rowCount();
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
        $this->Update = $this->Conn->prepare($this->Update);
    }

// cria sistaxe da query para prepared statement 
    private function getSyntax() {

        
        foreach ($this->Dados as $key => $value):
            
            $places[] = $key . ' =:' . $key;
        
        endforeach;
        $places = implode(',', $places);
        $this->Update = "UPDATE {$this->Tabela} SET {$places} {$this->Termos}";
    }

    //executando os metodo ou gera um erro
    private function Execute() {
        $this->connect();
        try {
            
            $this->Update->execute(array_merge($this->Dados, $this->Places));
            $this->result = TRUE;
            
        } catch (PDOException $e) {
            //passa valor nulo caso nao consiga salvar no banco
            $this->result = NULL;
            // exibe a mensagem de erro
            MSGErro("<b>Erro ao Atualizar!</b><br> {$e->getMessage()} - {$e->getCode()}", MSG_ERROR);
        }
    }

}

<?php

/**
 * Classe responsavel gestao de paginacaos e paginação
 *
 * @author pj
 */
class Pager {

    /** DEFINE PAGER */
    private $Page;
    private $Limit;
    private $Offset;

    /** REALIZA LEITURA */
    private $Tabela;
    private $Termos;
    private $Places;

    /** DEFINE O PAGINATOR */
    private $Rows;
    private $Link;
    private $MaxLinks;
    private $First;
    private $Last;

    /** RENDERIZA O PAGINATOR */
    private $Paginator;

    //recebe os atributos e valida
    function __construct($Link, $First = null, $Last = null, $MaxLinks = null) {
        $this->Link = (string) $Link;
        $this->First = ((string) $First ? $First : 'Primeira página');
        $this->Last = ((string) $Last ? $Last : 'Última pagina');
        $this->MaxLinks = ((int) $MaxLinks ? $MaxLinks : 5);
    }

    // executa a paginação
    public function ExePager($Page, $Limit) {

        $this->Page = ((int) $Page ? $Page : 1);
        $this->Limit = (int) $Limit;
        $this->Offset = ($this->Page * $this->Limit) - $this->Limit;
    }

    // evita erro de paginação errada
    public function ReturnPage() {

        if ($this->Page > 1):
            $nPage = $this->Page - 1;
            header("Location: {$this->Link}{$nPage}");
        endif;
    }

    //retorna os valores passados
    public function getPage() {
        return $this->Page;
    }

    //retorna os valores passados
    public function getLimit() {
        return $this->Limit;
    }

    //retorna os valores passados
    public function getOffset() {
        return $this->Offset;
    }

    public function ExePaginator($Tabela, $Termos = null, $ParseString = NULL) {

        $this->Tabela = (string) $Tabela;
        $this->Termos = (string) $Termos;
        $this->Places = (string) $ParseString;

        $this->getSyntax();
    }

    public function getPaginator() {

        return $this->Paginator;
    }

    //PRIVATE

    private function getSyntax() {
        $read = new Read;
        $read->ExeRead($this->Tabela, $this->Termos, $this->Places);
        $this->Rows = $read->getRowCount();

        // se linhas menor que limitw
        if ($this->Rows > $this->Limit):

            $paginas = ceil($this->Rows / $this->Limit);
            $maxLinks = $this->MaxLinks;

            $this->Paginator = "<div class=\"linha_resultado\">";
            $this->Paginator .= "<a title = \"{$this->First}\"href=\"{$this->Link}1\" class= \"paginacao\"><div class=\"paginacao_item\">{$this->First}</div></a>";
            for ($ipag = $this->Page - $maxLinks; $ipag <= $this->Page - 1; $ipag ++):
                if($ipag >= 1):
                $this->Paginator .= "<a title = \"Página {$ipag}\"href=\"{$this->Link}{$ipag}\" class= \"paginacao\"><div class=\"paginacao_item\">{$ipag}</div></a>";
                endif;
            endfor;
            $this->Paginator .= "<div class=\"paginacao_item\"><span class= \"active\">{$this->Page}</span></div>";
            
            for ($dpag = $this->Page + 1; $dpag <= $this->Page + $maxLinks; $dpag ++):
                if($dpag <= $paginas):
                $this->Paginator .= "<a title = \"Página {$dpag}\"href=\"{$this->Link}{$dpag}\"class= \"paginacao\"><div class=\"paginacao_item\">{$dpag}</div></a>";
                endif;
            endfor;
            
            $this->Paginator .= "<a title = \"{$this->Last}\"href=\"{$this->Link}{$paginas}\" class= \"paginacao\"><div class=\"paginacao_item\">{$this->Last}</div></a>";
            $this->Paginator .="</div>";
        endif;
    }

}

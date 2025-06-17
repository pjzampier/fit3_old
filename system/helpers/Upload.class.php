<?php

/**
 * Classe repomsavel por executar upload de imagens, arquivos e midias
 *
 * @author pj
 */
class Upload {

    private $File;
    private $Name;
    private $Send;

    /** IMAGE UPLOAD */
    private $Width;
    private $Image;

    /** RESULTSET */
    private $Result;
    private $Error;

    /** DIRETORIOS */
    private $Folder;
    private static $BaseDir;

    //cria pasta upload caso nao exista
    function __construct($BaseDir = NULL) {

        //atribui o caminho da pasta de upload se nao existe passa o valor padrao
        self::$BaseDir = ((string) $BaseDir ? $BaseDir : '../uploads/');

        // se a pasta nao existe
        if (!file_exists(self::$BaseDir) && !is_dir(self::$BaseDir)):
            //cria a pasta
            mkdir(self::$BaseDir, 0777);
        endif;
    }

    //verifica os atributos passados
    public function Image(array $Image, $Name = NULL, $Widht = NULL, $Folder = NULL) {

        $this->File = $Image;
        $this->Name = ((string) $Name ? $Name : substr($Image['name'], 0, strrpos($Image['name'], '.')));
        $this->Width = ((int) $Widht ? $Widht : 1024 );
        $this->Folder = ((string) $Folder ? $Folder : 'images');

        //chama metodo de criaçao
        $this->CheckFolder($this->Folder);
        //seta o nome 
        $this->setFileName();
    }

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

    /// PRIVATE
    //cria pastas para imagens com ano e mes
    private function CheckFolder($Folder) {

        list($y, $m) = explode("/", date('Y/m'));
        $this->CreateFolder("{$Folder}");
        $this->CreateFolder("{$Folder}/{$y}");
        $this->CreateFolder("{$Folder}/{$y}/{$m}/");
        $this->Send = "{$Folder}/{$y}/{$m}/";
    }

    //complemento do metodo de criaçao de pasta por ano e mes
    private function CreateFolder($Folder) {

        // se a pasta nao existe
        if (!file_exists(self::$BaseDir . $Folder) && !is_dir(self::$BaseDir . $Folder)):
            //cria a pasta
            mkdir(self::$BaseDir . $Folder, 0777);
        endif;
    }

    private function setFileName() {
        //$fileName = Check::name($this->Name) . strrchr($this->File['name'], '.');
        $FileName = Check::Name($this->Name) . strrchr($this->File['name'], '.');
        if (file_exists(self::$BaseDir . $this->Send . $FileName)):
            $FileName = Check::Name($this->Name) . '-' . time() . strrchr($this->File['name'], '.');
        endif;
        $this->Name = $FileName;

        echo'<pre>';
        var_dump($FileName);
        echo'</pre>';
    }

}

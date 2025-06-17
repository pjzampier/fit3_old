<?php

/**
 * Responsavel por carregar renderizar a view e modificar os valores para php
 * arquitetura mvc
 *
 * @author pj
 */
class view {

    private static $Data;
    private static $Keys;
    private static $Values;
    private static $Template;

    //recece o atributo do nome do arquivo da view
    public static function Load($template) {
        self::$Template = (string) $template;
        self::$Template = file_get_contents(self::$Template . ".tpl.php");

        // var_dump(self::$Template);
    }

    public static function Show(array $Data) {
        self::setKeys($Data);
        self::setValues();
        self::showView();
    }

    public static function Request($file, array $Data) {
        extract($Data);
        require ("{$file}.inc.php");
    }

    private static function setKeys($Data) {

        self::$Data = $Data;
        self::$Keys = explode('&', '#' . implode('#&#', array_keys(self::$Data)) . '#');
    }

    private static function setValues() {
        self::$Values = array_values(self::$Data);    
    }
    
    private static function showView() {
        
        echo str_replace(self::$Keys, self::$Values, self::$Template);
    }

}

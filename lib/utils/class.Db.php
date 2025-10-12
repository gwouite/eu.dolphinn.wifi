<?php
if (!defined('SPLASH-VD')) {
    die("err");
}

class Db extends PDO {
    private static $objet = null;

    public static function singleton($hote = "", $port = "", $user = "", $pass = "", $db = "") {
        if (!is_null(self::$objet) && is_a(self::$objet, 'Db')) return self::$objet;
        
        
        $objet = new Db($hote, $port, $user, $pass, $db);
        self::$objet = $objet;

        return self::$objet;
    }

    public function __construct($hote, $port, $user, $pass, $db) {

        $dsn = "mysql:host=".$hote.";port=".$port.";dbname=".$db;
        
        return parent::__construct($dsn, $user, $pass);
    }



}
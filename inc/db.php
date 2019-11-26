<?php

class Baza {
    private $db = null;
    var $ret = array();
    var $mode = PDO::FETCH_ASSOC;
    var $kom = array();
    
    function __construct(){
        global $db, $dbfile, $kom;
        if (!file_exists($dbfile))
            $kom[]= "Brak pliku bazy tworze nowy.";
        
        $db = new PDO("sqlite:$dbfile");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function init_tables() {
        global $db, $kom;
        if (file_exists('baza/baza.sql')){
            $q ="SELECT name FROM sqlite_master WHERE type='table' AND name='menu'";
            $ret = array();
            db_query($q, $ret);
            if(empty($ret)){
                $sql = file_get_contents('baza/baza.sql');
                $db->exec($sql);
                $kom[]="Utworzono tabeleczkę";
            }
      }
    }

    function db_query($q, &$ret){
        global $db;
        $r = null;
        try {
            $r = $db->query($q);
        } catch(PDOException $e){
            echo ($e->getMessage());
        }
        if ($r){
            $ret = $r->fetchAll();
            return true;
        }
        return false;
    }
}

?>

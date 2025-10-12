<?php
// define("SQL", true);
include dirname(__FILE__).'/lib/lib.php';

if (!isset($_SERVER['REQUEST_URI'])) exit("ERR 1");
if(!preg_match('/^'.addcslashes(addslashes($WWW_DIR),'/').'\/([a-z0-9\-]+)\//i', $_SERVER['REQUEST_URI'], $regs)) {
    exit("ERR 2");
}
$template = strtolower($regs[1]);
if (!isset($Templates[$template])) {
    exit("ERR 3 $template");
}
$page = 'connect';
if(preg_match('/^'.addcslashes(addslashes($WWW_DIR),'/').'\/'.$template.'\/([a-z0-9\-]+)/i', $_SERVER['REQUEST_URI'], $regs)) {
    $page = strtolower($regs[1]);
}

switch($Templates[$template]['type']) {
    case 'cambium':
    case 'mikrotik':
        $params = $_GET;
        $params_query = "";
        if (!isset($params['template'])) {
            $params_query = "template=".urlencode($template).'&';
        }
        foreach($params as $k=>$v) {
            $params_query.= $k.'='.urlencode($v).'&';
        } $params_query = substr($params_query, 0, -1);
        break;
    default:
        exit("ERR 5");
}

$W = array();
$W['images'] = $WWW_DIR.$Templates[$template]['images'];
$W['scripts'] = $WWW_DIR.$Templates[$template]['scripts'];
$W['styles'] = $WWW_DIR.$Templates[$template]['styles'];

if (!file_exists(dirname(__FILE__).$Templates[$template]['base'].'/'.$page.'.tpl')) exit('ERR 4');

// Envoi du fichier !
include dirname(__FILE__).$Templates[$template]['base'].'/'.$page.'.tpl';

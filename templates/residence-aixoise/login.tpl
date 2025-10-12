<?php
if (!defined('SPLASH-VD')) exit();

// En cas d'erreur :
// locationTo("connect?".$params_query);

$pass = trim(file_get_contents(__DIR__.'/passwd'));
if (!isset($_POST['vd_code']) || strtolower($_POST['vd_code']) != strtolower($pass)) {
    locationTo("connect?".$params_query."&vd_errcode=1");
}

// Rien à vérifier ici !
mikrotikLogin($params);


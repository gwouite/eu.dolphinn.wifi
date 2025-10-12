<?php
if (!defined('SPLASH-VD')) exit();

// En cas d'erreur :
// locationTo("connect?".$params_query);

if (!isset($_POST['vd_code']) || strtolower($_POST['vd_code']) != "1234") {
    locationTo("connect?".$params_query."&vd_errcode=1");
}

// Rien à vérifier ici !
mikrotikLogin($params);


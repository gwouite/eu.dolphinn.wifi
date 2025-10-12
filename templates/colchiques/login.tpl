<?php
if (!defined('SPLASH-VD')) exit();

// En cas d'erreur :
// locationTo("connect?".$params_query);

if (!isset($_POST['vd_code']) || trim(strtolower($_POST['vd_code'])) != "les colchiques") {
    locationTo("connect?".$params_query."&vd_errcode=1");
}

// Rien à vérifier ici !
mikrotikLogin($params);


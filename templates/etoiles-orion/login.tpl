<?php
if (!defined('SPLASH-VD')) exit();

// En cas d'erreur :
// locationTo("connect?".$params_query);

if (!isset($_POST['CGU']) || strtolower($_POST['CGU']) != "ok") {
    locationTo("connect?".$params_query."&vd_errcgu=1");
}

if (isset($_POST['vd_code']) && strtolower($_POST['vd_code']) == "orion".date('Y')) {
	mikrotikLogin($params);
}
if (isset($_POST['vd_code']) && strtolower($_POST['vd_code']) == "orionboss".date('Y')) {
	mikrotikLogin($params, 'full-access');
}
// Rien à vérifier ici !


locationTo("connect?".$params_query."&vd_errcode=1");

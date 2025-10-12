<?php
if (!defined('SPLASH-VD')) exit();

// En cas d'erreur :
// locationTo("connect?".$params_query);

if (isset($_POST['vd_code']) && strtolower($_POST['vd_code']) == "suez75") {
	mikrotikLogin($params);
}

if (isset($_POST['vd_code']) && strtolower($_POST['vd_code']) == "suez75fast") {
	mikrotikLogin($params, 'fast-user','r3d1n5i9-g3l1n2j6');
}

locationTo("connect?".$params_query."&vd_errcode=1");

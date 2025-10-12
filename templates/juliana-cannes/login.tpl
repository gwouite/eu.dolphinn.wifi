<?php
if (!defined('SPLASH-VD')) exit();

// En cas d'erreur :
// locationTo("connect?".$params_query);
mikrotikLogin($params, 'default-user','r3d2n5i9-g3l1n2j6');
exit();

if (isset($_POST['vd_code']) && strtolower($_POST['vd_code']) == "c@nnes06") {
	mikrotikLogin($params, 'default-user','r3d2n5i9-g3l1n2j6');
}

if (isset($_POST['vd_code']) && strtolower($_POST['vd_code']) == "c@nnes06fast") {
	mikrotikLogin($params, 'fast-user','r3d1n5i9-g3l1n2j6');
}

locationTo("connect?".$params_query."&vd_errcode=1");

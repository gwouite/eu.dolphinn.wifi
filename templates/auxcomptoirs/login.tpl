<?php
if (!defined('SPLASH-VD')) exit();

if (!isset($_POST['vd_code']) || strtolower($_POST['vd_code']) != "comptoirs") {
    locationTo("connect?".$params_query."&vd_errcode=1&vd_email=".trim(strtolower($_POST['vd_email'])));
}

$email = trim(strtolower($_POST['vd_email']));
if ($email != '') {

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		locationTo("connect?".$params_query."&vd_erremail=1&vd_email=".trim(strtolower($_POST['vd_email'])));
	} else {
		$f = fopen(__DIR__.'/emails/'.date('Y-m-d').'.txt','ab');
		if (!$f) {
			error_log("ERR Email");
		} else {
			flock($f, FLOCK_EX);
			fputs($f, $email."\n");
			fclose($f);
		}
	}
}


// Rien à vérifier ici !
mikrotikLogin($params);


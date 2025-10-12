<?php
define("SQL", true);
include dirname(__FILE__).'/lib/lib.php';

$db = Db::singleton();

// Récupère les informations dans le get ! // ugecam-valmante / 859c38d7f979f62404b00a142b87752d
// $site = myGetVar($_GET,'deleg_id');
// $pass = myGetVar($_GET,'deleg_pwd');
// if ($pass != md5($site.'Xsecret')) {
// 	http_response_code(302);
// 	exit("0:UserPass");
// }


if (!isset($_SERVER['REQUEST_URI'])) exit("0:RequestURI1");
if(!preg_match('/^'.addcslashes(addslashes($WWW_DIR),'/').'\/([a-z0-9\-]+)\//i', $_SERVER['REQUEST_URI'], $regs)) {
    exit("0:RequestURI");
}
$site = $regs[1];

$action = myGetVar($_GET,'action');
if ($action != 'adduser' && $action != 'moduser' && $action != 'deluser') {
	exit("0:NoAction");
}

if ($action == 'adduser') {
	$code = myGetVar($_GET,'user_pwd');
}

$old = date_default_timezone_get();
date_default_timezone_set('Europe/Paris');

$start = '0';
$end = '0';
if ($action != 'deluser') {
	$_start = myGetVar($_GET,'user_start');
	if (preg_match('/^([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$/', $_start, $regs)) {
		$start = gmdate("Y-m-d H:i:s",mktime($regs[4],$regs[5],0,$regs[2],$regs[3],$regs[1]));
	} else $start = gmdate("Y-m-d H:i:s");
	$_end = myGetVar($_GET,'user_end');
	if (preg_match('/^([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$/', $_end, $regs)) {
		$end = gmdate("Y-m-d H:i:s",mktime($regs[4],$regs[5],0,$regs[2],$regs[3],$regs[1]));
	} else $end = gmdate("Y-m-d H:i:s", time() + 86400);
}

date_default_timezone_set($old);

$id = myGetVar($_GET,'user_id');

// Récupérer le site_id !
$query = "SELECT id FROM site WHERE nom=".$db->quote($site)."";
	$st = $db->prepare($query);
	if (!$st->execute()) exit("0:DBerr1:".$query);
	$res = $st->fetchAll(Db::FETCH_OBJ);

if (count($res) != 1) exit("0:SiteUnknown");
$site_id = $res[0]->id;

// Si on modifie, vérification de l'action
if ($action == 'moduser') {
	// Vérification de la présence de l'id !
	$query = "select count(*) as count from codes where site_id = '".(int)$site_id."' and id = ".$db->quote($id)."";
		$st = $db->prepare($query);
		if (!$st->execute()) exit("0:DBerr2");
		$res = $st->fetchAll(Db::FETCH_OBJ);

		if (count($res) != 1) exit("0:DBerr3");
		if ($res[0]->count != 1) exit("0:NoUser");
	
	// Mise à jour 
	$query = "UPDATE codes SET `start`=".$db->quote($start).", `end`=".$db->quote($end)." where site_id = '".(int)$site_id."' and id = ".$db->quote($id)."";
	$st = $db->prepare($query);
	if (!$st->execute()) exit("0:DBerr4");

} else
if ($action == 'adduser') {
	// Supprime d'abord le(s) ID avec le même ID !
	$query = "DELETE from codes where site_id = '".(int)$site_id."' and id = ".$db->quote($id)."";
		$st = $db->prepare($query);
		if (!$st->execute()) exit("0:DBerr5");

	// Insertion 
	$query = "INSERT INTO codes (site_id, id, `start`, `end`, code) VALUES ( '".(int)$site_id."', ".$db->quote($id).", ".$db->quote($start).", ".$db->quote($end).", ".$db->quote($code).")";
		$st = $db->prepare($query);
		if (!$st->execute()) exit("0:DBerr6");
} else
if ($action == 'deluser') {
	// Supprime d'abord le(s) ID avec le même ID !
	$query = "DELETE from codes where site_id = '".(int)$site_id."' and id = ".$db->quote($id)."";
		$st = $db->prepare($query);
		if (!$st->execute()) exit("0:DBerr5");

} else {
	exit("0:Erreur Impossible");
}


exit('0:OK');
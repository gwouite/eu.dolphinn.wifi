<?php
if (!defined('SPLASH-VD')) exit();

// SITE_ID = 3
$site_id = 3;  // SITE ID dans la base WIFI
$max_users = 2;  // Nombre maximum d'utilisateur connecté en même temps
$duration = 300;  // Durée de 5 minutes ( défaut, modifié un peu plus loin )
$limit = gmdate('Y-m-d', time()+$duration).'T'.gmdate('H:i:s', time()+$duration).'+00:00';

$db = Db::singleton();

$now = gmdate("Y-m-d H:i:s");

// Vérification du login !
$query = "SELECT * FROM codes WHERE site_id = $site_id AND code = ".$db->quote($_POST['vd_code'])." AND `start` < ".$db->quote($now)." AND `end` > ".$db->quote($now);
	$st = $db->prepare($query);
	if (!$st->execute()) locationTo("connect?".$params_query."&vd_errcode=1&errrrr=2");
	$res = $st->fetchAll(Db::FETCH_OBJ);

	if (count($res) != 1) {
		locationTo("connect?".$params_query."&vd_errcode=1&errrrr=3");
	}

// Connexion à la base RADIUS
$user = 'MAXCOTEx'.$site_id.'x'.$res[0]->id;
$pass = md5($site_id.'x'.$res[0]->id."xSecret");

$end = $res[0]->end;
if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/', $end, $regs)) {
	$limit = $regs[1].'-'.$regs[2].'-'.$regs[3].'T'.$regs[4].':'.$regs[5].':'.$regs[6].'+00:00';
	$duration = gmmktime($regs[4],$regs[5],$regs[6],$regs[2],$regs[3],$regs[1]) - time();
}

$dbRadius = new Db($DB_RADIUS['host'], $DB_RADIUS['port'], $DB_RADIUS['user'], $DB_RADIUS['pass'], $DB_RADIUS['db']);

$query = "DELETE FROM radcheck WHERE username = ".$dbRadius->quote($user);	
	$st = $dbRadius->prepare($query);
	if (!$st->execute()) locationTo("connect?".$params_query."&vd_errcode=1&errrrr=4");

$query = "DELETE FROM radreply WHERE username = ".$dbRadius->quote($user);
	$st = $dbRadius->prepare($query);
	if (!$st->execute()) locationTo("connect?".$params_query."&vd_errcode=1&errrrr=5");

$query = "INSERT INTO radreply (username, attribute, op, `value`) VALUES (".$dbRadius->quote($user).",'Mikrotik-Rate-Limit',':=','5120k')";
	$st = $dbRadius->prepare($query);
	if (!$st->execute()) locationTo("connect?".$params_query."&vd_errcode=1&errrrr=6");
// $query = "INSERT INTO radreply (username, attribute, op, `value`) VALUES (".$dbRadius->quote($user).",'Session-Timeout',':=','".$duration."')";
$query = "INSERT INTO radreply (username, attribute, op, `value`) VALUES (".$dbRadius->quote($user).",'WISPr-Session-Terminate-Time',':=','".$limit."')";
	$st = $dbRadius->prepare($query);
	if (!$st->execute()) locationTo("connect?".$params_query."&vd_errcode=1&errrrr=7");
$query = "INSERT INTO radreply (username, attribute, op, `value`) VALUES (".$dbRadius->quote($user).",'Port-Limit',':=','".$max_users."')";
	$st = $dbRadius->prepare($query);
	if (!$st->execute()) locationTo("connect?".$params_query."&vd_errcode=1&errrrr=8");
$query = "INSERT INTO radcheck (username, attribute, op, `value`) VALUES (".$dbRadius->quote($user).",'Cleartext-Password',':=',".$dbRadius->quote($pass).")";
	$st = $dbRadius->prepare($query);
	if (!$st->execute()) locationTo("connect?".$params_query."&vd_errcode=1&errrrr=9");

// Rien à vérifier ici !
mikrotikLogin($params, $user, $pass);


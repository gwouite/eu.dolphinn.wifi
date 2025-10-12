<?php
define("SQL", true);
include dirname(__FILE__).'/lib/lib.php';
if(!preg_match('/stats\/([a-z0-9\-]+)\/(.*)\?/i', $_SERVER['REQUEST_URI'], $regs)) {
	error_log("Requête non prise en compte : ".$_SERVER['REQUEST_URI']);
    exit("ERR 1");
}

$site = $regs[1];
$type = $regs[2];

$db = Db::singleton();

$query = "SELECT * FROM `site` WHERE nom = ".$db->quote($site);
$st = $db->prepare($query);

if (!$st->execute()) exit("ERR 2");
$res = $st->fetchAll(Db::FETCH_OBJ);

if (count($res) != 1) exit("ERR 3");

$id = $res[0]->id;
$expiration = $res[0]->expiration;

if ($type == 'begin') {
	// On ajoute dans "instant"

	$clientId = trim($_GET['mac']);
	if (strlen($clientId) < 3) exit("ERR 4");
	$dteExpiration = gmdate("Y-m-d H:i:s", time()+(60*$expiration));
	$query = "INSERT INTO instant (site_id, client_id, expiration) VALUES (".$db->quote($id).",".$db->quote($clientId).",".$db->quote($dteExpiration).")";
	$st = $db->prepare($query);
	if (!$st->execute()) exit("ERR 5");

} else 
if ($type == 'end') {
	// On supprime de "instant"
	// On loggue la connexion
	
	$clientId = trim($_GET['mac']);
	if (strlen($clientId) < 3) exit("ERR 4");

	$query = "DELETE FROM instant WHERE (site_id = ".$db->quote($id)." AND client_id = ".$db->quote($clientId).") OR expiration < '".gmdate("Y-m-d H:i:s")."'";
	$st = $db->prepare($query);
	if (!$st->execute()) exit("ERR 5");

	$time = (int) $_GET['time'];
	if ($time <= 0) exit("ERR 6");
	
	$dteBegin = gmdate("Y-m-d H:i:s", time() - $time);
	$dteEnd = gmdate("Y-m-d H:i:s");

	$bytes_in = (int)($_GET['bytes-in']/1024);
	$bytes_out = (int)($_GET['bytes-out']/1024);

	$query = "INSERT INTO stats (site_id, client_id, dte_begin, dte_end, duration, bytes_in, bytes_out) VALUES (
			".$db->quote($id).",
			".$db->quote($clientId).",
			".$db->quote($dteBegin).",
			".$db->quote($dteEnd).",
			".$db->quote($time).",
			".$db->quote($bytes_in).",
			".$db->quote($bytes_out)."
			)";
	$st = $db->prepare($query);
	if (!$st->execute()) exit("ERR 7");
}

exit("OK");
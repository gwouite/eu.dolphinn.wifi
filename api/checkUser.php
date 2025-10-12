<?php
define("SQL", true);
include dirname(__FILE__).'/../lib/lib.php';

$user = trim($_GET['user']);
if (!preg_match('/^API/', $user)) {
	exit("ERR");
}

try {

	
	$db = Db::singleton();
	$query = "SELECT * from api_sessions where username = ".$db->quote($user)." AND dteEnd IS NULL";
	$st = $db->prepare($query);
	if (!$st->execute()) {
		exit("ERR 2");
	}

	$res = $st->fetchAll(Db::FETCH_OBJ);
	if (count($res) > 0) exit("OK");
	exit("END");



} catch(Exception $e) {
	exit("Exception = ".print_r($e, true));
}


<?php
define("SQL", true);
include dirname(__FILE__).'/lib/lib.php';

date_default_timezone_set("Europe/Paris");

if (!isset($_SERVER['HTTPS'])) {
	header("Location: https://".$_SERVER['HTTP_HOST'].$WWW_DIR.'/');
	exit();
}


$db = Db::singleton();


// Récupère le user saisi :
$pass = "NO PASS";
$user = "NO PASS";
if (isset($_SERVER['PHP_AUTH_PW'])) {
	$pass = $_SERVER['PHP_AUTH_PW'];
	$user = $_SERVER['PHP_AUTH_USER'];
}

$id = 0;
$nom = '';
try {
	$query = "SELECT * FROM `site` WHERE nom = ".$db->quote($user)." AND pass = ".$db->quote($pass);
	$st = $db->prepare($query);

	if (!$st->execute()) throw new Exception("ERR 2");
	$res = $st->fetchAll(Db::FETCH_OBJ);

	if (count($res) != 1) throw new Exception("ERR 3");

	$id = $res[0]->id;
	$nom = $res[0]->nom_aff;

} catch (Exception $e) {
	header('WWW-Authenticate: Basic realm="ConnectVD"');
    header('HTTP/1.0 401 Unauthorized');
    exit('Autorisation requise');
}

// Ici on est OK ! Affichons les stats !

// Récupère le nombre de connectés à l'instant T.

$query = "SELECT count(*) as instant FROM instant WHERE expiration > ".$db->quote(gmdate("Y-m-d H:i:s"))." AND site_id = ".$db->quote($id);

$st = $db->prepare($query);

if (!$st->execute()) throw new Exception("ERR 2");
$res = $st->fetchAll(Db::FETCH_OBJ);

if (count($res) != 1) throw new Exception("ERR 3");
$instant = $res[0]->instant;

// echo "Connexions live : ".$instant."<br /><br />\nStats : \n";

$fromDte = min(date("Y-m-d", time() - 86400*7), date("Y-m-d", time()));
if (isset($_GET['fromDte']) && preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $_GET['fromDte'], $regs)) {
	$_fromDte = $_GET['fromDte'];
	if ($_fromDte >= date("Y-m-d", time() - 86400*300) && $_fromDte <= date("Y-m-d", time())) {
		$fromDte = $_fromDte;
	}
}

$from_ts = 0;
if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $fromDte, $regs)) {
	$from_ts = mktime(0,0,0,$regs[2], $regs[3], $regs[1]);
} else {
	die("Impossible !! ".$fromDte);
}

$toDte = min(date("Y-m-d", $from_ts + 86400*8+100), date("Y-m-d", time() + 86400+100));
if (isset($_GET['toDte']) && preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $_GET['toDte'], $regs)) {
	$_toDte = $_GET['toDte'];
	if ($_toDte > $fromDte && $_toDte <= date("Y-m-d", time() + 86400+100)) {
		$toDte = $_toDte;
	}
}
$to_ts = 0;
if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $toDte, $regs)) {
	$to_ts = mktime(0,0,0,$regs[2], $regs[3], $regs[1]);
} else {
	die("Impossible !! ".$fromDte);
}

$to_ts = min($to_ts, time());


$from = date("Y-m-d H:i:s", $from_ts); 

$from_dte = gmdate("Y-m-d H:i:s", $from_ts);
$to_dte = gmdate("Y-m-d H:i:s", $to_ts);

$step = 3600;
if (($to_ts - $from_ts) > 86400*120) {
	$step = 86400*7;
} else 
if (($to_ts - $from_ts) > 86400*30) {
	$step = 86400;
} else 
if (($to_ts - $from_ts) > 86400*15) {
	$step = 86400/2;
}

// echo($from_ts.' / '.$to_ts.'<br />\n');

// Récupère les données pour les stats
$query = "SELECT UNIX_TIMESTAMP(dte_begin) as dte_begin, UNIX_TIMESTAMP(dte_end) as dte_end, bytes_in/duration as bytes_in, bytes_out/duration as bytes_out FROM stats WHERE site_id = ".$db->quote($id)." AND dte_begin <= '".$to_dte."' AND dte_end >= '".$from_dte."' ORDER BY dte_begin asc";
// echo $query;
$st = $db->prepare($query);

if (!$st->execute()) throw new Exception("ERR 4");
$res = $st->fetchAll(Db::FETCH_OBJ);

$datas = array();
$count = 0;
for ($current = $from_ts; $current < $to_ts; $current+=$step) {
	$data = new stdClass;
	$data->count = 0;
	$data->bytes_in = 0;
	$data->bytes_out = 0;
	// if ($count++ > 5000) break;
	// echo count($res)."<br />\n";
	foreach($res as $k=>$v) {
		if ($v->dte_begin >= $current+$step) break;
		if ($v->dte_end <= $current) {
			unset($res[$k]);
			continue;
		}

		$begin = max($current, $v->dte_begin);
		$end = min($current+$step, $v->dte_end);

		$duration = $end - $begin;
		$data->bytes_in+= $duration * $v->bytes_in;
		$data->bytes_out+= $duration * $v->bytes_out;
		$data->count+= 1;
	}

	$datas[date("Y-m-d H:i:s", $current)] = $data;
}

// echo date("Y-m-d H:i:s", $current);
// echo date("Y-m-d H:i:s", $to_ts);

$jsDatas = array();
$jsSessions = array();

$max = 0;
foreach($datas as $dte=>$stat) {
	$affDte = $dte;
	if (preg_match('/([0-9]+)-([0-9]+)-([0-9]+) ([0-9]+):([0-9]+):([0-9]+)/', $dte, $regs)) {
		$affDte = $regs[3].'/'.$regs[2].' '.$regs[4].'h';
	}
	$data = array();
	$data[] = $affDte;
	$data[] = (int)($stat->bytes_in);
	$data[] = (int)($stat->bytes_out);

	$max = max($max, $data[2]);
	$max = max($max, $data[1]);
	$jsDatas[] = $data;
	$data = array();
	$data[] = $affDte;
	$data[] = (int)$stat->count;
	$jsSessions[] = $data;
}

$multiplicateur = 1;
$index = 'Ko';
if ($max > 1024*1024) {
	$multiplicateur = 1024*1024;
	$index = 'Go';
} else
if ($max > 1024) {
	$multiplicateur = 1024;
	$index = 'Mo';
}
if ($multiplicateur > 1) {
	foreach ($jsDatas as $k=>$v) {
		$jsDatas[$k][1] = $v[1] / $multiplicateur;
		$jsDatas[$k][2] = $v[2] / $multiplicateur;
	}
}


$json = json_encode($jsDatas);
$jsonSessions = json_encode($jsSessions);

/*
foreach($res as $stat) {
	echo $stat->dte_begin." / ".$stat->bytes_out." / ".$stat->bytes_in."<br />\n";
}
*/

// echo "<pre>";
// print_r($datas);

include __DIR__.'/templates/admin/index.tpl';

exit();

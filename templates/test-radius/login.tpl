<?php
if (!defined('SPLASH-VD')) exit();

// En cas d'erreur :
// locationTo("connect?".$params_query);

if (!isset($_POST['type'])) {
    locationTo("connect?".$params_query);
}


$datas = new stdClass();
$datas->session = md5($_POST['type']).'_'.trim($_POST['type']);
$datas->limits = new stdClass();
$datas->limits->tx = 1024;
$datas->limits->rx = 1024;
$datas->limits->devices = 30;
$datas->ackStatsSession = 'https://connect.victoria-digital.com/collectStats.php';
$datas->limits->type = 'limited';
$datas->validUntil = gmdate("Y-m-d H:i:s", time() + 86400); // 1jour
switch($_POST['type']) {
	case 'free':
		// Default, OK !
		break;
	case 'plus':
		$datas->limits->tx = 1024*15;
		$datas->limits->rx = 1024*5;
		$datas->validUntil = gmdate("Y-m-d H:i:s", time() + 86400/2); // 12 h
		$datas->limits->type = 'nolimit';
		break;
	case 'super':
		$datas->limits->tx = 1024*100;
		$datas->limits->rx = 1024*100;
		$datas->validUntil = gmdate("Y-m-d H:i:s", time() + 1200); // 20 minutes
		$datas->limits->type = 'nolimit';
		break;
	default:
    	locationTo("connect?".$params_query);
		break;
		
}



function executeAPI($data, $authToken = false) {
	$url = "https://connect.victoria-digital.com/api/ws.php";

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
	$headers = array(
		"Cache-Control: no-cache",
		"Content-Type: application/json;charset=utf-8"
	);
	if ($authToken !== false) {
		$headers[] = "Auth-Token: ".$authToken;
	}

	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$ret = curl_exec($curl);

	$_ret = json_decode($ret);
	if ($_ret->status != 'OK') {
		throw new Exception($_ret->reason);
	}
	
	return $_ret->datas;
}

$data = new stdClass();
$data->action = 'TokenRequest';
$data->datas = new stdClass();
$data->datas->user = "admin";
$data->datas->pass = "Victori@28";

$token = executeAPI($data);

try {

	if (isset($_POST['decoFirst']) && $_POST['decoFirst'] == '1') {
		$data = new stdClass();
		$data->action = 'AccessStop';
		$data->datas = new stdClass();
		$data->datas->session = $datas->session;
		// $data->datas->all = true;

		// ACCESS STOP !

		$result = executeAPI($data, $token);
		error_log(print_r($data,true).$result);
	}

	$data = new stdClass();
	$data->action = 'AccessCreate';
	$data->datas = $datas;

	$logins = executeAPI($data, $token);

} catch(Exception $e) {
	locationTo("connect?".$params_query.'&type='.$_POST['type'].'&err='.$e->getMessage());
}

// Rien à vérifier ici !
mikrotikLogin($params, $logins->username, $logins->password);


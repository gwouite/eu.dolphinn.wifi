<?php


// $ar = array();

// $ar[] = "txt1";
// $ar[] = "txt2";
// $ar[] = "txt3";
// $ar[] = "txt4";
// $ar[] = "txt5";
// $ar[] = "txt6";


// $_ar = array();

// foreach($ar as $k=>$v) {
// 	$_ar[] = $v;
// 	if ($k == 3) unset($ar[$k]);
// }

// print_r($ar);
// print_r($_ar);


$authToken = "";


function execute($data, $authToken = false) {
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

$return = execute($data);

print_r($return);
echo "\n";

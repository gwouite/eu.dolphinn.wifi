<?php
define('SPLASH-VD', "1");
spl_autoload_register(function (string $class): void {
    // Si tu n'utilises pas de namespaces, on garde le nom tel quel.
    // Sinon, adapte ci-dessous (voir commentaire plus bas).
    $dirs = [
        __DIR__ . '/utils',
        __DIR__ . '/controller',
    ];

    foreach ($dirs as $dir) {
        $file = $dir . '/class.' . $class . '.php';
        if (is_file($file) && is_readable($file)) {
            require_once $file;
            return;
        }
    }

    throw new RuntimeException('Classe ' . $class . ' inexistante');
});



require dirname(__FILE__).'/config.php';

$token = JWT::singleton(TOKEN_KEY);

if (defined("SQL")) {
	$db = Db::singleton($DB['host'],$DB['port'],$DB['user'],$DB['pass'],$DB['db']);	
	
	$query = "SET time_zone = '+00:00'";
	$st = $db->prepare($query);
	$st->execute();
}


function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

if (!function_exists('getallheaders'))
{
    function getallheaders()
    {
    	$headers = [];
       foreach ($_SERVER as $name => $value)
       {
           if (substr($name, 0, 5) == 'HTTP_')
           {
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
           }
       }
       return $headers;
    }
}

function locationTo ($url) {
    header("Location: ".$url);
    exit();
}

function myGetVar($arr, $key) {
	if (!is_array($arr)) return null;
	if (!isset($arr[$key])) return null;
	return $arr[$key];
}

function loginPassFromSessionID($session_id, $prefix) {
	$ret = new stdClass();
	$ret->username = $prefix.md5(TOKEN_KEY.$session_id);
	$ret->password = substr(md5($prefix.TOKEN_KEY.$session_id), 0, 6);

	return $ret;
}

function cambiumLogin($params) {
    if (!is_array($params) || !isset($params['ga_srvr'])) exit("Erreur de paramètres!");

    $_params = "";
    foreach($params as $k=>$v) {
        $_params.= $k.'='.urlencode($v).'&';
    } $_params = substr($_params, 0, -1);

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Redirection...</title>
    <script>
        function launchForm() {
            document.getElementById('frmCambium').submit();
        }
    </script>
</head>
<body onload="launchForm()">
    <form action="http://<?php echo $params['ga_srvr']; ?>:880/cgi-bin/hotspot_login.cgi?<?php echo $_params; ?>" method="post" id="frmCambium">
        <input type="submit" value="Redirection..." />
    </form>
</body>
</html>
<?php

    exit();
}

function cambiumLogout($params) {
    if (!is_array($params) || !isset($params['ga_srvr'])) exit("Erreur de paramètres!");

    $_params = "";
    foreach($params as $k=>$v) {
        $_params.= $k.'='.urlencode($v).'&';
    } $_params = substr($_params, 0, -1);

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Redirection...</title>
    <script>
        function launchForm() {
            document.getElementById('frmCambium').submit();
        }
    </script>
</head>
<body onload="launchForm()">
    <form action="http://<?php echo $params['ga_srvr']; ?>:880/cgi-bin/hotspot_logout.cgi?<?php echo $_params; ?>" method="post" id="frmCambium">
        <input type="submit" value="Redirection..." />
    </form>
</body>
</html>
<?php

    exit();
}


function mikrotikLogin ($params, $user = 'default-limit', $pass = 'r3d1n5i9-g3l1n2j5') {
	global $Dispatcher_suffix;
    if (!is_array($params) || !isset($params['link-login-only'])) exit("Erreur de paramètres 3!");

    $_params = "";
    foreach($params as $k=>$v) {
        $_params.= $k.'='.urlencode($v).'&';
    } $_params = substr($_params, 0, -1);

	$Dispatcher_redir = '';

	foreach($Dispatcher_suffix as $suff=>$dest) {
		if(preg_match('/([a-z0-9\-]+)'.$suff.'/i', $_REQUEST['link-login-only'], $regs)) {
			$Dispatcher_redir = $dest;
			break;
		}
	}

    $mac=$params['mac'];
    $ip=$params['ip'];
    $username=$params['username'];
    $linklogin=$params['link-login'];
    $linkorig=$params['link-orig'];
    $error=$params['error'];
    $chapid=$params['chap-id'];
    $chapchallenge=$params['chap-challenge'];
    $linkloginonly=$params['link-login-only'];
    $linkorigesc=$params['link-orig-esc'];
    $macesc=$params['mac-esc'];
 ?><!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Redirection...</title>
        
	    <script type="text/javascript" src="/md5.js"></script>
        <script>
            function launchForm() {
               document.getElementById('frmMikrotik').submit();
            }
        </script>
    </head>
    <body onload="launchForm()">
        <form name="sendin" action="<?php echo $linkloginonly; ?>" method="post" id="frmMikrotik">
            <input type="hidden" name="username" value="<?php echo $user; ?>" />
            <input type="hidden" name="password" value="<?php echo $pass; ?>" />
            <input type="hidden" name="dst" value="<?php echo $Dispatcher_redir.$params['template'].'/success'; ?>" />
            <input type="hidden" name="popup" value="true" />
            <input type="submit" value="Redirection..." />
        </form>
    </body>
</html>
<?php

    exit();

}




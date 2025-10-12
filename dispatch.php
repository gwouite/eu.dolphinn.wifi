<?php
include dirname(__FILE__).'/lib/lib.php';

// print_r($_REQUEST);
// echo $Dispatcher_suffix."<br />\n";
// echo $_REQUEST['link-login-only']."<br />\n";
// echo '/([a-z0-9\-]+)'.$Dispatcher_suffix.'/i'."<br />\n";

$base = 'default';
$Dispatcher_redir = '';

foreach($Dispatcher_suffix as $suff=>$dest) {
	if(preg_match('/([a-z0-9\-]+)'.$suff.'/i', $_REQUEST['link-login-only'], $regs)) {
		$base = $regs[1];
		$Dispatcher_redir = $dest;
		break;
	}
}

// echo $base."<br />\n";

if (!isset($Dispatcher[$base])) {
    $base = 'default';
}
// echo $base."<br />\n";

$params_query = "";
foreach($_REQUEST as $k=>$v) {
    $params_query.= $k.'='.urlencode($v).'&';
} $params_query = substr($params_query, 0, -1);

// echo "Redir "."Location: ".$Dispatcher_redir.$Dispatcher[$base].'/?'.$params_query;
header("Location: ".$Dispatcher_redir.$Dispatcher[$base].'/?'.$params_query);

exit();




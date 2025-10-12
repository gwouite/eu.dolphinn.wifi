<?php
if (!defined('SPLASH-VD')) exit();



$WWW_DIR = '';
if (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] == 'localhost' || substr($_SERVER['HTTP_HOST'], 0,7) == '192.168')) {
    $WWW_DIR = '/splash';
}

$Templates = array();

$Templates['default'] = array();
$Templates['default']['type'] = 'mikrotik';
$Templates['default']['base'] = '/templates/default';
$Templates['default']['images'] = '/templates/default/img';
$Templates['default']['styles'] = '/templates/default/css';
$Templates['default']['scripts'] = '/templates/default/js';

$Templates['juliana-cannes'] = array();
$Templates['juliana-cannes']['type'] = 'mikrotik';
$Templates['juliana-cannes']['base'] = '/templates/juliana-cannes';
$Templates['juliana-cannes']['images'] = '/templates/juliana-cannes/img';
$Templates['juliana-cannes']['styles'] = '/templates/juliana-cannes/css';
$Templates['juliana-cannes']['scripts'] = '/templates/juliana-cannes/js';

$Templates['saga-vh'] = array();
$Templates['saga-vh']['type'] = 'mikrotik';
$Templates['saga-vh']['base'] = '/templates/saga-vh';
$Templates['saga-vh']['images'] = '/templates/saga-vh/img';
$Templates['saga-vh']['styles'] = '/templates/saga-vh/css';
$Templates['saga-vh']['scripts'] = '/templates/saga-vh/js';

$Templates['test-radius'] = array();
$Templates['test-radius']['type'] = 'mikrotik';
$Templates['test-radius']['base'] = '/templates/test-radius';
$Templates['test-radius']['images'] = '/templates/test-radius/img';
$Templates['test-radius']['styles'] = '/templates/test-radius/css';
$Templates['test-radius']['scripts'] = '/templates/test-radius/js';


$Dispatcher = array();
$Dispatcher['default']			= 'default';
$Dispatcher['juliana-cannes']	= 'juliana-cannes';
$Dispatcher['vhparis']	= 'saga-vh';
$Dispatcher['5ea58d28-78c3-447e-9acb-97b7bed76c2a']				= 'test-radius';

$Dispatcher_suffix = array();
$Dispatcher_suffix['\.wifi\.informatek\.in'] = 'https://juliana-cannes.wifi.informatek.fr/';
$Dispatcher_suffix['\.wifi\.local\.dolphinn\.eu'] = 'https://wifi.dolphinn.eu/';


define('TOKEN_KEY','SplashVDHumelabVMP');

$DB = array();
$DB['host'] = 'localhost';
$DB['port'] = '3306';
$DB['user'] = 'wifi';
$DB['pass'] = 'wilfi';
$DB['db'] = 'wifi';

$DB_RADIUS = array();
$DB_RADIUS['host'] = 'localhost';
$DB_RADIUS['port'] = '3306';
$DB_RADIUS['user'] = 'radius';
$DB_RADIUS['pass'] = 'radius';
$DB_RADIUS['db'] = 'radius';

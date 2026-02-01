<?php
define('SITE_NAME', 'Booking System');
define('DEFAULT_LANGUAGE', 'en');

if (!isset($config)) {
    $config = [];
}
//haircuts, raffles, cinema
$config['sitestyle'] = 'haircuts';
if($config['sitestyle'] == 'haircuts'){
    $config['jobroles'] = array('barber', 'hairdresser', 'owner', 'receptionist');
} else {
    $config['jobroles'] = array('staff', 'administrator', 'superuser');
}
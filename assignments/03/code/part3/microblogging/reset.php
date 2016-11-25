<?php

system('python ./provision/provision.py');

$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$redirect = $protocol . $_SERVER['HTTP_HOST'] . "/";
header('HTTP/1.1 301 Moved Permanently');
header('Location: ' . $redirect);

?>


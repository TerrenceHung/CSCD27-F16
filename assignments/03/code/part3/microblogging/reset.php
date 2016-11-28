<?php

system('python ./provision/provision.py');

$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$redirect = $protocol . $_SERVER['HTTP_HOST'] . "/";
header('HTTP/1.1 301 Moved Permanently');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Location: ' . $redirect);

?>


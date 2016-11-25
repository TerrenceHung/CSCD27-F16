<?php

system('mysql -u root -ppass4root -t -vvv < ./init/init.sql');

$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$redirect = $protocol . $_SERVER['HTTP_HOST'] . "/";
header('HTTP/1.1 301 Moved Permanently');
header('Location: ' . $redirect);

?>


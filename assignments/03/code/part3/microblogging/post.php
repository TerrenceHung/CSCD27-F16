<?php
session_start();
$email = $_SESSION['user']['email'];

$msg = trim((string)$_GET['msg']);

$db = new mysqli("localhost","root","pass4root","microblogging");
if ($db->connect_error) {
  trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
}

$query = "INSERT INTO posts(msg, owner) SELECT '$msg', email FROM users WHERE email = '$email' LIMIT 1";
$res = $db->query($query);

$db->close();
header("location:/");
?>

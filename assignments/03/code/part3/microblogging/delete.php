<?php
session_start();

$id = (int)$_GET['id'];
$email = $_SESSION['user']['email'];

$db = new mysqli("localhost","root","pass4root","microblogging");
if ($db->connect_error) {
  trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
}

$query = "DELETE FROM posts WHERE id = '$id'";
//$query = "DELETE FROM posts WHERE id = '$id' and owner='$email'";
$res = $db->query($query);

$db->close();
header("location:/");
?>

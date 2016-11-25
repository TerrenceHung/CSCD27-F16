<?php

$db = new mysqli("localhost","root","pass4root","microblogging");
if ($db->connect_error) {
  trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
}

$name =      (string)$_POST['name'];
$email =     (string)$_POST['email'];
$password =  (string)$_POST['password'];
$hash = password_hash($password, PASSWORD_DEFAULT);

$query = "SELECT * FROM users WHERE email = '$email'";
$res = $db->query($query);

if (($res->num_rows)==1) {
    header("location:/?error=existing-credential");
} else {
    $query = "INSERT INTO users (email, name, password) VALUES ('$email', '$name', '$hash')";
    $res = $db->query($query);
    $url = "/media/default/no-image-icon-th.png";
    $query = "INSERT INTO profiles(url, owner) VALUES ('$url','$email')";
    $res = $db->query($query);
    header("location:/?success=signup-complete");
}
$db->close();
?>
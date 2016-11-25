<?php
$db = new mysqli("localhost","root","pass4root","microblogging");
if ($db->connect_error) {
  trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
}

$email =     (string)$_POST['email'];
$password =  (string)$_POST['password'];

$query = "SELECT * FROM users WHERE email = '$email'";
$res = $db->query($query);

if (($res->num_rows)==1){
    $res->data_seek(0);
    while($row = $res->fetch_assoc()){
        $email =  $row['email'];
        $name =  $row['name'];
        $hash = $row['password'];
    }
    if (password_verify($password, $hash)) {
       session_start();
       $_SESSION['user']['email'] = $email;
       $_SESSION['user']['name'] = $name;
       header("location:/");
    }
    else {
        header("location:/?error=wrong-password");
    }
} else{
    header("location:/?error=inexisting-credential");
}
$db->close();
?>

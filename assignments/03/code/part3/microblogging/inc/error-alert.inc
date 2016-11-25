<?php switch($_GET['error']): ?>
<?php case "wrong-password": ?>
<div id="error-container">
    <div class="alert alert-danger">wrong password</div>
</div>
<?php break;?>
<?php case "inexisting-credential": ?>
<div id="error-container">
    <div class="alert alert-danger">invalid email</div>
</div>
<?php break;?>
<?php case "existing-credential": ?>
<div id="error-container">
    <div class="alert alert-danger">email already used</div>
</div>
<?php break;?>
<?php case "invalid-input": ?>
<div id="error-container">
    <div class="alert alert-danger">invalid input</div>
</div>
<?php break;?>
<?php endswitch;?>
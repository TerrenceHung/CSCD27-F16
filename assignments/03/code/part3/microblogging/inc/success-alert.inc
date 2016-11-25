<?php switch($_GET['success']): ?>
<?php case "signup-complete": ?>
<div id="error-container">
    <div class="alert alert-success">account created</div>
</div>
<?php break;?>
<?php endswitch;?>
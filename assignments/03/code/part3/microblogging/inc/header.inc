<!DOCTYPE html>
<html lang="en">
  <?php include('inc/menu.inc'); ?>
  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Microblogging</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav navbar-right">
<?php
session_start();
if(!isset ($_SESSION['user'])) include("inc/signin-form.inc");
else{
    $email = $_SESSION['user']['email'];
    include("inc/profile-button.inc");
}
?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

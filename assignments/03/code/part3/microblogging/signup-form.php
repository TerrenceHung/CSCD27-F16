<?php
session_start();
?>
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
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

         <div id="signup-container">
             <form class="form-horizontal" role="form" action='signup.php' method='post'>
               <div class="form-group">
                 <label for="name" class="col-sm-2 control-label">Full name</label>
                 <div class="col-sm-10">
                   <input type="text" class="form-control" id="name" placeholder="Full Name" name="name">
                 </div>
               </div>
               <div class="form-group">
                 <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                 <div class="col-sm-10">
                   <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email">
                 </div>
               </div>
               <div class="form-group">
                 <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                 <div class="col-sm-10">
                   <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
                 </div>
               </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                  </div>
                </div>
             </form>
         </div>

    </div> <!-- /container -->

    <?php include('inc/footer.inc'); ?>
  </body>
</html>
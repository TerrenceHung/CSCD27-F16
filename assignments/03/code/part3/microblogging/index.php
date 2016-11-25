<?php
include("inc/header.inc");
?>

<div class="container">

<?php
if(isset ($_GET['error'])) include("inc/error-alert.inc");
if(isset ($_GET['success'])) include("inc/success-alert.inc");
if(isset ($_SESSION['user'])) include("inc/post-form.inc");
if(isset ($_GET['filter'])) $filter = trim((string)$_GET['filter']); else $filter="";
?>

     <div id="post-container">
         <h1> Posts</h1>
         <div id="filter-container" class="form-group">
                 <span class="glyphicon glyphicon-search"></span>
                 <input id="filter-input" type="text" class="form-control filter-query" placeholder="Filter..." VALUE="<?php echo $filter;?>"/>
             </div>
            <div id ="filter-info">
                <?php
                    if($filter==""){
                        echo "Showing <span>all</span> recent posts";
                    }else{
                        echo "Showing recent posts that contains <span>$filter</span>";
                    }
                    ?>
            </div>
            <div id="posts">
                <?php
                $db = new mysqli("localhost","root","pass4root","microblogging");
                if ($db->connect_error) {
                  trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
                }

                $query = "SELECT posts.id, posts.msg, users.email, users.name, profiles.url FROM users INNER JOIN posts ON posts.owner = users.email INNER JOIN profiles ON profiles.owner = users.email WHERE posts.msg LIKE '%{$filter}%' OR users.name LIKE '%{$filter}%' ORDER BY posts.id DESC LIMIT 20";
                $res = $db->query($query);

                $res->data_seek(0);
                while($row = $res->fetch_assoc()){
                ?>

                <div class="post" id="<?php echo $row['id'];?>">
                    <div class="post-header row">
                        <div class="post-header-icon col-md-1"><img src="<?php echo $row['url'];?>" alt="Thierry Sans"></div>
                        <div class="post-header-profile col-md-6"><span class="profile-name"><?php echo $row['name'];?></span><span class="profile-id"><?php echo $row['email'];?></span></div>
                        <?php
                        if(isset ($email) && $email==$row['email']){
                        ?>
                        <span class="post-header-delete col-md-offset-11 col-md-1 glyphicon glyphicon-remove"></span>
                        <?php }?>
                    </div>
                     <div class="post-content row">
                         <div class="post-content-text col-md-offset-1 col-md-11"><?php echo $row['msg'];?></div>
                     </div>
                </div>
                <?php
                    }
                ?>
            </div>
     </div>
    </div> <!-- /container -->

  <?php include('inc/footer.inc'); ?>
  <script src="js/index.js"></script>
  </body>
</html>

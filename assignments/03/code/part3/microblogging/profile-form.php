<?php
include("inc/header.inc");
?>

<div class="container">

    <div id="profile-container">
    <form role="form" action='profile.php' method='post' enctype="multipart/form-data">
    <div class="form-group">
    <label for="image-type" class="col-sm-12 control-label">Profile picture</label>
    <div class="col-sm-12">
      <div class="radio">
        <label>
          <input type="radio" name="optionsimagetype" id="optionurl" value="url" checked>
         <div class="form-group">
             <label class="col-sm-2" for="inputurl">Url</label>
             <input class="col-sm-8" type="url" class="form-control" id="inputurl" placeholder="Url" name="url"/>
          </div>
        </label>
      </div>
    </div>
    <div class="col-sm-12">
     <div class="radio">
       <label>
         <input type="radio" name="optionsimagetype" id="optionfile" value="file">
         <div class="form-group">
             <label class="col-sm-2" for="inputfile">File</label>
             <input class="col-sm-8" type="file" id="inputfile" name="upfile"/>
          </div>
         </div>
       </label>
     </div>
     </div>
         <div class="form-group">
             <div class="col-sm-12">
             <button id="cancel-button" type="button" class="btn btn-default">Cancel</button>
             <button type="submit" class="btn btn-primary col-sm-offset-1">Update</button>
             </div>
           </div>
        </form>
    </div>

</div> <!-- /container -->

   <?php include('inc/footer.inc'); ?>
   <script src="js/profile.js"></script>
  </body>
</html>
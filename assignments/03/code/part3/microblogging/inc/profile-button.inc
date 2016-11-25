<li class="dropdown">
              <a href="#" id="profile-button" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['user']['name'];?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="profile-form.php">Change profile picture</a></li>
                <li class="divider"></li>
                <li><a href="signout.php">Sign out</a></li>
              </ul>
            </li>
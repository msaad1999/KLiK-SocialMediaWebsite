<?php

    session_start();
    require 'includes/dbh.inc.php';
    define('TITLE',"Inbox | KLiK");
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }
    
    include 'includes/HTML-head.php';   
    include 'includes/navbar.php';
?> 


      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <div class='card card-profile text-center'>
                        <img alt='' class='card-img-top' src='img/banner.png'>
                        <div class='card-block'>
                            <a href='profile.php'>
                            <img src='uploads/<?php echo $_SESSION["userImg"] ?>' class='card-img-profile'></a>
                            <h4 class='card-title'>
                              <?php echo strtoupper($_SESSION['userUid']); ?>
                              <small class="text-muted"><?php echo $_SESSION['f_name']." ".$_SESSION['l_name']; ?></small>
                              <br><small class="text-muted"><?php echo $_SESSION['headline']; ?></small>
                            </h4>
                        </div>
                    </div>
          </div>
          <div class="col-sm-7 text-center" id="user-section">
              
              <img class="cover-img" id='blah-cover' src="img/banner.png">
              
              <form action="includes/profileUpdate.inc.php" method='post' enctype="multipart/form-data"
                    style="padding: 0 30px 0 30px;">
                    
              
                    <label class="btn btn-primary">
                        Change Avatar <input type="file" id="imgInp" name='dp' hidden>
                    </label>
                    <img class="profile-img" id="blah"  src="#"> 


                    <?php  
                          if ($_SESSION['userLevel'] === 1)
                          {
                              echo '<img id="admin-badge" src="img/admin-badge.png">';
                          }
                    ?>

                    <h2><?php echo strtoupper($_SESSION['userUid']); ?></h2>
                    <br>
                  
                    <div class="form-row">
                      <div class="col">
                        <input type="text" class="form-control" name="f-name" placeholder="First Name"
                               value="<?php echo $_SESSION['f_name'] ?>" >
                        <small id="emailHelp" class="form-text text-muted">First Name</small>
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="l-name" placeholder="Last Name" 
                               value="<?php echo $_SESSION['l_name'] ?>" >
                        <small id="emailHelp" class="form-text text-muted">Last Name</small>
                      </div>
                    </div>
                  
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="email" 
                               value="<?php echo $_SESSION['emailUsers'] ?>" >
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                  
                    <div class="form-group">
                                <label >Gender</label><br>
                                <input id="toggle-on" class="toggle toggle-left" name="gender" value="m" type="radio" 
                                    <?php 
                                        if ($_SESSION['gender'] == 'm'){ ?> 
                                            checked="checked"
                                    <?php } ?>>
                                <label for="toggle-on" class="btn-r">M</label>
                                <input id="toggle-off" class="toggle toggle-right" name="gender" value="f" type="radio"
                                    <?php if ($_SESSION['gender'] == 'f'){ ?> 
                                            checked="checked"
                                    <?php } ?>>
                                <label for="toggle-off" class="btn-r">F</label>
                    </div>
                  
                  <hr>
                  
                    <div class="form-group">
                        <label for="headline">Profile Headline</label>
                        <input class="form-control" type="text" id="headline" name="headline" 
                               placeholder="Your Profile Headline" value='<?php echo $_SESSION['headline']; ?>'><br>
                        
                        <label for="edit-bio">Profile Bio</label>
                        <textarea class="form-control" id="edit-bio" rows="10" name="bio" maxlength="5000"
                            placeholder="What you want to tell people about yourself" 
                            ><?php echo $_SESSION['bio']; ?></textarea>
                    </div>
                  
                  <hr>
                  
                  <div class="form-group">
                        <label for="old-pwd">Change Password</label>
                        <input type="password" class="form-control" id="old-pwd" name="old-pwd"
                               placeholder="Current Password">
                    </div>
                  
                    <div class="form-row">
                      <div class="col">
                        <input type="password" class="form-control" id="exampleInputPassword1" name="pwd"
                               placeholder="New Password">
                      </div>
                      <div class="col">
                        <input type="password" class="form-control" id="exampleInputPassword1" name="pwd-repeat"
                               placeholder="Repeat New Password">
                      </div>
                    </div>
                  
                  <br><input type="submit" class="btn btn-primary" name="update-profile" value="Update Profile">
                  
              </form>
              
              
          </div>
          <div class="col-sm-2">
            
          </div>
        </div>


      </div> <!-- /container -->




                            <script>
                                var dp = '<?php echo $_SESSION["userImg"]; ?>';
                                
                                $('#blah').attr('src', 'uploads/'+ dp);
                                
                                function readURL(input) {

                                    if (input.files && input.files[0]) {
                                      var reader = new FileReader();

                                      reader.onload = function(e) {
                                        $('#blah').attr('src', e.target.result);
                                        
                                      }

                                      reader.readAsDataURL(input.files[0]);
                                    }
                                  }

                                  $("#imgInp").change(function() {
                                    readURL(this);
                                  });
                                  
                                  
                            </script>

<?php include 'includes/HTML-footer.php'; ?>
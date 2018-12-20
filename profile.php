<?php

    session_start();
    require 'includes/dbh.inc.php';
    define('TITLE',"Inbox | KLiK");
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }
    
    if(isset($_GET['id']))
    {
        $userid = $_GET['id'];
    }
    else
    {
        $userid = $_SESSION['userId'];
    }
    
    include 'includes/HTML-head.php';   
    include 'includes/navbar.php';
    
    
    
    $sql = "select * from users where idUsers = ".$userid;
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../blogs.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
    }
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
              <img class="cover-img" src="img/<?php echo $user['coverImg']; ?>">
              <img class="profile-img" src="uploads/<?php echo $user['userImg']; ?>">
              
              <?php  
                    if ($user['userLevel'] === 1)
                    {
                        echo '<img id="admin-badge" src="img/admin-badge.png">';
                    }
              ?>
              
              <h2><?php echo strtoupper($user['userUid']); ?></h2>
              <h6><?php echo strtoupper($user['f_name']) . " " . strtoupper($user['l_name']); ?></h6>
              <h6><?php echo '<small class="text-muted">'.$user['emailUsers'].'</small>'; ?></h6>
              
              <?php 
                if ($user['gender'] == 'm')
                {
                    echo '<i class="fa fa-male fa-2x" aria-hidden="true" style="color: #709fea;"></i>';
                }
                else if ($user['gender'] == 'f')
                {
                    echo '<i class="fa fa-female fa-2x" aria-hidden="true" style="color: #FFA6F5;"></i>';
                }
                ?>
              
              <br><small><?php echo $user['headline']; ?></small>
              <br><br>
              <div class="profile-bio">
                  <small><?php echo $user['bio'];?></small>
              </div>
              
              
              <hr>
              <h3>Created Blogs</h3>
              <br><br>
              
              <?php
                    $sql = "select * from blogs "
                            . "where blog_by = ?";
                    $stmt = mysqli_stmt_init($conn);    

                    if (!mysqli_stmt_prepare($stmt, $sql))
                    {
                        die('SQL error');
                    }
                    else
                    {
                        mysqli_stmt_bind_param($stmt, "s", $userid);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        echo '<div class="container">'
                                    .'<div class="row">';
                        while ($row = mysqli_fetch_assoc($result))
                        {       
                                echo '<div class="col-sm-4" style="padding-bottom: 30px;">
                                    <div class="card user-blogs">
                                        <img class="card-img-top" src="uploads/'.$row['blog_img'].'" alt="Card image cap">
                                        <div class="card-block">
                                          <p class="card-title">'.$row['blog_title'].'</p>
                                         <p class="card-text"><small class="text-muted">'
                                         .date("F jS, Y", strtotime($row['blog_date'])).'</small></p>
                                        </div>
                                      </div>
                                      </div>';
                        }
                        echo '</div>'
                                .'</div>';
                    }
              ?>
              
              <br><br>
              <hr>
              <h3>Created Forums</h3>
              <br><br>
              
              <?php
                    $sql = "select * from topics where topic_by = ?";
                    $stmt = mysqli_stmt_init($conn);    

                    if (!mysqli_stmt_prepare($stmt, $sql))
                    {
                        die('SQL error');
                    }
                    else
                    {
                        mysqli_stmt_bind_param($stmt, "s", $userid);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        echo '<div class="container">'
                                    .'<div class="row">';
                        while ($row = mysqli_fetch_assoc($result))
                        {
                                echo '<div class="col-sm-4" style="padding-bottom: 30px;">
                                    <a href="#">
                                    <div class="card card-inverse-user-forums text-white">
                                        <img class="card-img" src="img/banner.png" alt="Card image">
                                        <div class="card-img-overlay">
                                          <p class="card-title">'.substr($row['topic_subject'],0,20).'...</p>'.
                                          '<small class="card-text">'.date("F jS, Y", strtotime($row['topic_date'])).'</small>
                                        </div>
                                      </div>
                                      </div>
                                      </a>';
                        }
                        echo '</div>'
                                .'</div>';
                    }
              ?>
              
              <br><br>
              <hr>
              <h3>Participated Polls</h3>
              <br><br>
              
              
              <?php
                    $sql = "select * from poll_votes v "
                            . "join polls p on v.poll_id = p.id "
                            . "join users u on p.created_by = u.idUsers "
                            . "where v.vote_by = ?";
                    $stmt = mysqli_stmt_init($conn);    

                    if (!mysqli_stmt_prepare($stmt, $sql))
                    {
                        die('SQL error');
                    }
                    else
                    {
                        mysqli_stmt_bind_param($stmt, "s", $userid);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        echo '<div class="container">'
                                    .'<div class="row">';
                        while ($row = mysqli_fetch_assoc($result))
                        {   
                                echo '<div class="col-sm-4" style="padding-bottom: 30px;">
                                        <a href="#">
                                        <div class="card card-inverse-user-pollvotes text-white">
                                            <img class="card-img" src="img/banner.png" alt="Card image">
                                            <div class="card-img-overlay">
                                              <p class="card-title">'.substr($row['subject'],0,20).'...</p>'.
                                              '<small class="card-text"><b>Poll by:</b> <em>'
                                                    .strtoupper($row['uidUsers']).'</em></small>
                                            </div>
                                        </div>
                                        </a>
                                    </div>';
                        }
                        echo '</div>'
                                .'</div>';
                    }
              ?>
              
              
              <br><br>
              
              
              
          </div>
          <div class="col-sm-2">
            
          </div>
        </div>


      </div> <!-- /container -->






<?php include 'includes/HTML-footer.php'; ?>
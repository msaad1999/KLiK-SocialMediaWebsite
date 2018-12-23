<?php

    session_start();
    require 'includes/dbh.inc.php';
    define('TITLE',"Votes | KLiK");
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }
    
    if (isset($_GET['poll']))
    {
        $pollid = $_GET['poll'];
    }
    else
    {
        header("Location: index.php");
        exit();
    }
    
    include 'includes/HTML-head.php';   
?> 

</head>
<body>

    <?php include 'includes/navbar.php'; ?>
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            
              <?php include 'includes/profile-card.php'; ?>
              
          </div>
            
            
          <div class="col-sm-9" id="user-section">
              
              
              <img class="event-cover" src="img/pollpage-cover.png">
              
              
              <div class="px-5 my-5">
                  <div class="px-5">
                  
                        <?php

                            $sql = "select * from poll_options where poll_id=?";
                            $stmt = mysqli_stmt_init($conn);    

                            if (!mysqli_stmt_prepare($stmt, $sql))
                            {
                                header("Location: ../poll-view.php?error=sqlerror");
                                exit();
                            }
                            else
                            {
                                mysqli_stmt_bind_param($stmt, "s", $pollid);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                while ($row = mysqli_fetch_assoc($result))
                                {
                                    $sql2 = 'select u.uidUsers, u.idUsers, u.userImg '
                                            . 'from poll_votes v join users u '
                                            . 'on v.vote_by = u.idUsers '
                                            . 'where poll_id = ? '
                                            . 'and poll_option_id = ?';
                                    $stmt = mysqli_stmt_init($conn); 
                                    mysqli_stmt_prepare($stmt, $sql2);
                                    mysqli_stmt_bind_param($stmt, "ss", $pollid, $row['id']);
                                    mysqli_stmt_execute($stmt);
                                    $result2 = mysqli_stmt_get_result($stmt);

                                    echo "<h4 class='text-muted'>".ucwords($row['name'])."</h4><br><br>";
                                    
                                    $row2 = mysqli_fetch_assoc($result2);
                                    if(empty($row2))
                                    {
                                        echo '<img class="empty-img" src="img/empty.png">
                                                <br><br><hr><br>';
                                        continue;
                                    }
                                    do
                                    {
                                        echo '<a href="profile.php?id='.$row2['idUsers'].'">
                                            <h6><img class="voter-avatar" src="uploads/'.$row2['userImg'].'" > 
                                                '.ucwords($row2['uidUsers']).'<a>
                                            </h6><br>';
                                    }while ($row2 = mysqli_fetch_assoc($result2));
                                    
                                    echo '<br><hr><br>';
                                }
                            }
                        ?>

                  
                  
                  
                  <a class="btn btn-primary btn-lg" href="poll.php?poll=<?php echo $pollid; ?>">Back To Poll</a> 
                  
                </div>
            </div>
              
              
              
          </div>
            
        </div>


      </div> <!-- /container -->


<?php include 'includes/footer.php'; ?>



<?php include 'includes/HTML-footer.php'; ?>
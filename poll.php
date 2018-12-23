<?php

    session_start();
    require 'includes/dbh.inc.php';

    define('TITLE',"Poll | KLiK");
    
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
        
    <?php 
        include 'includes/navbar.php'; 
        include 'includes/poll.class.php';
        $poll = new Poll;
        $pollData = $poll->getPolls($pollid);
    ?> 
        
        
        <div class="container">
        <div class="row">
          <div class="col-sm-3">
            
              <?php include 'includes/profile-card.php'; ?>
              
          </div>
            
            
            <div class="col-sm-9" id="user-section">
              
              <img class="event-cover" src="img/pollpage-cover.png">
              
              <div class="px-5 my-5">
                  <div class="px-5">
                      
                      <form action="" method="post" name="pollFrm">
        
                        <h1><?php echo $pollData['poll']['subject']; ?></h1>
                        <br>
                        <p class="text-muted"><?php echo $pollData['poll']['poll_desc']; ?></p>
                        <br><br>
                        
                            
                        
                            <div class="funkyradio">
                            
                        
                            <?php 

                                $sql2 = 'select v.id '
                                        . 'from poll_votes v join polls p '
                                        . 'on v.poll_id = p.id '
                                        . 'where v.vote_by = ? '
                                        . 'and v.poll_id = ? '
                                        . 'and p.locked = 1;';
                                $stmt = mysqli_stmt_init($conn);    
                                mysqli_stmt_prepare($stmt, $sql2);
                                mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userId'], $pollid);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_store_result($stmt);

                                if (mysqli_stmt_num_rows($stmt) > 0)
                                {
                                    $voteCheck = false;
                                }
                                else
                                {
                                    $voteCheck = true;
                                }

                                $sql2 = 'select poll_option_id from poll_votes where poll_id = ? and vote_by = ?';
                                $stmt = mysqli_stmt_init($conn);    
                                mysqli_stmt_prepare($stmt, $sql2);
                                mysqli_stmt_bind_param($stmt, "ss", $pollid, $_SESSION['userId']);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                $row = mysqli_fetch_assoc($result);
                                $voted = $row['poll_option_id'];

                                foreach($pollData['options'] as $opt){

                                    //echo '<input type="radio" name="voteOpt" id="option'.$opt['id'].'" '
                                     //   . 'value="'.$opt['id'].'"';
                                    
                                    echo '<div class="funkyradio-info">
                                                <input type="radio" name="voteOpt" id="option'.$opt['id'].'"
                                                    value="'.$opt['id'].'" ';
                                    
                                    if ($opt['id'] == $voted)
                                    {
                                        echo 'checked="checked" ';
                                    }
                                    if ($voteCheck === false)
                                    {
                                        echo 'disabled="disabled" ';
                                    }
                                    
                                    echo            '> 
                                                    <label for="option'.$opt['id'].'">'.$opt['name'].'</label>
                                            </div>';
                                }
                                
                                echo '</div><br><br>';
                                
                                if ($voteCheck)
                                {
                                    echo '<input type="submit" name="voteSubmit" class="btn btn-lg btn-primary" 
                                        value="Submit Vote">
                                            <hr>';  
                                }
                                if (!empty($voted))
                                {
                                    // Poll Results    

                                    $pollResult = $poll->getResult($_GET['poll']);
                                    echo '<h1>Results</h1>';
                                    echo '<b class="text-muted">Total Votes: </b>'.$pollResult['total_votes'].'
                                            <br><br>';

                                    echo '<div class="col-md-12 col-lg-8">';

                                    if($voteCheck && !empty($pollResult['options']))
                                    { 
                                        $i=0;
                                        //Option bar color class array
                                        $barColorArr = array('azure','emerald','violet','yellow','red');
                                        //Generate option bars with votes count


                                        foreach($pollResult['options'] as $opt=>$vote){

                                            //Calculate vote percent
                                            $votePercent = round(($vote/$pollResult['total_votes'])*100);
                                            $votePercent = !empty($votePercent)?$votePercent.'':'0';


                                            //Define bar color class
                                            if(!array_key_exists($i, $barColorArr)){
                                                $i=0;
                                            }
                                            $barColor = $barColorArr[$i];
                            ?>

                            <div class="line-progress margin-b-20" 
                                 data-prog-percent="<?php echo $votePercent/100; ?>"><div></div>
                                <p class="progress-title"><?php echo $opt." - <b>".$vote.' user(s)'; ?></b></p>
                            </div><br>    

                            <?php
                                        $i++;
                                        }
                                        echo '</div>';
                                    }
                            ?>
                            
                            <br><br>
                            <a href="./poll-voters.php?poll=<?php echo $_GET['poll']; ?>" 
                               class="btn btn-secondary">View All Votes</a> 
                            <a href="./poll-view.php" class="btn btn-secondary">View All Polls</a>
                            
                            <?php
                                }
                            ?>

                        <input type="hidden" name="pollID" value="<?php echo $pollData['poll']['id']; ?>">

                    </form>
                  </div>
              </div>
              
          </div>
            
        </div>


      </div> <!-- /container -->
        
             
        
        
    <?php
        //if vote is submitted
        if(isset($_POST['voteSubmit'])){
            $voteData = array(
                'poll_id' => $_POST['pollID'],
                'poll_option_id' => $_POST['voteOpt'],
                'poll_vote_by' => $_SESSION['userId']
            );
            //insert vote data
            $voteSubmit = $poll->vote($voteData);
            //header("Location: ./poll.php?poll=".$pollid);
            header("Refresh:0");
        }
    ?>
      
    <?php include 'includes/footer.php'; ?>
        

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>
        
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/progressbar.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php
    define('TITLE',"Poll | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (isset($_GET['poll']))
    {
        $pollid = strip_bad_chars($_GET['poll']);
    }
?>


<?php
    //include and initialize Poll class 
    include 'includes/poll.class.php';
    $poll = new Poll;

    //get poll and options data
    $pollData = $poll->getPolls($pollid);
?>


<div class="pollContent">
    
    <form action="" method="post" name="pollFrm">
        
        <h3><?php echo $pollData['poll']['subject']; ?></h3>
        <br><br><p><?php echo $pollData['poll']['poll_desc']; ?></p>
        
        <ul>
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
                
                echo '<li><input type="radio" name="voteOpt" id="option'.$opt['id'].'" '
                . 'value="'.$opt['id'].'"';
                if ($opt['id'] == $voted)
                {
                    echo 'checked="checked" ';
                }
                if ($voteCheck === false)
                {
                    echo 'disabled="disabled" ';
                }
                echo ">";
                echo '<label for="option'.$opt['id'].'">'.$opt['name'].'</label></li>';
            }
            
            if ($voteCheck)
            {
                echo '<input type="submit" name="voteSubmit" class="button" value="Vote"> ';  
            }
            if (!empty($voted))
            {
                echo '<a href="results.php?pollID='.$pollData["poll"]["id"].'">Results</a><br><br> ';
            ?>
            
            </ul>
        
            <?php
            
                $pollResult = $poll->getResult($_GET['poll']);
                echo '<h3>Results</h3>';
                echo '<b>Total Votes: </b>'.$pollResult['total_votes'].'<br>';
                
                if(!empty($pollResult['options']))
                { 
                    $i=0;
                    //Option bar color class array
                    $barColorArr = array('azure','emerald','violet','yellow','red');
                    //Generate option bars with votes count


                    foreach($pollResult['options'] as $opt=>$vote){

                        //Calculate vote percent
                        $votePercent = round(($vote/$pollResult['total_votes'])*100);
                        $votePercent = !empty($votePercent)?$votePercent.'%':'0%';


                        //Define bar color class
                        if(!array_key_exists($i, $barColorArr)){
                            $i=0;
                        }
                        $barColor = $barColorArr[$i];
            ?>
        
            <div class="bar-main-container <?php echo $barColor; ?>">
                
                <div class="txt"><?php echo $opt." - ".$vote.' user(s)'; ?></div>

                <div class="wrap">
                    <div class="bar-percentage"><?php echo $votePercent; ?></div>
                    <div class="bar-container">
                        <div class="bar" style="width: <?php echo $votePercent; ?>;"></div>
                    </div>
                </div>
              </div>
        
            <?php
                    $i++;
                    }
                }
            ?>
            <a href="./poll-voters.php?poll=<?php echo $_GET['poll']; ?>" class="button previous">View All Votes</a><br>
            <a href="./poll-view.php" class="button previous">View All Polls</a>
            <?php
            }
            ?>
            
        <input type="hidden" name="pollID" value="<?php echo $pollData['poll']['id']; ?>">
        
    </form>
</div>

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
    header("Location: ./poll.php?poll=".$pollid);
}
?>


<?php include 'includes/footer.php'; ?>


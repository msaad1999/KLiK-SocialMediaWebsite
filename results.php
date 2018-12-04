<?php
    define('TITLE',"Poll Results | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<?php
    //include and initialize Poll class 
    include 'includes/poll.class.php';
    $poll = new Poll;

    //get poll result data
    $pollResult = $poll->getResult($_GET['pollID']);
?>

<h3><?php echo $pollResult['poll']; ?></h3>
<p><b>Total Votes:</b> <?php echo $pollResult['total_votes']; ?></p>

<?php
    if(!empty($pollResult['options'])){ $i=0;
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
  <div class="txt"><?php echo $opt; ?></div>
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

<a href="poll.php">Back To Poll</a>

<?php include 'includes/footer.php'; ?>
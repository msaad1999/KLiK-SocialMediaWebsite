
<?php

    session_start();
    include_once 'includes/dbh.inc.php';
    define('TITLE',"Dashboard| KLiK");

    $companyName = "Franklin's Fine Dining";
    include 'includes/arrays.php';
    
    function strip_bad_chars( $input ){
        $output = preg_replace( "/[^a-zA-Z0-9_-]/", "", $input);
        return $output;
    }
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }
?> 



<!DOCTYPE html>
<html>
    <head>
        <meta name="description" content="An Information Pool System" />
        <meta name="keywords" content="put, keywords, here" >
        
        
        <title><?php echo TITLE; ?></title>
        
        <link href="css/bootstrap.min.css" rel="stylesheet"> 
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet"> 
        <link rel="stylesheet" type="text/css" href="css/list-page.css">
        <link href="css/styles.css" rel="stylesheet">
        
        
        <link rel="shortcut icon" href="img/logo.ico" />
    </head>
    
    <body>
        
<?php include 'includes/navbar.php'; ?>        
        

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3" >
                    
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
                
                <div class="col-sm-7" >
                    
                    <div class="text-center p-3">
                        <img src="img/logo.png" >
                        <p><br>DASHBOARD</p>
                    </div>
                    
                    
                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="forum-tab" data-toggle="tab" href="#forum" role="tab" 
                             aria-controls="forum" aria-selected="true">Recent Forums</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="blog-tab" data-toggle="tab" href="#blog" role="tab" 
                             aria-controls="blog" aria-selected="false">Recent Blogs</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="poll-tab" data-toggle="tab" href="#poll" role="tab" 
                             aria-controls="poll" aria-selected="false">Recent Polls</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="event-tab" data-toggle="tab" href="#event" role="tab" 
                             aria-controls="event" aria-selected="false">Recent Events</a>
                        </li>
                    </ul>
                    
                    <br>
                    
                    <div class="tab-content" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="forum" role="tabpanel" aria-labelledby="forum-tab">
                            
                            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                                <img class="mr-3" src="img/logo.png" alt="" width="48" height="48">
                              <div class="lh-100">
                                <h1 class="mb-0 text-white lh-100">Latest Forums</h1>
                              </div>
                            </div>  

                            <div class="my-3 p-3 bg-white rounded shadow-sm">

                              <?php

                                  $sql = "select topic_id, topic_subject, topic_date, topic_cat, topic_by, userImg, idUsers, uidUsers, cat_name, (
                                                  select sum(post_votes)
                                              from posts
                                              where post_topic = topic_id
                                              ) as upvotes
                                          from topics, users, categories 
                                          where topics.topic_by = users.idUsers
                                          and topics.topic_cat = categories.cat_id
                                          order by topic_id desc, upvotes asc 
                                          LIMIT 4";
                                  $stmt = mysqli_stmt_init($conn);  

                                  if (!mysqli_stmt_prepare($stmt, $sql))
                                  {
                                      die('SQL error');
                                  }
                                  else
                                  {
                                      mysqli_stmt_execute($stmt);
                                      $result = mysqli_stmt_get_result($stmt);

                                      while ($row = mysqli_fetch_assoc($result))
                                      {

                                          echo '<a href="posts.php?topic='.$row['topic_id'].'">
                                              <div class="media text-muted pt-3">
                                                  <img src="uploads/'.$row['userImg'].'" alt="" class="mr-2 rounded div-img">
                                                  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                                    <strong class="d-block text-gray-dark">'.ucwords($row['topic_subject']).'</strong></a>
                                                    <span class="text-warning">'.ucwords($row['uidUsers']).'</span><br>
                                                    '.date("F jS, Y", strtotime($row['topic_date'])).'
                                                  </p>
                                                  <span class="text-primary text-center">
                                                      <i class="fa fa-chevron-up" aria-hidden="true"></i><br>
                                                          '.$row['upvotes'].'</div>';
                                      }
                                 }
                              ?>

                            </div>    
                            
                        </div>
                        
                        <div class="tab-pane fade" id="blog" role="blog" aria-labelledby="blog-tab">
                            
                            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                                <img class="mr-3" src="img/logo.png" alt="" width="48" height="48">
                              <div class="lh-100">
                                <h1 class="mb-0 text-white lh-100">Latest Blogs</h1>
                              </div>
                            </div>  

                            <div class="my-3 p-3 bg-white rounded shadow-sm">

                              <?php

                                  $sql = "select topic_id, topic_subject, topic_date, topic_cat, topic_by, userImg, idUsers, uidUsers, cat_name, (
                                                  select sum(post_votes)
                                              from posts
                                              where post_topic = topic_id
                                              ) as upvotes
                                          from topics, users, categories 
                                          where topics.topic_by = users.idUsers
                                          and topics.topic_cat = categories.cat_id
                                          order by topic_id desc, upvotes asc 
                                          LIMIT 4";
                                  $stmt = mysqli_stmt_init($conn);  

                                  if (!mysqli_stmt_prepare($stmt, $sql))
                                  {
                                      die('SQL error');
                                  }
                                  else
                                  {
                                      mysqli_stmt_execute($stmt);
                                      $result = mysqli_stmt_get_result($stmt);

                                      while ($row = mysqli_fetch_assoc($result))
                                      {

                                          echo '<a href="posts.php?topic='.$row['topic_id'].'">
                                              <div class="media text-muted pt-3">
                                                  <img src="uploads/'.$row['userImg'].'" alt="" class="mr-2 rounded div-img">
                                                  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                                    <strong class="d-block text-gray-dark">'.ucwords($row['topic_subject']).'</strong></a>
                                                    <span class="text-warning">'.ucwords($row['uidUsers']).'</span><br>
                                                    '.date("F jS, Y", strtotime($row['topic_date'])).'
                                                  </p>
                                                  <span class="text-primary text-center">
                                                      <i class="fa fa-chevron-up" aria-hidden="true"></i><br>
                                                          '.$row['upvotes'].'</div>';
                                      }
                                 }
                              ?>

                            </div>    
                            
                        </div>
                        
                        <div class="tab-pane fade" id="poll" role="poll" aria-labelledby="poll-tab">
                            
                            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                                <img class="mr-3" src="img/logo.png" alt="" width="48" height="48">
                              <div class="lh-100">
                                <h1 class="mb-0 text-white lh-100">Latest Polls</h1>
                              </div>
                            </div>  

                            <div class="my-3 p-3 bg-white rounded shadow-sm">

                              <?php

                                $sql = "select p.id, p.subject, p.created, p.poll_desc, p.locked, (
                                            select count(*) 
                                            from poll_votes v
                                            where v.poll_id = p.id
                                            ) as votes
                                        from polls p 
                                        order by votes desc";

                                $stmt = mysqli_stmt_init($conn);    

                                if (!mysqli_stmt_prepare($stmt, $sql))
                                {
                                    die('SQL error');
                                }
                                else
                                {
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    while ($row = mysqli_fetch_assoc($result))
                                    {

                                        echo '<a href="poll.php?poll='.$row['id'].'">
                                            <div class="media text-muted pt-3">
                                                <img src="img/logo.png" alt="" class="mr-2 rounded div-img poll-img">
                                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray ">
                                                  <strong class="d-block text-gray-dark">'.ucwords($row['subject']).'</strong></a>
                                                      '.date("F jS, Y", strtotime($row['created'])).'
                                                      <br><br>'.substr($row['subject'],0,50).'...<br><br>
                                                       <span class="text-primary" >
                                                            '.$row['votes'].' User(s) have voted
                                                       </span>
                                                </p>
                                                <span class="text-right">';

                                        if($row['locked'] === 1)
                                        {
                                            echo '<br><b class="small text-muted">[Locked Poll]</b>';
                                        }
                                        else
                                        {
                                            echo '<br><b class="small text-success">[Open Poll]</b>';
                                        }

                                        echo '</span>
                                                </div>';
                                    }
                               }
                            ?>

                            </div>    
                            
                        </div>
                        
                        <div class="tab-pane fade" id="event" role="event" aria-labelledby="event-tab">
                            
                            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                                <img class="mr-3" src="img/logo.png" alt="" width="48" height="48">
                              <div class="lh-100">
                                <h1 class="mb-0 text-white lh-100">Latest Events</h1>
                              </div>
                            </div>  

                            <div class="my-3 p-3 bg-white rounded shadow-sm">

                              <?php

                                  $sql = "select topic_id, topic_subject, topic_date, topic_cat, topic_by, userImg, idUsers, uidUsers, cat_name, (
                                                  select sum(post_votes)
                                              from posts
                                              where post_topic = topic_id
                                              ) as upvotes
                                          from topics, users, categories 
                                          where topics.topic_by = users.idUsers
                                          and topics.topic_cat = categories.cat_id
                                          order by topic_id desc, upvotes asc 
                                          LIMIT 4";
                                  $stmt = mysqli_stmt_init($conn);  

                                  if (!mysqli_stmt_prepare($stmt, $sql))
                                  {
                                      die('SQL error');
                                  }
                                  else
                                  {
                                      mysqli_stmt_execute($stmt);
                                      $result = mysqli_stmt_get_result($stmt);

                                      while ($row = mysqli_fetch_assoc($result))
                                      {

                                          echo '<a href="posts.php?topic='.$row['topic_id'].'">
                                              <div class="media text-muted pt-3">
                                                  <img src="uploads/'.$row['userImg'].'" alt="" class="mr-2 rounded div-img">
                                                  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                                    <strong class="d-block text-gray-dark">'.ucwords($row['topic_subject']).'</strong></a>
                                                    <span class="text-warning">'.ucwords($row['uidUsers']).'</span><br>
                                                    '.date("F jS, Y", strtotime($row['topic_date'])).'
                                                  </p>
                                                  <span class="text-primary text-center">
                                                      <i class="fa fa-chevron-up" aria-hidden="true"></i><br>
                                                          '.$row['upvotes'].'</div>';
                                      }
                                 }
                              ?>

                            </div>    
                            
                        </div>
                        
                    </div>
                    
                </div>
                
                <div class="col-sm-2">
                    
                    <div class="text-center p-3 mt-5">
                        <a href="#"><i class="creater-icon fa fa-users fa-5x" aria-hidden="true"></i></a>
                        <p><br>THE CREATORS</p>
                    </div>
                    
                    <a href="forum.php" class="btn btn-primary btn-lg btn-block">KLiK Forum</a>
                    <a href="hub.php" class="btn btn-secondary btn-lg btn-block">KLiK Hub</a>
                    <br><br><br>
                    <a href="create-topic.php" class="btn btn-primary btn-lg btn-block">Create a Forum</a>
                    <a href="create-blog.php" class="btn btn-secondary btn-lg btn-block">Create a Blog</a>
                    
                </div>
            </div>
        </div>

        
        
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>   
        
<?php include include 'includes/HTML-footer.php'; ?>
<?php
    session_start();
    require 'includes/dbh.inc.php';
    
    define('TITLE',"Hub | KLiK");
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    } 
    
    include 'includes/HTML-head.php';
    include 'includes/navbar.php';
    
?>  


            <link rel="stylesheet" type="text/css" href="css/list-page.css">
    </head>
    
    <body style="background: #f1f1f1">

        <main role="main" class="container">
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
          <img class="mr-3" src="img/200.png" alt="" width="48" height="48">
        <div class="lh-100">
          <h1 class="mb-0 text-white lh-100">KLiK Hub</h1>
          <small>Spreading Ideas</small>
        </div>
      </div>

      <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h5 class="border-bottom border-gray pb-2 mb-0">Top Blogs</h5>
        
        
        <?php

            $sql = "select blog_id, blog_img, blog_date, blog_votes, blog_title, blog_content, uidUsers
                    from blogs, users
                    where blogs.blog_by = users.idUsers
                    order by blog_votes desc
                    LIMIT 5 ";
            
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
                    
                    echo '<a href="blog-page.php?id='.$row['blog_id'].'">
                        <div class="media text-muted pt-3">
                            <img src="uploads/'.$row['blog_img'].'" alt="" class="mr-2 rounded div-img ">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray ">
                              <strong class="d-block text-gray-dark">'.ucwords($row['blog_title']).'</strong></a>
                                  <br>'.substr($row['blog_content'],0,50).'...
                            </p>
                            <span class="text-right text-primary"><i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                '.$row['blog_votes'].'<br>';
                    
                    if ($_SESSION['userLevel'] == 1 || $_SESSION['userLevel'] == $row['blog_by'])
                    {
                        echo '<a href="includes/delete-blog.php?id='.$row['blog_id'].'&page=forum" >
                                <i class="fa fa-trash" aria-hidden="true" style="color: red;"></i>
                              </a>
                            </span>';
                    }
                    else
                    {
                        echo '</span>';
                    }
                    
                    echo '</div>';
                }
           }
        ?>
        
            <small class="d-block text-right mt-3">
                <a href="create-blog.php" class="btn btn-primary">Create a Blog</a>
                <a href="blogs.php" class="btn btn-primary">All Blogs</a>
            </small>
        
        
      </div>
           
            
            
            
      <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h5 class="border-bottom border-gray pb-2 mb-0">Upcoming Events</h5>
        
        <?php

            $sql = "select event_id, event_by, title, event_date, event_image
                    from events
                    where event_date > now()
                    order by event_date 
                    LIMIT 5";
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
                    $earlier = new DateTime(date("Y-m-d"));
                    $later = new DateTime($row['event_date']);
                    $diff = $later->diff($earlier)->format("%a");
                    
                    echo '<a href="event-page.php?id='.$row['event_id'].'">
                        <div class="media text-muted pt-3">
                            <img src="uploads/'.$row['event_image'].'" alt="" class="mr-2 rounded div-img">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                              <strong class="d-block text-gray-dark">'.ucwords($row['title']).'</strong></a>
                              '.date("F jS, Y", strtotime($row['event_date'])).'<br>
                              <span class="text-primary" >'.$diff.' days remaining </span>
                            </p>
                            <span class="text-primary text-right">';
                    
                    if ($_SESSION['userLevel'] == 1 || $_SESSION['userId'] == $row['event_by'])
                    {
                        echo '<a href="includes/delete-event.php?id='.$row['event_id'].'&page=forum" >
                                <i class="fa fa-trash" aria-hidden="true" style="color: red;"></i>
                              </a>
                            </span>';
                    }
                    else
                    {
                        echo '</span>';
                    }
                    echo '</span>
                            </div>';
                }
           }
        ?>
        
        <small class="d-block text-right mt-3">
            <a href="create-event.php" class="btn btn-primary">Create An Event</a>
            <a href="events.php" class="btn btn-primary">All Events</a>
        </small>
        
      </div>
            
            
      <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h5 class="border-bottom border-gray pb-2 mb-0">Latest Polls</h5>
        
        <?php

            $sql = "select p.id, p.subject, p.created_by, p.locked, uidUsers, (
                        select count(*) 
                        from poll_votes pv 
                        where pv.poll_id = p.id
                        ) as voters
                    from polls p, users u
                    where p.created_by = u.idUsers
                    order by voters desc, created asc 
                    LIMIT 5";
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
                            <img src="img/poll-cover.png" alt="" class="mr-2 rounded div-img">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                              <strong class="d-block text-gray-dark">'.ucwords($row['subject']).'</strong></a>
                              <span class="text-muted">Created By'.ucwords($row['uidUsers']).'</span><br>
                                  <span class="text-primary">'.$row['voters'].' user(s) voted</span>
                            </p>
                            </div>';
                    
                    echo '';
                }
           }
        ?>
        
        <small class="d-block text-right mt-3">
            <a href="create-poll.php" class="btn btn-primary">Create A Poll</a>
            <a href="polls.php" class="btn btn-primary">All Polls</a>
        </small>
        
      </div>
            
            
    </main>
        
      <?php include 'includes/footer.php'; ?>  

<?php include 'includes/HTML-footer.php'; ?>
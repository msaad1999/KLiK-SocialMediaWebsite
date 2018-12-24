
<?php

    session_start();
    require 'includes/dbh.inc.php';
    define('TITLE',"Polls | KLiK");
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }
    
    include 'includes/HTML-head.php';
?>  

	<link rel="stylesheet" type="text/css" href="css/list-page.css">
    </head>
    
    <body style="background: #f1f1f1">

        <?php include 'includes/navbar.php'; ?>
   

        <main role="main" class="container">
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
          <img class="mr-3" src="img/200.png" alt="" width="48" height="48">
        <div class="lh-100">
          <h1 class="mb-0 text-white lh-100">KLiK Polls</h1>
          <small>Spreading Ideas</small>
        </div>
      </div>

      <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h5 class="border-bottom border-gray pb-2 mb-0">All Polls</h5>
        
        
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
                            <img src="img/poll-cover.png" alt="" class="mr-2 rounded div-img poll-img">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray ">
                              <strong class="d-block text-gray-dark">'.ucwords($row['subject']).'</strong></a>
                                  '.date("F jS, Y", strtotime($row['created'])).'
                                  <br><br>'.substr($row['subject'],0,50).'...<br>
                                   <span class="text-primary" >
                                        '.$row['votes'].' User(s) have voted
                                   </span>
                            </p>
                            <span class="text-right">';
                    
                    if ($_SESSION['userLevel'] == 1)
                    {
                        echo '<a href="includes/delete-poll.inc.php?pollid='.$row['id'].'" >
                                <i class="fa fa-trash fa-2x" aria-hidden="true" style="color: red;"></i>
                              </a>';
                    }
                    
                    if($row['locked'] === 1)
                    {
                        echo '<br><span class="text-warning">[Locked Poll]</span>';
                    }
                    else
                    {
                        echo '<br><span class="text-success">[Open Poll]</span>';
                    }
                    
                    echo '</span>
                            </div>';
                }
           }
           
           
            if ($_SESSION['userLevel'] == 1)
            {
                echo '<small class="d-block text-right mt-3">
                        <a href="create-poll.php" class="btn btn-primary">Create a Poll</a>';
            }
            else
            {
                echo '<small class="d-block text-right mt-3">';
            }
        ?>
        
        
        </small>
        
        
      </div>
    </main>
        
        <?php include 'includes/footer.php'; ?>
        
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    </body>
</html>

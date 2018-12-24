<?php

    session_start();
    require 'includes/dbh.inc.php';
    
    define('TITLE',"Events | KLiK");
    
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
          <h1 class="mb-0 text-white lh-100">KLiK Events</h1>
          <small>Spreading Ideas</small>
        </div>
      </div>

      <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h5 class="border-bottom border-gray pb-2 mb-0">All Events</h5>
        
        
        <?php

            $sql = "select event_id, event_by, title, event_date, event_image
                    from events
                    order by event_date desc";
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
                    if($earlier > $later)
                    {
                        $diff = '<span class="text-danger">Event Completed</span>';
                    }
                    else
                    {
                        $diff = $later->diff($earlier)->format("%a").' days remaining';
                    }
                    
                    echo '<a href="event-page.php?id='.$row['event_id'].'">
                        <div class="media text-muted pt-3">
                            <img src="uploads/'.$row['event_image'].'" alt="" class="mr-2 rounded div-img">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                              <strong class="d-block text-gray-dark">'.ucwords($row['title']).'</strong></a>
                              '.date("F jS, Y", strtotime($row['event_date'])).'<br>
                              <span class="text-primary" >'.$diff.'</span>
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
                <a href="create-event.php" class="btn btn-primary">Create an Event</a>
            </small>
        
        
      </div>
            
    </main>
        
        <?php include 'includes/footer.php'; ?>
        
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    </body>
</html>
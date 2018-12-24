<?php

    session_start();
    require 'includes/dbh.inc.php';
    
    define('TITLE',"Find People | KLiK");
    
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
            <div class="mx-5">
                <div class="d-flex align-items-center p-3 my-3 mx-5 text-white-50 bg-purple rounded shadow-sm">
                    <img class="mr-3" src="img/200.png" alt="" width="48" height="48">
                  <div class="lh-100">
                    <h1 class="mb-0 text-white lh-100">KLiK Users</h1>
                    <small>Spreading Ideas</small>
                  </div>
                </div>

                <div class="my-3 mx-5 p-3 bg-white rounded shadow-sm">
                  <h5 class="border-bottom border-gray pb-2 mb-0">Find People on KLiK</h5>


                  <?php

                      $sql = "select idUsers, uidUsers, userLevel, f_name, l_name, emailUsers, userImg
                              from users
                              order by userLevel desc, idUsers asc";

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

                              echo '<a href="profile.php?id='.$row['idUsers'].'">
                                  <div class="media text-muted pt-3">
                                      <img src="uploads/'.$row['userImg'].'" alt="" class="mr-2 rounded-circle div-img list-user-img">
                                      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray ">
                                        <strong class="d-block text-gray-dark">'.ucwords($row['uidUsers']).'</strong></a>
                                            <span class="text-primary">'.ucwords($row['f_name'].' '.$row['l_name']).'</span><br>
                                            '.$row['emailUsers'].'
                                      </p>
                                      <span class="text-right text-primary">
                                          <a href="message.php?id='.$row['idUsers'].'" >
                                              <i class="fa fa-comments-o fa-2x" aria-hidden="true"></i>
                                          </a>
                                      </span>
                                  </div>';
                          }
                     }
                  ?>

                      <small class="d-block text-right mt-3">
                          <a href="profile.php" class="btn btn-primary">Go to Profile</a>
                          <a href="message.php" class="btn btn-primary">Go to Inbox</a>
                      </small>


                </div>
            </div>
        </main>
        
        <?php include 'includes/footer.php'; ?>
        
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    </body>
</html>
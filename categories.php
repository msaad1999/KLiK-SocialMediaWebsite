<?php

    session_start();
    require 'includes/dbh.inc.php';
    
    define('TITLE',"Categories | KLiK");
    
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
          <h1 class="mb-0 text-white lh-100">KLiK Forums</h1>
          <small>Spreading Ideas</small>
        </div>
      </div>

      <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h5 class="border-bottom border-gray pb-2 mb-0">All Categories</h5>
        
        
        <?php

            $sql = "select cat_id, cat_name, cat_description, (
                        select count(*) from topics
                        where topics.topic_cat = cat_id
                        ) as forums
                    from categories
                    order by cat_id asc";
            
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
                    
                    echo '<a href="topics.php?cat='.$row['cat_id'].'">
                        <div class="media text-muted pt-3">
                            <img src="img/forum-cover.png" alt="" class="mr-2 rounded div-img ">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray ">
                              <strong class="d-block text-gray-dark">'.ucwords($row['cat_name']).'</strong></a>
                                  <br>'.$row['cat_description'].'
                            </p>
                            <span class="text-right text-primary"> 
                                Forums: '.$row['forums'].' <i class="fa fa-book" aria-hidden="true"></i><br>';
                    
                    if ($_SESSION['userLevel'] == 1)
                    {
                        echo '<a href="includes/delete-category.php?id='.$row['cat_id'].'&page=categories" >
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
           
           
            if ($_SESSION['userLevel'] == 1)
            {
                echo '<small class="d-block text-right mt-3">
                        <a href="create-category.php" class="btn btn-primary">Create Category</a>';
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

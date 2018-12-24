<?php

    session_start();
    require 'includes/dbh.inc.php';
    
    define('TITLE',"The Team | KLiK");
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }
    
    include 'includes/HTML-head.php';
?>  


        <link href="css/creator-portfolio.min.css" rel="stylesheet">
    </head>
    
    <body style="background: #f1f1f1">

        <?php include 'includes/navbar.php'; ?>
   

        <div class="jumbotron text-white" style="background-image: url('img/team-cover.png')">
            <div class="container">
              <h1 class="display-3">The KLiK Creators</h1>
              <h4>The Brains and Brawns behind all this</h4>
              <h1><a href="https://github.com/msaad1999/KLiK--PHP-coded-Social-Media-Website">
                      <i class="fa fa-github" aria-hidden="true"></i>
                  </a> &raquo;</h1>
            </div>
        </div>

        
      <div class="container">
        
        <section class="content-section" id="portfolio">
            
          <div class="container">
              
            <div class="content-section-heading text-center">
              <h3 class="text-secondary mb-0">The Minds Behind KLiK</h3>
              <h2 class="mb-5">The Team</h2>
            </div>
            <div class="row no-gutters">
              <div class="col-lg-6">
                  <a class="portfolio-item" href="_KLiK creators/KLiK_saad.php" target="_blank">
                  <span class="caption">
                    <span class="caption-content">
                      <h2>Muhammad Saad</h2>
                      <p class="mb-0 text-white">The Border is Black</p>
                    </span>
                  </span>
                  <img class="img-fluid" src="img/saad.png" alt="">
                </a>
              </div>
              <div class="col-lg-6">
                <a class="portfolio-item" href="_KLiK creators/KLiK_anas-kamal.php" target="_blank">
                  <span class="caption">
                    <span class="caption-content">
                      <h2>Syed Anas Kamal</h2>
                      <p class="mb-0 text-white">The cooler Anas than the one below</p>
                    </span>
                  </span>
                    <img class="img-fluid" src="img/anas-kamal.png" alt="">
                </a>
              </div>
              <div class="col-lg-6">
                <a class="portfolio-item" href="_KLiK creators/KLiK_ubaid.php" target="_blank">
                  <span class="caption">
                    <span class="caption-content">
                      <h2>Muhammad Ubaid Asim</h2>
                      <p class="mb-0 text-white">The border is not black</p>
                    </span>
                  </span>
                  <img class="img-fluid" src="img/ubaid.png" alt="">
                </a>
              </div>
              <div class="col-lg-6">
                <a class="portfolio-item" href="_KLiK creators/KLiK_anas-imran.php" target="_blank">
                  <span class="caption">
                    <span class="caption-content">
                      <h2>Anas Imran Tasadduq</h2>
                      <p class="mb-0 text-white">The Anas above me is lying</p>
                    </span>
                  </span>
                    <img class="img-fluid" src="img/anas-imran.png" alt="">
                </a>
              </div>
            </div>
          </div>
        </section>
          

      </div>
        
        <?php include 'includes/footer.php'; ?>
        
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    </body>
</html>
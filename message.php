<?php

    session_start();
    require 'includes/dbh.inc.php';
    
    define('TITLE',"Inbox | KLiK");
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }  
    
    include 'includes/HTML-head.php';
?> 


        <link href="css/inbox.css" rel="stylesheet">
    </head>
    
    <body>

        <?php include 'includes/navbar.php'; ?>
        
        <div class="cover">
            <div class="messaging">
              <div class="inbox_msg">
                <div class="inbox_people">
                  <div class="headind_srch">
                    <div class="recent_heading">
                      <h2>Inbox</h2>
                    </div>
                  </div>
                  <div class="inbox_chat">
                      
                      <?php
                
                        $sql = "select * from users where idUsers != ?";
                        $stmt = mysqli_stmt_init($conn);    

                        if (!mysqli_stmt_prepare($stmt, $sql))
                        {
                            die('sql error');
                        }
                        else
                        {
                            mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            
                            while ($row = mysqli_fetch_assoc($result))
                            {
                        ?>
                      
                      <a href='./message.php?id=<?php echo $row['idUsers']; ?>'><div class="chat_list ">
                            <div class="chat_people">
                                <div class="chat_img"> 
                                    <img class="chat_people_img" src="uploads/<?php echo $row['userImg'] ?>"> 
                                </div>
                              <div class="chat_ib">
                                <h5>
                                    <?php echo ucwords($row['uidUsers']) ?> 
                                    <span class="chat_date">KLiK User</span>
                                </h5>
                                <p>Click on the User to start chatting</p>
                              </div>
                            </div>
                          </div></a>
                      
                        <?php
                               
                            }
                        }

                        ?>
                  </div>
                </div>
                  
                  
                  
                <div class="mesgs">
                    <div class="msg_history">
                      
                        <?php
            
                            if(isset($_GET['id'])){

                                $user_two = trim(mysqli_real_escape_string($conn, $_GET['id']));

                                $sql = "select idUsers from users where idUsers = ? and idUsers != ?";
                                $stmt = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($stmt, $sql))
                                {
                                    die("SQL error");
                                }
                                else
                                {
                                    mysqli_stmt_bind_param($stmt, "ss", $user_two, $_SESSION['userId']);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_store_result($stmt);

                                    $resultCheck = mysqli_stmt_num_rows($stmt);

                                    if ($resultCheck === 0)
                                    {
                                        die("Invalid $_GET ID.");
                                    }
                                    else
                                    {
                                        $sql = "select * from conversation "
                                                . "where (user_one = ? AND user_two = ?) "
                                                . "or (user_one = ? AND user_two = ?)";
                                        $stmt = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($stmt, $sql))
                                        {
                                            die("SQL error");
                                        }
                                        else
                                        {
                                            mysqli_stmt_bind_param($stmt, "ssss", $user_two, $_SESSION['userId'],
                                                    $_SESSION['userId'], $user_two);

                                            mysqli_stmt_execute($stmt);
                                            $conver = mysqli_stmt_get_result($stmt);
                                            mysqli_stmt_store_result($stmt);

                                            if (mysqli_num_rows($conver) > 0)
                                            {

                                                $fetch = mysqli_fetch_assoc($conver);
                                                $conversation_id = $fetch['id'];

                                            }
                                            else
                                            {
                                                $sql = "insert into conversation(user_one, user_two) "
                                                        . "values (?,?)";
                                                $stmt = mysqli_stmt_init($conn);
                                                if (!mysqli_stmt_prepare($stmt, $sql))
                                                {
                                                    die("SQL error");
                                                }
                                                else
                                                {
                                                    mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userId'], $user_two);
                                                    mysqli_stmt_execute($stmt);
                                                    mysqli_stmt_store_result($stmt);

                                                    $conversation_id = mysqli_insert_id($conn);
                                                }
                                            }
                                        }
                                    }
                                }
                            }else {
                                die("<div class='text-center'>
                                        <br><br><br>
                                        <h1 class='text-white'>Click on a person to start chatting</h1>
                                     </div>");
                            }
                        ?>
                      
                     
                    
                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="hidden" id="conversation_id" value="<?php echo base64_encode($conversation_id); ?>">
                        <input type="hidden" id="user_form" value="<?php echo base64_encode($_SESSION['userId']); ?>">
                        <input type="hidden" id="user_to" value="<?php echo base64_encode($user_two); ?>">

                        <textarea id="message" type="text" class="write_msg form-control-plaintext" style="background-color: white;" 
                                  placeholder="Type a message"></textarea>

                        <button id="reply" class="msg_send_btn" 
                                type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
            
 

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>  
    </body>
</html>

<?php
    session_start();
    require("dbh.inc.php");
    if(isset($_GET['c_id'])){
        $conversation_id = base64_decode($_GET['c_id']);
        
        $q = mysqli_query($conn, "SELECT * FROM messages WHERE conversation_id = ".$conversation_id);
        
        if(mysqli_num_rows($q) > 0){
            while ($m = mysqli_fetch_assoc($q)) {
                //format the message and display it to the user
                $user_form = $m['user_from'];
                $user_to = $m['user_to'];
                $message = $m['message'];
 
                //get name and image of $user_form from `user` table
                $user = mysqli_query($conn, "SELECT uidUsers, userImg FROM users WHERE idUsers = '$user_form'");
                $user_fetch = mysqli_fetch_assoc($user);
                $user_form_username = $user_fetch['uidUsers'];
                $user_form_img = $user_fetch['userImg'];
 
                //display the message
                if ($user_form_username === $_SESSION['userUid']) 
                {
                    echo '<div class="outgoing_msg">
                            <div class="sent_msg">
                              <p>'.$message.'</p>
                            </div>
                          </div>';
                }
                else 
                {
                    echo '<div class="incoming_msg">
                            <div class="incoming_msg_img"> <img class="chat_people_inbox_img" src="uploads/'.$user_form_img.'"> </div>
                             <div class="received_msg">
                                <div class="received_withd_msg">
                                 <p>'.$message.'</p>
                                     <br>
                                </div>
                             </div>
                           </div>';
                }
                
 
            }
        }else{
            echo "<div class='text-center'>
                    <br>
                    <img src='img/empty.png' style='width:500px;'>
                </div>";
        }
    }
    
 
?>
<?php

    require("dbh.inc.php");
    //post message
    if(isset($_POST['message'])){
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $conversation_id = mysqli_real_escape_string($conn, $_POST['conversation_id']);
        $user_form = mysqli_real_escape_string($conn, $_POST['user_form']);
        $user_to = mysqli_real_escape_string($conn, $_POST['user_to']);
 
        //decrypt the conversation_id,user_from,user_to
        $conversation_id = base64_decode($conversation_id);
        $user_form = base64_decode($user_form);
        $user_to = base64_decode($user_to);
        
        
        
            $sql = "insert into messages(conversation_id, user_from, user_to, message) "
                    . "values (?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            //echo "--".$conversation_id."--".$user_form."--".$user_to."--".$message."--";
            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                echo "Error";
            }
            else
            {
                mysqli_stmt_bind_param($stmt, "ssss", $conversation_id, $user_form,
                       $user_to, $message);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                
                echo "Posted";
            }
    }
    else
    {
        echo "error";
    }
?>
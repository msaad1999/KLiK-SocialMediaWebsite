

$(document).ready(function(){
    
    /*post message via ajax*/
    $("#reply").on("click", function()
    {
        var message = $.trim($("#message").val()),
            conversation_id = $.trim($("#conversation_id").val()),
            user_form = $.trim($("#user_form").val()),
            user_to = $.trim($("#user_to").val()),
            error = $("#error");
 
        if((message != "") && (conversation_id != "") && (user_form != "") && (user_to != ""))
        {
            error.text("Sending...");
            $.post("includes/post_message_ajax.php",{message:message,conversation_id:conversation_id,user_form:user_form,user_to:user_to}, function(data){
                error.text(data);
                //clear the message box
                $("#message").val("");
            });
        }
    });
 
 
    //get message
    c_id = $("#conversation_id").val();
    
    //get new message every 2 second
    setInterval(function()
    {
        //$(".display-message").load("includes/get_message_ajax.php?c_id="+c_id);
        $(".msg_history").load("includes/get_message_ajax.php?c_id="+c_id);
    }, 500);
 
    $(".msg_history").scrollTop($(".msg_history")[0].scrollHeight);
});
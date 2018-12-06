<?php 
    define('TITLE',"Home | Franklin's Fine Dining");
    include 'includes/header.php';
?>


<h1>Create a Poll</h1>

<form id="contact-form" action="includes/create-poll.inc.php" method="post">
    
    <label for="title">Poll Title</label>
    <input type="text" name="title" id="title" placeholder="Add poll title"><br>
    
    <textarea id="desc" name="desc" placeholder="Optional Poll Description"></textarea>
    
    <label for="option">Poll Options</label>
    <div class="input_fields_wrap">
        <button class="add_field_button">Add More Fields</button>
        <div><input type="text" name="option[]" id="option" placeholder="poll option"><br>
        <input type="text" name="option[]" id="option" placeholder="poll option"></div>
    </div>
    
    <input type="checkbox" id="subscribe" name="is-locked" value="is-locked">
    <label for="subscribe">Make the Poll locked</label>
    <p>*The users will not be able to change their vote after casting it</p>
    
    <input type="submit" class="button next" name="poll-submit" value="Create Poll">
    
</form>

<a href="./poll-view.php" class="button previous">View Polls</a>


    <script>
        $(document).ready(function() {
            var max_fields      = 6; //maximum input boxes allowed
            var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                            x++; //text box increment
                            $(wrapper).append('<div><input type="text" name="option[]"\n\
                placeholder="poll option" id="option"><a href="#" class="remove_field">\n\Remove</a></div>'); //add input box
                    }
            });

            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
            })
        });
    </script>
    





<?php 
    include 'includes/footer.php';
?>
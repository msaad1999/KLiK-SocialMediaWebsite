<?php
    define('TITLE',"Create Topic | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (!isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }
?>


<div id="contact">
    <hr>

<?php
    $sql = "select cat_id, cat_name from categories;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../forum.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 0)
        {
            echo "<p class='closed'>You cannot create a topic before the admin creates "
            . "some categories</p>";
        }
        else
        {
?>

    <h1>Create Topic</h1>
    
    <?php
    
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyfields')
            {
                echo '<p class="closed">*Fill In All The Fields</p>';
            }
            else if ($_GET['error'] == 'sqlerror')
            {
                echo '<p class="closed">*Website Error: Contact admin to have the issue fixed</p>';
            }
        }
        else if (isset($_GET['operation']) == 'success')
        {
            echo '<p class="open">*Topic successfully created</p>';
        }
    ?>

    <form method="post" action="includes/create-topic.inc.php" id="contact-form">
    
    <label for="topic-subject">Subject</label>
    <input type="text" id="topic-subject" name="topic-subject">
    
    <label>Category</label>
    <select name="topic-cat" id="topic-cat">
    <?php 
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<option value='.$row['cat_id'].'>' . $row['cat_name'] . '</option>';
        }
    ?>
    </select>
    
    <label for="post-content">Message:</label>
    <textarea id="post-content" name="post-content"></textarea>
    
    <input type="submit" value="Create Topic" class="button next" name="create-topic">
    
</form>
<a href="./topics.php" class="button previous">View Topics</a>

    
<?php
        }
    }
?>


    <hr>
</div>
<?php include 'includes/footer.php'; ?>
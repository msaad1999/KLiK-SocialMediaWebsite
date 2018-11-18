<?php
    define('TITLE',"Create Category | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (!isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }
?>


<div id="contact">
    
    <h1>Create Category</h1>
    
    <?php
    
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyfields')
            {
                echo '<p class="closed">*Fill In All The Fields</p>';
            }
            else if ($_GET['error'] == 'catnametaken')
            {
                echo '<p class="closed">*A category with the given name already exists</p>';
            }
            else if ($_GET['error'] == 'sqlerror')
            {
                echo '<p class="closed">*Website Error: Contact admin to have the issue fixed</p>';
            }
        }
        else if (isset($_GET['catcreation']) == 'success')
        {
            echo '<p class="open">*Category successfully created</p>';
        }
    ?>
    
    <form method="post" action="includes/create-category.inc.php" id="contact-form">
    
        <label for="cat_name">Category Name</label>
        <input type="text" name="cat_name" />

        <label for="cat_description">Category Description</label>
        <textarea name="cat_description" /></textarea>

        <input type="submit" value="Add category" class="button next" name="create-cat">
    
    </form>
    
    <a href="./categories.php" class="button previous">View Categories</a>
    
</div>




<?php include 'includes/footer.php'; ?>
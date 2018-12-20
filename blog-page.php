<?php
    define('TITLE',"Blog | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (isset($_GET['blog']))
    {
        $blog = strip_bad_chars($_GET['blog']);
    }
?>

<hr>


<?php

    
    

    $sql = "select * from blogs where blog_id=?;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../blogs.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $blog);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $row = mysqli_fetch_assoc($result);
        echo "<h1>".$row['blog_title']."</h1>";
        echo "<p>".$row['blog_content']."</p>";        
    }

?>

<a href="./blogs.php" class="button previous">View Blogs</a>
<br>
<a href="./create-blog.php" class="button previous">Create a Blog</a>
<hr>

<?php include 'includes/footer.php'; ?>
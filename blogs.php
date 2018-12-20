<?php
    define('TITLE',"Blogs | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<hr>
<h1>Blogs</h1>

<?php

    $sql = "select * from blogs;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../blogs.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        echo "<table>"
                . "<thead>"
                    . "<tr>"
                        . "<th>Blog Title</th>"
                        . "<th>Blog Date</th>"
                    . "</tr>"
                . "</thead>"
                . "<tbody>";
        
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "<tr>"
                    . "<td>"
                        . "<a href='./blog.php?blog=".$row['blog_id']."'><p>".$row['blog_title']."</p></a>"
                    . "</td>"
                    . "<td>"
                        . "<p>".$row['blog_date']."</p>"
                    . "</td>"
                . "</tr>";;
        }
        
        echo "</tbody> </table>";
    }

?>

<a href="./create-blog.php" class="button previous">Create a Blog</a>
<hr>

<?php include 'includes/footer.php'; ?>
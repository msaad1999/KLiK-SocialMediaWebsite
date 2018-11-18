<?php
    define('TITLE',"Forum | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<hr>
<h1>Categories</h1>

<?php

    $sql = "select * from categories;";
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
        
        echo "<table>"
                . "<thead>"
                    . "<tr>"
                        . "<th>Category Name</th>"
                        . "<th>Category Description</th>"
                    . "</tr>"
                . "</thead>"
                . "<tbody>";
        
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "<tr>"
                    . "<td>"
                        . "<a href='./topics.php?cat=".$row['cat_id']."'><p>".$row['cat_name']."</p></a>"
                    . "</td>"
                    . "<td>"
                        . "<p>".$row['cat_description']."</p>"
                    . "</td>"
                . "</tr>";;
        }
        
        echo "</tbody> </table>";
    }

?>

<a href="./create-category.php" class="button previous">Create Category</a>
<hr>

<?php include 'includes/footer.php'; ?>
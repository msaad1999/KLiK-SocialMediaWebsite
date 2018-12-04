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
                        . "<th style='text-align: center'>Name</th>"
                        . "<th style='text-align: center'>Forums</th>"
                        . "<th style='text-align: center'>Description</th>";
        if ($_SESSION['userLevel'] == 1)
        {
            echo '<th></th>';
        }
        echo         "</tr>"
                . "</thead>"
                . "<tbody>";
        
        while ($row = mysqli_fetch_assoc($result))
        {
            $sql2 = 'select * from topics where topic_cat=?';
            mysqli_stmt_prepare($stmt, $sql2);
            mysqli_stmt_bind_param($stmt, "s", $row['cat_id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $num = mysqli_stmt_num_rows($stmt);
            
            echo "<tr>"
                    . "<td>"
                        . "<a href='./topics.php?cat=".$row['cat_id']."'><p>".$row['cat_name']."</p></a>"
                    . "</td>"
                    . "<td>"
                        . "<p style='text-align: center'>".$num."</p>"
                    . "</td>"
                    . "<td>"
                        . "<p>".$row['cat_description']."</p>"
                    . "</td>";
            if ($_SESSION['userLevel'] == 1)
            {
                echo "<td>"
                    . "<a href='includes/delete-category.php?id=".$row['cat_id']."' class='button previous'>Delete</a>"
                    . "</td>";
            }
            echo "</tr>";
        }
        
        echo "</tbody> </table>";
    }
    if ($_SESSION['userLevel'] == 1)
    {
        echo '<a href="./create-category.php" class="button previous">Create Category</a>';
    }
?>


<hr>

<?php include 'includes/footer.php'; ?>
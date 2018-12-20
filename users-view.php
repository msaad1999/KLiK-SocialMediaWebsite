<?php
    define('TITLE',"Forum | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<hr>
<h1>All Users</h1>

<?php

    $sql = "select * from users;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../categories.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        echo "<table>"
                . "<thead>"
                    . "<tr>"
                        . "<th style='text-align: center'>User</th>"
                        . "<th style='text-align: center'>Gender</th>"
                        . "<th style='text-align: center'>Full Name</th>"
                        . "<th style='text-align: center'>Email</th>";
        if ($_SESSION['userLevel'] == 1)
        {
            echo '<th></th>';
        }
        echo         "</tr>"
                . "</thead>"
                . "<tbody>";
        
        while ($row = mysqli_fetch_assoc($result))
        {
            /*$sql2 = 'select * from topics where topic_cat=?';
            mysqli_stmt_prepare($stmt, $sql2);
            mysqli_stmt_bind_param($stmt, "s", $row['uidUsers']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $num = mysqli_stmt_num_rows($stmt);*/
            
            echo "<tr>"
                    . "<td>"
                    . "<img id='userTh' id='userDp' src='./uploads/".$row['userImg']."'>"
                        . "<a href='./user-profile.php?user=".$row['idUsers']."'>".strtoupper($row['uidUsers'])."</a><br>";
                    if ($row['userLevel'] === 1)
                    {
                        echo ' <b>[Admin]</b> ';
                    }
            echo          '<br>'.$row['f_name'].' '.$row['l_name']."<br>"
                        . $row['emailUsers']   
                    . "</td>"
                    . "<td>"
                        . "<p style='text-align: center'>".strtoupper($row['gender'])."</p>"
                    . "</td>"
                    . "<td>"
                        
                    . "</td>";
            if ($_SESSION['userLevel'] == 1)
            {
                echo "<td>"
                    . "<a href='includes/delete-user.inc.php?user=".$row['idUsers']."' class='button previous'>Delete</a>"
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
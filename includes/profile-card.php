

            <div class='card card-profile text-center'>
                <img alt='' class='card-img-top card-user-cover' src='img/user-cover.png'>
                <div class='card-block'>
                    <a href='profile.php'>
                        <img src='uploads/<?php echo $_SESSION["userImg"] ?>' class='card-img-profile'>
                    </a>
                    <?php  
                        if ($_SESSION['userLevel'] == 1)
                        {
                            echo '<img id="card-admin-badge" src="img/admin-badge.png">';
                        }
                    ?>
                    <a href="edit-profile.php">
                        <i class="fa fa-pencil fa-2x edit-profile" aria-hidden="true"></i>
                    </a>
                    <h4 class='card-title'>
                    <?php echo ucwords($_SESSION['userUid']); ?>
                        <small class="text-muted">
                            <?php echo ucwords($_SESSION['f_name']." ".$_SESSION['l_name']); ?>
                        </small>
                        <br>
                        <small class="text-muted"><?php echo $_SESSION['headline']; ?></small>
                        <br><br><br>
                    </h4>
                </div>
            </div>
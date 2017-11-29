<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php"><div class="navbar-brand-logo"><img src="images/logos/white_transparent.png" alt="Friendalize Logo"><span>friendalize</span></div></a>
            <form class="form-inline form-search" method="post" action="search.php">
                <div class="input-group">
                    <input class="form-control form-input" name="search" id='search' type="text" placeholder="Search..." required/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-search" type="submit"><i class='fa fa-search fa-fw' aria-hidden="true"></i></button>
                        <button class="btn btn-default btn-close-search" type="button"><i class="fa fa-times fa-fw" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>          
            <a href="signout.php" class="navbar-toggle navbar-mobile" title="Sign Out"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i></a>
            <a href="notifications.php" class="navbar-toggle navbar-mobile" title="Notifications">
                <i class="fa fa-bell fa-fw" aria-hidden="true"></i>
                <?php
                if ($notifications_count > 0) {
                    echo "<span>" . $notifications_count . "</span>";
                }
                ?>
            </a>
            <a href="" class="navbar-toggle navbar-mobile navbar-mobile-search" title="Search"><i class='fa fa-search fa-fw' aria-hidden="true"></i></a></li>
            <a href="profile.php" class="navbar-toggle navbar-mobile" title="Profile"><img src="images/profiles/<?php echo $profile_pic; ?>" alt="Profile Pic"></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="profile.php" title="Profile"><div class="navbar-profile"><img src="images/profiles/<?php echo $profile_pic; ?>" alt="Profile Pic"><?php echo $first_name; ?></div></a></li>
                <li>
                    <a href="notifications.php" title="Notifications">
                        <i class="fa fa-bell fa-fw" aria-hidden="true"></i>
                        <?php
                        if ($notifications_count > 0) {
                            echo "<span>" . $notifications_count . "</span>";
                        }
                        ?>
                    </a>
                </li>                     
                <li><a href="signout.php" title="Sign Out"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i></a></li>
            </ul>
        </div>
    </div>
</nav>
<script>
    $(".navbar-mobile-search").click(function (e) {
        e.preventDefault();
        $(".form-search").css('display', 'list-item');
    });
    
    $(".btn-close-search").click(function (e) {
        $(".form-search").css('display', 'none');
    });
</script>
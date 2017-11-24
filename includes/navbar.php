<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php"><div class="navbar-brand-logo"><img src="images/logos/white_transparent.png" alt="Friendalize Logo"><span>friendalize</span></div></a>
            <a href="signout.php" class="navbar-toggle navbar-mobile" title="Sign Out"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i></a>
            <a href="notifications.php" class="navbar-toggle navbar-mobile" title="Notifications"><i class="fa fa-bell fa-fw" aria-hidden="true"></i></a>
            <a href="profile.php" class="navbar-toggle navbar-mobile" title="Profile"><img src="images/profiles/<?php echo $profile_pic; ?>.png" alt="Profile Pic"></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="profile.php" title="Profile"><div class="navbar-profile"><img src="images/profiles/<?php echo $profile_pic; ?>.png" alt="Profile Pic"><?php echo $first_name; ?></div></a></li>
                <li><a href="notifications.php" title="Notifications"><i class="fa fa-bell fa-fw" aria-hidden="true"></i></a></li>
                <li><a href="signout.php" title="Sign Out"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i></a></li>
            </ul>
        </div>
    </div>
</nav>
<?php
session_start();

if (!isset($_SESSION['first_login'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Get Started | Friendalize</title>
        <link href="styles/register.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <div class="navbar-fixed-top">
                <a href="signin.php"><div id="logo"><img src="images/logos/white_transparent.png" alt="Friendalize Logo">friendalize</div></a>
            </div>
        </div>
        <div class="container">
            <h1>Account Registration</h1>
            <h2>Step 3: Get Started</h2>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="33.3"
                     aria-valuemin="0" aria-valuemax="100" style="width:33.3%">
                    Personal Info
                </div>
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="33.3"
                     aria-valuemin="0" aria-valuemax="100" style="width:33.3%">
                    Institution
                </div>
                <div class="progress-bar progress-bar-active" role="progressbar" aria-valuenow="33.4"
                     aria-valuemin="0" aria-valuemax="100" style="width:33.4%">
                    Get Started
                </div>
            </div>
            <h4>Your registration is complete. We are very pleased and excited to welcome you to Friendalize!<br>Please select one of the options below to proceed...</h4>
            <a href="challenges.php" class="btn btn-option" role="button">
                <h4>Join a Challenge Room</h4>
                <div><span>Recommended</span></div>
                <p>Start your Friendalize experience now by clicking this button will throw you into a random challenge room. It's a great way to socialize!</p>
            </a>
            <a href="index.php" class="btn btn-option" role="button">
                <h4>Play Later</h4>
                <p>That's okay, you can always join one later!</p>
            </a>
        </div>
        <footer>
            <p>&#169; <?php echo date("Y"); ?> All Rights Reserved by LEAF.</p>
            <p>Terms & Conditions | Privacy Policy</p>
        </footer>
    </body>
</html>
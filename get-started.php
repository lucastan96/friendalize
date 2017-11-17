<?php
session_start();

//if (!isset($_SESSION['first_login'])) {
//    header("Location: index.php");
//    exit();
//}
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
            <div class="row">
                <div class="col-sm-6">
                    <div class="option">
                        <a href="" class="btn btn-option" role="button">
                            <h3>Join a Challenge Room (Recommended)</h3>
                            <p></p>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="option">
                        <a href="" class="btn btn-option" role="button">
                            <h3>Play Later</h3>
                            <p></p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
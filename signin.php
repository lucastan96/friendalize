<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($message)) {
    $username = "";
    $password = "";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Sign In | Friendalize</title>
        <link href="styles/signin.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-7 col-intro">
                    <div id="logo"><img src="images/logos/white_transparent.png" alt="Friendalize Logo">friendalize</div>
                    <div class="images">
                        <div class='col-sm-7 col-img'>
                            <img id="img-signin-1" src='images/signin/signin_1.png' alt='Clubbing'>
                            <div class='col-sm-5 col-img'>
                                <img id="img-signin-2" src='images/signin/signin_2.png' alt='Fruits'>
                            </div>
                            <div class='col-sm-7 col-img'>
                                <img id="img-signin-3" src='images/signin/signin_3.png' alt='Football'>
                            </div>
                        </div>
                        <div class='col-sm-5 col-img'>
                            <img id="img-signin-4" src='images/signin/signin_4.png' alt='Lagos, Portugal'>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-signin">
                    <a href="register.php" class="btn btn-register btn-desktop" role="button">Join Us Today<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                    <h1>Sign In</h1>
                    <form class="form-horizontal" action="signin-p.php" method="post">
                        <?php
                        if (isset($message)) {
                            echo "<div id='message'>" . $message . "</div>";
                        }
                        ?>
                        <div class="form-group">
                            <input class="form-control form-input" type="text" name="username" id="username" value="<?php echo $username; ?>" placeholder="Username" required autofocus>
                        </div>
                        <div class="form-group">
                            <input class="form-control form-input" type="password" name="password" id="password" value="<?php echo $password; ?>" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-signin" type="submit">Sign In<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </div>
                    </form>
                    <span id="or">OR</span>
                    <a href="register.php" class="btn btn-register btn-mobile" role="button">Join Us Today<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                    <footer>
                        <p>&#169; <?php echo date("Y"); ?> All Rights Reserved by LEAF.</p>
                        <p>Terms & Conditions | Privacy Policy</p>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
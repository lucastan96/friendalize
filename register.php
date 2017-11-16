<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Register | Friendalize</title>
        <link href="styles/register.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <div class="navbar-fixed-top">
                <a href="index.php"><div id="logo"><img src="images/logos/white_transparent.png" alt="Friendalize Logo">friendalize</div></a>
            </div>
        </div>
        <div class="container">
            <form action="register-p.php" method="post">
                <div class="row cols">
                    <div class="col-sm-6">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" name="email" class="form-control no-border input" placeholder="Please enter your email address" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                        
                        <label for="first_name" class="sr-only">First Name</label>
                        <input type="text" name="first_name" class="form-control no-border input" placeholder="Please enter your first Name" required>
                        
                        <label for="last_name" class="sr-only">Last Name</label>
                        <input type="text" name="last_name" class="form-control no-border input" placeholder="Please enter your last name" required>
                        
                        <label for="age" class="sr-only">Age</label>
                        <input type="number" name="age" class="form-control no-border input" placeholder="Please enter your age" required>
                        
                        <label for="country" class="sr-only">Country</label>
                        <select class="form-control no-border input" name="country" required>
                            <option value="" selected="selected">Please select a Country</option>
                        </select>
                        
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="registerpassword" class="form-control no-border input" placeholder="Please enter your password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                       
                        <label for="password_confirm" class="sr-only">Confirm Password</label>
                        <input type="password" name="password_confirm" class="form-control no-border input" placeholder="Please confirm your password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Please enter the same password">
                        <button class="btn btn-default no-border submit" type="submit">PROCEED</button>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
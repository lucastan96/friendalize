<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once('includes/connection.php');
require_once('includes/functions.php');

$countries_array = get_countries($db);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Account Registration | Friendalize</title>
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
            <h2>Step 1: Enter Your Personal Info</h2>
            <div class="progress">
                <div class="progress-bar progress-bar-active" role="progressbar" aria-valuenow="33.3"
                     aria-valuemin="0" aria-valuemax="100" style="width:33.3%">
                    Personal Info
                </div>
                <div class="progress-bar progress-bar-inactive" role="progressbar" aria-valuenow="33.3"
                     aria-valuemin="0" aria-valuemax="100" style="width:33.3%">
                    Institution
                </div>
                <div class="progress-bar progress-bar-inactive" role="progressbar" aria-valuenow="33.4"
                     aria-valuemin="0" aria-valuemax="100" style="width:33.4%">
                    Get Started
                </div>
            </div>
            <form class="form-horizontal" action="register-p.php" method="post">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="username">Username:</label>
                            <div class="col-sm-8">
                                <input class="form-control form-input" type="text" id="username" name="username" placeholder="Enter your username" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Email:</label>
                            <div class="col-sm-8">
                                <input class="form-control form-input" type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Enter your email address" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password">Password:</label>
                            <div class="col-sm-8">
                                <input class="form-control form-input" type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Enter your password" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password_confirm">Confirm Password:</label>
                            <div class="col-sm-8">
                                <input class="form-control form-input" type="password" id="password_confirm" name="password_confirm" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Confirm your password" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="first_name">First Name:</label>
                            <div class="col-sm-8">
                                <input class="form-control form-input" type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="last_name">Last Name:</label>
                            <div class="col-sm-8">
                                <input class="form-control form-input" type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="age">Age:</label>
                            <div class="col-sm-8">
                                <input class="form-control form-input" type="number" id="age" name="age" placeholder="Enter your age" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="country">Country:</label>
                            <div class="col-sm-8">
                                <select class="form-control form-select" id="country" name="country" required>
                                    <option value="" selected="selected">Select your country</option>
                                    <?php foreach ($countries_array as $countries) : ?>
                                        <option value="<?php echo $countries['country_id']; ?>"><?php echo htmlspecialchars($countries['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button class="btn btn-submit" type="submit">Continue<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
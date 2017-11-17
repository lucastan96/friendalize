<?php
session_start();

//if (!isset($_SESSION['user_id'])) {
//    header("Location: signin.php");
//    exit();
//}

require_once('includes/connection.php');
require_once('includes/functions.php');

$institutions_array = get_institutions($db);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Select Your Institution | Friendalize</title>
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
            <h2>Step 2: Select Your Institution</h2>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="33.3"
                     aria-valuemin="0" aria-valuemax="100" style="width:33.3%">
                    Personal Info
                </div>
                <div class="progress-bar progress-bar-active" role="progressbar" aria-valuenow="33.3"
                     aria-valuemin="0" aria-valuemax="100" style="width:33.3%">
                    Institution
                </div>
                <div class="progress-bar progress-bar-inactive" role="progressbar" aria-valuenow="33.4"
                     aria-valuemin="0" aria-valuemax="100" style="width:33.4%">
                    Get Started
                </div>
            </div>
            <form class="form-horizontal" action="setup-institution-p.php" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="institution">Institution:</label>
                    <div class="col-sm-10">
                        <select class="form-control form-select" id="institution" name="institution" required>
                            <option value="" selected="selected">Select your institution</option>
                            <?php foreach ($institutions_array as $institutions) : ?>
                                <option value="<?php echo $instituions['institution_id']; ?>"><?php echo htmlspecialchars($institutions['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
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
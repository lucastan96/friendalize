<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');

    $countries_array = get_countries($db);
    $institutions_array = get_institutions($db);
    $interests_array = get_interests($db);
    
    $user_settings_array = get_user_settings($db, $_SESSION['user_id']);
    $institution = get_user_institution($db, $_SESSION['user_id']);
    $interest_ids = get_user_interests_settings($db, $_SESSION['user_id']);
    
    $user_interests = explode(",", $interest_ids);
    
    foreach ($user_settings_array as $user_settings):
        $first_name = $user_settings["first_name"];
        $last_name = $user_settings["last_name"];
        $age = $user_settings["age"];
        $gender = $user_settings["gender"];
        $country_id = $user_settings["country_id"];
    endforeach;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Settings | Friendalize</title>
        <link href="scripts/lou-multi-select/css/multi-select.dist.css" rel="stylesheet">
        <link href="styles/settings.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <h1>Settings</h1>
                    <h2 class="description">Personalize your profile and personal details here.</h2>
                    <form action="settings-p.php" method="post">
                        <div class="form-group">
                            <label class="control-label" for="first_name">First Name:</label>
                            <input class="form-control form-input" type="text" id="first_name" name="first_name" placeholder="Enter your first name" value="<?php echo $first_name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="last_name">Last Name:</label>
                            <input class="form-control form-input" type="text" id="last_name" name="last_name" placeholder="Enter your last name" value="<?php echo $last_name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="age">Age:</label>
                            <input class="form-control form-input" type="number" id="age" name="age" placeholder="Enter your age" value="<?php echo $age; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="gender">Gender:</label>
                            <select class="form-control form-select" id="gender" name="gender" required>
                                <option value="">Select your gender</option>
                                <option value="1" <?php if ($gender == "Male") {echo "selected"; } ?>>Male</option>
                                <option value="2" <?php if ($gender == "Female") {echo "selected"; } ?>>Female</option>
                                <option value="3" <?php if ($gender == "Other") {echo "selected"; } ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="country">Country:</label>
                            <select class="form-control form-select" id="country" name="country" required>
                                <option value="">Select your country</option>
                                <?php foreach ($countries_array as $countries) : ?>
                                    <option value="<?php echo $countries['country_id']; ?>" <?php if ($countries["country_id"] == $country_id) {echo "selected"; } ?>><?php echo htmlspecialchars($countries['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="institution">Institution:</label>
                            <select class="form-control form-select" id="institution" name="institution" required>
                                <option value="">Select your institution</option>
                                <?php foreach ($institutions_array as $institutions) : ?>
                                    <option value="<?php echo $institutions['institution_id']; ?>" <?php if ($institutions["institution_id"] == $institution_id) {echo "selected"; } ?>><?php echo htmlspecialchars($institutions['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="interests">Interests:</label>
                            <select class="form-control form-select" multiple="multiple" id="interests" name="interests[]">
                                <?php foreach ($interests_array as $interests) : ?>
                                    <option value="<?php echo $interests['interest_id']; ?>" <?php if (in_array($interests["interest_id"], $user_interests)) {echo "selected"; } ?>><?php echo htmlspecialchars($interests['name']); ?></option>
                                <?php endforeach; ?>
                            </select>

                        <div class="form-group">
                            <button class="btn btn-submit" type="submit">Save<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </div>
                    </form>
					 <h1>Change Password Details</h1>
                    <form action="update_password.php" method ="post">
                        <div class="form-group">
                            <label class="control-label" for="password">Password:</label>
                            <input class="form-control form-input" type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Enter new password" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" >
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password_confirm">Confirm Password:</label>
                            <input class="form-control form-input" type="password" id="password_confirm" name="password_confirm" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Confirm new password" >
                        </div>
                        <div class="form-group">
                            <button class="btn btn-submit" type="submit">Save<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="scripts/lou-multi-select/js/jquery.multi-select.js"></script>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(6)').addClass("nav-active");
                $('.nav-mobile a:nth-child(6)').addClass("nav-active");
            });

            $('#interests').multiSelect({
                selectableHeader: "<div class='select-header'>Choose</div>",
                selectionHeader: "<div class='select-header'>Your Interests</div>"
            });

            var width = $('.nav-mobile a:nth-child(1)').width() + $('.nav-mobile a:nth-child(2)').width() + $('.nav-mobile a:nth-child(3)').width() + $('.nav-mobile a:nth-child(4)').width() + $('.nav-mobile a:nth-child(5)').width();
            $('.nav-mobile').scrollLeft(width);
        </script>
    </body>
</html>
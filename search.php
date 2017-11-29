<?php
$search = filter_input(INPUT_GET, 'query');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');

    if ($search != "") {
        $result_users = search_users($db, $search, $_SESSION["user_id"]);
        $search_description = sizeof($result_users) . " person found with the query '" . $search . "'.";
    } else {
        $search_description = "Find Friendalizers using the search function above you!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Search | Friendalize</title>
        <link href="styles/search.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <h1>Search</h1>
                    <h2 class="description"><?php echo $search_description; ?></h2>
                    <div class='users-list'>
                        <div class='row'>
                            <?php
                            foreach ($result_users as $result_user):
                                $user_id = $result_user["user_id"];
                                $user_profile_pic = $result_user["profile_pic"];
                                $user_first_name = $result_user["first_name"];
                                $user_last_name = $result_user["last_name"];

                                $user_institution = get_user_institution($db, $user_id);
                                $user_interests = get_user_interests($db, $user_id);

                                if ($user_interests == "") {
                                    $user_interests = "No interests yet";
                                }
                                ?>
                                <div class='col'>
                                    <a href="profile.php?id=<?php echo $user_id; ?>" class='users-list-item-link'>
                                        <div class="users-list-item-container">
                                            <img src="images/profiles/<?php echo $user_profile_pic; ?>">
                                            <div class='users-list-item-info'>
                                                <div class="users-list-name"><?php echo $user_first_name . " " . $user_last_name; ?></div>
                                                <p><?php echo $user_institution; ?></p>
                                                <p><?php echo $user_interests; ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <script src="scripts/viewport-resize.js"></script>
        <script>
            var query = "<?php echo $search; ?>";

            if (query != "") {
                $("#query").val(query);
            }
        </script>
    </body>
</html>
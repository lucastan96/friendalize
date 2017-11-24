<?php

function get_countries($db) {
    $query = "SELECT country_id, name FROM countries";
    $statement = $db->prepare($query);
    $statement->execute();
    $countries_array = $statement->fetchAll();
    $statement->closeCursor();

    return $countries_array;
}

function get_institutions($db) {
    $query = "SELECT institution_id, name FROM institutions GROUP BY name";
    $statement = $db->prepare($query);
    $statement->execute();
    $institutions_array = $statement->fetchAll();
    $statement->closeCursor();

    return $institutions_array;
}

function get_interests($db) {
    $query = "SELECT interest_id, name FROM interests GROUP BY name";
    $statement = $db->prepare($query);
    $statement->execute();
    $interests_array = $statement->fetchAll();
    $statement->closeCursor();

    return $interests_array;
}

function get_institution_id($db, $user_id) {
    $query = "SELECT institution_id FROM user_institutions WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $results_array = $statement->fetch();
    $statement->closeCursor();

    $institution_id = $results_array["institution_id"];

    return $institution_id;
}

function get_profile_pic($db, $user_id) {
    $query = "SELECT profile_pic FROM users WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $results_array = $statement->fetch();
    $statement->closeCursor();

    $profile_pic = $results_array["profile_pic"];

    return $profile_pic;
}

function get_first_name($db, $user_id) {
    $query = "SELECT first_name FROM users WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $results_array = $statement->fetch();
    $statement->closeCursor();

    $first_name = $results_array["first_name"];

    return $first_name;
}

function get_user_details($db, $user_id) {
    $query = "SELECT email, last_name, gender, age, country_id, DATE(join_date) FROM users WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $user_details_array = $statement->fetchAll();
    $statement->closeCursor();

    return $user_details_array;
}

function get_user_country($db, $country_id) {
    $query = "SELECT name FROM countries WHERE country_id = :country_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":country_id", $country_id);
    $statement->execute();
    $results_array = $statement->fetch();
    $statement->closeCursor();

    $country = $results_array["name"];

    return $country;
}

function get_user_institution($db, $user_id) {
    $query = "SELECT i.name FROM user_institutions u, institutions i WHERE u.user_id = :user_id AND u.institution_id = i.institution_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $results_array = $statement->fetch();
    $statement->closeCursor();

    $institution = $results_array["name"];

    return $institution;
}

function get_user_interests($db, $user_id) {
    $query1 = "SELECT interests FROM user_interests WHERE user_id = :user_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":user_id", $user_id);
    $statement1->execute();
    $results_array1 = $statement1->fetch();
    $statement1->closeCursor();

    $interest_ids = $results_array1["interests"];
    $interests_array = explode(",", $interest_ids);

    $interests = [];

    for ($i = 0; $i < sizeof($interests_array); $i++) {
        $query2 = "SELECT name FROM interests WHERE interest_id = :interest_id";
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(":interest_id", $interests_array[$i]);
        $statement2->execute();
        $results_array2 = $statement2->fetch();
        $statement2->closeCursor();

        array_push($interests, $results_array2["name"]);
    }

    sort($interests);
    $interests_str = implode(", ", $interests);

    return $interests_str;
}

function get_user_settings($db, $user_id) {
    $query = "SELECT first_name, last_name, gender, age, country_id FROM users WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $user_settings_array = $statement->fetchAll();
    $statement->closeCursor();

    return $user_settings_array;
}

function get_user_interests_settings($db, $user_id) {
    $query = "SELECT interests FROM user_interests WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $user_interests_array = $statement->fetch();
    $statement->closeCursor();
    
    $interest_ids = $user_interests_array["interests"];

    return $interest_ids;
}

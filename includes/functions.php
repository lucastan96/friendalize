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
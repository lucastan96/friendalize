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
    $institution_id_array = $statement->fetch();
    $statement->closeCursor();
    
    $institution_id = $institution_id_array["institution_id"];
    
    return $institution_id;
}
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
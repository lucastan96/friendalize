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
    $query = "SELECT interest_id, name FROM interests WHERE interest_id != 1 GROUP BY name";
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
    $query = "SELECT email, first_name, last_name, gender, age, country_id, DATE(join_date), profile_pic FROM users WHERE user_id = :user_id";
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

function get_rooms($db) {
    $query = 'SELECT * FROM ghost_room';
    $statement = $db->prepare($query);
    $statement->execute();
    $rooms = $statement->fetchAll();
    $statement->closeCursor();

    return $rooms;
}

function get_room_players($db, $room_id) {
    $query = 'SELECT user_id FROM ghost_room_players WHERE room_id = :room_id';
    $statement = $db->prepare($query);
    $statement->execute(array(":room_id" => $room_id));
    $users = $statement->fetchAll();
    $statement->closeCursor();

    return $users;
}

function get_room_player_info($db, $user_id) {
    $query = "SELECT first_name, last_name, profile_pic FROM users WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closeCursor();

    return $results;
}

function check_is_joined($db, $room_id, $user_id) {
    $query = 'SELECT COUNT(*) as is_joined FROM ghost_room_players WHERE room_id = :room_id AND user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->execute(array(":room_id" => $room_id, ":user_id" => $user_id));
    $results = $statement->fetch();
    $statement->closeCursor();

    if ($results["is_joined"] == 1) {
        return true;
    }

    return false;
}

function get_friend_status($db, $user_id, $friend_id) {
    $query1 = "SELECT friends FROM user_friends WHERE user_id = :user_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":user_id", $user_id);
    $statement1->execute();
    $results_array1 = $statement1->fetch();
    $statement1->closeCursor();

    $friend_ids = $results_array1["friends"];
    $friends_array = explode(",", $friend_ids);

    if (in_array($friend_id, $friends_array)) {
        return true;
    }

    return false;
}

function get_friend_count($db, $user_id) {
    $query = 'SELECT friends FROM user_friends WHERE user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->execute(array(":user_id" => $user_id));
    $results = $statement->fetch();
    $statement->closeCursor();

    $friend_ids = $results["friends"];

    if ($friend_ids != NULL) {
        $friends_array = explode(",", $friend_ids);
        return sizeof($friends_array);
    }

    return 0;
}

function get_friends($db, $user_id) {
    $query = 'SELECT friends FROM user_friends WHERE user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->execute(array(":user_id" => $user_id));
    $results = $statement->fetch();
    $statement->closeCursor();

    $friend_ids = $results["friends"];

    if ($friend_ids != NULL) {
        $friends = explode(",", $friend_ids);
        return $friends;
    }

    return NULL;
}

function get_user_request_status($db, $user_id, $friend_id) {
    $query1 = "SELECT requests FROM user_friends WHERE user_id = :user_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":user_id", $user_id);
    $statement1->execute();
    $results_array1 = $statement1->fetch();
    $statement1->closeCursor();

    $request_ids = $results_array1["requests"];
    $requests_array = explode(",", $request_ids);

    if (in_array($friend_id, $requests_array)) {
        return true;
    }

    return false;
}

function get_friend_request_status($db, $user_id, $friend_id) {
    $query1 = "SELECT requests FROM user_friends WHERE user_id = :user_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":user_id", $friend_id);
    $statement1->execute();
    $results_array1 = $statement1->fetch();
    $statement1->closeCursor();

    $request_ids = $results_array1["requests"];
    $requests_array = explode(",", $request_ids);

    if (in_array($user_id, $requests_array)) {
        return true;
    }

    return false;
}

function get_all_users($db) {
    $query = "SELECT user_id FROM users";
    $statement = $db->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();

    return $users;
}

function check_friend_requests($db, $user_id) {
    $query = "SELECT * FROM user_friends";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();

    $requested_ids = [];

    foreach ($results as $result):
        $stranger_id = $result["user_id"];
        $request_ids = $result["requests"];
        $requests_array = explode(",", $request_ids);

        if (in_array($user_id, $requests_array)) {
            array_push($requested_ids, $stranger_id);
        }
    endforeach;

    return $requested_ids;
}

function get_id($db, $user_id) {
    $query1 = "SELECT * FROM users WHERE user_id = :user_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":user_id", $user_id);
    $statement1->execute();
    $user = $statement1->fetch();
    $statement1->closeCursor();

    return $user;
}

function get_post_user_info($db, $user_id) {
    $query = "SELECT first_name, last_name, profile_pic FROM users WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closeCursor();

    return $results;
}

function get_post_category($db, $category_id) {
    $query = "SELECT name FROM interests WHERE interest_id = :interest_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":interest_id", $category_id);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closeCursor();
    
    return $results["name"];
}

function get_post_likes_count($db, $post_id) {
    $query = 'SELECT likes FROM posts WHERE post_id = :post_id';
    $statement = $db->prepare($query);
    $statement->execute(array(":post_id" => $post_id));
    $results = $statement->fetch();
    $statement->closeCursor();

    $likes = $results["likes"];

    if ($likes != NULL) {
        $likes_array = explode(",", $likes);
        return sizeof($likes_array);
    }

    return 0;
}

function get_post_like_status($db, $post_id, $user_id) {
    $query = 'SELECT likes FROM posts WHERE post_id = :post_id';
    $statement = $db->prepare($query);
    $statement->execute(array(":post_id" => $post_id));
    $results = $statement->fetch();
    $statement->closeCursor();

    $likes = $results["likes"];

    if ($likes != NULL) {
        $likes_array = explode(",", $likes);
        
        if (in_array($user_id, $likes_array)) {
            return 1;
        }
    }

    return 0;
}

function search_for_users($db,$user_id,$searchq) {
    $query = "SELECT  user_id,first_name,last_name FROM users WHERE first_name LIKE '%$searchq%' OR last_name LIKE '%$searchq%'";
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $search = $statement->fetchAll();
    $statement->closeCursor();
    return $search;
}

function count_notifications($db) {
    $sql = 'SELECT COUNT(*) FROM post_comments WHERE status = 0';
    $res = $db->prepare($sql);
    $res->execute();
    $count = $res->fetchColumn();
    return $count;
}

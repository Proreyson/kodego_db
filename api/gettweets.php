<?php

include "config.php";

$sql = "SELECT * FROM users JOIN tweets ON users.id = tweets.users_id ORDER BY users.id DESC";

$results = $conn->query($sql);

if ($results->num_rows > 0) {

    $posts = array();

    while ($row = $results->fetch_assoc()) {
        $todo = array(
            'id' => $row['id'],
            'content' => $row['content'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
        );
        $tweets[] = $todo;
    }

    $json = json_encode($tweets);
    header('Content-Type: application/json');
    echo $json;

} else {
    echo "No tweets found.";
}

?>
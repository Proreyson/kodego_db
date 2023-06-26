<?php

include 'config.php';

session_unset();
session_destroy();

$response = array(
    'success' => true,
    'message' => 'You have logged out successfully!'
);

echo json_encode($response);


?>
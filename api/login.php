<?php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    $email = $data['email'];
    $password = $data['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {

            $response = array(

                'success' => true,
                'message' => 'You Logged In Successfully!'

            );

            echo json_encode($response);

        } else {


            $response = array(

                'success' => false,
                'message' => 'Incorrect Password!'

            );

            echo json_encode($response);

        }

    } else {


        $response = array(

            'success' => false,
            'message' => 'Account Not Found'

        );

        echo json_encode($response);

    }

}

?>
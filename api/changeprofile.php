<?php

include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $email = $data['email'];
    $birthdate = $data['birthdate'];
    $password = $data['password'];
    $confirm_password = $data['confirm_password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if ($password === $confirm_password) {

            if (password_verify($password, $hashedPassword)) {


                $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', birthdate = '$birthdate' WHERE email = '$email'";

                if ($connect->query($sql)) {

                    $response = array(
                        'success' => true,
                        'message' => 'Profile Update Successfully'
                    );

                    echo json_encode($response);

                }



            }

        } else {

            $response = array(
                'success' => false,
                'message' => 'Passwords do not matched!'
            );

            echo json_encode($response);

        }



    }

} else {

    $response = array(
        'success' => false,
        'message' => 'Only Post request is allowed'
    );

    echo json_encode($response);

}

?>
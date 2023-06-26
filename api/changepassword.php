<?php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    $email = $data['email'];
    $password = $data['password'];
    $new_password = $data['new_password'];
    $confirm_password = $data['confirm_password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {

            if ($new_password === $confirm_password) {

                $new_password = password_hash($new_password, PASSWORD_DEFAULT);

                $sql = "UPDATE users SET password = '$new_password' WHERE email = '$email'";

                if ($connect->query($sql)) {

                    $response = array(
                        'success' => true,
                        'message' => 'Password Updated Successfully'
                    );

                    echo json_encode($response);

                }
            } else {


                $response = array(
                    'success' => false,
                    'message' => "New Password Doesn't Matched! "
                );

                echo json_encode($response);

            }

        } else {


            $response = array(
                'success' => false,
                'message' => 'Incorrect Password!'
            );

            echo json_encode($response);

        }

    }

} else {

    echo "only POST request is allowed!";

}

?>
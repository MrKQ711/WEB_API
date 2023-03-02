<?php

    ini_set('display_errors', 1);
    // include headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");


    // include database.php
    include_once ("../config/database.php");
    // include student.php
    include_once ("../classes/student.php");

    // create object of Database class
    $db = new Database();

    $connection = $db->connect();

    // create object of Student class
    $student = new Student($connection);

    if ($_SERVER['REQUEST_METHOD'] === "GET") {

        $data = $student->get_all_data();

        if ($data->num_rows > 0) {
            $student_array = array();
            $student_array['data'] = array();

            while ($row = $data->fetch_assoc()) {
                $student_item = array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "email" => $row['email'],
                    "mobile" => $row['mobile'],
                    "status" => $row['status'],
                    "created_at" => date("d-m-Y h:i:s A", strtotime($row['created_at']))
                );
                array_push($student_array['data'], $student_item);
            }

            // set response code
            http_response_code(200); // 200 means ok
            // display message
            echo json_encode(array("status" => 1, "message" => "Data found", "data" => $student_array));
        } else {
            // set response code
            http_response_code(404); // 404 means not found
            // display message
            echo json_encode(array("status" => 0, "message" => "No data found"));
        }
    } else {
        // set response code
        http_response_code(503); // 503 means service unavailable
        // display message
        echo json_encode(array("status" => 0, "message" => "Access denied"));
    }

?>
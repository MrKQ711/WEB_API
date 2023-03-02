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

    if($_SERVER['REQUEST_METHOD'] === "GET") {
            
            $student_id = isset($_GET['id']) ? intval($_GET['id']) : "";
    
            if(!empty($student_id)){
                $student->id = $student_id;
                if($student->delete_student()){
                    // set response code
                    http_response_code(200); // 200 means ok
                    // display message
                    echo json_encode(array("status" => 1, "message" => "Data deleted successfully"));
                } else {
                    // set response code
                    http_response_code(500); // 500 means internal server error
                    // display message
                    echo json_encode(array("status" => 0, "message" => "Failed to delete data"));
                }
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
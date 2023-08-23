<?php
require_once "db_connect.php";

if(isset($_POST['attemptSignup'])) {
    // take inputs
    $username = $_POST['username_email'] ?? "";
    $password = $_POST['password'] ?? "";
    $email = "Doe@gmail.com";

    // create error variables and set them to false initially
    $error_username = ["chars_length" => false, "only_chars_numbers" => false];
    $error_password = ["chars_length" => false, "atleast_1_char" => false, "atleast_1_number" => false, "at_least_1_symbol" => false];
    $username_errors_items = $password_errors_items = "";

    /* VALIDATION */

    // username at least 8 chars long + can be characters and numbers only
    if (strlen($username) < 8) {
        $error_username["chars_length"] = true; // username should be at least 8 chars long
        $username_errors_items .= "<li>Username length should be at least 8 characters.</li>";
    }
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $error_username["only_chars_numbers"] = true; // username should only contain characters and numbers
        $username_errors_items .= "<li>Username can only contain characters and numbers.</li>";
    }

    // password can be anything, just 8 chars long, should have 1 number, 1 special symbol, 1 character
    if (strlen($password) < 8) {
        $error_password["chars_length"] = true; // password should be at least 8 chars long
        $password_errors_items .= "<li>Password length should be at least 8 characters.</li>";
    }
    if (!preg_match('/\d/', $password)) {
        $error_password["atleast_1_number"] = true; // password should have at least 1 number
        $password_errors_items .= "<li>Password should have at least 1 number.</li>";
    }
    if (!preg_match('/[a-zA-Z]/', $password)) {
        $error_password["atleast_1_char"] = true; // password should have at least 1 character
        $password_errors_items .= "<li>Password should have at least 1 character.</li>";
    }
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        $error_password["atleast_1_symbol"] = true; // password should have at least 1 symbol
        $password_errors_items .= "<li>Password should have at least 1 symbol.</li>";
    }


    // if all checks passed, carry on and create account
    if(!in_array(true, $error_username) && !in_array(true, $error_password)) {
        // check if same username exists before or not
        $query = "SELECT * FROM accounts WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) { // if username already exists
            $username_errors_items .= "<li>Username already exists.</li>";
        }
        else {
            // sql create account
            $query = "INSERT INTO accounts (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $username, $email, $password_param);
            $password_param = password_hash($password, PASSWORD_DEFAULT);
            if ($stmt->execute()) {
                // echo "Data inserted successfully.";
            } else {
                // echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
    else{
        // return list items for each error box
        
    }

    die(json_encode(["errors_username_email" => $username_errors_items, "errors_password" => $password_errors_items]));
          
   
}
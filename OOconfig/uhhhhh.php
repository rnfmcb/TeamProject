<?php
/**
 * Created by PhpStorm.
 * User: mlind
 * Date: 7/10/2018
 * Time: 9:29 PM
 */

require_once 'DB_Func.php';
$db = new DB_Func();

$response['error'] = true;

if (isset($_POST['password']) && isset($_POST['email'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $db->getUserByEmailAndPassword($email, $password);

    if ($user){
        $response['uniqueID'] = $user['uniqueID'];
        $response['firstName'] = $user['firstName'];
        $response['lastName'] = $user['lastName'];
        $response['desiredUsername'] = $user['desiredUsername'];
        $response['mobileNumber'] = $user['mobileNumber'];
        $response['email'] = $user['email'];
        // $response['createdAt'] = $user['createdAt'];
        $response['photoStorage'] = $user['photoStorage'];
        $response['error'] = FALSE;
        $response['message'] = "Login Successful";
    }else {
        $response['error'] = TRUE;
        $response['message'] = "Could not retrieve user";
    }
    echo json_encode($response);


}


?>
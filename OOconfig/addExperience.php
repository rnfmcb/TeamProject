<?php


require_once 'DB_Func.php';
$db = new DB_Func();


$response = array("error" => FALSE);

if (isRequiredParametersSet()) {

//
//
//    $experience['expID'] = $expID;
//    $experience['category'] = $category;
//    $experience['date'] = $date;
//    $experience['hours'] = $hours;
//    $experience['description'] = $description;
//    $experience['organization'] = $organization;
//    $experience['verified'] = $verified;


    $category = $_POST['category'];
    $date = $_POST['date'];
    $hours = $_POST['hours'];
    $description = $_POST['description'];
    $organization = $_POST['organization'];
    $verified = $_POST['verified'];


    // $user = $db->getUserByEmailAndPassword($email, $password);
    $experience = $db->storeExperience( $category, $date, $hours, $description, $organization, $verified);

    if ($experience) {
        $response['error'] = FALSE;
        $response['message'] = "Successful Addition";
    } else {
        $response['error'] = TRUE;
    }
    echo json_encode($response);

} else {
    $response['message'] = "parameters not set";
    echo json_encode($response);
}

function isRequiredParametersSet()
{


    if (
        isset( $_POST['category'] ) &&
        isset( $_POST['date'] ) &&
        isset( $_POST['hours'] ) &&
        isset( $_POST['description'] ) &&
        isset( $_POST["organization"] )&&
        isset( $_POST['verified'] )

    )
    {
        return true;
    }

    else
        return false;

}



?>
<?php


require_once 'DB_Func.php';
$db = new DB_Func();


$response = array("error" => FALSE);

if (isRequiredParametersSet()) {


    $students = $_POST['students'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $hours = $_POST['hours'];
    $description = $_POST['description'];
    $organization = $_POST['organization'];
    $verified = $_POST['verified'];


    // $user = $db->getUserByEmailAndPassword($email, $password);
    $experience = $db->storeExperience( $title ,$category, $date, $hours, $description, $organization, $verified);

    if ($experience) {
        $response['error'] = FALSE;
        $response['message'] = "Successful Addition";
    } else {
        $response['error'] = TRUE;
    }
    echo json_encode($response);

    $studentList = parseStudents($students);
    $num = count($studentList);
    echo $experience['expID'];
    foreach ($studentList as $student ){
        $db->storeStudentExperience( $experience['expID'], $student );
    }


} else {
    $response['message'] = "parameters not set";
    echo json_encode($response);





}
////mock list - need add function
function parseStudents( $students ){
    $studentList = array();
    $val1 = 'dmld54';
    $val2  = 'tjs27f';
    $val3 = 'tsp4b';
    $val4 = 'rnfmcb';
    array_push($studentList, $val1, $val2, $val3, $val4  );
    return $studentList;
}

function isRequiredParametersSet()
{
    if (
        isset( $_POST['students'] ) &&
        isset( $_POST['title'] ) &&
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
<?php


require_once 'DB_Func.php';
$db = new DB_Func();


$response = array("error" => FALSE);

if (isRequiredParametersSet()) {


    $verified = $_POST['teacher'];
    $students = $_POST['students'];
    $category = $_POST['category'];
    $title = $_POST['title'];
    $organization = $_POST['organization'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $hours = $_POST['hours'];


    $experience = $db->storeExperience( $title, $category, $date, $hours, $description, $organization, $verified);

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

function parseStudents( $students )
{
    $studentList = array();
    $tok = strtok($students, " ,;\n\t");
	while ($tok !== false){
		$studentList[] = $tok;
		$tok = strtok(" ,;\n\t");
	}
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
        isset( $_POST['organization'] )&&
        isset( $_POST['teacher'] )
    )
    {
        return true;
    }
    else
        return false;
}


?>
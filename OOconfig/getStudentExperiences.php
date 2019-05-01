<?php
/**
 * Created by PhpStorm.
 * User: mlind
 * Date: 7/10/2018
 * Time: 9:29 PM
 */

require_once 'DB_Func.php';
$db = new DB_Func();

$response['error'] = false;

if (  isRequiredParametersSet() ){

    $ssoid = $_POST['ssoid'];
    $expID_List = $db->getStudentExpIDs($ssoid);
    $experienceInfoList = array();
    $numberOfExp = count($expID_List);

    $student = $db->getNameDegree($ssoid);

    foreach ($expID_List as $expID) {
        $ex = $db->getExperienceInfo($expID);
        $ex['ssoid'] = $ssoid;
        array_push($experienceInfoList, $ex);
    }
    if ( $numberOfExp ){
       $db->makePDF($experienceInfoList, $student);

    }else {
        $response['error'] = TRUE;
        $response['message'] = "Could not retrieve user experiences";
    }
   // echo json_encode($response);

}else {
    $response['message'] = "parameters not set";
    echo json_encode($response);

}
function isRequiredParametersSet()
{
    if ( isset( $_POST['ssoid'] ) )
    {
        return true;
    }
    else
        return false;
}


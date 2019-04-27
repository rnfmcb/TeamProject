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

if (  isRequiredParametersSet() ){

    $user = $db->getUserByEmailAndPassword( $expID );

    if ($user){

    }else {
        $response['error'] = TRUE;
        $response['message'] = "Could not retrieve user";
    }
    echo json_encode($response);

}

function isRequiredParametersSet()
{
    if (
    isset( $_POST['ssoid'] )
//   && isset( $_POST['ssoid'] )
    )
    {
        return true;
    }
    else
        return false;
}

?>
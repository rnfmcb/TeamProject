<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class DB_Func
{
    private $conn;

    //constructor
    function __construct()
    {
        require_once 'DB_conn.php';
        $db = new DB_Connect();
        $this->conn = $db->connect();
    }

    function __destruct()
    {
        // $this->conn->close();
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    /**
     * @param 7
     * @return #isSucces
     */
    function storeExperience($title,$category, $date, $hours, $description, $organization, $verified)
    {

        $stmt = $this->conn->prepare("INSERT INTO experience ( TITLE, CATEGORY, DATE, HOURS,
        DESCRIPTION, ORGANIZATION, VERIFIED) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssisss",$title ,$category, $date, $hours, $description, $organization, $verified);
        $result = $stmt->execute();
        $stmt->close();

        //check for successful store
        if ($result) {
            return $this->isSuccessExp($title, $category, $date, $hours, $description, $organization, $verified);
        } else {
            return false;
        }
    }


    public function isUserInfoUnique($e)
    {
        //check email
        $stmt = $this->conn->prepare("SELECT EXPID from experience WHERE EXPID = ?");
        $stmt->bind_param("s", $email);

        $stmt->execute();
        $stmt->store_result();
        $existingInfo = $stmt->num_rows();

        $stmt->close();
        return $existingInfo;
    }


    /**
     * @param
     * @return mixed
     */
    public function isSuccessExp($title, $category, $date, $hours, $description, $organization, $verified)
    {
        $expID = "";

        //global $experience;

        $stmt = $this->conn->prepare("SELECT EXPID FROM experience WHERE (TITLE = ? AND CATEGORY = ? AND DATE = ? AND HOURS = ?
                                             AND DESCRIPTION = ? AND ORGANIZATION = ? AND VERIFIED = ?) ");
        $stmt->bind_param("sssisss", $title,$category, $date, $hours, $description, $organization, $verified);

        $stmt->execute();
        $stmt->bind_result($expID);

        $stmt->fetch();
        //store in array $experience
        $experience['expID'] = $expID;
        $experience['title']= $title;

        $experience['category'] = $category;
        $experience['date'] = $date;
        $experience['hours'] = $hours;
        $experience['description'] = $description;
        $experience['organization'] = $organization;
        $experience['verified'] = $verified;

        $stmt->close();

        return $experience;
    }

    /**
     * @param $expID
     * @return mixed
     */
    public function getExperienceInfo($expID)
    {
        //global $experience;

        $stmt = $this->conn->prepare("SELECT * FROM experience WHERE  EXPID = ? ");
        $stmt->bind_param("i", $expID);

        $stmt->execute();
        $stmt->bind_result($expID, $title, $category, $date, $hours, $description, $organization, $verified);

        $stmt->fetch();

        //store in array $experience

        $experience['expID'] = $expID;
        $experience['title'] = $title;
        $experience['category'] = $category;
        $experience['date'] = $date;
        $experience['hours'] = $hours;
        $experience['description'] = $description;
        $experience['organization'] = $organization;
        $experience['verified'] = $verified;

        $stmt->close();

        return $experience;
    }
    /**
     * @param $ssoid
     * @return student info
     *
     */


    public function getNameDegree($ssoid){
        $stmt = $this->conn->prepare(" SELECT * FROM student WHERE ( SSOID = ? )");
        $stmt->bind_param("s", $ssoid);
        $result = $stmt->execute();
        //  $numberOfRows = $stmt->num_rows;
        $stmt->bind_result( $ssoid, $lastName, $firstName, $email, $degree);
        $stmt->fetch();

        $student['firstName'] =$firstName;
        $student['lastName'] = $lastName;
        $student['email']= $email;
        $student['degree'] = $degree;

        if ($result) {
            return $student;
        } else {
            echo "ssoid does not match";
        }
    }

    /**
     * @param $expID,ssoid
     * @return bool
     *
     * stores one ssoid and experience
     */
    function storeStudentExperience($expID, $ssoid)
    {
        $stmt = $this->conn->prepare("INSERT INTO experience_student ( EX, STU ) VALUES ( ?, ? )");
        $stmt->bind_param("is", $expID, $ssoid);
        $result = $stmt->execute();
        $stmt->close();

        //check for successful store
        if ($result) {
            return true;//$this->isSuccessStuExp($expID, $ssoid);
        } else {
            return false;
        }
    }
    /**
     * @param $ssoid
     * @return array of expIDs
     **/

    function getStudentExpIDs($ssoid){

        $stmt = $this->conn->prepare(" SELECT * FROM experience_student WHERE ( STU = ? )");
        $stmt->bind_param("s", $ssoid);
        $result = $stmt->execute();
        $stmt->store_result();
        //  $numberOfRows = $stmt->num_rows;
        $stmt->bind_result($expID, $ssoid);
        $expID_List = array();
        if ($result) {
            // output data of each row
            while($stmt->fetch()) {
                array_push($expID_List, $expID);
              //  echo "ssoid: " . $ssoid. " - expID: " . "$expID" . "<br>";
            }
        } else {
            echo "0 results";
        }
        return $expID_List;
    }
    /**
     * @param $expID,ssoid
     * @return mixed

     */

    public function isSuccessStuExp($expID, $ssoid)
    {
        $stmt = $this->conn->prepare(" SELECT * FROM experience_student WHERE ( EX, STU ) VALUE ( ?, ? )");
        $stmt->bind_param("is", $expID, $ssoid);

        $stmt->execute();
        $stmt->bind_result($expID, $ssoid);

        $stmt->fetch();
        //store in array $experience
        $experience_student['expID'] = $expID;
        $experience_student['category'] = $ssoid;

        $stmt->close();

        return $experience_student;
    }

    /**
     * @param $expID list ,student name and degree
     * @return PDF
     *
     */

    public function makePDF($experienceList , $student){
        require_once 'genPDF.php';
//creates printable array filled with empty strings, filled in later loop

        $name = $student['firstName'] . ' ' . $student['lastName'];

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Courier','',12);
        $pdf->Cell(0,10, 'Name: ' . $name,0,1);
        $pdf->Cell(0,10, 'Degree: ' . $student['degree'],0,1);
//Loop prints every entry in the array
//Text is tentatively set to wrap
//If it doesn't work, FPDF's documentation will help
        $exCount = count($experienceList);
        foreach ($experienceList as $ex)
            $pdf->MultiCell(0,$exCount,$ex['date'] . ' | ' . $ex['title'] . ' | ' . $ex['description'] . ' | ' . $ex['category']. ' | ' .$ex['hours'], 0 , 1);
        $pdf->Output();
    }
}


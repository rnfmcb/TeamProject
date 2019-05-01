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


    function storeExperience($title, $category, $date, $hours, $description, $organization, $verified)
    {
		
        $stmt = $this->conn->prepare("INSERT INTO experience ( TITLE, CATEGORY, DATE, HOURS,
        DESCRIPTION, ORGANIZATION, VERIFIED) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssisss", $title, $category, $date, $hours, $description, $organization, $verified);
        $result = $stmt->execute();
        $stmt->close();

        //check for successful store
        if ($result) {
            return $this->isSuccessExp($title, $category, $date, $hours, $description, $organization, $verified);
        } else {
            return false;
        }
    }

    /**
     * @param $email
     * @return #of matches
     */
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

        $stmt = $this->conn->prepare("SELECT EXPID FROM experience WHERE ( TITLE = ? AND CATEGORY = ? AND DATE = ? AND HOURS = ?
                                             AND DESCRIPTION = ? AND ORGANIZATION = ? AND VERIFIED = ?) ");
        $stmt->bind_param("sssisss", $title, $category, $date, $hours, $description, $organization, $verified);

        $stmt->execute();
        $stmt->bind_result($expID);

        $stmt->fetch();
        //store in array $experience
		$experience['title'] = $title;
        $experience['expID'] = $expID;
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
     * @param $email
     * @return mixed
     */
    public function getExperienceInfo($expID)
    {
        //global $experience;

        $stmt = $this->conn->prepare("SELECT * FROM experience WHERE  EXPID = ? ");
        $stmt->bind_param("i", $expID);

        $stmt->execute();
        $stmt->bind_result($expID, $category, $date, $hours, $description, $organization, $verified);

        $stmt->fetch();

        //store in array $experience

        $experience['expID'] = $expID;
        $experience['category'] = $category;
        $experience['date'] = $date;
        $experience['hours'] = $hours;
        $experience['description'] = $description;
        $experience['organization'] = $organization;
        $experience['verified'] = $verified;

        $stmt->close();

        return $experience;
    }

    function storeStudentExperience($expID, $ssoid)
    {

        $stmt = $this->conn->prepare("INSERT INTO experience_student ( EX, STU ) VALUES ( ?, ? )");
        $stmt->bind_param("is", $expID, $ssoid);
        $result = $stmt->execute();
        $stmt->close();
        echo "\n this\n";

        //check for successful store
        if ($result) {
            return true;//$this->isSuccessStuExp($expID, $ssoid);
        } else {
            return false;
        }
    }

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
}

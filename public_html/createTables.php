<?php
    
    require("../config/config.php");
    
    //Connect to the database.
    require("../php/openDB.php");
    
    //Build the query strings for each table's creation.
    //N.B. the database name is stored in config.php, which is hidden from users.
    $student = "CREATE TABLE ". $database .".`student` ( `SSOID` VARCHAR(10) NOT NULL ,  `LASTNAME` VARCHAR(45) NOT NULL ,  `FIRSTNAME` VARCHAR(45) NOT NULL ,  `EMAIL` VARCHAR(45) NOT NULL , `DEGREE` varchar(25) NOT NULL,    PRIMARY KEY  (`SSOID`),    UNIQUE  (`EMAIL`)) ENGINE = InnoDB;";
        
    $teacher = "CREATE TABLE ". $database .".`teacher` ( `SSOID` VARCHAR(10) NOT NULL , `LASTNAME` VARCHAR(45) NOT NULL , `FIRSTNAME` VARCHAR(45) NOT NULL , `EMAIL` VARCHAR(45) NOT NULL , `DEPARTMENT` VARCHAR(45) NOT NULL , PRIMARY KEY (`SSOID`), UNIQUE (`EMAIL`)) ENGINE = InnoDB;";
        
    $experience = "CREATE TABLE ". $database .".`experience` ( `EXPID` INT UNSIGNED NOT NULL AUTO_INCREMENT , `CATEGORY` VARCHAR(45) NOT NULL , `DATE` DATE NOT NULL , `HOURS` INT UNSIGNED NOT NULL , `TITLE` varchar(40) NOT NULL, `DESCRIPTION` VARCHAR(1000) NOT NULL , `ORGANIZATION` VARCHAR(45) NOT NULL , `VERIFIED` VARCHAR(10) NOT NULL , PRIMARY KEY (`EXPID`), FOREIGN KEY (`VERIFIED`) REFERENCES `teacher`(`SSOID`) ON DELETE NO ACTION ON UPDATE NO ACTION) ENGINE = InnoDB;";
    
    $experience_student = "CREATE TABLE ". $database .".`experience_student` ( `EX` INT UNSIGNED NOT NULL , `STU` VARCHAR(10) NOT NULL , PRIMARY KEY (`EX`, `STU`), FOREIGN KEY (`EX`) REFERENCES `experience`(`EXPID`) ON DELETE NO ACTION ON UPDATE NO ACTION, FOREIGN KEY (`STU`) REFERENCES `student`(`SSOID`) ON DELETE NO ACTION ON UPDATE NO ACTION) ENGINE = InnoDB;";
    
    //Construct the student table.
    if($conn->query($student) === TRUE)
    {
    	echo "Student table created successfully";
    	echo "<br>";
    }
    else
    {
    	echo "Student table creation error: ". $conn->error;
    	echo "<br>";
    }
    
    //Construct the teacher table.
    if($conn->query($teacher) === TRUE)
    {
    	echo "Teacher table created successfully";
    	echo "<br>";
    }
    else
    {
    	echo "Teacher table creation error: ". $conn->error;
    	echo "<br>";
    }
    
    //Construct the experience table.
    if($conn->query($experience) === TRUE)
    {
    	echo "Experience table created successfully";
    	echo "<br>";
    }
    else
    {
    	echo "Experience table creation error: ". $conn->error;
    	echo "<br>";
    }
    
    //Construct the experience_student table, which exists for normalization purposes.
    //This table provides the flexibility for multiple students to participate in the same experience.
    if($conn->query($experience_student) === TRUE)
    {
    	echo "Experience_Student table created successfully";
    	echo "<br>";
    }
    else
    {
    	echo "Experience_Student table creation error: ". $conn->error;
    	echo "<br>";
    }
    
    //Close the connection to the database.
    require("../php/closeDB.php");
    
    //Provide a link back to the index page.
    echo "<a href=\"index.html\"> Return to the index page. </a>";
    
?>
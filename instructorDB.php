<?php 

    function connectDB() { 
        $config = parse_ini_file("db.ini"); 
        $dbh = new PDO($config['dsn'], $config['username'], $config['password']); 
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        return $dbh; 
    } 

    function GetCourses() { 
        //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
    
            $statement = $dbh->prepare("SELECT cID, title FROM FP_Courses WHERE iID = :iID "); 
            $statement->bindParam(":iID", $_SESSION['ID']); 
            $statement->execute(); 
    
            return $statement->fetchAll(); 
            $dbh = null; 
        } catch (PDOException $e) { 
            print "Error!" . $e->getMessage() . "<br/>"; 
            die(); 
        } 
    }

    function GetCourseStuds($cID) {
        //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
            
            // Get the list of student names 
            $statement = $dbh->prepare("SELECT u.name FROM FP_Enroll AS e, FP_User AS u WHERE e.cID=:courseID AND u.ID=e.sID");
            $statement->bindParam(":courseID", $cID); 
            $statement->execute(); 
    
            return $statement->fetchAll(); 
            $dbh = null; 
        } catch (PDOException $e) { 
            print "Error!" . $e->getMessage() . "<br/>"; 
            die(); 
        } 
    }

    function GetCourseEvals($cID) {
        //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
            
            // Get the list of student names 
            $statement = $dbh->prepare("SELECT qnum,response FROM FP_EvalResponses WHERE cID=:courseID");
            $statement->bindParam(":courseID", $cID); 
            $statement->execute(); 
    
            return $statement->fetchAll(); 
            $dbh = null; 
        } catch (PDOException $e) { 
            print "Error!" . $e->getMessage() . "<br/>"; 
            die(); 
        } 
    }
?>
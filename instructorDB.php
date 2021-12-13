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

    function GetCourseEvalQuestions() {
        //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
            
            // Get the list of student names 
            $statement = $dbh->prepare("SELECT qNum,qType,qPrompt FROM FP_EvalQuestions ORDER BY qNum");
            $statement->execute(); 
    
            return $statement->fetchAll(); 
            $dbh = null; 
        } catch (PDOException $e) { 
            print "Error!" . $e->getMessage() . "<br/>"; 
            die(); 
        } 
    }

    function GetMultChoiceEvalResp($cID, $qNum){
        //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
            
            // Get the list of student names 
            $statement = $dbh->prepare("SELECT qNum,qtype,qPrompt,response,SUM");
            $statement->bindParam(":qNumID", $qNum); 
            $statement->bindParam(":courseID", $cID); 
            $statement->execute(); 
    
            return $statement->fetchAll(); 
            $dbh = null; 
        } catch (PDOException $e) { 
            print "Error!" . $e->getMessage() . "<br/>"; 
            die(); 
        } 
    }

    function GetFreeRespEval($qNum){
        //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
            
            // Get the list of student names 
            $statement = $dbh->prepare("");
            $statement->bindParam(":qNumID", $qNum); 
            $statement->bindParam(":courseID", $cID);  
            $statement->execute(); 
    
            return $statement->fetchAll(); 
            $dbh = null; 
        } catch (PDOException $e) { 
            print "Error!" . $e->getMessage() . "<br/>"; 
            die(); 
        } 
    }

    /*SELECT COUNT(DISTINCT(er.sID)) AS studRespone,COUNT(DISTINCT(e.sID)) AS totalClassCount FROM FP_EvalResponses AS er 
    LEFT JOIN FP_Enroll AS e ON e.cID=er.cID
    WHERE er.cID="CS1000" // 

    SELECT qNum,qPrompt FROM FP_EvalQuestions//

    SELECT response FROM FP_EvalResponses 
    WHERE cID="CS1000" AND qNum=2 //

    SELECT COUNT(response) FROM FP_EvalResponses WHERE response="Agree" AND qNum=2//
    */
?>















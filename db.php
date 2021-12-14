<?php 
function connectDB() 
{ 
    $config = parse_ini_file("db.ini"); 
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']); 
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    return $dbh; 
} 
//return number of rows matching the given user and passwd.  

function authenticate($user, $passwd) {
    try { 
        $dbh = connectDB(); 
        $statement = $dbh->prepare("SELECT count(*) FROM FP_User where username = :username and passwd = sha2(:passwd,256) "); 
        $statement->bindParam(":username", $user); 
        $statement->bindParam(":passwd", $passwd); 
        $result = $statement->execute(); 
        $row=$statement->fetch(); 
        $dbh=null; 
 
        return $row[0]; 
    }catch (PDOException $e) { 
        print "Error! " . $e->getMessage() . "<br/>"; 
        die(); 
    } 
}
function isStudent($user){
    try{
    $dbh = connectDB();
    $statement = $dbh -> prepare("SELECT count(*) FROM FP_Student where sID = (select id FROM FP_User where username = :username) ");
    $statement -> bindParam(":username", $user);
    $result = $statement->execute(); 
    $row=$statement->fetch(); 
    $dbh=null;
    return $row[0];
    }catch(PDOException $e){
        print "Error! " . $e -> getMessage() . "<br/>";
        die();
    }

}
function isInstructor($user){
    try{
    $dbh = connectDB();
    $statement = $dbh -> prepare("SELECT count(*) FROM FP_Instructor where iID = (select id FROM FP_User where username = :username) ");
    $statement -> bindParam(":username", $user);
    $result = $statement->execute(); 
    $row=$statement->fetch(); 
    $dbh=null;
    return $row[0];
    }catch(PDOException $e){
        print "Error! " . $e -> getMessage() . "<br/>";
        die();
    }

}
function nullPass($user){
    try{
        $dbh = connectDB();
        $statement = $dbh->prepare("SELECT count(*) FROM FP_User where username = :username and passwd IS NULL");
        $statement->bindParam(":username", $user); 
        $result = $statement->execute(); 
        $row=$statement->fetch(); 
        $dbh=null; 
        return $row[0];
    }catch(PDOException $e){
        print "nullPass - Error! " . $e->getMessage() . "<br/>";
        die(); 
    }
}
function setPassword($user, $passwd){
    try{
        $dbh = connectDB();
        $statement = $dbh->prepare("UPDATE FP_User SET passwd = sha2(:passwd,256) WHERE username = :username");
        $statement->bindParam(":username", $user); 
        $statement->bindParam(":passwd", $passwd); 
        $result = $statement->execute();
        $dbh = null;
        return;

    }catch(PDOException $e){
        print "Error! ". $e->getMessage() . "<br/>";
        die();

    }
} 
function get_ID($user){
    try{
        $dbh = connectDB();
        $statement = $dbh -> prepare("select id FROM FP_User where username = :username");
        $statement -> bindParam(":username", $user);
        $statement->execute(); 
        $ID=$statement->fetch(); 
        $dbh=null;
        return $ID[0];
        }catch(PDOException $e){
            print "Error! " . $e -> getMessage() . "<br/>";
            die();
    }
}
function GetResponseRate($cID) {
    //connect to database 
    //retrieve the data and display 
    try { 
        $dbh = connectDB(); 
        
        // Get the list of student names 
        $statement = $dbh->prepare("SELECT COUNT(DISTINCT(er.sID)) AS studRespone,COUNT(DISTINCT(e.sID)) AS totalClassCount FROM FP_Enroll AS e LEFT JOIN FP_EvalResponses AS er ON e.cID=er.cID WHERE e.cID=:courseID");
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
        $statement = $dbh->prepare("SELECT qNum,qPrompt,qType FROM FP_EvalQuestions");
        $statement->execute(); 

        return $statement->fetchAll(); 
        $dbh = null; 
    } catch (PDOException $e) { 
        print "Error!" . $e->getMessage() . "<br/>"; 
        die(); 
    } 
}

function GetMultChoiceEvalResp($cID, $qNum, $respType){
    //connect to database 
    //retrieve the data and display 
    try { 
        $dbh = connectDB(); 
        
        // Get the list of student names 
        $statement = $dbh->prepare("SELECT COUNT(response) FROM FP_EvalResponses WHERE response=:respType AND qNum=:qNumID AND cID=:courseID");
        $statement->bindParam(":qNumID", $qNum); 
        $statement->bindParam(":courseID", $cID); 
        $statement->bindParam(":respType", $respType);
        $statement->execute(); 

        return $statement->fetchAll(); 
        $dbh = null; 
    } catch (PDOException $e) { 
        print "Error!" . $e->getMessage() . "<br/>"; 
        die(); 
    } 
}

function GetFreeRespEval($cID,$qNum){
    //connect to database 
    //retrieve the data and display 
    try { 
        $dbh = connectDB(); 
        
        // Get the list of student names 
        $statement = $dbh->prepare("SELECT response FROM FP_EvalResponses WHERE cID=:courseID AND qNum=:qNumID");
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
function GetStudentEvalResp($cID,$qNum,$sID){
    //connect to database 
    //retrieve the data and display 
    try { 
        $dbh = connectDB(); 
        
        // Get the list of student names 
        $statement = $dbh->prepare("SELECT response FROM FP_EvalResponses WHERE cID=:courseID AND qNum=:qNumID AND sID = :ID");
        $statement->bindParam(":qNumID", $qNum); 
        $statement->bindParam(":courseID", $cID);  
        $statement->bindParam(":ID", $sID);  
        $statement->execute(); 

        return $statement->fetchAll(); 
        $dbh = null; 
    } catch (PDOException $e) { 
        print "Error!" . $e->getMessage() . "<br/>"; 
        die(); 
    } 
}

function SetResp($q, $resp){
    try{
        $dbh = connectDB();
        $dropStatement = $dbh->prepare("DELETE FROM FP_EvalResponses WHERE sID=:ID AND cID=:courseID AND qNum=:qNumID");
        $statement = $dbh->prepare("INSERT INTO FP_EvalResponses (qNum, cID, sID, response, compDateTime) VALUES (:qNumID, :cID, :ID, :resp, NOW())");
        $dropStatement->bindParam(":qNumID", $q); 
        $dropStatement->bindParam(":courseID", $_SESSION["cID"]); 
        $dropStatement->bindParam(":ID", $_SESSION["ID"]);
        $statement->bindParam(":qNumID", $q); 
        $statement->bindParam(":cID", $_SESSION["cID"]); 
        $statement->bindParam(":ID", $_SESSION["ID"]); 
        $statement->bindParam(":resp", $resp);
        $dropStatement->execute(); 
        $statement->execute();
        $dbh = null; 
    }catch(PDOException $e){
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
         
}
?> 
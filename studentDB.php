<?php   
    function get_enrolledCourses(){
         //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
            
            // Get the list of student names 
            $statement = $dbh->prepare("SELECT c.cID,c.title,er.compDateTime FROM FP_Enroll AS e LEFT JOIN FP_Courses AS c ON c.cID=e.cID LEFT JOIN FP_EvalResponses AS er ON er.cID=c.cID AND er.sID=:ID WHERE e.sID=:ID");
            $statement->bindParam(":ID", $_SESSION["ID"]); 
            $statement->execute(); 
            return $statement->fetchAll(); 
            $dbh = null; 
        } catch (PDOException $e) { 
            print "Error!" . $e->getMessage() . "<br/>"; 
            die(); 
        } 

    }
    function GetAllCourses() { 
        //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
    
            $statement = $dbh->prepare("SELECT cID, title FROM FP_Courses"); 
            $statement->execute(); 
    
            return $statement->fetchAll(); 
            $dbh = null; 
        } catch (PDOException $e) { 
            print "Error!" . $e->getMessage() . "<br/>"; 
            die(); 
        } 
    }
    function enroll($cID){
        try{
            
            $dbh = connectDB();
            $statement = $dbh->prepare("INSERT INTO FP_Enroll (sID, cID) VALUES (:ID,:cID)");
            $statement->bindParam(":cID", $cID); 
            $statement->bindParam(":ID", $_SESSION["ID"]); 
            $statement->execute();
            $dbh = null;
            return;
    
        }catch(PDOException $e){
            print "Error! ". $e->getMessage() . "<br/>";
            die();
    
        }
    }
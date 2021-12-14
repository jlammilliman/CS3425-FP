<?php   
    function GetEnrolledCourses(){
         //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
            
            // Get the list of student names 
            $statement = $dbh->prepare("SELECT * FROM(SELECT c.cID,c.title,er.compDateTime, ROW_NUMBER() OVER(PARTITION BY c.cID ORDER BY c.cID ASC) rn FROM FP_Enroll AS e LEFT JOIN FP_Courses AS c ON c.cID=e.cID LEFT JOIN FP_EvalResponses AS er ON er.cID=c.cID AND er.sID=:ID WHERE e.sID=:ID) a WHERE rn = 1");
            $statement->bindParam(":ID", $_SESSION["ID"]); 
            $statement->execute(); 
            return $statement->fetchAll(); 
            $dbh = null; 
        } catch (PDOException $e) { 
            print "Error!" . $e->getMessage() . "<br/>"; 
            die(); 
        } 

    }
    function isEnrolled($cID){
        //connect to database 
       //retrieve the data and display 
       try { 
           $dbh = connectDB(); 
           
           // Get the list of student names 
           $statement = $dbh->prepare("SELECT count(*) FROM FP_Enroll WHERE sID = :ID AND cID = :cID");
           $statement->bindParam(":ID", $_SESSION["ID"]); 
           $statement->bindParam(":cID", $cID);
           $statement->execute(); 
           $row = $statement->fetch();
           return  $row[0];
           $dbh = null; 
       } catch (PDOException $e) { 
           print "Error!" . $e->getMessage() . "<br/>"; 
           die(); 
       } 

   }
    function GetAllCoursesInfo() { 
        //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
    
            $statement = $dbh->prepare("SELECT c.cID,u.name,c.title,c.credit FROM FP_Courses AS c LEFT JOIN FP_User AS u ON u.ID=c.iID;"); 
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
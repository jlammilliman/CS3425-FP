<?php 
    function connectDB() { 
        $config = parse_ini_file("db.ini"); 
        $dbh = new PDO($config['dsn'], $config['username'], $config['password']); 
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        return $dbh; 
    } 

    function showStuds() {
        echo "Worm...";
    }

    function GetCourses() { 
        //connect to database 
        //retrieve the data and display 
        try { 
            $dbh = connectDB(); 
    
            $statement = $dbh->prepare("SELECT cID, title FROM FP_Courses"); // where iID = :iID "); 
            //$statement->bindParam(":iID", $_SESSION['iID']); 
            $statement->execute(); 
    
            return $statement->fetchAll(); 
            $dbh = null; 
        } catch (PDOException $e) { 
            print "Error!" . $e->getMessage() . "<br/>"; 
            die(); 
        } 
    }

    function showEvals() {
        echo "Shwoing evaluations for $cID...";
    }
?>
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
?> 
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
        $statement = $dbh->prepare("SELECT count(*) FROM lab3_customer where username = :username and password = sha2(:passwd,256) "); 
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

function get_accounts($user) 
{ 
    //connect to database 
    //retrieve the data and display 
    try { 
        $dbh = connectDB(); 
 
        $statement = $dbh->prepare("SELECT account_no, balance name FROM lab3_accounts where username = :username "); 
        $statement->bindParam(":username", $_SESSION['username']); 
        $statement->execute(); 
 
        return $statement->fetchAll(); 
        $dbh = null; 
    } catch (PDOException $e) { 
        print "Error!" . $e->getMessage() . "<br/>"; 
        die(); 
    } 
}; 

function transfer($from, $to, $amount, $user) 
{ 
    try { 
        $dbh = connectDB(); 
        $dbh->beginTransaction(); 
 
        // check if there are enough balance in the from account 
        $statement = $dbh->prepare("select balance from lab3_accounts where account_no=:from "); 
        $statement->bindParam(":from", $from); 
        $result = $statement->execute(); 
        $row = $statement->fetch(); 
        if ($row) { 
            $currentBalance = $row[0]; 
            if ($currentBalance < $amount) { 
                echo "Not enough balance in $from"; 
                $dbh->rollBack(); 
                $dbh=null; 
                return; 
            } 
        } else { 
            echo "Account $from does not exist"; 
            $dbh->rollBack(); 
            $dbh=null; 

            return; 
        } 
 
        $statement = $dbh->prepare("update lab3_accounts set balance = balance - :amount where account_no=:from"); 
        $statement->bindParam(":amount", $amount); 
        $statement->bindParam(":from", $from); 
        $result = $statement->execute(); 
 
        $statement = $dbh->prepare("update lab3_accounts set balance = balance + :amount where account_no= :to"); 
        $statement->bindParam(":amount", $amount); 
        $statement->bindParam(":to", $to); 
        $result = $statement->execute(); 
        echo "Money has been transfered successfully"; 
        $dbh->commit(); 
    } catch (Exception $e) { 
        echo "Failed: " . $e->getMessage(); 
        $dbh->rollBack(); 
    } 
 
    $dbh=null; 
}
?> 
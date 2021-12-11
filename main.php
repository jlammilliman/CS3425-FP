<style>

button{
    position: relative;
}
input[type="submit"] {
    height: 20px;
    width: auto;
    display: inline-block;

}
.buttons{
    text-align: center;

}

</style>

<html>
<?php
session_start();
?>

<div class = buttons>

<p> Welcome to JJ's course evaluations! <br>
Are you a... </p>

 <!-- show the login button or logout here -->
 <form action="studentLogin.php" method="post">
    <?php
    if (!isset($_SESSION["username"])) {
    ?>
        <input type="submit" value='Student' name="Student login"> 

    <?php
    }else { 
        echo "Welcome ". $_SESSION["username"];
    ?>
        <input type="submit" value='logout' name="logout">
    <?php
    }
    ?>
</form>
<form action="instructorLogin.php" method="post">
    <?php
    if (!isset($_SESSION["username"])) {
    ?>
        <input type="submit" value='Instructor' name="Instructor login"> 

    <?php
    }else { 
        echo "Welcome ". $_SESSION["username"];
    ?>
        <input type="submit" value='logout' name="logout">
    <?php
    }
    ?>
</form>
</div>
</html>
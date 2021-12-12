<?php 
require "db.php";
session_start(); 
 
// user clicked the login button */ 
if ( isset($_POST["login"]) ) {  
    //check the username and passwd, if correct, redirect to main.php page 
    if (authenticate($_POST["username"], $_POST["password"]) == 1 && isInstructor($_POST["username"])==1) { 
      $_SESSION["username"]=$_POST["username"]; 
      $_SESSION["ID"]=get_ID($_SESSION["username"]);
      header("LOCATION:instructor.php"); 
      return; 
    } else if (nullPass($_POST["username"])==1){ 
        header("LOCATION:newLogin.php");
        return;
   }else { 
      echo '<p style="color:red">Incorrect username or password!</p>'; 
   }    
}  
 
// user clicked the logout button */ 
if ( isset($_POST["logout"]) ) {  
   session_destroy(); 
} 
?> 
<div class = instructorLogin>
<h1>Insturctor Login</h1>
<p> Please enter your credentials </p>

<form method="post" action="instructorLogin.php">
    username: <input type="text" name="username" placeholder="username"><br>
    password: <input type="password" name="password" placeholder="password"><br>
    <button class="button" type="submit" name="login" value="login">Login</button>
</form>
</div>

<style>
    .button{
        background-color: white;
        border-radius: 4px;
        color: black;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 8px 4px;
        transition-duration: 0.3s;
        cursor: pointer;
    }
    .button:hover {
        background-color: black;
        color: white;
    }
    .instructorLogin{
        text-align: center;
    }
</style>
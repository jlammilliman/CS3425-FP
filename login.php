
<?php 
require "db.php";
session_start(); 
 
// user clicked the login button */ 
if ( isset($_POST["login"]) ) {  
  $_SESSION["username"]=$_POST["username"]; 
    //check the username and passwd, if correct, redirect to login.php page 
    if (authenticate($_POST["username"], $_POST["password"]) == 1) { 
      
      if(isStudent($_POST["username"]) == 1){
        $_SESSION["ID"]=get_ID($_SESSION["username"]);
        header("LOCATION:student.php"); 
        return;
      }else if(isInstructor($_POST["username"])==1){
        $_SESSION["ID"]=get_ID($_SESSION["username"]);
        header("LOCATION:instructor.php"); 
        return; 
      }  
   }else if(nullPass($_POST["username"])==1){ 
      header("LOCATION:newLogin.php");
      return;
   }else{
      echo '<p style="color:red">Incorrect username or password!</p>'; 
   }    
}  
 
// user clicked the logout button */ 
if ( isset($_POST["logout"]) ) {  
   session_destroy(); 
   header("LOCATION:login.php");
} 
?> 

<div class = login>
<h2> Welcome to J&J evaluations!</h2>

<h3>Login</h3>
<p> Please enter your credentials </p>

<form method="post" action="login.php">
    username: <input style = "margin: 5px" type="text" name="username" placeholder="username"><br>
    password: <input style = "margin: 5px" type="password" name="password" placeholder="password"><br>
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
</style>
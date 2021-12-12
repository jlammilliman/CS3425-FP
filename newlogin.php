<?php 
require "db.php";
 session_start();
// user clicked the login button */ 
if ( isset($_POST["login"]) ) {  
    //check the old and new passwd, if correct, redirect to appropriate page 
    if ($_POST["oldPsswd"] == $_POST["newPsswd"]) { 
      setPassword($_POST["username"], $_POST["newPsswd"]);
      header("LOCATION:main.php"); 
      session_destroy(); 


      return; 
   }else { 
      echo '<p style="color:red">Incorrect username or password!</p>'; 
   }    
}  
?> 
<div class="border-div">
    <form method="post" action="newLogin.php">
        Username: <input type="text" name= "username" placeholder="Enter Username"><br>
        New Password: <input type="password" name="newPsswd" placeholder="Enter new password..."><br>
        Re-Enter Password: <input type="password" name="oldPsswd" placeholder="Enter new password..."><br>
        <button class="button" type="submit" name="login" value="login">Login</button>
    </form>
<div>

<style>
    .border-div {
        background-color: lightgray;
        border-radius: 3ch;
        text-align: right;
        display: inline-block;
        padding: 2ch;
    }

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
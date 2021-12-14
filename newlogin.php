<?php 
require "db.php";
 session_start();
// user clicked the login button */ 
if ( isset($_POST["confirm"]) ) {  
    //check the old and new passwd, if correct, redirect to appropriate page 
    if ($_POST["newPsswd"] == $_POST["newPsswdConfirm"] ) { 
      setPassword($_SESSION["username"], $_POST["newPsswd"]);
      header("LOCATION:login.php"); 
      session_destroy(); 
      return; 
   }else { 
      echo '<p style="color:red">Passwords do not match!</p>'; 
   }    
}  
?> 
<div class="border-div">
    <form method="post" action="newlogin.php">
        New Password: <input type="password" name="newPsswd" placeholder="Enter new password..."><br>
        Re-Enter Password: <input type="password" name="newPsswdConfirm" placeholder="Enter new password..."><br>
        <button class="button" type="submit" name="confirm" value="Confirm">Confirm</button>
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
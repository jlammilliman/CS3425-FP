<?php 
session_start(); 
 
// user clicked the login button */ 
if ( isset($_POST["newlogin"]) ) {  
    //check the old and new passwd, if correct, redirect to appropriate page 
    if (authenticate($_POST["newPsswd"], $_POST["oldPsswd"]) == 1) { 
      $_SESSION["username"]=$_POST["username"]; 
      header("LOCATION:NEEDTOFIXBOO"); 
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
<div class="newLogin-div">
    <form method="post" action="newlogin.php">
        New Password: <input type="password" name="newPsswd" placeholder="Enter new password..."><br>
        Re-Enter Password: <input type="password" name="oldPsswd" placeholder="Enter new password..."><br>
        <button class="button" type="submit" name="login" value="login">Login</button>
    </form>
<div>

<style>
    .newLogin-div {
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
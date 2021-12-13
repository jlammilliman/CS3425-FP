<style>

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  
}
button{
position: relative;
}
input[type="text"] {
    width: 200px;
    height: 20px;
    padding-right: 50px;
}

input[type="submit"] {
    height: 20px;
    width: 50px;
}
.custom-table, th {
        border: 1px solid gray;
        text-align: left;
        margin: 0ch;
        padding: 4px;
        border-collapse: collapse;
        background-color: lightgray;
        
}
.td {
        border-right: 1px solid gray;
        text-align: left;
        margin: 0ch;
        padding: 4px;
        border-collapse: collapse;
        background-color: white;
}
</style>

<?php
    require "db.php";
    require "studentDB.php";
    session_start();
    if (isset($_SESSION["username"])) {
        $courses = get_enrolledCourses();
        $allCourses = GetALLCourses();
    }
?>
<form action="login.php" method="post">
        <?php
            echo "Welcome " . $_SESSION["username"] . "!";
        ?>
        <input type="submit" value='logout' name="logout"> 
    </form>

<table class = "custom-table">
    <tr>
        <th>Enrolled Courses: </th>
        <th>Eval</th> 
        <th>Completion Date/Time</th>
    </tr>
    <?php
    foreach ($courses as $row) {
        echo "<tr>";
        echo "<td class=\"td\">" . $row[0] . " - " . $row[1] ."</td>";
        echo "<td class=\"td\"> <a href=\"studentEval.php\">View/Edit</a> </td>";
        echo "<td class=\"td\">" . $row[2] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<form method = "post" action = student.php>
    <button> View Courses </button>
    <input type = "text" placeholder="Enter cID here" name = "cID">
    <input type = "submit" name = "Enroll" value = "Enroll">
    <?php
    if (isset($_POST["Enroll"])){
        $cID = $_POST["cID"];
        enroll($cID);
        header("LOCATION:student.php"); 

    }

    ?>
</form>
<div id = "CourseList">
    <table class = "custom-table">
    <th> Courses List</th>
    <?php 
    //=========================================================
    // List courses--students list block here
    //=========================================================
        foreach ($allCourses as $c) { 
            echo "<tr>";
            echo "<td class=\"td\">" . $c[0] . " - " . $c[1] ."</td>";
            echo "</tr>";
        } 
    ?>
    </table>
</div>
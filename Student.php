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
        column-width: auto;
        
}
.td {
        border-right: 1px solid gray;
        text-align: left;
        margin: 0ch;
        padding: 4px;
        border-collapse: collapse;
        background-color: white;

}
submit{
        width: auto;
}
</style>

<?php
    require "db.php";
    require "studentDB.php";
    session_start();
    if (isset($_SESSION["username"])) {
        $courses = GetEnrolledCourses();
        $allCourses = GetALLCoursesInfo();
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
        <th>Evaluation</th> 
        <th>Completion Date/Time</th>
    </tr>
    <?php
    foreach ($courses as $row) {
        echo "<tr>";
        echo "<td class=\"td\">" . $row[0] . " - " . $row[1] ."</td>";
    ?>
    <form method = "post" action = "student.php">
    <td class="td"> <button class= "button" type="submit" name="Eval" value="<?php echo $row[0]; ?>">View/Edit</button> </td>
    </form>
    <?php
        echo "<td class=\"td\">" . $row[2] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<?php
    if(isset($_POST["Eval"])){
        $_SESSION["cID"]=$_POST["Eval"];
        header("LOCATION:eval.php");
    }
?>

<form method = "post" action = student.php>
    <input type = "text" placeholder="Enter cID here" name = "cID">
    <input type = "submit" name = "Enroll" value = "Enroll">
    <?php
    if (isset($_POST["Enroll"])){
        $cID = $_POST["cID"];
        if(isEnrolled($cID)==0){
            enroll($cID);
            header("LOCATION:student.php");
        }else{
            echo '<p style = "color:red"> "Already enrollod in course!"</p>';
        }
         

    }

    ?>
</form>
<div id = "CourseList">
    <h3> Courses List</h3>

    <table class = "custom-table">
    <tr>
        <th>cID </th>
        <th>Title</th> 
        <th>Instructor</th>
        <th>Credits</th>
    </tr>
    <?php 
    //=========================================================
    // List courses--students list block here
    //=========================================================
        foreach ($allCourses as $c) { 
            echo "<tr>";
            echo "<td>" . $c[0] . "</td>";
            echo "<td>". $c[2] . "</td>";
            echo "<td>" . $c[1] . "</td>";
            echo "<td>" . $c[3] . "</td>";
            echo "</tr>";
        } 
    ?>
    </table>
</div>
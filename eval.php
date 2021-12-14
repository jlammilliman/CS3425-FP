<?php
require "db.php";
require "studentDB.php";
session_start();

if(!isset($_SESSION["ID"])) {
    header("LOCATION:login.php"); 
    session_destroy(); 
}
if(!isset($_SESSION["cID"])) {
    header("LOCATION:student.php"); 
}


$eqs = GetCourseEvalQuestions();
$courses = GetEnrolledCourses();

// show some class analytics -- class response is num of students who have completed the evaluation/totalstudentcount
echo "<div class=\"eval-div\">";
// Start building the class evaluation block
echo "<h2 class=\"title-h4\">Evaluations for " . $_SESSION["cID"] . "</h2>";
echo "<div class=\"inner2-div\" id=\"showStuds-div\">";

foreach ($eqs as $q) {
    echo "<div class=\"inner-div\"> <h4 class=\"h4\">" . $q[0] . ") " . $q[1] . "</h4>";

    // if the questiontype is freeresponse-- list the reponses: else multiplechoice-- build the table to display data,
    //qNum,qPrompt,qType
    if ($q[2] == "multipleChoice") {
        $types = array("Strongly Disagree", "Disagree", "Neutral", "Agree", "Strongly Agree");
        $resps = GetStudentEvalResp($_SESSION["cID"], $q[0], $_SESSION["ID"]);

        // Build input forms
        echo "<form method=\"post\" action =\"eval.php\">";

        echo "<select name=\"q" . $q[0] . "\" multiple=\"multiple\">";
        foreach($types as $t) {
           echo "<option width=\"100px\" value=\"" . $t . "\"";
           if ($t == $resps[0][0]) {
               echo "selected=\"selected\"";
           }
           echo ">" . $t . "</option>";
        }
        echo "</select>";

        echo "<input type =\"submit\" name = \"Save" . $q[0] . "\" value = \"Save\">";

        if (isset($_POST["Save" . $q[0] . ""])){
            SetResp($q[0], $_POST["q" . $q[0] . ""]);
            header("LOCATION:eval.php");
        }
        echo "</form>";


    } else {
        $resps = GetStudentEvalResp($_SESSION["cID"], $q[0], $_SESSION["ID"]);
        
        // Build input forms
        echo "<form method=\"post\" action =\"eval.php\">";
        echo "<input type =\"text\" placeholder=\"";
        if(!empty($resps[0])){
            echo $resps[0][0];
        } else {
            echo "Neutral";
        }
        echo "\" name = \"q" . $q[0] . "\">";
        echo "<input type =\"submit\" name = \"Save" . $q[0] . "\" value = \"Save\">";

        if (isset($_POST["Save" . $q[0] . ""])){
            SetResp($q[0], $_POST["q" . $q[0] . ""]);
            header("LOCATION:eval.php");
        }
        echo "</form>";
    }
    
    echo "</div>";
}
echo "</div>";
echo "</div>";


if (isset($_POST["goBack"])) {
    header("LOCATION:student.php");
}

?>
<form method="post" action="eval.php" display="contents">
    <td class="td"> <button class="button" type="submit" name="goBack" value="goBack">Go Back</button> </td>
</form>

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

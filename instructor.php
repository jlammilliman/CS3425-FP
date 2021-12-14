<?php
    require "instructorDB.php";
    session_start(); 

    if(!isset($_SESSION["ID"])) {
        header("LOCATION:login.php"); 
        session_destroy(); 
    }


    $courses = GetCourses($_SESSION["ID"]); 
?> 

<body>   
    <?php
        echo "Welcome " . $_SESSION["username"] . "!";
    ?>
    <form action="login.php" method="post">
        <input type="submit" value='logout' name="logout"> 
    </form>
    <form action="newlogin.php" method="post">
        <input type="submit" value='changePassword' name="Change Password"> 
    </form>
    <div class="base-div" id="basepain">
        <h4 class="h4"> Courses</h4>

        <?php 
        //=========================================================
        // List courses--students list block here
        //=========================================================
            foreach ($courses as $c) { 
                echo "<div class=\"inner-div\">";
                echo "<h4 class=\"title-h4\">" . $c[0] . " - " . $c[1] ."</h4>";
                echo "<div class=\"inner-div\" id=\"showStuds-div\">";
                echo "<h4 class=\"h4\">Enrolled Students...</h4>";
                $students = GetCourseStuds($c[0]);
                foreach ($students as $stud) { 
                    echo $stud[0];
                    echo "<hr margin=\"1px\" padding=\"0px\" size=\"1\" color=\"gray\">";
                }
                echo "</div>";
                echo "</div>";
            } 
        ?>
    </div>  

    <?php   
        //=========================================================
        // Evaluation block(s) here
        //=========================================================
        $eqs = GetCourseEvalQuestions();
        foreach($courses as $c) {
            // show some class analytics -- class response is num of students who have completed the evaluation/totalstudentcount
            $rRate = GetResponseRate($c[0]);
            if ($rRate[0][1]==0) {
                $showCRR = 0.00;
            } else {
                $showCRR = round($rRate[0][0]/$rRate[0][1] * 100, 2);
            }
            echo "<div class=\"eval-div\">";
            // Start building the class evaluation block
            echo "<h4 class=\"title-h4\">Evaluations for " . $c[0] . "</h4>";
            echo "<div class=\"inner2-div\" id=\"showStuds-div\">";

            // show some class responseRate
            echo "<label display=\"block\">Response Rate: " . $rRate[0][0] . "/" . $rRate[0][1] . " (" . $showCRR . "%)</label>";
            
            foreach($eqs as $q) {
                echo "<div class=\"inner-div\"> <h4 class=\"h4\">" . $q[0] . ") " . $q[1] . "</h4>";

                // if the questiontype is freeresponse-- list the reponses: else multiplechoice-- build the table to display data,
                //qNum,qPrompt,qType
                if ($q[2]=="multipleChoice") {
                    $types = array("Strongly Disagree", "Disagree", "Neutral", "Agree", "Strongly Agree");

                    // Build table header
                    echo "<table class=\"custom-table\">";
                    echo "<tr>";
                    echo "<th>Response Option</th>";          
                    echo "<th>Frequency</th>";
                    echo "<th>Percent</th>";
                    echo "<th>Percent Visual</th>";
                    echo "</tr>";
                    foreach($types as $t) {

                        // We need to count how many people voted for the specified types
                        $resps =  GetMultChoiceEvalResp($c[0], $q[0], $t);

                        foreach ($resps as $r) {               

                            // Calculate Frequency
                            if ($rRate[0][0]==0) {
                                $showFreq = 0.00;
                            } else {
                                $showFreq = round($r[0]/$rRate[0][1] * 100, 2);
                            }

                            //Build each row-- should be five total, one for each type
                            echo "<tr>";
                            echo "<td class=\"td\">" . $t . "</td>";
                            echo "<td class=\"td\">" . $r[0] . "</td>";
                            echo "<td class=\"td\">" . $showFreq . "%</td>";
                            echo "<td class=\"td\"><meter max=\"100\" min=\"0\" value=" . $showFreq . "></meter></td>";
                            echo "</tr>";  
                        }
                    }
                    echo "</table>"; // End table
                } else {
                    $resps = GetFreeRespEval($c[0],$q[0]);
                    foreach ($resps as $r) {
                        echo "<br class=\"fr-br\">- " . $r[0] . "</br>";
                    }
                }
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
    ?>     
</body>

<style>
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
        text-align: right;
        margin: 0ch;
        padding: 4px;
        border-collapse: collapse;
        background-color: white;
    }

    .h4 {
        margin: 0px;
        padding: 0px;
        text-align: left;
        border: 1px solid darkgray;
        background-color: rgb(230,230,230);
    }

    .title-h4 {
        margin: 0px;
        padding: 0px;
        text-align: left;
        border-top: 1px solid darkgray;
        background-color: lightblue;
    }

    .fr-br {
        margin: 0px;
        padding: 0px;
        text-align: left;
        border-top: 1px;
        border-bottom: 1px;
        border-style: solid;
        border-color: lightgray;
        text-align:top;
    }

    .br {
        margin: 0px;
        padding: 0px;
        text-align: right;
    }

    .inner-div {
        background-color: white;
        text-align: left;
        display: block;
        border: 0px;
        border-top: 1px;
        border-bottom:1px;
        border-color: gray;
        border-style: solid;
        margin: 0px;
        padding: 0px;
    }

    .inner2-div {
        background-color: lightgray;
        text-align: left;
        display: block;
        border: 0px;
        border-top: 1px;
        border-bottom:1px;
        border-color: gray;
        border-style: solid;
        margin: 0px;
        padding: 0px;
    }

    .eval-div {
        margin: 20px;
        display: block;
        padding:4px;
        margin-top:20px;
        background-color: lightgray;
        border-radius: 4px;
        text-align: left;
        float: left;
        border: 1px;
        border-color: gray;
        border-style: solid;
    }


    .base-div {
        width: 400px;
        margin: 20px;
        padding:4px;
        background-color: lightgray;
        border-radius: 4px;
        text-align: left;
        float: left;
        border: 1px;
        border-color: gray;
        border-style: solid;
    }
</style>
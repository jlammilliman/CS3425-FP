<?php
    require "instructorDB.php";
    session_start(); 

    $courses = GetCourses($_SESSION["ID"]); 
?> 

<body>   
    <div class="base-div" id="basepain">
        <label margin-left="10px">Courses:</label>

        <?php 
            foreach ($courses as $row) { 
                echo "<form class=\"inner-div\" method=\"POST\">";
                echo "<label class=\"Class\">" . $row[0] . " - " . $row[1] ."</label>";
                echo "<button class=\"button-inline\" float=\"right\" id=\"showevals" . $row[0] . "\" onclick=\"showEvals($row[0])\">Evaluations</button>";
                echo "<hr size=\"1\" color=\"gray\" margin=\"1px\">";
                echo "</form>";
            } 
        ?>
    </div>  
    <div class="base-div" id="sidepain">

    <label id="studentsList-label" margin-left="10px"></label>
    <?php   
        foreach($courses as $c) {
            echo "<label display=\"block\"><span id=\"courseID\">Student list for " . $c[0] . " </span></label>";
            echo "<div class=\"inner-div\" id=\"showStuds-div\">";
            $students = GetCourseStuds($c[0]);
            foreach ($students as $stud) { 
                echo "<label>" . $stud[0] . "</label>";
                echo "<hr size=\"1\" color=\"gray\" margin=\"1px\">";
            }
            echo "</div>";
        }
    ?> 
    </div>
    <div class="eval-div" id="bottompain">
    <?php   
        foreach($courses as $c) {
            echo "<label display=\"block\"><span id=\"courseID\">Evaluations for " . $c[0] . " </span></label>";
            echo "<div class=\"inner-div\" id=\"showStuds-div\">";
            $evals = GetCourseEvals($c[0]);
            foreach ($evals as $e) { 
                echo "<label>" . $e[0] . " - " . $e[1] . "</label>";
                echo "<hr size=\"1\" color=\"gray\" margin=\"1px\">";
            }
            echo "</div>";
        }
    ?> 
    
</body>

<style>
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

    .eval-div {
        width: 820px;
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
        vertical-align:top;
        border-radius: 4px;
        text-align: left;
        float: left;
        border: 1px;
        border-color: gray;
        border-style: solid;
    }
    
    .button{
        padding: 1ch;
        border-radius: 4px;
        color: black;
        text-align: center;
        text-decoration: none;
        display: block;
        font-size: 14px;
        transition-duration: 0.3s;
    }

    .button-inline {
        border-radius: 4px;
        float: right;
        color: black;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        transition-duration: 0.1s;
    }

    .button:hover {
        background-color: gray;
    }

    .button-inline:hover {
        background-color: gray;
    }

    .button:active {
        background-color: darkgray;
        color: white;
    }

    .button-inline:active {
        background-color: darkgray;
        color: white;
    }
</style>
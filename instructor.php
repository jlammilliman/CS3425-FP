<?php
    require "instructorDB.php";
?>

<body>   
    <div class="base-div" id="base">
        <label margin-left="10px">Courses:</label>
        <form class="inner-div" method="POST">
            <label class="Class">CS3425- Databases (Dummy Data)</label>
            <button class="button-inline" id="showstuds" onclick="showStuds()">Students</button>  
            <button class="button-inline" id="showevals" onclick="showEvals()">Evaluations</button>
            <hr size="1" color="gray" margin="1px">
        </form>
    </div>  
    <div class="base-div" id="sidepain">
    

    <label margin-left="10px">Student for :</label>
        <form class="inner-div" method="POST">
            <label class="Class">CS3425- Databases (Dummy Data)</label>
            <button class="button-inline" id="showstuds" onclick="showStuds()">Students</button>  
            <button class="button-inline" id="showevals" onclick="showEvals()">Evaluations</button>
            <hr size="1" color="gray" margin="1px">
        </form>
    <div>                        
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
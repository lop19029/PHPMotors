<?php
//This is the vehicles controller

//Get the database connection file
require_once "library/connections.php";
//Get the PHP Motors model for use as needed
require_once "model/main-model.php";

//Get the array of classifications
$classifications = getClassifications();
//var_dump($classifications);
//    exit;

// Build a navigation bar using the $classifications array
$navList = "<ul>";
$navList.= "<li><a href='/CS%20340/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
    $navList .= "<li><a href='/CS%20340/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList.= "</ul>";

// Build a drop down select list using the $classifications array
$classificationList = "<label for='classificationId'>Choose Car Classification</label>";
$classificationList.= "<select id='classificationId' name='classificationId'>";
foreach ($classifications as $classification) {
    $classificationList.= "<option value='$classification['classificationId']'>$classification['classificationName']</option>";
}
$classificationList.= "</select>";
?>
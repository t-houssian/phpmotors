<?php

// Validates the email server-side.
function checkEmail($clientEmail){
 $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
 return $valEmail;
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}

// Check the password for a maximum of 30 characters,
function checkclassificationName($classificationName){
    $pattern = '/^.{1,30}$/';
    return preg_match($pattern, $classificationName);
}

// Builds the navigationbar using the classifications array
// and the count(Amount of classifications.)
function buildNav($classifications){
    $count = count($classifications) + 1;
    $navList = "<ul style='grid-template-columns: repeat($count, auto);'>";
    $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';
    return $navList;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
    $classifList = '<select name="classificationId" id="classificationList">';
    $classifList .= "<option>Choose a Car Classification</option>";
    foreach ($classifications as $classification) {
    $classifList .= "<option value='$classification[classificationId]'";
    if(isset($classificationId)){
    if($classification['classificationId'] === $classificationId){
    $classifList .= ' selected ';
    }
    } elseif(isset($invInfo['classificationId'])){
    if($classification['classificationId'] === $invInfo['classificationId']){
    $classifList .= ' selected ';
    }
    }
    $classifList .= ">$classification[classificationName]</option>";
    }
    $classifList .= '</select>';
 

    return $classifList; 
}
<?php
/*
 * Proxy connection to the phpmotors database
 */

function phpmotorsConnect(){
 $server = 'mysql:3306';
 $dbname= 'phpmotors';
 $username = 'iClient';
 $password = 'BdyGTmLW]5)8XFk9'; 
 $dsn = "mysql:host=$server;dbname=$dbname";
 $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

 // Create the actual connection object and assign it to a variable
 try {
  $link = new PDO($dsn, $username, $password, $options);
  return $link;
 } catch(PDOException $e) {
  header('Location: /phpmotors/view/500.php');
  exit;
 }
}
phpmotorsConnect();
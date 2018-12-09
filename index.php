<?php

require($_SERVER['DOCUMENT_ROOT']."/tifr/include/DB_Connect.php");

$conn = new DB_Connect();
$db = $conn->connect();

$x = 4;

echo "<h1 style='color:red'>Connection Successful</h1>";
echo "<h3>Var x is ".$x."</h3>"
?>
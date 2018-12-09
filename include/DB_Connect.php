<?php
class DB_Connect{
    private $conn;
    function connect(){
        $servername = "localhost";
        $user = "root";
        $pass = "";
        $db_name = "nms";
        
        $this->conn = new mysqli($servername, $user, $pass, $db_name);
    
        return $this->conn;
    }
}
?>
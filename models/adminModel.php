<?php
require "../config/database.php";
class adminModel extends database
{
    private $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }

   
    
    
}

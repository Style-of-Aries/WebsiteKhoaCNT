<?php
require "../config/database.php";
class adminModel
{
   protected $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    protected function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }

   
    
    
}

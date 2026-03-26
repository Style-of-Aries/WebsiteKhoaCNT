<?php
class database{
    const HOST = '103.126.161.228';
    const USERNAME = 'nhom12nghiateacher';
    const PASSWORD = 'WpYFCxEIMI4Y';
    const DB_NAME = 'nhom12nghiateacher';
    const port = '3306';



    public static function connect(){
        $connect= mysqli_connect(self::HOST,self::USERNAME,self::PASSWORD,self::DB_NAME,self::port);
        mysqli_set_charset($connect,"utf8");

        if(mysqli_connect_errno() === 0){
            return $connect;
        }else{
            return false;

        }
    }
}
?>
<?php
require_once '../models/userModel.php';
require_once '../config/config.php';
class userController
{
    private $userModel;private $connect;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->userModel = new UserModel($connect);
    }
    
}

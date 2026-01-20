<?php
require_once '../models/userModel.php';
require_once '../config/config.php';
class userController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
}

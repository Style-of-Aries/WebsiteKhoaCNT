<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");

require_once "../config/database.php";
require_once "../models/userModel.php";

/* KẾT NỐI DATABASE */
$conn = database::connect();

if(!$conn){
    echo json_encode([
        "status"=>"error",
        "message"=>"Database connection failed"
    ]);
    exit;
}

/* TẠO MODEL */
$userModel = new userModel($conn);

/* LẤY DATA TỪ MOBILE */
$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$result = $userModel->getByUsername($username);
$user = mysqli_fetch_assoc($result);

/* CHECK USER */
if(!$user){
    echo json_encode([
        "status"=>"error",
        "message"=>"Tài khoản không tồn tại"
    ]);
    exit;
}

/* CHECK PASSWORD */
if(trim($user['password']) !== $password){
    echo json_encode([
        "status"=>"error",
        "message"=>"Sai mật khẩu"
    ]);
    exit;
}

/* SUCCESS */
echo json_encode([
    "status"=>"success",
    "user"=>$user
]);
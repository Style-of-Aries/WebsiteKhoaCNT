<?php 
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../middleware/PermissionMiddleware.php";

session_start(); 

$controllerName = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

// ✅ CHECK QUYỀN Ở ĐÂY (TRƯỚC KHI LOAD CONTROLLER)
PermissionMiddleware::check($controllerName, $action);

$controllerClass = $controllerName . 'Controller';

require_once __DIR__ . "/../controllers/{$controllerClass}.php";

$conn = database::connect();

if (!$conn) {
    die("❌ Không thể kết nối database");
}

$controller = new $controllerClass($conn);

// ✅ Check action tồn tại để tránh lỗi
if (!method_exists($controller, $action)) {
    die("❌ Action '$action' không tồn tại trong $controllerClass");
}

$controller->$action();
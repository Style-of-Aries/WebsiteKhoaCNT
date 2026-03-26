<?php
require_once "./../services/PermissionService.php";
class PermissionMiddleware
{

    private static $map = [
        'admin@index' => 'dashboard',
        'admin@getAllUser' => 'users',
        'department@getAllKhoa' => 'departments',
        'subject@getAllMonHoc' => 'subjects',
        'classes@getAllLopHoc' => 'classes',
        'course_classes@getAllHocPhan' => 'course_classes',
        'admin@getAllSinhVien' => 'students',
        'scores@attendance' => 'attendance',
        'scores@exam' => 'exam_score',
        'timetable@index' => 'timetable'
    ];

    public static function check($controller, $action)
    {

        if ($controller === 'auth') {
            return; // không chặn login
        }
        if (!isset($_SESSION['user']['role'])) {
            header('location: index.php');
            exit();
        }

        $key = strtolower($controller . '@' . $action);
        $permission = self::$map[$key] ?? null;

        if ($permission && !PermissionService::has($_SESSION['user']['role'], $permission)) {
            die('🚫 Bạn không có quyền truy cập!');
        }
    }
}

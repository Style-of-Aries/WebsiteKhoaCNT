<?php
class PermissionService
{

    private static function getPermissions() {
        $path = dirname(__DIR__) . '/config/permissions.php';

        if (!file_exists($path)) {
            die('❌ Không tìm thấy file permissions.php tại: ' . $path);
        }

        return require $path;
    }

    public static function has($role, $permission)
    {
        $permissions = self::getPermissions();

        if ($role === 'admin')
            return true;

        return in_array($permission, $permissions[$role] ?? []);
    }
}   

<?php

use LDAP\Result;

require_once '../models/userModel.php';
require_once '../models/studentModel.php';
require_once '../models/timetableModel.php';
require_once '../models/course_classesModel.php';
require_once '../models/resultModel.php';
require_once '../config/config.php';
require_once '../models/classesModel.php';
require_once '../models/departmentModel.php';
require_once '../models/academicResultsModel.php';
class studentController
{
    private $academicResultsModel;
    private $connect;
    private $courseClassModel;
    private $studentModel;
    private $classesModel;
    private $departmentModel;
    private $timetableModel;
    private $userModel;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->academicResultsModel = new academicResultsModel($connect);
        $this->userModel = new userModel($connect);
        $this->classesModel = new classesModel($connect);
        $this->departmentModel = new departmentModel($connect);
        $this->studentModel = new studentModel($connect);
        $this->timetableModel = new timetableModel($connect);
        $this->courseClassModel = new course_classesModel($connect);
    }


    public function index()
    {
        $students = $this->studentModel->getAll();
        require_once './../views/user/student/index.php';
    }
    public function profile()
    {
        $user = $_SESSION['user'];
        $profile = $this->studentModel->getAllProfile($user['ref_id']);
        $_SESSION['profile'] = $profile;
        $id = $user['ref_id'];
        $classes = $this->classesModel->getAll();
        $department = $this->departmentModel->getAll();
        $student = $this->studentModel->getById($id);
        $studentprf = $this->studentModel->getById($id);
        $userNd = $this->userModel->getByRef_id($id);
        // include "./../views/user/profile.php";
        require_once '../views/user/student/profileNew.php';
    }

    public function getAllResult()
    {

        if (!isset($_SESSION['user'])) {
            header("Location: index.php");
            exit;
        }
        $studentId = $_SESSION['user']['ref_id'];

        $result = $this->academicResultsModel->getStudentGrades($studentId);
        $statistics = mysqli_fetch_assoc($this->academicResultsModel->getStudentStatistics($studentId));

        require_once './../views/user/student/result.php';
    }


    public function getSchedule()
    {
        include "./../views/user/schedule.php";
    }
    public function lichHoc()
    {
        $studentId = $_SESSION['user']['ref_id'];
        $weeks = $this->timetableModel->getWeeksOfActiveSemester();

        $week = isset($_GET['week']) ? (int) $_GET['week'] : null;

        if ($week) {
            $timetables = $this->timetableModel->lichHocSvTheoTuan($studentId, $week);
        } else {
            $timetables = [];
        }

        include "./../views/user/student/lichHoc.php";
    }


    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectProfile();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirectProfile();
        }

        $student_id = $_SESSION['user']['ref_id'];

        // 1. Lấy dữ liệu từ form
        $data = $this->getProfileDataFromPost();

        // 2. Xử lý avatar
        $avatar = $this->handleAvatarUpload($student_id);
        if ($avatar !== null) {
            $data['avatar'] = $avatar;
        }

        // 3. Update DB
        $result = $this->studentModel->updateProfile($student_id, $data);

        // 4. Thông báo + redirect
        $this->setMessageAndRedirect($result);
    }

    private function getProfileDataFromPost()
    {
        return [
            'gender' => !empty($_POST['gender']) ? $_POST['gender'] : null,
            'date_of_birth' => !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null,
            'email' => !empty($_POST['email']) ? trim($_POST['email']) : null,
            'phone' => !empty($_POST['phone']) ? trim($_POST['phone']) : null,
            'address' => !empty($_POST['address']) ? trim($_POST['address']) : null,
            'identity_number' => !empty($_POST['identity_number']) ? trim($_POST['identity_number']) : null,
        ];
    }

    private function handleAvatarUpload($student_id)
    {
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== 0) {
            return null;
        }

        $uploadDir = BASE_PATH . '/public/upload/avatar/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $file = $_FILES['avatar'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExt, $allowedExt)) {
            return null;
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            return null;
        }

        $newFileName = 'student_' . $student_id . '_' . time() . '.' . $fileExt;
        $destination = $uploadDir . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return null;
        }

        // Xóa avatar cũ
        $oldProfile = $this->studentModel->getAllProfile($student_id);
        if ($oldProfile && !empty($oldProfile['avatar'])) {
            $oldAvatarPath = $uploadDir . $oldProfile['avatar'];
            if (file_exists($oldAvatarPath)) {
                unlink($oldAvatarPath);
            }
        }

        return $newFileName;
    }

    private function setMessageAndRedirect($success)
    {
        if ($success) {
            $_SESSION['success'] = 'Cập nhật thông tin thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại!';
        }

        header('Location: index.php?controller=student&action=profile');
        exit;
    }

    private function redirectProfile()
    {
        header('Location: index.php?controller=student&action=profile');
        exit;
    }

    public function getCourseClass()
    {
        $studentId = $_SESSION['user']['ref_id'];
        $classes = $this->courseClassModel->getCourseClassSV($studentId);
        require_once '../views/user/student/dangKyLop.php';
    }
    public function registerCourseClass()
    {
        $studentId = $_SESSION['user']['ref_id'];
        $classId = $_GET['class_id'];
        // var_dump($studentId);
        // var_dump($classId);
        // die;
        // 1. Đã đăng ký rồi thì không cho nữa
        if ($this->courseClassModel->isRegistered($studentId, $classId) != 0) {
            $_SESSION['error'] = 'Bạn đã đăng ký lớp này rồi';
            // header('Location: index.php?controller=student&action=course');
            $this->getCourseClass();
            exit;
        }

        // 2. Thực hiện đăng ký
        $this->courseClassModel->register($studentId, $classId);

        $_SESSION['success'] = 'Đăng ký thành công';
        $this->getCourseClass();
    }
}

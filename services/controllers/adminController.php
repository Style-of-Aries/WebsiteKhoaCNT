<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
require_once "./../models/departmentModel.php";
require_once "./../models/semesterModel.php";
require_once "./../models/studentSemesterModel.php";
class adminController
{
    private $connect;


    private $model;
    private $studentSemesterModel;
    private $userModel;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $semesterModel;
    private $departmentModel;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->model = new adminModel($connect);
        $this->semesterModel = new semesterModel($connect);
        $this->studentModel = new studentModel($connect);
        $this->studentSemesterModel = new studentSemesterModel($connect);
        $this->userModel = new userModel($connect);
        $this->lecturerModel = new lecturerModel($connect);
        $this->classesModel = new classesModel($connect);
        $this->departmentModel = new departmentModel($connect);
    }

    // giao diện dashboard
    public function index()
    {
        $totalSinhVien = $this->studentModel->getAllds();
        $totalGiangVien = $this->lecturerModel->getAll();
        $totalLopHoc = $this->classesModel->getAll();
        $totalKhoa = $this->departmentModel->getAllFaculty();
        $newStudents = $this->studentModel->getNewStudents();
        $facultyData = $this->studentModel->getStudentByFaculty();

        $facultyLabels = [];
        $facultyCount = [];

        foreach ($facultyData as $row) {
            $facultyLabels[] = $row['faculty_name'];
            $facultyCount[] = $row['total_students'];
        }
        require_once './../views/admin/dashboard/dashboard.php';
    }
    // giao diện danh sách người dùng
    public function getAllUser()
    {

        $users = $this->userModel->getAll();
        require_once './../views/admin/users/list.php';
        // require_once './../views/user/profile.php';
    }

    public function no_index()
    {
        // $users = $this->userModel->getAll();
        require_once './../views/admin/users/list_no.php';
    }


    public function getClassesByDepartment()
    {
        $department_id = $_GET['department_id'];

        $classes = $this->classesModel->getByDepartment($department_id);

        echo json_encode($classes);
    }
    // giao diện danh sách sinh viên 
    public function getAllSinhVien()
    {
        $keyword = $_GET['keyword'] ?? '';
        // $student_year = $this->studentSemesterModel->getAcademicYear()
        $faculty_id = $_GET['faculty_id'] ?? null;
        $departments = $this->departmentModel->getAllFacultyNew();
        if (!empty($keyword)) {
            $students = $this->studentModel->searchStudents($keyword);
        } else {
            $students = $this->studentModel->getAll($faculty_id);
        }

        require_once './../views/admin/student/list.php';
    }

    // giao diện danh sách giảng viên 
    public function getAllGiangVien()
    {
        $keyword = $_GET['keyword'] ?? '';

        if (!empty($keyword)) {
            $lecturers = $this->lecturerModel->searchLecturers($keyword);
        } else {
            $lecturers = $this->lecturerModel->getAll();
        }

        require_once './../views/admin/lecturer/list.php';
    }


    // sửa sv 

    public function editSv()
    {
        $errorEmail = $errorMaSv = $errorName = $errorDate = "";
        $id = $_GET['id'];
        $classes = $this->classesModel->getAll();
        $department = $this->departmentModel->getAllDepartment();
        $student = $this->studentModel->getById($id);
        $studentprf = $this->studentModel->getById($id);
        $userNd = $this->userModel->getByRef_id($id);

        require_once './../views/admin/student/edit.php';
    }
    public function chiTiet()
    {
        $errorEmail = $errorMaSv = $errorName = "";
        $id = $_GET['id'];
        $classes = $this->classesModel->getAll();
        $department = $this->departmentModel->getAll();
        $student = $this->studentModel->getById($id);
        $studentprf = $this->studentModel->getById($id);
        $userNd = $this->userModel->getByRef_id($id);

        require_once './../views/admin/student/chitiet.php';
    }
    public function editSinhVien()
    {


        $errorName = '';
        $errorEmail = '';
        $errorMaSv = '';
        $errorDate = '';
        $errorCccd = '';
        $errorSdt = '';



        if (isset($_POST['btn_edit'])) {
            $id = $_POST['id'];
            $student_code = $_POST['student_code'];
            $class_id = $_POST['class_id'];
            $department_id = $_POST['department_id'];
            $created_at = $_POST['created_at'];

            $full_name = $_POST['full_name'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $date_of_birth = $_POST['date_of_birth'];
            $address = $_POST['address'];
            $identity_number = $_POST['identity_number'];
            $education_type = $_POST['education_type'];
            $status = $_POST['status'];

            $username = $_POST['username'];
            $password = $_POST['password'];
            $avatar_old = $_POST['old_avatar']; // giữ nguyên avatar

            $avatarupdate = basename($_FILES['avatar']['name']);
            move_uploaded_file($_FILES['avatar']['tmp_name'], 'upload/avatar/' . $avatarupdate);

            // $sdtRegister = $_POST['phone'];
            if ($this->studentModel->KtMa($id, $student_code)) {
                $errorMaSv = "Mã sinh viên đã tồn tại";
            }
            if ($this->userModel->KtUserName($username, $id)) {
                $errorName = "Tài khoản đã tồn tại";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorEmail = "Email không đúng định dạng";
            } elseif ($this->studentModel->KtEmail($email, $id)) {
                $errorEmail = "Email đã tồn tại";
            }

            $today = date('Y-m-d');

            if ($date_of_birth > $today) {
                $errorDate = "Không được lớn hơn ngày hiện tại";
            }
            if ($this->studentModel->isStudentCodeExists($student_code, $id)) {
                $errorMaSv = "Mã sinh viên đã tồn tại";
            }
            if (!preg_match('/^(03|05|07|08|09)[0-9]{8}$/', $phone)) {
                $errorSdt = "Số điện thoại phải 10 số và bắt đầu bằng 03,05,07,08,09";
            }

            /* Validate CCCD / CMND */
            if (!preg_match('/^([0-9]{9}|[0-9]{12})$/', $identity_number)) {
                $errorCccd = "CMND hoặc CCCD không hợp lệ";
            }


            if (empty($errorName) && empty($errorEmail) && empty($errorMaSv) && empty($errorDate) && empty($errorSdt) && empty($errorCccd)) {
                $this->studentModel->updateStudent($id, $student_code, $department_id, $class_id);
                $this->studentModel->updateStudent_profiles($id, $gender, $full_name, $email, $phone, $date_of_birth, $address, $education_type, $status, $identity_number, $avatarupdate);
                $this->userModel->updateUser($id, $username, $password);
                // ===== ĐỒNG BỘ STUDENT_SEMESTERS =====
                $activeSemester = $this->semesterModel->getActiveSemester();

                if ($activeSemester) {

                    if ($status == 'Bảo lưu') {
                        $this->studentSemesterModel
                            ->updateStatus($id, $activeSemester['id'], 'reserved');
                    }

                    if ($status == 'Đang học') {
                        $this->studentSemesterModel
                            ->updateStatus($id, $activeSemester['id'], 'studying');
                    }
                }

                // header('index.php?controller=admin&action=getAllSinhVien');
                $this->getAllSinhVien();
                // header("Location: index.php?controller=admin&action=getAllSinhVien");
                exit;
            } else {
                // Gán lại dữ liệu vừa nhập để hiển thị lại form
                $student = [
                    'id' => $id,
                    'student_code' => $student_code,
                    'department_id' => $department_id,
                    'class_id' => $class_id,
                    'created_at' => $created_at,
                ];
                $studentprf = [
                    'full_name' => $full_name,
                    'gender' => $gender,
                    'date_of_birth' => $date_of_birth,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'identity_number' => $identity_number,
                    'education_type' => $education_type,
                    'status' => $status,
                    'avatar' => $avatar_old
                ];
                $userNd = [
                    'username' => $username,
                    'password' => $password
                ];
                $classes = $this->classesModel->getAlledit();
                $department = $this->departmentModel->getAlledit();
            }
            include_once "./../views/admin/student/edit.php";
        }
    }


    // bắt đầu thêm sinh viên 


    // truy cập tới giao diện sinh viên
    public function addNguoiDung()
    {


        $department = $this->departmentModel->getAllFaculty();
        require_once './../views/admin/users/add.php';
    }
    public function addSinhVien()
    {
        $errorName = '';
        $errorEmail = '';
        $errorMaSv = '';
        $errorDate = '';
        $errorCccd = '';
        $errorSdt = '';

        $classes = $this->classesModel->getAll();

        $department = $this->departmentModel->getAllDepartment();
        $student_code = $this->studentModel->generateStudentCode();

        require_once './../views/admin/student/addNew.php';
    }
    // thêm mới sinh Đ
    public function add()
    {
        $errorName = '';
        $errorEmail = '';
        $errorMaSv = '';
        $errorDate = '';
        $errorCccd = '';
        $errorSdt = '';
        $student_code = $this->studentModel->generateStudentCode();
        $old = [];
        if (isset($_POST['btn_add'])) {
            $old = $_POST; // lưu toàn bộ dữ liệu form

            $class_id = $_POST['class_id'];
            $department_id = $_POST['department_id'];
            // $year= date('dd/mm/YYYY');


            $student_code = $this->studentModel->generateStudentCode();

            $full_name = $_POST['full_name'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $date_of_birth = $_POST['date_of_birth'];
            $address = $_POST['address'];
            $identity_number = $_POST['identity_number'];
            $education_type = $_POST['education_type'];
            // $status = $_POST['status'];

            // upload avatar
            $avatar = null;
            if (!empty($_FILES['avatar']['name'])) {
                $avatar = time() . '_' . $_FILES['avatar']['name'];
                move_uploaded_file(
                    $_FILES['avatar']['tmp_name'],
                    'upload/avatar/' . $avatar
                );
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorEmail = "Email không đúng định dạng";
            } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
                $errorEmail = "Email phải là @gmail.com";
            } elseif ($this->studentModel->KtEmailAdd($email)) {
                $errorEmail = "Email đã tồn tại";
            }
            if (!preg_match('/^(03|05|07|08|09)[0-9]{8}$/', $phone)) {
                $errorSdt = "Số điện thoại phải 10 số và bắt đầu bằng 03,05,07,08,09";
            }

            /* Validate CCCD / CMND */
            if (!preg_match('/^([0-9]{9}|[0-9]{12})$/', $identity_number)) {
                $errorCccd = "CMND hoặc CCCD không hợp lệ";
            }

            $today = date('Y-m-d');

            if ($date_of_birth > $today) {
                $errorDate = "Không được lớn hơn ngày hiện tại";
            }
            if (empty($errorName) && empty($errorEmail) && empty($errorMaSv) && empty($errorDate) && empty($errorSdt) && empty($errorCccd)) {
                $student = $this->studentModel->addSinhVien($student_code, $class_id, $gender, $education_type, $department_id, $full_name, $email, $phone, $date_of_birth, $address, $identity_number, $avatar);

                if ($student) {
                    $this->getAllSinhVien();
                }
            }
            $classes = $this->classesModel->getAll();

            $department = $this->departmentModel->getAllDepartment();
        }
        include_once "./../views/admin/student/addNew.php";
        // var_dump($student_code);
        // die;
    }

    public function editGv()
    {
        $errorEmail = $errorMaSv = $errorName = "";
        $id = $_GET['id'];
        $user = $this->lecturerModel->getById($id);
        $userNd = $this->userModel->getByRef_id($id);
        $department = $this->departmentModel->getAll();
        require_once './../views/admin/lecturer/edit.php';
    }
    public function editGiangVien()
    {

        if (isset($_POST['btn_edit'])) {
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $lecturer_code = $_POST['lecturer_code'];
            $email = $_POST['email'];
            $department_id = $_POST['department_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            // $sdtRegister = $_POST['phone'];

            if ($this->userModel->KtUserName($username, $id)) {
                $errorName = "Tài khoản đã tồn tại";
            }
            if ($this->lecturerModel->KtMagv($lecturer_code, $id)) {
                $errorMaSv = "Mã giảng viên đã tồn tại";
            }
            if ($this->studentModel->KtEmail($email, $id)) {
                $errorEmail = "Email đã tồn tại";
            }
            if ($this->lecturerModel->KtEmail($email, $id)) {
                $errorEmail = "Email đã tồn tại";
            }
            if ($this->lecturerModel->isLecturerCodeExists($lecturer_code, $id)) {
                $errorMaSv = "Mã giảng viên đã tồn tại";
            }
            if (empty($errorName) && empty($errorEmail) && empty($errorMaSv)) {
                $this->lecturerModel->updateGiangVien($id, $full_name, $lecturer_code, $email, $department_id);
                $this->userModel->updateUser($id, $username, $password);
                $this->getAllGiangVien();
                exit;
            } else {
                // Gán lại dữ liệu vừa nhập để hiển thị lại form
                $user = [
                    'id' => $id,
                    'full_name' => $full_name,
                    'lecturer_code' => $lecturer_code,
                    'email' => $email,
                    'department_id' => $department_id
                ];
                $userNd = [
                    'username' => $username,
                    'password' => $password
                ];
                $department = $this->departmentModel->getAll();
            }
        }
        include_once "./../views/admin/lecturer/edit.php";
    }


    // bắt đầu thêm sinh viên 



    // kết thúc thêm giảng viên 

    // bắt đầu thêm giảng viên 


    // truy cập tới giao diện sinh viên
    public function addGiangVien()
    {
        $department = $this->departmentModel->getAll();
        require_once './../views/admin/lecturer/add.php';
    }
    // thêm mới sinh viên
    public function addGv()
    {
        if ($_POST['btn_add']) {
            $full_name = $_POST['full_name'];
            $lecturer_code = $_POST['lecturer_code'];
            $email = $_POST['email'];
            $department_id = $_POST['department_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $student = $this->lecturerModel->addGiangVien($full_name, $lecturer_code, $email, $department_id);
            if ($student) {
                $this->getAllGiangVien();
            } else {
                $this->no_index();
            }
        }
    }

    // kết thúc thêm sinh viên 

    // xóa người dùng 
    public function deleteUser()
    {
        $id = $_GET['id'];
        $role = $_GET['role'];
        $ref_id = $_GET['ref_id'];
        if ($role == 'student') {
            $this->studentModel->deleteStudent($ref_id);
        } else {
            $this->lecturerModel->deleteLecturer($ref_id);
        }
        $this->userModel->deleteUser($id);
        $this->getAllUser();
    }

    public function deleteStudent()
    {
        $ref_id = $_GET['id'];
        $id = $_GET['id'];
        $this->studentModel->deleteStudent($id);
        $this->studentModel->deleteSprofiles($id);
        $this->userModel->deleteUser($ref_id);
        $this->getAllSinhVien();
    }
    public function deleteLecturer()
    {
        $ref_id = $_GET['id'];
        $id = $_GET['id'];
        $this->lecturerModel->deleteLecturer($ref_id);
        $this->userModel->deleteUser($id);
        $this->getAllGiangVien();
    }
}

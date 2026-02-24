    <?php
    require_once "./../models/adminModel.php";
    require_once "./../models/userModel.php";
    require_once "./../models/studentModel.php";
    require_once "./../models/lecturerModel.php";
    require_once "./../models/classesModel.php";
    require_once "./../models/departmentModel.php";
    class adminController
    {
        private $connect;


        private $model;
        private $userModel;
        private $studentModel;
        private $lecturerModel;
        private $classesModel;
        private $departmentModel;
        public function __construct($connect)
        {
            $this->connect = $connect;
            $this->model = new adminModel($connect);
            $this->studentModel = new studentModel($connect);
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
            $totalKhoa = $this->departmentModel->getAllKhoa();
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


        // giao diện danh sách sinh viên 
        public function getAllSinhVien()
        {
            $keyword = $_GET['keyword'] ?? '';

            if (!empty($keyword)) {
                $students = $this->studentModel->searchStudents($keyword);
            } else {
                $students = $this->studentModel->getAll();
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
            $errorEmail = $errorMaSv = $errorName = "";
            $id = $_GET['id'];
            $classes = $this->classesModel->getAll();
            $department = $this->departmentModel->getAll();
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

                $avatarupdate =  basename($_FILES['avatar']['name']);
                move_uploaded_file($_FILES['avatar']['tmp_name'], 'upload/avatar/' . $avatarupdate);

                // $sdtRegister = $_POST['phone'];
                if ($this->studentModel->KtMa($id, $student_code)) {
                    $errorMaSv = "Mã sinh viên đã tồn tại";
                }
                if ($this->userModel->KtUserName($username, $id)) {
                    $errorName = "Tài khoản đã tồn tại";
                }
                if ($this->studentModel->KtEmail($email, $id)) {
                    $errorEmail = "Email đã tồn tại";
                }
                if ($this->lecturerModel->KtEmail($email, $id)) {
                    $errorEmail = "Email đã tồn tại";
                }
                if ($this->studentModel->isStudentCodeExists($student_code, $id)) {
                    $errorMaSv = "Mã sinh viên đã tồn tại";
                }


                if (empty($errorName) && empty($errorEmail) && empty($errorMaSv)) {
                    $this->studentModel->updateStudent($id, $student_code, $department_id, $class_id);
                    $this->studentModel->updateStudent_profiles($id, $gender, $full_name, $email, $phone, $date_of_birth, $address, $education_type, $status, $identity_number, $avatarupdate);
                    $this->userModel->updateUser($id, $username, $password);
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


            require_once './../views/admin/users/add.php';
        }
        public function addSinhVien()
        {
            $classes = $this->classesModel->getAll();

            $department = $this->departmentModel->getAll();

            require_once './../views/admin/student/addNew.php';
        }
        // thêm mới sinh Đ
        public function add()
        {
            $student_code = $this->studentModel->generateStudentCode();
            if (isset($_POST['btn_add'])) {
                $class_id = $_POST['class_id'];
                $department_id = $_POST['department_id'];
                // $year= date('dd/mm/YYYY');


                $full_name = $_POST['full_name'];
                $gender = $_POST['gender'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $date_of_birth = $_POST['date_of_birth'];
                $address = $_POST['address'];
                $identity_number = $_POST['identity_number'];
                $education_type = $_POST['education_type'];
                $status = $_POST['status'];

                // upload avatar
                $avatar = null;
                if (!empty($_FILES['avatar']['name'])) {
                    $avatar = time() . '_' . $_FILES['avatar']['name'];
                    move_uploaded_file(
                        $_FILES['avatar']['tmp_name'],
                        'upload/avatar/' . $avatar
                    );
                }
                $student = $this->studentModel->addSinhVien($student_code, $class_id, $gender, $education_type, $status, $department_id, $full_name, $email, $phone, $date_of_birth, $address, $identity_number, $avatar);
                if ($student) {
                    $this->getAllSinhVien();
                } else {
                    $this->no_index();
                }
            }
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

                $student = $this->lecturerModel->addGiangVien($full_name, $lecturer_code, $email, $department_id, $username, $password);
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

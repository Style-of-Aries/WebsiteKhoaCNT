<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
require_once "./../models/departmentModel.php";
require_once "./../models/subjectModel.php";
require_once "./../models/course_classesModel.php";
require_once "./../models/semesterModel.php";
require_once "./../models/timetableModel.php";
require_once "./../models/classSessionsModel.php";
require_once "./../models/roomModel.php";



class timetableController
{
    private $userModel;
    private $connect;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    private $classSessionsModel;
    private $subjectModel;
    private $course_classesModel;
    private $semesterModel;
    private $timetableModel;
    private $roomModel;


    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->classSessionsModel = new classSessionsModel($connect);
        $this->classesModel = new classesModel($connect);
        $this->studentModel = new studentModel($connect);
        $this->userModel = new userModel($connect);
        $this->lecturerModel = new lecturerModel($connect);
        $this->departmentModel = new departmentModel($connect);
        $this->subjectModel = new subjectModel($connect);
        $this->course_classesModel = new course_classesModel($connect);
        $this->semesterModel = new semesterModel($connect);
        $this->timetableModel = new timetableModel($connect);
        $this->roomModel = new roomModel($connect);
    }

    public function getAllHocPhan()
    {
        $course_classes = $this->course_classesModel->getAll();
        require_once './../views/admin/course_classes/list.php';
    }


    public function lichHoc()
    {
        $id = $_GET['id'];
        // $timetables = ;
        require_once './../views/admin/timetable/listGv.php';
    }
    public function addHocPhan()
    {
        $errorHocPhan = "";
        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $semester = $this->semesterModel->getAll();
        require_once './../views/admin/course_classes/add.php';
    }
    public function editHocPhan()
    {
        $id = $_GET['id'];
        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $semester = $this->semesterModel->getAll();
        $course_classes = $this->course_classesModel->getById($id);
        require_once './../views/admin/course_classes/edit.php';
    }

    public function tkb()
    {
        $id = (int) $_GET['id'];

        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $rooms = $this->roomModel->getAll();
        $semesters = $this->semesterModel->getAll();
        $semester = $this->semesterModel->layHocKyDangHoatDong();
        $course_classes = $this->course_classesModel->getById($id);

        if (!$semester) {
            die("Chưa có học kỳ đang hoạt động");
        }

        $semesterStart = $semester['start_date'];
        $semesterEnd = $semester['end_date'];

        $totalWeeks = ceil(
            (strtotime($semesterEnd) - strtotime($semesterStart) + 86400)
                / (7 * 86400)
        );

        $errors = [];
        $old = [];

        require_once './../views/admin/timetable/add.php';
    }

    public function add_tkb()
    {
        $errors = [];
        $old = [];

        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $rooms = $this->roomModel->getAll();
        
        $semester = $this->semesterModel->layHocKyDangHoatDong();
        if (!$semester) {
            die("Không có học kỳ đang hoạt động");
        }

        $semester_id = $semester['id'];
        $semesterStart = $semester['start_date'];
        $semesterEnd = $semester['end_date'];

        $totalWeeks = ceil(
            (strtotime($semesterEnd) - strtotime($semesterStart) + 86400)
                / (7 * 86400)
        );

        if (isset($_POST['btn_add'])) {

            $old = $_POST;

            $course_class_id=$_POST['id'];
            // $subject_id = (int) ($_POST['subject_id'] ?? 0);
            // $lecturer_id = (int) ($_POST['lecturer_id'] ?? 0);
            // $max_students = (int) ($_POST['max_students'] ?? 0);

            // MULTI SCHEDULE
            $days = $_POST['day_of_week'] ?? [];
            $sessions = $_POST['session'] ?? [];
            $roomsPost = $_POST['room_id'] ?? [];

            $startWeek = (int) ($_POST['start_week'] ?? 0);
            $endWeek = (int) ($_POST['end_week'] ?? 0);

            // ===== VALIDATE CƠ BẢN =====

            // if (!$subject_id)
            //     $errors['subject_id'] = "Vui lòng chọn môn học";

            // if (!$lecturer_id)
            //     $errors['lecturer_id'] = "Vui lòng chọn giảng viên";

            // if ($max_students <= 0)
            //     $errors['max_students'] = "Sĩ số phải lớn hơn 0";

            if (!$startWeek || !$endWeek)
                $errors['week'] = "Vui lòng chọn đầy đủ tuần học";
            elseif ($startWeek > $endWeek)
                $errors['week'] = "Tuần bắt đầu không được lớn hơn tuần kết thúc";

            if (empty($days))
                $errors['schedule'] = "Vui lòng thêm ít nhất 1 buổi học";

            // ===== VALIDATE MULTI SCHEDULE =====

            if (empty($errors)) {

                foreach ($days as $i => $day) {

                    $day = (int) $day;
                    $session = $sessions[$i] ?? '';
                    $room_id = (int) ($roomsPost[$i] ?? 0);

                    if (!$day || !$session || !$room_id) {
                        $errors['schedule'] = "Vui lòng nhập đầy đủ thông tin các buổi học";
                        break;
                    }

                    // check trùng phòng theo tuần
                    if (
                        $this->timetableModel->checkRoomConflict(
                            $room_id,
                            $day,
                            $session,
                            $startWeek,
                            $endWeek
                        )
                    ) {
                        $errors['schedule'] = "Phòng bị trùng lịch trong khoảng tuần đã chọn";
                        break;
                    }
                }
            }

            // ===== INSERT =====

            if (empty($errors)) {

                // $class_code = $this->course_classesModel->malop($subject_id);

                // $course_class_id = $this->course_classesModel->themHocPhan(
                //     $subject_id,
                //     $lecturer_id,
                //     $semester_id,
                //     $class_code,
                //     $max_students
                // );


                foreach ($days as $i => $day) {

                    $this->timetableModel->themThoiKhoaBieu(
                        $course_class_id,
                        $roomsPost[$i],
                        $day,
                        $sessions[$i],
                        $startWeek,
                        $endWeek
                    );
                }

                // generate session tự động
                $this->classSessionsModel->generateSessions($course_class_id);

                $this->getAllHocPhan();
                exit();
            }
        }

        require_once './../views/admin/course_classes/add.php';
    }
    // thêm 
    public function addhp()
    {
        if ($_POST['btn_add']) {

            $subject_id = $_POST['subject_id'];
            $lecturer_id = $_POST['lecturer_id'];
            $semester_id = $_POST['semester_id'];
            $max_students = $_POST['max_students'];
            $class_code = $this->course_classesModel->malop($subject_id);
            if ($this->course_classesModel->checkHocPhan($subject_id, $lecturer_id, $semester_id)) {
                $errorHocPhan = "Giảng viên đã dạy môn này!";
            }
            if (empty($errorHocPhan)) {
                $course_classes = $this->course_classesModel->addHocPhan($subject_id, $lecturer_id, $semester_id, $class_code, $max_students);
                if ($course_classes) {
                    $this->getAllHocPhan();
                    exit();
                }
            } else {
                $subject = $this->subjectModel->getAll();
                $lecturer = $this->lecturerModel->getAll();
                $semester = $this->semesterModel->getAll();
            }
        }
        include_once "./../views/admin/course_classes/add.php";
    }
    // sửa 
    public function edithp()
    {
        if ($_POST['btn_edit']) {
            $id = $_POST['id'];
            $subject_id = $_POST['subject_id'];
            $lecturer_id = $_POST['lecturer_id'];
            $semester_id = $_POST['semester_id'];
            $max_students = $_POST['max_students'];
            $class_code = $_POST['class_code'];
            if ($this->course_classesModel->checkHocPhan($subject_id, $lecturer_id, $semester_id)) {
                $errorHocPhan = "Giảng viên đã dạy môn này!";
            }
            if (empty($errorHocPhan)) {
                $course_classes = $this->course_classesModel->editHocPhan($id, $subject_id, $lecturer_id, $semester_id, $class_code, $max_students);
                if ($course_classes) {
                    $this->getAllHocPhan();
                    exit();
                }
            } else {

                $course_classes = [
                    'max_students' => $max_students,
                    'class_code' => $class_code,
                    'id' => $id,
                    'subject_id' => $subject_id,
                    'lecturer_id' => $lecturer_id,
                    'semester_id' => $semester_id
                ];
                $subject = $this->subjectModel->getAll();
                $lecturer = $this->lecturerModel->getAll();
                $semester = $this->semesterModel->getAll();
            }
        }
        include_once "./../views/admin/course_classes/edit.php";
    }





    public function addTkb()
    {
        $errorHocPhan = "";
        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $semesters = $this->semesterModel->getAll();
        $semester = $this->semesterModel->getActiveSemester();

        if (!$semester) {
            die("Chưa có học kỳ đang hoạt động");
        }

        // 2. ngày bắt đầu & kết thúc học kỳ
        $semesterStart = $semester['start_date']; // YYYY-MM-DD
        $semesterEnd = $semester['end_date'];   // YYYY-MM-DD

        // 3. tính tổng số tuần
        $days = (strtotime($semesterEnd) - strtotime($semesterStart)) / 86400 + 1;
        $totalWeeks = ceil($days / 7);

        $totalWeeks = ceil(
            (strtotime($semesterEnd) - strtotime($semesterStart) + 86400)
                / (7 * 86400)
        );
        $rooms = $this->roomModel->getAll();
        require_once './../views/admin/course_classes/add.php';
    }
    public function editTkb()
    {
        $id = (int) $_GET['id'];

        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $rooms = $this->roomModel->getAll();

        $semester = $this->semesterModel->getActiveSemester();
        if (!$semester)
            die("Chưa có học kỳ đang hoạt động");

        $semesterStart = $semester['start_date'];
        $semesterEnd = $semester['end_date'];

        $totalWeeks = ceil(
            (strtotime($semesterEnd) - strtotime($semesterStart) + 86400)
                / (7 * 86400)
        );

        $course_classes = $this->course_classesModel->getById($id);
        $timetable = $this->timetableModel->getByCourseClassId($id);

        $errors = [];

        require_once './../views/admin/course_classes/edit.php';
    }

    // thêm 
    public function add()
    {
        $errors = [];
        $old = [];

        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $rooms = $this->roomModel->getAll();

        $semester = $this->semesterModel->layHocKyDangHoatDong();
        if (!$semester) {
            die("Không có học kỳ đang hoạt động");
        }

        $semester_id = $semester['id'];
        $semesterStart = $semester['start_date'];
        $semesterEnd = $semester['end_date'];

        $totalWeeks = ceil(
            (strtotime($semesterEnd) - strtotime($semesterStart) + 86400)
                / (7 * 86400)
        );

        if (isset($_POST['btn_add'])) {

            $old = $_POST;

            $subject_id = (int) ($_POST['subject_id'] ?? 0);
            $lecturer_id = (int) ($_POST['lecturer_id'] ?? 0);
            $max_students = (int) ($_POST['max_students'] ?? 0);
            $day = (int) ($_POST['day_of_week'] ?? 0);
            $session = $_POST['session'] ?? '';
            $room_id = (int) ($_POST['room_id'] ?? 0);
            $startWeek = (int) ($_POST['start_week'] ?? 0);
            $endWeek = (int) ($_POST['end_week'] ?? 0);

            // validate 
            if (!$subject_id) {
                $errors['subject_id'] = "Vui lòng chọn môn học";
            }

            if (!$lecturer_id) {
                $errors['lecturer_id'] = "Vui lòng chọn giảng viên";
            }

            if ($max_students <= 0) {
                $errors['max_students'] = "Sĩ số phải lớn hơn 0";
            }

            if (!$day) {
                $errors['day_of_week'] = "Vui lòng chọn thứ học";
            }

            if (!$session) {
                $errors['session'] = "Vui lòng chọn buổi học";
            }

            if (!$room_id) {
                $errors['room_id'] = "Vui lòng chọn phòng học";
            }

            if (!$startWeek || !$endWeek) {
                $errors['week'] = "Vui lòng chọn đầy đủ tuần học";
            } elseif ($startWeek > $endWeek) {
                $errors['week'] = "Tuần bắt đầu không được lớn hơn tuần kết thúc";
                $semester = $this->semesterModel->getActiveSemester();
                if (!$semester)
                    die("Chưa có học kỳ đang hoạt động");

                $semesterStart = $semester['start_date'];
                $semesterEnd = $semester['end_date'];

                $totalWeeks = ceil(
                    (strtotime($semesterEnd) - strtotime($semesterStart) + 86400)
                        / (7 * 86400)
                );
            }

            // validate 
            if (empty($errors)) {

                if (
                    $this->course_classesModel->tonTaiHocPhan(
                        $subject_id,
                        $lecturer_id,
                        $semester_id
                    )
                ) {
                    $errors['lecturer_id'] = "Giảng viên đã dạy môn này trong học kỳ";
                }

                if (
                    $this->timetableModel->phongDaCoLich(
                        $room_id,
                        $day,
                        $session
                    )
                ) {
                    $errors['room_id'] = "Phòng học đã có lịch";
                }
            }

            //    thêm 
            if (empty($errors)) {

                $class_code = $this->course_classesModel->malop($subject_id);

                $course_class_id = $this->course_classesModel->themHocPhan(
                    $subject_id,
                    $lecturer_id,
                    $semester_id,
                    $class_code,
                    $max_students
                );

                $this->timetableModel->themThoiKhoaBieu(
                    $course_class_id,
                    $room_id,
                    $day,
                    $session,
                    $startWeek,
                    $endWeek
                );
                $this->classSessionsModel->generateSessions($course_class_id);
                $this->getAllHocPhan();
                exit();
            }
        }

        require_once './../views/admin/course_classes/add.php';
    }



    // sửa 
    public function edit()
    {
        $errors = [];

        if (isset($_POST['btn_edit'])) {

            $id = (int) $_POST['id'];
            $subject_id = (int) $_POST['subject_id'];
            $lecturer_id = (int) $_POST['lecturer_id'];
            $max_students = (int) $_POST['max_students'];

            $day = (int) $_POST['day_of_week'];
            $session = $_POST['session'];
            $room_id = (int) $_POST['room_id'];
            $startWeek = (int) $_POST['start_week'];
            $endWeek = (int) $_POST['end_week'];

            $semester = $this->semesterModel->getActiveSemester();
            $semester_id = $semester['id'];

            // validate 
            if (!$subject_id)
                $errors['subject_id'] = "Vui lòng chọn môn học";
            if (!$lecturer_id)
                $errors['lecturer_id'] = "Vui lòng chọn giảng viên";
            if ($max_students <= 0)
                $errors['max_students'] = "Sĩ số phải > 0";

            if (!$day)
                $errors['day_of_week'] = "Chọn thứ học";
            if (!$session)
                $errors['session'] = "Chọn buổi học";
            if (!$room_id)
                $errors['room_id'] = "Chọn phòng học";

            if (!$startWeek || !$endWeek || $startWeek > $endWeek) {
                $errors['week'] = "Tuần học không hợp lệ";
            }

            if (
                $this->timetableModel->phongDaCoLichEdit(
                    $room_id,
                    $day,
                    $session,
                    $id
                )
            ) {
                $errors['room_id'] = "Phòng đã có lịch";
            }

            // update 
            if (empty($errors)) {

                $this->course_classesModel->editHocPhan(
                    $id,
                    $subject_id,
                    $lecturer_id,
                    $semester_id,
                    $_POST['class_code'],
                    $max_students
                );

                $this->timetableModel->updateTimetable(
                    $id,
                    $room_id,
                    $day,
                    $session,
                    $startWeek,
                    $endWeek
                );

                $this->getAllHocPhan();
                exit();
            }

            // nếu lỗi → load lại view + giữ dữ liệu
            $subject = $this->subjectModel->getAll();
            $lecturer = $this->lecturerModel->getAll();
            $rooms = $this->roomModel->getAll();

            $course_classes = $this->course_classesModel->getById($id);

            // giữ timetable từ POST
            $timetable = [
                'day_of_week' => $day,
                'session' => $session,
                'room_id' => $room_id,
                'start_week' => $startWeek,
                'end_week' => $endWeek
            ];

            // ⚠️ BẮT BUỘC: cấp lại dữ liệu học kỳ cho view
            $semester = $this->semesterModel->getActiveSemester();
            $semesterStart = $semester['start_date'];
            $semesterEnd = $semester['end_date'];

            $totalWeeks = ceil(
                (strtotime($semesterEnd) - strtotime($semesterStart) + 86400)
                    / (7 * 86400)
            );
        }

        require_once './../views/admin/course_classes/edit.php';
    }

    public function deleteHocPhan()
    {
        if (!isset($_GET['id'])) {
            $this->getAllHocPhan();
            return;
        }

        $id = (int) $_GET['id'];

        // // Xóa điểm
        // $this->course_classesModel->deleteAcademicResults($id);

        // //  Xóa điểm danh
        // $this->course_classesModel->deleteAttendance($id);

        // //  Xóa sinh viên đăng ký học phần
        // $this->course_classesModel->deleteStudentCourseClass($id);

        // //  Xóa thời khóa biểu
        // $this->timetableModel->deleteByCourseClassId($id);

        // // Xóa học phần
        $this->course_classesModel->deleteHocPhanOnly($id);

        // Quay lại danh sách
        $this->getAllHocPhan();
    }
}

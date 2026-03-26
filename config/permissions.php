<?php
return [
    'admin' => ['*'],

    'lecturer' => [
        'attendance', 'score', 'dashboard', 'result'
    ],

    'academic_affairs' => [
        'dashboard', 'timetable'
    ],

    'training_office' => [
        'departments', 'subjects', 'classes', 'course_classes', 'dashboard', 'training', 'semesters', 'room'
    ],

    'student_affairs' => [
        'students', 'dashboard'
    ],

    'exam_office' => [
        'score', 'view_scores', 'dashboard', 'result'
    ]
];

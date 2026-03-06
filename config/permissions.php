<?php
return [
    'admin' => ['*'],

    'lecturer' => [
        'attendance', 'score', 'dashboard', 'result', 'timetable'
    ],

    'academic_affairs' => [
        'students', 'classes', 'course_classes', 'view_scores', 'dashboard', 'timetable'
    ],

    'training_office' => [
        'departments', 'subjects', 'classes', 'course_classes', 'dashboard', 'training'
    ],

    'student_affairs' => [
        'students', 'dashboard'
    ],

    'exam_office' => [
        'score', 'view_scores', 'dashboard'
    ]
];

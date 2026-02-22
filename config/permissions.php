<?php
return [
    'admin' => ['*'],

    'lecturer' => [
        'attendance', 'score', 'view_scores', 'dashboard'
    ],

    'academic_affairs' => [
        'students', 'classes', 'course_classes', 'view_scores', 'dashboard'
    ],

    'training_office' => [
        'departments', 'subjects', 'classes', 'course_classes', 'timetable', 'dashboard', 'training'
    ],

    'student_affairs' => [
        'students', 'dashboard'
    ],

    'exam_office' => [
        'score', 'view_scores', 'dashboard'
    ]
];

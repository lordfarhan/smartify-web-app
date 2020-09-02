<?php
return [
  // Welcome
  'welcome' => [
    'privacy' => 'Privacy and Policy',
    'dashboard' => 'Dashboard',
    'login' => 'Login',
    'register' => 'Register',
  ],

  // Header
  'header' => [
    'home' => 'Home',
    'contact' => 'Contact',
  ],

  // Sidebar
  'sidebar' => [
    'dashboard' => 'Dashboard',
    'institutions' => 'Institutions',
    'users' => 'Users',
    'roles' => 'Roles',
    'academic' => 'Academic',
    'teachers' => 'Teachers',
    'students' => 'Students',
    'subjects' => 'Subjects',
    'grades' => 'Grades',
    'courses' => 'Courses',
    'schedules' => 'Schedules',
    'utilities' => 'Utilities',
    'musics' => 'Musics',
    'quotes' => 'Quotes',
    'settings' => 'Settings',
  ],

  // Dashboard
  'dashboard' => [
    'more_info' => 'More info',
    'courses' => 'Courses',
    'schedules' => 'Schedules',
    'users' => 'Users',
  ],

  // Institutes
  'institutions' => [
    'attributes' => [
      'no' => 'No',
      'name' => 'Name',
      'name_placeholder' => 'Institution Name',
      'image' => 'Image',
      'name' => 'Name',
      'description' => 'Description',
      'description_placeholder' => 'Optional information about institution',
      'action' => 'Action',
      'code' => 'Code',
      'is_activated' => 'Is Activated',
      'activated_by' => 'Activated By'
    ],
    'actions' => [
      'browse' => 'Browse',
      'add' => 'Add',
      'import' => 'Import',
      'back' => 'Back',
      'process' => 'Process',
      'create' => 'Add New',
      'cancel' => 'Cancel',
    ],
    'index' => [
      'title' => 'Institution Management',
    ],
    'create' => [
      'title' => 'Add Institution',
    ],
    'edit' => [
      'title' => 'Edit Institution',
    ],
    'show' => [
      'title' => 'Activation Codes',
      'add_from_file' => 'If you want to add from file, click browse'
    ]
  ],

  // Users
  'users' => [
    'attributes' => [
      'no' => 'No',
      'verified' => 'Verified',
      'name' => 'Name',
      'name_placeholder' => 'User Name',
      'email' => 'Email',
      'email_placeholder' => 'user@codeiva.com',
      'phone' => 'Phone',
      'phone_placeholder' => '0811111111',
      'address' => 'Address',
      'address_placeholder' => 'Complete Address',
      'province' => 'Province',
      'province_placeholder' => 'Select Province',
      'regency' => 'Regency',
      'regency_placeholder' => 'Select Regency',
      'district' => 'District',
      'district_placeholder' => 'Select District',
      'village' => 'Village',
      'village_placeholder' => 'Select Village',
      'roles' => 'Roles',
      'institution' => 'Institution',
      'date_of_birth' => 'Date of Birth',
      'gender' => 'Gender',
      'gender_placeholder' => 'Select user gender',
      'image' => 'Image',
      'password' => 'Password',
      'password_placeholder' => 'Put your strong password',
      'confirm_password' => 'Confirm Password',
      'confirm_password_placeholder' => 'Make sure it matches with the password',
      'action' => 'Action',
    ],
    'actions' => [
      'process' => 'Process',
      'back' => 'Back',
      'create' => 'Add New User',
    ],
    'index' => [
      'title' => 'User Management',
    ],
    'create' => [
      'title' => 'Add User',
    ],
    'edit' => [
      'title' => 'Edit User',
    ],
    'show' => [
      'title' => 'User Detail',
      'joined_at' => 'Joined at',
      'verified_at' => 'Verified at',
      'last_update' => 'Last Update',
      'about' => 'About',
      'empty' => 'Empty',
      'gender_male' => 'Male',
      'gender_female' => 'Female',
      'gender_undefined' => 'Undefined',
    ]
  ],

  // Roles
  'roles' => [
    'attributes' => [
      'no' => 'No',
      'name' => 'Name',
      'name_placeholder' => 'Role Name',
      'permission' => 'Permission',
      'action' => 'Action'
    ],
    'actions' => [
      'back' => 'Back',
      'process' => 'Process',
      'create' => 'Create New Role',
    ],
    'index' => [
      'title' => 'Role Management',
    ],
    'create' => [
      'title' => 'Add Role',
    ],
    'edit' => [
      'title' => 'Edit Role',
    ],
    'show' => [
      'title' => 'Role Detail',
    ],
  ],

  // Subjects
  'subjects' => [
    'attributes' => [
      'no' => 'No',
      'subject' => 'Subject',
      'subject_placeholder' => 'Math',
      'information' => 'Information',
      'information_placeholder' => 'Optional information about subject',
      'action' => 'Action',
    ],
    'actions' => [
      'back' => 'Back',
      'process' => 'Process',
      'create' => 'Add New Subject',
    ],
    'index' => [
      'title' => 'Subject Management',
    ],
    'create' => [
      'title' => 'Create Subject',
    ],
    'edit' => [
      'title' => 'Edit Subject',
    ],
    'show' => [
      'title' => 'Subject Detail',
    ],
  ],

  // Grades
  'grades' => [
    'attributes' => [
      'no' => 'No',
      'grade' => 'Grade',
      'grade_placeholder' => '12',
      'educational_stage' => 'Educational Stage',
      'educational_stage_placeholder' => 'Select Educational Stage',
      'information' => 'Information',
      'information_placeholder' => 'Optional information about grade',
      'action' => 'Action',
    ],
    'actions' => [
      'back' => 'Back',
      'process' => 'Process',
      'create' => 'Add New Grade',
    ],
    'index' => [
      'title' => 'Grade Management',
    ],
    'create' => [
      'title' => 'Create Grade',
    ],
    'edit' => [
      'title' => 'Edit Grade',
    ],
    'show' => [
      'title' => 'Grade Detail',
    ],
  ],

  // Courses
  'courses' => [
    'attributes' => [
      'no' => 'No',
      'author' => 'Author',
      'author_placeholder' => 'Select Author',
      'subject' => 'Subject',
      'subject_placeholder' => 'Select Subject',
      'grade' => 'Grade',
      'grade_placeholder' => 'Select Grade',
      'section' => 'Section (optional)',
      'section_placeholder' => 'Ex: A, B, C, IPA A, IPS A, etc',
      'name' => 'Course Name',
      'name_placeholder' => 'Insert Course Name, ex: English for Beginner',
      'type' => 'Type',
      'type_placeholder' => 'Select Type',
      'enrollment_key' => 'Enrollment Key (only for private type)',
      'enrollment_key_placeholder' => 'Leave empty if your course is public',
      'status' => 'Status',
      'status_placeholder' => 'Select Status',
      'institution' => 'Institution',
      'institution_placeholder' => 'Select Institution',
      'image' => 'Image (optional)',
      'existing_image' => 'Existing Image',
      'attachment_title' => 'Attachment Title',
      'attachment_title_placeholder' => 'Attachement file name',
      'attachment' => 'Attachment (optional)',
      'existing_attachment' => 'Existing Attachment',
      'schedule' => 'Schedule',
      'date' => 'Date',
      'date_placeholder' => 'Pick Date',
      'start_course' => 'Start Course',
      'start_course_placeholder' => 'Pick Time',
      'end_course' => 'End Course',
      'end_course_placeholder' => 'Pick Time',
      'title' => 'Title',
      'chapter' => 'Chapter',
      'chapter_placeholder' => 'Chapter order',
      'chapter_title_placeholder' => 'Chapter Title',
      'sub_chapter' => 'Sub Chapter',
      'sub_chapter_placeholder' => 'A',
      'sub_chapter_title_placeholder' => 'Sub Chapter Title',
      'material_order' => 'Material Order',
      'material_content' => 'Material Content',
      'test_order' => 'Test Order',
      'test_title' => 'Test Title',
      'test_type' => 'Select Type',
      'test_type_chapter' => 'Chapter Test',
      'test_type_middle' => 'Mid Test',
      'test_type_final' => 'Final Test',
      'test_assign' => 'Assign',
      'test_assigned' => 'Assigned',
      'test_not_assigned' => 'Not Assigned',
      'test_submissions' => 'Submissions',
      'test_mark' => 'Mark',
      'duration' => 'Duration',
      'duration_placeholder' => 'Duration (in minute)',
      'description' => 'Description',
      'signer' => 'Signer',
      'not_yet_reported' => 'Not yet reported',
      'present' => 'Present',
      'absent' => 'Absent',
      'votes' => 'Votes',
      'replies' => 'Replies',
      'asked_by' => 'Asked by',
      'on' => 'on',
      'action' => 'Action'
    ],
    'actions' => [
      'process' => 'Process',
      'back' => 'Back',
      'create' => 'Create Course',
      'open' => 'Open',
      'edit' => 'Edit',
      'delete' => 'Delete',
      'post' => 'Post to Forum',
      'add' => 'Add',
      'remove' => 'Remove',
      'cancel' => 'Cancel',
      'replicate' => 'Replicate'
    ],
    'index' => [
      'title' => 'Course Management'
    ],
    'create' => [
      'title' => 'Create Course',
    ],
    'edit' => [
      'title' => 'Edit Course'
    ],
    'show' => [
      'title' => 'Course Detail',
      'created_at' => 'Created at',
      'updated_at' => 'Updated at',
      'chapters' => 'Chapters',
      'sub_chapters' => 'Sub Chapters',
      'materials' => 'Materials',
      'tests' => 'Tests',
      'members' => 'Members',
      'attendances' => 'Attendances',
      'forum' => 'Forum',
      'add_chapter' => 'Add Chapter',
      'add_sub_chapter' => 'Add Sub Chapter',
      'add_test' => 'Add Test',
      'edit_chapter' => 'Edit Chapter',
      'be_careful' => 'Be careful!',
      'be_careful_msg' => 'Are you sure want to delete this item?',
      'edit_test' => 'Edit Test',
      'edit_sub_chapter' => 'Edit Sub Chapter',
    ],
  ],

  // Forum
  'forum' => [
    'attributes' => [
      'title' => 'Title',
      'title_placeholder' => 'Good Title',
      'content' => 'Content',
      'content_placeholder' => 'Write your thought here',
      'reply' => 'Reply',
      'reply_placeholder' => 'Write your reply here',
      'attachment' => 'Attachment',
      'attachment_edit' => 'Attachment (leave empty if you make no change)',
      'attachment_placeholder' => 'File or image is allowed',
    ],
    'actions' => [
      'back' => 'Back',
      'process' => 'Process',
      'download' => 'Download Attachment File',
      'edit' => 'Edit',
      'delete' => 'Delete',
      'reply' => 'Reply',
    ],
    'create' => [
      'title' => 'Post Question'
    ],
    'edit' => [
      'title' => 'Edit Question'
    ],
    'show' => [
      'asked_by' => 'Asked by',
      'replied_by' => 'Replied by',
      'on' => 'on',
      'edited' => 'Edited',
      'replies' => 'Replies',
    ],
  ],

  // Schedules
  'schedules' => [
    'index' => [
      'title' => 'Schedule'
    ]
  ],

  // Tests
  'tests' => [
    'attributes' => [
      'test_order' => 'Test Order',
      'test_title' => 'Test Title',
      'test_type' => 'Select Type',
      'test_type_chapter' => 'Chapter Test',
      'test_type_middle' => 'Mid Test',
      'test_type_final' => 'Final Test',
      'test_assign' => 'Assign',
      'test_assigned' => 'Assigned',
      'test_not_assigned' => 'Not Assigned',
      'description' => 'Description',
      'order_placeholder' => 'Question Order',
      'question_placeholder' => 'Put question here',
      'question_image' => 'Question Image',
      'question_image_placeholder' => 'Browse Question Image',
      'question_image_existed' => 'Existing Question Image',
      'question_audio' => 'Question Audio',
      'question_audio_placeholder' => 'Browse Question Audio',
      'question_audio_existed' => 'Existing Question Audio',
      'correct_answer' => 'Correct Answer',
      'correct_answer_placeholder' => 'This form is the correct answer of it question',
      'multiple_choice' => 'Multiple Choice',
      'true_or_false' => 'True or False',
      'incorrect_answers' => 'Incorrect Answers',
      'incorrect_answer_1' => 'This form is for first incorrect answer',
      'incorrect_answer_2' => 'This form is for second incorrect answer',
      'incorrect_answer_3' => 'This form is for third incorrect answer',
      'incorrect_answer_4' => 'This form is for fourth incorrect answer',
    ],
    'actions' => [
      'back' => 'Back',
      'edit' => 'Edit',
      'delete' => 'Delete',
      'cancel' => 'Cancel',
      'process' => 'Process',
    ],
    'show' => [
      'title' => 'Manage Test',
      'questions' => 'Questions',
      'add_question' => 'Add Question',
      'be_careful' => 'Be Careful!',
      'be_careful_msg' => 'Are you sure want to delete this item?',
    ]
  ],

  // Questions
  'questions' => [
    'attributes' => [
      'order_placeholder' => 'Question Order',
      'question_placeholder' => 'Put question here',
      'question_image' => 'Question Image',
      'question_image_existed' => 'Existing Question Image',
      'question_audio' => 'Question Audio',
      'question_audio_existed' => 'Existing Question Audio',
      'correct_answer' => 'Correct Answer',
      'correct_answer_placeholder' => 'This form is the correct answer of it question',
      'multiple_choice' => 'Multiple Choice',
      'true_or_false' => 'True or False',
      'incorrect_answers' => 'Incorrect Answers',
    ],
    'actions' => [
      'back' => 'Back',
      'delete' => 'Delete',
      'process' => 'Process',
    ],
    'edit' => [
      'title' => 'Edit Question'
    ]
  ],

  // Quotes
  'quotes' => [
    'attributes' => [
      'name' => 'Name',
      'category' => 'Category',
      'quote' => 'Quote',
      'author' => 'Author',
      'image' => 'Image'
    ],
    'index' => [
      'title' => 'Quotes'
    ],
    'create' => [
      'title' => 'Create Quote',
    ],
    'edit' => [
      'title' => 'Edit Quote'
    ]
  ],

  // Settings
  'settings' => [
    'index' => [
      'title' => 'Settings'
    ],
  ],

  // Action
  'actions' => [
    'action' => 'Action',
    'process' => 'Process',
    'back' => 'Back',
    'create' => 'Create'
  ]
];

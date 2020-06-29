<?php
return [
  // Welcome
  'welcome' => [
    'dashboard' => 'Dasbor',
    'login' => 'Masuk',
    'register' => 'Daftar',
  ],

  // Header
  'header' => [
    'home' => 'Beranda',
    'contact' => 'Kontak',
  ],

  // Sidebar
  'sidebar' => [
    'dashboard' => 'Dasbor',
    'institutions' => 'Institusi',
    'users' => 'Pengguna',
    'roles' => 'Wewenang',
    'academic' => 'Akademik',
    'teachers' => 'Guru',
    'students' => 'Siswa',
    'subjects' => 'Mata Pelajaran',
    'grades' => 'Kelas',
    'courses' => 'Kursus',
    'schedules' => 'Jadwal',
    'utilities' => 'Utilitas',
    'settings' => 'Pengaturan',
  ],

  // Dashboard
  'dashboard' => [
    'more_info' => 'Selengkapnya',
    'courses' => 'Kursus',
    'schedules' => 'Jadwal',
    'users' => 'Pengguna',
  ],

  // Institutes
  'institutions' => [
    'attributes' => [
      'no' => 'No',
      'name' => 'Nama',
      'name_placeholder' => 'Nama Institusi',
      'image' => 'Gambar',
      'name' => 'Nama',
      'description' => 'Deskripsi',
      'description_placeholder' => 'Informasi tambahan tentang institusi',
      'action' => 'Aksi',
    ],
    'actions' => [
      'back' => 'Kembali',
      'process' => 'Proses',
      'create' => 'Tambah Institusi Baru',
    ],
    'index' => [
      'title' => 'Pengelolaan Institusi',
    ],
    'create' => [
      'title' => 'Tambah Institusi',
    ],
    'edit' => [
      'title' => 'Sunting Institusi',
    ]
  ],

  // Users
  'users' => [
    'attributes' => [
      'no' => 'No',
      'name' => 'Nama',
      'name_placeholder' => 'Nama Pengguna',
      'email' => 'Surel(E-mail)',
      'email_placeholder' => 'user@codeiva.com',
      'phone' => 'Nomor Telepon',
      'phone_placeholder' => '0811111111',
      'address' => 'Alamat',
      'address_placeholder' => 'Alamat Lengkap',
      'province' => 'Provinsi',
      'province_placeholder' => 'Pilih Provinsi',
      'regency' => 'Kabupaten/Kota',
      'regency_placeholder' => 'Pilih Kabupaten/Kota',
      'district' => 'Kecamatan',
      'district_placeholder' => 'Pilih Kecamatan',
      'village' => 'Desa/Kelurahan',
      'village_placeholder' => 'Pilih Desa/Kelurahan',
      'roles' => 'Wewenang',
      'institution' => 'Institusi',
      'date_of_birth' => 'Tanggal Lahir',
      'gender' => 'Jenis Kelamin',
      'gender_placeholder' => 'Pilih Jenis Kelamin',
      'image' => 'Gambar',
      'password' => 'Kata Sandi',
      'password_placeholder' => 'Masukan kata sandi yang kuat',
      'confirm_password' => 'Konfirmasi Kata Sandi',
      'confirm_password_placeholder' => 'Pastikan cocok dengan kata sandi',
      'action' => 'Aksi',
    ],
    'actions' => [
      'process' => 'Proses',
      'back' => 'Kembali',
      'create' => 'Tambah Pengguna Baru',
    ],
    'index' => [
      'title' => 'Pengelolaan Pengguna',
    ],
    'create' => [
      'title' => 'Tambah Pengguna',
    ],
    'edit' => [
      'title' => 'Sunting Pengguna',
    ],
    'show' => [
      'title' => 'Detail Pengguna',
      'joined_at' => 'Bergabung pada',
      'last_update' => 'Terakhir Diperbarui',
      'about' => 'Tentang',
      'empty' => 'Kosong',
      'gender_male' => 'Laki-Laki',
      'gender_female' => 'Perempuan',
      'gender_undefined' => 'Tak Terdefinisikan',
    ]
  ],

  // Roles
  'roles' => [
    'attributes' => [
      'no' => 'No',
      'name' => 'Nama',
      'name_placeholder' => 'Nama Wewenang',
      'permission' => 'Izin',
      'action' => 'Aksi'
    ],
    'actions' => [
      'back' => 'Kembali',
      'process' => 'Proses',
      'create' => 'Buat Wewenang Baru',
    ],
    'index' => [
      'title' => 'Pengelolaan Wewenang',
    ],
    'create' => [
      'title' => 'Tambah Wewenang',
    ],
    'edit' => [
      'title' => 'Sunting Wewenang',
    ],
    'show' => [
      'title' => 'Detail Wewenang',
    ],
  ],

  // Subjects
  'subjects' => [
    'attributes' => [
      'no' => 'No',
      'subject' => 'Mata Pelajaran',
      'subject_placeholder' => 'Matematika',
      'information' => 'Informasi',
      'information_placeholder' => 'Informasi tambahan seputar mata pelajaran',
      'action' => 'Aksi',
    ],
    'actions' => [
      'back' => 'Kembali',
      'process' => 'Proses',
      'create' => 'Tambah Baru',
    ],
    'index' => [
      'title' => 'Pengelolaan Mata Pelajaran',
    ],
    'create' => [
      'title' => 'Tambah Mata Pelajaran',
    ],
    'edit' => [
      'title' => 'Sunting Mata Pelajaran',
    ],
    'show' => [
      'title' => 'Detail Mata Pelajaran',
    ],
  ],

  // Grades
  'grades' => [
    'attributes' => [
      'no' => 'No',
      'grade' => 'Kelas',
      'grade_placeholder' => '12',
      'educational_stage' => 'Jenjang Pendidikan',
      'educational_stage_placeholder' => 'Pilih Jenjang Pendidikan',
      'information' => 'Informasi',
      'information_placeholder' => 'Informasi tambahan mengenai kelas ini',
      'action' => 'Aksi',
    ],
    'actions' => [
      'back' => 'Kembali',
      'process' => 'Proses',
      'create' => 'Tambah Kelas Baru',
    ],
    'index' => [
      'title' => 'Pengelolaan Kelas',
    ],
    'create' => [
      'title' => 'Tambah Kelas',
    ],
    'edit' => [
      'title' => 'Sunting Kelas',
    ],
    'show' => [
      'title' => 'Detail Kelas',
    ],
  ],

  // Courses
  'courses' => [
    'attributes' => [
      'no' => 'No',
      'author' => 'Author',
      'author_placeholder' => 'Pilih Author',
      'subject' => 'Mata Pelajaran',
      'subject_placeholder' => 'Pilih Mata Pelajaran',
      'grade' => 'Kelas',
      'grade_placeholder' => 'Pilih Kelas',
      'section' => 'Bagian (pilihan)',
      'section_placeholder' => 'Contoh: A, B, C, IPA A, IPS A, dsb',
      'name' => 'Nama Kursus',
      'name_placeholder' => 'Masukkan Nama Kursus, misal : Bahasa Indonesia Untuk Kelas 7 SMP',
      'type' => 'Tipe',
      'type_placeholder' => 'Pilih Tipe',
      'enrollment_key' => 'Kunci Pendaftaran (hanya untuk mode privat)',
      'enrollment_key_placeholder' => 'Tinggalkan kosong jika kursus bersifat publik',
      'status' => 'Status',
      'status_placeholder' => 'Pilih Status',
      'institution' => 'Institusi',
      'institution_placeholder' => 'Pilih Institusi',
      'image' => 'Gambar (pilihan)',
      'existing_image' => 'Gambar Yang Telah Ada',
      'attachment_title' => 'Judul Lampiran',
      'attachment_title_placeholder' => 'Nama file lampiran',
      'attachment' => 'Lampiran (pilihan)',
      'existing_attachment' => 'Lampiran Yang Sudah Ada',
      'schedule' => 'Jadwal',
      'date' => 'Tanggal',
      'date_placeholder' => 'Pilih Tanggal',
      'start_course' => 'Kursus Dimulai',
      'start_course_placeholder' => 'Ambil Waktu',
      'end_course' => 'Kursus Selesai',
      'end_course_placeholder' => 'Ambil Waktu',
      'title' => 'Judul',
      'chapter' => 'Bab',
      'chapter_placeholder' => 'Urutan BAB',
      'chapter_title_placeholder' => 'Judul Bab',
      'sub_chapter' => 'Sub Bab',
      'sub_chapter_placeholder' => 'A',
      'sub_chapter_title_placeholder' => 'Judul Sub Bab',
      'material_order' => 'Urutan Materi',
      'material_content' => 'Isi Materi',
      'test_order' => 'Urutan Ujian',
      'test_title' => 'Judul Ujian',
      'test_type' => 'Pilih Tipe',
      'test_type_chapter' => 'Ujian Bab',
      'test_type_middle' => 'Ujian Pertengahan',
      'test_type_final' => 'Ujian Akhir',
      'test_assign' => 'Penugasan',
      'test_assigned' => 'Ditugaskan',
      'test_not_assigned' => 'Tidak Ditugaskan',
      'duration' => 'Durasi',
      'duration_placeholder' => 'Durasi (dalam menit)',
      'description' => 'Deskripsi',
      'signer' => 'Penandatangan',
      'not_yet_reported' => 'Belum dilaportkan',
      'present' => 'Hadir',
      'absent' => 'Tidak Hadir',
      'votes' => 'Suara',
      'replies' => 'Balasan',
      'asked_by' => 'Ditanyakan oleh',
      'on' => 'pada',
      'action' => 'Aksi'
    ],
    'actions' => [
      'process' => 'Proses',
      'back' => 'Kembali',
      'create' => 'Buat Kursus',
      'open' => 'Buka',
      'edit' => 'Sunting',
      'delete' => 'Hapus',
      'post' => 'Pos ke Forum',
      'add' => 'Tambah',
      'remove' => 'Hapus',
      'cancel' => 'Batal',
    ],
    'index' => [
      'title' => 'Pengelolaan Kursus'
    ],
    'create' => [
      'title' => 'Buat Kursus',
    ],
    'edit' => [
      'title' => 'Sunting Kursus'
    ],
    'show' => [
      'title' => 'Detail Kursus',
      'created_at' => 'Dibuat pada',
      'updated_at' => 'Diperbarui pada',
      'chapters' => 'List Bab',
      'sub_chapters' => 'List Sub Bab',
      'materials' => 'List Materi',
      'tests' => 'List Ujian',
      'members' => 'Anggota',
      'attendances' => 'Kehadiran',
      'forum' => 'Forum',
      'add_chapter' => 'Tambah Bab',
      'add_sub_chapter' => 'Tambah Sub Bab',
      'add_test' => 'Tambah Ujian',
      'edit_chapter' => 'Sunting Bab',
      'be_careful' => 'Hati - hati!',
      'be_careful_msg' => 'Apakah anda yakin akan menghapus item ini?',
      'edit_test' => 'Sunting Ujian',
      'edit_sub_chapter' => 'Sunting Sub Bab',
    ],
  ],

  // Forum
  'forum' => [
    'attributes' => [
      'title' => 'Judul',
      'title_placeholder' => 'Judul Headline',
      'content' => 'Isi',
      'content_placeholder' => 'Apa yang anda pikirkan?',
      'reply' => 'Balasan',
      'reply_placeholder' => 'Tulis balasan anda disini',
      'attachment' => 'Lampiran',
      'attachment_edit' => 'Lampiran (kosongkan bila tidak mengubah lampiran sebelumnya)',
      'attachment_placeholder' => 'File atau gambar diperbolehkan',
    ],
    'actions' => [
      'back' => 'Kembali',
      'process' => 'Proses',
      'download' => 'Unduh Lampiran',
      'edit' => 'Sunting',
      'delete' => 'Hapus',
      'reply' => 'Balas',
    ],
    'create' => [
      'title' => 'Kirim Pertanyaan'
    ],
    'edit' => [
      'title' => 'Sunting Pertanyaan'
    ],
    'show' => [
      'asked_by' => 'Ditanyakan oleh',
      'replied_by' => 'Dibalas oleh',
      'on' => 'pada',
      'edited' => 'Disunting',
      'replies' => 'Balasan',
    ],
  ],

  // Schedules
  'schedules' => [
    'index' => [
      'title' => 'Jadwal'
    ]
  ],

  // Tests
  'tests' => [
    'attributes' => [
      'test_order' => 'Urutan Ujian',
      'test_title' => 'Judul Ujian',
      'test_type' => 'Pilih Tipe',
      'test_type_chapter' => 'Ujian Bab',
      'test_type_middle' => 'Ujian Pertengahan',
      'test_type_final' => 'Ujian Akhir',
      'test_assign' => 'Penugasan',
      'test_assigned' => 'Ditugaskan',
      'test_not_assigned' => 'Tidak Ditugaskan',
      'description' => 'Deskripsi',
      'order_placeholder' => 'Urutan Soal',
      'question_placeholder' => 'Masukkan soal disini',
      'question_image' => 'Soal Gambar',
      'question_image_placeholder' => 'Cari gambar',
      'question_image_existed' => 'Soal Gambar yang Telah Ada',
      'question_audio' => 'Soal Audio',
      'question_audio_placeholder' => 'Cari file audio',
      'question_audio_existed' => 'Soal Audio yang Telah Ada',
      'correct_answer' => 'Jawaban Benar',
      'correct_answer_placeholder' => 'Form ini untuk jawaban yang benar pada soal ini',
      'multiple_choice' => 'Pilihan Ganda',
      'true_or_false' => 'True or False',
      'incorrect_answers' => 'Jawaban-Jawaban Salah',
      'incorrect_answer_1' => 'Form ini untuk jawaban salah yang pertama',
      'incorrect_answer_2' => 'Form ini untuk jawaban salah yang kedua',
      'incorrect_answer_3' => 'Form ini untuk jawaban salah yang ketiga',
      'incorrect_answer_4' => 'Form ini untuk jawaban salah yang keempat',
    ],
    'actions' => [
      'back' => 'Kembali',
      'edit' => 'Sunting',
      'delete' => 'Hapus',
      'cancel' => 'Batal',
      'process' => 'Proses',
    ],
    'show' => [
      'title' => 'Kelola Ujian',
      'questions' => 'Soal - Soal',
      'add_question' => 'Tambah Soal',
      'be_careful' => 'Hati - Hati!',
      'be_careful_msg' => 'Apakah anda yakin akan menghapus item ini?',
    ]
  ],

  // Questions
  'questions' => [
    'attributes' => [
      'order_placeholder' => 'Urutan Soal',
      'question_placeholder' => 'Masukkan soal disini',
      'question_image' => 'Soal Gambar',
      'question_image_existed' => 'Soal Gambar yang Telah Ada',
      'question_audio' => 'Soal Audio',
      'question_audio_existed' => 'Soal Audio yang Telah Ada',
      'correct_answer' => 'Jawaban Benar',
      'correct_answer_placeholder' => 'Form ini untuk jawaban yang benar pada soal ini',
      'multiple_choice' => 'Pilihan Ganda',
      'true_or_false' => 'True or False',
      'incorrect_answers' => 'Jawaban-Jawaban Salah',
    ],
    'actions' => [
      'back' => 'Kembali',
      'delete' => 'Hapus',
      'process' => 'Proses',
    ],
    'edit' => [
      'title' => 'Sunting Question'
    ]
  ],

  // Settings
  'settings' => [
    'index' => [
      'title' => 'Settings'
    ],
  ],
];

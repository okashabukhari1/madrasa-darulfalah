<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/about', 'about')->name('about');
Route::get('/courses', [HomeController::class, 'courses'])->name('courses');
Route::get('/courses/{slug}', [HomeController::class, 'courseDetails'])->name('public.courses.show');
Route::get('/teachers', [HomeController::class, 'teachers'])->name('teachers');
Route::get('/teachers/{slug}', [HomeController::class, 'teacherDetails'])->name('public.teachers.show');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [\App\Http\Controllers\PublicMessageController::class, 'store'])->name('contact.store');
Route::get('/admission', [\App\Http\Controllers\PublicAdmissionController::class, 'index'])->name('admission');
Route::post('/admission', [\App\Http\Controllers\PublicAdmissionController::class, 'store'])->name('admission.store');

// Public Event & Announcement Details
Route::get('/events/{id}', [\App\Http\Controllers\PublicEventController::class, 'show'])->name('public.events.show');
Route::get('/announcements/{id}', [\App\Http\Controllers\PublicAnnouncementController::class, 'show'])->name('public.announcements.show');

Route::get('/books', [HomeController::class, 'books'])->name('books');

// OTP Routes for Password Reset
Route::middleware('guest')->group(function () {
    Route::get('password/otp/request', [OtpController::class, 'showRequestForm'])->name('password.otp.request');
    Route::post('password/otp/send', [OtpController::class, 'sendOtp'])->name('password.otp.send');
    Route::get('password/otp/verify', [OtpController::class, 'showVerifyForm'])->name('password.otp.verify');
    Route::post('password/otp/verify', [OtpController::class, 'verifyOtp'])->name('password.otp.verify.submit');
    Route::get('password/otp/reset', [OtpController::class, 'showResetForm'])->name('password.otp.resetForm');
    Route::post('password/otp/reset', [OtpController::class, 'resetPassword'])->name('password.otp.reset');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('students', AdminStudentController::class);
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('teachers', \App\Http\Controllers\Admin\TeacherController::class);
    Route::get('progress-logs', [\App\Http\Controllers\Admin\ProgressLogController::class, 'index'])->name('progress-logs.index');
    Route::resource('admissions', \App\Http\Controllers\Admin\AdmissionController::class);
    Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);
    Route::resource('messages', \App\Http\Controllers\Admin\MessageController::class);
    Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class);
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::resource('management', \App\Http\Controllers\Admin\StaffController::class);
    Route::resource('materials', \App\Http\Controllers\Admin\MaterialController::class);
    Route::resource('exams', \App\Http\Controllers\Admin\ExamController::class);
    Route::resource('attendance', \App\Http\Controllers\Admin\AttendanceController::class)->only(['index', 'destroy']);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('books', \App\Http\Controllers\Admin\BookController::class);
    Route::resource('book-categories', \App\Http\Controllers\Admin\BookCategoryController::class);

    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});

// Student Routes
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/courses', [\App\Http\Controllers\Student\CourseController::class, 'index'])->name('courses');
    Route::get('/courses/{id}', [\App\Http\Controllers\Student\CourseController::class, 'show'])->name('courses.show');
    Route::get('/attendance', [\App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('attendance');
    Route::get('/exams', [\App\Http\Controllers\Student\ExamController::class, 'index'])->name('exams.index');
    Route::get('/materials', [\App\Http\Controllers\Student\MaterialController::class, 'index'])->name('materials');
    Route::get('/announcements', [\App\Http\Controllers\Student\AnnouncementController::class, 'index'])->name('announcements');
    Route::get('/announcements/{id}', [\App\Http\Controllers\Student\AnnouncementController::class, 'show'])->name('announcements.show');
});

// Teacher Portal Routes
Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');
    
    // Courses
    Route::get('/courses', [\App\Http\Controllers\Teacher\CourseController::class, 'index'])->name('courses');
    Route::get('/courses/{slug}', [\App\Http\Controllers\Teacher\CourseController::class, 'show'])->name('courses.show');
    
    // Unified Progress & Attendance
    Route::get('/progress', [\App\Http\Controllers\Teacher\ProgressController::class, 'index'])->name('progress.index');
    Route::post('/progress', [\App\Http\Controllers\Teacher\ProgressController::class, 'store'])->name('progress.store');
    Route::get('/progress/history', [\App\Http\Controllers\Teacher\ProgressController::class, 'history'])->name('progress.history');

    // Announcements
    Route::get('/announcements', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'index'])->name('announcements');
    Route::get('/announcements/{id}', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'show'])->name('announcements.show');

    // Exams & Evaluations
    Route::resource('exams', \App\Http\Controllers\Teacher\ExamController::class);
});

// Fallback Dashboard Route (for user role or default Breeze auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect(auth()->user()->getRedirectRoute());
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/debug-auth', function() {
        return [
            'check' => auth()->check(),
            'user' => auth()->user(),
            'role' => auth()->user()?->role,
            'isAdmin' => auth()->user()?->isAdmin(),
            'isTeacher' => auth()->user()?->isTeacher(),
        ];
    });
});

require __DIR__.'/auth.php';

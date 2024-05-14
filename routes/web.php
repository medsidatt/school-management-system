<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\exams\FirstExamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentParentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\ClassesController;

Route::middleware('isLoggedIn')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/notfound', function () {
        return view('errors.404');
    })->name('notfound');

    Route::get('logout', [AdminController::class, 'logout'])->name('logout');
    Route::post('login', [AdminController::class, 'login'])->name('login');


});

Route::get('login', [AdminController::class, 'loginForm'])->name('login')->middleware('alreadyLoggedIn');


Route::get('register', [AdminController::class, 'registerForm'])->name('register')->middleware('alreadyLoggedIn');
Route::post('register', [AdminController::class, 'register'])->name('register');

Route::middleware('alreadyLoggedIn')->group(function () {

    Route::get('login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->name('login');

    Route::get('register', [AdminController::class, 'registerForm'])->name('register');
    Route::post('register', [AdminController::class, 'register'])->name('register');
});


Route::middleware('isLoggedIn')->group(function () {

    Route::get('students', [StudentController::class, 'index'])->name('students');
    Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('students/create', [StudentController::class, 'store'])->name('students.create');
    Route::get('students/{id}', [StudentController::class, 'view'])->name('students.view');
    Route::get('students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('students/{id}/edit', [StudentController::class, 'update'])->name('students.edit');
    Route::post('delete-student', [StudentController::class, 'destroy']);
});


Route::middleware('isLoggedIn')->group(function () {

    Route::get('parents', [StudentParentController::class, 'index'])->name('parents');
    Route::get('parents/create', [StudentParentController::class, 'create'])->name('parents.create');
    Route::post('parents/create', [StudentParentController::class, 'store'])->name('parents.create');
    Route::get('parents/{id}', [StudentParentController::class, 'view'])->name('parents.show');

});


Route::middleware('isLoggedIn')->group(function () {

    Route::get('teachers', [TeacherController::class, 'index'])->name('teachers');
    Route::get('teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::get('teachers/{id}', [TeacherController::class, 'view'])->name('teachers.show');
    Route::get('teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('teachers/{id}/edit', [TeacherController::class, 'update'])->name('teachers.edit');
    Route::post('teachers/create', [TeacherController::class, 'store'])->name('teachers.create');
    Route::delete('teachers/{id}/delete', [TeacherController::class, 'destroy'])->name('teachers.delete');

});

Route::middleware('isLoggedIn')->group(function () {

    Route::get('classes', [ClassesController::class, 'index'])->name('classes');
    Route::get('classes/create', [ClassesController::class, 'create'])->name('classes.create');
    Route::post('classes/create', [ClassesController::class, 'store'])->name('classes.create');
    Route::get('classes/{id}/edit', [ClassesController::class, 'edit'])->name('classes.edit.show');
//    Route::put('classes/edit', [ClassesController::class, 'update'])->name('classes.edit');
    Route::post('classes/delete', [ClassesController::class, 'destroy'])->name('classes.delete');
    Route::get('classes/{id}', [ClassesController::class, 'show'])->name('classes.show');
    Route::get('classes/class/students', [ClassesController::class, 'studentsByClass'])->name('studentsByClass');

});

Route::middleware('isLoggedIn')->group(function () {

    Route::get('subject', [SubjectsController::class, 'index'])->name('subjects');
    Route::post('subject', [SubjectsController::class, 'store'])->name('subjects');
    Route::post('subject/delete', [SubjectsController::class, 'destroy'])->name('subjects.delete');

});


Route::middleware('isLoggedIn')->group(function () {

    Route::get('exams/quarters/first-quarter', [FirstExamController::class, 'index'])->name('exams.quarters.first');
    Route::get('exams/quarters/first-quarter/chose', [FirstExamController::class, 'filteredExams'])->name('exams.quarters.first.filtered');
    Route::post('exams/quarters/first-quarter', [FirstExamController::class, 'store'])->name('exams.quarters.first');
    Route::get('exams/quarters/first-quarter/edit', [FirstExamController::class, 'edit'])->name('exams.quarters.first.edit');
    Route::post('exams/quarters/first-quarter/delete', [FirstExamController::class, 'destroy'])->name('exams.quarters.first.delete');
    Route::post('exams/quarters/first-quarter/student-subjects', [FirstExamController::class, 'studentSubjects'])->name('exams.quarters.first.student-subjects');


});

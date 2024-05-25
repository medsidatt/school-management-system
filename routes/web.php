<?php


use App\Http\Controllers\exams\FirstExamController;
use App\Http\Controllers\compositions\CompositionController;
use App\Http\Controllers\compositions\SecondCompositionController;
use App\Http\Controllers\compositions\ThirdCompositionController;
use App\Http\Controllers\exams\SecondExamController;
use App\Http\Controllers\exams\ThirdExamController;
use App\Http\Controllers\tests\FirstTestController;
use App\Http\Controllers\tests\SecondTestController;
use App\Http\Controllers\tests\ThirdTestController;
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
    Route::post('delete-student', [StudentController::class, 'destroy'])->name('students.delete');
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
    Route::get('classes/class/subjects', [ClassesController::class, 'subjectsByClass'])->name('subjectsByClass');

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

    Route::get('exams/quarters/second-quarter', [SecondExamController::class, 'index'])->name('exams.quarters.second');
    Route::get('exams/quarters/second-quarter/chose', [SecondExamController::class, 'filteredExams'])->name('exams.quarters.second.filtered');
    Route::post('exams/quarters/second-quarter', [SecondExamController::class, 'store'])->name('exams.quarters.second');
    Route::get('exams/quarters/second-quarter/edit', [SecondExamController::class, 'edit'])->name('exams.quarters.second.edit');
    Route::post('exams/quarters/second-quarter/delete', [SecondExamController::class, 'destroy'])->name('exams.quarters.second.delete');
    Route::post('exams/quarters/second-quarter/student-subjects', [SecondExamController::class, 'studentSubjects'])->name('exams.quarters.second.student-subjects');

    Route::get('exams/quarters/third-quarter', [ThirdExamController::class, 'index'])->name('exams.quarters.third');
    Route::get('exams/quarters/third-quarter/chose', [ThirdExamController::class, 'filteredExams'])->name('exams.quarters.third.filtered');
    Route::post('exams/quarters/third-quarter', [ThirdExamController::class, 'store'])->name('exams.quarters.third');
    Route::get('exams/quarters/third-quarter/edit', [ThirdExamController::class, 'edit'])->name('exams.quarters.third.edit');
    Route::post('exams/quarters/third-quarter/delete', [ThirdExamController::class, 'destroy'])->name('exams.quarters.third.delete');
    Route::post('exams/quarters/third-quarter/student-subjects', [ThirdExamController::class, 'studentSubjects'])->name('exams.quarters.third.student-subjects');

});



Route::middleware('isLoggedIn')->group(function () {

    Route::get('tests/quarters/first-quarter', [FirstTestController::class, 'index'])->name('tests.quarters.first');
    Route::get('tests/quarters/first-quarter/chose', [FirstTestController::class, 'filteredTests'])->name('tests.quarters.first.filtered');
    Route::post('tests/quarters/first-quarter', [FirstTestController::class, 'store'])->name('tests.quarters.first');
    Route::get('tests/quarters/first-quarter/edit', [FirstTestController::class, 'edit'])->name('tests.quarters.first.edit');
    Route::post('tests/quarters/first-quarter/delete', [FirstTestController::class, 'destroy'])->name('tests.quarters.first.delete');
    Route::post('tests/quarters/first-quarter/student-subjects', [FirstTestController::class, 'studentSubjects'])->name('tests.quarters.first.student-subjects');

    Route::get('tests/quarters/second-quarter', [SecondTestController::class, 'index'])->name('tests.quarters.second');
    Route::get('tests/quarters/second-quarter/chose', [SecondTestController::class, 'filteredTests'])->name('tests.quarters.second.filtered');
    Route::post('tests/quarters/second-quarter', [SecondTestController::class, 'store'])->name('tests.quarters.second');
    Route::get('tests/quarters/second-quarter/edit', [SecondTestController::class, 'edit'])->name('tests.quarters.second.edit');
    Route::post('tests/quarters/second-quarter/delete', [SecondTestController::class, 'destroy'])->name('tests.quarters.second.delete');
    Route::post('tests/quarters/second-quarter/student-subjects', [SecondTestController::class, 'studentSubjects'])->name('tests.quarters.second.student-subjects');

    Route::get('tests/quarters/third-quarter', [ThirdTestController::class, 'index'])->name('tests.quarters.third');
    Route::get('tests/quarters/third-quarter/chose', [ThirdTestController::class, 'filteredTests'])->name('tests.quarters.third.filtered');
    Route::post('tests/quarters/third-quarter', [ThirdTestController::class, 'store'])->name('tests.quarters.third');
    Route::get('tests/quarters/third-quarter/edit', [ThirdTestController::class, 'edit'])->name('tests.quarters.third.edit');
    Route::post('tests/quarters/third-quarter/delete', [ThirdTestController::class, 'destroy'])->name('tests.quarters.third.delete');
    Route::post('tests/quarters/third-quarter/student-subjects', [ThirdTestController::class, 'studentSubjects'])->name('tests.quarters.third.student-subjects');

});


Route::middleware('isLoggedIn')->group(function () {

    Route::get('compositions/quarters/first-quarter', [CompositionController::class, 'index'])->name('compositions.quarters.first');
    Route::get('compositions/quarters/first-quarter/chose', [CompositionController::class, 'filteredCompositions'])->name('compositions.quarters.first.filtered');
    Route::get('compositions/quarters/first-quarter/show', [CompositionController::class, 'show'])->name('compositions.quarters.first.show');
    Route::get('compositions/quarters/first-quarter/resultsToPdf', [CompositionController::class, 'resultsToPdf'])->name('compositions.quarters.first.resultsToPdf');

    Route::get('compositions/quarters/second-quarter', [SecondCompositionController::class, 'index'])->name('compositions.quarters.second');
    Route::get('compositions/quarters/second-quarter/chose', [SecondCompositionController::class, 'filteredCompositions'])->name('compositions.quarters.second.filtered');
    Route::get('compositions/quarters/second-quarter/show', [SecondCompositionController::class, 'show'])->name('compositions.quarters.second.show');
    Route::get('compositions/quarters/second-quarter/resultsToPdf', [SecondCompositionController::class, 'resultsToPdf'])->name('compositions.quarters.second.resultsToPdf');



    Route::get('compositions/quarters/third-quarter', [ThirdCompositionController::class, 'index'])->name('compositions.quarters.third');
    Route::get('compositions/quarters/third-quarter/chose', [ThirdCompositionController::class, 'filteredTests'])->name('compositions.quarters.third.filtered');
    Route::post('compositions/quarters/third-quarter', [ThirdCompositionController::class, 'store'])->name('compositions.quarters.third');
    Route::get('compositions/quarters/third-quarter/edit', [ThirdCompositionController::class, 'edit'])->name('compositions.quarters.third.edit');
    Route::post('compositions/quarters/third-quarter/delete', [ThirdCompositionController::class, 'destroy'])->name('compositions.quarters.third.delete');
    Route::post('compositions/quarters/third-quarter/student-subjects', [ThirdCompositionController::class, 'studentSubjects'])->name('compositions.quarters.third.student-subjects');

});

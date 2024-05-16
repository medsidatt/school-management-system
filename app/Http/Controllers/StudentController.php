<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;

class StudentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Student::with('classes')->get())
                ->addColumn('action', 'students.student-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('students.index');

    }

    public function create() {
        $classes = Classes::all();
        return view('students.create', [
            'classes' => $classes
        ]);
    }
    public function store(StorePostRequest $request): RedirectResponse
    {


        $student_data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'class' => $request->class,
            'date_of_birth' => $request->date_of_birth,
            'rim' => $request->rim
        ];



        // Create student record
        $student = Student::create($student_data);

        if ($student) {
            return redirect(route('students'))->with('success', 'Ajouter avec succès');
        }
        return redirect('students')->with('fail', 'Erreur d\'inscrire cet étudiant');
    }


    public function view($id) {
        $student = $this->getStudentById($id);
        if ($student == null) {
            return redirect('notfound');
        }
        return view('students.show', [
            'student' => $student
        ]);
    }

    public function edit($id) {
        $student = $this->getStudentById($id);
        if ($student == null) {
            return redirect('notfound');
        }
        $classes = Classes::all();
        return view('students.create', [
            'student' => $student,
            'classes'=> $classes
        ]);
    }

    public function update(StorePostRequest $request) {

        $student_data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'class' => $request->class,
            'date_of_birth' => $request->date_of_birth,
            'rim' => $request->rim
        ];

        $student = Student::where('id', $request->id)->first();

        $student = $student->update($student_data);

        return redirect(route('students'))->with('success', 'Modifier avec succès');
//        if ($student) {
//        }
//        return redirect()->back()->with('fail', 'Erreur d\'inscrire cet étudiant');

    }

    public function destroy()
    {
        $student = $this->getStudentById(request()->id);
        if ($student == null) {
            return response()->json(['notfound' => true, 'redirect' => route('notfound')]);
        }else {
            Exam::where('student_id', $student->id)->delete();
            $student->delete();
            return response()->json(['success' => 'L\'etudiant est suprime avec success']);
        }
    }

    private function getStudentById($id)
    {
        return Student::with('classes')->find($id);
    }

}

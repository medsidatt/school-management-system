<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Classes;
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
        return view('students.create', compact('classes'));
    }
    public function store(StorePostRequest $request): RedirectResponse
    {

        $parent_data = [
            'first_name' => $request->p_first_name,
            'last_name' => $request->p_last_name,
            'sex' => $request->p_sex,
            'tel' => $request->p_tel,
            'date_of_birth' => $request->p_date_of_birth,
            'nni' => $request->p_nni
        ];

        $parent_query = StudentParent::where('nni', $parent_data['nni'])->first();
        if(!empty($parent_query) && $parent_query->nni) {
            $parent_id = $parent_query->id;
        }else {
            $student_parent = StudentParent::create($parent_data);
            $parent_id = $student_parent->id;

        }


        $student_data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'parent' => $parent_id,
            'class' => $request->class,
            'date_of_birth' => $request->date_of_birth,
            'rim' => $request->rim
        ];



        // Create student record
        $student = Student::create($student_data);

        if ($student) {
            return redirect()->back()->with('success', 'Ajouter avec succès');
        }
        return redirect()->back()->with('fail', 'Erreur d\'inscrire cet étudiant');
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
            'student' => $student
        ])->with('classes', $classes);
    }

    public function update(StorePostRequest $request) {

//        $validator->validated();

        $parent_data = [
            'first_name' => $request->p_first_name,
            'last_name' => $request->p_last_name,
            'sex' => $request->p_sex,
            'tel' => $request->p_tel,
            'date_of_birth' => $request->p_date_of_birth,
            'nni' => $request->p_nni
        ];

        $student_data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'parent' => $request->p_id,
            'class' => $request->class,
            'date_of_birth' => $request->date_of_birth,
            'rim' => $request->rim
        ];

        $student_parent = StudentParent::where('id', $request->p_id)->first();
        $student = Student::where('id', $request->id)->first();

        $student_parent = $student_parent->update($parent_data);
        $student = $student->update($student_data);

        if ($student && $student_parent) {
            return redirect(route('students'))->with('success', 'Modifier avec succès');
        }
        return redirect()->back()->with('fail', 'Erreur d\'inscrire cet étudiant');

    }

    public function destroy()
    {
        dd('hello');
        $student = $this->getStudentById($id);
        $parent = Student::select('parent', $student->p_id)
            ->where('parent', $student->p_id);
        if ($student == null) {
            return redirect('notfound');
        }
        if ($parent->count() > 1) {
            $student->delete();
            return redirect()->back()->with('success', 'Suprimer avec succès');
        }else {
            $student->delete();
            $parent = StudentParent::find($student->parent);
            $parent->delete();
            return redirect()->back()->with('success', 'Suprimer avec succès');
        }
    }

    private function getStudentById($id)
    {
//        $student = Student::join('parents as p', 'parent', 'p.id')
//            ->join('classes as c', 'class', 'c.id')
//            ->where('students.id',  $id)
//            ->select(
//                'students.*',
//                'c.id as c_id',
//                'c.name as name',
//                'p.id as p_id',
//                'p.first_name as p_fn',
//                'p.nni as p_nni',
//                'p.tel as p_tel',
//                'p.last_name as p_ln',
//                'p.sex as p_sex',
//                'p.date_of_birth as p_dob'
//            )
//            ->first();
        $student = Student::with('classes', 'parents')->find($id);
        return $student;
    }

}

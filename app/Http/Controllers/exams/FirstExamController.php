<?php

namespace App\Http\Controllers\exams;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\StringInput;

class FirstExamController extends Controller
{
    public function index()
    {
        $students = Student::all();
        $subjects = Subjects::all();
        if (request()->ajax()) {
            return datatables()->of(Exam::where('quarter', 1)->with('students', 'subjects')->get())
                ->addColumn('action', 'exams.quarters.first.exam-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('exams.quarters.first.index', [
            'students' => $students,
            'subjects' => $subjects
        ]);

    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required|numeric',
            'student' => 'required',
            'subject' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = [
            'student_id' => $request->input('student'),
            'subject_id' => $request->input('subject'),
            'note' => $request->input('note'),
            'quarter' => 1
        ];

        $exam = Exam::create($data);

        // Assuming you want to return something meaningful upon successful creation
        return response()->json(['success' => true, 'exam' => $exam]);
    }




    public function studentSubjects(Request $request)
    {

        if (request()->ajax()) {
            $studentId = $request->student_id;
            $quarter = 1;

            $subjectsNotTaken = Subjects::whereNotIn('id', function ($query) use ($studentId, $quarter) {
                $query->select('subjects.id')
                    ->from('students')
                    ->join('exams', 'students.id', '=', 'exams.student_id')
                    ->join('subjects', 'subjects.id', '=', 'exams.subject_id')
                    ->where('students.id', $studentId)
                    ->where('exams.quarter', $quarter);
            })->get();

            return response()->json(['subjects' => $subjectsNotTaken ]);
        }

    }


    public function edit()
    {
        if (request()->ajax()) {
            return response()->json(['data' => request()->id ]);
        }
    }
}

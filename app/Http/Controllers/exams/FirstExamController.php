<?php

namespace App\Http\Controllers\exams;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassSubject;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\StringInput;
use Yajra\DataTables\DataTables;

class FirstExamController extends Controller
{
    public function index()
    {

        $classes = Classes::all();
        return view('exams.quarters.first.index', [
            'classes' => $classes
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

        $exams = Exam::where('student_id', $data['student_id'])
            ->where('subject_id', $data['subject_id'])
            ->get();

        if ($request->input('id')) {
            $note = Exam::find($request->input('id'));
            $note->update($data);
            return response()->json(['updated' => 'update']);
        } else
            if ($exams->count() > 0) {
                return response()->json(['exam' => $exams]);
            } else {
                $exam = Exam::create($data);
                return response()->json(['success' => $exam]);
            }
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

            return response()->json(['subjects' => $subjectsNotTaken]);
        }

    }


    public function edit()
    {
        if (request()->ajax()) {
            return response()->json(['data' => request()->id]);
        }
    }

    public function filteredExams(Request $request)
    {
        $classId = $request->class_id;
        $subjects = Subjects::whereHas('classes', function ($query) use ($classId) {
            $query->where('classes.id', $classId);
        })->get(['id', 'name']);

        $students = Student::where('class', $classId)->get();
        return datatables()->of(Exam::join('students', 'students.id', '=', 'exams.student_id')
            ->join('classes', 'classes.id', '=', 'students.class')
            ->join('subjects', 'subjects.id', '=', 'exams.subject_id')
            ->select(
                'exams.id as id', 'exams.note as note',
                'students.id as stu_id', 'students.first_name as stu_fn', 'students.last_name as stu_ln',
                'subjects.id as sub_id', 'subjects.name as sub_name'
            )
            ->where('quarter', 1)
            ->where('classes.id', $classId)
            ->get())
            ->addColumn('action', 'exams.quarters.first.exam-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->with('subjects', $subjects)
            ->with('students', $students)
            ->make(true);
    }

    public function destroy(Request $request)
    {
        if (request()->ajax()) {
            $note = Exam::find(request()->id);
            $note->delete();
            return response()->json(['success' => true]);
        }
    }



}

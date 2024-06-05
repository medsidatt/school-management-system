<?php

namespace App\Http\Controllers\tests;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subjects;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ThirdTestController extends Controller
{
    public function index()
    {

        $classes = Classes::all();
        return view('tests.quarters.third.index', [
            'classes' => $classes
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required|numeric|max:20|min:0',
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
            'quarter' => 3
        ];

        $tests = Test::where('student_id', $data['student_id'])
            ->where('subject_id', $data['subject_id'])
            ->where('quarter', 3)
            ->get();

        if ($request->input('id')) {
            $note = Test::find($request->input('id'));
            $note->update($data);
            return response()->json(['updated' => 'update']);
        } else
            if ($tests->count() > 0) {
                return response()->json(['test' => $tests]);
            } else {
                $test = test::create($data);
                return response()->json(['success' => $test]);
            }
    }


    public function filteredTests(Request $request)
    {
        $classId = $request->class_id;
        $subjects = Subjects::whereHas('classes', function ($query) use ($classId) {
            $query->where('classes.id', $classId);
        })->get(['id', 'name']);

        $students = Student::where('class', $classId)->get();
        return datatables()->of(Test::join('students', 'students.id', '=', 'tests.student_id')
            ->join('classes', 'classes.id', '=', 'students.class')
            ->join('subjects', 'subjects.id', '=', 'tests.subject_id')
            ->select(
                'tests.id as id', 'tests.note as note',
                'students.id AS stu_id', DB::raw('CONCAT(students.first_name, students.last_name) AS stu_name'),
                'subjects.id as sub_id', 'subjects.name as sub_name'
            )
            ->where('quarter', 3)
            ->where('classes.id', $classId)
            ->get())
            ->addColumn('action', 'tests.quarters.third.test-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->with('subjects', $subjects)
            ->with('students', $students)
            ->make(true);
    }

    public function destroy(Request $request)
    {
        if (request()->ajax()) {
            $note = Test::find(request()->id);
            $note->delete();
            return response()->json(['success' => true]);
        }
    }
}

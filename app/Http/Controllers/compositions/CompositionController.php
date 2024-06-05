<?php

namespace App\Http\Controllers\compositions;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassSubject;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompositionController extends Controller
{
    public function index()
    {
//        dd($this->getResultsOfClass(1));
        $classes = Classes::all();
        return view('compositions.quarters.first.index', [
            'classes' => $classes
        ]);
    }

    public function show()
    {

        $student = Student::select(
            DB::raw('CONCAT(first_name, last_name) AS name'),
            'c.name AS class_name',
            'rim'
        )
            ->join('classes AS c', 'class', '=', 'c.id')
            ->where('students.id', \request()->id)->first();

        $subjects = Subjects::select(
            'subjects.name as name',
            DB::raw('COALESCE(exams.note, 0) AS note'),
            'cs.coefficient as coefficient'
        )
            ->leftJoin('class_subjects as cs', 'subjects.id', '=', 'cs.subject')
            ->leftJoin('exams', function ($join) {
                $join->on('exams.subject_id', '=', 'cs.subject')
                    ->where('exams.quarter', '=', 1)
                    ->where('exams.student_id', '=', \request()->id);
            })
            ->where('cs.class', \request()->classId)
            ->get();
        return response()->json([
            'class' => $subjects,
            'student' => $student,
            'classId' => \request()->classId,
        ]);
    }


    public function filteredCompositions(Request $request)
    {
        $classId = $request->class_id;
        $averages = $this->getAverages($classId);

        return datatables()->of($averages)
            ->addColumn('action', 'compositions.quarters.first.composition-action')
            ->rawColumns(['action'])
            ->make('true');
    }

    public function resultsToPdf()
    {
        $classId = request()->classId;


        $results = array_values($this->getResultsOfClass($classId));
        return response()->json([$results]);
    }


    private function getAverages($classId)
    {
        $students = Student::select('id', DB::raw('CONCAT(first_name, " ", last_name) as name'), 'rim', 'class')
            ->where('class', $classId)
            ->get();
        $averages = [];

        $fetchData = function ($classId, $studentId, $type, $quarter) {
            return Subjects::select(
                'subjects.name as name',
                DB::raw('COALESCE(' . $type . '.note, 0) AS note'),
                'cs.coefficient as coefficient'
            )
                ->leftJoin('class_subjects as cs', 'subjects.id', '=', 'cs.subject')
                ->leftJoin($type, function ($join) use ($studentId, $quarter, $type) {
                    $join->on($type . '.subject_id', '=', 'cs.subject')
                        ->where($type . '.quarter', '=', $quarter)
                        ->where($type . '.student_id', '=', $studentId);
                })
                ->where('cs.class', $classId)
                ->get();
        };

        $calculateAVG = function ($data) {
            $sum = 0;
            $coe = 0;
            foreach ($data as $item) {
                $sum += $item->note * $item->coefficient;
                $coe += $item->coefficient;
            }
            if ($sum == 0)
                return 0;
            return $sum / $coe;
        };


        foreach ($students as $student) {
            $studentId = $student->id;

            $secondExamData = $fetchData($classId, $studentId, 'exams', 1);

            $totalAVG = $calculateAVG($secondExamData);

            $averages[$studentId] = [
                'rim' => $student->rim,
                'student_id' => $student->id,
                'class_id' => $student->class,
                'name' => $student->name,
                'average' => $totalAVG,
            ];
        }

        return $averages;
    }

    private function getResultsOfClass($classId)
    {
        $students = Student::select(
            'students.id AS id',
            DB::raw('CONCAT(first_name, " ", last_name) AS name'),
            'rim',
            'date_of_birth',
            'class',
            'classes.name AS class_name'
        )
            ->join('classes', 'classes.id', '=', 'students.class')
            ->where('class', $classId)
            ->get();

        $subjects = Subjects::select('name', 'subjects.id as id', 'coefficient')
            ->join('class_subjects', 'subjects.id', '=', 'class_subjects.subject')
            ->where('class_subjects.class', $classId)
            ->get();

        $query = function ($student_id, $quarter, $subject_id, $table) {
            return DB::table($table)
                ->select(
                    DB::raw('COALESCE(note, 0) AS note'),
                    'subjects.name AS subject_name',
                    'class_subjects.coefficient',
                    $table . '.subject_id'
                )
                ->join('subjects', 'subjects.id', '=', $table . '.subject_id')
                ->join('class_subjects', 'subjects.id', '=', 'class_subjects.subject')
                ->where($table . '.student_id', $student_id)
                ->where($table . '.subject_id', $subject_id)
                ->where($table . '.quarter', $quarter)
                ->first();
        };

        $results = [];
        foreach ($students as $student) {
            $notes = [];
            foreach ($subjects as $subject) {
                $secondTest = $query($student->id, 1, $subject->id, 'exams');
                $notes[$subject->id] = [
                    'note' => $secondTest ? $secondTest->note : 0,
                    'coefficient' => $subject->coefficient,
                    'name' => $subject->name
                ];
            }

            $results[$student->id] = [
                'id' => $student->id,
                'rim' => $student->rim,
                'name' => $student->name,
                'date_of_birth' => $student->date_of_birth,
                'class_id' => $student->class,
                'class_name' => $student->class_name,
                'notes' => $notes
            ];
        }

        return $results;

    }


}

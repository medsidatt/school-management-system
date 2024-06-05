<?php

namespace App\Http\Controllers\compositions;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subjects;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThirdCompositionController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        return view('compositions.quarters.third.index', [
            'classes' => $classes
        ]);
    }

    public function show()
    {
        return response()->json([
            'student' => $this->getStudentResult(\request()->classId, \request()->id),
        ]);
    }


    public function filteredCompositions(Request $request)
    {

        $results = $this->getAverages($request->classId);
        return datatables()->of($results)
            ->addColumn('action', 'compositions.quarters.third.composition-action')
            ->rawColumns(['action'])
            ->make('true');
    }

    public function resultsToPdf()
    {
        return response()->json([
           'result' => $this->getResultsOfClass(\request()->classId)
        ]);
    }

    private function getAverages($classId)
    {
        $students = Student::select('id', DB::raw('CONCAT(first_name, last_name) as name'), 'rim', 'class')
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

            $firstTestData = $fetchData($classId, $studentId, 'tests', 1);
            $secondTestData = $fetchData($classId, $studentId, 'tests', 2);
            $thirdTestData = $fetchData($classId, $studentId, 'tests', 3);
            $firstExamData = $fetchData($classId, $studentId, 'exams', 1);
            $secondExamData = $fetchData($classId, $studentId, 'exams', 2);
            $thirdExamData = $fetchData($classId, $studentId, 'exams', 3);

            $totalAVG = ($calculateAVG($firstExamData) + $calculateAVG($secondExamData) + $calculateAVG($thirdExamData)) / 3;

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
                $firstTest = $query($student->id, 1, $subject->id, 'tests');
                $secondTest = $query($student->id, 2, $subject->id, 'tests');
                $thirdTest = $query($student->id, 3, $subject->id, 'tests');
                $firstExam = $query($student->id, 1, $subject->id, 'exams');
                $secondExam = $query($student->id, 2, $subject->id, 'exams');
                $thirdExam = $query($student->id, 3, $subject->id, 'exams');

                $notes[$subject->id] = [
                    'firstTest' => $firstTest ? $firstTest->note : 0,
                    'secondTest' => $secondTest ? $secondTest->note : 0,
                    'thirdTest' => $thirdTest ? $thirdTest->note : 0,
                    'firstExam' => $firstExam ? $firstExam->note : 0,
                    'secondExam' => $secondExam ? $secondExam->note : 0,
                    'thirdExam' => $thirdExam ? $thirdExam->note : 0,
                    'subject_name' => $firstTest ? $firstTest->subject_name : $subject->name,
                    'coefficient' => $subject->coefficient
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



    private function getStudentResult($classId, $studentId)
    {
        $student = Student::select(
            'students.id AS id',
            DB::raw('CONCAT(first_name, " ", last_name) AS name'),
            'rim',
            'date_of_birth',
            'class',
            'classes.name AS class_name'
        )
            ->join('classes', 'classes.id', '=', 'class')
            ->where('class', $classId)
            ->where('students.id', $studentId)
            ->first();

        if (!$student) {
            return [];
        }

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

        $notes = [];
        foreach ($subjects as $subject) {
            $firstTest = $query($student->id, 1, $subject->id, 'tests');
            $secondTest = $query($student->id, 2, $subject->id, 'tests');
            $thirdTest = $query($student->id, 3, $subject->id, 'tests');
            $firstExam = $query($student->id, 1, $subject->id, 'exams');
            $secondExam = $query($student->id, 2, $subject->id, 'exams');
            $thirdExam = $query($student->id, 3, $subject->id, 'exams');

            $notes[$subject->id] = [
                'firstTest' => $firstTest ? $firstTest->note : 0,
                'secondTest' => $secondTest ? $secondTest->note : 0,
                'thirdTest' => $thirdTest ? $thirdTest->note : 0,
                'firstExam' => $firstExam ? $firstExam->note : 0,
                'secondExam' => $secondExam ? $secondExam->note : 0,
                'thirdExam' => $thirdExam ? $thirdExam->note : 0,
                'subject_name' => $firstTest ? $firstTest->subject_name : $subject->name,
                'coefficient' => $firstTest ? $firstTest->coefficient : $subject->coefficient
            ];
        }

        $result = [
            'id' => $student->id,
            'rim' => $student->rim,
            'name' => $student->name,
            'date_of_birth' => $student->date_of_birth,
            'class_id' => $student->class,
            'class_name' => $student->class_name,
            'notes' => $notes
        ];

        return $result;
    }



}

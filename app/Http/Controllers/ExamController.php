<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Exam::where('quarter', 1)->with('students', 'subjects')->get())
                ->addColumn('action', 'exams.quarters.first.exam-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('exams.quarters.first.index');

    }
}

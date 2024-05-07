<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use Illuminate\View\View;

class SubjectsController extends Controller
{
    public function index() : View
    {
        $subjects = Subjects::all();
        return view('subjects.index', compact('subjects'));
    }
}

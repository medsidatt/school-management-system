<?php

namespace App\Http\Controllers;

use App\Models\StudentParent;
use Illuminate\Http\Request;

class StudentParentController extends Controller
{
    public function index()
    {

        $parents = StudentParent::orderBy('date_of_birth')->get();
        return view('parents.index')->with('parents', $parents);
    }

    public function create() {
        return view('parents.create');
    }
    public function store(Request $request)
    {
        $messages = [
            'date_of_birth.before_or_equal' => 'The student must be at most 13 years old.',
            'date_of_birth.after_or_equal' => 'The student must be at least 23 years old.',
        ];

        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'tel' => 'required|unique:student_parents|digits:8|numeric',
            'date_of_birth' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d') . '|after_or_equal:' . now()->subYears(100)->format('Y-m-d'),
            'nni' => 'required|unique:student_parents|numeric|digits:10',
        ], $messages);

//        $studentParents = StudentParent::table('student_parents')->insert($data);
        $studentParents = StudentParent::create($data);

        if ($studentParents) {
            return redirect()->back()->with('success', 'Ajouter avec succès');
        }
        return redirect()->back()->with('fails', 'Erreur d\'inscrire cet étudiant');
    }


    public function view($id) {
        $parent = StudentParent::find($id);
        return view('parents.show', compact('parent'));
    }

    public function edit() {

    }

    public function destroy() {

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherPostRequest;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return view('teachers.index')->with('teachers', $teachers);
    }

    public function view($id) {
        $teacher = Student::find($id);
        if ($teacher == null) {
            return redirect('notfound');
        }
        return view('teachers.show', compact('teacher'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(TeacherPostRequest $request) : RedirectResponse
    {
        $validated_request = $request->validated();
        try {
            DB::beginTransaction();
            Teacher::create($validated_request);
            DB::commit();
            return redirect()->back()->with('success', 'Le professeur est inscrit avec succes');
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Erreur d\'inscrit cette professeur');
        }
    }

    public function edit($id)
    {
        $teacher = Teacher::find($id);
        if ($teacher == null) {
            return redirect('notfound');
        }
        return view('teachers.create', compact('teacher'));
    }

    public function update(TeacherPostRequest $request, $id)
    {
        $validated_request = $request->validated();
        $teacher = Teacher::find($id);
        if ($teacher == null) {
            return redirect('notfound');
        }
//        elseif () {
//
//        }
        $teacher->update($validated_request);
        return redirect(route('teachers'))->with('success', 'Les informations de la professeur est modifier avec succes');
    }



    public function destroy($id)
    {
        $teacher = Teacher::find($id);
        if ($teacher == null) {
            return redirect('notfound');
        }
        $teacher->delete();
        return redirect(route('teachers'))->back()->with('success', 'Le professeur est suprimer avec success');
    }

}



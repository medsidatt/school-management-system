<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Classes;
use App\Models\ClassSubject;
use App\Models\Subjects;
use http\Env\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ClassesController extends Controller
{

    public function index(): View
    {
        $classes = Classes::all();

        return view('classes.index', [
            'classes' => $classes
        ]);
    }

    public function create()
    {
        $subjects = Subjects::all()->sortBy('name');
        if (request()->ajax()) {
            return response()->json(['subjects' => $subjects ]);
        }
        return view('classes.create');
    }

    public function store(ClassPostRequest $request)
    {
        $validated = $request->validated();

//        try {
//            DB::beginTransaction();
//            $class = Classes::create($validated);
//            $class->subjects()->attach($request->subject);
//            DB::commit();
//            return redirect()->back()->with('success', 'Ajouter avec succès');
//
//        } catch (\Exception) {
//            return redirect()->back()->with('fail', 'Erreur d\'inscrire cet étudiant');
//
//        }


        if (request()->ajax()) {
            return response()->json(['success' => 'hello']);
        }


    }


    public function show($id): View
    {
        $class = Classes::with('students', 'subjects')->find($id);

        return view('classes.show', [
            'class' => $class
        ]);
    }


    public function edit($id): View|RedirectResponse
    {

        try {
            $class = Classes::with('subjects')->find($id);
            $class_subjects = array();
            foreach ($class->subjects as $subject) {
                $class_subjects[] = $subject->id;
            }
            $subjects = Subjects::all()->sortBy('name');
            return view('classes.create', [
                'subjects' => $subjects,
                'class' => $class,
                'class_subjects' => $class_subjects
            ]);
//                compact('subjects', 'class'));
        } catch (\Exception) {
            return redirect('not_found');
        }


    }

    public function update(ClassPostRequest $request, $id): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $class = Classes::find($id);
            $class->update($validated);
            $class->subjects()->sync($request->subject);

            DB::commit();
            return redirect()->back()->with('success', 'Modifier avec succès');

        } catch (\Exception) {
            return redirect()->back()->with('fail', 'Erreur de modifier cet étudiant');

        }
    }

    public function destroy($id)
    {
        $class = Classes::find($id);
        $class->delete();
    }
}

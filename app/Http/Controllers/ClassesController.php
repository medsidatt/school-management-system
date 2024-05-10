<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassPostRequest;
use App\Models\Classes;
use App\Models\Subjects;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Mockery\Exception;
use MongoDB\Driver\Session;

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
        return view('classes.create', [
            'subjects' => $subjects,
        ]);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'Le :attribute est obligatoire!',
            'unique' => 'Le :attribute est deja utilisee'
        ];

        $attributes = ['name' => 'nom du matiere'];
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('classes', 'name')->ignore($request->id)
            ]
        ], $messages, $attributes);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $coefficients = [];
        $subjects = $request->subject;
        foreach ($request->coefficient as $key => $value) {
            if ($value != null) {
                $coefficients[$key] = $value;
            }
        }


        DB::beginTransaction();
        $class = Classes::create($validator->validated());
        if (!empty($coefficients) && !empty($subjects)) {
            foreach ($subjects as $index => $subjectId) {
                $class->subjects()->attach($subjectId, ['coefficient' => $coefficients[$index]]);
            }
            DB::commit();
            $request->session()->put('success', 'Vous avez creer une nouvelle classe');
            return response()->json(['success' => true, 'redirect' => route('classes')]);
        }
        else{
            DB::rollBack();
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

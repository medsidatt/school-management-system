<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassPostRequest;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subjects;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Mockery\Exception;
use MongoDB\Driver\Session;
use function PHPUnit\Framework\callback;

class ClassesController extends Controller
{

    public function index()
    {
        $classes = Classes::all();
        if (request()->ajax()) {
            return datatables()->of($classes)
                ->addColumn('action', 'classes.class-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
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
        $i = 0;
        foreach ($request->coefficient as $key => $value) {
            if ($value != null) {
                $coefficients[$i] = $value;
                $i++;
            }

        }

        if ($request->id) {
            $class = Classes::find($request->id);
            $class->update($validator->validated());
            if ($class == null) {
                return response()->json(['notfound' => route('notfound')]);
            } else {
                if (!empty($coefficients) && !empty($subjects)) {
                    foreach ($subjects as $index => $subjectId) {
                        $class->subjects()->syncWithPivotValues($subjectId, ['coefficient' => $coefficients[$index]]);
                    }
                }
                $request->session()->put('success', 'Vous avez modifier une nouvelle classe');
                return response()->json(['success' => true, 'redirect' => route('classes')]);
            }
        } else {
            $class = Classes::create($validator->validated());
            if (!empty($coefficients) && !empty($subjects)) {
                foreach ($subjects as $index => $subjectId) {
                    $class->subjects()->attach($subjectId, ['coefficient' => $coefficients[$index]]);
                }
            }
            $request->session()->put('success', 'Vous avez creer une nouvelle classe');
            return response()->json(['success' => true, 'redirect' => route('classes')]);
        }

    }


    public function show($id): View
    {
        $class = Classes::with('students', 'subjects')->find($id);

        return view('classes.show', [
            'class' => $class
        ]);
    }


    public function edit($id)
    {
        $subjects = Subjects::all();
        $class = Classes::with('subjects')->find($id);
        if ($class == null) {
            return redirect()->route('notfound');
        }
        return view("classes.create", [
            'subjects' => $subjects,
            'class_name' => $class->name,
            'class_subjects' => $class->subjects,
            'id' => $id
        ]);
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

    public function destroy()
    {
        $class = Classes::find(request()->id);
        if ($class->subjects()->exists()) {
            $class->subjects()->detach();
        }
        if ($class->students()->exists()) {
            $class->students()->detach();
        }
        $class->delete();
        return response()->json(['success' => true]);


    }


    public function studentsByClass(Request $request)
    {
//        return response()->json(['test' => Student::where('class', 1)->get()]);
        return datatables()->of(Student::where('class', 1)->get())
            ->addColumn('action', 'classes.student-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
}

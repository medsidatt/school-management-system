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

    public function index() : View
    {

        $classes = Classes::with('subjects')->get()->map(function ($class) {
            return [
                'id' => $class->id,
                'name' => $class->name,
                'subjects' => $class->subjects->pluck('code')
            ];
        });

        return view('classes.index', compact('classes'));
    }

    public function create() : View
    {
        $subjects = Subjects::all()->sortBy('name');
        return view('classes.create')->with('subjects', $subjects);
    }

    public function store(ClassPostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $class = Classes::create($validated);
            $class->subjects()->attach($request->subject, ['coef' => 1]);
            DB::commit();
            return redirect()->back()->with('success', 'Ajouter avec succès');

        } catch (\Exception) {
            return redirect()->back()->with('fail', 'Erreur d\'inscrire cet étudiant');

        }


    }

    public function edit($id) : View|RedirectResponse
    {

        try {
            $class = Classes::with('subjects')->find($id);
            $formattedClass = [
                'name' => $class->name,
                'subjects' => $class->subjects->pluck('code')->toArray()
            ];
            $subjects = Subjects::all()->sortBy('name');
            return view('classes.create', compact('subjects', 'class'));
        }catch (\Exception) {
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
}

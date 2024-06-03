<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherPostRequest;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::select(
            'id',
            DB::raw('CONCAT(first_name, " " ,last_name) AS name'),
            'nni',
            'date_of_birth',
            'sex',
            'img_path'
        )->get();
        if (\request()->ajax()) {
            return datatables()->of($teachers)
                ->addColumn('action', 'teachers.teacher-action')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('teachers.index');
    }

    public function view($id)
    {
        $teacher = Teacher::with('classes')
        ->where('id',$id)->first();
        if ($teacher == null) {
            return redirect('notfound');
        }
        return view('teachers.show', [
            'teacher' => $teacher
        ]);
    }

    public function associateForm()
    {
        if (\request()->ajax()) {
            return response()->json([Classes::all()]);
        }
    }

    public function associateSubmit()
    {
        if (\request()->ajax()) {
            return response()->json([\request()->class]);
        }
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(TeacherPostRequest $request): RedirectResponse
    {

        $validated_request = $request->validated();

        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $path = $image->store('images', 'public');
            $validated_request['img_path'] = $path;
        } else
            $validated_request['img_path'] = null;

        Teacher::create($validated_request);

        return redirect()->back()->with('success', 'Le professeur est inscrit avec succes');

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

        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $path = $image->store('images', 'public');
            $validated_request['img_path'] = $path;

        }

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


    public function destroy()
    {
        $teacher = Teacher::find(\request()->id);
        if ($teacher == null) {
            return response()->json(['notfound' => route('notfound')]);
        }
        $teacher->delete();
        return response()->json(['success' => true]);
    }

}



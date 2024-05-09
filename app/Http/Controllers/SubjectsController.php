<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubjectsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Subjects::all())
                ->addColumn('action', 'subjects.subject-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('subjects.index',);
    }


    public function store(Request $request)
    {
        $messages = [
            'required' => 'Le :attribute est obligatoir',
            'unique' =>  'Le :attribute est deja utilisee',
        ];

        $attributes = [
            'name' => 'nom du matiere',
            'code' => 'code du matiere'
        ];

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('subjects', 'name')->ignore($request->input('id'))
            ],
            'code' => [
                'required',
                Rule::unique('subjects', 'code')->ignore($request->input('id'))
            ],
        ], $messages, $attributes);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $data = $validator->validated();


        if ($request->input('id')) {
            $subject = Subjects::find($request->input('id'));
            $subject->update($data);
            return response()->json(['update' => true]);
        } else {
            Subjects::create($data);
            return response()->json(['success' => true]);
        }

    }


    public function destroy()
    {
        $subject = Subjects::find(request()->input('id'));
        $subject->delete();

        return response()->json(['success' => true]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Subjects;
use App\Models\Teacher;
use App\Models\Timetable;
use DateTime;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        $teachers = Teacher::all();
        $subjects = Subjects::all();
        return view('lessons.index', [
            'classes' => $classes,
            'subjects' => $subjects,
            'teachers' => $teachers
        ]);
    }

    public function store(Request $request)
    {
        $customMessages = [
            'required' => 'Le champ :attribute est obligatoire.',
            'date_format' => 'Le champ :attribute doit être une heure valide au format HH:MM.',
            'after' => 'Le champ :attribute doit être une heure après :date.',
        ];

        $customAttributes = [
            'day' => 'jour',
            'subject_id' => 'matière',
            'teacher_id' => 'enseignant',
            'classes_id' => 'classe',
            'start' => 'heure de début',
            'end' => 'heure de fin',
        ];

        $validated = $request->validate([
            'day' => ['required'],
            'subject_id' => ['required'],
            'teacher_id' => ['required'],
            'classes_id' => ['required'],
            'start' => ['required', 'date_format:H:i'],
            'end' => ['required', 'date_format:H:i', 'after:start'],
        ], $customMessages, $customAttributes);


        $timetable = Timetable::create($validated);

        if ($timetable) {
            return redirect()->back()->with('success', 'Le lesson est ajouté dans l\'emploi.');
        } else {
            return redirect()->back()->with('fail', 'Le lesson n\'est pas ajouté dans l\'emploi.');
        }
    }

}

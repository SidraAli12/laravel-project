<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // List all students
    public function index()
    {
        $students = Student::with('class')->get();
        return view('students.index', compact('students'));
    }

    // Show create form
    public function create()
    {
        $classes = ClassModel::all();
        return view('students.create', compact('classes'));
    }

    // Store new student
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:students,email',
            'class_id' => 'required|exists:classes,id',
        ]);

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    // Show edit form
    public function edit(Student $student)
    {
        $classes = ClassModel::all();
        return view('students.edit', compact('student', 'classes'));
    }

    // Update student
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:students,email,'.$student->id,
            'class_id' => 'required|exists:classes,id',
        ]);

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    // Delete student
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }}
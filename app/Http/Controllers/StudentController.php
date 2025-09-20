<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;





class StudentController extends Controller
{
    // List all students
    public function index()
    {
        $students = Student::with('class')->get();
        return view('students.index', compact('students'));
    }
// AJAX method here
    public function fetchStudents()
    {
        $students = Student::with('class')->get();
    return response()->json($students); 
    }
    // Show create form
    public function create()
    {
        $classes = ClassModel::all();
        return view('students.create', compact('classes'));
    }

    // Store new student (AJAX version)
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:students,email',
                'class_id' => 'required|exists:classes,id',
            ]);

            // default values for verification
            $data['is_verified'] = 0;
            $data['verification_token'] = Str::random(40);

            $student = Student::create($data);

            // send verification email
            $verificationLink = route('students.verify', $student->verification_token);

            Mail::raw("Hi {$student->name}, click this link to verify your account: $verificationLink", function ($message) use ($student) {
                $message->to($student->email)
                        ->subject('Verify your Student Account');
            });

            // return JSON for AJAX
            return response()->json([
                'success' => true,
                'message' => 'Student added successfully! Verification email sent.',
                'student' => $student
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    // Verify student email
    public function verify($token)
    {
        $student = Student::where('verification_token', $token)->first();

        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Invalid verification link.');
        }

        $student->is_verified = 1;
        $student->verification_token = null;
        $student->save();

        return redirect()->route('students.index')->with('success', 'Student verified successfully!');
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

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully!',
            'student' => $student
        ]);
    }

    // Delete student
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully!'
        ]);
    }
}

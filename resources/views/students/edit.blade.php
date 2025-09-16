<x-app-layout>
    <h2>Edit Student</h2>

    <form action="{{ route('students.update', $student) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $student->name }}" required> <br><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $student->email }}" required> <br><br>

        <label>Class:</label>
        <select name="class_id" required>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" 
                    {{ $student->class_id == $class->id ? 'selected' : '' }}>
                    {{ $class->classname }}
                </option>
            @endforeach
        </select>
        <br><br>

        <button type="submit">Update</button>
    </form>
</x-app-layout>

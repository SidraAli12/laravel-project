<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <label>Name:</label>
    <input type="text" name="name" required> <br><br>

    <label>Email:</label>
    <input type="email" name="email" required> <br><br>

    <label>Class:</label>
    <select name="class_id" required>
    @foreach($classes as $class)
        <option value="{{ $class->id }}">{{ $class->classname }}</option>
    @endforeach
</select>

    <br><br>

    <button type="submit">Save</button>
</form>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Class</th>
        <th>Verified</th>
        <th>Actions</th>
    </tr>

    @foreach($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->class->classname ?? 'N/A' }}</td>
            <td>{{ $student->is_verified ? 'Yes' : 'No' }}</td>
            <td>
                <a href="{{ route('students.edit', $student) }}">Edit</a>
                <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

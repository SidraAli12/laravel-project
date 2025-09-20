<form id="studentForm">
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

<div id="message"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#studentForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('students.store') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            $('#message').html("<p style='color:green;'>" + response.message + "</p>");
        },
        error: function(xhr) {
            $('#message').html("<p style='color:red;'>Error: " + xhr.responseText + "</p>");
        }
    });
});
</script>

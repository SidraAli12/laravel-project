<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Students List
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <ul id="studentList"></ul>

            </div>
        </div>
    </div>

    {{-- ✅ JavaScript for AJAX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadStudents() {
            $.ajax({
                url: "{{ route('students.fetch') }}",
                type: "GET",
                dataType: "json",
                success: function(students) {
                    let list = "";
                    students.forEach(function(student) {
                        list += `<li>${student.name} (${student.email})</li>`;
                    });
                    $("#studentList").html(list);
                },
                error: function() {
                    alert("Failed to load students.");
                }
            });
        }
        $(document).ready(loadStudents);
    </script>
</x-app-layout>

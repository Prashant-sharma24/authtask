<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Include Bootstrap CSS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include DataTables CSS for styling -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<body>

    <div class="container">
        <h1 class="mt-4">Welcome to the Dashboard</h1>

        <!-- Your login/logout code here -->
        @if (Auth::check())
            <p>You are logged in as {{ Auth::user()->email }}</p>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn-warning" type="submit">Logout</button>
            </form>
        @else
            <p>You are not logged in.</p>
            <a href="{{ route('login') }}">Login</a>
        @endif
        <!-- Hidden form to handle the actual logout request -->
        <!-- Your logout form here -->
        <div class="container mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary text-end">Add USer</a>
        </div>

        <!-- ... Other HTML content ... -->

        <div class="container mt-4">
            <p>Total Users: {{ $totalUsers }}</p>

            <div class="user-list">
                <h3>User List</h3>
                <table id="user-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- User data will be populated dynamically using AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ... Other HTML content ... -->



    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#user-table').DataTable({
                ajax: {
                    url: '{{ route('users.data') }}',
                    type: 'GET',
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // Log the response
                        console.log(error); // Log the error
                    }
                },
                columns: [{
                        data: 'first_name'
                    },
                    {
                        data: 'last_name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<button class="btn btn-sm btn-primary edit-btn" data-id="' +
                                data.id + '">Edit</button>';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<button class="btn btn-sm btn-danger delete-btn" data-id="' +
                                data.id + '">Delete</button>';
                        }
                    }
                ]
            });

        // Edit button click event
        $('#user-table tbody').on('click', '.edit-btn', function () {
            var userId = $(this).data('id');
            // Redirect to the edit page for the selected user
            window.location.href = '/users/' + userId + '/edit';
        });

        // Delete button click event
        $('#user-table tbody').on('click', '.delete-btn', function () {
            var userId = $(this).data('id');
            // Send a DELETE request using AJAX
            $.ajax({
                url: '/users/' + userId,
                type: 'DELETE',
                success: function (response) {
                    // Refresh the DataTables table
                    userTable.ajax.reload();
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });
    </script>

</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="container">
        <form class="form" id="registration-form" action="{{ route('register') }}" method="POST" data="encrypt">
            @csrf
            <h2>Register</h2>
            <div class="form-group">
                <input type="text" name="first_name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                <span id="password-match-status"></span>
            </div>


            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');
            const matchStatus = document.getElementById('password-match-status');

            function updateMatchStatus() {
                if (passwordField.value === confirmPasswordField.value) {
                    matchStatus.textContent = 'Passwords match';
                    matchStatus.style.color = 'green';
                } else {
                    matchStatus.textContent = 'Passwords do not match';
                    matchStatus.style.color = 'red';
                }
            }

            passwordField.addEventListener('input', updateMatchStatus);
            confirmPasswordField.addEventListener('input', updateMatchStatus);
        });
    </script>



</body>
</html>

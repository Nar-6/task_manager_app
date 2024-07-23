<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style_auth.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Sign In</title>
</head>
<body>
    <div class="form-container shadow">
        <h3>MyTask</h3>
        <form action="{{ route('signin')}}" method="POST" class="login-form">
            @csrf
            @method('POST')
            <input type="email" name="email" id="email" placeholder="Mail" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            
            <a href="">Not connected ? Sign Up</a>
            <button type="submit">Sign In</button>
        </form>
    
        @if (session('success'))
            <div>{{ session('success') }}</div>
        @endif
    
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
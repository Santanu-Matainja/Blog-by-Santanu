<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
        <div class="container-md">
            <a class="navbar-brand" href="#">Navbar</a>
        </div>

        <a href="{{ route('login.form')}}" type="button" class="btn btn-primary mx-2">Login</a>
        <a href="{{ route('register.form')}}" type="button" class="btn btn-primary mx-2">SignUp</a>

    </nav>
</body>

</html>
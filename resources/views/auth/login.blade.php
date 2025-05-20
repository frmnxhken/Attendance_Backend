<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/assets') }}/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets') }}/css/app.min.css" rel="stylesheet" type="text/css" />
    <style>
        body,
        html {
            height: 100%;
        }

        .login-container {
            height: 100vh;
        }
    </style>
</head>

<body>

    <div class="container login-container d-flex justify-content-center align-items-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Login</h4>
                    <form method="POST" action="/login">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
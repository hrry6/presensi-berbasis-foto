<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Login</title>
</head>

<body>
    <section class="h-100 gradient-form mt-5">
        <div class="container py-5 h-100 mt-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <img src="{{ asset('img/logo.png') }}" alt="logo" class="w-50">

                                    <form action="" method="POST">
                                        @csrf
                                        <p class="mb-3 fw-bold fs-3">Log In</p>

                                        <div class="form-outline mb-4">
                                            <input type="text" class="form-control" placeholder="Username"
                                                name="username" />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" class="form-control" placeholder="Password"
                                                name="password" />
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <button type="submit"
                                                class="btn bg-primary w-100 text-white p-2 fw-bold fs-5 rounded-2">LOGIN</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <div
                                class="col-lg-5 d-flex align-items-center text-center"class="text-white px-3 py-5 p-md-5 mx-md-4">
                                <img src="{{ asset('img/backtoschool.png') }}" style="width: 100%;" alt="logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="fixed-bottom">
        <img src="{{ asset('img/wave.svg') }}" style="width: 100%;">
    </div>
</body>
<script>

</script>
</html>

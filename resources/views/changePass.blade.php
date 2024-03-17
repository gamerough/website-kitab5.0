<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Change Password</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('./style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Styles -->
    <style>
    </style>
</head>
<body>

    <section class="loginPage">
        <div class="container ">
            <div class="row">
                <div class="col-sm-6 login_left d-flex flex-column justify-content-center ">
                    <a href="#" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-arrow-left my-5" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                        </svg>
                    </a>
                    <p>
                        Forgot <span>Pass!</span> <br>
                        <span2>Tenang akun kamu akan kembali</span>
                    </p>
                    <div class="textfield">
                        <span class="input-Email">
                            <input class="form-control email my-3" type="password" name="Email" id="Email" placeholder="New Password">
                        </span>

                        <span class="input-Password">
                            <input class="form-control password" type="password" name="Email" id="Email" placeholder="Confirm Password">
                        </span>
                    </div>
                    <div class="textPass text-end my-2 mx-4">
                        <p>Your password must be 8-20 characters long, contain letters and number, and must not contain spaces, special character, or emoji.</p>
                    </div>
                    <a class="btn longBtn my-4" data-bs-target="#" data-bs-toggle="modal" type="submit">Change Password</a>
                    
                    <div class="btnRegris my-5">
                        <p>Remember your pass? <span><a href="{{ url('/login') }}">Login now</a></span></p>
                    </div>

                </div>
                <div class="col-sm-6 login_right d-flex flex-column justify-content-center">
                    <img src="images/changepass.png" alt="" />
                    <div class="text-center">
                        <p>"Iman harus ditegakkan dengan alasan. Ketika buta iman, ia mati."<br>
                            <span><b>Mahatma Gandhi</b></span>
                        </p>
                    </div>
                </div>
                

            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
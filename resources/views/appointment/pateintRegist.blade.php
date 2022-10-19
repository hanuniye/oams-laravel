<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset("asset/vendor/fontawesome-free/css/all.min.css") }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset("asset/css/sb-admin-2.min.css") }}" rel="stylesheet">

</head>

<body >

        <div class="row justify-content-center" style="width:100%;">
            <div class="col-7">
            <div class="container justify-content-center py-3 px-5">
        <div class="card o-hidden border-0 shadow-lg m-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row justify-content-center">
                    <div class="col-lg-12 mx-3">
                        <div class="px-5 py-4">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Register</h1>
                            </div>
                            <div class="alert alert-danger d-none" id="alert" role="alert" >
                                Data Inserted Successfuly!
                            </div>
                            <form id="form" >
                                @csrf
                                <div class="form-group row justify-content-center">
                                <div class="col-sm-12 mb-2 mb-sm-0">
                                    <label for="">Fullname</label>
                                    <input type="text" class="form-control  "
                                    id="fullname" name="fullname" placeholder="Fullname" >
                                    <p class="fullname text-danger"></p>
                                </div>
                                </div>

                                <div class="form-group row justify-content-center" >
                                <div class="col-sm-12 mb-2 mb-sm-0">
                                <label for="">Username</label>
                                    <input type="text" class="form-control  "
                                    id="username" name="username" placeholder="Username" >
                                    <p class="username text-danger"></p>
                                </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                    <div class="form-group row justify-content-center">
                                        <div class="col-sm-12 mb-2 mb-sm-0">
                                            <label for="">Age</label>
                                            <input type="text" class="form-control  "
                                            id="age" name="age" placeholder="Age" >
                                            <p class="age text-danger"></p>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group row justify-content-center">
                                        <div class="col-sm-12 mb-2 mb-sm-0">
                                        <label for="">Contact</label>
                                            <input type="text" class="form-control  "
                                            id="contact" name="contact" placeholder="Contact" >
                                            <p class="contact text-danger"></p>
                                        </div>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group row justify-content-center" >
                                            <div class="col-sm-12 mb-2 mb-sm-0">
                                            <label for="">Email</label>
                                                <input type="text" class="form-control  "
                                                id="email" name="email" placeholder="Email" >
                                                <p class="email text-danger"></p>
                                            </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row ">
                                        <div class="col">
                                        <div class="form-group row justify-content-center">
                                        <div class="col-sm-12 mb-2 mb-sm-0">
                                        <label for="">Password</label>
                                            <input type="password" class="form-control  "
                                            id="password" name="password" placeholder="Password" >
                                            <p class="password text-danger"></p>
                                        </div>
                                        </div>
                                        </div>

                                        <div class="col">
                                        <div class="form-group row justify-content-center">
                                        <div class="col-sm-12 mb-2 mb-sm-0">
                                        <label for="">Confirm_Password</label>
                                            <input type="password" class="form-control  "
                                            id="password_confirmation" name="password_confirmation" placeholder="Confirm_Password" >
                                        </div>
                                        </div>
                                    </div>


                                    </div>

                                    <div class="row ">
                                        <div class="col">
                                        <div class="form-group row justify-content-center">
                                        <div class="col-sm-12 mb-2 mb-sm-0">
                                        <label for="">Gender</label>
                                        <select class="form-control" id="gender" name="gender" >
                                                <option value="male">Male</option>
                                                <option value="female">female</option>
                                        </select>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group row justify-content-center">
                                        <div class="col-sm-12 mb-2 mb-sm-0">
                                        <label for="">Birth Date</label>
                                            <input type="date" class="form-control  "
                                            id="birthDate" name="birthDate"  >
                                            <p class="birthdate text-danger"></p>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <button type='submit' class="btn btn-primary btn-block">
                                    submit
                                    </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
            </div>
        </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset("asset/vendor/jquery/jquery.min.js") }}"></script>
    <script src="{{ asset("asset/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset("asset/vendor/jquery-easing/jquery.easing.min.js") }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset("asset/js/sb-admin-2.min.js") }}"></script>

    <script>
        $(document).ready(function(){
            $("#form").submit(function(e){
                e.preventDefault();

                $.post("pateintCreate",$(this).serialize())
                .done(data =>{
                    if(data.status){
                        location.href='/patientlogin'
                    }
                })
                .fail(data =>{
                    console.log(data.responseJSON.errors);
                    if(data.responseJSON.errors){
                        if(data.responseJSON.errors.fullname){
                            $(".fullname").html(data.responseJSON.errors.fullname)
                        }else{
                            $(".fullname").html('')
                        }
                        if(data.responseJSON.errors.username){
                            $(".username").html(data.responseJSON.errors.username)
                        }else{
                            $(".username").html('')
                        }
                        if(data.responseJSON.errors.age){
                            $(".age").html(data.responseJSON.errors.age)
                        }else{
                            $(".age").html('')
                        }
                        if(data.responseJSON.errors.birthDate){
                            $(".birthdate").html(data.responseJSON.errors.birthDate)
                        }else{
                            $(".birthdate").html('')
                        }
                        if(data.responseJSON.errors.contact){
                            $(".contact").html(data.responseJSON.errors.contact)
                        }else{
                            $(".contact").html('')
                        }
                        if(data.responseJSON.errors.email){
                            $(".email").html(data.responseJSON.errors.email)
                        }else{
                            $(".email").html('')
                        }
                        if(data.responseJSON.errors.password){
                            $(".password").html(data.responseJSON.errors.password)
                        }else{
                            $(".password").html('')
                        }



                    $("#alert").html(info)

                    }
                })
            })

        })
    </script>
</body>

</html>

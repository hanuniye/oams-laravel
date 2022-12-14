<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ url("") }}/asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ url("") }}/asset/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("asset/bootstrap.min.css") }}">

</head>

<body >
   {{-- navbar  --}}
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
          <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
        </span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
          <li class="nav-item ">
            <a class="nav-link active text-white" aria-current="page" href="/">Home</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>
<div class="row justify-content-center">
    <div class="col-6">
    <div class="container justify-content-center py-3 px-5">

<div class="card o-hidden border-0 shadow-lg m-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row justify-content-center">
            <div class="col-lg-12 mx-3">

                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                        <div class="alert alert-danger " id="alert" role="alert" >
                            Data Inserted Successfuly!
                        </div>
                    </div>

                    <form id="form">
                        @csrf
                        <div class="form-group row justify-content-center">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <input type="text" class="form-control " name="email" id="email"
                                    placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <input type="password" class="form-control"
                                    id="password" name="password" placeholder="Password">
                            </div>

                        </div>
                        <button type='submit' class="btn btn-primary btn-block ">
                           login
                        </button>
                    </form>
                </div>
            </div>
            <!-- <div class="col-lg-4"></div> -->
        </div>
    </div>
</div>

</div>
    </div>
</div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ url("") }}/asset/vendor/jquery/jquery.min.js"></script>
    <script src="{{ url("") }}/asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ url("") }}/asset/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ url("") }}/asset/js/sb-admin-2.min.js"></script>

    <script>
        $("#alert").hide()
        let styl = "none";
        let test = $("#block").val()
        console.log(test);

        $("#form").submit(function(e){
            e.preventDefault();

            $.post("/authanticate",$(this).serialize())
            .done(data =>{
                if(data.status){
                    if(data.data === 'pateint'){
                        location.href='/setappointment'
                    }
                    else{
                        location.href='/layout'
                    }
                }
                else{
                    $("#alert").show()
                    $("#alert").html(data.data)
                    $("#password").val('')
                }
            })
            .fail(data =>{
                console.log(data);
            })
        })
    </script>
</body>

</html>

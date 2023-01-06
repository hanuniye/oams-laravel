<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    {{-- csrf  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <!-- fontawesome  -->
    <script src="https://kit.fontawesome.com/c5f64b2bcd.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset("asset/bootstrap.min.css") }}">
    <!-- fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <!-- css link  -->
    <link rel="stylesheet" href="{{ asset("asset/style1.css") }}">
    <link rel="stylesheet" href="{{ asset("asset/fontawesome-icons/css/all.min.css") }}">
    {{-- datatable  --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <style>
      *{
        margin:0;
        padding:0;
        box-sizing:border-box;
      }
      .image{
        /* background:url("img/jonathan-borba-wzV17t-k3k0-unsplash.jpg");
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat; */
        height: 250px;
        width: 260px;
        text-transform: capitalize;
      }
      .image img{
        width:100%;
        height: 100%;
      }
      .info{
        font-family:'Josefin Sans', sans-serif;;
      }
      .schedule-patern{
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      .info .Text{
        letter-spacing: 2px;
      }
    </style>

  </head>

  <body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">
            <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
          </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">

            <li class="nav-item">
              <a class="nav-link active text-white bg-info py-1  mx-2"  href="/logout">Logout</a>
            </li>

          </ul>
        </div>
      </div>
    </nav>

    <div class="container my-5" >
        <div class="row justify-content-center">
            <div class="col-12">
            <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Doctor_Name</th>
                                            <th>Specialist</th>
                                            <th>Patient_Name</th>
                                            <th>patient_Contact</th>
                                            <th>Appoint_Date</th>
                                            <th>Appoint_Time</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody"></tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
     
    <section id="footer" style="margin-top:220px;">
        <!-- Footer -->
        <footer class="text-center text-white w-100" style="background-color: #0a4275; position:fixed; bottom:0; left:0; ">
        <!-- Grid container -->
        <div class="container p-4 pb-0">
            <!-- Section: CTA -->
            <section class="">
            <p class="d-flex justify-content-center align-items-center" id="footerInfo">
                <span class="me-3" id="footerText" style=" font-family: 'Josefin Sans', sans-serif;">Book for Free</span>
                <button type="button" class="btn btn-outline-light btn-rounded" style="font-family: 'Playfair Display', serif;">
                Book an Appointment
                </button>
            </p>
            </section>
            <!-- Section: CTA -->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2020 Copyright:
            <a class="text-white" style=" font-family: 'Josefin Sans', sans-serif;">Mabruuk</a>
        </div>
        <!-- Copyright -->
        </footer>
        <!-- Footer -->
    </section>

    {{-- pateint_id  --}}
    <form>
        @csrf
        <input type="hidden" id="pateint_id" value="{{ Auth()->user()->id }}">
        <input type="hidden" id="status" value="cancel">
    </form>

    <script src="{{ asset("asset/bootstrap.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    {{-- datatable  --}}
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    {{-- sweet alert  --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>

        $(document).ready(() =>{
            let pateint_id = $("#pateint_id").val()


            $(".table").DataTable({
                ajax:{
                    url:`getMyAppointment/${pateint_id}`,
                    dataSrc:""
                },
                columns:[
                    {data:"doctor_name"},
                    {data:"specialist"},
                    {data:"pateint_name"},
                    {data:"contact"},
                    {data:"date"},
                    {data:"time"},
                    {data:"status"},
                    {data:"action"},
                ]
            })
        })

        function printPatient(){
            let pateint_id = $("#pateint_id").val()

            $.get(`getMyAppointment/${pateint_id}`)
            .done(data =>{
                let resp = data[0]
                let newWIndow = window.open()
                newWIndow.document.write(`<html><head><title></title>
                <style>
                *{
                    margin:0;
                    padding:0;
                    box-sizing:border-box;
                }
                .main-cont{
                    display:flex;
                    flex-direction:column;
                    justify-content:center;
                    align-items:center;
                }

                .hospital-info{
                    display:flex;
                    flex-direction:column;
                    justify-content:center;
                    align-items:center;
                    padding:20px 0;
                    text-transform: capitalize;
                    border-bottom:1px solid #000;
                    line-height:1.3;
                }
                .patient-info{
                    display:flex;
                    flex-direction:column;
                    justify-content:center;
                    align-items:center;
                    padding:20px 0;
                    text-transform: capitalize;
                    border-bottom:1px solid #000;
                    line-height:1.6;
                }
                .appoint-info{
                    display:flex;
                    flex-direction:column;
                    justify-content:center;
                    align-items:center;
                    padding:20px 0;
                    text-transform: capitalize;
                    border-bottom:1px solid #000;
                    line-height:1.6;
                }


                </style>
                </head><body>`)
                newWIndow.document.write(`<div class='main-cont'>
                <div class='hospital-info'>
                    <h1>mabruuk hospital</h1>
                    <h4 style='margin-top:10px; font-size:20px;'>mabruuk hospital</h4>
                    <p style='margin-top:10px; font-size:18;''>bosaso,airport street</p>
                    <p style='margin-top:10px; font-size:18;''><strong>Contact:&nbsp </strong>090779****</p>
                </div>

                <div class='patient-info'>
                    <h5 style='margin-top:10px; font-size:22px;letter-spacing:1px;'>Patient details</h5>
                    <p style='margin-top:10px; font-size:16px;'><strong>Patient_name:</strong>  &nbsp ${resp.pateint_name}</p>
                    <p style='margin-top:10px; font-size:16px;'><strong>contact_no:</strong>  &nbsp ${resp.contact}</p>
                </div>

                <div class='appoint-info'>
                    <h5 style='margin-top:10px; font-size:22px;letter-spacing:1px;'>Appointment details</h5>
                    <p style='margin-top:10px; font-size:16px;'><strong>Doctor_name:</strong> &nbsp ${resp.doctor_name}</p>
                    <p style='margin-top:10px; font-size:16px;'><strong>Specialist:</strong> &nbsp  ${resp.specialist}</p>
                    <p style='margin-top:10px; font-size:16px;'><strong>Appointment_date</strong>  &nbsp ${resp.date}</p>
                    <p style='margin-top:10px; font-size:16px;'><strong>Appointment_time:</strong>  &nbsp ${resp.time}</p>
                    <p style='margin-top:10px; font-size:16px;'><strong>Appointment_status:</strong>  &nbsp ${resp.status}</p>
                    <p style='margin-top:10px; font-size:16px;'><span class='badge bg-success'><strong>Reason for appointment:</strong>  &nbsp ${resp.reason}</span></p>
                    <p style='margin-top:10px; font-size:16px;'><strong>patient come into hospital:</strong>  &nbsp ${resp.type}</p>
                </div>


                </div>`)
                newWIndow.document.write(`<body></html>`)
                newWIndow.print()
                newWIndow.close()

                })
            .fail(data =>{
                console.log(data);
            })

        }

        function cencelAppoint(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            swal({
                title: "Are you sure?",
                text: "Once cencel, you will cencel your appointment!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.post(`/updateStatus/${id}`,{status:"cencel"})
                    .done(data =>{
                        console.log(data);
                        location.reload()
                    })
                    .fail(data =>{
                        console.log(data);
                    })


                    swal("Poof! Your appointment has been cenceled!", {
                    icon: "success",
                    });
                } else {
                    swal("Your appointment is safe");
                }
            });



        }

    </script>

  </body>

</html>

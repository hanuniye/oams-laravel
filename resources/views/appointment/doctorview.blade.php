<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title></title>
    <!-- fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">

    <!-- css link  -->
    <link rel="stylesheet" href="{{ asset("asset/style1.css") }}">
    <link rel="stylesheet" href="{{ asset("asset/bootstrap.min.css") }}">

    <style>
      *{
        margin:0;
        padding:0;
        box-sizing:border-box;
      }
      .image{
        height: 250px;
        width: 260px;
        box-shadow: 0px 0px 05px rgba(159, 159, 159, 0.3);
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
        <!--schedule modal   -->
    <div class="modal " id="scheduleModal" style="margin-top:78px;" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title text-white">Modal title</h5>
                <button type="button" class="btn-close bg-white text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <table class="table table-dark table-hover">
                    <thead>
                    <th>Days</th>
                    <th>Available Time</th>
                    </thead>
                    <tbody class="scheduleInfo">

                    </tbody>
                </table>
            </div>
        </div>
        </div>
        </div>

    {{-- main  --}}
   <div class="top-cont">


    </div>


    {{-- footer  --}}
    <section id="footer">
        <!-- Footer -->
        <footer class="text-center text-white" style="background-color: #0a4275; ">
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

    <script src="{{ asset("asset/bootstrap.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script>

    $(document).ready(function(){
        $.get("getDoctors")
        .done(data =>{
            let info = ''

            data.forEach(item =>{
                console.log(item);
                info += `
                <div class="container my-5">
                    <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="row">
                        <div class="schedule-patern">
                            <div class="image">
                            <img src='/storage/${item.image}'>
                            </div>
                            <div class="info mb-4">
                                <h6 class="name">Name: <span class="Text text-muted">${item.name}</span></h6>
                                <h6 class="my-4 email">Email: <span class="Text text-muted">${item.email}</span></h6>
                                <h6 class="my-4 contact">Contact: <span class="Text text-muted">${item.contact}</span></h6>
                                <h6 class="my-4 specialist">Specialist: <span class="Text text-muted">${item.specialist_name}</span></h6>
                                <div class="btn btn-info" onclick=getSchedule(${item.id})>schedule</div>
                                                </div>
                                                <a onclick=setAppoint(${item.id}) class="btn btn-primary">set appointment</a>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                `
            })
            $(".top-cont").html(info)
        })
        .fail(data =>{
            console.log(data);
        })
    })

    function getSchedule(id){
        $("#scheduleModal").modal("toggle");

        $.get(`getDoctors/${id}`)
        .done(data =>{
            let info = ''
            console.log(data);

            data.forEach(item =>{
                $(".modal-title").html(`${item.doctor_name}'s schedule`)
                info += `
                    <tr>
                        <td style="font-family:'Josefin Sans', sans-serif;">${item.day}</td>
                        <td style="font-family:'Josefin Sans', sans-serif;">${item.start_time} - ${item.end_time}</td>
                    </tr>
                `
            })

            $(".table .scheduleInfo").html(info)
        })
        .fail(data =>{
            console.log(data);
        })
    }

    function setAppoint(doctorId){
        location.href = 'patientlogin'
    }



    </script>
  </body>

</html>

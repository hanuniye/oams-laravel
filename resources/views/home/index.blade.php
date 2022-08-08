<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title></title>
    <!-- fontawesome  -->
    <script src="https://kit.fontawesome.com/c5f64b2bcd.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ url("") }}/asset/bootstrap.min.css">
    <!-- fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <!-- css link  -->
    <link rel="stylesheet" href="{{ url("") }}/asset/style1.css">
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand text-white" href="#">Navbar</a>
        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">
            <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
          </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
            <li class="nav-item ">
              <a class="nav-link active text-white" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-white" href="#">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-white" href="#">Pricing</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>



  <!-- show-case -->
  <section class="text-light" id="sec1">
    <div class="container h-100 d-flex justify-content-center align-items-center" id="showCase">
      <div class="text-center">
        <h1>You are in the Right Place
          at the Right Time.</h1>
            <a href="doctorsView.php" class="btn btn-outline-light btn-rounded" id="showCaseBtn">Book an Appointment</a>
      </div>
    </div>
  </section>

  <!-- aobout  -->
  <section id="about">
    <div class="container" id="aboutCont">
        <div class="aboutImage">
        </div>
          <div class="aboutInfo ">
            <h3>who we are</h3>
            <h1>Get To Know About <br>
              <span class="text-success">Us</span> </h1>
              <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quibusdam ipsum assumenda rerum numquam recusandae similique, illum perferendis rem natus ipsa. Nostrum quibusdam deleniti nisi repellendus eaque, consequatur architecto ducimus quis provident eveniet, ea exercitationem quo!</p>
            <div class="btn btn-success" id="aboutBtn">Read More</div>
          </div>
    </div>
  </section>

  <!-- services  -->
  <section id="services">
    <div class="container">
      <div class="serviceheading">
        <h3>our services</h3>
      </div>
    </div>
    <div class="container" id="servicesCont">
        @foreach ($data as $item)
        <div class="main-cont">
            <img style="max-width: 330px;" src="{{ $item->image != null ? "storage/$item->image" : asset("asset/images/OIP.jpg") }}">
                <div class="servicesInfo">
                  <h4 style="text-transform: capitalize">{{ $item->name }}</h4>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa itaque ad fugit suscipit sequi!</p>
                  <div>
                    <div class="btn btn-success" id="servicesBtn">read me</div>
                  </div>
                </div>
        </div>

        @endforeach




        {{-- <div class="main-cont">
            <img src="{{ url("") }}/asset/images/orthodontics-g55cca20fd_640.jpg" alt="">
            <div class="servicesInfo">
                <h4>dental</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa itaque ad fugit suscipit sequi!</p>
                <div>
                <div class="btn btn-success" id="servicesBtn">read me</div>
                </div>
            </div>
        </div> --}}


      </div>
    </div>
  </section>

  <section id="footer">
    <!-- Footer -->
    <footer class="text-center text-white" style="background-color: #0a4275; ">
      <!-- Grid container -->
      <div class="container p-4 pb-0">
        <!-- Section: CTA -->
        <section class="">
          <p class="d-flex justify-content-center align-items-center" id="footerInfo">
            <span class="me-3" id="footerText" style=" font-family: 'Josefin Sans', sans-serif;">Book for Free</span>
            <a href='doctorsView.php' class="btn btn-outline-light btn-rounded" style="font-family: 'Playfair Display', serif;">
              Book an Appointment
            </a>
          </p>
        </section>
        <!-- Section: CTA -->
      </div>
      <!-- Grid container -->

      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2020 Copyright:
        <a class="text-white" style=" font-family: 'Josefin Sans', sans-serif;">Mabruuk</a>
        <div class="d-flex justify-content-center">
          <a class="text-white" href="/mabruuk1/real/views/admin/login.php" style=" font-family: 'Josefin Sans', sans-serif;">Admin</a>
          /
          <a class="text-white" href="/mabruuk1/real/views/doctor/login.php" style=" font-family: 'Josefin Sans', sans-serif;">Doctor</a>
        </div>
      </div>
      <!-- Copyright -->
    </footer>
    <!-- Footer -->
  </section>

    <script src="{{ url("") }}/asset/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
      document.querySelector(".navbar-toggler").addEventListener('click',function(){
        document.querySelector(".navbar").classList.toggle("bg-dark")
      })

          
    </script>
  </body>
</html>

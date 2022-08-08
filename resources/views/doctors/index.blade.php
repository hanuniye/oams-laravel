@extends('layout')

@section('content')

<div class="modal" tabindex="-1" id="doctrorModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
            </div>
            <div class="modal-body">

              @if (auth()->user()->role == "admin")
                    <form id="form" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                        </div>

                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        </div>

                        <div class="mb-3">
                            <label for="Password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                        </div>

                        <div class="mb-3">
                            <label for="Password" class="form-label">Age</label>
                            <input type="text" class="form-control" id="age" name="age" placeholder="Age">
                        </div>

                        <div class="mb-3">
                            <label for="Phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Contacts">
                        </div>


                        <div class="mb-3">
                            <label for="Specialization" class="form-label">Specialization</label>
                            <select class="form-control" id="specialist" name="specialist">

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="Expreince" class="form-label">Expreince</label>
                            <input type="text" class="form-control" id="expreince" name="expreince" placeholder="Expreince">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <div class="grid-cont">
                            <div class="show-image">
                                <img src="" class="image" alt="">
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
              
                @else

              <form id="form" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                </div>

                <div class="mb-3">
                    <label for="Password" class="form-label">Age</label>
                    <input type="text" class="form-control" id="age" name="age" placeholder="Age">
                </div>

                <div class="mb-3">
                    <label for="Phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="contact" name="contact" placeholder="Contacts">
                </div>


                <div class="mb-3">
                    <label for="Specialization" class="form-label">Specialization</label>
                    <select class="form-control" id="specialist" name="specialist">

                    </select>
                </div>

                <div class="mb-3">
                    <label for="Expreince" class="form-label">Expreince</label>
                    <input type="text" class="form-control" id="expreince" name="expreince" placeholder="Expreince">
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <div class="grid-cont">
                    <div class="show-image">
                        <img src="" class="image" alt="">
                    </div>
                </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
              @endif

        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content:space-between;align-items:center;">
        <i class="fa-solid fa-plus text-primary" id="addbtn" style="font-size: 25px; cursor: pointer;"></i>
        <h6 class="m-0 font-weight-bold text-primary">Doctors</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Phone</th>
                        <th>Specailization</th>
                        <th>Expreince</th>
                        <th>Image</th>
                        <th>DOCreate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $.get('specialization/get')
    .done(data =>{
        console.log(data);
        let info = "<option>..select..</option>";

        data.forEach(item =>{
            info += `<option value="${item.id}">${item.name}</option>`
        })
        $("#specialist").html(info)
    })
    .fail(data =>{
        console.log(data);
    })

    let updateBtn = "add";
        let updateId;

        @if (auth()->user()->role == "admin")
            $("#addbtn").click(function(){
                $("#doctrorModal").modal("toggle")
                $("form")[0].reset();
                updateBtn = "add"
                $(".image").attr("src", "");
            })
        @endif

        let placeImage = document.querySelector(".image")
        let File = document.querySelector("#image")
        let reader = new FileReader();

        File.addEventListener("change",function(){
            let getData = File.files[0];
            reader.readAsDataURL(getData);

            reader.addEventListener("load",function(){
                    placeImage.src = reader.result
            })
        })

       @if (auth()->user()->role == "admin")

       $("#form").submit(function(e){
            e.preventDefault()

            let formField = new FormData(this);
            let url = "";

            if(updateBtn == "add"){
                url = "doctor/create"
            }
            else{
                url = `doctor/update/${updateId}`
            }

            $.ajax({
                url:url,
                data:formField,
                method:"post",
                processData:false,
                contentType:false,

                success:function(data){
                    $("#form")[0].reset()
                    $("#doctorModal").modal("toggle");

                    if(data.status == true){
                        iziToast.success({
                            title: 'success',
                            message: data.massege,
                            position:"topCenter"
                        });

                    }
                    setTimeout(() => {
                        location.reload()
                    }, 1000);
                },
                error:function(data){
                    console.log(data);
                }
            })

        })

       @else

       $("#form").submit(function(e){
            e.preventDefault()

            let formField = new FormData(this);

            $.ajax({
                url:`doctor/update/${updateId}`,
                data:formField,
                method:"post",
                processData:false,
                contentType:false,

                success:function(data){
                    $("#form")[0].reset()
                    $("#doctorModal").modal("toggle");

                    if(data.status == true){
                        iziToast.success({
                            title: 'success',
                            message: data.massege,
                            position:"topCenter"
                        });

                    }
                    setTimeout(() => {
                        location.reload()
                    }, 1000);
                },
                error:function(data){
                    console.log(data);
                }
            })

        })

       @endif

      $(document).ready(function(){
            $('.table').DataTable({
                ajax:{
                    url:"doctor/get",
                    dataSrc:""
                },
                columns:[
                    {data:"id"},
                    {data:"name"},
                    {data:"email"},
                    {data:"age"},
                    {data:"contact"},
                    {data:"specialist_id"},
                    {data:"exprience"},
                    {data:"image"},
                    {data:"created_at"},
                    {data:"action"},
                ]
            });
        })



        function getUser(id){
            console.log(id);
            updateBtn = "update"
            $("#doctrorModal").modal("toggle")
            updateId = id;

            $.get(`doctor/get/${id}`)
            .done(data =>{
                $("#name").val(data.name)
                $("#email").val(data.email)
                $("#age").val(data.age)
                $("#contact").val(data.contact)
                $("#specialist").val(data.specialist_id)
                $("#expreince").val(data.exprience)
                $("#password").val(data.password)
                $(".image").attr("src", `storage/${data.image }`)
            })
            .fail(data =>{
                console.log(data);
            })
        }

       @if(auth()->user()->role == "admin"){
         function deleteUser(id){
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this info!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.get(`doctor/delete/${id}`)
                    .done(data =>{
                        location.reload()
                    })
                    .fail(data => {
                        console.log(data);
                    })
                    swal("Seccessfuly has been deleted!", {
                    icon: "success",
                    });
                } else {
                    swal("Your info is safe!");
                }
                });

        }
       }
       @endif
</script>

@endsection

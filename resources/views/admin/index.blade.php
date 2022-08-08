@extends('layout')

@section('content')

<div class="modal" tabindex="-1" id="adminModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
            </div>
            <div class="modal-body">

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
                        <label for="Phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="contact" name="contact" placeholder="Contacts">
                    </div>

                    <div class="mb-3">
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password">
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
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content:space-between;align-items:center;">
        <i class="fa-solid fa-plus text-primary" id="addbtn" style="font-size: 25px; cursor: pointer;"></i>
        <h6 class="m-0 font-weight-bold text-primary">Admin profile</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
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
    let updateBtn = "add";
        let updateId;

        $("#addbtn").click(function(){
            $("#adminModal").modal("toggle")
            $("form")[0].reset();
            updateBtn = "add"
            $(".image").attr("src", "");
        })

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

        $("#form").submit(function(e){
            e.preventDefault()

            let formField = new FormData(this);
            let url = "";

            if(updateBtn == "add"){
                url = "admin/create"
            }
            else{
                url = `admin/update/${updateId}`
            }

            $.ajax({
                url:url,
                data:formField,
                method:"post",
                processData:false,
                contentType:false,

                success:function(data){
                    $("#form")[0].reset()
                    $("#adminModal").modal("toggle");

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

        $(document).ready(function(){

            $.get("admin/get")
            .done(data =>{
                // let info = "";
                // data.forEach(data =>{
                //     info += `<tr>
                //             <td>${data.id}</td>
                //             <td>${data.name}</td>
                //             <td>${data.email}</td>
                //             <td>${data.contact}</td>
                //             <td><img src="storage/${data.image}" style="max-width:70px;"></td>
                //             <td>${data.created_at}</td>
                //             <td><button class="btn btn-primary">Edit</button></td>
                //             <td><button class="btn btn-danger">Delete</button></td>
                //         </tr>`
                // })
                // $("tbody").html(info)
                $('.table').DataTable({
                    ajax:{
                        url:"admin/get",
                        dataSrc:""
                    },
                    columns:[
                        {data:"id"},
                        {data:"name"},
                        {data:"email"},
                        {data:"contact"},
                        {data:"image"},
                        {data:"created_at"},
                        {data:"action"},
                    ]
                });
            })
            .fail(data =>{
                console.log(data);
            })
        })

        function getUser(id){
            updateBtn = "update"
            $("#adminModal").modal("toggle")
            updateId = id;

            $.get(`admin/get/${id}`)
            .done(data =>{
                $("#name").val(data.name)
                $("#email").val(data.email)
                $("#contact").val(data.contact)
                $("#password").val(data.password)
                $(".image").attr("src", `storage/${data.image }`)
            })
            .fail(data =>{
                console.log(data);
            })
        }

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
                    $.get(`admin/delete/${id}`)
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

</script>

@endsection

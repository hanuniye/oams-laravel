@extends('layout')

@section('content')

<style>
    span{
        color: white;
    }
</style>

<div class="modal" tabindex="-1" id="pateintModal">
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
                        <label for="Fullname" class="form-label">Fullname</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Username">
                    </div>

                    <div class="mb-3">
                        <label for="Password" class="form-label">Age</label>
                        <input type="text" class="form-control" id="age" name="age"
                            placeholder="Age">
                    </div>

                    <div class="mb-3">
                        <label for="Phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="contact" name="contact" placeholder="Contacts">
                    </div>


                    <div class="mb-3">
                        <label for="Specialization" class="form-label">Specialization</label>
                        <select class="form-control" id="specialist" name="specialist" >

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Doctor" class="form-label">Doctor</label>
                        <select class="form-control" id="doctor" name="doctor_id" >
                            <option>..select..</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Gender" class="form-label">Gender</label>
                        <select class="form-control" id="gender" name="gender" >
                            <option>..select..</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Birth_date</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date">
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
                <label for="Gender" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="booked">booked</option>
                    <option value="confirmed">in-proces</option>
                    <option value="denied">cencel</option>
                </select>
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
        <h6 class="m-0 font-weight-bold text-primary">Pateints</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Age</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Birth_date</th>
                        <th>Doctor</th>
                        <th>Status</th>
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

    // get specialist
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

    // get doctors with specialist
    $("#specialist").change(function(){
        let id = $(this).val();

        $.get(`pateint/getDoctor/${id}`)
        .done(data =>{
            let info = ""

            data.forEach(item =>{
                info += `<option value="${item.id}">${item.name}</option>`
            })
            $("#doctor").html(info)
        })
        .fail(data =>{
            console.log(data);
        })
    })


    let updateBtn = "add";
        let updateId;
    @if (auth()->user()->role == "admin")
        $("#addbtn").click(function(){
            $("#pateintModal").modal("toggle")
            $("form")[0].reset();
            updateBtn = "add"
            $(".image").attr("src", "");
        })
    @endif

        $("#form").submit(function(e){
            e.preventDefault()

            let formField = new FormData(this);
            let url = "";

            if(updateBtn == "add"){
                url = "pateint/create"
            }
            else{
                url = `pateint/update/${updateId}`
            }

            $.ajax({
                url:url,
                data:formField,
                method:"post",
                processData:false,
                contentType:false,

                success:function(data){
                    $("#form")[0].reset()
                    $("#pateintModal").modal("toggle");

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
                $('.table').DataTable({
                    ajax:{
                        url:"pateint/get",
                        dataSrc:""
                    },
                    columns:[
                        {data:"id"},
                        {data:"fullname"},
                        {data:"name"},
                        {data:"age"},
                        {data:"contact"},
                        {data:"gender"},
                        {data:"birth_date"},
                        {data:"doctor_name"},
                        {data:"status"},
                        {data:"created_at"},
                        {data:"action"},
                    ]
                });
        })

    @if(auth()->user()->role == "admin")
        function getUser(id){
            updateBtn = "update"
            $("#pateintModal").modal("toggle")
            updateId = id;

            $.get(`pateint/get/${id}`)
            .done(data =>{
                console.log(data);
                $("#name").val(data.name)
                $("#fullname").val(data.fullname)
                $("#gender").val(data.gender)
                $("#age").val(data.age)
                $("#contact").val(data.contact)
                $("#doctor").val(data.doctor_id)
                $("#birth_date").val(data.birth_date)
                $("#password").val(data.password)
                $("#status").val(data.status)
                $("#specialist").val(data.specialist)

                $("#doctor").html(`<option value='${data.doctor_id}'>${data.doctor_name}</option>`)
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
                    $.get(`pateint/delete/${id}`)
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

        @else
        function getUser(id){
            updateBtn = "update"
            $("#pateintModal").modal("toggle")
            updateId = id;

            $.get(`pateint/get/${id}`)
            .done(data =>{
                $("#status").val(data.status)
            })
            .fail(data =>{
                console.log(data);
            })
        }

        @endif


</script>

@endsection



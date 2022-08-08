@extends('layout')

@section('content')

<style>
    span{
        color: white;
    }
</style>

<div class="modal" tabindex="-1" id="scheduleModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
            </div>
            <div class="modal-body">
                <form id="form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="Day" class="form-label">Day</label>
                        <select class="form-control" id="day" name="day">
                            <option>..select..</option>
                            <option value="saturday">saturday</option>
                            <option value="sunday">sunday</option>
                            <option value="monday">monday</option>
                            <option value="tuesday">tuesday</option>
                            <option value="wednesday">wednesday</option>
                            <option value="thrusday">thrusday</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Start_time" class="form-label">Start_time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" placeholder="start_time">
                    </div>

                    <div class="mb-3">
                        <label for="End_time" class="form-label">End_time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" placeholder="start_time">
                    </div>

                    <div class="mb-3">
                        <label for="Doctor" class="form-label">Doctor</label>
                        <select class="form-control" id="doctor" name="doctor_id" >
                    </select>
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
        <h6 class="m-0 font-weight-bold text-primary">Schedule</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Day</th>
                        <th>Start_time</th>
                        <th>End_time</th>
                        <th>Doctor</th>
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

    // get doctors
        $.get(`doctor/get`)
        .done(data =>{
            let info = "<option>..select..</option>"
            data.forEach(item =>{
                info += `<option value="${item.id}">${item.name}</option>`
            })
            $("#doctor").html(info)
        })
        .fail(data =>{
            console.log(data);
        })


        let updateBtn = "add";
        let updateId;
        
        $("#addbtn").click(function(){
            $("#scheduleModal").modal("toggle")
            $("form")[0].reset();
            updateBtn = "add"
        })

        $("#form").submit(function(e){
            e.preventDefault()

            let url = "";

            if(updateBtn == "add"){
                url = "schedule/create"
            }
            else{
                url = `schedule/update/${updateId}`
            }

            $.post(url,$(this).serialize())

            .done(data =>{
                    $("#form")[0].reset()
                    $("#scheduleModal").modal("toggle");

                    if(data.status == true){
                        iziToast.success({
                            title: 'success',
                            message: data.data,
                            position:"topCenter"
                        });

                    }
                    setTimeout(() => {
                        location.reload()
                    }, 1000);
            })

            .fail(data =>{
                console.log(data);
            })

        })


        $(document).ready(function(){

                $('.table').DataTable({
                    ajax:{
                        url:"schedule/get",
                        dataSrc:""
                    },
                    columns:[
                        {data:"id"},
                        {data:"day"},
                        {data:"start_time"},
                        {data:"end_time"},
                        {data:"doctor_id"},
                        {data:"action"},
                    ]
                });
        })

        function getUser(id){
            updateBtn = "update"
            $("#scheduleModal").modal("toggle")
            updateId = id;

            $.get(`schedule/get/${id}`)

            .done(data =>{
                console.log(data);
                $("#day").val(data.day)
                $("#start_time").val(data.start_time)
                $("#end_time").val(data.end_time)
                $("#doctor").val(data.doctor_id)

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
                    $.get(`schedule/delete/${id}`)
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



@extends('layout')

@section('content')

<style>
    span{
        color: white;
    }
    .comment{
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">View Appointment Details</h5>
        </div>
        <div class="modal-body" style="padding:10px 20px">

        <div class="alert alert-success d-none" id="alert" role="alert">
            Data Inserted Successfuly!
        </div>



            <form id="viewForm">
            <div class="patient-info" style="text-align:center;">

            </div>
             <input type="hidden" id="user_id" value="">
         </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        </div>
        </form>
        </div>
    </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Eddit Appointment</h5>
        </div>
        <div class="modal-body">

            <form id="statusForm">
                @csrf
            <div class="mb-3">
                <label for="" class="form-label">Patient come into hospital</label>
                <select  class="form-control" id="status" name="status">
                    <option selected>..select..</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
             </div>

</div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        </div>
        </form>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content:space-between;align-items:center;">
        <h6 class="m-0 font-weight-bold text-primary">Appointments</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Doctor_Name</th>
                        <th>Specialist</th>
                        <th>Patient_Name</th>
                        <th>Contact</th>
                        <th>Appoint_Date</th>
                        <th>Appoint_Time</th>
                        <th>DO_Create</th>
                        <th>Status</th>
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
    
    let pateintId;
    $(document).ready(() =>{
        $(".table").DataTable({
            ajax:{
                url:"appointment/get",
                dataSrc:""
            },
            columns:[
                {data:"appointId"},
                {data:"doctor_name"},
                {data:"specialist"},
                {data:"pateint_name"},
                {data:"contact"},
                {data:"date"},
                {data:"time"},
                {data:"created_at"},
                {data:"appointstatus"},
                {data:"action"},
        ]
        })
    })

    function updateStatus(id){
        $("#statusModal").modal("toggle")
        pateintId = id;
    }

    $("#statusForm").submit(function(e){
        e.preventDefault();

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });


        if($("#status").val() === "yes"){
            $.post(`reception/updateStatus/${pateintId}`,{status:"in-process",type:"yes"})
            .done(data =>{
                $("#statusModal").modal("toggle")
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
        }
        if($("#status").val() === "no"){
            $.post(`reception/updateStatus/${pateintId}`,{status:"booked",type:"no"})
            .done(data =>{
                $("#statusModal").modal("toggle")
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
        }
        if($("#status").val() !== "no" && $("#status").val() !== "yes"){
            $("#statusModal").modal("toggle")
        }

    })
        


    function deleteUser(id){
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will delete this appointment!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.get(`appointment/delete/${id}`)
                .done(data =>{
                    location.reload()
                })
                .fail(data =>{
                    console.log(data);
                })
                swal("Poof! Your imaginary file has been deleted!", {
                icon: "success",
                });
            } else {
                swal("Your info. is safe!");
            }
        });

    }

    function view(id){
        pateintId = id;
        $("#viewModal").modal("toggle")
        $.get(`appointment/view/${id}`)
        .done(data =>{
            console.log(data);

            let info = `
                <div style="padding: 5px; display:block; border-bottom:1px solid #000;">
                    <h4>Appointment details</h4>
                </div>
                <div style="padding: 7px; display:block; border-bottom:1px solid #000;">
                <p  style="margin:0; padding:0;"><strong>Doctor_name:</strong>&nbsp &nbsp ${data.doctor_name}</p>
                </div>
                <div style="padding: 7px; ; display:block; border-bottom:1px solid #000;">
                <p style="margin:0; padding:0;"><strong>Specialist:</strong>&nbsp &nbsp${data.specialist}</p>
                </div>
                <div style="padding: 7px; ; display:block; border-bottom:1px solid #000;">
                <p  style="margin:0; padding:0;"><strong>Patient_name:</strong>&nbsp &nbsp${data.pateint_name}</p>
                </div>
                <div style="padding: 7px; ; display:block; border-bottom:1px solid #000;">
                <p  style="margin:0; padding:0;"><strong>Patient_contact:</strong>&nbsp &nbsp${data.contact}</p>
                </div>
                <div style="padding: 7px; ; display:block; border-bottom:1px solid #000;">
                <p  style="margin:0; padding:0;"><strong>Appointment_date:</strong>&nbsp &nbsp${data.date}</p>
                </div>
                <div style="padding: 7px; ; display:block; border-bottom:1px solid #000;">
                <p  style="margin:0; padding:0;"><strong>Appointment_time:</strong>&nbsp &nbsp${data.time}</p>
                </div>
                <div style="padding: 5px; ; display:block; border-bottom:1px solid #000;">
                <p  style="margin:0; padding:0;"><strong>Reason for appoint:</strong>&nbsp &nbsp${data.reason}</p>
                </div>
                <div style="padding: 5px; ; display:block; border-bottom:1px solid #000;">
                <p  style="margin:0; padding:0;"><strong>appointment status:</strong>&nbsp &nbsp${data.status}</p>
                </div>
                <div style="padding: 5px; ; display:block; border-bottom:1px solid #000;">
                <p  style="margin:0; padding:0;"><strong>pateint come into hospital:</strong>&nbsp &nbsp${data.type}</p>
                </div>
                <div class='comment' style="padding: 5px; ;  border-bottom:1px solid #000;">
                   <Strong>Doctor Comment:</Strong>  &nbsp &nbsp<textarea  id="comment" cols="15" rows="5"></textarea>
                </div>`
                $(".patient-info").html(info)

                if(data.status === "in-process"){
                    $(".modal .comment").show()
                }else{
                    $(".modal .comment").hide()
                }

        })
        .fail(data =>{
            console.log(data);
        })
    }

    $("#viewForm").submit(function(e){
        e.preventDefault();
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        let comment = $("#comment").val();

        if(comment){
            $.post(`updateStatus/${pateintId}`,{status:"completed"})
            .done(data =>{
                $("#viewModal").modal("toggle")
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
        }
        else{
            $("#viewModal").modal("toggle")
        }

    })

</script>

@endsection



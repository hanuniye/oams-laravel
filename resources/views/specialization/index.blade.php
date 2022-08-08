@extends('layout')

@section('content')

<div class="modal" tabindex="-1" id="specialModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
            </div>
            <div class="modal-body">

                <form id="form" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="" class="form-label">Specialization Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Specialization Name">
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
        <h6 class="m-0 font-weight-bold text-primary">Specialization</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
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
            $("#specialModal").modal("toggle")
            $("form")[0].reset();
            updateBtn = "add"
            $(".image").attr("src", '')
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
            let formField = new FormData(this)
            let url = "";

            if(updateBtn == "add"){
                url = "specialization/create"
            }
            else{
                url = `specialization/update/${updateId}`
            }

            $.ajax({
                url:url,
                data:formField,
                method:"post",
                processData:false,
                contentType:false,

                success:function(data){
                    $("#form")[0].reset()
                    $("#specailModal").modal("toggle");

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
                        url:"specialization/get",
                        dataSrc:""
                    },
                    columns:[
                        {data:"id"},
                        {data:"name"},
                        {data:"image"},
                        {data:"created_at"},
                        {data:"action"},
                    ]
                });
        })


        function edits(id){
            updateBtn = "update"
            $("#specialModal").modal("toggle")
            updateId = id;

            $.get(`specialization/get/${id}`)
            .done(data =>{
                $("#name").val(data.name)
                $(".image").attr("src",`storage/${data.image}`)
            })
            .fail(data =>{
                console.log(data);
            })
        }

        function deletes(id){
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this info!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.get(`specialization/delete/${id}`)
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

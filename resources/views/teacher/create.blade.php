<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- csrf token --}}
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
</head>


<body>
     <div style="padding: 30px">
        <div class="container">
            <h2 style="color: red;"> <marquee behavior="" direction=""> Laravel 8 Ajax Crud Application -- W3 Coders </marquee></h2>
            <div class="row">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            All Teachers List
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Institute</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>1</td>
                                        <td>Test Name</td>
                                        <td>Test Title</td>
                                        <td>Test Institute</td>
                                        <td>Test Action </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4" >
                    <div class="card">
                        <div class="card-header">
                            <span id="addT">Add New Teacher </span>
                            <span id="updateT">Update Teacher</span>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" placeholder="Enter Name" id="name" class="form-control"/>
                                <span class="text-danger" id="nameError"></span>
                            </div>
                            <div class="form-group">
                                <label>Title </label>
                                <input type="text" placeholder="Enter Title" id="title" class="form-control">
                                <span class="text-danger" id="titleError"></span>
                            </div>
                            <div class="form-group">
                                <label>Institute </label>
                                <input type="text" placeholder="Enter Institute" id="institute" class="form-control">
                                <span class="text-danger" id="instituteError"></span>
                            </div>
                            <input type="hidden" id="id">
                            <div>
                                <button type="submit" class="btn btn-primary" onclick="addData()" id="addButton"> Add </button>
                                <button type="submit" class="btn btn-success" onclick="updateData()" id="updateButton"> Update </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
     </div>
  
     <script>
         $('#addT').show();
         $('#updateT').hide();
         $('#addButton').show();
         $('#updateButton').hide();

         $.ajaxSetup({
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         })

         function allData(){
             $.ajax({
                 type:"GET",
                 dataType:'json',
                 url:"{{route('teachers.index')}}",
                 success:function(response){
                    
                    var data = "";
                    $.each(response,function(key,value){
                        data += "<tr>"
                        data +="<td>"+ value.id + "</td>"
                        data +="<td>"+ value.name + "</td>"
                        data +="<td>"+ value.title + "</td>"
                        data +="<td>"+ value.institute + "</td>"
                        data +="<td>"+ "<button class='btn btn-sm btn-primary mr-2' onclick='editData("+value.id+")'>Edit</button>" 
                        data += "<button class='btn btn-sm btn-danger mr-2'>Delete</button>" +"</td>"
                        data += "</tr>";
                    })
                    $('tbody').html(data)
                 }
             })
         }
         allData();
         function clearData(){
            $('#name').val('');
            $('#title').val('');
            $('#institute').val('');
            $('#nameError').text('');
            $('#titleError').text('');
            $('#instituteError').text('');
         }
         function addData(){
            var name = $('#name').val();
            var title = $('#title').val();
            var institute = $('#institute').val();
            $.ajax({
                type:"POST",
                dataType:"json",
                data:{
                    name:name,
                    title:title,
                    institute:institute
                },
                url:"{{route('teachers.store')}}",
                success:function(data){
                    clearData();
                    allData();

                    console.log("Successfully Data is Added!");
                },

                error(error){
                    $('#nameError').text('');
                    $('#titleError').text('');
                    $('#instituteError').text('');
                    if($('#name').val() == ""){
                        $('#nameError').text(error.responseJSON.errors.name);
                    }
                    if($('#title').val() == ""){
                        $('#titleError').text(error.responseJSON.errors.title);
                    }
                    if($('#institute').val() == ""){
                        $('#instituteError').text(error.responseJSON.errors.institute);
                    }
                   
                    
                    
                }
            })
         }

         function editData(id){
             
             $.ajax({
                 type:"GET",
                 dataType:"json",
                 url:"/teachers/"+id + "/edit",
                 success :function(data){
                     $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#title').val(data.title);
                    $('#institute').val(data.institute);
                    $('#addButton').hide();
                    $('#updateButton').show();
                    $('#updateT').show();
                    $('#addT').hide();
                 }
             })
         }

         function updateData(){
             var id = $('#id').val();
             var name = $('#name').val();
             var title = $('#title').val();
             var institute = $('#institute').val();
             let _token   = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                 type:"PUT",
                 dataType:"json",
                 data:{_token:_token ,name:name,title:title,institute:institute},
                 url:"/teachers/"+id , 
                 success:function(response){
                     clearData();
                     allData();
                     $('#addT').show();
                        $('#updateT').hide();
                        $('#addButton').show();
                        $('#updateButton').hide();
                     console.log(response)
                 },
                 error:function(error){
                     console.log(error)
                 }
             })
         }

       
     </script>
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/bootstrap.js')}}"></script>
        <script src="{{asset('js/popper.js')}}"></script>
        <script src="{{asset('js/jqajax.js')}}"></script>
</body>
</html>

{{-- https://codingdriver.com/laravel-ajax-crud-example-tutorial-from-scratch.html --}}
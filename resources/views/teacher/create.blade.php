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
                            </div>
                            <div class="form-group">
                                <label>Title </label>
                                <input type="text" placeholder="Enter Title" id="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Institute </label>
                                <input type="text" placeholder="Enter Institute" id="institute" class="form-control">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary" onclick="addData()" id="addButton"> Add </button>
                                <button type="submit" class="btn btn-success" id="updateButton"> Update </button>
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
                        data +="<td>"+ "<button class='btn btn-sm btn-primary mr-2'>Edit</button>" 
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